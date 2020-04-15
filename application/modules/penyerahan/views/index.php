 
 <div style="margin-top:-50px">
 <center>
 <span style='color:white'>Pencarian : NIK / Nomor HP / Email</span>
 <input type="text" name='kode' value=""  class='form-control' style="text-align:center" onchange="kode(this.value)">
 </center>
 </div> 
 <div class="  clearfix col-md-12">&nbsp;</div>
  <div class='row col-md-12'> 
 <br> 
<div id="data" class=" "></div>
 		
</div>			
		 
<script>	 
$("[name='kode']").focus();

function kode(kode)
{
        	loading();
			var url="<?php echo base_url();?>penyerahan/getData"; 
			$.post(url,{ kode:kode},function(data){
				$("#data").html(data);
			 	unblock(); 
						  $("[name='penerima']").focus();
			  });
}
</script>	 




  