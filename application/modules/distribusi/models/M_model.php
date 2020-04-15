<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_model extends ci_Model
{
	 
	public function __construct() {
        parent::__construct();
		 
		 
     	}
		
		function get_peserta()
	{
		
		$query=$this->_get_datatables_peserta();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	private function _get_datatables_peserta()
	{	$filter		=	"";
	
		$jenis_acara	=	$this->input->get_post("jenis_acara");
		$dispo			=	$this->input->get_post("dispo");
		$distri			=	$this->input->get_post("distri");
		$prov			=	$this->input->get_post("prov");
		$kab			=	$this->input->get_post("kab");
		
		if($jenis_acara){
			 
			$filter.=" AND (jenis_acara='".$jenis_acara."' or jenis_acara=3) ";
		}
		if($dispo==1){
			$filter.=" AND (blok1 IS NOT NULL or blok2 IS NOT NULL) ";
		}elseif($dispo==2){
			$filter.=" AND (blok1 IS NULL and blok2 IS NULL) ";
		}
		if($distri==1){
			$filter.=" AND diterima_oleh IS NOT NULL ";
		}elseif($distri==2){
			$filter.=" AND diterima_oleh IS NULL ";
		}
		if($prov){
			$filter.=" AND substr(nik,1,2)='".$prov."' ";
		}
		if($kab){
			$filter.=" AND substr(nik,1,4)='".$kab."' ";
		}
		
		$query="select * from data_peserta where id_kategory='1' and sts_acc=2 and jadwal_distribusi is null and sts_verifikasi=2  ".$filter;
	
		if($_POST['search']['value']){
			$searchkey=$_POST['search']['value'];
				$query.=" AND (
				nama LIKE '%".$searchkey."%'  or
				nik LIKE '%".$searchkey."%'  or
				hp LIKE '%".$searchkey."%'  or
				email LIKE '%".$searchkey."%'  or
				lembaga LIKE '%".$searchkey."%'  or 
				ket LIKE '%".$searchkey."%'  
				) ";
			}
		
		$waktu=$this->input->post("waktu");
	 	if($waktu){
			$query.=" AND jenis='".$waktu."' ";
		}
		$gate=$this->input->post("gate");
	 	if($gate){
			$query.=" AND gate='".$gate."' ";
		}
		$cetak=$this->input->post("cetak");
	 	if($cetak){
			$query.=" AND cetak='".$cetak."' ";
		} 
		$nama_file=$this->input->post("nama_file");
	 	if($nama_file){
			$query.=" AND nama_file='".$nama_file."' ";
		} 
		
		$status=$this->input->post("status");
		if($status!=null){
			$query.=" AND status='".$status."' ";
		}
		
		$blok=$this->input->post("blok");
		if($blok){
			$query.=" AND blok='".$blok."' ";
		}
		
		$pic=$this->input->post("pic");
		if($pic){
			$query.=" AND pic='".$pic."' ";
		}
		
		$lembaga=$this->input->post("lembaga");
		if($lembaga){
			$query.=" AND lembaga='".$lembaga."' ";
		}
		$cadangan=$this->input->post("cadangan");
		if($cadangan==1){
			$query.=" AND kode_registrasi LIKE '%bebas%' ";
		}elseif($cadangan==2)
		{
			$query.=" AND kode_registrasi NOT LIKE '%bebas%' ";
		} 
		
		
		
		$no_surat=$this->input->post("no_surat");
		if($no_surat){
			$danon="";
			foreach($no_surat as $non)
			{
				$danon.="'".$non."',";
			}
			$danon=substr($danon,0,-1);
			$query.=" AND no_surat in(".$danon.")";
		}
		
		if($_POST['search']['value']){
			$searchkey=$_POST['search']['value'];
				$query.=" AND (
				nama LIKE '%".$searchkey."%'  or
				nik LIKE '%".$searchkey."%'  or
				hp LIKE '%".$searchkey."%'  or
				email LIKE '%".$searchkey."%'  or
				lembaga LIKE '%".$searchkey."%'  or 
				ket LIKE '%".$searchkey."%'  
				) ";
			}

	 
			$query.="group by id asc" ;
		return $query;
	
	}
	
	public function count_file_peserta($tabel)
	{		
		
		$q=$this->_get_datatables_peserta();
		return $this->db->query($q)->num_rows();
	}
	 
	
	/*--------------------------------------------------*/
	function get_persus()
	{
		
		$query=$this->_get_datatables_persus();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	private function _get_datatables_persus()
	{	$filter		=	"";
	
		$jenis_permohonan	=	$this->input->get_post("jenis_permohonan");
		$dispo				=	$this->input->get_post("dispo");
		$distri				=	$this->input->get_post("distri");
		 
		if($jenis_permohonan){
			 
			$filter.=" AND jenis_permohonan='".$jenis_permohonan."'  ";
		}
		if($dispo){
			$filter.=" AND sts_dispo='".$dispo."' ";
		}
		
		if($distri==1){
			$filter.=" AND diterima_oleh IS NOT NULL ";
		}elseif($distri==2){
			$filter.=" AND diterima_oleh IS NULL ";
		} 
		 
		
		$query="select * from data_persus where 1=1  ".$filter;
	
		if($_POST['search']['value']){
			$searchkey=$_POST['search']['value'];
				$query.=" AND (
				nama LIKE '%".$searchkey."%'  or
				nik LIKE '%".$searchkey."%'  or
				hp LIKE '%".$searchkey."%'  or
				email LIKE '%".$searchkey."%'  or
				lembaga LIKE '%".$searchkey."%'  or 
				ket LIKE '%".$searchkey."%'  
				) ";
			}
		
		$waktu=$this->input->post("waktu");
	 	if($waktu){
			$query.=" AND jenis='".$waktu."' ";
		}
		$gate=$this->input->post("gate");
	 	if($gate){
			$query.=" AND gate='".$gate."' ";
		}
		$cetak=$this->input->post("cetak");
	 	if($cetak){
			$query.=" AND cetak='".$cetak."' ";
		} 
		$nama_file=$this->input->post("nama_file");
	 	if($nama_file){
			$query.=" AND nama_file='".$nama_file."' ";
		} 
		
		$status=$this->input->post("status");
		if($status!=null){
			$query.=" AND status='".$status."' ";
		}
		
		$blok=$this->input->post("blok");
		if($blok){
			$query.=" AND blok='".$blok."' ";
		}
		
		$pic=$this->input->post("pic");
		if($pic){
			$query.=" AND pic='".$pic."' ";
		}
		
		$lembaga=$this->input->post("lembaga");
		if($lembaga){
			$query.=" AND lembaga='".$lembaga."' ";
		}
		$cadangan=$this->input->post("cadangan");
		if($cadangan==1){
			$query.=" AND kode_registrasi LIKE '%bebas%' ";
		}elseif($cadangan==2)
		{
			$query.=" AND kode_registrasi NOT LIKE '%bebas%' ";
		} 
		
		
		
		$no_surat=$this->input->post("no_surat");
		if($no_surat){
			$danon="";
			foreach($no_surat as $non)
			{
				$danon.="'".$non."',";
			}
			$danon=substr($danon,0,-1);
			$query.=" AND no_surat in(".$danon.")";
		}
		
		if($_POST['search']['value']){
			$searchkey=$_POST['search']['value'];
				$query.=" AND (
				nama LIKE '%".$searchkey."%'  or
				nik LIKE '%".$searchkey."%'  or
				hp LIKE '%".$searchkey."%'  or
				email LIKE '%".$searchkey."%'  or
				lembaga LIKE '%".$searchkey."%'  or 
				ket LIKE '%".$searchkey."%'  
				) ";
			}

	 
			$query.="group by id asc" ;
		return $query;
	
	}
	
	public function count_file_persus($tabel)
	{		
		
		$q=$this->_get_datatables_persus();
		return $this->db->query($q)->num_rows();
	}
	 
	
	 
	function idu()
	{
		$this->session->userdata("id");
	}
	
	 
	function jmlDistribusi($tgl)
	{
		$this->db->where("diterima_tgl",null);
		$this->db->where("jadwal_distribusi",$tgl);
		return $this->db->get("data_peserta")->num_rows();
	}
	function setDistribusi()
	{
		$id				=	$this->input->get_post("id");//id
		$tgl			=	$this->input->get_post("tgl");
		$tgl			=	explode(",",$tgl);
		$tgl			=	trim($tgl[1]);
		$tgl			=	$this->tanggal->eng_($tgl,"-");
		$id_pemohon		=	$this->m_reff->clearkomaray($id); 
		return $this->kirimEmail($tgl,$id_pemohon);
	}
	function kirimEmail($tgl,$id_pemohon)
	{	 $var["ok"]=0;
		 $var["gagal"]=0;
		 $var["dgagal"]="";
		 $id     =   $this->input->get_post("id"); 
         $data   =   $this->m_reff->clearkomaray($id);
		 $ok=0;$gagal=0;$dgagal="";
        foreach($id_pemohon as $val)
        {    
                        $this->db->where("id",$val);
                        $this->db->where("sts_acc",2);
                        $this->db->where("jadwal_distribusi IS NULL");
                        $this->db->where("diterima_oleh IS NULL"); 
            $data    =  $this->db->get("data_peserta")->row();
        if($data){   
            
            $to     =   $data->email; 
            $isi    =   $this->isiEMail($data,$tgl);
            $subject=   "Bukti Pengambilan Undangan"; 
            
            $phone  =   $data->hp;
            $path   =   $this->mdl->genUndangan($data,$tgl); 
            $isiWa  =   $this->isiWa($data,$tgl); 
                        $this->m_reff->kirimWa($phone,$isiWa);
                        $this->m_reff->kirimWa($phone,"Bukti Pengambilan Undangan",base_url().$path);
            $isiSms =   $this->isiSms($tgl);
                        $this->m_reff->kirimSms($phone,$isiSms);
			$sts    =   $this->m_reff->kirimEmail($to,$subject,$isi,$path,"Bukti Pengambilan Undangan HUT RI-75","delete");   
    		
			if($sts["sts"]=="ok"){
				$this->db->set("sts_notif",1);
				$this->db->set("sts_acc",2);
				$this->db->set("jadwal_distribusi",$tgl);
				$this->db->where("diterima_tgl",null);
				$this->db->where("email",$data->email);
				$this->db->update("data_peserta");
				$ok++;
			}else{
				$gagal++;
				$dgagal.=$data->email."<br>";
			}
			
			
        }//end if	
			
        }
		 $var["ok"]=$ok;
		 $var["gagal"]=$gagal;
		 $var["dgagal"]=$dgagal;
		return $var;
	}
		function genUndangan($data,$tgl)
	{
		ob_start();
		$phone  =   $data->hp;
		//include('file.html');
	    $data_v["val"]=$data;
	    $data_v["tgl"]=$tgl;
		$isi=$this->load->view('genUndangan',$data_v); 
		
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
		 $html2pdf = new HTML2PDF('P',array("110","190"), 'en', true, '', array(0,0,0,0));
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
	//  $html2pdf->AddFont('monotypecorsiva', 'bold', 'monotypecorsiva.php'); 
		 $html2pdf->Output('file_upload/'.$phone.'.pdf', 'F');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
	    
       return "file_upload/".$phone.".pdf";
	}
	 
	 function isiEMail($data,$tgl)
    {
        
        $nik         =   $data->nik;
		$this->m_reff->qr($nik);
        $nama        =   $data->nama;
        $email       =   $data->email;
        $lembaga     =   $data->lembaga;
        $tgl_ambil   =   $this->tanggal->hariLengkap($tgl,"/");
        $this->m_reff->qr($nik);
        
        $blok_pagi  =   $data->blok1;
        $blok_sore  =   $data->blok2;
		$blok_pagi_="";
		$blok_sore_="";
		
		if($blok_pagi)
		{
			$blok_pagi_='<span style="font-size:13px;line-height:16px; color:black">Acara Penaikan Bendera : Blok '.$this->m_reff->goField("tr_blok","nama","where id='".$blok_pagi."'").'</span> <br> ';
		}
		if($blok_sore)
		{
			$blok_sore_='<span style="font-size:13px;line-height:16px; color:black">Acara Penurunan Bendera : Blok '.$this->m_reff->goField("tr_blok","nama","where id='".$blok_pagi."'").'</span> <br>';
		}
        
    return    $isi='
    <table style="max-width:400px" cellpadding=0 cellspacing=0>
    <tr>
    <td colspan="2" style="background-color:#EEE;">
    <img  style="border-top-left-radius:15px;border-top-right-radius:15px" src="'.base_url().'plug/img/banner2.JPG" width="100%"   alt="E-receipt"  class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 1; left: 745px; top: 101px;"><div id=":rt" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Download lampiran " data-tooltip-class="a1V" data-tooltip="Download"><div class="aSK J-J5-Ji aYr"></div></div></div>
     <center>
     <span style="font-size:16"><b> BUKTI PENGAMBILAN UNDANGAN<br> HUT RI-75</b></span>
     <hr width="90%">
     </center>
      </td>
    </tr>
    <tr>
    <td align="left" valign="top" style="background-color:#EEE;padding:10px"> 
     <span style="font-size:11px;color:#9e9e9e;line-height:16px">Nama Pemohon :</span><br>
      <span style="font-size:13px;line-height:16px;font-weight:bold;color:black">'.$nama.'</span> <br>
      
      <span style="font-size:11px;color:#9e9e9e;line-height:16px">NIK / nomor identitas :</span><br>
      <span style="font-size:13px;line-height:16px;font-weight:bold;color:black">'.$nik.'</span> <br>
      
   
     <br>
        <b style="font-size:12px;font-weight:bold;color:teal;"> PEROLEHAN UNDANGAN</b><br>
      
      '.$blok_pagi_.'
      '.$blok_sore_.'
    
      
     
     
    </td> <td style="background-color:#EEE"> 
                 
                 <img src="'.base_url().'qr/'.$nik.'.png" width="110px"><br>
                
    </td>
    </tr>
    <tr>
    <td colspan="2"  style="background-color:#EEE;padding:10px"> 
   <div>  <b style="font-size:12px;font-weight:bold;color:teal;"> INFORMASI PENGAMBILAN UNDANGAN</b><br> 
     <span style="font-size:13px;color:black;line-height:16px"> - Undangan dapat diambil pada :<br>hari   '.$tgl_ambil.' pukul 08.30 - 16.00 WIB </span><br>
      <span style="font-size:13px;color:black;line-height:16px">Alamat  :   Kantor Sekretariat Negara <br>
      Jl. Veteran No.17-18, RT.2/RW.3, Gambir, Kecamatan Gambir, Kota Jakarta Pusat.
      </span><br>
    <span style="font-size:13px;color:black;line-height:16px"> - Membawa KTP Asli atau tanda pengenal yang didaftarkan. </span><br>
        <span style="font-size:13px;color:black;line-height:16px"> - Menunjukan email ini saat pengambilan. </span><br>
        <span style="font-size:13px;color:black;line-height:16px"> - Jika Undangan tidak diambil  lebih dari 3 hari dari tanggal pengambilan maka otomatis dibatalkan. </span><br>
        
        </div>
    </td>
    </tr>
    </table>
    
    
    ';
        
    }
    
    
     function isiWa($data,$tgl)
    {
        
        $nik         =   $data->nik;
		$this->m_reff->qr($nik);
        $nama        =   $data->nama;
        $email       =   $data->email;
        $lembaga     =   $data->lembaga;
        $tgl_ambil   =   $this->tanggal->hariLengkap($tgl,"/");
        $this->m_reff->qr($nik);
        
        $blok_pagi  =   $data->blok1;
        $blok_sore  =   $data->blok2;
		$blok_pagi_="";
		$blok_sore_="";
		
		if($blok_pagi)
		{
			$blok_pagi_=' 1 Acara Penaikan Bendera : Blok '.$this->m_reff->goField("tr_blok","nama","where id='".$blok_pagi."'").'  ';
		}
		if($blok_sore)
		{
			$blok_sore_=' 1 Acara Penurunan Bendera : Blok '.$this->m_reff->goField("tr_blok","nama","where id='".$blok_pagi."'").' ';
		}
		
 
		$icon2="📍";
		$icon1="🏛";
	 
        $isi=$this->m_reff->tm_pengaturan(7);
        $isi=str_replace('{nama}',$nama,$isi);
        $isi=str_replace('{nik}',$nik,$isi);
        $isi=str_replace('{blok_pagi}',$blok_pagi_,$isi);
        $isi=str_replace('{blok_sore}',$blok_sore_,$isi);
        $isi=str_replace('{waktu_pengambilan}',$tgl_ambil,$isi); 
        $isi=str_replace('{icon2}',$icon2,$isi);
        $isi=str_replace('{icon1}',$icon1,$isi);
        return $isi;
    }
	
	
	 function isiSms($tgl_ambil)
    {   $tgl_ambil  =   $this->tanggal->hariLengkap($tgl_ambil,"/");
        $isi=$this->m_reff->tm_pengaturan(9); 
        $isi=str_replace('{waktu_pengambilan}',$tgl_ambil,$isi);  
        return $isi;
    }
	
}

?>