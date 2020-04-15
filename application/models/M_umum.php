<?php

class M_umum extends CI_Model  {
    
		
	function __construct()
    {
        parent::__construct();
		
    }
	///////////////////Golongan validasi
	function jmlTarget()
	{	$this->db->select("sum(target) as sum");
		$return=$this->db->get("tr_blok")->row();
		return isset($return->sum)?($return->sum):"";
	}
	function jmlPemohon($jenis=null)
	{
		if($jenis)
		{ 
			$this->db->where("(jenis_acara ='".$jenis."' or jenis_acara=3)");
			$this->db->select("count(*) as jml");
		}else{
			$this->db->select("sum(jml_undangan) as jml");
		}
		
		$return=$this->db->get("v_peserta")->row();
		return isset($return->jml)?($return->jml):0;
	}
	function jmlDispo()
	{	
		//$this->db->where("sts_acc",2);
		$this->db->where("blok1 IS NOT NULL");
		$this->db->or_where("blok2 IS NOT NULL");
		$this->db->select("sum(jml_undangan) as jml");
		$return=$this->db->get("v_peserta")->row();
		return isset($return->jml)?($return->jml):0;
	}
	function jmlDispoByBlok($jenis,$blok)
	{	
		if($jenis)
		{
			$this->db->where("(jenis_acara ='".$jenis."' or jenis_acara=3)");
			$this->db->select("count(*) as jml");
		}else{
			$this->db->select("sum(jml_undangan) as jml");
		}
		
		if($jenis==1){
				$this->db->where("blok1",$blok); 
		}elseif($jenis==2){
				$this->db->where("blok2",$blok); 
		}elseif($jenis==3){
				$this->db->where("blok1",$blok); 
				$this->db->where_or("blok2",$blok); 
		}
		//$this->db->where("sts_acc",2); 
		$return=$this->db->get("v_peserta")->row();
		return isset($return->jml)?($return->jml):0;
	}
	function jmlDistribusi($jenis=null,$blok=null)
	{	
		if($jenis){
				
			$this->db->where("(jenis_acara ='".$jenis."' or jenis_acara=3)");
				$this->db->select("count(*) as jml");
		}else{
				$this->db->select("sum(jml_undangan) as jml");
		}
		if($jenis==1){
				$this->db->where("blok1",$blok); 
		}elseif($jenis==2){
				$this->db->where("blok2",$blok); 
		}elseif($jenis==3){
				$this->db->where("blok1",$blok); 
				$this->db->where_or("blok2",$blok); 
		}
		$this->db->where("diterima_oleh IS NOT NULL"); 
		$return=$this->db->get("v_peserta")->row();
		return isset($return->jml)?($return->jml):0;
	}
	function per_dispo()
	{
		$pemohon=$this->jmlPemohon();
		if(!$pemohon){return 0;}
		$sudah=$this->jmlDispo();
		return (($sudah/$pemohon)*100);
	}
	function per_pemohon()
	{
		$target		=	$this->jmlTarget();
		if(!$target){return 0;}
		$jmlPemohon	=	$this->jmlPemohon();
		return (($jmlPemohon/$target)*100);
	}
	function per_distribusi()
	{	  $jmlDispo		=	$this->jmlDispo();
		if(!$jmlDispo){return 0;}
		$jmlDistribusi	=	$this->jmlDistribusi();
		return (($jmlDistribusi/$jmlDispo)*100);
	}
	function jmlQuota($jenis,$blok=null)
		{
			$this->db->where("jenis",$jenis);
			if($blok){
			$this->db->where("id",$blok);
			}
			$this->db->select("sum(target) as target");
			$s=$this->db->get("tr_blok")->row();
			return number_format($s->target,0,",",".");
			 
		}
	function getJmlBlok($kode_persus,$id_blok,$jenis)
	{
		$this->db->where("kode_persus",$kode_persus);
		if($jenis==1){
			$this->db->where("blok1",$id_blok);
		}else{
			$this->db->where("blok2",$id_blok);
		}
		return $this->db->get("data_peserta")->num_rows();
	}
	function realisasi($jenis_acara,$kode_persus)
	{
		if($jenis_acara){
				
			$this->db->where("(jenis_acara ='".$jenis_acara."' or jenis_acara=3)");
				$this->db->select("count(*) as jml");
		}else{
				$this->db->select("sum(jml_undangan) as jml");
		}
		$this->db->where("kode_persus",$kode_persus);
		$return=$this->db->get("v_peserta")->row();
		return isset($return->jml)?($return->jml):0;
	}
}