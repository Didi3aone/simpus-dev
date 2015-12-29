<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lb4_gigi extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	/***************************** DALAM WILAYAH *****************************/
	function get_jml_kunjungan_baru_umum_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kasus', 1);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_kunjungan_baru_bpjs_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kasus', 1);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_kunjungan_baru_umum_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kasus', 1);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_kunjungan_baru_bpjs_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kasus', 1);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	
	
	
	/***************************** LUAR WILAYAH *****************************/
	function get_jml_kunjungan_lama_umum_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kasus', 2);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_kunjungan_lama_bpjs_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kasus', 2);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_kunjungan_lama_umum_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kasus', 2);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_kunjungan_lama_bpjs_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kasus', 2);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	// tumpat gigi tetap
	function get_jml_tambal_gigi_tetap_umum_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('(kd_produk ="7A.02" OR kd_produk="7A.03" OR kd_produk="7A.01" OR kd_produk="7A.04" OR kd_produk="7A.05")');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_tambal_gigi_tetap_bpjs_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('(kd_produk ="7A.02" OR kd_produk="7A.03" OR kd_produk="7A.01" OR kd_produk="7A.04" OR kd_produk="7A.05")');
		
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_tambal_gigi_tetap_umum_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('(kd_produk ="7A.02" OR kd_produk="7A.03" OR kd_produk="7A.01" OR kd_produk="7A.04" OR kd_produk="7A.05")');
		
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_tambal_gigi_tetap_bpjs_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('(kd_produk ="7A.02" OR kd_produk="7A.03" OR kd_produk="7A.01" OR kd_produk="7A.04" OR kd_produk="7A.05")');
		
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	// cabut gigi tetap
	function get_jml_cabut_gigi_tetap_umum_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('(kd_produk ="7A.10" OR kd_produk="7A.11" OR kd_produk="7A.14")');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_cabut_gigi_tetap_bpjs_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('(kd_produk ="7A.10" OR kd_produk="7A.11" OR kd_produk="7A.14")');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_cabut_gigi_tetap_umum_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('(kd_produk ="7A.10" OR kd_produk="7A.11" OR kd_produk="7A.14")');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_cabut_gigi_tetap_bpjs_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('(kd_produk ="7A.10" OR kd_produk="7A.11" OR kd_produk="7A.14")');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	// cabut gigi sulung
	function get_jml_cabut_gigi_sulung_umum_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('(kd_produk ="7A.06" OR kd_produk="7A.07")');
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_cabut_gigi_sulung_bpjs_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('(kd_produk ="7A.06" OR kd_produk="7A.07")');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_cabut_gigi_sulung_umum_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('(kd_produk ="7A.06" OR kd_produk="7A.07")');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_cabut_gigi_sulung_bpjs_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('(kd_produk ="7A.06" OR kd_produk="7A.07")');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	// pembersihan karang gigi
	function get_jml_pembersihan_karang_gigi_umum_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('kd_produk', '7A.15');
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pembersihan_karang_gigi_bpjs_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('kd_produk', '7A.15');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pembersihan_karang_gigi_umum_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('kd_produk', '7A.15');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pembersihan_karang_gigi_bpjs_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('kd_produk', '7A.15');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	// pengobatan pulpa
	function get_jml_pengobatan_pulpa_umum_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('obat !=', 'NULL');
		$this->db->like('kd_icd', 'K04');
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pengobatan_pulpa_bpjs_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('obat !=', 'NULL');
		$this->db->like('kd_icd', 'K04');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pengobatan_pulpa_umum_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('obat !=', 'NULL');
		$this->db->like('kd_icd', 'K04');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pengobatan_pulpa_bpjs_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('obat !=', 'NULL');
		$this->db->like('kd_icd', 'K04');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	// Pengobatan gusi
	function get_jml_pengobatan_gusi_umum_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('obat !=', 'NULL');
		$this->db->like('kd_icd', 'K05');
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pengobatan_gusi_bpjs_dw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan', '3271060002');
		$this->db->where('obat !=', 'NULL');
		$this->db->like('kd_icd', 'K05');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pengobatan_gusi_umum_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('obat !=', 'NULL');
		$this->db->like('kd_icd', 'K05');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pengobatan_gusi_bpjs_lw($bln, $thn)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_bayar !=', 'BS');
		$this->db->where('kd_kelurahan !=', '3271060002');
		$this->db->where('obat !=', 'NULL');
		$this->db->like('kd_icd', 'K05');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
}