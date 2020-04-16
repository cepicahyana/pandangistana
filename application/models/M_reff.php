<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_reff extends ci_Model
{
	
	public function __construct() {
        parent::__construct();
     	}
		function acak($jml=2)
		{
			$karakter = '123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789';
			$shuffle  = substr(str_shuffle($karakter),0,$jml);
			return $shuffle;
		}
		 function tm_pengaturan($id)
	{
		$return=$this->db->get_where("tm_pengaturan",array("id"=>$id))->row();
		return isset($return->val)?($return->val):"";
	}
	  function qr($id)
	 {
		 if($id){
				$this->load->library('ciqrcode');
				$params['data'] = $id;
				$params['level'] = 'H';
				$params['size'] = 10;
				$params['savename'] = FCPATH.'qr/'.$id.".png";
		return	$this->ciqrcode->generate($params);
		 }
	 }	function clearkoma($data)
	{
    	if(substr($data,0,1)==",")
		{
			$data=substr($data,1);
		}
		
		if(substr($data,-1)==",")
		{
			$data=substr($data,0,-1);
		}
		
		
		$data=str_replace(",,",",",$data);
		return $data;
	}function clearkomaray($data)
	{
		 
		$data=$this->clearkoma($data);
		return explode(",",$data);
	}
     function getColor($blok)
	 {
		  $data=$this->db->query("SELECT * from tr_blok where  id='".$blok."' ")->row();
		return isset($data->color)?($data->color):"";
	 }
	function goField($tbl,$select,$where=null)
	{
	    $data=$this->db->query("SELECT $select from $tbl $where ")->row();
		return isset($data->$select)?($data->$select):"";
	}
	
	function goResult($tbl,$select,$where=null)
	{
	   return $data=$this->db->query("SELECT $select from $tbl $where ");  
	}
	 function jk($id)
	 {
	     if($id=="l")
	     {
	         return "Laki-laki";
	     }elseif($id=="p")
	     {
	         return "Perempuan";
	     }
	 }
	 
	function tgl_pergantian()
	{
		$data=$this->db->get_where("tr_tahun_ajaran",array("sts"=>1))->row();
		return isset($data->tgl_pindah)?($data->tgl_pindah):"";
	}		
	 
	function zipz($nama_file,$dir,$file)
	{
             $error=true;
            /* nama zipfile yang akan dibuat */
            $zipname = $nama_file.".zip";
            /* proses membuat zip file */
            $zip = new ZipArchive;
            $zip->open($zipname, ZipArchive::CREATE);
             
          //  foreach ($file as $value) {
            $zip->addFile($dir.$file,$file);
        //    }
             $zip->close();
            /* preses pembuatan zip file selesai disini */
             
            /* download file jika eksis*/
            if(file_exists($zipname)){
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; 
            filename="'.$zipname.'"');
            header('Content-Length: ' . filesize($zipname));
            readfile($zipname);
            unlink($zipname);
             
            } else{
            $error = "Proses mengkompresi file gagal  ";
            } //end of if file_exist
            
            return $error;
            
    }
    
    function zip($zip_file,$dir,$data)
    {
            
            
            // Get real path for our folder
            $rootPath = realpath($dir);
            
            // Initialize archive object
            $zip = new ZipArchive();
            $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            
            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
            
            foreach ($files as $name => $file)
            {
                // Skip directories (they would be added automatically)
                if (!$file->isDir())
                {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) + 1);
            
                    // Add current file to archive
                   $polder=substr($relativePath,0,6);
                   if (in_array($polder, $data)) {
                       $zip->addFile($filePath, $relativePath);
                    }  
                   
                   
                   
                }
            }
            
            // Zip archive will be created only after closing object
            $zip->close();
            
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($zip_file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($zip_file));
            readfile($zip_file);

            
    }
 
	function setToken()
	{
	$code=substr(str_shuffle("123aYbCdEfGhIj0K0opqrStUvwXyZ4567809"),0,25); $this->session->set_userdata("token",$code); 
	echo '<input type="hidden" name="token" value="'.$this->session->userdata("token").'">';
	}
	function cekToken()
	{
		$token_post=$this->input->post("token");
		$token_server=$this->session->userdata("token");
	
		if($token_post==$token_server)
		{
		return true;
		}else{
		return false;
		}
		
	}
	
	function hapus_file($nama_file)
	{
		$filename = $nama_file;

		if (file_exists($filename)) {
			unlink($nama_file);
		}  
		return true;
	}
	function upload_file($form,$dok,$idu,$type_file="JPG,PNG",$sizeFile="3000000")
	{		
	$var=array();
	$var["size"]=true; 
	$var["file"]=true;
	$var["validasi"]=false; 
	
		$nama=date("YmdHis")."_".$idu."_";
		  $lokasi_file = $_FILES[$form]['tmp_name'];
		  $tipe_file   = $_FILES[$form]['type'];
		  $nama_file   = $_FILES[$form]['name'];
		   $size  	   = $_FILES[$form]['size'];
			$nama_file=str_replace(" ","_",$nama_file);
			// $jenis="jpg";
			$nama=str_replace("/","",$nama."_".$nama_file);
			 $target_path = "file_upload/".$dok."/".$nama;
			 

			  $ex=substr($nama_file,-3);
			$extention=str_replace(" ","_",strtoupper($ex));
		//  $var["type"]=$type_file; 
		  $var["maxsize"]=substr($sizeFile,0,-6); 
		  
		 $pos = strpos(strtoupper($type_file), $extention);
		 if ($pos === false) {
			$file_extention=false;
		} else {
			$file_extention=true;
		}
		 
		 
		 $maxsize =$sizeFile;
		 if($size>=$maxsize)
		 {
			$var["size"]=false; 
		 }elseif($file_extention==false){
			$var["file"]=false; $var["type_file"]=$type_file;
		 }else{
		 	$var["validasi"]=true;
			if (!empty($lokasi_file)) {
			move_uploaded_file($lokasi_file,$target_path);
			 }
			$var["name"]=$nama;
		 }
		 return $var;
	}
	
	public function kirimEmail($femail,$fsubject,$fmessage,$path=null,$namaFile=null,$delfile=null)
	{   
	    return $this->sendEmail($femail,$fsubject,$fmessage,$path,$namaFile,$delfile);
	    
	}
	
	 
	function sendEmail($femail,$fsubject,$fmessage,$path=null,$namaFile=null,$delfile=null){
	    $user=$this->tm_pengaturan(2);
		$pass=$this->tm_pengaturan(3);
		$from=$this->tm_pengaturan(4);
		$host=$this->tm_pengaturan(18);
		$port=$this->tm_pengaturan(19);
		$smptScure=$this->tm_pengaturan(20);
        $this->load->library('PHPMailer_load'); //Load Library PHPMailer
        $mail = $this->phpmailer_load->load(); // Mendefinisikan Variabel Mail
       
       
        $mail->setFrom($from, $fsubject); // Sumber email
        $mail->addAddress($femail,$fsubject); // Masukkan alamat email dari variabel $email
        $mail->Subject = $fsubject; // Subjek Email
        $mail->msgHtml($fmessage); // Isi email dengan format HTML
        $mail->isHTML(true);
     	if(file_exists($path)){
          $mail->addAttachment($path,$namaFile);
     	}  
        $mail->CharSet  = "UTF-8";
        $mail->Host 	= $host; // Host dari server SMTP
        $mail->isSMTP();  // Mengirim menggunakan protokol SMTP
        $mail->Port 	= $port;
        $mail->SMTPAuth = true; // Autentikasi SMTP
        $mail->Username = $user;
        $mail->Password = $pass;
        $mail->SMTPSecure = $smptScure;
         $mail->SMTPOptions      = array(
                                        ''.$smptScure.'' => array(
                                            'verify_peer' => false,
                                            'verify_peer_name' => false,
                                            'allow_self_signed' => true
                                        )
                                    );
       
        
        if (!$mail->send()) {
                    $var["sts"]="Mailer Error: " . $mail->ErrorInfo;
                  
                } else {
                   $var["sts"]="ok";
                    if($path && file_exists($path) && $delfile){
                        unlink($path);
                    }
                }  
                 
                  return $var;
    }

     function kirimWa($phone,$msg,$dok=null)
     {
            if($dok){
                $link  =  $this->tm_pengaturan(13);
                $data = [
                'phone' => $phone,
                'caption' => $msg,
                'document' =>$dok,
            ];
            }else{
                $link  =  $this->tm_pengaturan(6);
                $data = [
                'phone' => $phone,
                'message' => $msg,
                ];
            }
            
            $curl = curl_init();
            $token =  $this->tm_pengaturan(5);
          
            
            
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                )
            );
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); 
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl); 
            return $result;
    
     }
     
      function kirimSms($phone,$msg)
     {
            
            $curl = curl_init();
            $token =  $this->tm_pengaturan(12);
            $link  =  $this->tm_pengaturan(11);
             $data = [
                'phone' => $phone,
                'message' => $msg,
                ];
            
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl); 
            return $result;
    
     }
	
}

?>