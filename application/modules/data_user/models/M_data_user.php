<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_user extends ci_Model
{
	
	public function __construct() {
        parent::__construct();
		//$this->m_konfig->validasi_session("super");
     	}

	function hapus_UG($id)
	{
	$this->db->where("id_level",$id);
	return $this->db->delete("main_level");
	}
	
	function cekChatId($id)
	{
	$this->db->where("status","0");
	$this->db->where("id_admin=",$id);
	return $this->db->get("data_chat")->num_rows();
	}	
	
	private function _cekDel($id)
	{
	$this->db->where("id_admin!=",$this->session->userdata('id'));
	$this->db->where("id_admin",$id);
	return $this->db->get("admin")->num_rows();
	}
	
	public function deleted_UG($id)
	{
	$daprof=$this->dataProfile($id);
	$path = "file_upload/dp/".$daprof->poto;
	
	$cekiddel=$this->_cekDel($id);	
	if($cekiddel){			 
				 if (file_exists($path)) {
					unlink($path);
				 }
	};			 
	
	$this->db->where("id_admin!=",$this->session->userdata('id'));
	$this->db->where("id_admin",$id);
	$data=$this->db->delete("admin");
	}
	
		
	

	
	function dataProfileLevel($id)
	{
	return $this->db->get_where("main_level",array("id_level"=>$id))->row();
	}
	function dataProfile($id)
	{
	return $this->db->get_where("admin",array("id_admin"=>$id))->row();
	}
	




	///-----------------------------------ajax//
	private function _get_datatables_open()
	{
	$query="select *,b.nama as namaGroup from admin a,main_level b where a.level=b.id_level ";
	
	
		$query.="AND a.level='3' ";
		
	
		if($_POST['search']['value']){
		$searchkey=$_POST['search']['value'];
			$query.=" AND (
			b.nama LIKE '%".$searchkey."%' or 
			nama LIKE '%".$searchkey."%' or 
			telp LIKE '%".$searchkey."%' or 
			email LIKE '%".$searchkey."%' or
			alamat LIKE '%".$searchkey."%'
			) ";
		}

		$column = array('','poto','nama','telp','email','namaGroup','alamat');
		$i=0;
		foreach ($column as $item) 
		{
		$column[$i] = $item;
		}
		
		if(isset($_POST['order']))
		{
		//	$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			$query.=" order by ".$column[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir'] ;
		} 
		else if(isset($order))
		{
			$order = $order;
		//	$this->db->order_by(key($order), $order[key($order)]);
			$query.=" order by ".key($order)." ".$order[key($order)] ;
		}
		return $query;
	
	}
	
	function get_open()
	{
		
		$query=$this->_get_datatables_open();
		if($_POST['length'] != -1)
		//$this->db->limit($_POST['length'], $_POST['start']);
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		//if($keyword=$this->uri->segment(3)){ $this->db->like('TextDecoded',$keyword);};
		
		//$query = $this->db->get();
		return $this->db->query($query)->result();
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
	function getDataUser($id) //id_file
	{
	$this->db->where("id_admin",$id);
	$this->db->join("main_level b","a.level=b.id_level");
	$this->db->from("admin a");
	return $this->db->get()->row();
	}
	///////-----------------------------------------------------
	private function folderhapus($folderhapus) {
		$files = glob($folderhapus.'/*'); // Ambil semua file yang ada dalam folder
		foreach($files as $file){ // Lakukan perulangan dari file yang kita ambil
		  if(is_file($file)) // Cek apakah file tersebut benar-benar ada
			unlink($file); // Jika ada, hapus file tersebut
		}
		rmdir($folderhapus);
	}
	
	function deleted_Event($id)
	{
	$this->db->where("id_admin",$id);
	$dt=$this->db->get("data_event")->result();
	 foreach($dt as $dt){
	 $path = "file_upload/form/".$id."_".$dt->id_event;
	 $this->folderhapus($path);
	}
	
	
	$this->db->where("id_admin",$id);
	return $this->db->delete("data_event");
	}
	function dataChat($id)
	{
	$this->updateStatusChat($id);
	$this->db->order_by("id_chat","ASC");
	return $dataChat=$this->db->get_where("data_chat",array("focus"=>$id))->result();
	}
	//------------------------------------------------------------------------------------------->
	function dataChatMax($id)
	{
	$this->db->order_by("id_chat","DESC");
	return $dataChat=$this->db->get_where("data_chat",array("focus"=>$id))->row();
	}
	
	 function updateStatusChat($id)
	{
	$array=array(
	"status"=>"1",
	);
	$this->db->where("id_admin",$id);
	$this->db->where("focus",$id);
	return $this->db->update("data_chat",$array);
	}
	function sendChat($chat,$id)
	{

	$array=array(
	"id_admin"=>$this->session->userdata("id"),
	"focus"=>$id,
	"chat"=>$chat,
	"date"=>date('Y-m-d H:i:s'),
	);
	return $this->db->insert("data_chat",$array);
	}
	
	//------------------------------------------------------------------------------------------->
	
	function deleted_Peserta($id)
	{
	$this->db->where("id_admin",$id);
	return $this->db->delete("data_peserta");
	}
	function deleted_Chat($id)
	{
	$this->db->where("id_admin",$id);
	return $this->db->delete("data_chat");
	}function deleted_Form($id)
	{
	$this->db->where("id_admin",$id);
	return $this->db->delete("data_form");
	}function deleted_Invoice($id)
	{
	$this->db->where("id_admin",$id);
	return $this->db->delete("data_invoice");
	}function deleted_Payment($id)
	{
	$this->db->where("id_admin",$id);
	return $this->db->delete("data_payment");
	}function deleted_tampungForm($id)
	{
	$this->db->where("id_admin",$id);
	return $this->db->delete("tampung_form");
	}function deleted_Formulir($id)
	{
	$this->db->where("id_admin",$id);
	return $this->db->delete("tm_formulir");
	}
	
}

?>