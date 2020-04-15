<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
	 	$this->load->library('email');
		date_default_timezone_set("Asia/Jakarta");		
	}
 
	
	 
	
	function config1()
	{
		$config = Array(
		'protocol' => 'smtp',
    	'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => "uarmoure@gmail.com",
		'smtp_pass' => "cipanandur",
		'mailtype'  => 'html',
		'charset'   => 'iso-8859-1'
		);
		 
	    	$this->load->library('email', $config);
        	$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
            $this->email->set_header('Content-type', 'text/html');
	}
 
	function kirimEmail()
	{       $email      =   $this->input->get_post("email");
        	$subject    =   $this->input->get_post("subject");
        	$isi        =   $this->input->get_post("isi");
	        $to         =   $email; 
            $this->_kirim_email($isi,$to,$subject);
            echo "oke";
       
    }
    	private function _kirim_email($isi,$to,$subject)
	{
		 
		$this->config1();
		$this->email->set_newline("\r\n");
		$mail = $this->email;
		$mail->from("no-replay@divisionit.co.id","$subject");
		$mail->to($to); 
		 
		$mail->subject($subject);
		$mail->message($isi);	
	
   if($this->email->send())
   {
	return true;
   }else
   {
	return false;
   }
		 
	return	$mail->send();
		 
	}
    function isiEMail($data)
    {
        
        $nik         =   $data->nik;
        $nama        =   $data->nama;
        $email       =   $data->email;
        $lembaga     =   $data->lembaga;
      
        $blok_pagi  =   $this->mdl->dispon_pagi($nik);
        $blok_sore  =   $this->mdl->dispon_sore($nik);
         
         
       
        
    return    $isi='
    <table style="max-width:400px" cellpadding=0 cellspacing=0>
    <tr>
    <td colspan="2" style="background-color:#EEE">
    <img src="'.base_url().'plug/img/banner1.JPG" width="100%"   alt="E-receipt"
    style="border-top-left-radius:15px;border-top-right-radius:15px" class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 1; left: 745px; top: 101px;"><div id=":rt" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Download lampiran " data-tooltip-class="a1V" data-tooltip="Download"><div class="aSK J-J5-Ji aYr"></div></div></div>
     <center>
     <span style="font-size:16"><b> PERMOHONAN UNDANGAN HUT-RI 75</b></span>
     <hr width="90%">
     </center>
      </td>
    </tr>
    <tr>
    <td align="left" valign="top" style="background-color:#EEE;padding:10px">

     <span style="font-size:11px;color:#9e9e9e;line-height:16px">Nama Pemohon :</span><br>
      <span style="font-size:13px;line-height:16px;;color:black"><b>'.$nama.'</b></span> <br>
      
      <span style="font-size:11px;color:#9e9e9e;line-height:16px">NIK :</span><br>
      <span style="font-size:13px;line-height:16px;;color:black"><b>'.$nik.'</b></span> <br>
      
      <span style="font-size:11px;color:#9e9e9e;line-height:16px">Email :</span><br>
      <span style="font-size:13px;line-height:16px;;color:black"> '.$email.' </span> <br>
      
      <span style="font-size:11px;color:#9e9e9e;line-height:16px">Lembaga / instansi:</span><br>
      <span style="font-size:13px;line-height:16px;color:black"><b>'.$lembaga.'</b></span> <br>
       
      
      
     <br>
        <b style="font-size:12px;;color:teal;"> PERMOHONAN UNDANGAN</b><br>
      
      <span style="font-size:13px;line-height:16px; color:black">Undangan Pagi : '.$blok_pagi.'</span> <br> 
    
      <span style="font-size:13px;line-height:16px; color:black">Undangan Sore : '.$blok_sore.'</span> <br>
     
     
    </td>  
    </tr>
    <tr>
    <td   style="background-color:#EEE;padding:10px">
    
      
        <span style="font-size:13px;color:black;line-height:16px">Permohonan anda sedang kami proses, untuk informasi jadwal 
        pengambilan dan jumlah undangan yang diperoleh akan kami informasikan kembali melalui email,sms dan whatsapp.   </span><br>
    </td>
    </tr>
    </table>
    
    
    ';
        
    }
	
	
	
	
	
	
	
	
	

}
