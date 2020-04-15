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
		$fjadwal			=	$this->input->get_post("fjadwal");
		$tgl            =   date('Y-m-d');
		
		if($fjadwal==1)
		{
			$filter.=" AND jadwal_distribusi IS NULL ";
		}elseif($fjadwal==2)
		{
			$filter.=" AND jadwal_distribusi IS NOT NULL ";
		}
		
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
			$filter.=" AND (diterima_oleh IS NULL and jadwal_distribusi='".date('Y-m-d')."') ";
		}elseif($distri==3){
			$filter.=" AND (diterima_oleh IS NULL and jadwal_distribusi='".$this->tanggal->minTgl($tgl,1)."') ";
		}elseif($distri==4){
			$filter.=" AND (diterima_oleh IS NULL and jadwal_distribusi='".$this->tanggal->minTgl($tgl,2)."') ";
		}elseif($distri==5){
			$filter.=" AND (diterima_oleh IS NULL and jadwal_distribusi='".$this->tanggal->minTgl($tgl,3)."') ";
		}elseif($distri==6){
			$filter.=" AND (diterima_oleh IS NULL and jadwal_distribusi<='".$this->tanggal->minTgl($tgl,4)."') ";
		}
		
		
		
		
		if($prov){
			$filter.=" AND substr(nik,1,2)='".$prov."' ";
		}
		if($kab){
			$filter.=" AND substr(nik,1,4)='".$kab."' ";
		}
		
		$query="select * from data_peserta where id_kategory='1' and hps is null ".$filter;
	
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

		
	/*	if(isset($_POST['order']))
		{
		//	$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			$query.=" order by ".$column[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir'] ;
		} 
		else if(isset($order))
		{
			$order = $order;
		//	$this->db->order_by(key($order), $order[key($order)]);
			$query.=" order by ".key($order)." ".$order[key($order)] ;
		}*/
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

		
	/*	if(isset($_POST['order']))
		{
		//	$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			$query.=" order by ".$column[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir'] ;
		} 
		else if(isset($order))
		{
			$order = $order;
		//	$this->db->order_by(key($order), $order[key($order)]);
			$query.=" order by ".key($order)." ".$order[key($order)] ;
		}*/
			$query.="group by id asc" ;
		return $query;
	
	}
	
	public function count_file_persus($tabel)
	{		
		
		$q=$this->_get_datatables_persus();
		return $this->db->query($q)->num_rows();
	}
	 
	
	/*--------------------------------------------------*/
	function setBlokPersus()
	{
		$kode		=	$this->input->get_post("kode");
		$acara		=	$this->input->get_post("acara");
		$blok		=	$this->input->get_post("blok"); 
		$jml		=	$this->input->get_post("jml");
		
		$data		=	$this->db->query("select * from data_persus where kode='".$kode."' ")->row();
		
		$data_awal=array(
		"kode_persus"=>$data->kode,
		"email"=>$data->email,
		"nama"=>$data->nama,
		"hp"=>$data->hp,
		//"lembaga"=>$data->lembaga,
		"id_kategory"=>$data->jenis_permohonan,
		//"ket"=>$data->ket,
	///////	"jml_pagi"=>$data->jml_pagi,
	//////	"jml_sore"=>$data->jml_sore, 
	///	"sts_acc"=>$data->sts_acc,
		"_cid"=>$this->idu(),
		"_ctime"=>date('Y-m-d H:i:s'),
		); 
		
		 
		
		 if($acara==1){
		     	$this->db->query("delete from data_peserta where kode_persus='".$kode."' and jenis_acara='1'
		 and   (blok1='".$blok."' or blok1 is null or blok1='' )");
			$jblok="blok1";
		 }else{
			 $jblok="blok2"; 
		     	$this->db->query("delete from data_peserta where kode_persus='".$kode."' and jenis_acara='2'
		  and (blok2='".$blok."' or blok2 is null or blok2='' )");
		 } 
	  // $this->db->query("delete from data_peserta where kode_persus='".$blok."' and ( blok1 is null and blok2 is null ) ");
		
		for($i=1;$i<=$jml;$i++)
		{   $nik	=	$this->m_reff->acak("16");
			$this->db->set($jblok,$blok);
			$this->db->set($data_awal);
			$this->db->set("nik",$nik);
			$this->db->set("jenis_acara",$acara); 
			$this->db->set("_cid",$this->idu());
			$this->db->set("_ctime",date('Y-m-d H:i:s'));
			$this->db->insert("data_peserta");
		}
		 
		return true;
	}
	function idu()
	{
		$this->session->userdata("id");
	}
	
	function setStatus()
	{
		$kode	=	$this->input->post("kode");
		$sts	=	$this->input->post("sts");
		$this->db->set("sts_dispo",$sts);
		$this->db->where("kode",$kode);
		return $this->db->update("data_persus");
	}
	function hapus_cek()
	{
	    $id =   $this->input->post("id");
	    $in =   $this->m_reff->clearkomaray($id);
	    $this->db->where("diterima_oleh",null);
	    $this->db->where_in("id",$in);
	    $this->db->set("hps",1);
	 return   $this->db->update("data_peserta");
	}
	function setBroadcast()
	{
	    $id				=	$this->input->get_post("id");//id
	 
		$id_pemohon		=	$this->m_reff->clearkomaray($id); 
		return $this->kirimEmail($id_pemohon); 
	}
		function kirimEmail($id_pemohon)
	{	 $var["ok"]=0;
		 $var["gagal"]=0;
		 $var["dgagal"]=""; 
		 $ok=0;$gagal=0;$dgagal="";
        foreach($id_pemohon as $val)
        {              
                        $this->db->where("id",$val);
                        $this->db->where("sts_acc",2);
                        $this->db->where("jadwal_distribusi IS NOT NULL");
                        $this->db->where("diterima_oleh IS NULL"); 
            $val    =   $this->db->get("data_peserta")->row();
            $to     =   $val->email;
            $isi    =   $this->isiEMail($val);
            $subject=   "Bukti Pengambilan Undangan"; 
            $tgl    =   $val->jadwal_distribusi;
            $phone  =   $val->hp;
            $path   =   $this->mdl->genUndangan($val); 
            $isiWa  =   $this->isiWa($val); 
                        $this->m_reff->kirimWa($phone,$isiWa);
                        $this->m_reff->kirimWa($phone,"Bukti Pengambilan Undangan",base_url().$path);
            $isiSms =   $this->isiSms($val);
                        $this->m_reff->kirimSms($phone,$isiSms);
			$sts    =   $this->m_reff->kirimEmail($to,$subject,$isi,$path,"Bukti Pengambilan Undangan HUT RI-75","delete");   
    		
			if($sts["sts"]=="ok"){
				$this->db->set("sts_notif",1);
				$this->db->set("sts_acc",2);
				$this->db->set("jadwal_distribusi",$tgl);
				$this->db->where("diterima_tgl",null);
				$this->db->where("email",$val->email);
				$this->db->update("data_peserta");
				$ok++;
			}else{
				$gagal++;
				$dgagal.=$val->email."<br>";
			}
        }
		 $var["ok"]=$ok;
		 $var["gagal"]=$gagal;
		 $var["dgagal"]=$dgagal;
		return $var;
	}
	
	 function genUndangan($val)
	{
		ob_start();
		//include('file.html');
	    $data["val"]=$val; 
		$isi=$this->load->view('genUndangan',$data); 
		
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
		 $html2pdf = new HTML2PDF('P',array("110","190"), 'en', true, '', array(0,0,0,0));
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
	//  $html2pdf->AddFont('monotypecorsiva', 'bold', 'monotypecorsiva.php'); 
		 $html2pdf->Output('file_upload/'.$val->hp.'.pdf', 'F');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
	    
       return "file_upload/".$val->hp.".pdf";
	}
	 
	 function isiEMail($data)
    {   $tgl         =   $data->jadwal_distribusi;   
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
    
    
     function isiWa($val)
    {
       
        $data=$val;
        $tgl         =   $val->jadwal_distribusi; 
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
	
	
	 function isiSms($val)
    { 
        $tgl    =   $val->jadwal_distribusi;
        $tgl    =   $this->tanggal->hariLengkap($tgl,"/");
        $isi=$this->m_reff->tm_pengaturan(9); 
        $isi=str_replace('{waktu_pengambilan}',$tgl,$isi);  
        return $isi;
    }
    
}

?>