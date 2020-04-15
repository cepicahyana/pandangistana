 
 <div style="margin-top:-20px" class='col-md-12'>
 
 
<?php 
$db=$this->db->get_where("data_persus",array("sts_dispo"=>1,"diterima_oleh"=>null))->result();
$kode[null]="---- pilih ----";
foreach($db as $val)
{
	$kode[$val->kode]=$val->nama." ".$val->ket;
}
echo form_dropdown("[kode]",$kode,"","class='form-control' onchange='kode(this.value)' id='kode' ");
?>
 
 </div> 
 
 
 <br>
<div id="data"></div>
			
		 
<script>	
$('#kode').select2({
	 theme: "bootstrap"
 });
		  		  
$("[name='kode']").focus();

function kode(kode)
{
		loading();
			var url="<?php echo base_url();?>penyerahan/getDataPersus"; 
			$.post(url,{ kode:kode},function(data){
				$("#data").html(data);
				unblock(); 
					  $("#kod11").focus();
			  });
}
</script>	 