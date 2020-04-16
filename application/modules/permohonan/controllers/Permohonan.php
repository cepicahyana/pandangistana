<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permohonan extends CI_Controller {

	  
	function __construct()
	{
		parent::__construct();	
		$this->load->model('m_model','mdl');
		$this->m_konfig->validasi_session(array("user","registrasi"));
		
		date_default_timezone_set("Asia/Jakarta");
	}
	 
	
	function _template($data)
	{
	$this->load->view('temp_user/main',$data);	
	}
	 	
	function form_filter()
	{
	$this->load->view('form_filter');	
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
	public function persus()
	{
		 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("persus");
		}else{
			$data['konten']="persus";
			$this->_template($data);
		}
		 
	}

	function online()
	{
		$this->index();
	}
	
	function detail_peserta_persus(){
		echo $this->load->view("getDetailPesertaPersus");
	}

	function edit_peserta_persus(){
		echo $this->load->view("getEditPesertaPersus");
	}

	function update_peserta_persus(){
		echo $this->mdl->update_peserta_persus();
	}

	function delete_peserta_persus(){
		echo $this->mdl->delete_peserta_persus();
	}

	function detail_peserta_online(){
		echo $this->load->view("getDetailPesertaOnline");
	}

	function edit_peserta_online(){
		echo $this->load->view("getEditPesertaOnline");
	}

	function update_peserta_online(){
		echo $this->mdl->update_peserta_online();
	}

	function delete_peserta_online(){
		echo $this->mdl->delete_peserta_online();
	}

	function ajax_peserta()
	{
		$list = $this->mdl->get_peserta();
		$data = array();
		$no = $_POST['start'];
		$no =$no+1;
		 
		 
		 
		foreach ($list as $dataDB) {
		////
		 
			$row = array();
			if($dataDB->diterima_oleh){
			    $row[] ="";
			}else{
			  $row[] = ' 
			 
			  <input type="checkbox" id="md_checkbox_'.$dataDB->id.'"   class="pilih filled-in chk-col-red" onclick="pilcek()"  name="pilih[]"  value="'.$dataDB->id.'" />
                                <label for="md_checkbox_'.$dataDB->id.'">&nbsp;</label>';
			}
			
			$row[] = "<span class='size'>".$no++."</span>";
			 
			 
			$button	=	"";
			 
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
			
			$dispo="  Belum";
			if($dataDB->jenis_acara==1){
			$acara="<span class='text-black'>Pagi</span>";
				if($dataDB->blok1){
					$dispo="  <span class='text-primary'>Sudah</span>";
				}
			}elseif($dataDB->jenis_acara==2){
				$acara="<span class='text-black'>Sore</span>";
				if($dataDB->blok2){
					$dispo="  <span class='text-primary'>Sudah</span>";
				}
			}else{ $acara="<span class='text-black'>Pagi & Sore</span>";	
			
				if($dataDB->blok1 and $dataDB->blok2){
					$dispo="  <span class='text-primary'>Sudah</span>";
				}
				
				}
			
			if($dataDB->jadwal_distribusi)
			{
				$jadwal		=	$this->tanggal->hariLengkap($dataDB->jadwal_distribusi,"/");
				$disbutton	=	"";
			}else{
				$jadwal	=	"-";
				$disbutton	=	"disabled";
			}
			
			if($dataDB->diterima_oleh)
			{
				$nama_pengambil	=	"<span class='text-success'>oleh: ".$dataDB->diterima_oleh."</span>";
				$pengambilan	=	$this->tanggal->eng3($dataDB->diterima_tgl,"/");
				$href			=	"";
			
			}else{
				$pengambilan	=	"-";
				$nama_pengambil	=	"";
				$href			=	"";
				 
			}
			
			
			if($dataDB->jadwal_distribusi and $dataDB->diterima_oleh)
			{
				$button			=	'<div class=" ">
											<button aria-expanded="false" class="btn-block btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
												<b>Action</b>
											</button>
											<ul style="position: absolute; transform: translate3d(0px, 43px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-start" class="dropdown-menu" role="menu">
												<li>
												  
													<a class="dropdown-item" href="javascript:detail(`'.$dataDB->id.'`)">Detail</a>
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_edit" onclick="edit_peserta_online(`'.$dataDB->id.'`)">
														Edit
													</a>
												</li>
											</ul>

										</div>';
			}elseif($dataDB->jadwal_distribusi and !$dataDB->diterima_oleh){
			$button			=	'<div class=" ">
											<button aria-expanded="false" class="btn-block btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
												<b>Action</b>
											</button>
											<ul style="position: absolute; transform: translate3d(0px, 43px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-start" class="dropdown-menu" role="menu">
												<li>
												 
												 
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_detail" onclick="detail_peserta_online(`'.$dataDB->id.'`)">Detail</a>
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_edit" onclick="edit_peserta_online(`'.$dataDB->id.'`)">
														Edit
													</a>
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_delete" onclick="getId(`'.$dataDB->id.'`)" >
														Hapus
													</a> 													
													
												</li>
											</ul>

										</div>';
			}else 
			{
				$button			=	'<div class=" ">
											<button aria-expanded="false" class="btn-block btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
												<b>Action</b>
											</button>
											<ul style="position: absolute; transform: translate3d(0px, 43px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-start" class="dropdown-menu" role="menu">
												<li>
												  
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_detail" onclick="detail_peserta_online(`'.$dataDB->id.'`)">Detail</a>
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_edit" onclick="edit_peserta_online(`'.$dataDB->id.'`)">
														Edit
													</a>
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_delete" onclick="getId(`'.$dataDB->id.'`)" >
														Hapus
													</a> 
													
												</li>
											</ul>

										</div>';
			}
			
			$nama			=	$dataDB->nama;
			$kab			=	$this->m_reff->goField("wil_kabupaten","nama","where id_kab='".substr($dataDB->nik,0,4)."' ");
			$prov			=	$this->m_reff->goField("wil_provinsi","nama","where id_prov='".substr($dataDB->nik,0,2)."' ");
			$row[]			= 	$nama.br()."<span class='text-primary'>".strtolower($kab)." -".$prov."</span>";
			$row[]			= 	$acara;
			$row[]			= 	$dispo;
			 $row[]			= 	$jadwal;
			 $row[]			= 	$nama_pengambil.br().$pengambilan;
			 $row[]			= 	$button;
		 
		 
			$data[] 		= 	$row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mdl->count_file_peserta("data_peserta"),
						"recordsFiltered" =>$this->mdl->count_file_peserta('data_peserta'),
						"data" => $data,
						);
		//output to json format
		echo json_encode($output);
	}
	
	
	function ajax_persus()
	{
		$list = $this->mdl->get_persus();
		$data = array();
		$no = $_POST['start'];
		$no =$no+1;
		 
		 
		 
		foreach ($list as $dataDB) {
		////
		 
			$row = array();
			 
			
			$row[] = "<span class='size'>".$no++."</span>";
			 
			 
			$button	=	"";
			 
			if($dataDB->nama)
			{
				$natam=$dataDB->nama;
			}else{
				$natam="---";
			}
			
					
			
			 if($dataDB->sts_dispo==1)
			{	 
			 $dispo="<span class='text-success fas fa-check-double' ></span> <span class='text-success' onclick='getDispo(`".$dataDB->id."`)'>Sudah</span>";
			}elseif($dataDB->sts_dispo==2){
			$dispo="<button class='cursor' onclick='getDispo(`".$dataDB->id."`)'>Belum</button>";
			}elseif($dataDB->sts_dispo==3){
			$dispo="<button class='cursor bg-orange' onclick='getDispo(`".$dataDB->id."`)'>Draft</button>";
			}				
			 
			
			 
				$jadwal	=	"-";
				$disbutton	=	"disabled";
			 
			if($dataDB->diterima_oleh)
			{
				$nama_pengambil	=	"<span class='text-success'>oleh: ".$dataDB->diterima_oleh."</span>";
				$pengambilan	=	$this->tanggal->eng3($dataDB->diterima_tgl,"/");
				$href			=	"";
			
			}else{
				$pengambilan	=	"-";
				$nama_pengambil	=	"";
				$href			=	"";
				 
			}
			
			
			if($dataDB->diterima_oleh  )
			{
				$button			=	'<div class=" ">
											<button aria-expanded="false" class="btn-block btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
												<b>Action</b>
											</button>
											<ul style="position: absolute; transform: translate3d(0px, 43px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-start" class="dropdown-menu" role="menu">
												<li>
												  
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_detail" onclick="detail_peserta_persus(`'.$dataDB->id.'`)">Detail</a>
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_edit" onclick="edit_peserta_persus(`'.$dataDB->id.'`)">
														Edit
													</a>
												</li>
											</ul>

										</div>';
			}elseif(  !$dataDB->diterima_oleh){
			$button			=	'<div class=" ">
											<button aria-expanded="false" class="btn-block btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
												<b>Action</b>
											</button>
											<ul style="position: absolute; transform: translate3d(0px, 43px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-start" class="dropdown-menu" role="menu">
												<li>
												  
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_detail" onclick="detail_peserta_persus(`'.$dataDB->id.'`)">Detail</a>
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_edit" onclick="edit_peserta_persus(`'.$dataDB->id.'`)">
														Edit
													</a>
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_delete" onclick="getId(`'.$dataDB->id.'`)" >
														Hapus
													</a> 													
													
												</li>
											</ul>

										</div>';
			}else 
			{
				$button			=	'<div class=" ">
											<button aria-expanded="false" class="btn-block btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
												<b>Action</b>
											</button>
											<ul style="position: absolute; transform: translate3d(0px, 43px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-start" class="dropdown-menu" role="menu">
												<li>
												  
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_detail" onclick="detail_peserta_persus(`'.$dataDB->id.'`)">Detail</a>
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_edit" onclick="edit_peserta_persus(`'.$dataDB->id.'`)">
														Edit
													</a>
													<a class="dropdown-item" href="javascript:(0)" data-toggle="modal" data-target="#mdl_delete" onclick="getId(`'.$dataDB->id.'`)" >
														Hapus
													</a> 													
												</li>
											</ul>

										</div>';
			}
			if($dataDB->jenis_permohonan==2)
			{
				$jenis_permohonan="Persus";
			}else{
				$jenis_permohonan="Given";
			}
			
			$nama			=	$dataDB->nama;
			 $row[]			= 	$nama;
			 $row[]			= 	$dataDB->jml_pagi;
			 $row[]			= 	$dataDB->jml_sore;
			 $row[]			= 	$dispo;
			 
			 $row[]			= 	$nama_pengambil.br().$pengambilan;
			 $row[]			= 	$jenis_permohonan;
			 $row[]			= 	$button;
		 
		 
			$data[] 		= 	$row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mdl->count_file_persus("data_peserta"),
						"recordsFiltered" =>$this->mdl->count_file_persus('data_peserta'),
						"data" => $data,
						);
		//output to json format
		echo json_encode($output);
	}
	
	
	
	function dataProvinsi()
	{	$query_data="";
		$s=$this->input->get_post("search");
		if($s)
		{	 
			$this->db->like("nama",$s); 
		}
		
			$this->db->order_by("nama","asc");
			$query=$this->db->get("wil_provinsi")->result();
		 
			foreach($query as $v)
			{
				$query_data[]=["id"=>$v->id_prov,"text"=>$v->nama];
			}
		 
	echo	  json_encode($query_data);
	}
	function form_kab()
	{
		$prov	=	$this->input->get_post("val");
		$this->db->where("id_prov",$prov);
		$this->db->order_by("nama","asc");
		$data=$this->db->get("wil_kabupaten")->result();
		$db[null]="---- semua kab/kota ----";
		foreach($data as $data)
		{
			$db[$data->id_kab]=$data->nama;
		}
		echo form_dropdown("fkab",$db,"","id='fkab' class='form-control' ");
	}
	function getDispoPersus()
	{
		$this->load->view("getDispoPersus");
	}
	
	function setBlokPersus()
	{
		$data	= $this->mdl->setBlokPersus();
		echo json_encode($data);
	}
	function setStatus()
	{
	echo $this->mdl->setStatus();
	}
	function hapus_cek()
	{
	    echo $this->mdl->hapus_cek();
	}
	function broadcast()
	{
	    $this->load->view("broadcast");
	}
	function setBroadcast()
	{
	$echo=$this->mdl->setBroadcast();
	//echo json_encode($echo);
	echo "<table class='entry'><tr>
	<td>Notifikasi Terkirim</td><td>".$echo["ok"]."</td>
	</tr><tr>
	<td valign='top'>Gagal Terkirim</td><td>".$echo["gagal"]."<br>".$echo["dgagal"]."</td>
	</tr></table>";
	}
}

