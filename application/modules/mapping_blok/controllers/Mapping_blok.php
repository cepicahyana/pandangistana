<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapping_blok extends CI_Controller {

	  
	function __construct()
	{
		parent::__construct();	
		$this->load->model('model','mdl');
		$this->m_konfig->validasi_session(array("user","registrasi"));
		
		date_default_timezone_set("Asia/Jakarta");
	}
	 
	
	function _template($data)
	{
	$this->load->view('temp_user/main',$data);	
	}
	 	
	function form_filter()
	{
	$this->load->view('form_filter');	
	}
	 
	public function index(){
		 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("index");
		}else{
			$data['konten']="index";
			$this->_template($data);
		}
		 
	}

	public function detail(){
		$this->db->where("nama", $_POST["blok"]);
 		$this->db->where("jenis", $_POST["jenis"]);
 		$d = $this->db->get("v_blok")->row_array();

 		$data["d"] = $d;
		echo $this->load->view("detail", $data);
	}

	function updateTarget(){
		echo $this->mdl->updateTarget();
	}
}

