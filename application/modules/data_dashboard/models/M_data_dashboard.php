<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_dashboard extends ci_Model
{
	
	public function __construct() {
        parent::__construct();
		$this->m_konfig->validasi_session("admin");
     	}
	function cekInvoice()
	{
	$this->db->where("status","proses");
	return $this->db->get("data_invoice")->num_rows();
	}function cekKonfirmasi()
	{
	$this->db->where("status","no");
	return $this->db->get("data_payment")->num_rows();
	}
	
	function cekChat()
	{
	$this->db->where("status","0");
	$this->db->where("id_admin!=",$this->session->userdata('id'));
	return $this->db->get("data_chat")->num_rows();
	}
	function dataEvent($id)
	{
	$this->db->where("id_event",$id);
	return $this->db->get("data_event")->row();
	}	
	function jmlKolom($id)
	{
	$ids=$this->session->userdata("id");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_data_form",$id);
	return $this->db->get("tm_formulir")->num_rows();
	}
	function not($id)
	{
	$ids=$this->session->userdata("id");
	$data=array("status"=>"0");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_peserta",$id);
	return $this->db->update("data_peserta",$data);
	}
	
	function acc($id)
	{
	$ids=$this->session->userdata("id");
	$data=array("status"=>"1");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_peserta",$id);
	return $this->db->update("data_peserta",$data);
	}
	function getDataForm($id)
	{
	$ids=$this->session->userdata("id");
	$this->db->order_by("id_formulir","asc");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_data_form",$id);
	return $this->db->get("tm_formulir")->result();
	}
	function namaForm($id)
	{
	$this->db->where("id_form",$id);
	$data=$this->db->get("data_form")->row();
	return isset($data->nama_form)?($data->nama_form):"<i>form dihapus</i>";
	}
	
	function jmlPeserta($id)
	{
	
	$this->db->where("id_event",$id);
	$this->db->where("status","1");
	return $this->db->get("data_peserta")->num_rows();
	}
	
	
	private function _cekLInkEvent($acak)
	{
	
	$this->db->where("link",$acak);
	return $this->db->get("data_event")->num_rows();
	}
	
	private function _link()
	{
	$acak=substr(str_shuffle("1234567890"),0,5);
	$cek=$this->_cekLInkEvent($acak);
	if($cek)
	{
	return $acak+12;	
	}else{
	return $acak;
	}
	
	}
	

	function dataForm()
	{
	$this->db->order_by("nama_form","ASC");
	return $this->db->get("data_form")->result();
	}
	
	function get_open()
	{
		
		$query=$this->_get_datatables_open();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	
	private function _dataPeserta($id)
	{
	$this->db->where("id_event",$id);
	return $this->db->delete("data_peserta");
	}

	
}

?>