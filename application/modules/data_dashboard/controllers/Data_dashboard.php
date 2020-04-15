<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_dashboard extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->load->model('M_data_dashboard','dashboard');
		$this->m_konfig->validasi_session(array("admin"));
	
	}
	function notifikasi()
	{
	$this->load->view("notifikasi");
	}
	function _template($data)
	{
	$this->load->view('template/main',$data);	
	}
	
	public function index()
	{

	$data['konten']="dashboard";
	$this->_template($data);
	}
	function detailEventModal($id)
	{
	$data['id']=$id;
	$this->load->view('detailEvent',$data);	
	}
	
	function process()
	{
	/////////////
//	date_default_timezone_set("Asia/Jakarta");
	$type = $_POST['type'];

	if($type == 'new')
	{
		$startdate = $_POST['startdate'].'+'.$_POST['zone'];
		$title = $_POST['title'];
		$insert ="INSERT INTO data_event(`title`, `startdate`, `enddate`, `allDay`) VALUES('$title','$startdate','$startdate','false')";
		$lastid = $this->db->query($insert);
		echo json_encode(array('status'=>'success','eventid'=>$lastid));
	}

	if($type == 'changetitle')
	{
		$eventid = $_POST['eventid'];
		$title = $_POST['title'];
		$update = $this->db->query("UPDATE data_event SET title='$title' where id_event='$eventid'");
		if($update)
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	if($type == 'resetdates')
	{
		$title = $_POST['title'];
		$startdate = $_POST['start'];
		$enddate = $_POST['end'];
		$eventid = $_POST['eventid'];
		$update = $this->db->query("UPDATE data_event SET title='$title', startdate = '$startdate', enddate = '$enddate' where id_event='$eventid'");
		if($update)
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	if($type == 'remove')
	{
		$eventid = $_POST['eventid'];
		$delete = $this->db->query("DELETE FROM data_event where id_event='$eventid'");
		if($delete)
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	if($type == 'fetch')
	{
		$events = array();
		$fetch = $this->db->query("SELECT * FROM data_event")->result();
		foreach($fetch as $fetch)
		{
		$e = array();
		$e['id'] = $fetch->id_event;
		$e['title'] = $fetch->title;
		$e['start'] = $fetch->startdate;
		$e['end'] = $fetch->enddate;

		$allday = ($fetch->allDay == "true") ? true : false;
		$e['allDay'] = $allday;

		array_push($events, $e);
		}
		echo json_encode($events);
	}

/////////
	}
	
	//--------------------------->
	
}

