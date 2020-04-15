<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class On extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->model('m_reg','reg');
		date_default_timezone_set("Asia/Jakarta");		
	}
	function modalcek()
	{
	$this->load->view('modalcek');
	}function modalSorry()
	{
	$this->load->view('modalSorry');
	}function modaltutup()
	{
	$this->load->view('modaltutup');
	}function modalQuota()
	{
	$this->load->view('modalQuota');
	}
	public function index()
	{
		$this->load->view('template/main');
	}
	function line($id)
	{
	$this->load->view('registration');
	}
	function widget($id)
	{
	$this->load->view('widget');
	}
	function getWidget($id)
	{
	$data['id']=$id;
	$this->load->view('getWidget',$data);
	}
	function saveRegister($id)
	{
	echo $this->reg->saveRegister($id);
	}
	private function _returnIP($event,$ip)
	{
	$uri=$event;
	$link=substr($uri,0,5);
	$id=substr($uri,5,40);
	$this->db->where("id_admin",$id);
	$this->db->where("link",$link);
	
	$idEvent=$this->_cekIDEvent($uri);
	
		$this->db->where("id_admin",$id);
		$this->db->where("id_event",$idEvent);
		//$this->db->where("ip",$ip);
		$data=$this->db->get("data_peserta")->row();
		return isset($data->kode_registrasi)?($data->kode_registrasi):" code Error ";
		

		
	}
	private function _cekEvent($event)
	{
	$uri=$event;
	$link=substr($uri,0,5);
	$id=substr($uri,5,40);
	$this->db->where("id_admin",$id);
	$this->db->where("link",$link);
	$data=$this->db->get("data_event")->row();
	return $data->acc;
	}
	private function _tiketEvent($event)
	{
	$uri=$event;
	$link=substr($uri,0,5);
	$id=substr($uri,5,40);
	$this->db->where("id_admin",$id);
	$this->db->where("link",$link);
	$data=$this->db->get("data_event")->row();
	return $data->sistem_tiket;
	}	
	
	private function _cekIDEvent($event)
	{
	$uri=$event;
	$link=substr($uri,0,5);
	$id=substr($uri,5,40);
	$this->db->where("id_admin",$id);
	$this->db->where("link",$link);
	$data=$this->db->get("data_event")->row();
	return isset($data->id_event)?($data->id_event):"0";
	}
	
	
	function success($event,$ip)
	{
	$ip=$this->session->userdata("koreg");
	$ip=$this->_returnIP($event,$ip);

	$cekEvent=$this->_cekEvent($event);
	$tiket=$this->_tiketEvent($event);
	if($tiket==1)
	{
		$data="<h2>".$ip."</h2>";
		if($cekEvent=="1")
		{
		$data.="Event ini memerlukan persetujuan admin <br> silahkan cek status registrasi anda di menu <b>PRINT TICKET</b> dengan menyertakan <b>NOMOR REGISTRASI</b> anda.";
		}else
		{
		$data.="Silahkan cetak tiket anda di menu <b>PRINT TICKET</b><br> dengan menyertakan <b>NOMOR REGISTRASI</b> anda.";
		}
	}else
	{
	$data="Terimakasih atas partisipasi anda.";
			
	}	
	echo $data;	
	}
	private function _cekReg($noreg,$idadmin,$link)
	{
	$li=$link."".$idadmin;
	$idEvent=$this->_cekIDEvent($li);
	if($idEvent!="0")
	{
		$this->db->where("id_admin",$idadmin);
		$this->db->where("id_event",$idEvent);
		$this->db->where("kode_registrasi",$noreg);
		return $this->db->get("data_peserta")->num_rows();
	}else
	{
		return 0;
	}

	}	
	
	private function _cekRegRow($noreg,$idadmin,$link)
	{
	$li=$link."".$idadmin;
	$idEvent=$this->_cekIDEvent($li);
	if($idEvent!="0")
	{
		$this->db->where("id_admin",$idadmin);
		$this->db->where("id_event",$idEvent);
		$this->db->where("kode_registrasi",$noreg);
		return $this->db->get("data_peserta")->row();
	}else
	{
		return 0;
	}

	}
	function cek_register($event)
	{
	$uri=$event;
	$link=substr($uri,0,5);
	$idadmin=substr($uri,5,40);
		
	$noreg=$this->input->post("id");
	$cekReg=$this->_cekReg($noreg,$idadmin,$link);
	
	
	
		if(!$cekReg)
		{
		echo "Nomor Tidak Terdaftar";
		}else
		{
			$dt=$this->_cekRegRow($noreg,$idadmin,$link); $status=$dt->status;
			if($status==0) { echo "Data anda sedang kami proses <br> Silahkan cek beberapa saat lagi"; }else
			{	
				$data["dataDB"]=$dt->data;
				$data["id_admin"]=$dt->id_admin;
				$data["id_event"]=$dt->id_event;
				$this->load->view("tiket",$data);	}
		}
		


	}

}
