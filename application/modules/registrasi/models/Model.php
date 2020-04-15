<?php

class Model extends CI_Model  {
    
	var $tbl="data_peserta_rakor";
	var $id="1";
	function __construct()
    {
        parent::__construct();
    }
	function tbl()
	{
		return $this->tbl;
	}
	function save_set()
	{
		$id_acara	=	$this->input->get_post("id_acara");
		$field		=	$this->input->get_post("field");
		$konten		=	$this->input->get_post("konten");
		$this->db->set($field,$konten);
		$this->db->where("id",$this->id);
		return $this->db->update("tr_jenis_undangan");
	}
	function noSurat()
	{			$val=$this->input->get_post("val");
				$this->db->set("no_surat",$val);
				$this->db->where("id",$this->id_acara());
		return  $this->db->update("tr_jenis_undangan");
	}function setDeputi()
	{			$val=$this->input->get_post("val");
				$this->db->set("pimpinan",$val);
				$this->db->where("id",$this->id_acara());
		return  $this->db->update("tr_jenis_undangan");
	}function isi_undangan()
	{			$val=$this->input->get_post("isi_undangan");
				$this->db->set("isi_undangan",$val);
				$this->db->where("id",$this->id_acara());
		return  $this->db->update("tr_jenis_undangan");
	}function lampiran2()
	{			$val=$this->input->get_post("lampiran2");
				$this->db->set("lampiran2",$val);
				$this->db->where("id",$this->id_acara());
		return  $this->db->update("tr_jenis_undangan");
	}
	function idu()
	{
		return $this->session->userdata("id");
	}
	function id_acara()
	{
		return $this->id;
	}
	
	function no_surat()
	{
		$r				=	$this->m_reff->goField("tr_jenis_undangan","no_surat","where id='".$this->id."'");
		$agendalast		=	$this->m_reff->goField("data_acara","no_surat","where id_acara='".$this->id_acara()."' order by tgl desc limit 1");
		$bulan		=	date("m"); $bulan	= sprintf("%02s", $bulan);
		$agendalast		=	str_replace("R-","",$agendalast);
		$agenda		=	explode("/",$agendalast);

		$noagenda	=	isset($agenda[0])?($agenda[0]):"";
		if($noagenda)
		{
		 
			$noagenda	= trim($noagenda+1);
		}else{
			$noagenda	=	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		
		
		$tahun	=	date("Y"); 
		$hasil	=	str_replace("{agenda}",$noagenda,$r);
		$hasil	=	str_replace("{bln}",$bulan,$hasil);
		return 	str_replace("{tahun}",$tahun,$hasil);
		
	}
	function _cekNik($nik)
	{
			   $this->db->where("nik",$nik);
		return $this->db->get("v_peserta")->num_rows();
	}function _cekHp($hp)
	{
			   $this->db->where("hp",$hp);
		return $this->db->get("v_peserta")->num_rows();
	}function _cekEmail($email)
	{
			   $this->db->where("email",$email);
		return $this->db->get("v_peserta")->num_rows();
	}
	function insert_persus()
	{	$form=$this->input->post("f");
		$this->db->set($form);
		return 	$this->db->insert("data_persus");
	}
	
	function insert()
	{
		$nik	=	$this->input->get_post("f[nik]");
		$hp		=	$this->input->get_post("f[hp]");
		$email	=	$this->input->get_post("f[email]");
		$cek	=	$this->_cekNik($nik);
		$cekHP	=	$this->_cekHp($hp);
		$cekEmail	=	$this->_cekEmail($email);
		if($cekEmail)
		{
			$var["gagal"]=true;
			$var["info"]="Gagal!! Email sudah terdaftar";
			return $var;
		}if($cek)
		{
			$var["gagal"]=true;
			$var["info"]="Gagal!! NIK sudah terdaftar";
			return $var;
		}if($cekHP)
		{
			$var["gagal"]=true;
			$var["info"]="Gagal!! Nomor HP sudah terdaftar";
			return $var;
		}
		$jml_pagi		=	$this->input->post("jml_pagi"); 
		$pagi_single	=	$this->input->post("pagi_single"); 
		$pagi_double	=	$this->input->post("pagi_double"); 
		$jml_sore		=	$this->input->post("jml_sore"); 
		$sore_single	=	$this->input->post("sore_single"); 
		$sore_double	=	$this->input->post("sore_double"); 
		 
		$tambahan=array(
		"jml_pagi"=>$jml_pagi,
		"jml_sore"=>$jml_sore,
		"jml_s_pagi"=>$pagi_single,
		"jml_s_sore"=>$sore_single,
		"jml_d_pagi"=>$pagi_double,
		"jml_d_sore"=>$sore_double
		); 
		if($jml_pagi)
		{
			$jml_pagi	=	$jml_pagi;
			$this->_insert_peserta($jml_pagi,1,null,$tambahan);
		}else{
			$this->_insert_peserta($pagi_double,1,2,$tambahan);
			$this->_insert_peserta($pagi_single,1,1,$tambahan);
		}	
		
		if($jml_sore)
		{
			$jml_sore	=	$jml_sore;
			$this->_insert_peserta($jml_sore,2,null,$tambahan);
		}else{ 
			$this->_insert_peserta($sore_double,2,2,$tambahan);
			$this->_insert_peserta($sore_single,2,1,$tambahan);
		}			
		 $f	    	=	$this->input->post("f");
		 $nik       =   $this->input->get_post("f[nik]");
		 $this->kirim_notif($nik);
	  	 $var["validasi"]=true;
		 return $var;
		
	}
	private function _insert_peserta($loop,$jenis,$berlaku,$tambahan)
	{
		for($i=1;$i<=$loop;$i++)
		{
			 $this->db->set($tambahan); 
			 $this->db->set("jenis",$jenis); 
			 $this->db->set("berlaku",$berlaku); 
			 $this->db->set("_cid",$this->idu()); 
			 $this->db->set("_ctime",date('Y-m-d H:i:s'));  
			 $f		=	$this->input->post("f");
			   $this->db->insert("data_peserta",$f); 
		}
		return true;
	}
	
	function insertxxxx()
	{
		$kode_acara		=	$this->input->post("f[kode_acara]");
		$durasi			=	$this->m_reff->goField("data_acara","durasi","where kode='".$kode_acara."' ");
		$tgl			=	$this->m_reff->goField("data_acara","tgl","where kode='".$kode_acara."' ");
		$qr				=	$this->m_reff->getCodeTamu($kode_acara);
		$this->m_reff->qr($kode_acara,$qr);
		$form			=	$this->input->post("f");
		
		$durasi="";$no=1;
		for($i=0;$i<=$durasi;$i++)
		{
			$tgl_pelaksanaan=$this->tanggal->tambahTgl($tgl,$i);
			$durasi[$no++][$tgl_pelaksanaan]=null;
		}
		
		$this->db->set($form);
		$this->db->set("cekin",$durasi);
		$this->db->set("sts_ikutserta",1);
		$this->db->set("qr",$qr);
		$this->db->set("_cid",$this->idu());
		return $this->db->insert("data_peserta");
	}
	 
	  
	function update()
	{ 	 $id	=	$this->input->post("id");
			
		 $tgl	=	$this->input->post("tgl");
		 $tgl	=	$this->tanggal->eng_($tgl,"-"); 
		 $this->db->set("_uid",$this->idu()); 
		 $this->db->set("_utime",date('Y-m-d')); 
		 $this->db->set("tgl",$tgl); 
		 $this->db->set("id_acara",$this->id);
		 $this->db->where("id",$this->input->post("id"));
		 $f		=	$this->input->post("f");
		
		  $this->db->update("data_acara",$f); 
		return $this->update_acara($id);
	}
	 
	  function update_acara($id)
	 {
		$kode	 = $this->m_reff->goField("data_acara","kode","where id='".$id."' ");
		$durasi	 = $this->m_reff->goField("data_acara","durasi","where id='".$id."' ");
		$tgl	 = $this->m_reff->goField("data_acara","tgl","where id='".$id."' ");
		$cekin="";$no=1;
		for($i=0;$i<$durasi;$i++)
		{
			$tgl_pelaksanaan=$this->tanggal->tambahTgl($tgl,$i);
			$cekin[$tgl_pelaksanaan]=null;
		}
		$cekin	=	json_encode($cekin);
		$this->db->set("cekin",$cekin);
		$this->db->where("kode_acara",$kode);
		return $this->db->update("data_peserta");
	 }
	 
	  function get_data()
	{
		$query=$this->_get_data();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	function _get_data()
	{
		    $pencarian=$this->input->get_post("pencarian");
		 if($pencarian)
		 {
			 $pencarian="AND (
				perihal LIKE '%".$pencarian."%' or  
				no_surat LIKE '%".$pencarian."%' or  
				tempat LIKE '%".$pencarian."%' or  
				acara LIKE '%".$pencarian."%'   
			   
				) ";
		 }
		 
		$query="select * from data_acara where 1=1  and id_acara='".$this->id."'  ".$pencarian;
			if($_POST['search']['value']){
			$searchkey=$_POST['search']['value'];
				$query.=" AND (
				perihal LIKE '%".$searchkey."%' or  
				no_surat LIKE '%".$searchkey."%' or  
				tempat LIKE '%".$searchkey."%' or  
				acara LIKE '%".$searchkey."%'   
				) ";
			}

		 
		if(isset($_POST['order']))
		{
		$query.=" order by id desc";
		} 
		else if(isset($order))
		{
			$order = $order;
			$query.=" order by ".key($order)." ".$order[key($order)] ;
		}
		return $query;
	}
	
	public function count()
	{				
		$query = $this->_get_data();
        return  $this->db->query($query)->num_rows();
	}
	
	
	
	
	  function _dataTamu()
	{
		$query=$this->_dataTamu_();
		if($_POST['length'] != -1)
		$query.=" limit ".$_POST['start'].",".$_POST['length'];
		return $this->db->query($query)->result();
	}
	function _dataTamu_()
	{
		    $kode=$this->input->get_post("kode"); 
		    $query=" AND kode_acara='".$kode."' ";
			
		 $blok=$this->input->get_post("blok");	
		 if($blok)
		 {
			   $query.=" AND blok LIKE '%".$blok."%' "; 
		 }

		 $nama=$this->input->get_post("nama");	
		 if($nama)
		 {
			   $query.=" AND (nama LIKE '%".$nama."%' OR qr LIKE '%".$nama."%') "; 
		 }
		 $jabatan=$this->input->get_post("jabatan");	
		 if($jabatan)
		 {
			   $query.=" AND jabatan LIKE '%".$jabatan."%' "; 
		 }
		 $alamat=$this->input->get_post("alamat");	
		 if($alamat)
		 {
			   $query.=" AND alamat LIKE '%".$alamat."%' "; 
		 }
		 $ikutserta=$this->input->get_post("ikutserta");	
		 if($ikutserta!="")
		 {
			   $query.=" AND sts_ikutserta LIKE '%".$ikutserta."%' "; 
		 }
		 $kehadiran=$this->input->get_post("kehadiran");	
		 if($kehadiran!="")
		 {
			   $query.=" AND sts_kehadiran LIKE '%".$kehadiran."%' "; 
		 }
		 
		$query="select * from data_peserta where 1=1   ".$query;
			if($_POST['search']['value']){
			$searchkey=$_POST['search']['value'];
				$query.=" AND (
				nama LIKE '%".$searchkey."%' or  
				jabatan LIKE '%".$searchkey."%' or  
				qr LIKE '%".$searchkey."%' or  
				alamat LIKE '%".$searchkey."%'   
				) ";
			}

		 
		if(isset($_POST['order']))
		{
		$query.=" order by id desc";
		} 
		else if(isset($order))
		{
			$order = $order;
			$query.=" order by ".key($order)." ".$order[key($order)] ;
		}
		return $query;
	}
	
	public function count_tamu()
	{				
		$query = $this->_dataTamu_();
        return  $this->db->query($query)->num_rows();
	}
	
	function show_file_xl()
	{
		$id= $this->input->get("id"); 
		$this->db->where("id",$id);
		$db=$this->db->get("file_peserta")->row();
		$kode_acara=isset($db->kode_acara)?($db->kode_acara):"";
		if(!$kode_acara){ echo "<i>Acara tidak ditemukan</i>"; return false;}

		$peserta=$db->peserta;
		$r_peserta=json_decode($peserta,true);
		 
		 
		$data=$this->db->query("select * from data_acara where kode='".$kode_acara."' ")->row(); 
		$no_surat=$data->no_surat;

		$title=$db->title;
		$r_title=json_decode($title,true);

 
 
        $objPHPExcel = new PHPExcel();
 
        $style = array(
            
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '6CCECB')
            ),
            'borders' =>
            array('allborders' =>
                array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
        );
		
		 
			 
		 
	 
        $awal="A";$jml=0;
        foreach($r_title as $t)
		{		
			    $objPHPExcel->getActiveSheet(0)->setCellValue($awal.'1', strtoupper($t));
			    $objPHPExcel->getActiveSheet(0)->getColumnDimension($awal)->setAutoSize(true);
				$objPHPExcel->getActiveSheet(0)->getStyle( $awal.'1')->applyFromArray($style);
				 $jml++;$awal++;
		} 
  
      
	  
		$no=0; $awal="A"; $start=1;
		foreach($r_peserta as $key=>$val)
		{	$start++;
			$isi="";$no++;
		 
			$awal_isi="A";
			for($i=0;$i<$jml;$i++){ 
				$objPHPExcel->getActiveSheet(0)->setCellValue($awal_isi++.$start, $val[$i]);
			} 
		}
		  
        $objPHPExcel->getActiveSheet(0)->setTitle('TAMU UNDANGAN');
		
						
//<!-------------------------------------------------------------------------------  --->		
     
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$db->nama_file.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
	}
	  	
	function import_persus($file_form)
	{		
	 
		$this->load->library("PHPExcel");
		$insert=0;$gagal=0;$edit=0;$validasi_hp=true;$validasi=true;
		$file   = explode('.',$_FILES[$file_form]['name']);
		$length = count($file);
		if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls'){
         $tmp    = $_FILES[$file_form]['tmp_name']; 
	 
			    $load = PHPExcel_IOFactory::load($tmp);
                $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
				$i=1;
		 	 
				 $jenis_permohonan	=	$this->input->post("id_kategory");
				$kode	=	$this->m_reff->acak(17);
				foreach ($sheets as $sheet) {
					if ($i > 1) {	 
							 $nama		=	isset($sheet[1])?($sheet[1]):"";						 
							 $jml_pagi	=	isset($sheet[2])?($sheet[2]):"";						 
							 $jml_sore	=	isset($sheet[3])?($sheet[3]):"";						 
							 $email		=	isset($sheet[4])?($sheet[4]):"";						 
							 $hp		=	isset($sheet[5])?($sheet[5]):"";						 
							 $ket		=	isset($sheet[6])?($sheet[6]):"";						 
							 
								$dataray=array(
									"jenis_permohonan"	=>	$jenis_permohonan,
									"kode"			=>	$kode,
									"nama"			=>	$nama, 
									"jml_pagi"		=>	$jml_pagi,
									"jml_sore"		=>	$jml_sore,
									"email"			=>	$email,
									"hp"			=>	$hp,
									"ket"			=>	$ket,
									"_cid"			=>	$this->idu(),
									);
								$this->db->insert("data_persus",$dataray);
								$insert++; 
					}
					$i++;
                }
                
       } else{
			 $var["file"]=false;
			 $var["type_file"]="<br>&nbsp;&nbsp;File Excell";
		}
			  $var["import_data"]=true;
			  $var["data_insert"]=$insert;
			  $var["data_gagal"]=$gagal;
			  $var["data_edit"]=$edit; 
			  $var["validasi"]=$validasi;
		return $var;
	}
	
	function import_peserta($file_form)
	{		
	 
		$this->load->library("PHPExcel");
		$insert=0;$gagal=0;$edit=0;$validasi_hp=true;$validasi=true;
		$file   = explode('.',$_FILES[$file_form]['name']);
		$length = count($file);
		if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls'){
         $tmp    = $_FILES[$file_form]['tmp_name']; 
	 
			    $load = PHPExcel_IOFactory::load($tmp);
                $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
				$i=1;
		 	
				$jml_title=count(array_keys($sheets[1]));	 
				$title=json_encode($sheets[1],true);	
					 unset($sheets[1]);
				$peserta=json_encode($sheets,true);		 
					 
			 	foreach ($sheets as $sheet) 
				{ 
							$insert++; 
				}
				 
							$dataray=array(
								"id_acara"=>$this->mdl->id_acara(),
								"jml_peserta"=>$insert, 
								"title"=>$title,
								"peserta"=>$peserta,
								"_cid"=>$this->mdl->idu(),
								"_ctime"=>date("Y-m-d H:i:s")
								);
							$form	=	$this->input->get_post("f");	
							$this->db->set($form);	
						return 	$this->db->insert("file_peserta",$dataray);
							 
				$i++;
       } else{
			 $var["file"]=false;
			 $var["type_file"]="<br>&nbsp;&nbsp;File Excell";
		}
			  $var["import_data"]=true;
			  $var["data_insert"]=$insert;
			  $var["data_gagal"]=$gagal;
			  $var["data_edit"]=$edit; 
			  $var["validasi"]=$validasi;
		return $var;
	}
	
	function edit_import_peserta($file_form)
	{		
	 
		$this->load->library("PHPExcel");
		$insert=0;$gagal=0;$edit=0;$validasi_hp=true;$validasi=true;
		$file   = explode('.',$_FILES[$file_form]['name']);
		$length = count($file);
		if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls'){
         $tmp    = $_FILES[$file_form]['tmp_name']; 
	 
			    $load = PHPExcel_IOFactory::load($tmp);
                $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
				$i=1;
		 	
				$jml_title=count(array_keys($sheets[1]));	 
				$title=json_encode($sheets[1],true);	
					 unset($sheets[1]);
				$peserta=json_encode($sheets,true);		 
					 
			 	foreach ($sheets as $sheet) 
				{ 
							$insert++; 
				}
				 
							$dataray=array( 
								"jml_peserta"=>$insert, 
								"title"=>$title,
								"peserta"=>$peserta,
								"_cid"=>$this->mdl->idu(),
								"_ctime"=>date("Y-m-d H:i:s")
								);
							$form	=	$this->input->get_post("f");	
							$this->db->set($form);	
							$this->db->where("id",$this->input->post("id"));
						return 	$this->db->update("file_peserta",$dataray);
							 
				$i++;
       } else{
			 $var["file"]=false;
			 $var["type_file"]="<br>&nbsp;&nbsp;File Excell";
		}
			  $var["import_data"]=true;
			  $var["data_insert"]=$insert;
			  $var["data_gagal"]=$gagal;
			  $var["data_edit"]=$edit; 
			  $var["validasi"]=$validasi;
		return $var;
	}
	
	function hapus_file()
	{
	    $id = $this->input->get_post("id");
		$id = $this->encrypt->decode($id,"key");
		$this->db->where("id",$id);
		$this->db->delete("file_peserta");
	}
	function hapus()
	{
	    $id 			= 	$this->input->get_post("id");
		//$id = $this->encrypt->decode($id,"key");
		
		$nama_file		=	$this->m_reff->goField("data_peserta","qr","where id='".$id."' ");
		$kode			=	$this->m_reff->goField("data_peserta","kode_acara","where id='".$id."' ");
		 
		$this->db->where("kode_acara",$id);
		$this->db->delete("file_peserta");
		$this->m_reff->hapus_file("qr/".$kode."/".$nama_file);
		$this->db->where("kode",$id);
		return $this->db->delete("data_acara");
	}
	function jml_acara()
	{
		$this->db->where("id_acara",$this->id);
		return $this->db->get("data_acara")->num_rows();
	}
	function getBlok($blok)
	{
	return $this->db->query("SELECT blok,COUNT(*) as jml FROM data_peserta WHERE blok IS NOT NULL AND kode_acara='".$kode."'  GROUP BY blok ORDER BY blok ASC ")->result();
	}
	
	function insert_tamu()
	{
		$kode_acara		=	$this->input->post("f[kode_acara]");
		$durasi			=	$this->m_reff->goField("data_acara","durasi","where kode='".$kode_acara."' ");
		$tgl			=	$this->m_reff->goField("data_acara","tgl","where kode='".$kode_acara."' ");
		$qr				=	$this->m_reff->getCodeTamu($kode_acara);
		$this->m_reff->qr($kode_acara,$qr);
		$form			=	$this->input->post("f");
		
		$cekin="";$no=1;
		for($i=0;$i<$durasi;$i++)
		{
			$tgl_pelaksanaan=$this->tanggal->tambahTgl($tgl,$i);
			$cekin[$tgl_pelaksanaan]=null;
		}
		$cekin	=	json_encode($cekin);
		$this->db->set($form);
		$this->db->set("cekin",$cekin);
		$this->db->set("sts_ikutserta",1);
		$this->db->set("qr",$qr);
		$this->db->set("_cid",$this->idu());
		return $this->db->insert("data_peserta");
	}function update_tamu()
	{ 
		$form			=	$this->input->post("f"); 
		$this->db->set($form); 
		$this->db->where("id",$this->input->post("id"));
		$this->db->set("_uid",$this->idu());
		return $this->db->update("data_peserta");
	}
	function jmlBlokPeserta($kode,$blok)
	{	 
		    
		$this->db->where("sts_ikutserta",1);
		$this->db->where("blok",$blok);
		$this->db->where("kode_acara",$kode);
		$this->db->select("SUM(berlaku) as jml");
		$return=$this->db->get("v_peserta")->row();
		$return=$return->jml;
		if(!$return)
		{
			return 0;
		}else{
			return $return;
		}
		
	}function jmlBlokUndangan($kode,$blok)
	{	 
		    
		$this->db->where("sts_ikutserta",1);
		$this->db->where("blok",$blok);
		$this->db->where("kode_acara",$kode);
		$this->db->select("SUM(berlaku) as jml");
		return $this->db->get("v_peserta")->num_rows();
		 
	}
	function jmlBlokTerisi($kode,$blok,$in)
	{
		$this->db->LIKE("cekin",$in);
		$this->db->where("sts_ikutserta",1);
		$this->db->where("blok",$blok);
		$this->db->where("kode_acara",$kode);
		$this->db->select("SUM(berlaku) as jml");
		$return=$this->db->get("v_peserta")->row();
		$return=$return->jml;
		if(!$return)
		{
			return 0;
		}else{
			return $return;
		}
	}
	function hapus_cek()
	{	
		$ray=$this->m_reff->clearkomaray($this->input->post("id"));
		$kode=$this->input->post("kode"); 
		$this->db->where_in("id",$ray);
		return $this->db->delete("data_peserta");
	}
	function export_xl()
	{
		$id= $this->input->get("id"); 
		$in=$this->m_reff->clearkomaray($id);
		$this->db->where_in("id",$in);
		$data=$this->db->get("data_peserta")->result();
		 
		  
		 
        $objPHPExcel = new PHPExcel();
 
        $style = array(
            
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '6CCECB')
            ),
            'borders' =>
            array('allborders' =>
                array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
        );
		
		  
        		
			    $objPHPExcel->getActiveSheet(0)->setCellValue('A1',"NO");
			    $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"NAMA");
			    $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"JABATAN/LEMBAGA");
			    $objPHPExcel->getActiveSheet(0)->setCellValue('D1',"ALAMAT");
			    $objPHPExcel->getActiveSheet(0)->setCellValue('E1',"BLOK");
			    $objPHPExcel->getActiveSheet(0)->setCellValue('F1',"KEIKUTSERTAAN");
			    $objPHPExcel->getActiveSheet(0)->setCellValue('G1',"KEHADIRAN");
			    $objPHPExcel->getActiveSheet(0)->getColumnDimension("A")->setAutoSize(true);
			    $objPHPExcel->getActiveSheet(0)->getColumnDimension("B")->setAutoSize(true);
			    $objPHPExcel->getActiveSheet(0)->getColumnDimension("C")->setAutoSize(true);
			    $objPHPExcel->getActiveSheet(0)->getColumnDimension("D")->setAutoSize(true);
			    $objPHPExcel->getActiveSheet(0)->getColumnDimension("E")->setAutoSize(true);
			    $objPHPExcel->getActiveSheet(0)->getColumnDimension("F")->setAutoSize(true);
			    $objPHPExcel->getActiveSheet(0)->getColumnDimension("G")->setAutoSize(true);
				$objPHPExcel->getActiveSheet(0)->getStyle("A1:G1")->applyFromArray($style);
				 
      
	  
		$no=1;   $start=2;
		foreach($data as $val)
		{	$kode_acara=$val->kode_acara;
		
		if($val->sts_ikutserta==0)	{ $ikut="Belum konfirmasi"; }elseif($val->sts_ikutserta==1){ $ikut="Ya";}else{ $ikut="Tidak";}
		if($val->sts_kehadiran==0)	{ $hadir="Tidak hadir"; }elseif($val->sts_kehadiran==1){ $hadir="Hadir";}else{ $hadir="Diblok";}
		 	$objPHPExcel->getActiveSheet(0)->setCellValue("A".$start, $no++);
			$objPHPExcel->getActiveSheet(0)->setCellValue("B".$start, $val->nama);
			$objPHPExcel->getActiveSheet(0)->setCellValue("C".$start, $val->jabatan);
			$objPHPExcel->getActiveSheet(0)->setCellValue("D".$start, strip_tags($val->alamat));
			$objPHPExcel->getActiveSheet(0)->setCellValue("E".$start, $val->blok);
			$objPHPExcel->getActiveSheet(0)->setCellValue("F".$start, $ikut);
			$objPHPExcel->getActiveSheet(0)->setCellValue("G".$start, $hadir); 
			$start++;
		}
		  
        $objPHPExcel->getActiveSheet(0)->setTitle('TAMU UNDANGAN');
		
						
//<!-------------------------------------------------------------------------------  --->		
		$nama_file=$this->m_reff->goField("data_acara","perihal","where kode='".$kode_acara."' ");
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nama_file.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
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
 
	function kirim_notif($nik)
	{
	        $data       =   $this->db->get_where("v_peserta",array("nik"=>$nik))->row();
	        $to         =   $data->email;
            $subject    =   "Permohonan Undangan HUT RI 75";
             $isi        =   $this->isiEMail($data);
            $this->_kirim_email($isi,$to,$subject);
       
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
    function isiEMail($data)
    {
        
        $nik         =   $data->nik;
        $nama        =   $data->nama;
        $email       =   $data->email;
        $lembaga     =   $data->lembaga;
      
        $blok_pagi  =   $this->mdl->dispon_pagi($nik);
        $blok_sore  =   $this->mdl->dispon_sore($nik);
         
         
       
        
    return    $isi='
    <table style="max-width:400px" cellpadding=0 cellspacing=0>
    <tr>
    <td colspan="2" style="background-color:#EEE">
    <img src="'.base_url().'plug/img/banner1.JPG" width="100%"   alt="E-receipt"
    style="border-top-left-radius:15px;border-top-right-radius:15px" class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 1; left: 745px; top: 101px;"><div id=":rt" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Download lampiran " data-tooltip-class="a1V" data-tooltip="Download"><div class="aSK J-J5-Ji aYr"></div></div></div>
     <center>
     <span style="font-size:16"><b> PERMOHONAN UNDANGAN HUT-RI 75</b></span>
     <hr width="90%">
     </center>
      </td>
    </tr>
    <tr>
    <td align="left" valign="top" style="background-color:#EEE;padding:10px">

     <span style="font-size:11px;color:#9e9e9e;line-height:16px">Nama Pemohon :</span><br>
      <span style="font-size:13px;line-height:16px;;color:black"><b>'.$nama.'</b></span> <br>
      
      <span style="font-size:11px;color:#9e9e9e;line-height:16px">NIK :</span><br>
      <span style="font-size:13px;line-height:16px;;color:black"><b>'.$nik.'</b></span> <br>
      
      <span style="font-size:11px;color:#9e9e9e;line-height:16px">Email :</span><br>
      <span style="font-size:13px;line-height:16px;;color:black"> '.$email.' </span> <br>
      
      <span style="font-size:11px;color:#9e9e9e;line-height:16px">Lembaga / instansi:</span><br>
      <span style="font-size:13px;line-height:16px;color:black"><b>'.$lembaga.'</b></span> <br>
       
      
      
     <br>
        <b style="font-size:12px;;color:teal;"> PERMOHONAN UNDANGAN</b><br>
      
      <span style="font-size:13px;line-height:16px; color:black">Undangan Pagi : '.$blok_pagi.'</span> <br> 
    
      <span style="font-size:13px;line-height:16px; color:black">Undangan Sore : '.$blok_sore.'</span> <br>
     
     
    </td>  
    </tr>
    <tr>
    <td   style="background-color:#EEE;padding:10px">
    
      
        <span style="font-size:13px;color:black;line-height:16px">Permohonan anda sedang kami proses, untuk informasi jadwal 
        pengambilan dan jumlah undangan yang diperoleh akan kami informasikan kembali melalui email,sms dan whatsapp.   </span><br>
    </td>
    </tr>
    </table>
    
    
    ';
        
    }
 
	
	
	
}




