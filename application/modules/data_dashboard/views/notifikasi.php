<?php
$konfirmasi=$this->dashboard->cekKonfirmasi();
$chat=$this->dashboard->cekChat();
if($chat!=0 OR $konfirmasi!=0)
{
?>
<div style="min-width:475px;position:fixed;top:0px;padding:5px;left:10px; z-index:3200;"> 
<div class="main-box-body clearfix">

<div class="alert alert-block alert-danger fade in">
<button type="button" class="close black" data-dismiss="alert" aria-hidden="true">x</button>
<h4><b>Notifikasi</b></h4>
<?php if($konfirmasi){ echo "<a href='".base_url()."data_payment/transfer'>$konfirmasi Konfirmasi Transfer</a> <br>";}; ?>

<?php if($chat){ echo "ada $chat Pesan Chating";}; ?>

</div>
</div>
</div>';
<?php
}
