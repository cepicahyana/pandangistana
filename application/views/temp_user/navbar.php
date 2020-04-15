
<?php 
	$iduser = $this->session->userdata("id");

	$this->db->where("id_admin", $iduser);
	$me = $this->db->get("admin")->row_array();

	if ($me["poto"] != NULL || $me["poto"] != "") {
	 	$foto = "file_upload/admin/".$me["poto"];
	}
	else{
		$foto = "file_upload/admin/dummy-user.jpg";
	} 
?>


	<nav class="navbar navbar-header navbar-expand-lg p-0">

						<div class="container-fluid p-0">
							 
							<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
								 
								 
								<li class="nav-item dropdown hidden-caret">
									<a class="nav-link dropdown-toggle  " href="<?php echo base_url()?>dashboard/jadwal_distribusi"   >
										<i class="fa fa-calendar"></i>  Jadwal Distribusi
									</a> 
								</li>
								
								<li class="nav-item dropdown hidden-caret">
									<a class="nav-link dropdown-toggle" href="<?php echo base_url() ?>mapping_blok">
										<i class="fa fa-couch"></i>  Mapping Blok
									</a> 
								</li>
								
								<li class="nav-item dropdown hidden-caret">
									<a class="nav-link menuclick" href="<?php echo base_url()?>dashboard/mappingWilayah"    >
										<i class="fas fa-map-marked-alt"></i>  Data perwilayah
									</a> 
								</li>
								 
								 
								<li class="nav-item dropdown hidden-caret">
									<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
										<div class="avatar-sm">
											<img src="<?php echo base_url().$foto;?>" alt="..." class="avatar-img rounded-circle">
										</div>
									</a>
									<ul class="dropdown-menu dropdown-user animated fadeIn">
										<div class="dropdown-user-scroll scrollbar-outer">
											<li>
												<div class="user-box">
													<div class="avatar-lg"><img src="<?php echo base_url().$foto;?>" alt="image profile" class="avatar-img rounded"></div>
													<div class="u-text">
														<h4><?php echo $me["owner"] ?> </h4>
														<p class="text-muted"><?php echo $me["email"] ?></p> 
													</div>
												</div>
											</li>
											<li>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" href="<?php echo base_url() ?>profile">Profile</a>
												<a class="dropdown-item" href="<?php echo base_url() ?>login/logout">Logout</a>
											</li>
										</div>
									</ul>
								</li>
							</ul>
						</div>
					</nav>
					<!-- End Navbar -->