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
	<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="<?php echo base_url();?><?php echo $poto;?>" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a   href="javascript:void(0)" >
								<span>
									<?php echo $nama;?>
									<span class="user-level"><?php echo $this->session->userdata("level");?></span>
									 
								</span>
							</a>
							 
							 
						</div>
					</div>
					
					
			 
		<ul class="nav nav-primary">
                    						
<!------------------------------------------------------------------------->
<?php
$link="";$aktif="";
$uri1=$this->uri->segment(1);
$uri2=$this->uri->segment(2);
$uri=$uri1."/".$uri2;
	 
	  $this->db->where("hak_akses",$this->m_konfig->getIdLevel($this->session->userdata("level")));
	   $this->db->order_by("id_menu","ASC");
$menu=$this->db->get_where("main_menu",array("level"=>1));
foreach($menu->result() as $level1)
{
$slashLink=explode("/",$level1->link);
$jmlslash=count($slashLink);
if($jmlslash>1){
	if($level1->link==$uri){ $link="style='opacity:0.9;filter:alpha(opacity=0);'"; $aktif="active"; }else{ $aktif="";};
}else{
	if($level1->link==$uri1){ $link="style='opacity:0.9;filter:alpha(opacity=0);'"; $aktif="active"; }else{ $aktif="";};
}


if($level1->id_main==0){?>
	<li class='<?php echo $aktif; ?> nav-item' >
	<a <?php echo $link; ?>  class="menuclick" href="<?php echo base_url().$level1->link;?>"  >
	<i class="<?php echo $level1->icon;?>"></i> 
	<span ><?php echo $level1->nama;?></span>
	<!--<span class="label label-primary label-circle pull-right">23</span>-->
	</a>
	</li>
<?php }else{ ?>
	<li class='<?php echo $aktif; ?> nav-item'>
	<a href="#"  class="menu-toggle">
	<i class="<?php echo $level1->icon;?>"></i> 
	<span><?php echo $level1->nama;?></span>
	<i class="fa fa-angle-right drop-icon"></i>
	</a>
		<ul class="ml-menu" >
		<?php
		
	    $this->db->where("hak_akses",$this->m_konfig->getIdLevel($this->session->userdata("level")));
		$this->db->order_by("id_menu","ASC");
		$menu2=$this->db->get_where("main_menu",array("level"=>2,"id_main"=>$level1->id_menu));
		foreach($menu2->result() as $level2)
		{?>
	
		<?php
		$slashLink=explode("/",$level2->link);
		$jmlslash=count($slashLink);
		if($jmlslash>1){
		if($level1->link==$uri){ $link="style='background:#33ccff;opacity:0.9;filter:alpha(opacity=10);'"; $aktif="active"; };
		}else{
		if($level1->link==$uri1){ $link="style='background:#33ccff;opacity:0.9;filter:alpha(opacity=10);'"; $aktif="active"; };
		}
		?>
	
	
		
			<li >
			<a  class="menuclick" href="<?php echo base_url().$level2->link;?>">
			<i class="<?php echo $level2->icon;?>"></i> 
			<span><?php echo $level2->nama;?></span>
			</a>
			</li>
			
		<?php } ?>	
			
		</ul>
	</li>
<?php } ?>
	
<?php }; ?>
 
<li class="active"></li>
<!------------------>
 
 
<!------------------------------------------------------------------------->
   </ul>
				
					
				</div>
			</div>
		</div>
		<!-- End Sidebar -->
