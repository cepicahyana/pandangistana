<!--   Core JS Files   -->
	
	<script src="<?php echo base_url();?>assets/js/core/popper.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="<?php echo base_url();?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="<?php echo base_url();?>assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

	<!-- Moment JS -->
	<script src="<?php echo base_url();?>assets/js/plugin/moment/moment.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>plug/js/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>plug/css/daterangepicker.css" />
	<!-- Chart JS -->
	<script src="<?php echo base_url();?>assets/js/plugin/chart.js/chart.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="<?php echo base_url();?>assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<script src="<?php echo base_url();?>assets/js/plugin/chart-circle/circles.min.js"></script>

	<!-- Datatables -->
	
	<!-- Bootstrap Notify -->
	<script src="<?php echo base_url();?>assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/notify.js"></script>

	<!-- Bootstrap Toggle -->
	<script src="<?php echo base_url();?>assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>


 
	<!-- Dropzone -->
	<script src="<?php echo base_url();?>assets/js/plugin/dropzone/dropzone.min.js"></script>

	<!-- Fullcalendar -->
	<script src="<?php echo base_url();?>assets/js/plugin/fullcalendar/fullcalendar.min.js"></script>

	<!-- DateTimePicker -->
	<script src="<?php echo base_url();?>assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js"></script>

	<!-- Bootstrap Tagsinput -->
	<script src="<?php echo base_url();?>assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

	<!-- Bootstrap Wizard -->
	<script src="<?php echo base_url();?>assets/js/plugin/bootstrap-wizard/bootstrapwizard.js"></script>

	<!-- jQuery Validation -->
	<script src="<?php echo base_url();?>assets/js/plugin/jquery.validate/jquery.validate.min.js"></script>

	<!-- Summernote -->
	<script src="<?php echo base_url();?>assets/js/plugin/summernote/summernote-bs4.min.js"></script>

	<!-- Select2 -->
	<script src="<?php echo base_url();?>assets/js/plugin/select2/select2.full.min.js"></script>

	<!-- Sweet Alert -->
	<script src="<?php echo base_url();?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Atlantis JS -->
	<script src="<?php echo base_url();?>assets/js/atlantis2.min.js"></script>
  
	
	
	 <script type="text/javascript">
		  $(document).off("click",".menuclick").on("click",".menuclick",function (event, messages) {
			   event.preventDefault();loading("loading");
			   var url = $(this).attr("href");
			   var title = $(this).attr("title");
			   var session = "1";
			     if(url=="<?php echo base_url()?>login/logout")
				 {
					 window.location.href="<?php echo base_url()?>login/logout";
				 } 
				   
			    $(this).parent().addClass('active').siblings().removeClass('active');
				///$(".content").html("<center> Mohon tunggu.... </center>")
				$.post(url,{ajax:"yes"},function(data){
				unblock("loading");
				//$('.modal.aside').remove();
				  history.replaceState(title, title, url);
				//  $('title').html(title);
				  $(".content").html(data);
			  })
		  }) 
	 </script> 
	 <script> $('.select2').select2({ theme: "bootstrap" }); </script>
	 
	 
	