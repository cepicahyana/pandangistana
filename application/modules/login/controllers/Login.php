<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->load->model('M_login','login');
	}
	
	function _template($data)
	{
	$this->load->view('template/head',$data);
	$this->load->view('template/konten');	
	$this->load->view('template/footer');
	}
	public function logout()
	{
		$reg=$this->session->userdata("reg");
		if($reg) { $this->db->query("update data_event set mode='1' where id_event='".$reg."'"); };
	
		$this->session->sess_destroy();
		redirect("login");
	}
	public function index()
	{
	$this->m_konfig->validasi_login();
	//$data['konten']="index";
	//$this->_template($data);
	$this->load->view("index");
	}
	function captcha()
	{
	$captcha=substr(str_shuffle("123456789"),0,5); // string yg akan diacak membentuk captcha 0-z dan sebanyak 6 karakter
	$this->login->captcha($captcha);
	$gambar=ImageCreate(50,25); // ukuran kotak width=60 dan height=20
	$wk=ImageColorAllocate($gambar, 255, 255, 255); // membuat warna kotak -> Navajo White
	$wt=ImageColorAllocate($gambar, 51, 153, 153); // membuat warna tulisan -> Putih
	ImageFilledRectangle($gambar, 190, 776, 50, 120, $wk);
	ImageString($gambar, 10, 1, 3, $captcha, $wt);
	ImageJPEG($gambar);
	}
	function cekLogin()
	{
	$hasil=$this->login->cekLogin();
	echo json_encode($hasil);
	}
}

