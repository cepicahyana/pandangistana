 <style>
     .tag{
         font-size:14px;
     }
 </style>
  
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  id="area_formSubmit">
				
                    <div class="card">
					<div class="card-header">
									<div class="card-title">Import data </div>
								

							</div>
					  <form class="form-horizontal" id="formSubmit" action="javascript:submitForm('formSubmit')"
							method="post" url="<?php echo base_url()?>registrasi/import_persus">
                        
                        <div class="card-body" >
                        
							
								
			            <center> <a href="<?php echo base_url()?>format.xlsx"><i class='fa fa-download'></i> Download Format File</a></center>   <br> 

							
                                <div class="row clearfix">
                     
                                     <div class="form-group   col-lg-2 col-md-2 col-sm-5 mt-sm-2 text-right">
                                       <label for="id_kategory">  Kategory  </label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line"> 
												<select required name='id_kategory' class='form-control'>
												<option value=""> ---- pilih ----</option>
												<option value='3'>Given</option>
												<option value='2'>Permintaan Khusus</option>
												</select>
												 
											</div>
                                        </div>
                                    </div> 
									             
									
									 <div class="form-group   col-lg-2 col-md-2 col-sm-5 mt-sm-2 text-right">
                                       <label for="Upload"> Upload File  </label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line"> 
												
												 <input type="file" required name='file'     class="form-control" >	 
											</div>
                                        </div>
                                    </div> 
									
									 
									
                                </div>  
							 
								 
					 
								  
  <div > 
            </div>
			 
							<hr> 
							 
								
                                   <div class="col-md-12"><center>
								<button onclick="submitForm('formSubmit')"  class="  btn btn-primary  waves-effect fa fa-upload">   Upload </button> </button>
                                 </center>   </div>
                                 <div class="rows">&nbsp;</div>
								 <br>
                            
                        </div>
                    </div>
					</form>
                </div>
            
			
		<script>
function reload_table()
{
}	
 
		</script>	
		
		
		
		
		