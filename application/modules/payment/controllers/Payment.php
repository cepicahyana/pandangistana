<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->load->model('m_payment','payment');
		$this->m_konfig->validasi_session(array("user"));
		date_default_timezone_set("Asia/Jakarta");
	}
	
	function _template($data)
	{
	$this->load->view('template/main',$data);	
	}
	function warning($hal)
	{
	$data['hal']=$hal;
	$this->load->view("warning",$data);
	}
	function invoice($id)
	{
	$this->load->view("invoice");
	}
	public function konfirm()
	{

	$data['konten']="konfirm";
	$data['dataInvoice']=$this->payment->dataInvoice();
	$this->load->view("konfirm",$data);
	}
	function saveKonfirm()
	{
	echo $this->payment->saveKonfirm();
	}
	public function index()
	{

	$data['konten']="payment.php";
	$this->_template($data);
	}
	
	function tampil($id)
	{
	$data['idForm']=$id;
	$this->load->view('tampilpayment',$data);
	}
	
	function loadData()
	{
	$this->load->view('viewpayment');
	}
	function delpayment($id)
	{
	echo $this->payment->delpayment($id);
	}
	
	function addpayment()
	{
	$data=$this->payment->addpayment();
	echo $data;
	}
	
	public function mypayment()
	{

	$data['konten']="mypayment";
	$this->_template($data);
	}
	public function saldo()
	{

	$data['konten']="saldo";
	$this->_template($data);
	}
	
	function finishadd()
	{
		echo $this->payment->finishadd();
	}
	
	function ajax_open()
	{
		$con=new konfig(); $dp=$con->dataProfile($this->session->userdata("id"));
		$list = $this->payment->get_open();
		$data = array();
		$no = $_POST['start'];
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
		if($dataDB->status=="belum") { $status="Belum dibayar"; }else { $status=$dataDB->status;};
		
		$jt=$this->tanggal->eng(substr($dataDB->created,0,10),"/");
		if($dataDB->status=="lunas") {
		$del="|	<a href='javascript:deleted(".$dataDB->id_invoice.")'><i class='fa fa-trash'></i> Delete</a>"; }
		else{	$del="";}
		
			$row = array();
			$row[] = "<span class='size'>".$no++."</span>";
			$row[] = "<span class='size'><a href='".base_url()."payment/invoice/".$dataDB->id_invoice."' target='new'>".$dataDB->nomor_invoice."</a></span>";
			$row[] = "<span class='size'>".$dataDB->title."</span>";
			$row[] = "<span class='size'>".$this->tanggal->eng(substr($dataDB->created,0,10),"/")."</span>";
			$row[] = "<span class='size'>".$jt."</span>";
			$row[] = "<span class='size'>Rp ".number_format(($dataDB->quota*$dataDB->tarif+500)-$dataDB->alokasi_saldo,0,",",".")."</span>";
			$row[] = "<span class='size'>".$status."</span>";
			$row[] = "<span class='size'>
			<a href='".base_url()."payment/invoice/".$dataDB->id_invoice."' target='new'><i class='fa fa-file'></i> lihat</a>
			".$del."			
			</span>";
							
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->payment->count_file("data_invoice"),
						"recordsFiltered" =>$this->payment->count_filtered('data_invoice'),
						"data" => $data,
						);
		//output to json paymentat
		echo json_encode($output);

	}
	
	function deleteInvoice($id)
	{
	echo $this->payment->deleteInvoice($id);
	}
}

