<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun extends CI_Controller {

	 
	var $tbl="admin";
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("user"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	 
	function _template($data)
	{
	$this->load->view('temp_user/main',$data);	
	}
	function verifikator()
	{
		$this->index();
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
	 public function distributor()
	{
		 	
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("distributor");
		}else{
			$data['konten']="distributor";
			$this->_template($data);
		}
		
	}
	 
	 
	
	 
	///-----------------------SISWA--------------------------///
 
	 
	
	///-----------------------mitra PENILIAAN--------------------------///
	function getData()
	{
		$list = $this->mdl->get_data();
		$data = array();
		$no = $_POST['start'];
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
	 
		 $tombol='<div class="demo-button-groups">
                                <div class="btn-group" role="group">
                                    <button type="button" onclick="edit(`'.$dataDB->id_admin.'`)" class="btn btn-primary btn-sm waves-effect waves-light">EDIT</button>
                                    <button type="button" onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="btn btn-danger btn-sm waves-effect waves-light">HAPUS</button>
                                    
                                </div>
                                
                            </div>';
			 		
							 
		 
			$row = array();
			$row[] = "<span class='size'>".$no++."</span>";	
			$row[] = "<span class='size'>  ".$dataDB->owner." </span>";
			$row[] = "<span class='size'>  ".$dataDB->telp."   </span>";
 
			$row[] = "<span class='size'>  ".$dataDB->username."   </span>";
		 
			 
			$row[] = $tombol;
		  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $c=$this->mdl->count(),
						"recordsFiltered" =>$c,
						"data" => $data,
						);
		//output to json format
		echo json_encode($output);

	}
	
	 
	//-------------------------------------------------END SISWA------------------------------------//
	function idu()
	{
		return $this->session->userdata("id");
	}
	  
	 
	function viewAdd()
	{
		echo $this->load->view("viewAdd");
	}
	function viewEdit()
	{
		echo $this->load->view("viewEdit");
	}
	function insert($level)
	{
		echo json_encode($this->mdl->insert($level));
	}
	function update()
	{
		echo json_encode($this->mdl->update());
	}
	function set()
	{
		echo $this->mdl->set();
	}
	
	
	function hapus()
	{
		$id=$this->input->post("id");
		echo $this->mdl->hapus($id);
	}
	 
	function save_bursa()
	{
	$data=$this->mdl->save_bursa();
	echo json_encode($data);
	}
	function hapus_bursa()
	{
	$data=$this->mdl->hapus_bursa();
	echo json_encode($data);
	}
}