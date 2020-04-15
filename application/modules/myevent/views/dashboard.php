  
						<div class="col-md-6">
							<div class="card ">
								<div class="card-body  ">
								  	<div class="card-category">Progress Permohonan</div>
					 
									<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-1"></div>
											<h6 class="fw-bold mt-3 mb-0">Permohonan</h6>
											<h6 class="fw-bold "><?php echo $this->umum->jmlPemohon()?></h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-2"></div>
											<h6 class="fw-bold mt-3 mb-0">Disposisi</h6>
											<h6 class="fw-bold "><?php echo $this->umum->jmlDispo()?></h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-3"></div>
											<h6 class="fw-bold mt-3 mb-0">Distribusi</h6>
											<h6 class="fw-bold "><?php echo $this->umum->jmlDistribusi()?></h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card card-dark bg-primary-gradient">
								<div class="card-body bubble-shadow">
									<div class="card-title">Total Permohonan Undangan</div>
									<div class="row py-3">
										<div class="col-md-4 d-flex flex-column justify-content-around">
											<div>
												<h6 class="fw-bold text-uppercase text-warning op-8">  Penaikan </h6>
												<h3 class="fw-bold"><?php echo $this->umum->jmlPemohon(1);?></h3>
											</div>
											<div>
												<h6 class="fw-bold text-uppercase text-warning op-8">  Penurunan</h6>
												<h3 class="fw-bold"><?php echo $this->umum->jmlPemohon(2);?></h3>
											</div>
										</div>
										<div class="col-md-8">
											<div id="chart-container">
												<canvas id="totalIncomeChart"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
			





 

	
	
	 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="card">
                        
                        <div class="body"><center><b>DATA BLOK PAGI</b></center>
                            <div class="table-responsive">
                                <table class="entry" width="100%">
                                    <thead>
                                        <tr >
                                            <th>NO</th>
                                            <th>NAMA BLOK</th>
                                            <th>QUOTA</th>
                                            <th>DISPO</th>
                                            <th>DISTRIBUSI</th>
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
	
	
	
 

































			
					  <script>
					    $(document).ready(function() {
		Circles.create({
			id:'circles-1',
			radius:45,
			value:<?php echo $per_dispo=number_format($this->umum->per_pemohon(),0,"",".");?>,
			maxValue:100,
			width:7,
			text: <?php echo $per_dispo;?>+"%",
			colors:['#f1f1f1', '#FF9E27'],
			duration:600,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-2',
			radius:45,
			value:<?php echo $per_dispo=number_format($this->umum->per_dispo(),0,"",".");?>,
			maxValue:100,
			width:7,
			text: <?php echo $per_dispo;?>+"%",
			colors:['#f1f1f1', '#2BB930'],
			duration:700,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-3',
			radius:45,
			value:<?php echo $per_distribusi=number_format($this->umum->per_distribusi(),0,"",".");?>,
			maxValue:100,
			width:7,
			text: <?php echo $per_distribusi;?>+"%",
			colors:['#f1f1f1', '#F25961'],
			duration:900,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

		var mytotalIncomeChart = new Chart(totalIncomeChart, {
			type: 'pie',
			data: {
				
				labels: [   "PENURUNAN" , "PENAIAKAN",],
				datasets : [{
					label: "Jumlah", 
					borderColor: 'white',
					data: [<?php echo $this->umum->jmlPemohon(2);?>,   <?php echo $this->umum->jmlPemohon(1);?> ],
					backgroundColor: [
					 "#d4de7a", "#e079a9"
					],
				}],
			},
			options: {
				responsive: false,
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
			 
			}
		});

						});
	</script>