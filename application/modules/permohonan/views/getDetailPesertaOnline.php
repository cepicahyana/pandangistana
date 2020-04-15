<?php 
	$link=$this->m_reff->tm_pengaturan(14);

	$id		=	$this->input->post("id");
	$data = $this->db->get_where("data_peserta", array("id" => $id))->row();
?>

<div class="row">
	<div class='col-md-6'>
		<a href='<?php echo $data->foto_ktp?>' alt='ktp' target="_blank"><img src="<?php echo $link."/upload/peserta/ktp/".$data->foto_ktp?>" width='100%'></a>
		<a href='<?php echo $data->foto_kk?>'  alt='kk' target="_blank"><img src="<?php echo $link."/upload/peserta/kk/".$data->foto_kk?>" width='100%'></a>
	</div>
	<div class='col-md-6'>
		<table class='entry2' width="100%">
		    <tr class='bg-grey '>
		        <td colspan="2"><b class=' '> Data profile</b></td>
		    </tr>
		    <tr>
		        <td>Nama</td>
		        <td>
		            <?php echo $data->nama; ?>
		        </td>
		    </tr>
		    <tr>
		        <td>NIK</td>
		        <td>
		            <?php echo $data->nik; ?>
		        </td>
		    </tr>
		    <tr>
		        <td>Hp</td>
		        <td>
		            <?php echo $data->hp; ?>
		        </td>
		    </tr>
		    <tr>
		        <td>E-mail</td>
		        <td>
		            <?php echo $data->email; ?>
		        </td>
		    </tr>
		    <tr>
		        <td>Alamat</td>
		        <td>
		            <?php echo $prov=$this->m_reff->goField("wil_provinsi","nama","where id_prov='".substr($data->nik,0,2)."' "); ?> -
		                <?php echo $kab=strtolower($this->m_reff->goField("wil_kabupaten","nama","where id_kab='".substr($data->nik,0,4)."'")); ?>
		        </td>
		    </tr>
		    <tr>
		        <td>Alasan Mengikuti</td>
		        <td>
		            <?php echo $data->alasan_mengikuti; ?>
		        </td>
		    </tr>
		</table>
		<br/>
		Jumlah pendaftar pada wilayah yang sama
		<table class='entry2' width="100%">
		    <tr>
		        <td>Seprovinsi
		            <?php echo $prov;?>
		        </td>
		        <td>
		            <?php echo $this->mdl->getProvByNik($data->nik)?>
		        </td>
		    </tr>
		    <tr>
		        <td>Sekabupaten
		            <?php echo strtoupper(str_replace("KAB. ","",$kab));?>
		        </td>
		        <td>
		            <?php echo $this->mdl->getKabByNik($data->nik)?>
		        </td>
		    </tr>
		</table>
	</div>
</div>