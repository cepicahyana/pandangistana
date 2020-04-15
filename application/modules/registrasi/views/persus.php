 <style>
     .tag{
         font-size:14px;
     }
 </style>
  
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  id="area_formSubmit">
				
                    <div class="card">
					<div class="card-header">
									<div class="card-title">Input Permohonan Khusus</div>
								</div>
					  <form class="form-horizontal" id="formSubmit" action="javascript:submitForm('formSubmit')"
							method="post" url="<?php echo base_url()?>registrasi/insert_persus">
                        
                        <div class="card-body" >
                        
							
								 
			 

							
                                <div class="row clearfix">
                                    
                                                <input type="hidden" name='f[kode]' value='<?php echo date('YmdHis').$this->m_reff->acak(3);?>'   required class="form-control" >
                                                  
									
									 <div class="form-group   col-lg-2 col-md-2 col-sm-5 mt-sm-2 text-right">
                                       <label for="email">  Email  </label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line"> 
												
												 <input type="mail" name='f[email]'     class="form-control" >	 
											</div>
                                        </div>
                                    </div> 
									
									 <div class="form-group   col-lg-2 col-md-2 col-sm-5 mt-sm-2 text-right">
                                       <label for="email">  Kategory  </label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line"> 
												<select required name='f[jenis_permohonan]' class='form-control'>
												<option value=""> ---- pilih ----</option>
												<option value='3'>Given</option>
												<option value='2'>Permintaan Khusus</option>
												</select>
												 
											</div>
                                        </div>
                                    </div> 
									
									
                                </div>  
							 
								<div class="row  clearfix">
								     
									  <div class="form-group form-show-validation  col-lg-2 col-md-2 col-sm-5 mt-sm-2 text-right">
                                        <label for="nik" >  Atas Nama</label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name='f[nama]' required   required class="form-control" >
                                            </div>
                                        </div>
                                    </div>
									

                                  
									<div class="form-group   col-lg-2 col-md-2 col-sm-5 mt-sm-2 text-right">
                                       <label for="hp"  >  Nomor Hp  </label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line"> 
												
												 <input type="text" name='f[hp]'     class="form-control" >	 
											</div>
                                        </div>
                                    </div> 
									
									
                                </div>
								
								  
								 
								 
                                    
									
								 
									
							 <div class="row clearfix">		
								  <div class="form-group   col-lg-2 col-md-2 col-sm-5 mt-sm-2 text-right">
                                        <label for="password_2">  <b>Jumlah Pagi</b></label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                            
												 <input type="text" name='f[jml_pagi]'    class="form-control" >	 
												 
                                            </div>
                                        </div>
                                    </div>
									
								 
									
                                		
							 	
							  <div class="form-group   col-lg-2 col-md-2 col-sm-5 mt-sm-2 text-right">
                                        <label for="password_2">  <b>Jumlah Sore</b></label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                            
												 <input type="text" name='f[jml_sore]'   class="form-control" >	 
												 
                                            </div>
                                        </div>
                                    </div> 
                        </div> 
                              
								 
                                
						 <div class="row clearfix">			
								<div class="form-group   col-lg-2 col-md-2 col-sm-5 mt-sm-2 text-right">
                                        <label for="password_2">  <b>Keterangan</b></label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                            <input type="text" class="form-control" name='f[ket]'>  
                                            </div>
                                        </div>
                                    </div>			
                  </div>			
								 
								
								  
  <div > 
            </div>
			 
							 
							 
								
                                   <div class="col-md-12"><center>
								<button onclick="submitForm('formSubmit')"  class="  btn btn-primary  waves-effect fa fa-save">   Simpan </button> </button>
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
		
		
		
		
		