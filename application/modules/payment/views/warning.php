<?php
$umum=new umum();
$saldo=$umum->jmlInvoice();

if($saldo>0)
{
$p="<p>Anda mempunyai ".$umum->jmlInvoice()." Invoice yang belum dibayarkan<br>
segera melakukan pembayaran sebelum jatuh tempo</p>";
}else
{
$p="Untuk menambah saldo silahkan melakukan transfer dan konfirmasi pembayaran anda disini";
}


$data='
<div style="max-width:475px;position:fixed;bottom:0px;padding:5px;left:10px; z-index:3200;"> 
<div class="main-box-body clearfix">

<div class="alert alert-block alert-danger fade in">
<button type="button" class="close black" data-dismiss="alert" aria-hidden="true">x</button>
<h4><b>Informasi</b></h4>
'.$p.'
<p>
<a class="btn btn-success" href="'.base_url().'payment">Invoice</a> 
<a class="btn btn-default" href="javascript:rek()">Rek.Pembayaran</a> 
<a class="btn btn-default" href="javascript:konfirm()">Konfirmasi Pembayaran</a>
</p>
</div>
</div>
</div>';
echo $data;