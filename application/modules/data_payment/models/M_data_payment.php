<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_payment extends ci_Model
{
	
	public function __construct() {
        parent::__construct();
		//$this->m_konfig->validasi_session("super");
     	}
	function get_open()
	{
		
		$query=$this->_get_datatables_open();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	function get_transfer()
	{
		
		$query=$this->_get_datatables_transfer();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	function saldo()
	{
	$id=$this->session->userdata("id");
	$this->db->where("id_admin",$id);
	$data=$this->db->get("admin")->row();
	return $data->saldo;
	}
	function dataInvoice()
	{
	$dt="select * from data_invoice LEFT JOIN data_event ON data_invoice.id_data_event=data_event.id_event
	where  data_invoice.status='belum'";
	return $this->db->query($dt)->result();
	}
	private function _get_datatables_open()
	{
	$query="select *,data_invoice.id_admin as id_admin,data_invoice.status as status from data_invoice LEFT JOIN data_payment ON data_invoice.id_invoice=data_payment.id_invoice ";
	
		
		if(isset($_POST['search']['value'])){
		$searchkey=$_POST['search']['value'];
			$query.=" AND (
			data_invoice.status LIKE '%".$searchkey."%' OR 
			nomor_invoice LIKE '%".$searchkey."%'
			) ";
		}

		$column = array('data_invoice.id_invoice'); //no order by
		$i=0;
		foreach ($column as $item) 
		{
		$column[$i] = $item;
		}
		
		$query.="order by data_invoice.id_invoice DESC";
		return $query;
	
	}	
	private function _get_datatables_transfer()
	{
	$query="select *,data_payment.status as status,data_payment.`id_admin` AS id_admin from data_payment LEFT JOIN tm_bank ON data_payment.id_bank=tm_bank.id_bank LEFT JOIN data_invoice ON data_invoice.id_invoice=data_payment.id_invoice";
	
		
		if(isset($_POST['search']['value'])){
		$searchkey=$_POST['search']['value'];
			$query.=" AND (
			nomor_invoice LIKE '%".$searchkey."%' OR 
			nama_bank LIKE '%".$searchkey."%' OR
			data_payment.tgl LIKE '%".$searchkey."%'
			) ";
		}

		$column = array('data_payment.tgl'); //no order by
		$i=0;
		foreach ($column as $item) 
		{
		$column[$i] = $item;
		}
		
		$query.="order by data_payment.tgl DESC";
		return $query;
	
	}
	function saveKonfirm()
	{
	$data=array(
	"id_admin"=>$this->session->userdata("id"),
	"id_bank"=>$bank=$this->input->post("bank"),
	"id_invoice"=>$this->input->post("invoice"),
	"tujuan"=>$this->input->post("tujuan"),
	"nominal"=>$this->input->post("tujuan"),
	"ket"=>$this->input->post("ket"),
	);
	$this->db->insert("data_payment",$data);
	return $this->_update_status_invoice($this->input->post("invoice"),$bank);
	}
	
	function _update_status_invoice($id,$bank)
	{
	$data=array(
	"status"=>"proses",
	"id_bank"=>$bank,
	);
	$this->db->where("id_invoice",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	return $this->db->update("data_invoice",$data);
	}
	
	function delform($id)
	{
	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_invoice",$id);
	return $this->db->delete("data_invoice");
	}
	
	public function count_file($tabel)
	{		
		
		$this->db->from($tabel);
		return $this->db->count_all_results();
	}
	function count_filtered($tabel)
	{
		
		$this->db->from($tabel);
		$query=$this->_get_datatables_open();
		return $this->db->query($query)->num_rows();
	}
	public function count_file_transfer($tabel)
	{		
		
		$this->db->from($tabel);
		return $this->db->count_all_results();
	}
	function count_filtered_transfer($tabel)
	{
		
		$this->db->from($tabel);
		$query=$this->_get_datatables_transfer();
		return $this->db->query($query)->num_rows();
	}
	function addform()
	{
	$pil=$this->input->get("pilih");
	$pil=substr($pil,0,-1);
	$data=array(
	"id_admin"=>$this->session->userdata("id"),
	"nama_form"=>$this->input->get("nama"),
	"type_form"=>$this->input->get("type"),
	"required"=>$this->input->get("required"),
	"pilihan"=>str_replace("undefined,","",$pil),
	);
	return $this->db->insert("data_invoice",$data);
	}
	
	private function _gettampung()
	{
	$this->db->order_by("id_invoice","ASC");
	return $this->db->get("data_invoice")->result();
	}
	
	function incDataForm()
	{
	$data=$this->db->query("SHOW TABLE STATUS LIKE 'data_form'")->row();
	return $data->Auto_increment;
	}
	function finishadd()
	{
	$t=$this->_gettampung();
		foreach($t as $val)
		{
			$array=array(
			"id_admin"=>$this->session->userdata("id"),
			"nama_form"=>$val->nama_form,
			"id_data_form"=>$this->incDataForm(),
			"type_form"=>$val->type_form,
			"required"=>$val->required,
			"pilihan"=>$val->pilihan,
			);
		$this->db->insert("tm_formulir",$array);
		////
		$this->db->where("id_invoice",$val->id_invoice);
		$this->db->delete("data_invoice");
		}
		$array=array(
			"id_admin"=>$this->session->userdata("id"),
			"nama_form"=>$this->input->post('nama'),
			"tgl"=>date('Y-m-d'),
			);
	return	$this->db->insert("data_form",$array);
	}
	function deleteForm($id)
	{
	$this->db->where("id_invoice",$id);
	$this->db->delete("data_form");
	////
	$this->db->where("id_data_form",$id);
	$this->db->delete("tm_formulir");
	}
}

?>