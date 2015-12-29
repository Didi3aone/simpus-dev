<style type="text/css">
body .modal {
    /* new custom width */
    width: 1280px;
    /* must be half of the width, minus scrollbar on the left (30px) */
    margin-left: -640px;
}
th.vcenter{
    vertical-align:middle;
    text-align: center;
}
.modal-body{
    position: relative;
}
.img-responsive {
    width:30px;
    height: 30px;
    position:relative;
    left:50%;
    top:50%;
    margin-top: -15px;
    margin-left:-15px;
}
</style>
<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Laporan Program Kesehatan Gigi dan Mulut</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman laporan program kesehatan gigi dan mulut</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
      						<li class="ui-tabs-active"><a href="#list"><i class="icon-align-justify"></i> Cetak Laporan Program Kesehatan Gigi dan Mulut</a></li>
                        </ul>
                        
                        <!---- CETAK LAP PROKES START ---->
   						<div id="list">
                        	<h4 class="widgettitle nomargin shadowed">Generate Laporan</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('c_lap_prokes/lap_prokes/cetak', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Bulan Laporan</label>
                                            <span class="field">
                                            	<select name="bulan" id="bulan">
                                                	<option value="--">--Pilih Bulan Laporan--</option>
                                                    <option value="1">Januari</option>
                                                    <option value="2">Februari</option>
                                                    <option value="3">Maret</option>
                                                    <option value="4">April</option>
                                                    <option value="5">Mei</option>
                                                    <option value="6">Juni</option>
                                                    <option value="7">Juli</option>
                                                    <option value="8">Agustus</option>
                                                    <option value="9">September</option>
                                                    <option value="10">Oktober</option>
                                                    <option value="11">November</option>
                                                    <option value="12">Desember</option>
                                                </select>
                                            </span>
                                        </p>
                                        
                                        <p>
                                            <label>Tahun Laporan</label>
                                            <span class="field">
                                            <select name="tahun" id="tahun">
                                            	<option value="--">--Pilih Tahun Laporan--</option>
                                            	<?php 
													//$current = date('Y'); 
													$current = '2015';
													$start = $current; 
													for($i=$start;$i<=($current+3);$i++){
														echo '<option value="'.$i.'">'.$i.'</option>';
													}
												?>
                                             </select> 
                                            </span>
                                        </p>
                                                           
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary" id="preview">Preview</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END CETAK LAP PROKES ---->

                        <script type="text/javascript">
                        jQuery(document).ready(function(){

                            jQuery('#preview').click(function(e){
                                e.preventDefault();
                                //alert('test');
                                jQuery('#previewModal').modal('show');   
                            });

                            jQuery('#loading').show();

                            jQuery('#previewModal').on('show', function(){
                                    var bln,thn,target,x;

                                    x = jQuery("#bulan option:selected").text();

                                    bln = jQuery('#bulan').val();
                                    thn = jQuery('#tahun').val();
                                    target = '<?php echo base_url("c_lap_prokes/lap_prokes/preview"); ?>';
                                    //console.log(bln + '\n' + thn);
                                    
                                    var title = 'LAPORAN PROGRAM KESEHATAN GIGI DAN MULUT<br>DINAS KESEHATAN KOTA BOGOR<br>PUSKESMAS TANAH SAREAL<br><b>BULAN ' + x.toUpperCase() + ' ' + thn + '</b>';

                                    jQuery('#previewModalLabel').html(title);

                                    jQuery.post(target, {bulan: bln, tahun: thn}, function(data){
                                        jQuery('#loading').hide();

                                        jQuery('.content').html(data);

                                    });

                            });

                            jQuery('#previewModal').on('shown', function () {
                                jQuery(".modal-body").scrollTop(0);
                            });

                            jQuery('#previewModal').on('hide', function() {
                                jQuery(this).removeData('modal');
                            });

                            jQuery('#cetak').click(function(e){
                                e.preventDefault();
                                jQuery('#previewModal').modal('hide');
                                jQuery('#form_input').submit();

                            });


                        });
                        </script>
                	</div><!--tabs-->
                </div><!--span12-->
            </div><!--row-fluid-->
        </div><!--contentinner-->
    </div><!--maincontent-->

    <div aria-hidden="false" aria-labelledby="previewModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="previewModal">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h3 id="previewModalLabel" class="text-center">Modal Heading</h3>
        </div>
        <div class="modal-body">
            <div id='loading' style='display:none;'>
                <span class="img-responsive">Memuat data ... <img src='<?php echo base_url("assets/img/loaders/loader6.gif"); ?>'/></span>
            </div>
            <p class="content"></p>
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn">Tutup</button>
            <button class="btn btn-primary" id="cetak">Cetak</button>
        </div>
    </div><!--#previewModal-->
</div><!--mainright-->