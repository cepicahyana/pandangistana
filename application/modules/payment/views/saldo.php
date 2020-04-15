<center><div class="row">
<div class="col-lg-4 col-md-6 col-sm-6">
<div class="main-box clearfix project-box emerald-box">
<div class="main-box-body clearfix">
<div class="project-box-header emerald-bg">
<div class="name">
<a href="#" class="black sadow">
JUMLAH SALDO
</a>
</div>
</div>
<div class="project-box-content">
<span class="chart" data-percent="86" data-bar-color="#2ecc71">
<h1><b> <?php  $saldo=$this->payment->saldo(); echo number_format($saldo,0,",",".");?></b></h1>
</span>
</div>

<div class="project-box-ultrafooter clearfix">
<a href="javascript:warning('saldo')" class=" pull-right">
Tambah Saldo
<i class="fa fa-arrow-circle-right fa-lg"></i>
</a>
</div>
</div>
</div>
</div>
