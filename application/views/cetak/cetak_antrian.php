<style type="text/css">
    *{
        font-family: Arial;
        font-size:12px;
        margin:0px;
        padding:0px;
    }
    @page {
        margin-left:3cm 2cm 2cm 2cm;
    }
    table.grid{
        width:80mm;
        font-size: 12pt;
        border-collapse:collapse;
    }
    table.grid th{
        padding-top:1mm;
        padding-bottom:1mm;
    }
    table.grid th{
        border-top: 0.2mm solid #000;
        border-bottom: 0.2mm solid #000;
        text-align:center;
        padding:7px;
    }
    table.grid tr td{
        padding-top:0.5mm;
        padding-bottom:0.5mm;
        padding-left:2mm;
        padding-right:2mm;
    }
    h1{
        font-size: 18pt;
    }
    h2{
        font-size: 14pt;
    }
    h3{
        font-size: 10pt;
    }
    .kop{
        font-size:12px;
        margin-bottom:5px;
        width:80mm ;
    }
    .kop h2{
        font-size:22px;
    }
    .header{
        display: block;
        width:80mm ;
        margin-bottom: 0.3cm;
        text-align: left;
    }
    .attr{
        font-size:9pt;
        width: 100%;
        padding-top:2pt;
        padding-bottom:2pt;
        border-top: 0.2mm solid #000;
        border-bottom: 0.2mm solid #000;
    }
    .pagebreak {
        width:80mm ;
        page-break-after: always;
        margin-bottom:10px;
    }
    .akhir {
        width:80mm ;
    }
    .page {
        width:80mm ;
        font-size:12px;
    }

</style>
<?php

if($data->num_rows()>0){

    $kop_kanan  = $tgl_pelayanan;
    $kop_kanan  .= "<p></p>";


    $judul_H      = $nm_puskesmas;
    $kop_alamat   = $alamat;
    $cara_bayar   = $cara_bayar;
    $kop_nm_kota  = $nm_kota;
    $kop_nm_propinsi  = $nm_propinsi;
    $tanggal    = $this->m_crud->indonesian_date($date);


    function myheader($kop,$kop_kanan,$judul_H,$kop_alamat,$cara_bayar,$kop_nm_kota,$kop_nm_propinsi,$tanggal){
        ?>
        <div class="page">
            <br/><br/><br/><br/><br/>
            <table width="100%">
                <tr>
                    <td align="center" colspan="3"><?php echo $kop;?></td>
                </tr>
                <tr>
                    <td align="center"><?php echo $tanggal; ?><br/><br/></td>
                </tr>
                <!--<tr>
                    <td align="center" style="font-size: 13px"><?php echo 'PUSKESMAS '.$judul_H; ?></td>
                </tr>
                <tr>
                    <td align="center"><?php echo $kop_alamat; ?></td>
                </tr>
                <tr>
                    <td align="center"><?php echo $kop_nm_kota.' - '.$kop_nm_propinsi ?></td>
                </tr>-->
                <tr>
                    <td align="center">
                        <?php echo '- PASIEN '. $cara_bayar .' -'; ?> <br/><br/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center;"><a href="#" id="not-print" onClick="window.print();return false" >NO ANTRIAN</a><br/><br/></td>
                </tr>

            </table>
        </div>

        <table class="grid">
    <?php
    }
    function myfooter(){
        ?>
        </table>
    <?php
    }
    $no=1;
    $page =1;
    $jml = 0;
    foreach($data->result_array() as $db){

       if(($no%40) == 1){
            if($no > 1){
                myfooter();
                ?>
                <div class="pagebreak" align="right">
                    <div class="page" align="center"><?php //hal ?></div>
                </div>
                <?php
                $page++;
            }
            myheader($kop,$kop_kanan,$judul_H,$kop_alamat,$cara_bayar,$kop_nm_kota,$kop_nm_propinsi,$tanggal);
        }
        ?>
        <tr>
            <td align="center" style="font-size: 55px"><?php echo $db['no_antrian']; ?> </td>
        </tr>
        <tr>
            <td align="center"><?php echo '( '.$db['nm_unit'].' )'; ?><br/><br/></td>
        </tr>
        <tr>
            <td align="center" style="font-size: 15px">Terima Kasih, Silahkan Tunggu</td>
        </tr>
        <?php
        $no++;
    }
    ?>

    <?php
    myfooter();
    ?>
    </table>
    <div class="page" >

    </div>
<?php
}else{
    echo "Tidak Ada Data";
}
?>