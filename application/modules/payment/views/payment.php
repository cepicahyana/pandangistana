
<script src="<?php echo base_url()?>plug/js/jquery-2.2.1.min.js"></script>
<script src="<?php echo base_url();?>plug/jqueryform/jquery.form.js"></script>

<div class="row" id="user-profile">
<div class="col-lg-12 col-md-12 col-sm-12" >
<div class="main-box clearfix">
<header class="main-box-header clearfix"><center>
<h2><b>INVOICE</b></h2></center>
</header>
<div class="main-box-body clearfix">
<div class="profile-status">
</div>



<span id="dataTable">
<b><center>
</center></b>
<table id='table' class="tabel black table-striped table-bordered table-hover dataTable">
		  	<thead>			
				<th class='thead' axis="string" width='15px'>No</th>
				<th class='thead' axis="string">No.Invoice</th>		
				<th class='thead' axis="string">Event</th>		
				<th class='thead' axis="string" >Tanggal Invoice</th>		
				<th class='thead' axis="string" >Jatuh tempo</th>		
				<th class='thead' axis="string">Total Tagihan</th>		
				<th class='thead' axis="string">Status</th>		
				<th class='thead' axis="string"></th>		
				
			</thead>
</table>
</span>

</div>
</div>
</div>

<div class="col-lg-6 col-md-6 col-sm-6 main-box pratampil" >
<header class="main-box-header clearfix">
<h2><b><span>Pratampil Formulir</span></b></h2>
</header>
<div class="main-box-body clearfix">

<div class="form-group">
	<label for="inputPassword1" class="black col-lg-3 control-label">Password baru</label>
	 <div class="col-lg-9">
		<input type="text" class="form-control"  name="password" id="inputPassword1" placeholder="Password baru (jika password akan diubah)">
	 </div>
</div>
<br>
<button class="btn btn-success pull-right"><i class='fa fa-save'></i> simpan</button>
<span id="msg" class="pull-right" style='padding-right:50px;margin-top:5px'></span>
</div>
</div>



  <link href="<?php echo base_url();?>/plug/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
  <script src="<?php echo base_url()?>plug/datatables/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url()?>plug/datatables/js/dataTables.bootstrap.js"></script>	
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
      var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#table').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('payment/ajax_open/'.$this->uri->segment(3).'')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0,1,2,3,4,5,6,-0 ], //last column
          "orderable": false, //set not orderable
        },
        ],

      });
    });

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }
	
	 function deleted(id)
    {
      if(confirm('Are you sure delete this invoice?'))
      {
        // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>payment/deleteInvoice/"+id,
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

</script>

<script>
function tampil(id,nama)
{

  // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>form/tampil/"+id,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
              $("#tampil").modal("show");
              $("#dataload").html(data);
              $(".modal-title").html("<b>"+nama+"</b>");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
}
</script>

	
<!-- Bootstrap modal -->
  <div class="modal fade" id="tampil" role="dialog" >
		<div class="modal-dialog">
               <div class="md-content">
				<div class="modal-header">
				<button data-dismiss="modal" class="md-close close">&times;</button>
				<h4 class="modal-title"><b>Formulir</b></h4>
				</div>
				<div class="modal-body">
				<span id="dataload"></span>
				</div>
				</div>
		</div>
   </div><!-- /.modal-dialog -->
<!-- End Bootstrap modal -->

