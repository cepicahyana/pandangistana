<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notif extends CI_Controller {

	
	var $idevent=13;
	function __construct()
	{
		parent::__construct();	
		$this->load->model('m_model','mdl');
		$this->m_konfig->validasi_session(array("user","registrasi"));
			$this->load->library('email');
		date_default_timezone_set("Asia/Jakarta");
	}
  
	function isiEMail($val)
	{
	    echo $this->mdl->isiEMail($val);
	}
	function _template($data)
	{
	$this->load->view('temp_user/main',$data);	
	}
 
	public function index()
	{
		 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("index");
		}else{
			$data['konten']="index";
			$this->_template($data);
		}
		 
	} 
	 
	function ajax_peserta()
	{
		$list = $this->mdl->get_peserta();
		$data = array();
		$no = $_POST['start'];
		$no =$no+1;
		///
		//$id=$this->uri->segment(3); 
	//	$event=$this->mdl->dataEvent($id);
	//	$jmlKolom=$this->mdl->jmlKolom($event->id_form); 
		$this->db->order_by("nama","asc");
		$data_b=$this->db->get("tr_blok")->result();
		$data_blok[null]="---";
		foreach($data_b as $b)
		{
			$data_blok[$b->nama]=$b->nama;
		}
		$sts_notif    = $this->input->get_post("sts_notif");  
		 
		foreach ($list as $dataDB) {
		////
		 
			$row = array();
			if($sts_notif!=1){
			$row[] =  '
			 <input type="checkbox" id="md_checkbox_'.$dataDB->id_peserta.'"   class="pilih filled-in chk-col-red" onclick="pilcek()"  name="hapus[]"  value="'.$dataDB->id_peserta.'" />
                                <label for="md_checkbox_'.$dataDB->id_peserta.'">&nbsp;</label> ';
			}
			$row[] = "<span class='size'>".$no++."</span>";
			 
			 if($dataDB->sts_notif==0)
			 {
				 $status="<i class='font-11'>belum dikirim</i>";
			 } else{
			     if(!$dataDB->penerima){
			         $status="<i class='col-deep-orange'>Belum diambil</i><br>Jadwal Pengambilan: ".$this->tanggal->ind($dataDB->tgl_ambil,"/");
			     }else{
			         	$status="<i class='font-13 col-indigo'>".$dataDB->penerima."</i><br><i class='font-13'>Tgl Terima : ".$this->tanggal->ind($dataDB->tgl_terima,"/")."</i>";
			     }
			
			 }
			 
			 
			if($dataDB->nama)
			{
				$natam=$dataDB->nama;
			}else{
				$natam="---";
			}
			if($dataDB->lembaga)
			{
				$lembaga=$dataDB->lembaga;
			}else{
				$lembaga="---";
			}
			if($dataDB->jenis==1){
			$acara="Pagi";}else{
				$acara="Sore";
			}
		 
			$kod1="<input type='text' name='kod' id='kod1".$dataDB->id_peserta."' value='".$dataDB->ip."' onchange='setKode(`1`,`".$dataDB->id_peserta."`)'>";
			$kod2="<input type='text' name='kod' id='kod2".$dataDB->id_peserta."' value='".$dataDB->ip2."' onchange='setKode(`2`,`".$dataDB->id_peserta."`)'>";
			
			$blok_sore		=	$this->mdl->blok_sore($dataDB->nik);
			$blok_pagi		=	$this->mdl->blok_pagi($dataDB->nik);
			
			$dispon_sore		=	$this->mdl->dispon_sore($dataDB->nik);
			$dispon_pagi		=	$this->mdl->dispon_pagi($dataDB->nik);
			$blok_pagi_d		=	form_dropdown("blok_pagi",$data_blok,$blok_pagi,"  style='width:60px' class=' form-control'  onchange='setBlok(`".$dataDB->nik."`,`1`,this.value)' ");
			$blok_sore_d		=	form_dropdown("blok_sore",$data_blok,$blok_sore,"style='width:60px' class='form-control'  onchange='setBlok(`".$dataDB->nik."`,`2`,this.value)' ");
			$nama               =   $dataDB->nama;
			//$kategory		=	$this->m_reff->goField("tr_kategory","nama","where id='".$dataDB->id_kategory."' ");
			$row[]			= 	$nama.br()."<i class='col-deep-orange'>".$dataDB->nik."</i>";
			$row[]			= 	$dataDB->lembaga;
			$row[]			= 	"<span class='  font-bold' onclicks='getDispo(`".$dataDB->nik."`,`1`,`".$nama."`)' >".$dispon_pagi."</span>";
			$row[]			= 	"<span class='  font-bold' onclicks='getDispo(`".$dataDB->nik."`,`2`,`".$nama."`)'>".$dispon_sore."</span>"; 
			$row[]			= 	$status;
			//$row[]			= 	$kategory;  
		//	$row[]			=	"<div  class='col-md-4' ><input style='width:60px' class='form-control' value='".$dispon_pagi."' onchange='setDispo(`1`,this.value)'></div> <div class='col-md-4'  >".$blok_pagi_d."</div><div  class='col-md-4' >".$berlaku_pagi."</div>"; 
		//	$row[]			=	"<div  class='col-md-4' ><input style='width:60px' class='form-control' value='".$dispon_sore."' onchange='setDispo(`2`,this.value)'> </div> <div  class='col-md-4W' >".$blok_sore_d."</div><div  class='col-md-4' >".$berlaku_sore."</div>"; 
			
								
						 
			//$row[]			= 	$blok_pagi_d;  
			//$row[]			= 	$blok_sore_d;  
  
			$data[] 		= 	$row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mdl->count_file_peserta("data_peserta"),
						"recordsFiltered" =>$this->mdl->count_filtered_peserta('data_peserta'),
						"data" => $data,
						);
		//output to json format
		echo json_encode($output);
	} 
		public function send()
	{
		 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("send");
		}else{
			$data['konten']="send";
			$this->_template($data);
		}
		 
	}
		public function bd()
	{
		 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("bd");
		}else{
			$data['konten']="send";
			$this->_template($data);
		}
		 
	}
	function kirim()
	{
		$data	= $this->mdl->kirim();
		echo json_encode($data);
	}
	
	function setRekap()
	{
		$id=$this->input->post("id");
		$set=$this->input->post("set");
		$this->db->where("id_peserta",$id);
		$this->db->set("rekap",$set);
		echo $this->db->update("data_peserta");
	}
	function ajax_barcode()
	{
		$list = $this->mdl->get_barcode();
		$data = array();
		$no = $_POST['start'];
		$no =$no+1;
		///
		//$id=$this->uri->segment(3); 
	//	$event=$this->mdl->dataEvent($id);
	//	$jmlKolom=$this->mdl->jmlKolom($event->id_form); 
		foreach ($list as $dataDB) {
		////
		$isidata=explode(" __v||v__ ",$dataDB->data);
			$row = array();
			$row[] =  '
			 <input type="checkbox" id="md_checkbox_'.$dataDB->id_peserta.'"   class="pilih filled-in chk-col-red" onclick="pilcek()"  name="hapus[]"  value="'.$dataDB->id_peserta.'" />
                                <label for="md_checkbox_'.$dataDB->id_peserta.'">&nbsp;</label> ';
			
			$row[] = "<span class='size'>".$no++."</span>";
		 
			  
			 
			$row[]= $dataDB->ip;
			$row[]= $dataDB->cetak;
	 
		  
		
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mdl->count_file_barcode("data_peserta"),
						"recordsFiltered" =>$this->mdl->count_filtered_barcode('data_peserta'),
						"data" => $data,
						);
		//output to json format
		echo json_encode($output);
	}
	function setKode()
	{
		$id=$this->input->post("id");
		$ke=$this->input->post("ke");
		$kode=$this->input->post("kode");
		$cek=$this->db->query("select * from data_peserta where (ip='".$kode."' or ip2='".$kode."') ")->num_rows();
		if($cek){
		echo "false";
		return false;
		}
		
		$this->db->where("id_peserta",$id);
		$this->db->set("kode_registrasi",$kode);
		if($ke==1)
		{
			$this->db->set("ip",$kode);
		}else{
			$this->db->set("ip2",$kode);
		}
		
		$this->db->update("data_peserta");
		return $this->m_reff->qr($kode);
	}
	function deletePeserta()
	{
	echo $this->mdl->deletePeserta();
	}function setStatus()
	{
	echo $this->mdl->setStatus();
	}
	function acc($id)
	{
		$event=$this->idEvent;
	echo $this->mdl->acc($id,$event);
	}function not($id)
	{
	echo $this->mdl->not($id);
	}function acc2($id)
	{
		$event=$this->idEvent;
	echo $this->mdl->acc2($id,$event);
	}function not2($id)
	{
	echo $this->mdl->not2($id);
	}
	function updatedCheckIn()
	{
	$this->load->view("UpdatedCheckIn");
	}
	function exportPeserta($id)
	{
	$this->load->library("PHPExcel");
	$this->mdl->exportPeserta($id);
	}
	
	function download_template()
	{
	$id=$this->idevent;
	$this->load->library("PHPExcel");
	$this->mdl->download_template($id);
	}
	
	function modeEvent($id)
	{
	$iduser=$this->session->userdata("id");
	$this->db->where("id_admin",$iduser);
	$this->db->where("id_event",$id);
	$this->session->set_userdata(array("reg"=>$id));
	return $this->db->update("data_event",array("mode"=>"0"));
	}
	function upload_file()
	{	$id=$this->idevent;
		if($this->input->post("hapus")==1)
		{
		$this->mdl->deleteAllPeserta($id);
		$iduser=$this->session->userdata("id");
		$this->db->where("id_admin",$iduser);
		$this->db->where("id_event",$id);
		$this->db->delete("data_peserta");
		}
		$mode=$this->input->get_post("mode");
		$data=$this->mdl->do_upload_file($id,$mode);
		$data=explode("-",$data);
		
               ?><hr>
			 
                <table class="table col-black table-hover table-bordered" >
			        <?php echo "<tr><td>PAGI</td><td>:</td><td>".$data[0]."</td></tr>"; ?>
			       <?php echo "<tr><td>SORE</td><td>:</td><td>".$data[1]."</td></tr>"; ?>
					<?php echo "<tr><td>Diupdate</td><td>:</td><td>".$data[2]."</td></tr>"; ?>
                </table>
                <?php
    }
	function upload_file_barcode()
	{
		$jml=$this->input->post("jml");
		for($i=1;$i<=$jml;$i++)
		{
			$this->buildBarcode();
		}
		echo "true";
	}
	function buildBarcode()
	{
					$like=$this->db->query("SHOW TABLE STATUS LIKE 'data_barcode'")->row();
					$additional=substr(str_shuffle("123456789"),0,5);
					$kode=$additional.sprintf("%05s", $like->Auto_increment);
					$this->db->set("ip",$kode);
					$this->db->set("kode_registrasi",$kode);
					$this->db->insert("data_barcode");
					return $this->m_reff->qr($kode);
	}
	
	function upload_file_khusus()
	{	$id=$this->idevent;
		$mode=$this->input->get_post("mode");
		$data=$this->mdl->do_upload_file_khusus($id,$mode);
		$data=explode("-",$data);$no_surat="Tidak ada";
		if(isset($data[2])){
			$no_surat="No Surat : ".$data[3];
		}
               ?><hr>
	 
                <table class="table col-black table-hover table-bordered" >
			       <?php echo "<tr><td>PAGI</td><td>:</td><td>".$data[0]."</td></tr>"; ?>
			       <?php echo "<tr><td>SORE</td><td>:</td><td>".$data[1]."</td></tr>"; 
				   if($data[3]){
				   echo "<tr><td>DATA DOUBLE</td><td>:</td><td>".$no_surat."</td></tr>"; } 
				   if($data[4]){
				   echo "<tr><td>MASALAH </td><td>:</td><td>Nomor surat ada yg kosong</td></tr>"; }
				   if($data[5]){
				   echo "<tr><td>MASALAH </td><td>:</td><td>Nama File ada yg kosong</td></tr>"; } 
				   if($data[6]){
				   echo "<tr><td>MASALAH </td><td>:</td><td>Blok pagi ada yg kosong No.".$data[6]."</td></tr>"; } 
				   if($data[7]){
				   echo "<tr><td>MASALAH </td><td>:</td><td>Blok sore ada yg kosong No.".$data[7]." </td></tr>"; } ?>
				 
                </table>
                <?php
    }
 
	function downloadData()
	{ 
		$namaFile = "data.json"; 
		header("Content-type: text/plain");
	 	header("Content-Disposition: attachment; filename=".$namaFile); 
		$query = "SELECT kode_registrasi,jenis,gate FROM data_peserta where status='2' and jenis='1'"; 
		$hasil = $this->db->query($query)->result();
		$val=array();$n=1;$kode="";$gate="";
		foreach ($hasil as $data)
		{
			$kode.=$data->kode_registrasi."::".$data->gate.",";
		//	$gate.="'".$data->gate."',";
			
		}
		$kode=substr($kode,0,-1);
		//$gate=substr($gate,0,-1);
		if($kode){
		$val[]=array("reg"=>$kode,"jenis"=>1,"gate"=>$gate);
		}
		
		$query = "SELECT kode_registrasi,jenis,gate FROM data_peserta where status='2' and jenis='2'"; 
		$hasil = $this->db->query($query)->result();
		 $kode="";
		foreach ($hasil as $data)
		{
			$kode.=$data->kode_registrasi."::".$data->gate.",";
		//	$gate.="'".$data->kode_registrasi."',";
		}
		$kode=substr($kode,0,-1);
		//$gate=substr($gate,0,-1);
		if($kode){
		$val[]=array("reg"=>$kode,"jenis"=>2,"gate"=>$gate);
		}
		
		echo json_encode($val); 
	 	
	}
 
}

