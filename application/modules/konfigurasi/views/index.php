    <style>
    textarea{
        min-height:300px;
    }
    </style>
 
                <!-- Task Info -->
                <div class="col-lg-12 col-md-12 card">
                    <div >
                        <div class="card-header">
                        <b>  Konfigurasi </b>
                          
							 
                        </div>
                         
                           <!----->
				 
                        <div class="row card-body">
                            <div class="table-responsive col-md-12">
                               <table id='table' class="tabel black table-bordered  table-hover dataTable" style="width:100%">
								<thead  class='sadow bg-blue'>			
									<th class='thead' axis="string" width='15px'>&nbsp;NO</th>
								
									<th class='thead' >Konfigurasi </th>
									<th class='thead' >Value </th>
									 
								</thead>
								<?php   $no=1;?>
								<tr>
								<td><?php echo $no++;?></td>
								<td>Maksimal distribusi undangan perhari</td>
								<td>
								 
								<input class='form-control' type="text" id="val_1" name="val_1" onchange='save_(`1`,`val_1`)' value="<?php echo $this->m_reff->goField("tm_pengaturan","val","where id='1' ");?>">
							 
								</td>
								</tr>
								
							
							 
								
									<tr>
								<td><?php echo $no++;?></td>
								<td>Url API Whatsapp pesan biasa</td>
								<td>
								 
								<input class='form-control' type="text" id="val_6" name="val_6" onchange='save_(`6`,`val_6`)'
								value="<?php echo $this->m_reff->goField("tm_pengaturan","val","where id='6' ");?>">
							 
								</td>
								</tr>
								
									<tr>
								<td><?php echo $no++;?></td>
								<td>Url API Whatsapp pesan dokumen</td>
								<td>
								 
								<input class='form-control' type="text" id="val_13" name="val_13" onchange='save_(`13`,`val_13`)'
								value="<?php echo $this->m_reff->goField("tm_pengaturan","val","where id='13' ");?>">
							 
								</td>
								</tr>
								
								
									<tr>
								<td><?php echo $no++;?></td>
								<td>Token API Whatsapp</td>
								<td>
								 
								<input class='form-control' type="text" id="val_5" name="val_5" onchange='save_(`5`,`val_5`)'
								value="<?php echo $this->m_reff->goField("tm_pengaturan","val","where id='5' ");?>">
							 
								</td>
								</tr>
								
							 
								
									<tr>
								<td><?php echo $no++;?></td>
								<td>Url API Sms</td>
								<td>
								 
								<input class='form-control' type="text" id="val_11" name="val_11" onchange='save_(`11`,`val_11`)'
								value="<?php echo $this->m_reff->goField("tm_pengaturan","val","where id='11' ");?>">
							 
								</td>
								</tr>
								
									<tr>
								<td><?php echo $no++;?></td>
								<td>Token API Sms</td>
								<td>
								 
								<input class='form-control' type="text" id="val_12" name="val_12" onchange='save_(`12`,`val_12`)'
								value="<?php echo $this->m_reff->goField("tm_pengaturan","val","where id='12' ");?>">
							 
								</td>
								</tr>
								
								
							 
								
								<tr>
								<td><?php echo $no++;?></td>
								<td>Konten Notif Whatsapp (permohonan diterima)</td>
								<td>
								 
								<textarea class='form-control' id="val_7" name="val_7" onchange='save_(`7`,`val_7`)'><?php echo $this->m_reff->goField("tm_pengaturan","val","where id='7' ");?></textarea>
								<button onclick='save_(`7`,`val_7`)' class="btn btn-block btn-primary">SIMPAN</button>
								</td>
								</tr>
								
									<tr>
								<td><?php echo $no++;?></td>
								<td>Konten Notif Whatsapp (permohonan ditolak)</td>
								<td>
								 
								<textarea class='form-control' id="val_8" name="val_8" onchange='save_(`8`,`val_8`)'><?php echo $this->m_reff->goField("tm_pengaturan","val","where id='8' ");?></textarea>
								<button onclick='save_(`8`,`val_8`)' class="btn btn-block btn-primary">SIMPAN</button>
								</td>
								</tr>
								 
								
									<tr>
								<td><?php echo $no++;?></td>
								<td>Konten Notif SMS (permohonan diterima)</td>
								<td>
								 
								<textarea class='form-control' id="val_9" name="val_9" onchange='save_(`9`,`val_9`)'><?php echo $this->m_reff->goField("tm_pengaturan","val","where id='9' ");?></textarea>
								<button onclick='save_(`9`,`val_9`)' class="btn btn-block btn-primary">SIMPAN</button>
								</td>
								</tr>
								
									<tr>
								<td><?php echo $no++;?></td>
								<td>Konten Notif SMS (permohonan ditolak)</td>
								<td>
								 
								<textarea id="val_10" class='form-control' name="val_10" onchange='save_(`10`,`val_10`)'><?php echo $this->m_reff->goField("tm_pengaturan","val","where id='10' ");?></textarea>
								<button onclick='save_(`10`,`val_10`)' class="btn btn-block btn-primary">SIMPAN</button>
								</td>
								</tr>
								<tr>
								<td><?php echo $no++;?></td>
								<td>Link upload file pendaftaran</td>
								<td>
								 
								<input type="text" id="val_14" class='form-control' name="val_14" onchange='save_(`14`,`val_14`)' value="<?php echo $this->m_reff->goField("tm_pengaturan","val","where id='14' ");?>">
		 
								</td>
								</tr>
									<tr>
								<td><?php echo $no++;?></td>
								<td>Konten Notif WA registrasi</td>
								<td>
								 
								<textarea id="val_15" class='form-control' name="val_15" onchange='save_(`15`,`val_15`)'><?php echo $this->m_reff->goField("tm_pengaturan","val","where id='15' ");?></textarea>
								<button onclick='save_(`15`,`val_15`)' class="btn btn-block btn-primary">SIMPAN</button>
								</td>
								</tr>	<tr>
								<td><?php echo $no++;?></td>
								<td>Konten Notif SMS registrasi</td>
								<td>
								 
								<textarea id="val_16" class='form-control' name="val_16" onchange='save_(`16`,`val_16`)'><?php echo $this->m_reff->goField("tm_pengaturan","val","where id='16' ");?></textarea>
								<button onclick='save_(`16`,`val_16`)' class="btn btn-block btn-primary">SIMPAN</button>
								</td>
								</tr>
							</table>
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


 