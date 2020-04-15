    <style>
    textarea{
        min-height:300px;
    }
    </style>
 
                <!-- Task Info -->
                <div class="col-lg-12 col-md-12 card">
                    <div >
                        <div class="card-header">
                        <b>  Autodispo untuk umum </b>
                          
							 
                        </div>
                         
                           <!----->
				 
                        <div class="row card-body">
                            
	 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="card">
                        
                        <div class="body"><center><b>DATA BLOK PAGI</b></center>
                            <div class="table-responsive">
                                <table class="entry2" width="100%">
                                    <thead>
                                        <tr >
                                            <th  class='bg-primary'>NO</th>
                                            <th  class='bg-primary'>NAMA BLOK</th>
                                            <th  class='bg-primary'>QUOTA</th>
                                            <th  class='bg-primary'>DISPO</th>
                                            <th  class='bg-primary'>DISTRIBUSI</th>
                                            <th  class='bg-primary'>AUTODISPO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$datablokpagi=$this->db->query("select * from tr_blok where jenis=1 order by nama asc ")->result();
									$no=1;
									foreach($datablokpagi as $val)
									{
									?>
                                      <tr>
									  <td><?php echo $no++;?></td>
									  <td> <?php echo $val->nama;?></td>
									  <td><?php echo $this->umum->jmlQuota(1,$val->id);?></td>
									  <td><?php echo $this->umum->jmlDispoByBlok(1,$val->id);?></td>
									  <td><?php echo $this->umum->jmlDistribusi(1,$val->id);?></td>
									  <td>
									  <div class="form-check">
												<label class="form-check-label">
													<input class="form-check-input" value="1" type="checkbox" name='cek<?php echo $val->id;?>'>
													<span class="form-check-sign">pilih</span>
												</label>
											</div>
									  
									  </td>
									   
									  </tr>  
									<?php } ?>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                        </div>


						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="card">
                        
                        <div class="body"><center><b>DATA BLOK SORE</b></center>
                            <div class="table-responsive">
                                <table class="entry" width="100%">
                                    <thead >
                                        <tr class="bg-pink">
                                            <th>NO</th>
                                            <th>NAMA BLOK</th>
                                            <th>QUOTA</th>
                                            <th>DISPO</th>
                                            <th>DISTRIBUSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$databloksore=$this->db->query("select * from tr_blok where jenis=2 order by nama asc ")->result();
									$no=1;
									foreach($databloksore as $val)
									{
									?>
                                      <tr>
									  <td><?php echo $no++;?></td>
									  <td> <?php echo $val->nama;?></td>
									  <td><?php echo $this->umum->jmlQuota(2,$val->id);?></td>
									  <td><?php echo $this->umum->jmlDispoByBlok(2,$val->id);?></td>
									  <td><?php echo $this->umum->jmlDistribusi(2,$val->id);?></td>
									   
									  </tr>  
									<?php } ?>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                        </div>		
					 					
					 
                           <!----->
                        </div>
                    </div>
                </div>
                <!-- #END# Task Info -->
				
 
  
	
 

	
 
   
<script>
 
  
  //$('#val_6').jqte();
 
 function save_(idpengaturan,idkonten)
	 {	 
	 var idkonten=$("[name='"+idkonten+"']").val();
		 $.ajax({
		 url:"<?php echo base_url()?>konfigurasi/save_",
		 data: "idpengaturan="+idpengaturan+"&idkonten="+idkonten,
		 method:"POST",
		 success: function(data)
            {	 
				 notif("   Tersimpan! ");
            }
		});
	 }
	 
    
	
</script>


 