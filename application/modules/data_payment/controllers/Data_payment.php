<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_payment extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->load->model('m_data_payment','payment');
		$this->m_konfig->validasi_session(array("admin"));
		date_default_timezone_set("Asia/Jakarta");
	}
	
	function _template($data)
	{
	$this->load->view('template/main',$data);	
	}
	function warning()
	{
	$this->load->view("warning");
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

	$data['konten']="payment";
	$this->_template($data);
	}
	

	

	function delpayment($id)
	{
	echo $this->payment->delpayment($id);
	}
	

	public function saldo()
	{

	$data['konten']="saldo";
	$this->_template($data);
	}
	

	private function _quota($id)
	{
	$data=$this->db->query("select quota from data_event where id_event='".$id."'")->row();
	return $data->quota;
	}
	private function _title($id)
	{
	$data=$this->db->query("select title from data_event where id_event='".$id."'")->row();
	return isset($data->title)?($data->title):"has deleted"; 
	}	
	function ajax_open()
	{
		
		$list = $this->payment->get_open();
		$data = array();
		$no = $_POST['start'];
		$no =$no+1;
			$con=new konfig();
		foreach ($list as $dataDB) {
		////
		$dp=$con->dataProfile($dataDB->id_admin);
		
		$proses='<div class="input-group-btn">
		<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Pending<span class="caret"></span></button>
		<ul class="dropdown-menu">
		<li><a href="javascript:acc('.$dataDB->id_invoice.')" >Aprov</a></li>
		<li><a href="javascript:can('.$dataDB->id_invoice.')">Cancel</a></li>
		<li><a href="javascript:del('.$dataDB->id_invoice.')">Delete</a></li>
		</ul>
		</div>';
		$lunas='<div class="input-group-btn">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">'.$dataDB->status.' <span class="caret"></span></button>
		<ul class="dropdown-menu">
		<li><a href="javascript:can('.$dataDB->id_invoice.')">Cancel</a></li>
		<li><a href="javascript:del('.$dataDB->id_invoice.')">Delete</a></li>
		</ul>
		</div>';
		
		
		if($dataDB->status=="belum") { $status="Belum di bayar";}elseif($dataDB->status=="proses") { $status=$proses;}else{ $status=$lunas;};
		
		$jt=$this->tanggal->eng(substr($dataDB->created,0,10),"/");
		$jt=$this->tanggal->tambahTgl($jt,2);
		//$jt=$this->tanggal->eng($jt,"/");
		$tglskrg=date('Y-m-d');
		$jt=$this->tanggal->eng($tglskrg,"/");
		
		
			$row = array();
			$row[] = "<span class='size'>".$no++."</span>";
			$row[] = "<span class='size'>".$dp->owner."</span>";
			$row[] = "<span class='size'><a target='_blank' href='".base_url()."data_payment/invoice/".$dataDB->id_invoice."/".$dataDB->id_admin."'>".$dataDB->nomor_invoice."</a></span>";
			$row[] = "<span class='size'>".$this->_title($dataDB->id_data_event)."</span>";
			$row[] = "<span class='size'>".$this->tanggal->eng(substr($dataDB->created,0,10),"/")."</span>";
			$row[] = "<span class='size'>".$jt."</span>";
			$row[] = "<span class='size'>Rp ".number_format($this->_quota($dataDB->id_data_event)*$dp->price+250,0,",",".")."</span>";
			$row[] = "<span class='size'>".$dataDB->status."</span>";
							
			
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
	
	/*------------------------------------------------------------------------------------------//*/
	function invoice($id,$admin)
	{
	$this->load->view("invoice");
	}
	function ajax_transfer()
	{
		
		$list = $this->payment->get_transfer();
		$data = array();
		$no = $_POST['start'];
		$no =$no+1;
		$con=new konfig();
		foreach ($list as $dataDB) {
		////
		 $dp=$con->dataProfile($dataDB->id_admin);
			
		if($dataDB->status=="no"){
		$status='<div class="input-group-btn">
		<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">'.$dataDB->status.' <span class="caret"></span></button>
		<ul class="dropdown-menu">
		<li><a href="javascript:acc(`'.$dataDB->id_payment.'`,`'.$dataDB->id_invoice.'`)">Ya</a></li>
		<li><a href="javascript:del(`'.$dataDB->id_payment.'`,`'.$dataDB->id_invoice.'`)">Bohong</a></li>
		</ul>
		</div>';
		}else{
		$status='<div class="input-group-btn">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">'.$dataDB->status.' <span class="caret"></span></button>
		<ul class="dropdown-menu">
		<li><a href="javascript:del(`'.$dataDB->id_payment.'`,`'.$dataDB->id_invoice.'`)">Bohong</a></li>
		</ul>
		</div>';
		};	
			
			if($dataDB->tujuan==1) { $tujuan="Bayar Invoice"; } else { $tujuan="Top Up Saldo";};
		
			$row = array();
			$row[] = "<span class='size'>".$dataDB->tgl."</span>";
			$row[] = "<span class='size'>".$dp->owner."</span>";
			$row[] = "<span class='size'>".$dataDB->nama_bank."</span>";
			$row[] = "<span class='size'><a target='_blank' href='".base_url()."data_payment/invoice/".$dataDB->id_invoice."/".$dataDB->id_admin."'>".$dataDB->nomor_invoice."</a></span>";
			$row[] = "<span class='size'>".$tujuan."</span>";
			$row[] = "<span class='size'>".number_format($dataDB->nominal,0,",",".")."</span>";
			$row[] = "<span class='size'>".$dataDB->methode_bayar."</span>";
			$row[] = "<span class='size'>".$dataDB->nama_pengirim."</span>";
			$row[] = "<span class='size'>".$dataDB->ket."</span>";
			$row[] = "<span class='size'>".$status."</span>";

							
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->payment->count_file_transfer("data_payment"),
						"recordsFiltered" =>$this->payment->count_filtered_transfer('data_payment'),
						"data" => $data,
						);
		//output to json paymentat
		echo json_encode($output);

	}
	
	
	
	private function acc($idpayment,$id)
	{
	$pay=$this->db->query("select tgl,methode_bayar,nama_pengirim from data_payment where id_payment='".$idpayment."' ")->row();
	
	$this->db->where("id_invoice",$id);
	$data=array(
	"status"=>"lunas",
	"tgl_bayar"=>substr($pay->tgl,0,10),
	"methode_pembayaran"=>$pay->methode_bayar. " - ".$pay->nama_pengirim,
	);
	echo $this->db->update("data_invoice",$data);
	}
	
	private function cancel($id)
	{
	$this->db->where("id_invoice",$id);
	$data=array(
	"status"=>"belum",
	"tgl_bayar"=>"",
	"methode_pembayaran"=>"",
	);
	echo $this->db->update("data_invoice",$data);
	}
			
	private function deleteInvoice($id)
	{
	$this->db->where("id_invoice",$id);
	$data=array(
	"status"=>"belum",
	"tgl_bayar"=>"",
	"methode_pembayaran"=>"",
	);
	echo $this->db->update("data_invoice",$data);
	}
	/*-------------------------------------------------------------------*/
	function accTransfer($id,$invoice)
	{
	$this->acc($id,$invoice);
	
	$dt=$this->db->query("select id_admin,id_data_event from data_invoice where id_invoice='".$invoice."' ")->row();
	$this->db->query("update data_event set status='1' where id_admin='".$dt->id_admin."' and id_event='".$dt->id_data_event."' ");
		 $this->db->where("id_payment",$id);
	echo $this->db->update("data_payment",array("status"=>"yes"));
	}
	function noTrf($id,$invoice)
	{
	$this->cancel($invoice);
	$this->db->where("id_payment",$id);
		$dt=$this->db->query("select id_admin,id_data_event from data_invoice where id_invoice='".$invoice."' ")->row();
		$this->db->query("update data_event set status='0' where id_admin='".$dt->id_admin."' and id_event='".$dt->id_data_event."' ");
	echo $this->db->update("data_payment",array("status"=>"no"));
	}
	function deleteTransfer($id,$invoice)
	{
	$this->deleteInvoice($invoice);
	$this->db->where("id_payment",$id);
	echo $this->db->delete("data_payment");
	}
	/*-------------------------------------------------------------------*/
	
	
	function transfer()
	{
	$data['konten']="transfer";
	$this->_template($data);
	}
}

