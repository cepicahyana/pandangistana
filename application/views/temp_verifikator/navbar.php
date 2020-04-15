	<?php
	$data=$this->db->get_where("admin",array("id_admin"=>$this->session->userdata("id")))->row();
	$poto=isset($data->poto)?($data->poto):"x";
	$nama=isset($data->owner)?($data->owner):"";
	if(file_exists("file_upload/user/".$poto.""))
	{
	$poto="file_upload/user/".$poto;
	}else{
	$poto="assets/img/profile.jpg";
	}
	?>
	
	
	<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
				
				<div class="container-fluid">
					 
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>
					 
						 
					  
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="<?php echo base_url();?><?php echo $poto;?>" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="<?php echo base_url();?><?php echo $poto;?>" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4><?php echo $nama;?></h4>
												<p class="text-muted"><?php echo $this->session->userdata("level");?></p> 
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
									 
										<a class="dropdown-item menuclick" href="<?php echo base_url()?>profile_setting">Akun</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="<?php echo base_url()?>login/logout">Logout</a>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->