<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_lb_4_gigi extends CI_Controller
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
		
		$this->load->model('m_lb4_gigi');
		
		$this->load->library('template');
		
		$this->load->library('Datatables');
        $this->load->library('table');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	
	function lb4_gigi($par1 = '', $par2 = '', $par3 = '')
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
			$inputFileName	= APPPATH . "libraries/format_lb4_gigi.xls";
			
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
			
			$objPHPExcel->getActiveSheet()->setCellValue('D1', $data['puskesmas'][0]['kd_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('D2', $data['puskesmas'][0]['nm_kelurahan']);
			$objPHPExcel->getActiveSheet()->setCellValue('D3', $data['puskesmas'][0]['nm_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('D4', $data['puskesmas'][0]['nm_kecamatan']);
			$objPHPExcel->getActiveSheet()->setCellValue('I1', $bulan);
			$objPHPExcel->getActiveSheet()->setCellValue('I2', $thn);
            
			// Kunjungan Baru
			$kunj_baru_umum_dw = $this->m_lb4_gigi->get_jml_kunjungan_baru_umum_dw($bln, $thn);
			$kunj_baru_bpjs_dw = $this->m_lb4_gigi->get_jml_kunjungan_baru_bpjs_dw($bln, $thn);
			$kunj_baru_umum_lw = $this->m_lb4_gigi->get_jml_kunjungan_baru_umum_lw($bln, $thn);
			$kunj_baru_bpjs_lw = $this->m_lb4_gigi->get_jml_kunjungan_baru_bpjs_lw($bln, $thn);
			
			// Kunjungan Lama
			$kunj_lama_umum_dw = $this->m_lb4_gigi->get_jml_kunjungan_lama_umum_dw($bln, $thn);
			$kunj_lama_bpjs_dw = $this->m_lb4_gigi->get_jml_kunjungan_lama_bpjs_dw($bln, $thn);
			$kunj_lama_umum_lw = $this->m_lb4_gigi->get_jml_kunjungan_lama_umum_lw($bln, $thn);
			$kunj_lama_bpjs_lw = $this->m_lb4_gigi->get_jml_kunjungan_lama_bpjs_lw($bln, $thn);
			
			// Tumpatan gigi tetap
			$tgt_umum_dw = $this->m_lb4_gigi->get_jml_tambal_gigi_tetap_umum_dw($bln, $thn);
			$tgt_bpjs_dw = $this->m_lb4_gigi->get_jml_tambal_gigi_tetap_bpjs_dw($bln, $thn);
			$tgt_umum_lw = $this->m_lb4_gigi->get_jml_tambal_gigi_tetap_umum_lw($bln, $thn);
			$tgt_bpjs_lw = $this->m_lb4_gigi->get_jml_tambal_gigi_tetap_bpjs_lw($bln, $thn);
			
			// Cabut gigi Tetap
			$cbt_umum_dw = $this->m_lb4_gigi->get_jml_cabut_gigi_tetap_umum_dw($bln, $thn);
			$cbt_bpjs_dw = $this->m_lb4_gigi->get_jml_cabut_gigi_tetap_bpjs_dw($bln, $thn);
			$cbt_umum_lw = $this->m_lb4_gigi->get_jml_cabut_gigi_tetap_umum_lw($bln, $thn);
			$cbt_bpjs_lw = $this->m_lb4_gigi->get_jml_cabut_gigi_tetap_bpjs_lw($bln, $thn);
			
			// Cabut gigi sulung
			$cbts_umum_dw = $this->m_lb4_gigi->get_jml_cabut_gigi_sulung_umum_dw($bln, $thn);
			$cbts_bpjs_dw = $this->m_lb4_gigi->get_jml_cabut_gigi_sulung_bpjs_dw($bln, $thn);
			$cbts_umum_lw = $this->m_lb4_gigi->get_jml_cabut_gigi_sulung_umum_lw($bln, $thn);
			$cbts_bpjs_lw = $this->m_lb4_gigi->get_jml_cabut_gigi_sulung_bpjs_lw($bln, $thn);
			
			// Pengobatan pulpa
			$pp_umum_dw = $this->m_lb4_gigi->get_jml_pengobatan_pulpa_umum_dw($bln, $thn);
			$pp_bpjs_dw = $this->m_lb4_gigi->get_jml_pengobatan_pulpa_bpjs_dw($bln, $thn);
			$pp_umum_lw = $this->m_lb4_gigi->get_jml_pengobatan_pulpa_umum_lw($bln, $thn);
			$pp_bpjs_lw = $this->m_lb4_gigi->get_jml_pengobatan_pulpa_bpjs_lw($bln, $thn);
			
			// Pengobatan gusi
			$pg_umum_dw = $this->m_lb4_gigi->get_jml_pengobatan_gusi_umum_dw($bln, $thn);
			$pg_bpjs_dw = $this->m_lb4_gigi->get_jml_pengobatan_gusi_bpjs_dw($bln, $thn);
			$pg_umum_lw = $this->m_lb4_gigi->get_jml_pengobatan_gusi_umum_lw($bln, $thn);
			$pg_bpjs_lw = $this->m_lb4_gigi->get_jml_pengobatan_gusi_bpjs_lw($bln, $thn);
			
			// Pembersihan Karang Gigi
			$pkg_umum_dw = $this->m_lb4_gigi->get_jml_pembersihan_karang_gigi_umum_dw($bln, $thn);
			$pkg_bpjs_dw = $this->m_lb4_gigi->get_jml_pembersihan_karang_gigi_bpjs_dw($bln, $thn);
			$pkg_umum_lw = $this->m_lb4_gigi->get_jml_pembersihan_karang_gigi_umum_lw($bln, $thn);
			$pkg_bpjs_lw = $this->m_lb4_gigi->get_jml_pembersihan_karang_gigi_bpjs_lw($bln, $thn);
			
			
			$objPHPExcel->getActiveSheet()->setCellValue('E14', $kunj_baru_umum_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('F14', $kunj_baru_bpjs_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('G14', $kunj_baru_bpjs_lw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('I14', $kunj_baru_umum_lw['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('E15', $kunj_lama_umum_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('F15', $kunj_lama_bpjs_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('G15', $kunj_lama_bpjs_lw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('I15', $kunj_lama_umum_lw['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('E17', $tgt_umum_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('F17', $tgt_bpjs_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('G17', $tgt_bpjs_lw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('I17', $tgt_umum_lw['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('E18', $cbt_umum_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('F18', $cbt_bpjs_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('G18', $cbt_bpjs_lw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('I18', $cbt_umum_lw['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('E20', $cbts_umum_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('F20', $cbts_bpjs_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('G20', $cbts_bpjs_lw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('I20', $cbts_umum_lw['jml']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('E23', $pkg_umum_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('F23', $pkg_bpjs_dw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('G23', $pkg_bpjs_lw['jml']);
			$objPHPExcel->getActiveSheet()->setCellValue('I23', $pkg_umum_lw['jml']);
			
						
			$filename='LB4_BP_GIGI_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}

		if ($par1 == 'preview') {
            //error_reporting(1);
			
			
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
			
			// Kunjungan Baru
			$kunj_baru_umum_dw = $this->m_lb4_gigi->get_jml_kunjungan_baru_umum_dw($bln, $thn);
			$kunj_baru_bpjs_dw = $this->m_lb4_gigi->get_jml_kunjungan_baru_bpjs_dw($bln, $thn);
			$kunj_baru_umum_lw = $this->m_lb4_gigi->get_jml_kunjungan_baru_umum_lw($bln, $thn);
			$kunj_baru_bpjs_lw = $this->m_lb4_gigi->get_jml_kunjungan_baru_bpjs_lw($bln, $thn);
			
			// Kunjungan Lama
			$kunj_lama_umum_dw = $this->m_lb4_gigi->get_jml_kunjungan_lama_umum_dw($bln, $thn);
			$kunj_lama_bpjs_dw = $this->m_lb4_gigi->get_jml_kunjungan_lama_bpjs_dw($bln, $thn);
			$kunj_lama_umum_lw = $this->m_lb4_gigi->get_jml_kunjungan_lama_umum_lw($bln, $thn);
			$kunj_lama_bpjs_lw = $this->m_lb4_gigi->get_jml_kunjungan_lama_bpjs_lw($bln, $thn);
			
			// Tumpatan Gigi Tetap
			$tgt_umum_dw = $this->m_lb4_gigi->get_jml_tambal_gigi_tetap_umum_dw($bln, $thn);
			$tgt_bpjs_dw = $this->m_lb4_gigi->get_jml_tambal_gigi_tetap_bpjs_dw($bln, $thn);
			$tgt_umum_lw = $this->m_lb4_gigi->get_jml_tambal_gigi_tetap_umum_lw($bln, $thn);
			$tgt_bpjs_lw = $this->m_lb4_gigi->get_jml_tambal_gigi_tetap_bpjs_lw($bln, $thn);
			
			// Cabut gigi tetap
			$cbt_umum_dw = $this->m_lb4_gigi->get_jml_cabut_gigi_tetap_umum_dw($bln, $thn);
			$cbt_bpjs_dw = $this->m_lb4_gigi->get_jml_cabut_gigi_tetap_bpjs_dw($bln, $thn);
			$cbt_umum_lw = $this->m_lb4_gigi->get_jml_cabut_gigi_tetap_umum_lw($bln, $thn);
			$cbt_bpjs_lw = $this->m_lb4_gigi->get_jml_cabut_gigi_tetap_bpjs_lw($bln, $thn);
			
			// Cabut gigi sulung
			$cbts_umum_dw = $this->m_lb4_gigi->get_jml_cabut_gigi_sulung_umum_dw($bln, $thn);
			$cbts_bpjs_dw = $this->m_lb4_gigi->get_jml_cabut_gigi_sulung_bpjs_dw($bln, $thn);
			$cbts_umum_lw = $this->m_lb4_gigi->get_jml_cabut_gigi_sulung_umum_lw($bln, $thn);
			$cbts_bpjs_lw = $this->m_lb4_gigi->get_jml_cabut_gigi_sulung_bpjs_lw($bln, $thn);
			
			// Pengobatan pulpa
			$pp_umum_dw = $this->m_lb4_gigi->get_jml_pengobatan_pulpa_umum_dw($bln, $thn);
			$pp_bpjs_dw = $this->m_lb4_gigi->get_jml_pengobatan_pulpa_bpjs_dw($bln, $thn);
			$pp_umum_lw = $this->m_lb4_gigi->get_jml_pengobatan_pulpa_umum_lw($bln, $thn);
			$pp_bpjs_lw = $this->m_lb4_gigi->get_jml_pengobatan_pulpa_bpjs_lw($bln, $thn);
			
			// Pengobatan gusi
			$pg_umum_dw = $this->m_lb4_gigi->get_jml_pengobatan_gusi_umum_dw($bln, $thn);
			$pg_bpjs_dw = $this->m_lb4_gigi->get_jml_pengobatan_gusi_bpjs_dw($bln, $thn);
			$pg_umum_lw = $this->m_lb4_gigi->get_jml_pengobatan_gusi_umum_lw($bln, $thn);
			$pg_bpjs_lw = $this->m_lb4_gigi->get_jml_pengobatan_gusi_bpjs_lw($bln, $thn);
			
			
			// Pembersihan karang gigi
			$pkg_umum_dw = $this->m_lb4_gigi->get_jml_pembersihan_karang_gigi_umum_dw($bln, $thn);
			$pkg_bpjs_dw = $this->m_lb4_gigi->get_jml_pembersihan_karang_gigi_bpjs_dw($bln, $thn);
			$pkg_umum_lw = $this->m_lb4_gigi->get_jml_pembersihan_karang_gigi_umum_lw($bln, $thn);
			$pkg_bpjs_lw = $this->m_lb4_gigi->get_jml_pembersihan_karang_gigi_bpjs_lw($bln, $thn);
			

			$result = '';
			$result .= '<div class="container-fluid">
  <div class="row">
    <div class="span12">
    <table class="table table-bordered table-responsive">
  	<thead>
	    <tr>
	      <th class="vcenter" rowspan="2">No</th>
	      <th class="vcenter" rowspan="2">Kegiatan</th>
	      <th class="vcenter" colspan="2">Dalam Wilayah</th>
	      <th class="vcenter" colspan="2">Luar Wilayah</th>
	    </tr>
	    <tr>
	      <th class="vcenter">Umum</th>
		  <th class="vcenter">BPJS</th>
		  <th class="vcenter">BPJS</th>
		  <th class="vcenter">Umum</th>
	    </tr>
  </thead>
  <tbody>
  		<tr>
			<td class="vcenter"><b>V</b></td>
			<td><b>UPAYA KESEHATAN GIGI</b></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td class="vcenter"><b>A</b></td>
			<td><b>KUNJUNGAN DI BP. GIGI</b></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td class="vcenter">1</td>
			<td>Kunjungan Baru Rawat Jalan Gigi</td>
			<td class="vcenter">'.$kunj_baru_umum_dw['jml'].'</td>
			<td class="vcenter">'.$kunj_baru_bpjs_dw['jml'].'</td>
			<td class="vcenter">'.$kunj_baru_bpjs_lw['jml'].'</td>
			<td class="vcenter">'.$kunj_baru_umum_lw['jml'].'</td>
		</tr>
		<tr>
			<td class="vcenter">2</td>
			<td>Kunjungan Lama Rawat Jalan Gigi</td>
			<td class="vcenter">'.$kunj_lama_umum_dw['jml'].'</td>
			<td class="vcenter">'.$kunj_lama_bpjs_dw['jml'].'</td>
			<td class="vcenter">'.$kunj_lama_bpjs_lw['jml'].'</td>
			<td class="vcenter">'.$kunj_lama_umum_lw['jml'].'</td>
		</tr>
		<tr>
			<td class="vcenter">3</td>
			<td>Hari Buka Bp. Gigi</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td class="vcenter">4</td>
			<td>Tumpatan pada Gigi Tetap</td>
			<td>'.$tgt_umum_dw['jml'].'</td>
			<td>'.$tgt_bpjs_dw['jml'].'</td>
			<td>'.$tgt_bpjs_lw['jml'].'</td>
			<td>'.$tgt_umum_lw['jml'].'</td>
		</tr>
		<tr>
			<td class="vcenter">5</td>
			<td>Pencabutan Gigi Tetap</td>
			<td>'.$cbt_umum_dw['jml'].'</td>
			<td>'.$cbt_bpjs_dw['jml'].'</td>
			<td>'.$cbt_bpjs_lw['jml'].'</td>
			<td>'.$cbt_umum_lw['jml'].'</td>
		</tr>
		<tr>
			<td class="vcenter">6</td>
			<td>Tumpatan Gigi Sulung</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td class="vcenter">7</td>
			<td>Pencabutan Gigi Sulung</td>
			<td>'.$cbts_umum_dw['jml'].'</td>
			<td>'.$cbts_bpjs_dw['jml'].'</td>
			<td>'.$cbts_bpjs_lw['jml'].'</td>
			<td>'.$cbts_umum_lw['jml'].'</td>
		</tr>
		<tr>
			<td class="vcenter">8</td>
			<td>Pengobatan Pulpa dan jaringan peri apikal</td>
			<td>'.$pp_umum_dw['jml'].'</td>
			<td>'.$pp_bpjs_dw['jml'].'</td>
			<td>'.$pp_bpjs_lw['jml'].'</td>
			<td>'.$pp_umum_lw['jml'].'</td>
		</tr>
		<tr>
			<td class="vcenter">9</td>
			<td>Pengobatan Gusi dan atau Periodontal</td>
			<td>'.$pg_umum_dw['jml'].'</td>
			<td>'.$pg_bpjs_dw['jml'].'</td>
			<td>'.$pg_bpjs_lw['jml'].'</td>
			<td>'.$pg_umum_lw['jml'].'</td>
		</tr>
		<tr>
			<td class="vcenter">10</td>
			<td>Pembersihan Karang Gigi</td>
			<td>'.$pkg_umum_dw['jml'].'</td>
			<td>'.$pkg_bpjs_dw['jml'].'</td>
			<td>'.$pkg_bpjs_lw['jml'].'</td>
			<td>'.$pkg_umum_lw['jml'].'</td>
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
		
		$data['page_name']  = 'lb4_gigi';
		$data['page_title'] = 'LB4 BP Gigi';
		$this->template->display('form_lb4_gigi', $data);
	}	

}
?>