<style>
a{
	color:black;
}
</style>
<?php $con=new umum(); 
  
$date=$this->db->query("SELECT DISTINCT(SUBSTR(tgl,1,10)) AS tgl FROM data_peserta   order by tgl asc")->result();
$dbase[]=array();
$dbasex[]=array();

$tglin=date("Y-m-d H:i:s");
if($tglin<=date("Y-m-d 14:00:00"))
{
  $sd=$this->session->set_userdata("dates",1);
  $value="1";
}else{
  $sd=$this->session->set_userdata("dates",2);
  $value="2";
}
 
 
 


 ?>
</div>
 
  
  <!-- End Bootstrap modal -->
  <script>
  function pb(id)
	{
    // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/getPb/"+id,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
			var dt=data.split("::");
            var idp=$("#idPeserta").val(dt[0]);
            var vket=$(".pb").val(dt[1]);
            $(".tpb").html(dt[2]);
            $("#pb").modal("show");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	
	function sv(id)
	{
    // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/getSv/"+id,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
			var dt=data.split("::");
            var idp=$("#idPeserta").val(dt[0]);
            var vket=$(".sv").val(dt[1]);
			   $(".tsv").html(dt[2]);
            $("#sv").modal("show");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	  
	
	function blokan(id)
	{
            $.ajax({
            url : "<?php echo base_url();?>notif/getBlok/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
				var idp=$("#idblokan").val(data["id"]);
				var vket=$(".blokan").val(data["blok"]);
				$("#blokan").modal("show");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	  
	
	function berlakukan(id)
	{
            $.ajax({
            url : "<?php echo base_url();?>notif/getberlaku/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
				var idp=$("#idberlaku").val(data["id"]);
				var vket=$(".berlaku").val(data["berlaku"]);
				$("#berlakukan").modal("show");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	  
	
	
	function pic(id)
	{
            $.ajax({
            url : "<?php echo base_url();?>notif/getpic/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
				var idp=$("#idpic").val(data["id"]);
				var vket=$(".pic").val(data["pic"]);
				$("#pican").modal("show");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	  
	
	 
	function saveSv()
	{
	var idp=$("#idPeserta").val();
	var makan=$(".sv").val();
	// ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/saveSv",
            type: "POST",
            data: "idPeserta="+idp+"&sv="+makan,
            success: function(data)
            {
              reload_table()
              $("#sv").modal("hide");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	
	
	function savePb()
	{
	var idp=$("#idPeserta").val();
	var makan=$(".pb").val();
	// ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/savePb",
            type: "POST",
            data: "idPeserta="+idp+"&pb="+makan,
            success: function(data)
            {
              reload_table()
              $("#pb").modal("hide");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	
	
	function saveblokan()
	{
	var idp=$("#idblokan").val();
	var param=$(".blokan").val();
	// ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/saveblokan",
            type: "POST",
            data: "idPeserta="+idp+"&blok="+param,
            success: function(data)
            {
              reload_table()
              $("#blokan").modal("hide");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	
	
	function savepic()
	{
	var idp=$("#idpic").val();
	var param=$(".pic").val();
	// ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/savepic",
            type: "POST",
            data: "idPeserta="+idp+"&pic="+param,
            success: function(data)
            {
              reload_table()
              $("#pican").modal("hide");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	
	
	function saveberlaku()
	{
	var idp=$("#idberlaku").val();
	var param=$(".berlaku").val();
	// ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/saveberlaku",
            type: "POST",
            data: "idPeserta="+idp+"&berlaku="+param,
            success: function(data)
            {
              reload_table()
              $("#berlakukan").modal("hide");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	
	
	
	function saveMakan()
	{
	var idp=$("#idPeserta").val();
	var makan=$(".makan").val();
	// ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/saveMakan",
            type: "POST",
            data: "idPeserta="+idp+"&makan="+makan,
            success: function(data)
            {
              reload_table()
              $("#makan").modal("hide");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}	
	
	function saveket()
	{
	var idp=$("#idPeserta").val();
	var vket=$(".vket").val();
	// ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/saveket",
            type: "POST",
            data: "idPeserta="+idp+"&ket="+vket,
            success: function(data)
            {
              reload_table()
              $("#ket").modal("hide");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}
  </script>
  
    
  
  <!-- Bootstrap modal -->
  <div class="modal fade" id="berlakukan" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title- black"><b>PENANGGUNG JAWAB</b></h4>
      </div>
      <div class="modal-body form">
		<input type="hidden" id="idberlaku">
        <input type="text" class="form-control berlaku"></input><br>
		  
		<button class='btn btn-primary' onclick="saveberlaku()">simpan</button>
      </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->  
  
  
   
  
  
  
  
  <!-- Bootstrap modal -->
  <div class="modal fade" id="ket" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title- black"><b>Class</b></h4>
      </div>
      <div class="modal-body form">
	  <input type="hidden" id="idPeserta">
        <input type="text" class="form-control vket"></input><br>
		<button class='btn btn-primary' onclick="saveket()">simpan</button>
      </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->  
  
  
    
	
	
<script>	
function import_file(id)
    {
	
	  $('#modal_form_import').modal('show'); // show bootstrap modal

    }
</script>		
	
<script>	
function import_file_khusus(id)
    {
	
	  $('#modal_form_import_khusus').modal('show'); // show bootstrap modal

    }
</script>	
	
	
	
	
	 <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_edit" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title  black"><b>Edit</b></h4>
      </div>
      <div class="modal_edit form">
        
          
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	</div>
  <!-- End Bootstrap modal -->	
	
	
	
	 
  
  
  
  
	<!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form_import_khusus" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title- black"><b>Import Data Peserta Format Khusus</b></h4>
      </div>
      <div class="modal-body form">
       
		 
 
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h5 class="box-title">Silahkan <a href='<?php echo base_url();?>FORMAT1.xlsx'>
		  download template</a> sebelum upload.</h5>
        </div><!-- /.box-header -->
          <div class="box-body">                      
            <form role="form" name="uploadfilexl_khusus" id="uploadfilexl_khusus" 
                  action="javascript:simpanfile_khusus();" method="post" enctype="multipart/form-data">
                <div class="form-groups">
                  <input id="userfile" required name="userfile" type="file" class="form-control">
                </div><br>
				    <div class="form-group">
				 <select name='mode' required class="form-control">
				 <option value="">--- Pilih Mode ---</option>
				 <option value="1">Cek dulu</option>
				 <option value="2">Langung Tambahkan</option>
				 </select>
                     
                  </div>
				 
				<br>
                <button type="submit" onclick="javascript:simpanfile_khusus();" class="btn pull-right bg-teal">
                    <i class="material-icons">file_upload</i>&nbsp;Upload
                </button>
				<br>
                <div class="form-group">
                    <div class="hasil_khusus"></div>
                    <div class="hasil_khusus_data"></div>
                </div>
            </form>
          </div><!-- /.box-body -->
      </div><!-- /.box -->
 
 
 

          </div>
           
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
  
  
  
               <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card" >
                        <div class="header"> 
						
						
                        
					 
						
						<h2 class="sound">KIRIM NOTIFIKASI</h2> 
                        </div>
						    <div class="body"> 
				 <div class="cards" id="area_lod">
			            <div class="body">
                            <div class="table-responsives">
<?php $date=date("Y-m-d");?>
						
<span style='color:black;position:absolute;margin-top:-40px;z-index:222' class="cursor btnhapus">
 <a class="  btn bg-teal" href="#" onclick="kirim()"><i class='material-icons'>send</i> Kirim Notifikasi Pengambilan</a> 
 <input type="text" id="tgl" class='form-control'>
</span>


<form action="#" name="delcheck" id="delcheck" class="form-horizontal" method="post">
<table id='table' class="tabel black table-striped table-bordered table-hover dataTable">
 <tr> 		  	<thead class='bg-teal'>	
<th class='thead col-white'   width='5px' rowspan="2">
  
                                <input type="checkbox" id="md_checkbox"  value="ya" class="pilihsemua filled-in chk-col-red"   />
                                <label for="md_checkbox" class="col-white">&nbsp;</label>
						 
</th>		
				<th rowspan="2" class='thead' axis="string" width='15px'>No</th>
				 
				<th rowspan="2" class='thead'>NAMA PEN.JAWAB</th>
				<th rowspan="2"  class='thead'>LEMBAGA INSTANSI</th>
				<th colspan="2"  class='thead ' ><center>DISPOSISI</center></th> 
				<th rowspan="2"  class='thead  '  ><center>STATUS</center></th> 
			 
			 </tr>
			 <tr> 
				<th   class='thead '>PAGI</th> 
				<th   class='thead  '>SORE</th>  
				 
			</tr>
			</thead>
</table>
</form>
</div>
						</div>						
					</div>	
                           <!----->
                        </div>
                    </div>
                </div>
                <!-- #END# Task Info -->
				 
	 
		</div>
 
 
 
	
  <script type="text/javascript">
	 
   var  dataTable = $('#table').DataTable({ 
	 
        "processing": true, //Feature control the processing indicator.
		"language": {
						"processing": ' <span class="sr-only">Loading...</span> <br><b style="color:#;background:white">Proses menampilkan data<br> Mohon Menunggu..</b>',
						  "oPaginate": {
							"sFirst": "Halaman Pertama",
							"sLast": "Halaman Terakhir",
							 "sNext": "Selanjutnya",
							 "sPrevious": "Sebelumnya"
							 },
						"sInfo": "Total :  _TOTAL_ , Halaman (_START_ - _END_)",
						 "sInfoEmpty": "Tidak ada data yang di tampilkan",
						   "sZeroRecords": "Data tidak tersedia",
						  
				    },
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		 "responsive": false,
		 "searching": true,
		 "lengthMenu":
		 [[12, 24,36,48,60,72,84, 96,108,120,1000,2000,3000,20000], 
		 [12, 24,36,48,60,72,84, 96,108,120,1000,2000,3000,20000,"All"]],
         dom: 'Blfrtip',
		buttons: [
           // 'copy', 'csv', 'excel', 'pdf', 'print'
			 
		/*	 {
					extend: 'excel',
                        exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8   ]
                },text:'Download Excell',
							
                    },
					
				
					{extend: 'colvis',
                        exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6,7,8 ]
                },text:' Kolom',
							
                    },
					 
					*/
        ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('notif/ajax_peserta/'.$this->uri->segment(3).'')?>",
            "type": "POST",
			"data": function ( data ) {
						
						  data.sts_notif = 0; 
						 
		 },
		   beforeSend: function() {
               loading("area_lod");
            },
			complete: function() {
              unblock('area_lod');
            },
		 
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0    ], //last column
          "orderable": false, //set not orderable
        },
        ],
	
      });
    
  
	
	//   $(document).on('change', '#cadangan,#gate,#waktu,#status,#nama_file,#blok,#lembaga,#pic,#no_surat,#cetak', function (event, messages) {			
	//		  dataTable.ajax.reload(null,false);  
   //     });
		
		 function reload_table()
    {
      dataTable.ajax.reload(null,false); //reload datatable ajax 
    }
	
 


</script>
  
	
	
	 <script>
  
	function kirim()
	{	
	 var tgl = $("#tgl").val();
	 var checkbox_value = "";
    $("[name='hapus[]']").each(function () {
        var ischecked = $(this).is(":checked");
        if (ischecked) {
            checkbox_value += $(this).val() + ",";
        }
    });
           	 alertify.confirm("<center>Kirim Notifikasi  ?</center>",function(){
           	 $.post("<?php echo base_url();?>notif/kirim/",{id:checkbox_value,tgl:tgl},function(){
        			//	notif("Data berhasil dihapus !!");			  
        			  reload_table();
        		      });
           	 });
		 
	}
 
	function rekap(set,id)
	{
		 $.post("<?php echo base_url();?>notif/setRekap/",{id:id,set:set},function(){
			//	notif("Data berhasil dihapus !!");			  
			  reload_table();
		      });
		   
	}
	 
	function hapusAll()
	{	
		var con=window.confirm("hapus data terpilih ?");
		if(con==false){ return false; };
		$.ajax({
		url:"<?php echo base_url();?>notif/hapusAll",
		type: "POST",
		data: $('#delcheck').serialize(),
	//	dataType: "JSON",
		success: function(data)
				{	 $(".btnhapus").hide();
					$(".pilihsemua").removeAttr("checked");
					$(".pilihsemua").val("ya");
					reload_table();
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Try Again!');
				}
		});
	}
  
  
  $(".btnhapus").hide();
  	$(".pilihsemua").click(function(){
	
		if($(".pilihsemua").val()=="ya") {
		$(".pilih").prop("checked", "checked");
		$(".pilihsemua").val("no");
		  $(".btnhapus").show();
		} else {
		$(".pilih").removeAttr("checked");
		$(".pilihsemua").val("ya");
		  $(".btnhapus").hide();
		}
	
	});
	
	function pilcek(){
		$(".btnhapus").show();
		$(".pilihsemua").removeAttr("checked");
		$(".pilihsemua").val("ya");
		 
	};
  
  </script>
  <script>
  $(".tabel-inputan").hide();
  $(".pratampil").hide();
  function addForm(){
  $(".tabel-inputan").fadeIn(1000);
  $("#dataTable").fadeOut(1000);
  $(".crt").hide();
  }
  </script>

  
 
  
  <script type="text/javascript">
  	 function date()
    {
      var date=$("#date").val();
        // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/sessiondate/"+date,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
         
     
    } 
	
	function deleted(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/deletePeserta/"+id,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
         
      }
    }	 
	
	
	function not(id)
    {
     
        // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/not/"+id,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
         
      
    }function not2(id)
    {
     
        // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/not2/"+id,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
         
      
    }
	
	function acc(id)
    {
     
        // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/acc/"+id+"/<?php echo $this->uri->segment(3);?>",
            type: "POST",
            data: "JSON",
            success: function(data)
            {
               //if success reload ajax table
			   if(data==3){ alert('Quota penuh!'); }
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
         
      
    }
	
	function acc2(id)
    {
     
        // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/acc2/"+id+"/<?php echo $this->uri->segment(3);?>",
            type: "POST",
            data: "JSON",
            success: function(data)
            {
               //if success reload ajax table
			   if(data==3){ alert('Quota penuh!'); }
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
         
      
    }
	
	
	
	function add(id)
	{
	// ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/addPeserta/"+id,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
               //if success reload ajax table
              $("#modal_form").modal("show");
              $(".bodyx").html(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	
	}
	
	function mode(id)
	{
	// ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>notif/modeEvent/"+id,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
              window.location.href="<?php echo base_url();?>notif/register/"+id;
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	
	}
	
	
	function getDispo(nik,jenis,nama)
	{
	    $.ajax({
            url : "<?php echo base_url();?>notif/getDispo",
            type: "POST",
            data: "nik="+nik+"&jenis="+jenis,
            success: function(data)
            {
               //if success reload ajax table
              $("#modal_edit").modal("show");
              $(".modal_edit").html(data);
              $(".modal-title").html(nama);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}
	
 
	
	$("select").selectpicker();
	

</script>




<script>
			$('#tgl').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "startDate": "<?php echo $this->tanggal->ind($this->tanggal->tambahTgl(date('Y-m-d'),3),"/")?>",
     
    "drops": "down",
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
 // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
 
});

 
</script>
 