<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_cetak_lap_harian extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// cek session
		if ($this->session->userdata('logged_in') == false) {
			$this->session->unset_userdata();
			$this->session->sess_destroy();
			redirect('login');
		}
		
		$this->load->model('m_register_harian');		
		$this->load->library('template');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	
	function register_harian($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
		
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/register_harian.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_register_harian->get_puskesmas_info($kd_puskesmas);
						
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);
			

			//$tgl	= $this->input->post('tgl');
			$tgl_mulai	= $this->input->post('tgl_mulai');
			$tgl_akhir	= $this->input->post('tgl_akhir');
			$kd_unit_pelayanan = $this->input->post('kd_unit_pelayanan');
			$kd_bayar = $this->input->post('kd_bayar');
			$unit = $this->m_register_harian->get_unit_pelayanan_info($kd_unit_pelayanan);
			$cara_bayar = $this->m_register_harian->get_cara_bayar_info($kd_bayar);
			$pasien = $this->m_register_harian->get_pasien_rawat_umum_by_date($this->functions->convert_date_sql($tgl_mulai), $this->functions->convert_date_sql($tgl_akhir), $kd_unit_pelayanan, $kd_bayar);
			
			#echo $this->db->last_query(); exit;  //untuk menampilkan sintaks query trakir
			
			#echo '<pre>'; print_r($data); exit;
			
			#echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
			if ($kd_unit_pelayanan =='') {
				$unitnya = "SEMUA UNIT PELAYANAN";
			} else {$unitnya = $unit['nm_unit'];}
			
			$judul = "REGISTER RAWAT JALAN $unitnya ";
			if ($kd_bayar =='') {
				$caraku = " - ";
			} else {$caraku = $cara_bayar['cara_bayar'];}
			
			$cr_byr = "Pasien $caraku ";
			
			$objPHPExcel->getActiveSheet()->setCellValue('A1', $judul);
			$objPHPExcel->getActiveSheet()->setCellValue('A2', $puskesmas['nm_puskesmas']);
            $objPHPExcel->getActiveSheet()->setCellValue('A3', $tgl_mulai.' sd '.$tgl_akhir);
			$objPHPExcel->getActiveSheet()->setCellValue('A4', $cr_byr);

            $i=7;
            $no=1;

            foreach($pasien as $rs){
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $rs['kd_rekam_medis']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $rs['nm_lengkap']);
                switch($rs['kd_jenis_kelamin']){
                    case 1: $jk = "L"; break;
                    case 2: $jk = "P"; break;
                }
				if ($rs['alamat']=='') {$rs['alamat']= "-";}
				if ($rs['nm_kelurahan']=='') {$rs['nm_kelurahan']= "-";}
				if ($rs['nm_kota']=='') {$rs['nm_kota']= "-";}
				if ($rs['cara_bayar']=='') {$rs['cara_bayar']= "-";}
				if ($rs['penyakit']=='') {$rs['penyakit']= "-";}
				if ($rs['tindakan']=='') {$rs['tindakan']= "-";}
				if ($rs['jns_kasus']=='') {$rs['jns_kasus']= "-";}
				if ($rs['keterangan']=='') {$rs['keterangan']= "-";}
				if ($rs['nm_dokter']=='') {$rs['nm_dokter']= "-";}
				if ($rs['no_asuransi']=='') {$rs['no_asuransi']= "-";}
				$teks =  $rs['cara_bayar'].' ('. $rs['no_asuransi'].')';
				$asuransi = ' '.$rs["no_asuransi"];
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $jk);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $rs['alamat']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $rs['nm_kelurahan']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $rs['nm_kota']);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $rs['gol_umur']);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $rs['cara_bayar']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $asuransi);
				//$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $teks);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $rs['penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $rs['tindakan']);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $rs['jns_kasus']);
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $rs['keterangan']);
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $rs['nm_dokter']);
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $rs['nm_unit']);
                $i++;
                $no++;
            }

			
			$filename='Register_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		$data['list_unit_pelayanan']		= $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_kd_bayar']		= $this->m_crud->get_list_cara_bayar('1');
		$data['page_name']  = 'RegisterHarian';
		$data['page_title'] = 'Register Harian';
		$this->template->display('form_register', $data);
	}
	
	function rekap_pasien($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
		
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/rekap_cara_bayar.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_register_harian->get_puskesmas_info($kd_puskesmas);
						
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);
			

			$tgl_mulai	= $this->input->post('tgl_mulai');
			$tgl_akhir	= $this->input->post('tgl_akhir');
			//$unit = $this->m_register_harian->get_unit_pelayanan_info($kd_unit_pelayanan);
			$rekap = $this->m_register_harian->get_rekap_cara_bayar($this->functions->convert_date_sql($tgl_mulai), $this->functions->convert_date_sql($tgl_akhir));
			
			#echo $this->db->last_query(); exit;  //untuk menampilkan sintaks query trakir
			
			#echo '<pre>'; print_r($data); exit;
			
			#echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
			
			$objPHPExcel->getActiveSheet()->setCellValue('B3', $puskesmas['nm_puskesmas']);
			$tanggalnya	= $tgl_mulai.' sd '.$tgl_akhir;
            $objPHPExcel->getActiveSheet()->setCellValue('B4', $tanggalnya);

            $i=7;
            $no=1;

            foreach($rekap as $rs){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $rs['kd_bayar']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $rs['nm_unit']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $rs['jml']);
				
                $i++;
                $no++;
            }

			
			$filename='Rekap_harian_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		$data['page_name']  = 'RekapHarian';
		$data['page_title'] = 'Rekap Harian';
		$this->template->display('form_rekap_kdbayar', $data);
	}
	
	function rekap_stok_obat($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
		
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/rekap_stok_obat.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_register_harian->get_puskesmas_info($kd_puskesmas);
						
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);

			$tgl	= $this->input->post('tgl');
			//$unit = $this->m_register_harian->get_unit_pelayanan_info($kd_unit_pelayanan);
			$rekap = $this->m_register_harian->get_rekap_stok_obat();
			
			#echo $this->db->last_query(); exit;  //untuk menampilkan sintaks query trakir
			
			#echo '<pre>'; print_r($data); exit;
			
			#echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
			
			$objPHPExcel->getActiveSheet()->setCellValue('C2', $puskesmas['nm_puskesmas']);
            $objPHPExcel->getActiveSheet()->setCellValue('C3', $tgl);

            $i=7;
            $no=1;

            foreach($rekap as $rs){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $rs['kd_obat']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $rs['nama_obat']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $rs['obat_stok']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $rs['apotek_stok']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $rs['sat_kecil_obat']);
				
                $i++;
                $no++;
            }

			
			$filename='Rekap_stok_obat_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		$data['page_name']  = 'RekapStokObat';
		$data['page_title'] = 'Rekap Stok Obat';
		$this->template->display('form_rekap_stok_obat', $data);
	}
}
?>