 <?php
$nik	=	$this->input->get_post("nik");
$jenis	=	2;

		$this->db->order_by("nama","asc");
		$this->db->where("jenis",2);
		$data_b=$this->db->get("tr_blok")->result();
		$data_blok[null]="---";
		$listblok="";$listblokinput1="";$listblokinput2="";
		foreach($data_b as $v)
		{	$jmlBlok1=$this->mdl->getJmlBlok($nik,$jenis,$v->nama,1);
		 
			$title="blue-grey";
			if($jmlBlok1)
			{
				$css1="grey";
				//$title=$v->color;
			}else{
				$css1="";
			}
			
		
		
			 
			$listblok.="<td style='background-color:".$title."'>".$v->nama."</td>";
		 	
			$listblokinput1.="<td  style='background-color:".$css1."'>
			<input type='text' onchange='setBlok(`".$nik."`,`".$jenis."`,`".$v->nama."`,this.value,`1`)' style='width:40px' class='form-controls' value='".$jmlBlok1."'> </td>";
		}
		
		 
			 
		
$this->db->where("nik",$nik);
$this->db->where("jenis",$jenis);
 
$this->db->order_by("jenis,blok","ASC");
$data	=	$this->db->get("data_peserta")->result();
$lis="";$no=1;$nik="";$undangan_pagi=$undangan_sore=0;

    $nama_pj	=	"";
	$nik		=	"";
	$hp			=	"";
	$email		=	"";
	$ket		=   "";
	$total_pagi			=	"";
	$total_sore			=	"";
	$pagi_single		=	"";
	$pagi_double		=	"";
	$sore_single		=	"";
	$sore_double		=   "";
	
foreach($data as $val)
{
	$nama_pj	=	isset($val->nama)?($val->nama):"";
	$nik		=	isset($val->nik)?($val->nik):"";
	$hp			=	isset($val->hp)?($val->hp):"";
	$email		=	isset($val->email)?($val->email):"";
	$ket		=	isset($val->ket)?($val->ket):"";
	$total_pagi			=	isset($val->jml_pagi)?($val->jml_pagi):"";
	$total_sore			=	isset($val->jml_sore)?($val->jml_sore):"";
	$pagi_single		=	isset($val->jml_s_pagi)?($val->jml_s_pagi):"";
	$pagi_double		=	isset($val->jml_d_pagi)?($val->jml_d_pagi):"";
	$sore_single		=	isset($val->jml_s_sore)?($val->jml_s_sore):"";
	$sore_double		=	isset($val->jml_d_sore)?($val->jml_d_sore):"";
	 
	
	$color	=	$this->m_reff->getColor($val->jenis,$val->blok);
	$qr1="";
	$qr2="";$blok_pagi=$blok_sore="";
	if($val->jenis==1)
	{	$acara="PAGI";
		 
		$undangan_pagi++;
	}else{
		$acara="SORE";
		  $undangan_sore++;
	}
	$blok="<span class='label  font-14' style='background-color:".$color."'>BLOK&nbsp; : ".$val->blok."</span>";
		 
	
}
 
 
$jml_undangan	=	$undangan_pagi+$undangan_sore;
$all_blok		=	form_dropdown("all_blok",$data_blok,"","  class='form-control'  onchange='setAllBlok(`".$nik."`,`".$jenis."`,this.value)' ");

 


?>
<br>

<div class="col-md-12" id="load_acara_sore">
			  <b>DISPOSISI ACARA SORE</b>
			 <table class="entry2 card" width="100%">
					<tr class='bg-light-green'>
					<td >  SORE</td> 
					<?php echo $listblok  ?>
					</tr>
				 
					<tr>
					<td>DISPO</td>
					<?php echo $listblokinput1 ?>
					</tr>
			 </table>
			 </div>		