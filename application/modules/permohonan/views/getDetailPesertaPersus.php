
<?php
	$id = $_POST["id"];

	$this->db->where("id", $id);
	$d = $this->db->get("data_persus")->row_array();

?>
<input type="hidden" value="<?php echo $d['id'] ?>" name="id">
<div class="row">
	<div class="col-md-4 col-sm-12">
		<label>Nama Persus</label><br/>
		<strong><?php echo $d['nama'] ?></strong>
	</div>
	<div class="col-md-4 col-sm-12">
		<label>No. HP</label><br/>
		<strong><?php echo $d['hp'] ?></strong>
	</div>
	<div class="col-md-4 col-sm-12">
		<label>Email</label><br/>
		<strong><?php echo $d['email'] ?></strong>
	</div>
</div>

<div class="row pt-4">
	<div class="col-md-4 col-sm-12">
		<label>Jumlah Pagi</label><br/>
		<strong><?php echo $d['jml_pagi'] ?></strong>
	</div>
	<div class="col-md-4 col-sm-12">
		<label>Jumlah Sore</label><br/>
		<strong><?php echo $d['jml_sore'] ?></strong>
	</div>
</div>

<script type="text/javascript">
	//$('#fjk').select2({ theme: "bootstrap" });
</script>