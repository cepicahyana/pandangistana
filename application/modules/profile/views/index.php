<?php 
    $data=$this->mdl->dataProfile();

    if ($data->poto !== NULL || $data->poto !== "") {
        $foto = "file_upload/admin/".$data->poto;
    }
    else{
        $foto = "file_upload/admin/dummy-user.jpg";
    }
?> 

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Profile</div>
        </div>

        <form method="POST" enctype="multipart/form-data" url="<?php echo base_url() ?>profile/updateProfile" action="javascript:submitForm('formSubmit')" id="formSubmit">

            <div class="row card-body" style='padding-top:10px;padding-bottom:20px' id="area_formSubmit">
                <input type="hidden" value="<?php echo $data->id_admin ?>" name="id">
                <div class="col-md-12 text-center">
                    <div class="form-group">
                        <div style="width: 150px;border-radius: 50%;overflow: hidden;margin:auto">
                            <img src="<?php echo base_url().$foto; ?>" class="img-fluid" id="photo" style="width: 150px"  />
                        </div>
                        <br>
                        <div style="margin: auto;width: 200px;">
                            <input type="file" class="form-control" name="photo" id="imgInp">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="f[owner]" class="form-control" value="<?php echo $data->owner ?>" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="f[email]" class="form-control" value="<?php echo $data->email ?>" required />
                    </div>
                </div>  
                <div class="col-md-4">
                    <div class="form-group">
                        <label>No. HP</label>
                        <input type="text" name="f[telp]" class="form-control" value="<?php echo $data->telp ?>" />
                    </div>
                </div>
                <!--
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" rows="10" name="f[alamat]"><?php echo $data->alamat ?></textarea>
                    </div>
                    <hr>
                </div>-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="f[username]" class="form-control" value="<?php echo $data->username ?>" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ubah Password</label>
                        <input type="password" name="password" class="form-control" value="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ketik Ulang Password</label>
                        <input type="password" name="password2" class="form-control" value="" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button class="btn btn-primary" type="submit" onclick="javascript:submitForm('formSubmit')"><i class="fas fa-save"></i> SIMPAN PERUBAHAN</button>
                    </div>
                </div>   
            </div>

        </form>

    </div>
</div>


<script>
function reload_table()
{
	
}

    $("#imgInp").change(function() {
      readURLImg(this);
    });

    function readURLImg(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#photo').attr('src', e.target.result);
          $('.avatar-img').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
      }
    }
</script>
 