<?php
$kode	=	$this->input->get_post("kode");
$this->db->where("kode_persus",$kode);
$this->db->order_by("jenis_acara,blok1,blok2","ASC");
$data	=	$this->db->get("data_peserta")->result();
$lis="";$no=1;$nik="";$undangan_pagi=$undangan_sore=0;$urut=1;$jmlpagi=$jmlsore=0;
foreach($data as $val)
{
	
	$qr1="";
	$qr2="";$blok_pagi=$blok_sore="";
	if($val->blok1)
	{	$namblok	=	$this->m_reff->goField("tr_blok","nama","where id='".$val->blok1."'");
		$color	=	$this->m_reff->getColor($val->blok1);
		$blok="<span class='btn btn-sm font-14' style='background-color:".$color."'><b style='font-size:15px'>	".$namblok."</b> PAGI&nbsp;</span>";
		if($val->blok1)
		{	 $blok_pagi=$val->blok1;
			 
		}else{
			 
		}
		$undangan_pagi++;
	}else{
		$namblok	=	$this->m_reff->goField("tr_blok","nama","where id='".$val->blok2."'");
		$color	=	$this->m_reff->getColor($val->blok2);
		$blok="<span class='btn btn-sm  font-14' style='background-color:".$color."'>	<b style='font-size:15px'>".$namblok."</b>	SORE </span>";
		if($val->blok2)
		{	 $blok_sore=$val->blok2;
		 
		}else{
			 
		}
			$undangan_sore++;
	}
	
	if($val->jenis_acara==1)
	{	$jmlpagi++;
		$qr1="<input value='".$this->mdl->getQr($val->id,1)."' type='text' size='30' style='border:grey solid 1px' id='kod1".$urut."' onchange='setKode(1,".$val->id.",this.value,1,".$urut.",".$val->blok1.")'>" ;
		$qr2="";
		
		$urut++;
	}else{
		 $jmlsore++;
		$qr1="";
		$qr2="<input value='".$this->mdl->getQr($val->id,2)."' type='text' size='30' style='border:grey solid 1px'  id='kod1".$urut."'  onchange='setKode(2,".$val->id.",this.value,1,".$urut.",".$val->blok2.")'>" ;
		 $urut++;
	}
	
	$lis.="<tr>
	<td  style='border:none'>".$no++."</td>
	<td  style='border:none;min-width:100px'>".$blok."</td>
	<td style='border:none'>".$qr1."</td>
	<td style='border:none'>".$qr2."</td>
	</tr>";
	$nama_pj	=	$val->nama;
	$nik		=	$val->nik;
	$hp			=	$val->hp;
	$email		=	$val->email;
}
 
if(!$nik)
{
	echo "<br> ";
	return false;
}

?>
<br>
<br>
 
                <div class="row col-md-12">
				  <div class="col-md-5 card">
				  
                            <a style='margin-top:5px' class="btn btn-block bg-white col-black waves-effect" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
                               aria-controls="collapseExample">
                            <i class="fa fa-address-card"></i>    Data Pemohon
                            </a>
                            <div class="collapse" id="collapseExample">
                               
                               <table class="entry  " width="100%">
					<tr class='bg-blue-grey'><td colspan="2">Data Profile</tr>
					<tr><td>Nama </td> <td><?php echo $nama_pj;?></td></tr>
					<td>  NIK</td>  <td><?php echo  $nik;?></td></tr>
					<td>  Hp</td> <td><?php echo $hp;?></td></tr>
					<td>Email</td> <td><?php echo $email;?></td></tr> 
					</table> 
                              
                            </div>
                      
				   
				   
				   
				   
				   
				   
				   
				<center>    <div id="camera"> Capture</div>	</center>
				  <div id="webcam">
                  <center>
                      <button type=button   onClick="preview()" class='col-blue-grey btn bg-white btn-block'><b>[ AMBIL PHOTO ]</b></button>
                  </center>  
                </div>
                <div id="simpan" style="display:none">
                    <input type=button value="Remove" onClick="batal()" class='btn bg-teal btn-block'>
                 
                </div>
            
                <div id="hasil"></div>
					 
				<b>	Nama Penerima :</b><br>
					<input type="text"   name='penerima' class='form-control' value="<?php echo $this->mdl->getPenerimaPersus($kode)?>"  >
					
				<b>	Tanggal diterima:</b><br>
					<input type="text" class='form-control' name="tgl" id='tgl' value="<?php echo $this->mdl->getTglAmbilPersus($kode)?>"   >
					 <hr>
					    <button type=button   onclick='simpan(`<?php echo  $kode;?>`)' class='btn btn-primary btn-block'> 
					    <i class="fa fa-print"> </i> 
					    Simpan & cetak tanda terima</button>
					    <hr>
				  </div>
				  
				  
                    <div class="col-md-6">
                       
					<table class="entry2 " width="105%">
					<tr class='bg-blue-grey col-white'>
					<td>NO</td> 
					<td>BLOK</td> 
					<td >QRCODE PAGI</td>
					<td >QRCODE SORE</td>
				
					</tr>
					<?php echo $lis;?>
					</table>
					</div>
	  </div>
				 
<script>	
 
 
function setKode(ke,id,kode,berlaku,urut,idblok)
{			var url="<?php echo base_url();?>penyerahan/setKode";
			 
			$.post(url,{ke:ke,id:id,kode:kode,idblok:idblok},function(data){
				  if(data=="false")
				  {
					  notif("Kode qrcode sudah pernah digunakan");
					   $("#kod1"+urut).val("");
				  }else if(data=="wrong")
				  {
					  notif("Maaf!! kode tidak cocok silahkan pilih gelang yang sesuai. ");
					   $("#kod1"+urut).val("");
				  }else{
					  var next=Number(urut)+1;
					  var awal=Number(urut);
					 if(ke==1)
					 {
						 if(berlaku==1)
						 {
							  $("#kod1"+next).focus();
							//   $("#kod1"+next).val("");
						 }else{
							  $("#kod2"+awal).focus();
							 //  $("#kod2"+awal).val("");
						 }
						 
						
					 }else{
						   
					   $("#kod1"+next).focus();
					   $("#kod1"+next).val("");
					    
					 }						 
				 
				  
				  }
			  });
}
</script>			


<script>
			$('#tgl').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "drops": "up",
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Min",
            "Sen",
            "Sel",
            "Rab",
            "Kam",
            "Jum",
            "Sab"
        ],
        "monthNames": [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Augustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ],
        "firstDay": 1
    },
    
}, function(start, end, label) { 
  
});

 
</script>

	 <script src="<?php echo base_url()?>/static/js/webcam.min.js"></script>
<script language="Javascript">
        // konfigursi webcam
        Webcam.set({
            width: 300,
            height: 250,
            image_format: 'jpg',
            jpeg_quality: 100
        });
        Webcam.attach( '#camera' );

        function preview() {
            // untuk preview gambar sebelum di upload
			count=1;
            Webcam.freeze();
            // ganti display webcam menjadi none dan simpan menjadi terlihat
            document.getElementById('webcam').style.display = 'none';
            document.getElementById('simpan').style.display = '';
        }
        var count=0;
        function batal() {
            // batal preview
            Webcam.unfreeze();
            count=0;
            // ganti display webcam dan simpan seperti semula
            document.getElementById('webcam').style.display = '';
            document.getElementById('simpan').style.display = 'none';
        }
        
         function simpan(kode_persus) {
			 var val = $("[name='penerima']").val(); 
			 var tgl = $("[name='tgl']").val(); 
			 if(!val || !tgl)
			 {
				 notif("Mohon isi nama penerima dan tanggal diterima.");
				 return false;
			 }
				$(".diambil_oleh1").html(val);
				$(".diambil_oleh2").html(val);
            // ambil foto
			var idt=$("[name='id_tamu']").val();
            Webcam.snap( function(data_uri) {
                
                // upload foto
                Webcam.upload( data_uri, '<?php echo base_url()?>penyerahan/setPenerimaPersus/?kode_persus='+kode_persus+'&penerima='+val+'&tgl='+tgl, function(code, text) {} );
				
                Webcam.unfreeze();
				cetak_bukti();
                document.getElementById('webcam').style.display = '';
                document.getElementById('simpan').style.display = 'none';
            } );
        }
	  $("#bukti").hide();	
	function cetak_bukti()
	{
		$("#bukti").show();
		 var divName	   	  	 = "bukti";
		 var printContents 	  	 = document.getElementById(divName).innerHTML;
		 var originalContents 	 = document.body.innerHTML; 
		 document.body.innerHTML = printContents; 
		 window.print(); 
		 document.body.innerHTML = originalContents;
		$("[name='kode']").val(null);
		$("[name='kode']").focus();
		 window.location.href="<?php echo base_url()?>penyerahan/persus";
	}
	 
    </script>
	
	<div id="bukti">
	<table border="1" width="100%" >
	<tr>
	<td colspan="2"><center>TANDA TERIMA</center></td>
	</tr>
	<tr>
	<td style="padding:10px">
	<span style='float:right'>   <?php echo $this->tanggal->hariLengkap(date("Y-m-d"),"/")." ".date("H:i:s");?> WIB</span> 
	Permohonan Khusus/Given : <?php echo $nama_pj;?><br> 
	 
	<hr>
	Diterima oleh : <span class='diambil_oleh1'><?php echo $nama_pj;?></span><br>
	Perolehan : <?php echo ($urut-1);?> Undangan<br>
	<?php
	if($jmlpagi)
	{
		echo 'Undangan upacara penaikan bendera (pagi) :   '.$jmlpagi.'  <br>';
	}
	if($jmlsore)
	{
		echo 'Undangan upacara penurunan bendera (sore) :   '.$jmlsore.'  <br>';
	}
	?>
	
	 
	
	<div style='float:right'>ttd Penerima<bR>
	<br>
	<br>
	<br>
	 <br>
	<u>&nbsp;<span class='diambil_oleh2'><?php echo $nama_pj;?></span>&nbsp;</u>
	</div>
	</td>
	</tr>
	</table> 
	</div>
	
	
	