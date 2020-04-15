
<div class="main-box black">
<header class="main-box-header clearfix">
<h2 class="black sadow">Konfirmasi Pembayaran <button data-dismiss="modal"  class="md-close close">&times;</button></h2>
</header>
<div class="main-box-body clearfix">
<span id="sudah">
<form id="formKonfim" action="javascript:saveKonfirm()" >

<?php if($dataInvoice){?>
<div class="form-group">
<label>Tujuan Pembayaran</label>
<select required id="tujuan" name="tujuan" class="form-control" onchange="pilpay()">
<option value="">- - - Pilih - - -</option>
<option  value="1">Bayar Invoice</option>
<option  value="2">Tambah Saldo</option>
</select>
</div>
<?php }else{ ?>
<div class="form-group">
<label>Tujuan Pembayaran</label>
<select required id="tujuan" name="tujuan" class="form-control" onchange="pilpay()">
<option  value="2">Tambah Saldo</option>
</select>
</div>
<?php } ?>


<?php if($dataInvoice){?>
<div class="form-group noinvoice">
<label for="exampleInputEmail1">Nomor Invoice</label>
<?php
foreach($dataInvoice as $op)
	{
	$val[$op->id_invoice]=$op->nomor_invoice." - ".$op->title;
	}
	$array=$val;
	echo form_dropdown("invoice",$array,"", 'class="form-control"');
?>
</div>
<?php } ?>


<div class="form-group">
<label>Bank Tujuan:</label>
<select required name="bank" class="form-control">
<option value="">- - - Pilih - - -</option>
<option  value="1">BCA</option>
<option  value="2">BNI</option>
<option  value="3">PAYPAL</option>
</select>
</div>

<div class="form-group">
<label for="nominal">Nomonal Transfer</label>
<input type="nominal" name="nominal" required class="form-control" id="kode">
</div>

<div class="form-group">
<label>Metode pembayaran:</label>
<select required name="metode" class="form-control">
<option value="">- - - Pilih - - -</option>
<option  value="Internet Banking">Internet Banking</option>
<option  value="SMS Banking">SMS Banking</option>
<option  value="Transfer ATM">Transfer ATM</option>
<option  value="Setoran Tunai">Setoran Tunai</option>
</select>
</div>

<div class="form-group">
<label for="namaPengirim">Nama Pengirim</label>
<input type="text" name="namaPengirim" required class="form-control" id="namaPengirim">
</div>



<div class="form-group">
<label for="ket">Keterangan</label>
<textarea  class="form-control" name="ket" id="ket"></textarea>
</div>



<button type="submit" class="btn btn-defaul btn-primary pull-right">Simpan</button>
<span>
</form>
</div>
</div>


<script>
function saveKonfirm()
{
       // ajax adding data to database
          $.ajax({
            url : "<?php echo base_url();?>payment/saveKonfirm",
            type: "POST",
            data: $('#formKonfim').serialize(),
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
               <?php 
$uri1=$this->uri->segment(1);
$uri2=$this->uri->segment(2);
if($uri1=="payment" and $uri2=="")
{
?>
reload_table();    
<?php
}
?>
                         
               closeWarning();         
				$('#sudah').html("<h3>Terimakasih! Pembayaran anda segera kami proses...</hr>");			   
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
}
</script>


<script>
$(".noinvoice").hide();
function pilpay()
{
var tujuan=$("#tujuan").val();
if(tujuan==1){
$(".noinvoice").show();
}else
{
$(".noinvoice").hide();
}
}
</script>


