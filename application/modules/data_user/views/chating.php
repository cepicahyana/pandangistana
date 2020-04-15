<!--<script src='<?php echo base_url();?>assets/js/moment.min.js'></script>
<script src='<?php echo base_url();?>assets/js/jquery.min.js'></script>
<script src='<?php echo base_url();?>assets/js/jquery-ui.min.js'></script>-->
<?php $con=new konfig(); $dp=$con->dataProfile($id_admin); ?> 
<div class="col-lg-8">
<div class="main-box clearfix">
<header class="main-box-header clearfix">
<h2 class="sadow05 black">You & <?php echo $dp->owner; ?></h2>
</header>
<div class="main-box-body clearfix">
<div class="conversation-wrapper">
<div class="conversation-content">
<div class="conversation-inner">

<?php
foreach($dataChat as $dc)
{
$div="";
?>
<!----->

<?php 
$this->load->model("m_profile","profile");
if($dc->id_admin!=$id_admin){ ?>
<div class="conversation-item item-right clearfix">
<div class="conversation-user">
<img width='55px' height="50px" src="<?php echo base_url();?>file_upload/dp/<?php $dp=$this->profile->dataProfile($dc->id_admin); echo $dp->poto;?>" alt=""/>
</div>
<div class="conversation-body">
<div class="name">
<?php echo $dp->owner; ?>
</div>
<div>
<span class="time hidden-xs">
<?php echo $dc->date; ?>
</span>
</div>
<div class="text">
<?php echo $dc->chat; ?>
</div>
</div>
</div>

<?php }else{ ?>

<div class="conversation-item item-left clearfix">
<div class="conversation-user">
<img width='55px' height="50px" src="<?php echo base_url();?>file_upload/dp/<?php $dp=$this->profile->dataProfile($dc->id_admin); echo $dp->poto;?>" alt=""/>
</div>
<div class="conversation-body">
<div class="name">
Admin
</div>
<div>
<span class="time hidden-xs">
<?php echo $dc->date; ?>
</span>
</div>
<div class="text">
<?php echo $dc->chat; ?>
</div>
</div>
</div>

<?php }
} ?>

<!----NEXT------>
<p class='isicat nextChat'></p>

</div>
</div>
<div class="conversation-new-message">

<div class="form-group">
<textarea class="form-control chating" rows="2" placeholder="Enter your message..."></textarea>
</div>
<div class="clearfix">
<div class="loadi pull-left"></div>
<button type="submit" class="btn btn-success pull-right" onclick="sendChat(<?php echo $id_admin; ?>)">Kirim Pesan</button>
</div>

</div>
</div>
</div>
</div>
</div>
<!---


<script src="<?php echo base_url();?>plug/boostrap/js/jquery.slimscroll.min.js"></script> -->

<script>
function sendChat(id){
 $('.nextChat').html("<img src='<?php echo base_url();?>plug/img/load.gif'> <font color='#999999'>Please wait...</font>");
 $('.loadi').html("<img src='<?php echo base_url();?>plug/img/load.gif'> <font color='#999999'>Please wait...</font>");
	var chat=$(".chating").val();
	$.ajax({
	url:"<?php echo base_url();?>data_user/sendChat/"+id,
	type: "POST",
    data: "chat="+chat,
	success: function(data)
            {
			
			$(".nextChat").html(data);
			$(".chating").val("");
			  $(".isicat").removeClass("nextChat");
			   $(".isicat:last").addClass("nextChat");
			   $('.loadi').html("<i><span style='font-size:13px'>Terkirim...</span></i>");
			   
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Try Again!');
            }
	});
}
setInterval(function(){ loadChat(); }, 3000);

function loadChat()
{
	$.ajax({
	url:"<?php echo base_url();?>data_user/loadChat/<?php echo $id_admin; ?>",
	type: "POST",
 	success: function(data)
            {
			
			$(".nextChat").html(data);
			  $(".isicat").removeClass("nextChat");
			   $(".isicat:last").addClass("nextChat");
			 			   
            }
	});
}

</script>