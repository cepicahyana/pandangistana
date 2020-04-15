<?php $con=new umum; ?>
<div class="row">
<div class="col-lg-12">
<div class="row">
<div class="col-lg-12">
<ol class="breadcrumb">
<li><a href="#">Admin</a></li>
<li class="active"><span>Dashboard</span></li>
</ol>
<h1>Dashboard</h1>
</div>
</div>
<div class="row">
<div class="col-lg-3 col-sm-6 col-xs-12">
<div class="main-box infographic-box colored emerald-bg">
<i class="fa fa-envelope"></i>
<span class="headline">Peserta</span>
<span class="value"><?php echo $con->totalPeserta();?></span>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-xs-12">
<div class="main-box infographic-box colored blue-bg">
<i class="fa fa-money"></i>
<span class="headline">Transfer</span>
<span class="value"><?php echo $con->totalTransfer();?></span>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-xs-12">
<div class="main-box infographic-box colored red-bg">
<i class="fa fa-user"></i>
<span class="headline">Users</span>
<span class="value"><?php echo $con->totalUser();?></span>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-xs-12">
<div class="main-box infographic-box colored purple-bg">
<i class="fa fa-globe"></i>
<span class="headline">Event</span>
<span class="value"><?php echo $con->totalEvent();?></span>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-3 col-sm-6 col-xs-12">
<div class="main-box infographic-box">
<i class="fa fa-user red-bg"></i>
<span class="headline">Members</span>
<span class="value">
<span class="timer" data-from="120" data-to="2562" data-speed="1000" data-refresh-interval="50">
2562
</span>
</span>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-xs-12">
<div class="main-box infographic-box">
<i class="fa fa-shopping-cart emerald-bg"></i>
<span class="headline">Invoice</span>
<span class="value">
<span class="timer" data-from="30" data-to="658" data-speed="800" data-refresh-interval="30">
<?php echo $con->totalInvoice();?>
</span>
</span>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-xs-12">
<div class="main-box infographic-box">
<i class="fa fa-money blue-bg"></i>
<span class="headline">Saldo</span>
<span class="value">
Rp <span class="timer" data-from="83" data-to="8400" data-speed="900" data-refresh-interval="60">
<?php echo $con->totalSaldo();?>
</span>
</span>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-xs-12">
<div class="main-box infographic-box">
<i class="fa fa-eye yellow-bg"></i>
<span class="headline">Monthly Visits</span>
<span class="value">
<span class="timer" data-from="539" data-to="12526" data-speed="1100">
12526
</span>
</span>
</div>
</div>
</div>
<div class="row">
<div class="col-md-3 col-sm-6 col-xs-12">
<div class="main-box small-graph-box emerald-bg">
<div class="box-button">
	<a href="#" class="box-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
</div>
<span class="value">69,600</span>
<span class="headline">Visits</span>
<div class="progress">
<div style="width: 84%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="84" role="progressbar" class="progress-bar">
<span class="sr-only">84% Complete</span>
</div>
</div>
<span class="subinfo">
<i class="fa fa-caret-down"></i> 22% less than last week
</span>
</div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12 hidden-sm">
<div class="main-box small-graph-box blue-bg">
<div class="box-button">
	<a href="#" class="box-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
</div>
<span class="value">923</span>
<span class="headline">Orders</span>
<div class="progress">
<div style="width: 42%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="42" role="progressbar" class="progress-bar">
<span class="sr-only">42% Complete</span>
</div>
</div>
<span class="subinfo">
<i class="fa fa-caret-up"></i> 15% higher than last week
</span>
</div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
<div class="main-box small-graph-box red-bg">
<div class="box-button">
	<a href="#" class="box-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
</div>
<span class="value">2,562</span>
<span class="headline">Users</span>
<div class="progress">
<div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar">
<span class="sr-only">60% Complete</span>
</div>
</div>
<span class="subinfo">
<i class="fa fa-caret-up"></i> 10% higher than last week
</span>
</div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
<div class="main-box small-graph-box purple-bg">
<div class="box-button">
	<a href="#" class="box-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
</div>
<span class="value">$61,600</span>
<span class="headline">Revenue</span>
<div class="progress">
<div style="width: 77%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="77" role="progressbar" class="progress-bar">
<span class="sr-only">77% Complete</span>
</div>
</div>
<span class="subinfo">
<i class="fa fa-caret-down"></i> 22% More than last week
</span>
</div>
</div>
</div>
</div>