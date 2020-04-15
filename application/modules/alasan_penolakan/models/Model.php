<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends ci_Model
{
	 
	public function __construct() {
    parent::__construct();
	 	 
 	}

 	function insert(){
 		$f = $_POST["f"];

 		return $this->db->insert("tm_alasan_penolakan", $f);
 	}

 	function update(){
 		$f = $_POST["f"];
 		$id = $_POST["id"];

 		$this->db->where("id", $id);
 		return $this->db->update("tm_alasan_penolakan", $f);
 	}

 	function delete(){
 		$id = $_POST["id"];

 		$this->db->where("id", $id);
 		return $this->db->delete("tm_alasan_penolakan");
 	}

 	function get_data()
	{
		
		$query=$this->_get_datatables();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	private function _get_datatables()
	{	$filter		=	"";
	
		
		$query="select * from tm_alasan_penolakan where 1=1 ".$filter;
	
		if($_POST['search']['value']){
			$searchkey=$_POST['search']['value'];
				$query.=" AND (
					alasan LIKE '%".$searchkey."%'
				) ";
			}

		
		$query.= "order by alasan asc";
		return $query;
	
	}
	
	public function count_file($tabel)
	{		
		
		$q=$this->_get_datatables();
		return $this->db->query($q)->num_rows();
	}

}

?>