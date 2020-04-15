<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends ci_Model
{
	
	public function __construct() {
        parent::__construct();
		 
     	}
	 
 
	function jmlDistribusi($tgl)
	{
		$this->db->where("diterima_tgl",null);
		$this->db->where("jadwal_distribusi",$tgl);
		return $this->db->get("data_peserta")->num_rows();
	}
	
	function jmlBelumDistribusi($tgl)
	{
		$this->db->where("diterima_tgl",null);
		$this->db->where("jadwal_distribusi",$tgl);
		return $this->db->get("data_peserta")->num_rows();
	}
	function jmlSudahDistribusi($tgl)
	{	
		$this->db->where("diterima_tgl IS NOT NULL");
		$this->db->where("jadwal_distribusi",$tgl);
		return $this->db->get("data_peserta")->num_rows();
	}
	function getDistribusi($tgl,$jenis)
	{	$this->db->order_by("blok","ASC");
		$this->db->where("jenis",$jenis);
		$this->db->where("jadwal_distribusi",$tgl);
		return $this->db->get("v_distribusi")->result();
	}
}
?>