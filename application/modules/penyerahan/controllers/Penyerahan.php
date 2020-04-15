<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penyerahan extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("user","distributor"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	function setPenerima()
	{
	    echo $this->mdl->setPenerima();
	}function setPenerimaPersus()
	{
	    echo $this->mdl->setPenerimaPersus();
	}
		function setTanggalTerima()
	{
	    echo $this->mdl->setTanggalTerima();
	}
	function _template($data)
	{
		
		$level=$this->session->userdata("level");
		if($level=="user"){
			$this->load->view('temp_user/main',$data);	
		}else{
			$this->load->view('temp_verifikator/main',$data);	
		}
	}
	function setKode()
	{
		$id		=	$this->input->post("id");
		$ke		=	$this->input->post("ke");
		$idblok	=	$this->input->post("idblok");
		$kode	=	$this->input->post("kode");
		$cek	=	$this->db->query("select * from data_peserta where (barcode1='".$kode."' or barcode2='".$kode."') ")->num_rows();
		if($cek){
		echo "false";
		return false;
		}
		
		if($idblok!=substr($kode,0,2))
		{
			echo "wrong";
			return false;
		}
		
		$this->db->where("id",$id);
		 
		if($ke==1)
		{
			$this->db->set("barcode1",$kode);
		}else{
			$this->db->set("barcode2",$kode);
		}
		
		return $this->db->update("data_peserta");
		//return $this->m_reff->qr($kode);
	}
	
	function getData()
	{
		 echo	$this->load->view("getData");
	}function getDataPersus()
	{
		 echo	$this->load->view("getDataPersus");
	}
	  public function index()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("index");
		}else{
			$data['konten']="index";
			$this->_template($data);
		}
		
	}    public function persus()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("persus");
		}else{
			$data['konten']="persus";
			$this->_template($data);
		}
		
	}  
}