<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_event extends ci_Model
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
	
	function jmlPeserta($id)
	{
	$ids=$this->session->userdata("id");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_event",$id);
	$this->db->where("status","2");
	return $this->db->get("data_peserta")->num_rows();
	}

	private function _get_datatables_open()
	{
	$query="select * from data_event where ";
		
		if(isset($_POST['search']['value'])){
		$searchkey=$_POST['search']['value'];
			$query.=" (
			title LIKE '%".$searchkey."%' 			
			) ";
		}

		$column = array('title'); //no order by
		$i=0;
		foreach ($column as $item) 
		{
		$column[$i] = $item;
		}
		
		$query.="order by id_event DESC";
		return $query;
	
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
	/*--------------------------------------------------------------------------------------*/
	private function _dataPeserta($idEvent,$idAdmin)
	{
	$this->db->where("id_admin",$idAdmin);
	$this->db->where("id_event",$idEvent);
	return $this->db->delete("data_peserta");
	}
	private function folderhapus($folderhapus) {
		$files = glob($folderhapus.'/*'); // Ambil semua file yang ada dalam folder
		foreach($files as $file){ // Lakukan perulangan dari file yang kita ambil
		  if(is_file($file)) // Cek apakah file tersebut benar-benar ada
			unlink($file); // Jika ada, hapus file tersebut
		}
		rmdir($folderhapus);
	}
	
	function delete($idEvent,$idAdmin)
	{
	
	$path = "file_upload/form/".$idAdmin."_".$idEvent;
				 
	$this->folderhapus($path);
	
	$this->_dataPeserta($idEvent,$idAdmin);
	$this->db->where("id_admin",$idAdmin);
	$this->db->where("id_event",$idEvent);
	return $this->db->delete("data_event");
	}
	
}
	


?>