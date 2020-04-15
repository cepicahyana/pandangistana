<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_event extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->load->model('m_data_event','data_event');
		$this->m_konfig->validasi_session(array("admin"));
		date_default_timezone_set("Asia/Jakarta");
	}
	
	function _template($data)
	{
	$this->load->view('template/main',$data);	
	}

	public function index()
	{

	$data['konten']="data_event";
	$this->_template($data);
	}
	

	function ajax_open()
	{
		
		$list = $this->data_event->get_open();
		$data = array();
		$no = $_POST['start'];
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
		$con=new konfig(); $dp=$con->dataProfile($dataDB->id_admin);
		
		$aksi1='<div class="input-group-btn">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Diizinkan<span class="caret"></span></button>
		<ul class="dropdown-menu">
		<li><a href="javascript:cekal('.$dataDB->id_event.')" >Cekal</a></li>
		<li><a href="javascript:deleted(`'.$dataDB->id_event.'`,`'.$dataDB->id_admin.'`)">Delete</a></li>
		</ul>
		</div>';
		$aksi0='<div class="input-group-btn">
		<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Cekal <span class="caret"></span></button>
		<ul class="dropdown-menu">
		<li><a href="javascript:izinkan('.$dataDB->id_event.')">Izinkan</a></li>
			<li><a href="javascript:deleted(`'.$dataDB->id_event.'`,`'.$dataDB->id_admin.'`)">Delete</a></li>
		</ul>
		</div>';
		if($dataDB->validasi==1){ $validasi=$aksi1; } else{ $validasi=$aksi0; };
		
		
		$jt=$this->tanggal->eng(substr($dataDB->startdate,0,10),"/");
		$jt=$this->tanggal->tambahTgl($jt,2);
		//$jt=$this->tanggal->eng($jt,"/");
		$tglskrg=date('Y-m-d');
		$jt=$this->tanggal->eng($tglskrg,"/");
		
		
			$row = array();
			$row[] = "<span class='size'>".$no++."</span>";
			$row[] = "<span class='size'>".$dp->owner."</span>";
			$row[] = "<span class='size'>".$dataDB->title."</span>";
			$row[] = "<span class='size'>".$dataDB->lokasi."</span>";
			$row[] = "<span class='size'>".$this->tanggal->aturHari($dataDB->startdate,$dataDB->enddate,"/","s/d")."</span>";
			$row[] = "<span class='size'>".$dataDB->quota."</span>";
			$row[] = "<span class='size'>".$this->data_event->jmlPeserta($dataDB->id_event)."</span>";
			$row[] = "<span class='size'>".$validasi."</span>";
							
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->data_event->count_file("data_event"),
						"recordsFiltered" =>$this->data_event->count_filtered('data_event'),
						"data" => $data,
						);
		//output to json paymentat
		echo json_encode($output);

	}
	
	

	function izinkan($id)
	{
	$this->db->where("id_event",$id);
	echo $this->db->update("data_event",array("validasi"=>"1"));
	}
	
	function cekal($id)
	{
	$this->db->where("id_event",$id);
	echo $this->db->update("data_event",array("validasi"=>"0"));
	}
	
	function deletedEvent($idEvent,$idAdmin)
	{
	echo $this->data_event->delete($idEvent,$idAdmin);
	}
}

