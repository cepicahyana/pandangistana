<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	 
	public function index()
	{
    phpinfo();
	}
 
	function register()
	{
	$cekIp=$this->_cekIp($_SERVER['REMOTE_ADDR']);
	$cekHp=$this->_cekHp($this->input->post("telp"));
	$cekEmail=$this->_cekEmail($this->input->post("email"));
		if($cekIp>0){ echo json_encode("ip"); }else{
			if($cekHp>0){	echo json_encode("hp"); }else{
				if($cekEmail>0){	echo json_encode("email"); }else{
					$save=$this->_save();
					echo "true";
				}
			}
		}
	}
	
	
	function looping()
	{
		$dt=$this->db->get("wil_kabupaten")->result();
		foreach($dt as $val)
		{
			$this->db->query("INSERT INTO `data_peserta` (`nik`, `nama`, `hp`, `email`, `jenis_acara`, `permohonan_awal`)
			VALUES ('".$val->id_kab."040801".date("His")."', 'Masyarakat ".$val->nama." ', '".$val->id_kab."2212".date("His")."', 'mail".$val->id_kab."@gmail.com', '3', '3') ");
		}
	}
	
	
}
