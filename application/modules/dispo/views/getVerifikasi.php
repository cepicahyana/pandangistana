 <?php
$id		=	$this->input->post("id");
if($id){
	$data	=	$this->db->get_where("data_peserta",array("id"=>$id,"sts_verifikasi"=>0,"id_kategory"=>1))->row();
	 
}else{
				$this->db->order_by("id","asc");
	$data	=	$this->db->get_where("data_peserta",array("sts_verifikasi"=>0,"id_kategory"=>1))->row();
}

if(!$data){echo '
<b>Maff!</b>   <button type="button" class="close"  onclick="closeModal(0)" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
  </button> 
<h5 class="text-danger"><i>Data tidak tersedia..</i></h5>';

 return false;}
 $this->mdl->setStsVerifikasi($data->id,1);	
?>

<div id="loadGet">


  <button type="button" class="close"  onclick="closeModal(`<?php echo $data->id;?>`,`0`)" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
  </button> 
 				
					
 <b style='font-size:20px'>Verifikasi</b>
 <!-- <span style='margin-left:300px;'><button class="btn   bg-teal" type="button"  ><b class="fas fa-chevron-circle-left"> </b> Sebelumnya </button>
 <button  class=' btn' type="button" onclick="selanjutnya(``)" >Selanjutnya <b class="fas fa-chevron-circle-right"> </b> </button>
</span>-->
<hr>

<div class='row'>
	<div class='col-md-6'>
	
	<?php 
	$link=$this->m_reff->tm_pengaturan(14);
	?>
	<a href='<?php echo $data->foto_ktp?>' alt='ktp' target="_blank"><img src="<?php echo $link."/upload/peserta/ktp/".$data->foto_ktp?>" width='100%'></a>
	<a href='<?php echo $data->foto_kk?>'  alt='kk' target="_blank"><img src="<?php echo $link."/upload/peserta/kk/".$data->foto_kk?>" width='100%'></a>
	</div>

	<div class='col-md-6'>
	
	<table class='entry2' width="100%">
	<tr class='bg-grey '>
	<td colspan="2"><b class=' '> Data profile</b></td>
	</tr>
	<tr>
	<td>Nama</td> <td><?php echo $data->nama; ?></td>
	</tr>
	<tr>
	<td>NIK</td> <td>  <?php echo $data->nik; ?></td>
	</tr><tr>
	<td>Hp</td> <td>  <?php echo $data->hp; ?></td>
	</tr><tr>
	<td>E-mail</td> <td>  <?php echo $data->email; ?></td>
	</tr><tr>
	<td>Alamat</td> <td>  <?php echo $prov=$this->m_reff->goField("wil_provinsi","nama","where id_prov='".substr($data->nik,0,2)."' "); ?> - 
	 <?php echo $kab=strtolower($this->m_reff->goField("wil_kabupaten","nama","where id_kab='".substr($data->nik,0,4)."'")); ?>
	 </td>
	</tr> 
	<tr>
	 <td>Alasan Mengikuti</td> <td>  <?php echo $data->alasan_mengikuti; ?></td>
	</tr>
	</table>
	Jumlah pendaftar pada   wilayah yang sama
	<table class='entry2' width="100%">
	<tr>
	<td>Seprovinsi <?php echo $prov;?></td><td><?php echo $this->mdl->getProvByNik($data->nik)?></td>
	</tr><tr>
	<td>Sekabupaten  <?php echo str_replace("KAB. ","",$kab);?></td> <td><?php echo $this->mdl->getKabByNik($data->nik)?></td>
	</tr>
	</table>
	<hr>
	
	<?php
	$permohonan	=	$data->jenis_acara;
	?>
	
	<div class="row">
	<div class='col-md-4'>
	<?php
	if($permohonan==1 or $permohonan==3)
	{?>
	<button class="btn btn-block bg-orange btn-block fas fa-check-double" type="button" onclick="setAcc('<?php echo $data->id;?>',1)" >
													ACC PAGI
	 </button>
	<?php }else{   echo "<button class='btn' onclick='setAcc(`".$data->id."`,1)' >ACC PAGI</button>";  } ?>
	</div>
	<div class='col-md-4'>
	<?php
	if($permohonan==3)
	{?>
	
	<button class="btn bg-success  btn-block fas fa-check-double" type="button" onclick="setAcc('<?php echo $data->id;?>',3)" >
													ACC SEMUA
	 </button>
	 <?php }else{
		   echo "<button class='btn' disabled >ACC SEMUA</button>"; 
	 }?>
	</div>
	<div class='col-md-4'>
	<?php
	if($permohonan==2  or $permohonan==3 )
	{?>
	<button class="btn bg-orange  btn-block fas fa-check-double" type="button" onclick="setAcc('<?php echo $data->id;?>',2)" >
													ACC SORE
	 </button>
	<?php }else{
			  echo "<button class='btn' onclick='setAcc(`".$data->id."`,2)'>ACC SORE</button>"; 
	}
			  ?>
	</div>
	</div>
	
	 
	 
	 
	 
	 <hr>
	 <center>Permohonan ditolak</center>
		 
												 
														 
														<?php 
														$this->db->order_by("id","asc");
														$dataAlasan=$this->db->get("tm_alasan_penolakan")->result();
														$db[null]="---- pilih alasan penolakan ----";
														foreach($dataAlasan as $dataAlasan)
														{
															$db[$dataAlasan->id]=$dataAlasan->alasan;
														}
														echo form_dropdown("alasan",$db,"","id='alasan' class='form-control'   ");
														?>
													<br>
													 
													
	<button class="btn btn-danger btn-block far fa-times-circle" type="button" onclick="setTolak('<?php echo $data->id;?>')" >
													TOLAK
												</button>
	
	 
	
	</div> 
</div>

</div>
 
<script>
function setAcc(id,sts)
{ 
			 loading("loadGet"); 	 
			  $.post("<?php echo site_url("dispo/setAcc"); ?>",{id:id,sts:sts},function(data){ 
			  unblock("loadGet");
			  if(data==false){	notif("Maaf! terjadi kesalahan dalam proses disposisi");	return false;} 
			getNext();			  
			}); 
}
</script>

<script>
function setTolak(id)
{ 
	var alasan = $("[name='alasan']").val();
	if(!alasan){ notif("Mohon pilih alasan penolakan!"); $("[name='alasan']").focus(); return false;}
			 loading("loadGet"); 	 
			  $.post("<?php echo site_url("dispo/setTolak"); ?>",{id:id,alasan:alasan},function(data){ 
		 	  unblock("loadGet");
			getNext();			  
			}); 
}
</script>

<script>
 
function getNext()
		 {	 
			$("#getVerifikasi").html("Mohon menunggu...."); 	 
			  $.post("<?php echo site_url("dispo/getNextVerifikasi"); ?>",function(data){ 
		 	    $("#getVerifikasi").html(data); 	 		 	
			});   
		 }
</script>		 