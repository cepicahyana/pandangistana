<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_user extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->load->model('M_data_user','data_user');
		$this->load->model('m_profile','profile');
		$this->m_konfig->validasi_session(array("admin"));
	}
	
	function _template($data)
	{
	$this->load->view('template/main',$data);	
	}
	
	public function index()
	{
	$data['konten']="data_user";
	$data['dataProfil']=$this->data_user->dataProfile(3);
	$this->_template($data);
	}
	function konfig()
	{
	$data['konten']="konfig";
	$data['dataProfil']=$this->data_user->dataProfile($this->session->userdata("id"));
	$this->_template($data);
	}
	
	function menu($id)
	{
	$data['konten']="menu";
	$data['dataProfil']=$this->data_user->dataProfileLevel($id);
	$this->_template($data);
	}
	function manajemen()
	{
	$this->index();
	}
	function cekID($id)
	{
	$this->db->where("id_menu",$id);
	echo $this->db->get("main_menu")->num_rows();
	}
	function updateKonfig()
	{
	$this->data_user->updateKonfig();
	redirect("data_user/konfig");
	}	
	function editMenu($id)
	{
	$data=$this->data_user->editMenu($id);
	echo json_encode($data);
	}
	
	function updateMenu()
	{
	$level=$this->input->post("Level");
	if($level==2){	$this->data_user->updateIdMain($this->input->post("Induk")); }
	echo $this->data_user->updateMenu();
	}
	function hapus_UG($id)
	{
	$this->data_user->hapus_UG($id);
	redirect("data_user/manajemen");
	}
	
	
	
	
	function menuLevel1($id,$val)
	{
	$dataMenu=$this->db->query("select * from main_menu where level='1' and hak_akses ='".$id."' ");
		  $dt="";
		  foreach($dataMenu->result() as $op)
		  {
		  $dt[$op->id_menu]=$op->nama;
		  }
		  $array=$dt;
	echo form_dropdown("Induk",$array,$val,"class='form-control'");
	}
	
	function profile_admin()
	{
	$data['konten']="profile_admin";
	$data['dataProfil']=$this->profile->dataProfile(3);
	$this->_template($data);
	}
	
	function add_dataUser()
	{
	$data=$this->profile->add_dataUser();
	echo json_encode($data);
	}
	
	function update_profile($id)
	{
	$data=$this->profile->update($id);
	echo json_encode($data);
	}
	public function upload_img()
	{
	$this->profile->upload_img(3);
	redirect("data_user/profile_admin");
	}
	
	
	function getUG($id)
	{
	$data=$this->data_user->getUG($id);
	echo json_encode($data);
	}
	function getDataUg($id)
	{
	 $dataMenu=$this->db->get("main_level");
		  $dt="";
		  foreach($dataMenu->result() as $op)
		  {
		  $dt[$op->id_level]=$op->nama;
		  }
		  $array=$dt;
	echo form_dropdown("Hak",$array,$id,'style="width:380px" id="sel2"');
	}
	//<!----------------------------------------------------------------------------------------->
	
	function jmlEvent($id)
	{
	$this->db->where("id_admin",$id);
	return $this->db->get("data_event")->num_rows();
	}
	function jmlForm($id)
	{
	$this->db->where("id_admin",$id);
	return $this->db->get("data_form")->num_rows();
	}
	function jmlInvoice($id)
	{
	$this->db->where("id_admin",$id);
	return $this->db->get("data_invoice")->num_rows();
	}
	function ajax_open()
	{
			
		$list = $this->data_user->get_open();
		$data = array();
		$no = $_POST['start'];
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
			$row = array();
			$row[] = "<span class='size'>".$no++."</span>";
			$row[] = "<span class='size'><a target='_blank' href='".base_url()."/file_upload/dp/".$dataDB->poto."'><img width='30px' src='".base_url()."/file_upload/dp/".$dataDB->poto."'></a></span>";
			$row[] = "<span class='size'>".$dataDB->owner."</a></span>";
			$row[] = "<span class='size'>".$dataDB->telp."</span>";
			$row[] = "<span class='size'>".$dataDB->email."</span>";
			$row[] = "<span class='size'>".$dataDB->alamat."</span>";
			$row[] = "<span class='size'>".$dataDB->tgl."</span>";
			$row[] = "<a href='javascript:saldo(".$dataDB->id_admin.")'><span class='size'>".number_format($dataDB->saldo,0,",",".")."</span></a>";
			$row[] = "<span class='size'>".$this->jmlEvent($dataDB->id_admin)."</span>";
			$row[] = "<span class='size'>".$this->jmlForm($dataDB->id_admin)."</span>";
			$row[] = "<span class='size'>".$this->jmlInvoice($dataDB->id_admin)."</span>";
			
			$now='<a class="table-link danger" href="javascript:void()" title="chat" onclick="chat('.$dataDB->id_admin.')">
			<span class="fa-stack"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-weixin fa-stack-1x fa-inverse"></i>
			</span> </a>';
			
			$ada='<a class="label label-danger	" href="javascript:void()" title="chat" onclick="chat('.$dataDB->id_admin.')"> Check </a>';
					
			$cekChat=$this->data_user->cekChatId($dataDB->id_admin);	
			if($cekChat){ $chat=$ada; } else { $chat=$now; };	
			//add html for action
			$row[] = '
			'.$chat.'	
			<a class="table-link" href="javascript:void()" title="Edit" onclick="edit('.$dataDB->id_admin.')">
			<span class="fa-stack"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
			</span> </a>
			
			
			<a class="table-link" href="javascript:void()" title="Hapus" onclick="deleted('.$dataDB->id_admin.')">
			<span class="fa-stack"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
			</span> </a>';		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->data_user->count_file("admin"),
						"recordsFiltered" =>$this->data_user->count_filtered('admin'),
						"data" => $data,
						);
		//output to json format
		echo json_encode($output);

	}
	
	function ajax_edit($id)
	{
	$data=$this->data_user->getDataUser($id);
	echo json_encode($data);
	}	
	
	function deleted_UG($id)
	{
	$this->data_user->deleted_Event($id);
	$this->data_user->deleted_Peserta($id);
	$this->data_user->deleted_Chat($id);
	$this->data_user->deleted_Form($id);
	$this->data_user->deleted_Invoice($id);
	$this->data_user->deleted_Payment($id);
	$this->data_user->deleted_tampungForm($id);
	$this->data_user->deleted_Formulir($id);
	$data=$this->data_user->deleted_UG($id);
	echo json_encode($data);
	}
	//----------------------------------------------------------->
	function modalChat($id)
	{
	$this->data_user->updateStatusChat($id);
	$data['id_admin']=$id;
	$data['dataChat']=$this->data_user->dataChat($id);
	$this->load->view("chating",$data);
	}
	function sendChat($id)
	{
	$chat=$this->input->post("chat");
	$this->data_user->sendChat($chat,$id);
	$data['dataChat']=$this->data_user->dataChatMax($id);
	$this->load->view("liveChat",$data);
	}	
	function loadChat($id)
	{
	$data['id']=$id;
	$this->load->view("loadChat",$data);
	}
	//------------------------------------------------------------>
	function ceksaldo($id)
	{
	$this->db->where("id_admin",$id);
	$data=$this->db->get("admin")->row();
	echo json_encode($data);
	}	
	function saveSaldo()
	{
	$this->db->where("id_admin",$this->input->post("id"));
	$data=$this->db->update("admin",array("saldo"=>$this->input->post("saldo")));
	echo json_encode($data);
	}
}

