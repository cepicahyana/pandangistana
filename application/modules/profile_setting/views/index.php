<style>
    .upload {
        border: #DCDCDC dashed 1px;
    }
</style>

<?php 
//$jkl=$jkp=""; if($data->jk=="l"){ $jkl="checked";}else{ $jkp="checked";}
$profileimg=isset($data->poto)?($data->poto):'';	
if($profileimg!=''){$img=$profileimg;}else{$img='img_not.png';}	
?>

   
    <div class="row col-md-12">
        <div class="col-md-12" id="area_formSubmit">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Profile</h5>
                </div>
                <div class="card-body">
                    <form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post" url="<?php echo site_url('profile_setting/update');?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <center class="hide">
                                    <label>
                                        <div style="max-width:300px">
                                            <b>	PHOTO PROFILE</b>
                                            <br>
                                            <img class="img-responsive" style="width:200px;height:200px;border-radius:20px;border:#F5F5DC solid 2px;padding:5px;margin-top:20px;margin-bottom:20px;" id="blah" src="<?php echo base_url()?>file_upload/user/<?php echo $profileimg;?>" alt="" height="100px" />
                                            <input type='file' accept=".JPG,.jpg,.png" name="poto" id="imgInp" class="form-control upload" />
                                            <br>
                                        </div>
                                    </label>
                                </center>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group fill">
                                    <label for="">Nama  </label>
                                    <input type="text" class="form-control" name="f[owner]" value="<?php echo $data->owner;?>">
                                </div>
                                
                                <div class="form-group fill">
                                    <label for="">Telp</label>
                                    <input type="text" class="form-control" name="f[telp]" value="<?php echo $data->telp;?>" required>
                                </div> 
								<div class="form-group fill">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" name="f[username]" value="<?php echo $data->username;?>" required>
                                </div>
                                 
                                <div class="form-group fill">
                                    <label for="">Password Baru</label>
                                     <input type="password" class="form-control" name="password" value="">
                                </div>

								<div class="form-group fill">
                                    <label for="">Ketik ulang password </label>
                                     <input type="password" class="form-control" name="cpassword" value="">
                                </div>
                            </div> 
                        </div>
                        <div class="row justify-content-between btn-page">
                            <div class="col-sm-6">
                                <span class="pull-right" id="msg"></span>
                            </div>
                            <div class="col-sm-6 text-md-right">
                                <button onclick="submitForm('formSubmit')" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                    $('.image img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
		function reload_table()
		{
		}
    </script>