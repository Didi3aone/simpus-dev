<script type="text/javascript">
function pilih2(id){

	$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/simpanResep",
			data	: { trans_id : id},
			cache	: false,
			success	: function(data){
					detailBarang();
					$("#jml").val('');
					
			}
		});
	$("#DataResep").dialog('close');
    $("#no_tr").val(id);
    $("#no_tr").focus();

	function detailBarang(){
		var kode = $("#kodekeluar").val();
		var string = "kode="+kode;
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/DataDetailApotekKeluar",
			data	: string,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
				//$("#nm_lengkap").val('nm_lengkap');
			}
		});
		
	}
}
</script>
<div id="list">
                        	<table class="table table-bordered" id="dyntable">
                    		<colgroup>
                        		<col class="con0" style="align: center; width: 4%" />
                        		<col class="con1" />
                        		<col class="con0" />
                        		<col class="con1" />
                        		<col class="con0" />
                        		<col class="con1" />
					<col class="con0" />
                                <col class="con0" />
                    		</colgroup>
                    		<thead>
                                <tr>
								  <th>No.</th>
								  <th style="width: 10%">Rekam Medis</th>
                                  <th>Nama Pasien</th>
								  <th>U m u r</th>
								  <th>Alamat</th>
								  <th>Unit Layanan</th>
								  <th>View</th>
								  <th>Pilih</th>
								</tr>
                   			</thead>
                            <tbody>
                            <?php
							  $no=1;
							  foreach($data->result_array() as $dp){
							  //$stok = $this->m_crud->CariStokAkhir($dp['kd_obat']);
							?>
                            	<tr class="gradeX">
                                <td class="center" width="50"><?php echo $no; ?></td>
                                <td style="text-align: center"><?php echo $dp['kd_rekam_medis']; ?></td>
								  <td class="left"><?php echo $dp['nm_lengkap']; ?></td>
                                  <td style="text-align: center;"><?php echo $dp['umur']; ?></td>
								  <td><?php echo $dp['alamat']; ?></td>
								  <td class="center"><?php echo $dp['kd_antrian']; ?></td>
								  <td >
								  <div class="btn-group">
									<a class="btn btn-small btn-primary" title="Lihat Resep" href="<?php echo base_url();?>cont_transaksi_pelayanan/cetak_resep/<?php echo $dp['kd_trans_pelayanan'];?>" target="blank">
									<i class="icon-share icon-white"></i></a>
								  </div><!-- /btn-group -->
								  </td>
								  <td >
								  <div class="btn-group">
									<a class="btn btn-danger btn-small" title="Pilih" href="javascript:pilih2('<?php echo $dp['kd_trans_pelayanan'];?>')" >
									<i class="icon-ok icon-white"></i></a>
								  </div><!-- /btn-group -->
								  </td>
                                </tr>
                              <?php
								$no++;
								}
							  ?>
                   	 		</tbody>
                			</table>
                        </div>
