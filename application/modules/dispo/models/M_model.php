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
			 
			$filter.=" AND (jenis_acara='".$jenis_acara."' ) ";
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
		
		$query="select * from data_peserta where id_kategory='1'  and sts_acc='0' ".$filter;
	
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
		 
		
		$query="select * from data_persus where sts_dispo in(2,3)  ".$filter;
	
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
		return $this->session->userdata("id");
	}
	
	function setStatus()
	{
		$kode	=	$this->input->post("kode");
		$sts	=	$this->input->post("sts");
		$this->db->set("sts_dispo",$sts);
		$this->db->where("kode",$kode);
		return $this->db->update("data_persus");
	}
	function setStsVerifikasi($id,$sts)
	{  
		$this->db->set("verifikator",$this->idu());
		$this->db->set("sts_verifikasi",$sts);
		$this->db->where("id",$id);
		return $this->db->update("data_peserta");
	}
	 
	function setTolak($id,$alasan)
	{
		/*$this->db->set("verifikator",$this->idu());
		$this->db->set("id_alasan",$alasan);
		$this->db->set("sts_verifikasi",2);
		$this->db->set("sts_acc",3);
		$this->db->where("id",$id);
		return $this->db->update("data_peserta");*/
		return $this->kirimEmail($id,$alasan);
	}
function kirimEmail($id,$id_alasan)
	{	 
	     $alasan =   $this->m_reff->goField("tm_alasan_penolakan","alasan","where id='".$id_alasan."' ");
	     
	     $var["ok"]=0;
		 $var["gagal"]=0;
		 $var["dgagal"]="";
		                $this->db->where("id",$id);
		                $this->db->where("sts_acc!=",2);
		 $data     =    $this->db->get("data_peserta")->row();
		 $ok=0;$gagal=0;$dgagal="";
            
            $to     =   $data->email;//$this->m_reff->goField("data_peserta","email","where id='".$val."' ");  
            $isi    =   $this->isiEMailPenolakan($data->nama,$data->nik,$alasan);
            $subject=   "HUT-RI75 ISTANA NEGARA"; 
            
            $phone  =   $data->hp; 
			$sts    =   $this->m_reff->kirimEmail($to,$subject,$isi);   
			if($sts["sts"]=="ok"){
				
				$isiWa  =   $this->isiWaPenolakan($data->nama,$data->nik,$alasan); 
				$this->m_reff->kirimWa($phone,$isiWa);
				
					$this->db->set("verifikator",$this->idu());
					$this->db->set("tgl_verifikasi",date('Y-m-d'));
            		$this->db->set("id_alasan",$id_alasan);
            		$this->db->set("sts_verifikasi",2);
            		$this->db->set("sts_acc",3);
            		$this->db->where("sts_acc!=",2);
            		$this->db->where("id",$id);
                	$this->db->update("data_peserta");
				$ok++;
			}else{
				$gagal++;
				$dgagal.=$val."<br>";
			}
        
		 $var["ok"]=$ok;
		 $var["gagal"]=$gagal;
		 $var["dgagal"]=$dgagal;
		return $var;
	}
	
	
	
	function isiEMailPenolakan($nama,$nik,$alasan)
	{
	    return    $isi='
    <table style="max-width:400px" cellpadding=0 cellspacing=0>
    <tr>
    <td colspan="2" style="background-color:#EEE;">
    <img  style="border-top-left-radius:15px;border-top-right-radius:15px" src="'.base_url().'plug/img/banner1.JPG" width="100%"   alt="E-receipt"  class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 1; left: 745px; top: 101px;"><div id=":rt" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Download lampiran " data-tooltip-class="a1V" data-tooltip="Download"><div class="aSK J-J5-Ji aYr"></div></div></div>
     <center>
     <span style="font-size:13"><b>  HUT RI-75 ISTANA NEGARA </b></span><br>
     <span style="font-size:13;color:#1572E8"><b>Status Permohonan : Ditolak </b></span>
     <hr width="90%">
     </center>
      </td>
    </tr>
    <tr>
    <td align="left" valign="top" style="background-color:#EEE;padding:10px"> 
    Kepada Yth:<br>
    Bapak/Ibu/Saudara :'.$nama.' <br>
    NIK / nomor identitas :'.$nik.' <br>
    Mohon maaf permohonan undangan anda untuk mengikuti acara HUT RI-75 di Istana Negara telah kami tolak dengan alasan :<br>
    <b>'.$alasan.'</b><br>
     Terimakasih atas partisipasi anda.
    </td> <td style="background-color:#EEE"> 
    </td>
    </tr>
   
    </table>
    
    
    ';
	}
	
	function isiWaPenolakan($nama,$nik,$alasan)
	{
	      $isi=$this->m_reff->tm_pengaturan(8);
        $isi=str_replace('{nama}',$nama,$isi);
        $isi=str_replace('{nik}',$nik,$isi);
        $isi=str_replace('{alasan}',$alasan,$isi); 
        return $isi;
	}
	
	
	
	
	
	function autoDispo()
	{
		$data=$this->db->query("SELECT * FROM v_blok  WHERE peruntukan=1 AND jenis=1 ORDER BY jml,nama ASC")->row();
		$var["blok1"]=isset($data->id)?($data->id):"";
		$data=$this->db->query("SELECT * FROM v_blok  WHERE peruntukan=1 AND jenis=2 ORDER BY jml,nama ASC")->row();
		$var["blok2"]=isset($data->id)?($data->id):"";
		return $var;
	}
	
	function setStsAcc($id,$sts)
	{   $this->db->set("verifikator",$this->idu());
	    $this->db->set("tgl_verifikasi",date('Y-m-d'));
		$this->db->set("sts_verifikasi",2);
		$this->db->set("sts_acc",2);
		$this->db->set("jenis_acara",$sts);
		
		$dispo	=	$this->mdl->autoDispo();
		if($sts==1)
		{	$this->db->set("blok1",$dispo["blok1"]);
			$this->db->set("blok2",null);
		}elseif($sts==2)
		{	$this->db->set("blok2",$dispo["blok2"]);
			$this->db->set("blok1",null);
		}else{
			$this->db->set("blok1",$dispo["blok1"]);
			$this->db->set("blok2",$dispo["blok2"]);
		}
		if(!$dispo["blok1"] and !$dispo["blok2"]){	return false;	}
		$this->db->where("id",$id);
		return $this->db->update("data_peserta");
	}
	function getProvByNik($nik)
	{		$this->db->where("sts_acc!=",3);
		$this->db->select("sum(jml_undangan) as jml");
		$this->db->where("SUBSTR(nik,1,2)",substr($nik,0,2));
		$return=$this->db->get("v_peserta")->row();
		return isset($return->jml)?($return->jml):"0";
	}function getKabByNik($nik)
	{		$this->db->where("sts_acc!=",3);
		$this->db->select("sum(jml_undangan) as jml");
		$this->db->where("SUBSTR(nik,1,4)",substr($nik,0,4));
		$return=$this->db->get("v_peserta")->row();
		return isset($return->jml)?($return->jml):"0";
	}
}

?>