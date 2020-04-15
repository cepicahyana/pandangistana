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
	
	 
	function set()
	{
		$sts=$this->input->post("sts");
		$id=$this->input->post("id");
		if($sts==0){ $sts=1;}else{ $sts=0;}
		$this->db->set("sts",$sts);
		$this->db->where("id",$id);
		return $this->db->update($this->tbl);
	}
	 
	 function get_data()
	{
		$query=$this->_get_data();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	function _get_data()
	{
		 $level		=	$this->input->get_post("level");
		 
		 
		$query="select * from admin where level='".$level."'   ";
			if($_POST['search']['value']){
			$searchkey=$_POST['search']['value'];
				$query.=" AND (
				nama LIKE '%".$searchkey."%'   
				) ";
			}

		$column = array('', 'owner'  );
		$i=0;
		foreach ($column as $item) 
		{
		$column[$i] = $item;
		}
		
		if(isset($_POST['order']))
		{
		$query.=" order by owner   asc";
		} 
		else if(isset($order))
		{
			$order = $order;
			$query.=" order by ".key($order)." ".$order[key($order)] ;
		}
		return $query;
	}
	
	public function count()
	{				
		$query = $this->_get_data();
        return  $this->db->query($query)->num_rows();
	}
	function insert($level)
	{	
	$user=$this->input->post("f[username]");
	$pass=$this->input->post("password");
	 $cek=$this->db->get_where("admin",array("username"=>$user,"password"=>md5($pass)))->num_rows();
	 if(!$cek){
		$post=$this->input->post("f");
		$post=$this->security->xss_clean($post);
		$pass=$this->input->post("password");
		$this->db->set("level",$level);
		$this->db->set("password",md5($pass));
	 
	 	return $this->db->insert($this->tbl,$post);
	 }else{
		$var["upass"]=false;
	 return $var;
	 }
	}
	function update()
	{
	 
	$user=$this->input->post("f[username]");
	$pass=$this->input->post("password");
	 $cek=$this->db->get_where("admin",array("username"=>$user,"password"=>md5($pass),"id_admin!="=>$this->input->post("id")))->num_rows();
	 if(!$cek){
		$post=$this->input->post("f");
		$post=$this->security->xss_clean($post);
		$pass=$this->input->post("password");
		if($pass){
		$this->db->set("password",md5($pass));
		}
		$this->db->where("id_admin",$this->input->post("id"));
	 	return $this->db->update($this->tbl,$post);
	 }else{
		$var["upass"]=false;
	 return $var;
	 }
	}
	function hapus($id)
	{
		 
		$this->db->where("id_admin",$id);
		return $this->db->delete("admin");
	}
	
	 
	 
	 
	 
}