<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_model extends ci_Model
{
	var $idevent=13;
	public function __construct() {
        parent::__construct();
		 
		$this->session->unset_userdata("date");
     	}
	function blok_sore($nik)
	{
		$this->db->where("nik",$nik);
		$this->db->where("jenis",2);
		$db=$this->db->get("data_peserta")->row();
		return isset($db->blok)?($db->blok):"";
	}
	
	function blok_pagi($nik)
	{
		$this->db->where("nik",$nik);
		$this->db->where("jenis",1);
		$db=$this->db->get("data_peserta")->row();
		return isset($db->blok)?($db->blok):"";
	}
		
		function dispon_sore($nik)
	{
		$this->db->where("nik",$nik);
		$this->db->where("jenis",2);
		return $this->db->get("data_peserta")->num_rows();
	}
		function dispon_pagi($nik)
	{
		$this->db->where("nik",$nik);
		$this->db->where("jenis",1);
		return $this->db->get("data_peserta")->num_rows();
	}
		
		
		 
	
	function jmlKolom($id)
	{
	$ids=$this->session->userdata("id");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_data_form",$id);
	return $this->db->get("tm_formulir")->num_rows();
	}
	function not($id)
	{
	$ids=$this->session->userdata("id");
	$data=array("status"=>"0");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_peserta",$id);
	return $this->db->update("data_peserta",$data);
	}
	
	function acc($id,$event)
	{
		$dataEvent=$this->dataEvent($event);
	//	$ps1=$this->Get_dataPeserta($event,"1");
	//	$ps2=$this->Get_dataPeserta($event,"2");
	//	$pt=$ps1+$ps2;
		
	$dataEvent=$this->dataEventID($event);
	$ids=$this->session->userdata("id");
	$data=array("status"=>"1");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_peserta",$id);
	//	if($dataEvent->quota<=$pt) { return 3; 	}//
	return $this->db->update("data_peserta",$data);
	}function not2($id)
	{
	$ids=$this->session->userdata("id");
	$data=array("status2"=>"0");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_peserta",$id);
	return $this->db->update("data_peserta",$data);
	}
	
	function acc2($id,$event)
	{
		$dataEvent=$this->dataEvent($event);
	//	$ps1=$this->Get_dataPeserta($event,"1");
	//	$ps2=$this->Get_dataPeserta($event,"2");
	//	$pt=$ps1+$ps2;
		
	$dataEvent=$this->dataEventID($event);
	$ids=$this->session->userdata("id");
	$data=array("status2"=>"1");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_peserta",$id);
	//	if($dataEvent->quota<=$pt) { return 3; 	}//
	return $this->db->update("data_peserta",$data);
	}
	function getDataForm($id)
	{
	$ids=$this->session->userdata("id");
	$this->db->order_by("id_formulir","asc");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_data_form",$id);
	return $this->db->get("tm_formulir")->result();
	}
	function namaForm($id)
	{
	$ids=$this->session->userdata("id");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_form",$id);
	$data=$this->db->get("data_form")->row();
	return isset($data->nama_form)?($data->nama_form):"<i>form dihapus</i>";
	}
	function jmlInvoice()
	{
	$ids=$this->session->userdata("id");
	$this->db->where("id_admin",$ids);
	$this->db->where("status","belum");
	return $this->db->get("data_invoice")->num_rows();
	}
	function jmlPeserta($id,$status)
	{
	$ids=$this->session->userdata("id");
	$this->db->where("id_admin",$ids);
	$this->db->where("id_event",$id);
	$this->db->where("status",$status);
	return $this->db->get("data_peserta")->num_rows();
	}
	
	
	private function _cekLInkEvent($acak)
	{
	$ids=$this->session->userdata("id");
	$this->db->where("id_admin",$ids);
	$this->db->where("link",$acak);
	return $this->db->get("data_event")->num_rows();
	}
	
	private function _link()
	{
	$acak=substr(str_shuffle("1234567890"),0,5);
	$cek=$this->_cekLInkEvent($acak);
	if($cek)
	{
	return $acak+12;	
	}else{
	return $acak;
	}
	
	}
	
	private function _insert_invoice()
	{
	$id=$this->session->userdata("id");
	
	$tarif=$this->db->query("select price,saldo from admin where id_admin='".$id."' ")->row();
	$price=$tarif->price;
	$saldo=$tarif->saldo;
	$quota=$this->input->post("quota");
	$biaya=$quota*$price+500;
	$bayarku=$mp="null"; $status="belum";
	
	
	if($this->cekvoucher($this->input->post('kodeVoucher'))=="ada") {
	$bayarku="voucher"; $status="lunas"; $mp="Voucher Gratis"; $alokasi="";
	}else
	{
	//	if($saldo>=$biaya) { $bayarku=$mp="saldo"; $status="lunas";    }
		if($saldo>=$biaya) { $b=$saldo-$biaya;	$bayarku=$mp="saldo"; $status="lunas";  
		}else{	
				if($saldo>0){ 
					$b=0; $bayarku=$mp="saldokurang"; $status="belum";	 
					
					
							}else{
				$b=0; $bayarku=$mp="null"; $status="belum";		
				}
		}
		$alokasi=$saldo-$biaya;
		if($biaya>=$saldo){ $alokasi=$saldo; }else { $alokasi=$biaya;};
	}
		
	$noinvo=substr(str_shuffle("1234567890"),0,5);
	$data=array(
	"id_admin"=>$id,
	"nomor_invoice"=>$noinvo,
	"status"=>$status,
	"quota"=>$this->input->post('quota'),
	"title"=>$this->input->post('namaEven'),
	"tarif"=>$price,
	"id_data_event"=>$this->_maxID(),
	"created"=>date('Y-m-d H:i:s'),
	"methode_pembayaran"=>$mp,
	"alokasi_saldo"=>$alokasi,
	"tgl_bayar"=>date('Y-m-d'),
	);
	$this->db->insert("data_invoice",$data);
	
	if($mp=="saldo" or $mp=="saldokurang") {
	$saldoini=$tarif->saldo-$b;
	$this->db->query("update admin set saldo='".$b."' where id_admin='".$id."'");
	}
	
	return $status."::".$bayarku;
	}
	
	
	private function _insert_Newinvoice($quota,$idEven)
	{
	$id=$this->session->userdata("id");
	
	$tarif=$this->db->query("select price,saldo from admin where id_admin='".$id."' ")->row();
	$price=$tarif->price;
	$saldo=$tarif->saldo;
	$biaya=$quota*$price+500;
	$bayarku=$mp="null"; $status="belum";
	
		
	
	if($this->cekvoucher($this->input->post('kodeVoucher'))=="ada") {
	$bayarku="voucher"; $status="lunas"; $mp="Voucher Gratis"; $alokasi="";
	}else
	{
	//	if($saldo>=$biaya) { $bayarku=$mp="saldo"; $status="lunas";    }
		if($saldo>=$biaya) { $b=$saldo-$biaya;	$bayarku=$mp="saldo"; $status="lunas";  
		}else{	
				if($saldo>0){ 
					$b=0; $bayarku=$mp="saldokurang"; $status="belum";	 
					
					
							}else{
				$b=0; $bayarku=$mp="null"; $status="belum";		
				}
		}
		$alokasi=$saldo-$biaya;
		if($biaya>=$saldo){ $alokasi=$saldo; }else { $alokasi=$biaya;};
	}
		
	$noinvo=substr(str_shuffle("1234567890"),0,5);
	$data=array(
	"id_admin"=>$id,
	"nomor_invoice"=>$noinvo,
	"status"=>$status,
	"quota"=>$quota,
	"title"=>$this->input->post('namaEven'),
	"tarif"=>$price,
	"id_data_event"=>$idEven,
	"created"=>date('Y-m-d H:i:s'),
	"methode_pembayaran"=>$mp,
	"alokasi_saldo"=>$alokasi,
	"tgl_bayar"=>date('Y-m-d'),
	);
	
	
	if($mp=="saldo" or $mp=="saldokurang") {
	$saldoini=$tarif->saldo-$b;
	$this->db->query("update admin set saldo='".$b."' where id_admin='".$id."'");
	}
		$dataEvent=$this->db->query("select status from data_event where id_admin='".$id."' and id_event='".$idEven."' ")->row();
		if($dataEvent->status==0){
		$update=array(
		"quota"=>$this->input->post('quota'),
		"title"=>$this->input->post('namaEven'),
		"tarif"=>$price,
		"created"=>date('Y-m-d H:i:s'),
		"methode_pembayaran"=>$mp,
		"alokasi_saldo"=>$alokasi,
		"tgl_bayar"=>date('Y-m-d'),
		);
			$this->db->where("id_admin",$id);
			$this->db->where("id_data_event",$idEven);
			return $this->db->update("data_invoice",$update);
		}else {
		
		$this->db->query("update data_event set status='0' where id_admin='".$id."' and id_event='".$idEven."' ");
		return $this->db->insert("data_invoice",$data);
		}
	}	
	
	
	private function _update_Newinvoice($quota,$idEven)
	{
	$id=$this->session->userdata("id");
	
	$tarif=$this->db->query("select price,saldo from admin where id_admin='".$id."' ")->row();
	$price=$tarif->price;
	$saldo=$tarif->saldo;
	$biaya=$quota*$price+500;
	$bayarku=$mp="null"; $status="belum";
	
		
	
	if($this->cekvoucher($this->input->post('kodeVoucher'))=="ada") {
	$bayarku="voucher"; $status="lunas"; $mp="Voucher Gratis"; $alokasi="";
	}else
	{
	//	if($saldo>=$biaya) { $bayarku=$mp="saldo"; $status="lunas";    }
		if($saldo>=$biaya) { $b=$saldo-$biaya;	$bayarku=$mp="saldo"; $status="lunas";  
		}else{	
				if($saldo>0){ 
					$b=0; $bayarku=$mp="saldokurang"; $status="belum";	 
					
					
							}else{
				$b=0; $bayarku=$mp="null"; $status="belum";		
				}
		}
		$alokasi=$saldo-$biaya;
		if($biaya>=$saldo){ $alokasi=$saldo; }else { $alokasi=$biaya;};
	}
		
	
	if($mp=="saldo" or $mp=="saldokurang") {
	$saldoini=$tarif->saldo-$b;
	$this->db->query("update admin set saldo='".$b."' where id_admin='".$id."'");
	}
		$dataEvent=$this->db->query("select status from data_event where id_admin='".$id."' and id_event='".$idEven."' ")->row();
		if($dataEvent->status==0){
		$update=array(
		"quota"=>$this->input->post('quota'),
		"title"=>$this->input->post('namaEven'),
		"tarif"=>$price,
		"created"=>date('Y-m-d H:i:s'),
		"methode_pembayaran"=>$mp,
		"alokasi_saldo"=>$alokasi,
		"tgl_bayar"=>date('Y-m-d'),
		);
			$this->db->where("id_admin",$id);
			$this->db->where("id_data_event",$idEven);
			return $this->db->update("data_invoice",$update);
		}
	}
	function saveChange($id)
	{
	$tglreg=$this->input->post("tglreg")."00";
	$tglreg=explode(" ",$tglreg);
	$tgl=$this->tanggal->eng_($tglreg[0],"-");
	$tglreg=$tgl." ".$tglreg[1];
	$start=$this->tanggal->eng_($this->input->post("start"),"-");
	$end=$this->tanggal->eng_($this->input->post("end"),"-");
	$noinvo=$this->_link();
	$data=array(
	"id_admin"=>$this->session->userdata("id"),
	"title"=>$this->input->post("namaEven"),
	"lokasi"=>$this->input->post("lokasi"),
	"startdate"=>$start,
	"enddate"=>$end,
	"quota"=>$this->input->post("quota"),
	"ket"=>$this->input->post("infoEvent"),
	"info_kontak"=>$this->input->post("infoKontak"),
	"id_form"=>$this->input->post("jenisForm"),
	"batas_registrasi"=>$tglreg,
	"acc"=>$this->input->post("proses"),
	"status_event"=>$this->input->post("status"),
	"lat"=>$this->input->post("lat"),
	"long"=>$this->input->post("long"),
	"sistem_tiket"=>$this->input->post("sistem_tiket"),
	);
	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_event",$id);
	/////
	$E=$this->dataEventID($id);
	if($E->id_form!=$this->input->post("jenisForm")){ $this->_delPeserta($id); }

	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_event",$id);
	return $this->db->update("data_event",$data);
	}
	private function _delPeserta($id)
	{
	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_event",$id);
	return $this->db->delete("data_peserta");
	}
	function save()
	{
	
	$tglreg=$this->input->post("tglreg")."00";
	$tglreg=explode(" ",$tglreg);
	$tgl=$this->tanggal->eng_($tglreg[0],"-");
	$tglreg=$tgl." ".$tglreg[1];
	$start=$this->tanggal->eng_($this->input->post("start"),"-");
	$end=$this->tanggal->eng_($this->input->post("end"),"-");
	$noinvo=$this->_link();
	$data=array(
	"id_admin"=>$this->session->userdata("id"),
	"title"=>$this->input->post("namaEven"),
	"lokasi"=>$this->input->post("lokasi"),
	"startdate"=>$start,
	"enddate"=>$end,
	"quota"=>$this->input->post("quota"),
	"ket"=>$this->input->post("infoEvent"),
	"info_kontak"=>$this->input->post("infoKontak"),
	"id_form"=>$this->input->post("jenisForm"),
	"batas_registrasi"=>$tglreg,
	"acc"=>$this->input->post("proses"),
	"status_event"=>$this->input->post("status"),
	"lat"=>$this->input->post("lat"),
	"long"=>$this->input->post("long"),
	"link"=>$noinvo,
	"sistem_tiket"=>$this->input->post("sistem_tiket"),
	"status"=>"1",
	);
	return $this->db->insert("data_event",$data);
	}
	function updateStatusPeserta($id,$date=1,$ke,$set)
	{
	
	if($date==null){ $date=1; }
	
	if($ke=="1"){
		$data=array(
		"status"=>$set,
		"cekin"=>date("d-m-Y H:i:s"),
		"gate"=>$this->session->userdata("gate"),
		); 
		$this->db->where("ip",$id);
	}
	
	if($ke=="2"){
		$data=array(
		"status2"=>$set,
		"cekin2"=>date("d-m-Y H:i:s"),
		"gate2"=>$this->session->userdata("gate"),
		); 
		$this->db->where("ip2",$id);
	}
	
//	$this->db->where("id_admin",$this->session->userdata("id"));
	return $this->db->update("data_peserta",$data);
	}
	private function _getDataPeserta2($id)
	{
	$this->db->where("kode_registrasi",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	return $get=$this->db->get("data_peserta")->row();
	}
	
	function updateStatusPeserta2($id,$date)
	{
	
	$isi=$this->_getDataPeserta2($id);
			$data=array(
			"id_admin"=>$this->session->userdata("id"),
			"data"=>$isi->data,
			"id_event"=>$isi->id_event,
			"tgl"=>$date." ".date('H:i:s'),
			"ip"=>$isi->ip,
			"kode_registrasi"=>$isi->kode_registrasi,
			"status"=>"2",
			"cekin"=>$date." ".date("H:i:s"),
			);
	return $this->db->insert("data_peserta",$data);
	}
	
	
	function updateStatusClassPeserta($id,$class,$date=null)
	{
	 if($date==null){ $date=date("Y-m-d"); }
	$data=array(
	"ket"=>$class,
	"cekin"=>date("d-m-Y H:i:s"),
	);
	
	 	$date=$this->session->userdata("date");
		if($date){
		$this->db->where("jenis",$date);
		}
	$this->db->where("jenis",$date);
	$this->db->where("kode_registrasi",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	return $this->db->update("data_peserta",$data);
	}
	
	function updateStatusPbPeserta($id)
	{
	$date=$this->session->userdata("date");
		if($date){
		$this->db->where("jenis",$date);
		}
	$this->db->where("kode_registrasi",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	$getMakan=$this->db->get("data_peserta")->row();
	$makan=$getMakan->pb;
	
	$data=array(
	"pb"=>$makan.",".date("Y-m-d H:i:s"),
	);
	$date=$this->session->userdata("date");
		if($date){
		$this->db->where("jenis",$date);
		}
	$this->db->where("kode_registrasi",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	return $this->db->update("data_peserta",$data);
	}
	
	function updateStatusSvPeserta($id)
	{
	$date=$this->session->userdata("date");
		if($date){
		$this->db->where("jenis",$date);
		}
	$this->db->where("kode_registrasi",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	$getMakan=$this->db->get("data_peserta")->row();
	$makan=$getMakan->sv;
	
	$data=array(
	"sv"=>$makan.",".date("Y-m-d H:i:s"),
	);
	$date=$this->session->userdata("date");
		if($date){
		$this->db->where("jenis",$date);
		}
	$this->db->where("kode_registrasi",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	return $this->db->update("data_peserta",$data);
	}
	
	function updateStatusMakanPeserta($id)
	{
		$date=date("Y-m-d");
	 
		$this->db->where("jenis",$date);
		$this->db->where("kode_registrasi",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	$getMakan=$this->db->get("data_peserta")->row();
	$makan=$getMakan->makan;
	
	$data=array(
	"makan"=>$makan.",".date("Y-m-d H:i:s"),
	);
	 
	 
		
	$this->db->where("jenis",$date);	 
	$this->db->where("kode_registrasi",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	return $this->db->update("data_peserta",$data);
	}
	
	
	/*private function _uploadForm($idform,$lebel,$ip,$ideven)
	{
		 $path = "file_upload/form/".$this->session->userdata("id")."_".$ideven;
				 if (!file_exists($path)) {
					mkdir($path);
				 }
		
		  $lokasi_file = $_FILES[$lebel]['tmp_name'];
		  $tipe_file   = $_FILES[$lebel]['type'];
		  $nama_file   = $_FILES[$lebel]['name'];
		  
		  if($tipe_file)
		  {
		   $jenis=explode("/",$tipe_file);
			$jenis=$jenis[1];
			if($jenis=="png" || $jenis=="jpg" || $jenis=="jpeg")
			{
			$jenis="jpg";
			};
		
		   $nama=$ip.$idform.str_replace(".","",$lebel).".".$jenis; //penamaan file

				 $path = "file_upload/form/".$this->session->userdata("id")."_".$ideven."/".$nama;
				 if (file_exists($path)) {
					unlink($path);
				 }
	
			 $target_path = "file_upload/form/".$this->session->userdata("id")."_".$ideven."/".$nama;
			 //
			 $path = "file_upload/form/".$this->session->userdata("id")."_".$ideven."/index.html";
			  $file=fopen($path,"w");
				 if (!file_exists($path)) {
					 $content_to_write = "No file!";
					fwrite($file, $content_to_write);
				    fclose($file);
				 }
			 
		  }
		  //
		if (!empty($lokasi_file)) {
		move_uploaded_file($lokasi_file,$target_path);
		return $nama;
		}
	}*/
	
	private function _uploadForm($idform,$lebel,$ip,$ideven)
	{
		 $path = "file_upload/form/".$this->session->userdata("id")."_".$ideven;
				 if (!file_exists($path)) {
					mkdir($path);
				 }
		  if(!isset($_FILES[$lebel]['tmp_name']))
		  {
			  return "";
		  }
		  
		  $lokasi_file = $_FILES[$lebel]['tmp_name'];
		  $tipe_file   = $_FILES[$lebel]['type'];
		  $nama_file   = $_FILES[$lebel]['name'];
		 
		  
		  if($tipe_file)
		  {
		   $jenis=explode("/",$tipe_file);
			$jenis=$jenis[1];
			if($jenis=="png" || $jenis=="jpg" || $jenis=="jpeg")
			{
			$jenis="jpg";
			};
		
		   $nama=$ip.$idform.str_replace(".","",$lebel).".".$jenis; //penamaan file

			/*	 $path = "file_upload/form/".$this->session->userdata("id")."_".$ideven."/".$nama;
				 if (file_exists($path)) {
					unlink($path);
				 }*/
	
			 $target_path = "file_upload/form/".$this->session->userdata("id")."_".$ideven."/".$nama;
			 //
			 $path = "file_upload/form/".$this->session->userdata("id")."_".$ideven."/index.html";
			  $file=fopen($path,"w");
				 if (!file_exists($path)) {
					 $content_to_write = "No file!";
					fwrite($file, $content_to_write);
				    fclose($file);
				 }
			 
		  }
		  //
		if (!empty($lokasi_file)) {
		move_uploaded_file($lokasi_file,$target_path);
		return $nama;
		}
	}
	private function _uploadPhotoIn($id,$ip)
	{
	$dataEvent=$this->dataEvent($id);
	$this->db->order_by("id_formulir","asc");
	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_data_form",$dataEvent->id_form);
	$db=$this->db->get("tm_formulir")->result();
	$data="";$foto="";
	foreach($db as $db)
	{
	
	$label=str_replace(" ","_",$db->nama_form);
	
	if($db->type_form=="5"){
	$foto=$this->_uploadForm($db->id_formulir,$label,$ip,$id);
	$data.="_@-ahref-@_".$foto." __v||v__ ";
	}
	
	
	elseif($db->type_form=="4"){
	$val="";
	$araypil=$db->pilihan;
	$data4=explode(",",$araypil);
	$dtcekbok="";
	foreach($data4 as $op)
	{
	$hmop=$this->input->post($op);
	if(isset($hmop)){
	$op=$hmop.", ";
	}else{
	$op="";
	};
	$dtcekbok.=$op;
	};
	$dtcekbok=str_replace(",,",", ",$dtcekbok);
	$data.=substr($dtcekbok,0,-1);
	
	$data.=" __v||v__ ";
		
	}
	
	
	else{
		$data.=$this->input->post($label)." __v||v__ ";
		}
	}
	return $data."::".$foto;
	}
	
	
	
	
	
	function saveRegister($id)
	{
	
	 $dat=$this->db->query("SELECT SUBSTR(startdate,1,10) as startdate,SUBSTR(enddate,1,10) as enddate FROM data_event where id_event='".$id."'")->row();
	 $selisih=$this->tanggal->selisih($dat->startdate,$dat->enddate);
  
			 
		
	$uri=$id;
		$dataEvent=$this->dataEvent($id);
		$ps1=$this->Get_dataPeserta($id,"1");
		$ps2=$this->Get_dataPeserta($id,"2");
		$pt=$ps1+$ps2;
		
	
		$tglSkrg=date('Y-m-d H:i:s');
		//if($dataEvent->batas_registrasi>$tglSkrg){ return 4; }
		$date=$this->session->userdata("date");
	//	if(!$date){
	//	$date=date('Y-m-d');
	//	}
		if($this->input->post("barcode"))
		{
			$kodeIPsip=$this->input->post("barcode");
		}else{
			$kodeIPsip=substr(str_shuffle("123456789019"),0,12);
		}
		 
			for($i=0;$i<=$selisih;$i++)
			{
				$tgl = mktime(0, 0, 0, SUBSTR($dat->enddate,5,2), SUBSTR($dat->enddate,8,2)-$i, SUBSTR($dat->enddate,0,4));
				$tglE=date("Y-m-d", $tgl);
				$tgl=date("Y-m-d", $tgl);
				
				
				$data=$this->_uploadPhotoIn($id,$kodeIPsip);
				if($dataEvent->acc=="1"){ $acc="0";}else{ $acc="1";};
				$data=explode("::",$data);
				$jundangan=$this->input->post("undangan[]");
				foreach($jundangan as $val)
				{
					$datainsert=array(
					"id_admin"=>$this->session->userdata("id"),
					"data"=>$data[0],
					"id_event"=>$dataEvent->id_event,
					"tgl"=>$tgl." ".date('H:i:s'),
					//"cekin"=>$tgl." ".date('H:i:s'),
					"ip"=>$kodeIPsip,
					"kode_registrasi"=>$kodeIPsip,
					"j_makan"=>$this->input->post("makan"),
					"j_souvenir"=>$this->input->post("souvenir"),
					"j_pb"=>$this->input->post("photoboth"),
					"blok"=>$this->input->post("blok"),
					"no_kursi"=>$this->input->post("no_kursi"),
					"lembaga"=>$this->input->post("Instansi/Lembaga"),
					"nama"=>$this->input->post("Nama"),
					"kontak"=>$this->input->post("Kontak"),
					"berlaku"=>$this->input->post("berlaku"),
					"foto"=>$data[1],
					"status"=>"1",
					"jenis"=>$val,
					);	
						
					$cekdulu=$this->db->query("select * from data_peserta where jenis='".$val."' and kode_registrasi='".$kodeIPsip."' and substr(tgl,1,10)='".$tgl."' ")->num_rows();
					if(!$cekdulu)
					{
					 	 $this->m_reff->qr($kodeIPsip);
						 $this->db->insert("data_peserta",$datainsert);	
					} 
				}
				
				 
			}	
		return true;
		}
		
		
		
	private function _uploadPhotoEd($idPeserta,$idEvent,$urut)
	{
	$dataEvent=$this->dataEvent($idEvent);
	$this->db->order_by("id_formulir","asc");
	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_data_form",$dataEvent->id_form);
	$db=$this->db->get("tm_formulir")->result();
	$data="";
	
		
	$dp=$this->db->query("select * from data_peserta where id_event='".$idEvent."' AND id_admin='".$this->session->userdata('id')."' AND id_peserta='".$idPeserta."' ")->row();
	$isidata=explode(" __v||v__ ",$dp->data);
	$dataisi=$isidata[$urut];//
	$kode=$dp->kode_registrasi;
	return $this->_EditUploadForm($dataEvent->id_form,$dp->kode_registrasi,$idEvent,$dp->data,$urut,$kode);
	

	}

	



	private function _EditUploadForm($idform,$ip,$ideven,$dp,$urut,$kode)
	{
	$lebel="isi";
		 $path = "file_upload/form/".$this->session->userdata("id")."_".$ideven;
				 if (!file_exists($path)) {
					mkdir($path);
				 }
		
		  $lokasi_file = $_FILES[$lebel]['tmp_name'];
		  $tipe_file   = $_FILES[$lebel]['type'];
		  $nama_file   = $_FILES[$lebel]['name'];
		  
		  if($tipe_file)
		  {
		   $jenis=explode("/",$tipe_file);
			$jenis=$jenis[1];
			if($jenis=="png" || $jenis=="jpg" || $jenis=="jpeg")
			{
			$jenis="jpg";
			};
		
		   $nama=$ip.$idform.str_replace(".","",$lebel).".".$jenis; //penamaan file

				 $path = "file_upload/form/".$this->session->userdata("id")."_".$ideven."/".$nama;
				 if (file_exists($path)) {
					unlink($path);
				 }
	
			 $target_path = "file_upload/form/".$this->session->userdata("id")."_".$ideven."/".$nama;
			 //
			 $path = "file_upload/form/".$this->session->userdata("id")."_".$ideven."/index.html";
			  $file=fopen($path,"w");
				 if (!file_exists($path)) {
					 $content_to_write = "No file!";
					fwrite($file, $content_to_write);
				    fclose($file);
				 }
			 
		  }
		  //
		if (!empty($lokasi_file)) {
		move_uploaded_file($lokasi_file,$target_path);
		///
				$isidata=explode(" __v||v__ ",$dp);
				$jmlisi=count($isidata);
				$ic='';
				for($i=0;$i<($jmlisi-1);$i++)
				{
				$ok=$isidata[$i]." __v||v__ ";
				if($i==$urut)
				{
				$ok="_@-ahref-@_".$nama." __v||v__ ";
				}
				$ic.=$ok;
				}
				
						$data=array(
						"data"=>$ic,
						"foto"=>$nama,
						);
							$this->db->where("id_event",$ideven);
							$this->db->where("kode_registrasi",$kode);
							$this->db->where("id_admin",$this->session->userdata("id"));
					return $this->db->update("data_peserta",$data);	
		///
		}
	}

	
		
	function editRegister($idPeserta,$idEvent,$urut)
	{
	$dp=$this->db->query("select data,kode_registrasi from data_peserta where id_event='".$idEvent."' AND id_admin='".$this->session->userdata('id')."' AND id_peserta='".$idPeserta."' ")->row();
	$kode=$dp->kode_registrasi;
	$dt=$this->getType($urut,$idEvent);
	$type=$dt->type_form;
	if($type=="5")
	{
	return	$data=$this->_uploadPhotoEd($idPeserta,$idEvent,$urut);
	}else
	{
	$isidata=explode(" __v||v__ ",$dp->data);
	$jmlisi=count($isidata);
	$ic='';
	for($i=0;$i<($jmlisi-1);$i++)
	{
	$ok=$isidata[$i]." __v||v__ ";
	if($i==$urut)
	{
	$ok=$this->input->post("isi")." __v||v__ ";
	}
	$ic.=$ok;
	}
	
			$data=array(
			"data"=>$ic,
			);
			if($urut=="0")
			{
				$data2=array("berlaku"=>$this->input->post("isi"));
			}
			elseif($urut==1)
			{
				$data2=array("nama"=>$this->input->post("isi"));
			}elseif($urut==2)
			{
				$data2=array("lembaga"=>$this->input->post("isi"));
			}elseif($urut==3)
			{
				$data2=array("kontak"=>$this->input->post("isi"));
			}else{
				$data2=array();
			}
			$data=array_merge($data,$data2);
				$this->db->where("id_event",$idEvent);
				$this->db->where("kode_registrasi",$kode);
				$this->db->where("id_admin",$this->session->userdata("id"));
		return $this->db->update("data_peserta",$data);	
	}
	}
	
	
	
	function dataEventID($id)
	{
	$this->db->where("id_event",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	return $this->db->get("data_event")->row();
	}
	private function _maxID()
	{
	$data=$this->db->query("select MAX(id_event) as max from data_event where id_admin='".$this->session->userdata("id")."' ")->row();
	return $data->max;
	}
	
	
	
	
	
	
	function dataForm()
	{
	$this->db->order_by("nama_form","ASC");
	$this->db->where("id_admin",$this->session->userdata("id"));
	return $this->db->get("data_form")->result();
	}
	
	function get_open()
	{
		
		$query=$this->_get_datatables_open();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	private function _get_datatables_open()
	{
	$query="select *,data_event.id_admin as id_admin from data_event LEFT JOIN data_form ON data_event.id_form=data_form.id_form WHERE data_event.id_admin='".$this->session->userdata("id")."' ";
	
		
		if($_POST['search']['value']){
		$searchkey=$_POST['search']['value'];
			$query.=" AND (
			startdate LIKE '%".$searchkey."%' OR 
			enddate LIKE '%".$searchkey."%' OR
			title LIKE '%".$searchkey."%' OR
			batas_registrasi LIKE '%".$searchkey."%' OR
			nama_form LIKE '%".$searchkey."%' OR
			ket LIKE '%".$searchkey."%' 
			) ";
		}

		$column = array('id_event');
		$i=0;
		foreach ($column as $item) 
		{
		$column[$i] = $item;
		}
		
		
			
		//	$this->db->order_by(key($order), $order[key($order)]);
			$query.=" order by id_event DESC" ;
	
		return $query;
	
	}
	function delform($id)
	{
	$this->db->where("id_event",$id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	return $this->db->delete("data_event");
	}
	
	public function count_file($tabel)
	{		
		$this->db->where("id_admin",$this->session->userdata("id"));
		$this->db->from($tabel);
		return $this->db->count_all_results();
	}
	function count_filtered($tabel)
	{
		$this->db->where("id_admin",$this->session->userdata("id"));
		$this->db->from($tabel);
		$query=$this->_get_datatables_open();
		return $this->db->query($query)->num_rows();
	}
	private function _dataPeserta($id)
	{
	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_event",$id);
	return $this->db->delete("data_peserta");
	}
	
	private function Get_dataPeserta($id,$status)
	{
	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_event",$id);
	$this->db->where("status",$status);
	return $this->db->get("data_peserta")->num_rows();
	}
	
	private function folderhapus($folderhapus) {
		$files = glob($folderhapus.'/*'); // Ambil semua file yang ada dalam folder
		foreach($files as $file){ // Lakukan perulangan dari file yang kita ambil
		  if(is_file($file)) // Cek apakah file tersebut benar-benar ada
			unlink($file); // Jika ada, hapus file tersebut
		}
		 if(is_file($folderhapus))
		 {
		rmdir($folderhapus);
		 }
	}
	
	function _delInvoice($id)
	{
	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_data_event",$id);
	$this->db->where("status!=","lunas");
	return $this->db->delete("data_invoice");
	}
	
	function deleteAllPeserta($id)
	{
	
	 $path = "file_upload/form/".$this->session->userdata("id")."_".$id;
				 
	return $this->folderhapus($path);

	}
	
	function delete($id)
	{
	
	 $path = "file_upload/form/".$this->session->userdata("id")."_".$id;
				 
	$this->folderhapus($path);
	
	$this->_dataPeserta($id);
	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_event",$id);
	$this->db->delete("data_event");
	return $this->_delInvoice($id);
	}
	function dataEvent($idEvent)
	{
		$this->db->where("id_admin",$this->session->userdata("id"));
		$this->db->where("id_event",$idEvent);
		return $this->db->get("data_event")->row();
	}
	
	
	/*peserta---------------------------------------------------------*/
	function hapusAll()
	{
	//$IDG=$this->session->userdata("id");
	$hapus=$this->input->post("hapus");
		foreach($hapus as $ID)
		{
		$this->hapusPeserta($ID);
		}	return true;
	}
	private function hapusBarcode($ID)
	{
		$dt=$this->db->query("select kode_registrasi from data_peserta where id_peserta='".$ID."' ")->row();
		$qr=isset($dt->kode_registrasi)?($dt->kode_registrasi):"";
		$filename = "qr/".$qr.".png";
		if (file_exists($filename)){
			unlink($filename);
		} 
	}
	private function hapusPeserta($ID)
	{
		$this->hapusBarcode($ID);
		$this->db->where("id_peserta",$ID);
		return $this->db->delete("data_peserta");
	}
	function get_peserta()
	{
		
		$query=$this->_get_datatables_peserta();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	
	function get_barcode()
	{
		
		$query=$this->_get_datatables_barcode();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	function getType($urut,$idEvent)
	{
	$getForm=$this->db->query("select id_form from data_event where 
	id_admin='".$this->session->userdata("id")."' and id_event='".$idEvent."' ")->row();
	return $db=$this->db->query("SELECT nama_form,type_form,pilihan FROM tm_formulir WHERE  id_data_form='".$getForm->id_form."' AND id_admin='".$this->session->userdata("id")."' ORDER BY id_formulir ASC LIMIT ".$urut.",999")->row();
	}
	private function _get_datatables_peserta()
	{
		$sts_acc	=	$this->input->get_post("sts_acc");
		$sts_notif  =   $this->input->get_post("sts_notif");
		$penerima  =   $this->input->get_post("penerima");
		$filter="";
		if($penerima){
		    $filter=" AND ( penerima is null or penerima='') ";
		}
		$query="select * from v_peserta where sts_acc='2' and sts_notif='".$sts_notif."'   ".$filter;
	
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
		
	   
			$query.="group by id_peserta asc" ;
		return $query;
	
	}
	
	public function count_file_peserta($tabel)
	{		
		
		$q=$this->_get_datatables_peserta();
		return $this->db->query($q)->num_rows();
	}
	function count_filtered_peserta($tabel)
	{	$this->db->where("id_event",$this->idevent);
		$this->db->where("id_admin",$this->session->userdata("id"));
		$this->db->from($tabel);
		$query=$this->_get_datatables_peserta();
		return $this->db->query($query)->num_rows();
	}
	
	/*--------------------------------------------------*/
	
	private function _get_datatables_barcode()
	{
		$query="select * from data_barcode where 1=1 
		  ";
	
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
		
		$column = array('data');
		$i=0;
		foreach ($column as $item) 
		{
		$column[$i] = $item;
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
			$query.=" order by jenis,blok,gate,id_peserta asc" ;
		return $query;
	
	}
	
	public function count_file_barcode($tabel)
	{		
		
		$q=$this->_get_datatables_barcode();
		return $this->db->query($q)->num_rows();
	}
	function count_filtered_barcode($tabel)
	{	$this->db->where("id_event",$this->idevent);
		$this->db->where("id_admin",$this->session->userdata("id"));
		$this->db->from($tabel);
		$query=$this->_get_datatables_barcode();
		return $this->db->query($query)->num_rows();
	}
	
	/*--------------------------------------------------*/
	private function _delFile($id)
	{
	$this->db->where("id_peserta",$id);
	$this->db->where("id_admin",$idadmin=$this->session->userdata("id"));
	$datax=$this->db->get("data_peserta")->row();
	$idEven=$datax->id_event;
	$coun=$this->db->query("select * from data_peserta where 
	kode_registrasi='".$datax->kode_registrasi."' AND id_event='".$idEven."' ")->num_rows();
	if($coun>1){ return false; }
	
	$data=$datax->data;
	$data=explode("_@-ahref-@_",$data);
	$jml=count($data);
	for($i=1;$i<$jml;$i++)
	{
		$part2=explode(" __v||v__ ",$data[$i]);
		$nama=$part2[0];
		
		 $path = "file_upload/form/".$idadmin."_".$idEven."/".$nama;
				 if (file_exists($path)) {
					unlink($path);
				 }
	}
	
	
	
	
	}
	function deletePeserta()
	{
		$id=$this->input->post("id");
	 	$id=substr($id,0,-1);
		 
	//$this->hapusBarcode($id);
	 
 
		$this->db->where("id_peserta in (".$id.") ");
	   $this->db->delete("data_peserta");
	}
	
	function tglAwal($idevent)
	{
	$db=$this->db->query("SELECT DISTINCT(SUBSTR(tgl,1,10)) AS tgl FROM data_peserta WHERE id_event='".$idevent."' LIMIT 1")->row();
	return isset($db->tgl)?($db->tgl):date('Y-m-d');
	}
	
	private function _GetDataPeserta($id)
	{
	$this->db->where("id_admin",$this->session->userdata("id"));
	$this->db->where("id_event",$id);
		$date=$this->session->userdata("dates");
		if($date){
		$this->db->where("jenis",$date);
		}
		 
	return $this->db->get("data_peserta")->result();
	}
	
	function exportPeserta($id)
	{
			
		//////start
	$objPHPExcel = new PHPExcel();
	//style
	$style = array( 
     'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'rotation'   => 0,
      ),
      'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => '339966')
          ),
     'borders' => 
      array( 'allborders' => 
        array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
          ), 
        ), 
    );
	$style2 = array( 
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'rotation'   => 0,
      ),
	  'borders' => 
      array( 'allborders' => 
        array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
          ), 
        ), 
      'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => 'ccccff')
          )
    );	
	
	$fontHeader = array( 
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'ffffff')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
		);


		$fontHeader2 = array( 
		'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => '99cc00')
          ),
		  'borders' => 
      array( 'allborders' => 
        array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
          ), 
        ), 
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => '000000')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
		);
	//header margen cell--------------------------
	//$objPHPExcel->getActiveSheet(0)->mergeCells('A1:A2');
	
	//untuk pewarnaan
	
	///END Header----------------------
	//// ATUR SIZE

$dataEvent=$this->dataEvent($id);
$dataForm=$this->getDataForm($dataEvent->id_form); 
	//cell value
	$objPHPExcel->getActiveSheet(0)->setCellValue('A1',"No");
	$startHeader="A";
	foreach($dataForm as $val){
	$startHeader++;
	$objPHPExcel->getActiveSheet(0)->setCellValue($startHeader.'1',$val->nama_form);
	}
		$startHeader++;
	$objPHPExcel->getActiveSheet(0)->setCellValue(''.$startHeader++.'1',"Nomor Registrasi");
	$objPHPExcel->getActiveSheet(0)->setCellValue(''.$startHeader++.'1',"Status Peserta");
//	$objPHPExcel->getActiveSheet(0)->setCellValue(''.$startHeader++.'1',"Jumlah Makan");
//	$objPHPExcel->getActiveSheet(0)->setCellValue(''.$startHeader++.'1',"Jumlah Souvenir");
//	$objPHPExcel->getActiveSheet(0)->setCellValue(''.$startHeader++.'1',"Jumlah Photoboth");
//	$objPHPExcel->getActiveSheet(0)->setCellValue(''.$startHeader.'1',"Kelas");

	/*--------------------------------------------------------------------------------------------->*/
	$dataPeserta=$this->_GetDataPeserta($id);
	$start=2;$no=1;$startisi="A";
	foreach($dataPeserta as $dataDB)
	{
	$objPHPExcel->getActiveSheet(0)->setCellValue($startisi++.$start,"".$no++);
		/*------------------------------------*/
			$isidata=explode(" __v||v__ ",$dataDB->data);
			$jmlKolom=count($isidata);
			for($i=0;$i<($jmlKolom-1);$i++)
			{
			
				if(count(explode("_@-ahref-@_",$isidata[$i]))>1){
					$isiUpload=str_replace("_@-ahref-@_","",$isidata[$i]);
									
				$isi=$isiUpload;
				
				}else
				{
				$isi=$isidata[$i];
				}
				$objPHPExcel->getActiveSheet(0)->setCellValue($startisi++.$start,"".$isi);
							
			}
		if($dataDB->status==0) { $stts="Belum Terverifikasi";	 }elseif($dataDB->status==1){ $stts="Terverifikasi"; } else { $stts="Hadir";}
		$objPHPExcel->getActiveSheet(0)->setCellValue($startisi++.$start,"`".$dataDB->kode_registrasi);
		$objPHPExcel->getActiveSheet(0)->setCellValue($startisi++.$start,$stts);
		
		$jmlMakan=count(explode(",",substr($dataDB->makan,1,99999)));
		$jmlPb=count(explode(",",substr($dataDB->pb,1,99999)));
		$jmlSv=count(explode(",",substr($dataDB->sv,1,99999)));
		if($dataDB->makan==""){ $jmlMakan=0; }
	//	$objPHPExcel->getActiveSheet(0)->setCellValue($startisi++.$start,$jmlMakan);
	//	$objPHPExcel->getActiveSheet(0)->setCellValue($startisi++.$start,$jmlSv);
	//	$objPHPExcel->getActiveSheet(0)->setCellValue($startisi++.$start,$jmlPb);
	//	$objPHPExcel->getActiveSheet(0)->setCellValue($startisi++.$start,$dataDB->ket);
		/*------------------------------------*/
	$startisi="A";
	$start++;		
	}
	
	
	/*--------------------------------------------------------------------------------------------->*/
	//make a border column
 
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:'.$startHeader.'1')->applyFromArray($style);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:'.$startHeader.'1')->applyFromArray($fontHeader);
	for($x="A";$x<=$startHeader;$x++)
	{
	$objPHPExcel->getActiveSheet(0)->getColumnDimension($x)->setAutoSize(true);
	}
	
	
	// Rename worksheet (worksheet, not filename)
	$objPHPExcel->getActiveSheet(0)->setTitle("Data Peserta");
	  

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
		$date=$this->session->userdata("date");
		if($date){
		$date;
		}else
		{
		$date=$this->tglAwal($id);
		}
	header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename='.str_replace(" ","_",$dataEvent->title."|".$date).'.xlsx');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	//////finish
	
	}
	
	function download_template($id)
	{
			
		//////start
	$objPHPExcel = new PHPExcel();
	//style
	$style = array( 
     'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'rotation'   => 0,
      ),
      'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => '339966')
          ),
     'borders' => 
      array( 'allborders' => 
        array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
          ), 
        ), 
    );
	$style2 = array( 
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'rotation'   => 0,
      ),
	  'borders' => 
      array( 'allborders' => 
        array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
          ), 
        ), 
      'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => 'ccccff')
          )
    );	
	
	$fontHeader = array( 
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'ffffff')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
		);


		$fontHeader2 = array( 
		'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => '99cc00')
          ),
		  'borders' => 
      array( 'allborders' => 
        array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
          ), 
        ), 
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => '000000')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
		);
	//header margen cell--------------------------
	//$objPHPExcel->getActiveSheet(0)->mergeCells('A1:A2');
	
	//untuk pewarnaan
	
	///END Header----------------------
	//// ATUR SIZE

$dataEvent=$this->dataEvent($id);
$dataForm=$this->getDataForm($dataEvent->id_form); 
	//cell value

	$startHeader="E";
	$objPHPExcel->getActiveSheet(0)->getStyle('A1')->applyFromArray($style);
	$objPHPExcel->getActiveSheet(0)->setCellValue('A1',"KODE REGISTRASI");
	$objPHPExcel->getActiveSheet(0)->setCellValue('B1',"JENIS UNDANGAN");
	$objPHPExcel->getActiveSheet(0)->setCellValue('C1',"PENANGGUNG JAWAB");
		$objPHPExcel->getActiveSheet(0)->setCellValue('D1',"NAMA TAMU");
		$objPHPExcel->getActiveSheet(0)->setCellValue('E1',"INSTANSI/LEMBAGA");
		$objPHPExcel->getActiveSheet(0)->setCellValue('F1',"JML BERLAKU UNDANGAN");
	//$objPHPExcel->getActiveSheet(0)->setCellValue('D1',"BLOK");
	//$objPHPExcel->getActiveSheet(0)->setCellValue('E1',"NO KURSI");
	$objPHPExcel->getActiveSheet(0)->setCellValue('A2',"KOSONG=BY SISTEM");
	$objPHPExcel->getActiveSheet(0)->setCellValue('B2',"1= TAMU PAGI");
	$objPHPExcel->getActiveSheet(0)->setCellValue('B3',"2= TAMU SORE");
	$objPHPExcel->getActiveSheet(0)->setCellValue('B4',"3= TAMU PAGI & SORE");
		$objPHPExcel->getActiveSheet(0)->getStyle('B1')->applyFromArray($style);
			$objPHPExcel->getActiveSheet(0)->getStyle('C1')->applyFromArray($style);
				$objPHPExcel->getActiveSheet(0)->getStyle('D1')->applyFromArray($style);
					$objPHPExcel->getActiveSheet(0)->getStyle('E1')->applyFromArray($style);
						$objPHPExcel->getActiveSheet(0)->getStyle('F1')->applyFromArray($style);
					
					  
	/*foreach($dataForm as $val){
	$objPHPExcel->getActiveSheet(0)->getStyle($startHeader.'1')->applyFromArray($style);
	$objPHPExcel->getActiveSheet(0)->setCellValue($startHeader++.'1',$val->nama_form);
	
	}*/
		

	/*--------------------------------------------------------------------------------------------->*/
	$dataPeserta=$this->_GetDataPeserta($id);
	$start=2;$no=1;$startisi="A";
	
	
	/*--------------------------------------------------------------------------------------------->*/
	//make a border column
 
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:F1')->applyFromArray($fontHeader);
	//for($x="A";$x<$startHeader;$x++)
	//{
	//$objPHPExcel->getActiveSheet(0)->getColumnDimension($x)->setAutoSize(true);
	//}
	$objPHPExcel->getActiveSheet(0)->getColumnDimension("A")->setWidth("20");
	$objPHPExcel->getActiveSheet(0)->getColumnDimension("B")->setWidth("20");
	$objPHPExcel->getActiveSheet(0)->getColumnDimension("C")->setWidth("25");
	$objPHPExcel->getActiveSheet(0)->getColumnDimension("D")->setWidth("20");
	$objPHPExcel->getActiveSheet(0)->getColumnDimension("E")->setWidth("20");
	$objPHPExcel->getActiveSheet(0)->getColumnDimension("F")->setWidth("25");
	
	// Rename worksheet (worksheet, not filename)
	$objPHPExcel->getActiveSheet(0)->setTitle("Data Peserta");
	  

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename='.str_replace(" ","_",$dataEvent->title).'.xlsx');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	//////finish
	
	}
	
	
	 
 
	function idu()
	{
		return $this->session->userdata("id");
	}
 
	function setStatus()
	{
		$nik	=	$this->input->post("nik");
		$sts	=	$this->input->post("sts");
		$this->db->set("sts_acc",$sts);
		$this->db->where("nik",$nik);
		return $this->db->update("data_peserta");
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
    private function _updateStatus($email,$tgl)
    {
        $tgl    =   $this->tanggal->eng_($tgl,"-");
        $this->db->set("tgl_ambil",$tgl);
        $this->db->set("sts_notif",1);
         $this->db->set("sts_acc",2);
        $this->db->where("email",$email);
        return $this->db->update("data_peserta");
    }
    function kirim()
    {
        $id     =   $this->input->get_post("id");
        $tgl     =   $this->input->get_post("tgl");
        $data   =   $this->m_reff->clearkomaray($id);
        foreach($data as $val)
        {    
            $to=$this->m_reff->goField("v_peserta","email","where id_peserta='".$val."' "); 
            $this->_updateStatus($to,$tgl);
            $isi=$this->isiEMail($val);
            $subject="Informasi Pengambilan Undangan";
            
            $this->_kirim_email($isi,$to,$subject);
        }
        
    }
    function isiEMail($val)
    {
        $this->db->where("id_peserta",$val);
        $data=$this->db->get("v_peserta")->row();
        $nik         =   $data->nik;
        $nama        =   $data->nama;
        $email       =   $data->email;
        $lembaga     =   $data->lembaga;
        $tgl_ambil   =   $this->tanggal->hariLengkap($data->tgl_ambil,"/");
        $this->m_reff->qr($nik);
        
        $blok_pagi  =   $this->mdl->dispon_pagi($nik);
        $blok_sore  =   $this->mdl->dispon_sore($nik);
        
    return    $isi='
    <table style="max-width:400px" cellpadding=0 cellspacing=0>
    <tr>
    <td colspan="2" style="background-color:#EEE;">
    <img  style="border-top-left-radius:15px;border-top-right-radius:15px" src="'.base_url().'plug/img/banner2.JPG" width="100%"   alt="E-receipt"  class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 1; left: 745px; top: 101px;"><div id=":rt" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Download lampiran " data-tooltip-class="a1V" data-tooltip="Download"><div class="aSK J-J5-Ji aYr"></div></div></div>
     <center>
     <span style="font-size:16"><b> INFORMASI PENGAMBILAN UNDANGAN</b></span>
     <hr width="90%">
     </center>
      </td>
    </tr>
    <tr>
    <td align="left" valign="top" style="background-color:#EEE;padding:10px"> 
     <span style="font-size:11px;color:#9e9e9e;line-height:16px">Nama Pemohon :</span><br>
      <span style="font-size:13px;line-height:16px;font-weight:bold;color:black">'.$nama.'</span> <br>
      
      <span style="font-size:11px;color:#9e9e9e;line-height:16px">NIK :</span><br>
      <span style="font-size:13px;line-height:16px;font-weight:bold;color:black">'.$nik.'</span> <br>
      
      <span style="font-size:11px;color:#9e9e9e;line-height:16px">Lembaga / instansi:</span><br>
      <span style="font-size:13px;line-height:16px;color:black"><b>'.$lembaga.'</b></span> <br>
     <br>
        <b style="font-size:12px;font-weight:bold;color:teal;"> PEROLEHAN UNDANGAN</b><br>
      
      <span style="font-size:13px;line-height:16px; color:black">Undangan Pagi : '.$blok_pagi.'</span> <br> 
    
      <span style="font-size:13px;line-height:16px; color:black">Undangan Sore : '.$blok_sore.'</span> <br>
     
     
    </td> <td style="background-color:#EEE"><center>
    
                 
                 <img src="'.base_url().'qr/'.$nik.'.png" width="150px"><br>
                 </center>
    </td>
    </tr>
    <tr>
    <td colspan="2"  style="background-color:#EEE;padding:10px"> 
   <div>  <b style="font-size:12px;font-weight:bold;color:teal;"> INFORMASI PENGAMBILAN UNDANGAN</b><br> 
     <span style="font-size:13px;color:black;line-height:16px"> - Undangan dapat diambil pada hari   '.$tgl_ambil.' pukul 08.30 - 16.00 WIB </span><br>
    <span style="font-size:13px;color:black;line-height:16px"> - Membawa KTP Asli. </span><br>
        <span style="font-size:13px;color:black;line-height:16px"> - Menunjukan email ini saat pengambilan. </span><br>
        </div>
    </td>
    </tr>
    </table>
    
    
    ';
        
    }
	private function _kirim_email($isi,$to,$subject)
	{
		 
		$this->config1();
		$this->email->set_newline("\r\n");
		$mail = $this->email;
		$mail->from("no-replay@divisionit.co.id","HUT-RI 75");
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
}

?>