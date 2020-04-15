<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/invoice.css" media="all">
<title>invoice</title>
<?php
$idInvoice=$this->uri->segment(3);
$idAdmin=$this->uri->segment(4);
$this->db->where("id_admin",$idAdmin);
$this->db->where("id_invoice",$idInvoice);
$data=$this->db->get("data_invoice")->row();
if(!isset($data->id_data_event)){ echo "Invoice Tidak ditemukan"; return false;};
$saldo=$this->db->query("select saldo from admin where id_admin='".$idAdmin."'")->row();
$saldo=$saldo->saldo;
$quota=$this->db->query("select quota from data_event where id_event='".$data->id_data_event."'")->row();
$quota=$quota->quota;
?>
<?php $con=new konfig(); $dp=$con->dataProfile($idAdmin); ?>
<span id="print">
<div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img class="imgsibuta" src="<?php echo base_url();?>plug/img/web.png" style="max-width:200px">
                            </td>
                            
                            <td>
							<?php $tgl=explode(" ",$data->created); ?>
                                Invoice #: <?php echo $data->nomor_invoice; $jt=$this->tanggal->tambahTgl($tgl[0],2) ?><br>
                                Tanggal Invoice: <?php echo  $this->tanggal->eng($tgl[0],"/"); ?><br>
                                <?php if($data->status=="lunas") {?>
								Tanggal Pembayaran: <?php echo  $this->tanggal->eng($data->tgl_bayar,"/"); }else{ ?>
								Jatuh tempo: <?php echo  $this->tanggal->eng($jt,"/"); } ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            
                            
                            <td><b>Ditagih ke:</b><br>
                                <?php echo $dp->owner; ?><br>
                               <?php echo  $dp->telp; ?><br>
                               <?php echo  $dp->email; ?><br>
                            </td>
							
							<td><b>Bayar Ke:</b><br>
                                <?php echo $con->konfigurasi(2);?><br>
                                Tanggulun Barat<br>
                                Kalijati-Subang.41271<br>
								Jawa Barat Indonesia<br>
								<a href="#">085-2128-8210 | 526DCF55</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
                       
                   
            <tr class="heading">
                <td>
                    Invoice Items
                </td>
                <td>
                    Jumlah
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Jumlah Quota <?php echo $data->quota; ?> Register x <?php echo $data->tarif; ?>
                </td>
                
                <td>
                   Rp <?php echo number_format($th=$data->quota*$data->tarif,0,",","."); ?>
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Biaya Administrasi 	
                </td>
                
                <td>
                  Rp <?php echo $member="500"; ?>
                </td>
            </tr>
			<?php
			$t=($member+$th);
			?>
			<tr class="item">
                <td align='right'>
                   Sub Total	
                </td>
                
                <td>
                  Rp <?php  echo number_format($t,0,",","."); ?>
                </td>
            </tr>
			
	<?php
if($data->methode_pembayaran=="Voucher Gratis") {	?>
			<tr class="item">
                <td align='right'>
                  Nilai  Voucher 	
                </td>
                
                <td>
                  Rp <?php  echo number_format($kurang=$t,0,",","."); ?>
                </td>
            </tr>
			<?php
				$t=0;
				 }elseif($data->methode_pembayaran=="saldo") {	?>
			<tr class="item">
                <td align='right'>
                    Alokasi Saldo	
                </td>
                
                <td>
                  Rp <?php $saldo=$kurang=$data->alokasi_saldo; echo number_format($saldo,0,",","."); ?>
                </td>
            </tr>
			
			<?php
				$t=($th+$member)-$saldo;
				if($t<1){ $t=0;};
				 }elseif($data->methode_pembayaran=="saldokurang") {	?>
			<tr class="item">
                <td align='right'>
                    Alokasi Saldo	
                </td>
                
                <td>
                  Rp <?php $saldo=$kurang=$data->alokasi_saldo; echo number_format($saldo,0,",","."); ?>
                </td>
            </tr>
			
			<?php
				$t=($th+$member)-$saldo;
				if($t<1){ $t=0;};
				 }elseif($data->alokasi_saldo!=0) {	?>
			<tr class="item">
                <td align='right'>
                    Alokasi Saldo	
                </td>
                
                <td>
                  Rp <?php $saldo=$kurang=$data->alokasi_saldo; echo number_format($saldo,0,",","."); ?>
                </td>
            </tr>
			
			<?php
				$t=($th+$member)-$saldo;
				if($t<1){ $t=0;};
				 }else
				{
				?>
				<tr class="item">
                <td align='right'>
                    Alokasi Saldo	
                </td>
                
                <td>
                  Rp 0
                </td>
				</tr>
				<?php
				} ?>		
			
			
			
            		
            
            <tr class="item last">
                <td align="right" class="total">
                    Total yang harus dibayar
                </td>
                
                <td>
                  <b>  Rp <?php echo number_format($t,0,",","."); ?> </b>
                </td>
            </tr> 
			
      <?php
if($data->status=="lunas"){?>      
            <tr class="heading">
                <td>
                   Metode pembayaran
                </td>
                <td>
                   Status Invoice
                </td>
			
            </tr>
			  <tr class="item">
                <td>
                   <?php echo $data->methode_pembayaran;?>
                </td>
                
                <td>
                 LUNAS
                </td>
            </tr>
<?php } ?>			
			
			
			
			
			
        </table>
</div>
</span>
<center>	
<button class='btn btn-small btn-primary' onclick="printDiv('print')"><i class="fa fa-print"></i> Print</button>

</center>


<script type="text/javascript">
  function printDiv(print) {
     var printContents = document.getElementById(print).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>