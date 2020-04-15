<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->load->model('m_dashboard','mdl');
		$this->m_konfig->validasi_session(array("user")); 
	}
	 
	 
	function _template($data)
	{
	$this->load->view('temp_user/main',$data);	
	}
	
	function getDetail()
	{
	$this->load->view('getDetail');	
	}
	 	
	function mappingWilayah()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("wilayah");
		}else{
			$data['konten']="wilayah";
			$this->_template($data);
		}	
	}function jadwal_distribusi()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("jadwal_distribusi");
		}else{
			$data['konten']="jadwal_distribusi";
			$this->_template($data);
		}	
	}
	 
	 
}

