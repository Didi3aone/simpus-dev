<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lap_prokes extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function get_jml_kunjungan_gigi($bln, $thn, $kunjungan, $kd_jenkel){
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kunjungan', $kunjungan);
		$this->db->where('kd_jenis_kelamin', $kd_jenkel);
		$this->db->where('kd_unit_pelayanan', 3);
	
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_penyakit_gigi($bln, $thn, $icd, $kd_jenkel)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_penyakit', $icd);
		$this->db->where('kd_jenis_kelamin', $kd_jenkel);
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_tambal_gigi_tetap($bln, $thn, $kd_jenkel)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kelamin', $kd_jenkel);
		$this->db->where('(kd_produk ="7A.02" OR kd_produk="7A.03" OR kd_produk="7A.01" OR kd_produk="7A.04" OR kd_produk="7A.05")');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_cabut_gigi_tetap($bln, $thn, $kd_jenkel)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kelamin', $kd_jenkel);
		$this->db->where('(kd_produk ="7A.10" OR kd_produk="7A.11" OR kd_produk="7A.14")');
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_cabut_gigi_sulung($bln, $thn, $kd_jenkel)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kelamin', $kd_jenkel);
		$this->db->where('(kd_produk ="7A.06" OR kd_produk="7A.07")');
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pengobatan_pulpa($bln, $thn, $kd_jenkel)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kelamin', $kd_jenkel);
		$this->db->where('obat !=', 'NULL');
		$this->db->like('kd_icd', 'K04');
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pengobatan_gusi($bln, $thn, $kd_jenkel)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kelamin', $kd_jenkel);
		$this->db->where('obat !=', 'NULL');
		$this->db->like('kd_icd', 'K05');
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_pembersihan_karang_gigi($bln, $thn, $kd_jenkel)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_tindakan');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kelamin', $kd_jenkel);
		$this->db->where('kd_produk', '7A.15');
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_rujukan($bln, $thn, $kd_jenkel)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('pelayanan p');
		$this->db->join('pasien pas', 'p.kd_rekam_medis = pas.kd_rekam_medis');
		$this->db->where('MONTH(p.tgl_pelayanan)', $bln);
		$this->db->where('YEAR(p.tgl_pelayanan)', $thn);
		$this->db->where('pas.kd_jenis_kelamin', $kd_jenkel);
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	
}