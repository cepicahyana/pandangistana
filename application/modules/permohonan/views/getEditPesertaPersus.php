
<?php
	$id = $_POST["id"];

	$this->db->where("id", $id);
	$d = $this->db->get("data_persus")->row_array();

?>
<input type="hidden" value="<?php echo $d['id'] ?>" name="id">
<div class="row">
	<div class="col-md-4 col-sm-12">
		<label>Nama Persus</label>
		<input type="text" name="f[nama]" class="form-control" required="" value="<?php echo $d['nama'] ?>">
	</div>
	<div class="col-md-4 col-sm-12">
		<label>No. HP</label>
		<input type="text" name="f[hp]" class="form-control" required="" value="<?php echo $d['hp'] ?>">
	</div>
	<div class="col-md-4 col-sm-12">
		<label>Email</label>
		<input type="email" name="f[email]" class="form-control" required="" value="<?php echo $d['email'] ?>">
	</div>
</div>

<div class="row pt-4">
	<div class="col-md-4 col-sm-12">
		<label>Jumlah Pagi (permohonan awal)</label>
		<input type="text" name="f[jml_pagi]" class="form-control" required="" value="<?php echo $d['jml_pagi'] ?>">
	</div>
	<div class="col-md-4 col-sm-12">
		<label>Jumlah Sore (permohonan awal)</label>
		<input type="text" name="f[jml_sore]" class="form-control" required="" value="<?php echo $d['jml_sore'] ?>">
	</div>
</div>

<script type="text/javascript">
	//$('#fjk').select2({ theme: "bootstrap" });
</script>