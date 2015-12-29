<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_lap_prokes extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// cek session
		if ($this->session->userdata('logged_in') == false && $this->session->userdata('id_akses') !== 2) {
			$this->session->unset_userdata();
			$this->session->sess_destroy();
			redirect('login');
		}
		
		$this->load->model('m_lap_prokes');
		
		$this->load->library('template');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	function lap_prokes($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
            		//error_reporting(1);
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/lap_prokes_mulut.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
			
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);
			
			//get puskesmas info from session
			$data['puskesmas'] = $this->m_crud->get_info_puskesmas();
			$bln	= $this->input->post('bulan');
			$thn	= $this->input->post('tahun');
			
			switch($bln)
			{
				case 1:
					$bulan = "JANUARI"; break;
				case 2:
					$bulan = "FEBRUARI"; break;
				case 3:
					$bulan = "MARET"; break;
				case 4:
					$bulan = "APRIL"; break;
				case 5:
					$bulan = "MEI"; break;
				case 6:
					$bulan = "JUNI"; break;
				case 7:
					$bulan = "JULI"; break;
				case 8:
					$bulan = "AGUSTUS"; break;
				case 9:
					$bulan = "SEPTEMBER"; break;
				case 10:
					$bulan = "OKTOBER"; break;
				case 11:
					$bulan = "NOVEMBER"; break;
				case 12:
					$bulan = "DESEMBER"; break;
			}
			
			//$objPHPExcel->getActiveSheet()->setCellValue('D1', $data['puskesmas'][0]['kd_puskesmas']);
			//$objPHPExcel->getActiveSheet()->setCellValue('D2', $data['puskesmas'][0]['nm_kelurahan']);
			$objPHPExcel->getActiveSheet()->setCellValue('A4', 'PUSKESMAS ' . strtoupper($data['puskesmas'][0]['nm_puskesmas']));
			//$objPHPExcel->getActiveSheet()->setCellValue('D4', $data['puskesmas'][0]['nm_kecamatan']);
			$objPHPExcel->getActiveSheet()->setCellValue('A5', 'BULAN ' . $bulan . ' ' . $thn);
			//$objPHPExcel->getActiveSheet()->setCellValue('I2', $thn);
            
			// Kunjungan kunjungan
			$kunj_baru_l = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, '1', '1');
			$kunj_baru_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, '1', '2');
			$kunj_lama_l = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, '2', '1');
			$kunj_lama_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, '2', '2');
			
			// Karies
			$karies_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K02.9', '1');
			$karies_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K02.9', '2');
			
			// Pulpa
			$pulp_a_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K04.0', '1');
			$pulp_b_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K04.1', '1');
			$pulp_a_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K04.0', '2');
			$pulp_b_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K04.1', '2');
			$pulp_l = $pulp_a_l['jml'] + $pulp_b_l['jml'];
			$pulp_p = $pulp_a_p['jml'] + $pulp_b_p['jml'];
			
			// Gingsivitis / gusi bengkak
			$gusi_a_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K06.1', '1');
			$gusi_b_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K06.0', '1');
			$gusi_a_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K06.1', '2');
			$gusi_b_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K06.0', '2');
			$gusi_l = $gusi_a_l['jml'] + $gusi_b_l['jml'];
			$gusi_p = $gusi_a_p['jml'] + $gusi_b_p['jml'];
			
			// Gangguan gigi dan jaringan lainnya
			$gg_a_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K00', '1');
			$gg_b_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K01.1', '1');
			
			$gg_c_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03', '1');
			$gg_d_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.1', '1');
			$gg_e_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.2', '1');
			$gg_f_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.5', '1');
			$gg_g_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.6', '1');
			$gg_h_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K08.1', '1');
			
			$gg_a_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K00', '2');
			$gg_b_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K01.1', '2');
			$gg_c_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03', '2');
			$gg_d_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.1', '2');
			$gg_e_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.2', '2');
			$gg_f_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.5', '2');
			$gg_g_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.6', '2');
			$gg_h_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K08.1', '2');
			
			$gg_l = $gg_a_l['jml'] + $gg_b_l['jml'] + $gg_c_l['jml'] + $gg_d_l['jml'] + $gg_e_l['jml'] + $gg_f_l['jml'] + $gg_g_l['jml'] + $gg_h_l['jml']; 
			$gg_p = $gg_a_p['jml'] + $gg_b_p['jml'] + $gg_c_p['jml'] + $gg_d_p['jml'] + $gg_e_p['jml'] + $gg_f_p['jml'] + $gg_g_p['jml'] + $gg_h_p['jml'];
			
			// abses mulut / rongga mulut
			$rm_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K12.2', '1');
			$rm_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K12.2', '2');
			
			// tumpatan gigi tetap
			$tgt_l = $this->m_lap_prokes->get_jml_tambal_gigi_tetap($bln, $thn, '1');
			$tgt_p = $this->m_lap_prokes->get_jml_tambal_gigi_tetap($bln, $thn, '2');
			
			// cabut gigi tetap
			$cgt_l = $this->m_lap_prokes->get_jml_cabut_gigi_tetap($bln, $thn, '1');
			$cgt_p = $this->m_lap_prokes->get_jml_cabut_gigi_tetap($bln, $thn, '2');
			
			// cabut gigi sulung
			$cgs_l = $this->m_lap_prokes->get_jml_cabut_gigi_sulung($bln, $thn, '1');
			$cgs_p = $this->m_lap_prokes->get_jml_cabut_gigi_sulung($bln, $thn, '2');
			
			// pengobatan pulpa
			$pp_l = $this->m_lap_prokes->get_jml_pengobatan_pulpa($bln, $thn, '1');
			$pp_p = $this->m_lap_prokes->get_jml_pengobatan_pulpa($bln, $thn, '2');
			
			// pengobatan gusi / periodontal
			$pg_l = $this->m_lap_prokes->get_jml_pengobatan_gusi($bln, $thn, '1');
			$pg_p = $this->m_lap_prokes->get_jml_pengobatan_gusi($bln, $thn, '2');
			
			// pembersihan karang gigi
			$pkg_l = $this->m_lap_prokes->get_jml_pembersihan_karang_gigi($bln, $thn, '1');
			$pkg_p = $this->m_lap_prokes->get_jml_pembersihan_karang_gigi($bln, $thn, '2');
			
			// rujukan
			$rujuk_l = $this->m_lap_prokes->get_jml_rujukan($bln, $thn, '1');
			$rujuk_p = $this->m_lap_prokes->get_jml_rujukan($bln, $thn, '2');
			
			
			$objPHPExcel->getActiveSheet()->setCellValue('C11', $kunj_baru_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D11', $kunj_baru_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C12', $kunj_lama_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D12', $kunj_lama_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C22', $karies_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D22', $karies_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C23', $pulp_l);
			$objPHPExcel->getActiveSheet()->setCellValue('D23', $pulp_p);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C24', $gusi_l);
			$objPHPExcel->getActiveSheet()->setCellValue('D24', $gusi_p);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C25', $gg_l);
			$objPHPExcel->getActiveSheet()->setCellValue('D25', $gg_p);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C26', $rm_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D26', $rm_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C22', $karies_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D22', $karies_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C28', $tgt_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D28', $tgt_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C29', $cgt_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D29', $cgt_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C31', $cgs_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D31', $cgs_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C32', $pp_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D32', $pp_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C33', $pg_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D33', $pg_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C34', $pkg_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D34', $pkg_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C36', $rujuk_l['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('D36', $rujuk_p['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('A118', 'Kepala Puskesmas ' . ucwords(strtolower($data['puskesmas'][0]['nm_puskesmas'])));
			$objPHPExcel->getActiveSheet()->setCellValue('A123', $data['puskesmas'][0]['kpl_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('A124', 'NIP: ' . $data['puskesmas'][0]['nip_kpl']);
					
			$objPHPExcel->getActiveSheet()->setCellValue('C117', 'Bogor, ' . $this->functions->format_tgl_cetak2(date('Y-m-d')));
			$objPHPExcel->getActiveSheet()->setCellValue('C123', $this->session->userdata('nama'));
			$objPHPExcel->getActiveSheet()->setCellValue('C124', 'NIP: ' . $this->session->userdata('nip'));
		
				
			$filename='LAPORAN_PROKES_GIGI_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}

		if ($par1 == 'preview') {
            error_reporting(1);
			
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
			
			//get puskesmas info from session
			
			$data['puskesmas'] = $this->m_crud->get_info_puskesmas();
			$bln	= $this->input->post('bulan');
			$thn	= $this->input->post('tahun');
			
			switch($bln)
			{
				case 1:
					$bulan = "JANUARI"; break;
				case 2:
					$bulan = "FEBRUARI"; break;
				case 3:
					$bulan = "MARET"; break;
				case 4:
					$bulan = "APRIL"; break;
				case 5:
					$bulan = "MEI"; break;
				case 6:
					$bulan = "JUNI"; break;
				case 7:
					$bulan = "JULI"; break;
				case 8:
					$bulan = "AGUSTUS"; break;
				case 9:
					$bulan = "SEPTEMBER"; break;
				case 10:
					$bulan = "OKTOBER"; break;
				case 11:
					$bulan = "NOVEMBER"; break;
				case 12:
					$bulan = "DESEMBER"; break;
			}
			
			// Kunjungan kunjungan
			$kunj_baru_l = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, '1', '1');
			$kunj_baru_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, '1', '2');
			$kunj_lama_l = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, '2', '1');
			$kunj_lama_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, '2', '2');
			
			// Karies
			$karies_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K02.9', '1');
			$karies_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K02.9', '2');
			
			// Pulpa
			$pulp_a_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K04.0', '1');
			$pulp_b_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K04.1', '1');
			$pulp_a_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K04.0', '2');
			$pulp_b_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K04.1', '2');
			$pulp_l = $pulp_a_l['jml'] + $pulp_b_l['jml'];
			$pulp_p = $pulp_a_p['jml'] + $pulp_b_p['jml'];
			
			// Gingsivitis / gusi bengkak
			$gusi_a_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K06.1', '1');
			$gusi_b_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K06.0', '1');
			$gusi_a_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K06.1', '2');
			$gusi_b_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K06.0', '2');
			$gusi_l = $gusi_a_l['jml'] + $gusi_b_l['jml'];
			$gusi_p = $gusi_a_p['jml'] + $gusi_b_p['jml'];
			
			// Gangguan gigi dan jaringan lainnya
			$gg_a_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K00', '1');
			$gg_b_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K01.1', '1');
			
			$gg_c_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03', '1');
			$gg_d_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.1', '1');
			$gg_e_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.2', '1');
			$gg_f_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.5', '1');
			$gg_g_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.6', '1');
			$gg_h_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K08.1', '1');
			
			$gg_a_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K00', '2');
			$gg_b_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K01.1', '2');
			$gg_c_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03', '2');
			$gg_d_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.1', '2');
			$gg_e_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.2', '2');
			$gg_f_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.5', '2');
			$gg_g_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K03.6', '2');
			$gg_h_p = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K08.1', '2');
			
			$gg_l = $gg_a_l['jml'] + $gg_b_l['jml'] + $gg_c_l['jml'] + $gg_d_l['jml'] + $gg_e_l['jml'] + $gg_f_l['jml'] + $gg_g_l['jml'] + $gg_h_l['jml']; 
			$gg_p = $gg_a_p['jml'] + $gg_b_p['jml'] + $gg_c_p['jml'] + $gg_d_p['jml'] + $gg_e_p['jml'] + $gg_f_p['jml'] + $gg_g_p['jml'] + $gg_h_p['jml'];
			
			// abses mulut / rongga mulut
			$rm_l = $this->m_lap_prokes->get_jml_penyakit_gigi($bln, $thn, 'K12.2', '1');
			$rm_p = $this->m_lap_prokes->get_jml_kunjungan_gigi($bln, $thn, 'K12.2', '2');
			
			// tumpatan gigi tetap
			$tgt_l = $this->m_lap_prokes->get_jml_tambal_gigi_tetap($bln, $thn, '1');
			$tgt_p = $this->m_lap_prokes->get_jml_tambal_gigi_tetap($bln, $thn, '2');
			
			// cabut gigi tetap
			$cgt_l = $this->m_lap_prokes->get_jml_cabut_gigi_tetap($bln, $thn, '1');
			$cgt_p = $this->m_lap_prokes->get_jml_cabut_gigi_tetap($bln, $thn, '2');
			
			// cabut gigi sulung
			$cgs_l = $this->m_lap_prokes->get_jml_cabut_gigi_sulung($bln, $thn, '1');
			$cgs_p = $this->m_lap_prokes->get_jml_cabut_gigi_sulung($bln, $thn, '2');
			
			// pengobatan pulpa
			$pp_l = $this->m_lap_prokes->get_jml_pengobatan_pulpa($bln, $thn, '1');
			$pp_p = $this->m_lap_prokes->get_jml_pengobatan_pulpa($bln, $thn, '2');
			
			// pengobatan gusi / periodontal
			$pg_l = $this->m_lap_prokes->get_jml_pengobatan_gusi($bln, $thn, '1');
			$pg_p = $this->m_lap_prokes->get_jml_pengobatan_gusi($bln, $thn, '2');
			
			// pembersihan karang gigi
			$pkg_l = $this->m_lap_prokes->get_jml_pembersihan_karang_gigi($bln, $thn, '1');
			$pkg_p = $this->m_lap_prokes->get_jml_pembersihan_karang_gigi($bln, $thn, '2');
			
			// rujukan
			$rujuk_l = $this->m_lap_prokes->get_jml_rujukan($bln, $thn, '1');
			$rujuk_p = $this->m_lap_prokes->get_jml_rujukan($bln, $thn, '2');
			
			$result = '';
			$result .= '<div class="container-fluid">
  <div class="row">
    <div class="span12">
    <table class="table table-bordered table-responsive">
  	<thead>
	    <tr>
	      <th class="vcenter" rowspan="2">NO</th>
	      <th class="vcenter" rowspan="2">KEGIATAN</th>
	      <th class="vcenter" colspan="2">JUMLAH</th>
	      <th class="vcenter" rowspan="2">JUMLAH</th>
	    </tr>
	    <tr>
	      <th class="vcenter">L</th>
		  <th class="vcenter">P</th>
	    </tr>
  </thead>
  <tbody>
  		<tr>
			<td class="vcenter"><b>I</b></td>
			<td colspan="4"><b>KUNJUNGAN PUSKESMAS</b></td>
		</tr>
		<tr>
			<td class="vcenter">1</td>
			<td>Jml penduduk wilayah kerja Puskesmas</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		<tr>
			<td class="vcenter">2</td>
			<td>Jml kunjungan baru rawat jalan gigi ke Puskesmas</td>
			<td class="vcenter">'.$kunj_baru_l['jml'].'</td>
			<td class="vcenter">'.$kunj_baru_p['jml'].'</td>
			<td class="vcenter">'.($kunj_baru_l['jml'] + $kunj_baru_p['jml']).'</td>
		</tr>
		<tr>
			<td class="vcenter">3</td>
			<td>Jml kunjungan lama rawat jalan gigi ke Puskesmas</td>
			<td class="vcenter">'.$kunj_lama_l['jml'].'</td>
			<td class="vcenter">'.$kunj_lama_p['jml'].'</td>
			<td class="vcenter">'.($kunj_lama_l['jml'] + $kunj_lama_p['jml']).'</td>
		</tr>
		<tr>
			<td class="vcenter">4</td>
			<td>Jml BUMIL di wilayah kerja Puskesmas</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		
		<tr>
			<td class="vcenter">5</td>
			<td>Jml kunjungan BRJG bumil</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		<tr>
			<td class="vcenter">6</td>
			<td>Jml kunjungan LRJG bumil</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		<tr>
			<td class="vcenter">7</td>
			<td>Jml anak prasekolah di wilayah kerja Puskesmas</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		<tr>
			<td class="vcenter">8</td>
			<td>Jml Kunjungan BRJG anak anak prasekolah</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		<tr>
			<td class="vcenter">9</td>
			<td>Jml Kunjungan LRJG anak anak prasekolah</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		<tr>
			<td class="vcenter">10</td>
			<td>Jml Kunjungan BRJG anak SD</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		<tr>
			<td class="vcenter">11</td>
			<td>Jml Kunjungan LRJG anak SD</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		<tr>
			<td class="vcenter"><b>II</b></td>
			<td colspan="4"><b>DIAGNOSA/JENIS KELAINAN PELAYANAN MEDIK GIGI</b></td>
		</tr>
		<tr>
			<td class="vcenter">1</td>
			<td>Karies gigi</td>
			<td class="vcenter">'.$karies_l['jml'].'</td>
			<td class="vcenter">'.$karies_p['jml'].'</td>
			<td class="vcenter">'.($karies_l['jml'] + $karies_p['jml']).'</td>
		</tr>
		<tr>
			<td class="vcenter">2</td>
			<td>Penyakit pulpa dan jaringan periapikal</td>
			<td class="vcenter">'.$pulp_l.'</td>
			<td class="vcenter">'.$pulp_p.'</td>
			<td class="vcenter">'.($pulp_l + $pulp_p).'</td>
		</tr>
		<tr>
			<td class="vcenter">3</td>
			<td>Gingsivitis dan jaringan periodontal</td>
			<td class="vcenter">'.$gusi_l.'</td>
			<td class="vcenter">'.$gusi_p.'</td>
			<td class="vcenter">'.($gusi_l + $gusi_p).'</td>
		</tr>
		<tr>
			<td class="vcenter">4</td>
			<td>Gangguan gigi dan jaringan lainnya</td>
			<td class="vcenter">'.$gg_l.'</td>
			<td class="vcenter">'.$gg_p.'</td>
			<td class="vcenter">'.($gg_l + $gg_p).'</td>
		</tr>
		<tr>
			<td class="vcenter">5</td>
			<td>Penyakit rongga mulut</td>
			<td class="vcenter">'.$rm_l['jml'].'</td>
			<td class="vcenter">'.$rm_p['jml'].'</td>
			<td class="vcenter">'.($rm_l['jml'] + $rm_p['jml']).'</td>
		</tr>
		<tr>
			<td class="vcenter"><b>III</b></td>
			<td colspan="4"><b>JENIS KEGIATAN PELAYANAN GIGI MEDIK</b></td>
		</tr>
		<tr>
			<td class="vcenter">1</td>
			<td>Tumpatan gigi tetap</td>
			<td class="vcenter">'.$tgt_l['jml'].'</td>
			<td class="vcenter">'.$tgt_p['jml'].'</td>
			<td class="vcenter">'.($tgt_l['jml'] + $tgt_p['jml']).'</td>
		</tr>
		<tr>
			<td class="vcenter">2</td>
			<td>Pencabutan gigi tetap</td>
			<td class="vcenter">'.$cgt_l['jml'].'</td>
			<td class="vcenter">'.$cgt_p['jml'].'</td>
			<td class="vcenter">'.($cgt_l['jml'] + $cgt_p['jml']).'</td>
		</tr>
		<tr>
			<td class="vcenter">3</td>
			<td>Tumpatan gigi sulung</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		<tr>
			<td class="vcenter">4</td>
			<td>Pencabutan gigi sulung</td>
			<td class="vcenter">'.$cgs_l['jml'].'</td>
			<td class="vcenter">'.$cgs_p['jml'].'</td>
			<td class="vcenter">'.($cgs_l['jml'] + $cgs_p['jml']).'</td>
		</tr>
		<tr>
			<td class="vcenter">5</td>
			<td>Pengobatan pulpa</td>
			<td class="vcenter">'.$pp_l['jml'].'</td>
			<td class="vcenter">'.$pp_p['jml'].'</td>
			<td class="vcenter">'.($pp_l['jml'] + $pp_p['jml']).'</td>
		</tr>
		<tr>
			<td class="vcenter">6</td>
			<td>Pengobatan periodontal</td>
			<td class="vcenter">'.$pg_l['jml'].'</td>
			<td class="vcenter">'.$pg_p['jml'].'</td>
			<td class="vcenter">'.($pg_l['jml'] + $pg_p['jml']).'</td>
		</tr>
		<tr>
			<td class="vcenter">7</td>
			<td>Pembersihan karang gigi</td>
			<td class="vcenter">'.$pkg_l['jml'].'</td>
			<td class="vcenter">'.$pkg_p['jml'].'</td>
			<td class="vcenter">'.($pkg_l['jml'] + $pkg_p['jml']).'</td>
		</tr>
		<tr>
			<td class="vcenter">8</td>
			<td>Pengobatan lain-lain</td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
			<td class="vcenter"></td>
		</tr>
		<tr>
			<td class="vcenter">9</td>
			<td>Jumlah rujukan</td>
			<td class="vcenter">'.$rujuk_l['jml'].'</td>
			<td class="vcenter">'.$rujuk_p['jml'].'</td>
			<td class="vcenter">'.($rujuk_l['jml'] + $rujuk_p['jml']).'</td>
		</tr>
  ';

  $result .='
  </tbody>
</table>
    </div>
  </div>
</div>';

			echo $result; exit;
		
		}
		
		$data['page_name']  = 'lap_prokes';
		$data['page_title'] = 'Laporan Program Kesehatan Gigi dan Mulut';
		$this->template->display('form_prokes', $data);
	}
}