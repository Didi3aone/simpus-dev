<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_lb_1 extends CI_Controller
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
		
		$this->load->model('m_lb1');
		
		$this->load->library('template');
		
		$this->load->library('Datatables');
        $this->load->library('table');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	
	function lb1($par1 = '', $par2 = '', $par3 = '')
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
			$inputFileName	= APPPATH . "libraries/format_lb1.xls";
			
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
			
			$objPHPExcel->getActiveSheet()->setCellValue('F1', $data['puskesmas'][0]['kd_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('F2', $data['puskesmas'][0]['nm_kelurahan']);
			$objPHPExcel->getActiveSheet()->setCellValue('F3', $data['puskesmas'][0]['nm_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('F4', $data['puskesmas'][0]['nm_kecamatan']);
			$objPHPExcel->getActiveSheet()->setCellValue('F5', $data['puskesmas'][0]['nm_kota']);
			$objPHPExcel->getActiveSheet()->setCellValue('F6', $data['puskesmas'][0]['nm_propinsi']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH5', $bulan);
			$objPHPExcel->getActiveSheet()->setCellValue('AH6', $thn);
            $objPHPExcel->getActiveSheet()->setCellValue('B291', 'Kepala Puskesmas '.$data['puskesmas'][0]['nm_puskesmas']);
			
			
			// Writing row by row.

			$icd = $this->m_lb1->get_list_icd();
			$start_i = 13;
			$no = 1;

			foreach($icd as $r):

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$start_i.'', $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$start_i.'', $r['penyakit']);

				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 1, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$start_i.'', $a['jml']);
				// Golongan Umur 0-7 gol 1 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 1, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$start_i.'', $a['jml']);
				// Golongan Umur 8-28hr gol 2 (Laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 2, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$start_i.'', $a['jml']);
				// Golongan Umur 8-28hr gol 2 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 2, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$start_i.'', $a['jml']);
				// Golongan Umur 29hr-1th gol 3 (Laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 3, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$start_i.'', $a['jml']);
				// Golongan Umur 29hr-1th gol 3 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 3, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$start_i.'', $a['jml']);
				// Golongan Umur 1-4th Gol 4 (Laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 4, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$start_i.'', $a['jml']);
				// Golongan Umur 1-4th Gol 4(Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 4, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$start_i.'', $a['jml']);
				// Golongan Umur 5-9th Gol 5(Laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 5, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$start_i.'', $a['jml']);
				// Golongan Umur 5-9th Gol 5 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 5, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$start_i.'', $a['jml']);
				// Golongan Umur 10-14th gol 6 (Laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 6, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('S'.$start_i.'', $a['jml']);
				// Golongan Umur 10-14th gol 6 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 6, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$start_i.'', $a['jml']);
				// Golongan Umur 15-19th gol 7 (Laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1,7 , $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$start_i.'', $a['jml']);
				// Golongan Umur 15-19th gol 7 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 7, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('V'.$start_i.'', $a['jml']);
				// Golongan Umur 20-44th gol 8 (Laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1,8 , $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('W'.$start_i.'', $a['jml']);
				// Golongan Umur 20-44th gol 8 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 8, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('X'.$start_i.'', $a['jml']);
				// Golongan Umur 45-54th gol 9 (laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 9, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('Y'.$start_i.'', $a['jml']);
				// Golongan Umur 45-54th gol 9 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 9, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('Z'.$start_i.'', $a['jml']);
				// Golongan Umur 55-59th gol 10 (Laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 10, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('AA'.$start_i.'', $a['jml']);
				// Golongan Umur 55-59th gol 10 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 10, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('AB'.$start_i.'', $a['jml']);
				// Golongan Umur 60-69th gol 11 (Laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 11, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('AC'.$start_i.'', $a['jml']);
				// Golongan Umur 60-69th gol 11 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 11, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('AD'.$start_i.'', $a['jml']);
				// Golongan Umur >70th gol 12 (Laki)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 12, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('AE'.$start_i.'', $a['jml']);
				// Golongan Umur >70th gol 12 (Perempuan)
				$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 12, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('AF'.$start_i.'', $a['jml']);

				// Kasus Baru Kolera Laki
				$b = $this->m_lb1->get_jml_kunjungan_per_kasus($bln, $thn, 1, 1, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('AG'.$start_i.'', $b['jml']);
				$b = $this->m_lb1->get_jml_kunjungan_per_kasus($bln, $thn, 2, 1, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('AH'.$start_i.'', $b['jml']);

				// Kasus Lama Kolera Perempuan
				$b = $this->m_lb1->get_jml_kunjungan_per_kasus($bln, $thn, 1, 2, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$start_i.'', $b['jml']);
				$b = $this->m_lb1->get_jml_kunjungan_per_kasus($bln, $thn, 2, 2, $r['kd_penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('AK'.$start_i.'', $b['jml']);

				$start_i++;
				$no++;

			endforeach;
			
						
			$filename='LB1_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
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
			
			/*
			$result['kd_puskesmas'] = $data['puskesmas'][0]['kd_puskesmas'];
			$result['nm_kelurahan'] = $data['puskesmas'][0]['nm_kelurahan'];
			$result['nm_puskesmas'] = $data['puskesmas'][0]['nm_puskesmas'];
			$result['nm_kecamatan'] = $data['puskesmas'][0]['nm_kecamatan'];
			$result['nm_kota'] 		= $data['puskesmas'][0]['nm_kota'];
			$result['nm_propinsi'] 	= $data['puskesmas'][0]['nm_propinsi'];
			$result['bulan'] 		= $bulan;
			$result['tahun']		= $tahun;
			*/

			$result = '';
			$result .= '<div class="container-fluid">
  <div class="row">
    <div class="span12">
    <table class="table table-bordered table-responsive">
  	<thead>
	    <tr>
	      <th class="vcenter" rowspan="3">No</th>
	      <th class="vcenter" rowspan="3">Penyakit</th>
	      <th class="vcenter" colspan="24">Jumlah Kasus Baru Menurut Golongan Umur</th>
	      <th class="vcenter" colspan="3" rowspan="2">Kasus Baru</th>
	      <th class="vcenter" colspan="3" rowspan="2">Kasus Lama</th>
	      <th class="vcenter" rowspan="3">Gakin</th>
	      <th class="vcenter" rowspan="3">Non Gakin</th>
	      <th class="vcenter" rowspan="3">Jumlah</th>
	    </tr>
	    <tr>
	      <th class="vcenter" colspan="2">0-7hr</th>
	      <th class="vcenter" colspan="2">8-28hr</th>
	      <th class="vcenter" colspan="2">29hr-1th</th>
	      <th class="vcenter" colspan="2">1-4th</th>
	      <th class="vcenter" colspan="2">5-9th</th>
	      <th class="vcenter" colspan="2">10-14th</th>
	      <th class="vcenter" colspan="2">15-19th</th>
	      <th class="vcenter" colspan="2">20-44th</th>
	      <th class="vcenter" colspan="2">45-54th</th>
	      <th class="vcenter" colspan="2">55-59th</th>
	      <th class="vcenter" colspan="2">60-69th</th>
	      <th class="vcenter" colspan="2">&gt;-70th</th>
	    </tr>
	    <tr>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter"v>P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">JML</th>
	      <th class="vcenter">L</th>
	      <th class="vcenter">P</th>
	      <th class="vcenter">JML</th>
	    </tr>
  </thead>
  <tbody>';

  $icd = $this->m_lb1->get_list_icd();
  $no = 1;

  foreach($icd as $r):

  	$result .= '<tr>';

  	$result .= '<td>'.$no.'</td>';
  	$result .= '<td>'.$r["penyakit"].'</td>';

  	$total = 0;

  	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 1, $r['kd_penyakit']);
  	$result .= '<td>'.$a["jml"].'</td>';

  	$total = $total + $a["jml"];

	// Golongan Umur 0-7 gol 1 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 1, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

	// Golongan Umur 8-28hr gol 2 (Laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 2, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

	// Golongan Umur 8-28hr gol 2 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 2, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

	// Golongan Umur 29hr-1th gol 3 (Laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 3, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur 29hr-1th gol 3 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 3, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

	
	// Golongan Umur 1-4th Gol 4 (Laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 4, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur 1-4th Gol 4(Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 4, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

	
	// Golongan Umur 5-9th Gol 5(Laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 5, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];
				
	// Golongan Umur 5-9th Gol 5 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 5, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];
			
	// Golongan Umur 10-14th gol 6 (Laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 6, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur 10-14th gol 6 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 6, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];
	
	// Golongan Umur 15-19th gol 7 (Laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1,7 , $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];
				
	// Golongan Umur 15-19th gol 7 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 7, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];
				
	// Golongan Umur 20-44th gol 8 (Laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1,8 , $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur 20-44th gol 8 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 8, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur 45-54th gol 9 (laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 9, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur 45-54th gol 9 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 9, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur 55-59th gol 10 (Laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 10, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur 55-59th gol 10 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 10, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur 60-69th gol 11 (Laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 11, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur 60-69th gol 11 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 11, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];
				
	// Golongan Umur >70th gol 12 (Laki)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 1, 12, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];

				
	// Golongan Umur >70th gol 12 (Perempuan)
	$a = $this->m_lb1->get_jml_kunjungan_per_usia($bln, $thn, 2, 12, $r['kd_penyakit']);
	$result .= '<td>'.$a["jml"].'</td>';

	$total = $total + $a["jml"];


	// Kasus Baru Kolera Laki
	$b = $this->m_lb1->get_jml_kunjungan_per_kasus($bln, $thn, 1, 1, $r['kd_penyakit']);
	$result .= '<td>'.$b["jml"].'</td>';
	$c = $this->m_lb1->get_jml_kunjungan_per_kasus($bln, $thn, 2, 1, $r['kd_penyakit']);
	$result .= '<td>'.$c["jml"].'</td>';

	$result .= '<td>'.($b["jml"]+$c["jml"]).'</td>';

	// Kasus Lama Kolera Perempuan
	$d = $this->m_lb1->get_jml_kunjungan_per_kasus($bln, $thn, 1, 2, $r['kd_penyakit']);
	$result .= '<td>'.$d["jml"].'</td>';
	$e = $this->m_lb1->get_jml_kunjungan_per_kasus($bln, $thn, 2, 2, $r['kd_penyakit']);
	$result .= '<td>'.$e["jml"].'</td>';
	$result .= '<td>'.($d["jml"]+$e["jml"]).'</td>';

	$result .= '<td>0</td>';
	$result .= '<td>0</td>';
	$result .= '<td>'.$total.'</td>';

	$result .= '</tr>';

	$start_i++;
	$no++;

	endforeach;

  $result .='
  </tbody>
</table>
    </div>
  </div>
</div>';

			echo $result; exit;
		
		}
		
		$data['page_name']  = 'lb1';
		$data['page_title'] = 'LB1';
		$this->template->display('form_lb1', $data);
	}
	

}
?>