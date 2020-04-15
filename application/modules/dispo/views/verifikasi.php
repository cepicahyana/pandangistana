<script>
getVerifikasi()
function getVerifikasi()
		 {	var id="<?php echo $this->input->post("id");?>";
			$("#getVerifikasi").html("Mohon menunggu...."); 	 
			  $.post("<?php echo site_url("dispo/getVerifikasi"); ?>",{id:id},function(data){ 
		 	    $("#getVerifikasi").html(data); 	 		 	
			});   
		 }
</script>	  
		
		 
<div id="getVerifikasi"></div>		 
		