
<script src="<?php echo base_url()?>plug/js/jquery-2.2.1.min.js"></script>
<script src="<?php echo base_url();?>plug/jqueryform/jquery.form.js"></script>

<div class="row" id="user-profile">
<div class="col-lg-12 col-md-12 col-sm-12" >
<div class="main-box clearfix">
<header class="main-box-header clearfix"><center>
<h2><b>DATA EVENT</b></h2></center>
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
				<th class='thead' axis="string">User</th>		
				<th class='thead' axis="string">Nama Event</th>		
				<th class='thead' axis="string">Lokasi</th>		
				<th class='thead' axis="string" >Pelaksanaan</th>		
				<th class='thead' axis="string" >Quota</th>		
				<th class='thead' axis="string">Kehadiran</th>		
				<th class='thead' axis="string">validasi</th>		
				
			</thead>
</table>
</span>

</div>
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
            "url": "<?php echo site_url('data_event/ajax_open/'.$this->uri->segment(3).'')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0,1,2,3,4,5,6,7,-0 ], //last column
          "orderable": false, //set not orderable
        },
        ],

      });
    });

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }
	
	 function deleted(id_event,id)
    {
      if(confirm('Are you sure delete this event?'))
      {
        // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>data_event/deletedEvent/"+id_event+"/"+id,
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
function cekal(id)
{
  // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>data_event/cekal/"+id,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
              reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
}
</script>
<script>
function izinkan(id)
{
  // ajax delete data to database
          $.ajax({
            url : "<?php echo base_url();?>data_event/izinkan/"+id,
            type: "POST",
            data: "JSON",
            success: function(data)
            {
              reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
}
</script>