<?php
$this->db->order_by("jml","desc");
$this->db->where("jml>=",1);
$data_provinsi	=	$this->db->get("v_prov")->result();
?>
<style>
#mapping_wilayah {
    background: url(<?php  echo base_url()?>plug/img/bgcart.png) no-repeat;
	background-size:cover;
	border-radius:30px;
}
</style>
<figure class="highcharts-figure">
    <div id="mapping_wilayah"></div>
	
	<div class="card">
		<table class='entry' width="100%">
		<?php
		$no=1;
		foreach($data_provinsi as $val)
		{
		?>
		<tr>
		<td>No. <?php echo $no++;?></td><td>Provinsi <?php echo $val->nama;?> </td><td> <?php echo $val->jml;?> </td>
		</tr>
		<?php } ?>
		</table>
		<br>
	</div>
	
    <p class="highcharts-description" style=' width:100%'>
       Data berdasarakan data permohonan yang telah melalui tahap verifikasi dan belum diverifikasi,
	   untuk pemohon yang ditolak tidak disertakan dalam rekapitulasi ini.
    </p>
</figure>

<?php
 $this->db->order_by("nama");
$data_provinsi	=	$this->db->get("v_prov")->result();
$dt_provinsi	=	"";
$dt_kab			=	"";
$no=1;
foreach($data_provinsi as $dp)
{	$no++;
	 
	$dt_provinsi.=   "{
						id: '1.".$no."',
						parent: '0.0',
						name: '".$dp->nama."', 
						value : ".$dp->jml."
						},";
						
	$data_kabupaten	=	$this->db->get_where("v_kab",array("id_prov"=>$dp->id_prov))->result();	
			 $nomor=1;
			foreach($data_kabupaten as $kab){	
			$dt_kab.=	"{
						id: '2.".$nomor++."',
						parent: '1.".$no."',
						name: '".$kab->nama."',
						value : ".$kab->jml."
						},";
			}
						
}
?>

<script>
var data = [{
    id: '0.0',
    parent: '',
    name: 'Indonesia'
},
<?php echo $dt_provinsi;?>
  <?php echo $dt_kab;?>
 
  
 ];

// Splice in transparent for the center circle
Highcharts.getOptions().colors.splice(0, 0, 'transparent');


Highcharts.chart('mapping_wilayah', {

    chart: {
        height: '50%',
		  backgroundColor: 'transparent',
    },

    title: {
        text: 'Pengelompokan Permohonan Perwilayah'
    },
    subtitle: {
        text: 'Data berdasarkan kode nomor NIK'
    },
    series: [{
        type: "sunburst",
        data: data,
        allowDrillToNode: true,
        cursor: 'pointer',
        dataLabels: {
            format: '{point.name}',
            filter: {
                property: 'innerArcLength',
                operator: '>',
                value: 16
            }
        },
        levels: [{
            level: 1,
            levelIsConstant: false,
            dataLabels: {
                filter: {
                    property: 'outerArcLength',
                    operator: '>',
                    value: 64
                }
            }
        }, {
            level: 2,
            colorByPoint: true
        },
        {
            level: 3,
            colorVariation: {
                key: 'brightness',
                to: -0.5,
				 colorByPoint: true
            }
        }, {
            level: 4,
            colorVariation: {
                key: 'brightness',
                to: 0.5
            }
        }]

    }],
    tooltip: {
        headerFormat: "",
        pointFormat: ' <b>{point.name}</b>  = <b>{point.value}</b>'
    }
});
</script>