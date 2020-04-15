<?php

class Model extends CI_Model  {
    
	var $tbl="admin";
 
 	function __construct()
    {
        parent::__construct();
    }
	function idu()
	{
		return $this->session->userdata("id");
	}
	
	 
	function save_($idp,$val)
	{
		$this->db->set("val",$val);
		$this->db->where("id",$idp);
	return $this->db->update("tm_pengaturan");
	}
	
	 
	 
	 
	 
}