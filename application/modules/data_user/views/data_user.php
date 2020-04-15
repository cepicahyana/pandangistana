  <script src="<?php echo base_url();?>plug/js/jquery-2.2.1.min.js"></script>


<div class="row">
<div class="col-lg-12">
<div class="main-box clearfix ">

<header class="main-box-header clearfix">
<h2 class="sadow05 black b">Data User <a href="javascript:add()" class="btn btn-primary pull-right">
<i class="fa fa-plus-circle fa-lg"></i> Add Data User
</a></h2>

</header>
<div class="main-box-body clearfix ">

<table id='table' class="tabel black table-striped table-bordered table-hover dataTable">
		  	<thead>			
				<th class='thead' axis="string" width='15px'>No</th>
				<th class='thead' axis="date">Photo</th>
				<th class='thead' axis="date">Nama</th>
				<th class='thead' axis="string">Telphone</th>
				<th class='thead' axis="string">E-mail</th>
				<th class='thead' axis="string">Alamat</th>			
				<th class='thead' axis="string">Updated</th>			
				<th class='thead' axis="string">Saldo (Rp)</th>			
				<th class='thead' axis="string">Event</th>			
				<th class='thead' axis="string">Form</th>			
				<th class='thead' axis="string" >Invoice</th>			
				<th width='100px'>&nbsp;</th>
			</thead>
</table>




</div>
</div>
</div>
</div>
<!--<link href="http://localhost/ajax_crud_datatables/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">-->
  <link href="<?php echo base_url();?>/plug/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
  <script src="<?php echo base_url()?>plug/datatables/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url()?>plug/datatables/js/dataTables.bootstrap.js"></script>			




  <script type="text/javascript">
      var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#table').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('data_user/ajax_open/'.$this->uri->segment(3).'')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0,-1,-2,-3,-4,-5 ], //last column
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
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
          $.ajax({
            url:"<?php echo base_url();?>data_user/deleted_UG/"+id,
            type: "POST",
            dataType: "JSON",
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
	
	
	
	function pilih(id)
	{
	$.ajax({
		url:"<?php echo base_url();?>data_user/dropdownHak/"+id,
		type: "POST",
		data:"",
		 success: function(data)
				{
				$('#pilih').html(data);
				}
		});
	}

	function edit(id)
    {
	$("#gambar").attr("required", false);
	$("#inputPassword1").attr("required", false);
	save_method="update";
	$("#msg").html("");
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
	  //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo base_url();?>data_user/ajax_edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {	 pilih(id)
            $('[name="Hak"]').val(data.id_admin);
            $('[name="owner"]').val(data.owner);
            $('[name="telp"]').val(data.telp);
            $('[name="email"]').val(data.email);
            $('[name="username"]').val(data.username);
            $('[name="alamat"]').val(data.alamat);
           					
            $('#modaledit').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').html('<b>Edit Data</b>'); // Set title to Bootstrap modal title
			
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    }
	
	function uploadUlang()
	{
	var tanya=confirm("upload file baru ?");
	if(tanya==true)
	{
	$(".inputan").hide();
	$("#inputan").show();
	}
		
	}
	
	function chat(id)
    {
      $.ajax({
        url : "<?php echo base_url();?>data_user/modalChat/" + id,
        type: "GET",
         success: function(data)
        {	 
            
            $('#chat').modal('show'); // show bootstrap modal when complete loaded           
            $('#loadchat').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
	}
	
	
	function saldo(id)
    {
	$('#formSaldo')[0].reset(); // reset form on modals
      $.ajax({
        url : "<?php echo base_url();?>data_user/ceksaldo/" + id,
        type: "GET",
		dataType:"JSON",
         success: function(data)
        {	 
            $("input[name='saldo']").val(data.saldo);
            $("input[name='id']").val(id);
            $('#saldo').modal('show'); // show bootstrap modal when complete loaded           
           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
	}

	function simpanSaldo()
    {
	var  url ="<?php echo base_url();?>data_user/saveSaldo/";
		$.ajax({
            url : url,
            type: "POST",
            data: $('#formSaldo').serialize(),
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
               $('#saldo').modal('hide');
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
	}
   </script>		
  
  <!-- Bootstrap modal -->
  <div class="modal fade" id="chat" role="dialog" >
		<div class="modal-dialog">
		<div id="loadchat"></div>
         </div>
   </div>
<!---------------------->

 <!-- Bootstrap modal -->
  <div class="modal fade" id="saldo" role="dialog">
		<div class="modal-dialog">
               <div class="md-content">
				<div class="modal-header">
				<button data-dismiss="modal" class="md-close close">&times;</button>
				<h4 class="modal-title"><b>Saldo Deposit</b></h4>
				</div>
				<div class="modal-body">
	<form action="#" id="formSaldo" class="form-horizontal">
<input type="hidden" name="id" >

<div class="form-group" >
	<label for="" class="col-lg-2 control-label">saldo</label>
		<div class="col-lg-9 form-group-select2">
			<input type="text" class="form-control" name="saldo" id="saldo" >
		</div>
		</div>
</form>
 <div class="modal-footer">
            <button type="submit" id="btnSave" class="btn btn-primary pull-right" onclick="simpanSaldo()" >Save</button>
			<span id="msg" style='padding-right:15px;margin-top:20px'></span>
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
          </div>
       

				</div>
				</div>
						
				</div>
         </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
<!---------------------->

  
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modaledit" role="dialog">
		<div class="modal-dialog">
               <div class="md-content">
				<div class="modal-header">
				<button data-dismiss="modal" class="md-close close">&times;</button>
				<h4 class="modal-title"><b>Add User Akun</b></h4>
				</div>
				<div class="modal-body">
	<form  action="javascript:simpan()" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
<input type="hidden" name="Hak" >

<div class="form-group" style='display:none'>
	<label for="" class="col-lg-2 control-label">Level</label>
		<div class="col-lg-9 form-group-select2">
			<input type="text" class="form-control"  value='3' name="level" id="gambar" >
		</div>
		</div>


<div class="form-group">
	<label for="poto" class="black col-lg-2 control-label">Photo</label>
	 <div class="col-lg-9">
		<input type="file" class="form-control"  value='' name="gambar" id="gambar" >
	 </div>
</div>

<div class="form-group">
	<label for="inputNama" class="black col-lg-2 control-label">Nama</label>
	 <div class="col-lg-9">
		<input required type="text" class="form-control"  value='' name="owner" id="inputNama" placeholder="Nama ">
	 </div>
</div>

<div class="form-group">
	<label for="inputTelp" class="black col-lg-2 control-label">No.Telp</label>
	 <div class="col-lg-9">
		<input  type="text" class="form-control"  value='' name="telp" id="inputTelp" placeholder="Nomor Telpon">
	 </div>
</div>

<div class="form-group">
	<label for="inputEmail1" class="black col-lg-2 control-label">E-mail</label>
	 <div class="col-lg-9">
		<input  type="email" class="form-control"  value='' name="email" id="inputEmail1" placeholder="Email">
	 </div>
</div><div class="form-group">
	<label for="inputalamat" class="black col-lg-2 control-label">Alamat</label>
	 <div class="col-lg-9">
		<input  type="text" class="form-control"  value='' name="alamat" id="inputalamat" placeholder="Alamat">
	 </div>
</div>

<div class="form-group">
	<label for="inputuser" class="black col-lg-2 control-label">Username</label>
	 <div class="col-lg-9">
		<input required type="text" class="form-control" value='' name="username" id="inputuser" placeholder="Username">
	 </div>
</div>

<div class="form-group">
	<label for="inputPassword1" class="black col-lg-2 control-label">Password baru</label>
	 <div class="col-lg-9">
		<input type="text" class="form-control"  name="password" id="inputPassword1" placeholder="Password baru (jika password akan diubah)">
	 </div>
</div>


 <div class="modal-footer">
            <button type="submit" id="btnSave" class="btn btn-primary pull-right" onclick="javascript:simpan()">Save</button>
			<span id="msg" style='padding-right:15px;margin-top:20px'></span>
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
          </div>
       
</form>
				</div>
				</div>
						
				</div>
         </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
		

<script src="<?php echo base_url('plug/jqueryform/jquery.form.js');?>"></script>
<script type="text/javascript">
var save_method="";
function add()
	{
	save_method="add";
	 $('#form')[0].reset(); // reset form on modals
	$("#gambar").attr("required", "true");
	$("#inputPassword1").attr("required", "true");
	 pilih("0");
	$("#msg").html("");
	$('#modaledit').modal('show'); 
	}
	
	
	
function simpan(){
var pass=$("#inputPassword1").val();
if(pass!=null && pass!=""){
$('#msg').html('<img src="<?php echo base_url();?>plug/img/load.gif"/> Loading...');
}
    var id=$('[name="Hak"]').val();
	if(save_method=="add"){
	var link='<?php echo base_url("data_user/add_dataUser"); ?>'; }
	  else{
	 var link='<?php echo base_url("data_user/update_profile"); ?>/'+id; }
	
	
    $('#form').ajaxForm({
	 url:link,
     data: $('#form').serialize(),
	 dataType: "JSON",
     success: function(data)
            {
			$("#inputPassword1").val("");
			if(data==true){
			 $('#msg').html('<font color="green"><i class="fa fa-check-circle fa-fw fa-lg"></i> Berhasil disimpan.</font>');
			  $('#modaledit').modal('hide');
               reload_table();
			}else{
			$("#inputuser").val("");
			 $('#msg').html('<font color="red"><i class="fa fa-warning fa-fw fa-lg"></i>Silahkan cari username/password lain!</font>');
			}
			

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
    });     
};
</script> 
