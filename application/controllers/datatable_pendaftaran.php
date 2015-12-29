<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Datatable_pendaftaran extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Datatables');
        $this->load->library('table');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	/***Default function, redirects to login page if no logged in yet***/
	public function index()
	{
		if (!$this->session->userdata('logged_in') == true)
			redirect('login');	
	}
	
	function pengguna()
    {
        $this->datatables->select('user.id_user,user.nama,user.nip,user.email,akses.akses,puskesmas.nm_puskesmas')
            ->unset_column('user.id_user')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/pengguna/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/pengguna/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_agama')
			->from('user')
			->join('akses', 'user.id_akses = akses.id_akses')
			->join('puskesmas', 'user.kd_puskesmas = puskesmas.kd_puskesmas');
 
        echo $this->datatables->generate();
    }
	
	function agama()
    {
        $this->datatables->select('kd_agama,nm_agama')
            ->unset_column('kd_agama')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/agama/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'op_pendaftaran/agama/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_agama')
			->from('agama');
 
        echo $this->datatables->generate();
    }
	
	function puskesmas()
	{
		$this->datatables->select('puskesmas.kd_puskesmas,puskesmas.nm_puskesmas,puskesmas.alamat,jenis_puskesmas.jenis_puskesmas,kecamatan.nm_kecamatan,puskesmas.puskesmas_induk')
            //->unset_column('puskesmas.kd_puskesmas')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/puskesmas/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/puskesmas/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','puskesmas.kd_puskesmas')
			->from('puskesmas')
			->join('jenis_puskesmas', 'puskesmas.id_jenis_puskesmas = jenis_puskesmas.id_jenis_puskesmas')
			->join('kecamatan', 'puskesmas.kd_kecamatan = kecamatan.kd_kecamatan');
 
        echo $this->datatables->generate();
	}
	
	function cara_bayar()
	{
		$this->datatables->select('kd_bayar,cara_bayar,kd_customer')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/cara_bayar/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/cara_bayar/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_bayar')
			->from('cara_bayar');
 
        echo $this->datatables->generate();
	}
	
	function jenis_kelamin()
	{
		$this->datatables->select('kd_jenis_kelamin,jenis_kelamin')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/jenis_kelamin/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/jenis_kelamin/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_jenis_kelamin')
			->from('jenis_kelamin');
 
        echo $this->datatables->generate();
	}
	
	function golongan_darah()
	{
		$this->datatables->select('kd_gol_darah,gol_darah')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/golongan_darah/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/golongan_darah/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_gol_darah')
			->from('golongan_darah');
 
        echo $this->datatables->generate();
	}
	
	function pendidikan()
	{
		$this->datatables->select('kd_pendidikan,pendidikan')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/pendidikan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/pendidikan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_pendidikan')
			->from('pendidikan');
 
        echo $this->datatables->generate();
	}
	
	function pekerjaan()
	{
		$this->datatables->select('kd_pekerjaan,pekerjaan')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/pekerjaan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/pekerjaan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_pekerjaan')
			->from('pekerjaan');
 
        echo $this->datatables->generate();
	}
	
	function obat()
	{
		$this->datatables->select('o.kd_obat,o.nama_obat,golongan_obat.gol_obat,satuan_kecil.sat_kecil_obat,terapi_obat.terapi_obat,o.sa_gudang')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/obat/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','o.kd_obat')
			->from(''.$this->session->userdata('obat_pref').' o')
			->join('golongan_obat', 'o.kd_gol_obat = golongan_obat.kd_gol_obat')
			->join('satuan_kecil', 'o.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat')
			->join('terapi_obat', 'o.kd_terapi_obat = terapi_obat.kd_terapi_obat');
 
        echo $this->datatables->generate();
	}
	
	function golongan_obat()
	{
		$this->datatables->select('kd_gol_obat,gol_obat')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/golongan_obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/golongan_obat/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_gol_obat')
			->from('golongan_obat');
 
        echo $this->datatables->generate();
	}
	
	function jenis_obat()
	{
		$this->datatables->select('kd_jenis_obat,jenis_obat')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/jenis_obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/jenis_obat/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_jenis_obat')
			->from('jenis_obat');
 
        echo $this->datatables->generate();
	}
	
	function milik_obat()
	{
		$this->datatables->select('kd_milik_obat,kepemilikan')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/milik_obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/milik_obat/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_milik_obat')
			->from('milik_obat');
 
        echo $this->datatables->generate();
	}
	
	function satuan_besar()
	{
		$this->datatables->select('kd_sat_besar_obat,sat_besar_obat')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/satuan_besar/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/satuan_besar/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_sat_besar_obat')
			->from('satuan_besar');
 
        echo $this->datatables->generate();
	}
	
	function satuan_kecil()
	{
		$this->datatables->select('kd_sat_kecil_obat,sat_kecil_obat')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/satuan_kecil/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/satuan_kecil/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_sat_kecil_obat')
			->from('satuan_kecil');
 
        echo $this->datatables->generate();
	}
	
	function terapi_obat()
	{
		$this->datatables->select('kd_terapi_obat,terapi_obat')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/terapi_obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/terapi_obat/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_terapi_obat')
			->from('terapi_obat');
 
        echo $this->datatables->generate();
	}
	
	function unit_farmasi()
	{
		$this->datatables->select('kd_unit_farmasi,nama_unit_farmasi,farmasi_utama')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/unit_farmasi/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/unit_farmasi/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_unit_farmasi')
			->from('unit_farmasi');
 
        echo $this->datatables->generate();
	}
	
	function golongan_petugas()
	{
		$this->datatables->select('kd_gol,nama_gol')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/golongan_petugas/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/golongan_petugas/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_gol')
			->from('golongan_petugas');
 
        echo $this->datatables->generate();
	}
	
	function posisi()
	{
		$this->datatables->select('kd_posisi,posisi')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/posisi/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/posisi/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_posisi')
			->from('posisi');
 
        echo $this->datatables->generate();

	}
	
	function spesialisasi()
	{
		$this->datatables->select('kd_spesialisasi,spesialisasi')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/spesialisasi/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/spesialisasi/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_spesialisasi')
			->from('spesialisasi');
 
        echo $this->datatables->generate();
	}
	
	function pendidikan_kesehatan()
	{
		$this->datatables->select('kd_pendidikan,pendidikan')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/pendidikan_kesehatan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/pendidikan_kesehatan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_pendidikan')
			->from('pendidikan_kesehatan');
 
        echo $this->datatables->generate();
	}
	
	function tindakan()
	{
		$this->datatables->select('kd_produk,kd_puskesmas,gol_produk,produk,harga')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/tindakan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/tindakan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_produk')
			->from('tindakan');
 
        echo $this->datatables->generate();
	}
	
	function asal_pasien()
	{
		$this->datatables->select('kd_asal,asl_pasien')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/asal_pasien/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/asal_pasien/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_asal')
			->from('asal_pasien');
 
        echo $this->datatables->generate();
	}
	
	function unit_pelayanan()
	{
		$this->datatables->select('unit_pelayanan.kd_unit_pelayanan,unit_pelayanan.nm_unit,unit_pelayanan.kd_puskesmas,puskesmas.nm_puskesmas')
			->unset_column('unit_pelayanan.kd_unit_pelayanan,unit_pelayanan.kd_puskesmas')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/unit_pelayanan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/unit_pelayanan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','unit_pelayanan.kd_unit_pelayanan')
			->from('unit_pelayanan')
			->join('puskesmas','unit_pelayanan.kd_puskesmas = puskesmas.kd_puskesmas');
 
        echo $this->datatables->generate();
	}
	
	function icd_induk()
	{
		$this->datatables->select('kd_icd_induk,nm_icd_induk')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/icd_induk/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/icd_induk/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_icd_induk')
			->from('icd_induk');
 
        echo $this->datatables->generate();
	}
	
	function icd()
	{
		$this->datatables->select('kd_penyakit,kd_icd_induk,penyakit')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/icd/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/icd/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_penyakit')
			->from('icd');
 
        echo $this->datatables->generate();
	}
	
	function dokter()
	{
		$this->datatables->select('dokter.kd_dokter,dokter.nm_dokter,dokter.nip_dokter,dokter.jabatan_dokter,dokter.status_dokter,puskesmas.nm_puskesmas')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/dokter/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/dokter/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','dokter.kd_dokter')
			->from('dokter')
			->join('puskesmas','dokter.kd_puskesmas = puskesmas.kd_puskesmas');
 
        echo $this->datatables->generate();
	}
	
	function petugas()
	{
		$this->datatables->select('petugas.kd_petugas,petugas.nama_petugas,unit_pelayanan.nm_unit,golongan_petugas.nama_gol,posisi.posisi,spesialisasi.spesialisasi,pendidikan_kesehatan.pendidikan')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/petugas/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/petugas/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','petugas.kd_petugas')
			->from('petugas')
			->join('unit_pelayanan','petugas.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan')
			->join('golongan_petugas','petugas.kd_gol = golongan_petugas.kd_gol')
			->join('posisi','petugas.kd_posisi = posisi.kd_posisi')
			->join('spesialisasi','petugas.kd_spesialisasi =  spesialisasi.kd_spesialisasi')
			->join('pendidikan_kesehatan','petugas.kd_pendidikan = pendidikan_kesehatan.kd_pendidikan');
			
        echo $this->datatables->generate();
	}
	
	function kamar()
	{
		$this->datatables->select('kd_unit,no_kamar,nm_kamar,jumlah_bed,digunakan')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/kamar/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/kamar/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_unit')
			->from('kamar');
			
        echo $this->datatables->generate();
	}
	
	function status_keluar_pasien()
	{
		$this->datatables->select('kd_status_pasien,keterangan')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/status_keluar_pasien/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/status_keluar_pasien/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_status_pasien')
			->from('status_keluar_pasien');
			
        echo $this->datatables->generate();
	}
	
	function ruangan()
	{
		$this->datatables->select('ruangan.kd_ruangan,puskesmas.nm_puskesmas,ruangan.nm_ruangan')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/ruangan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'op_pendaftaran/ruangan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','ruangan.kd_ruangan')
			->from('ruangan')
			->join('puskesmas','ruangan.kd_puskesmas = puskesmas.kd_puskesmas');
			
        echo $this->datatables->generate();
	}
	
	function pendaftaran($id)
	{
		$this->datatables->select('kd_rekam_medis,nm_lengkap,nik,tanggal_lahir,tanggal_daftar,kd_puskesmas,DATE_FORMAT(tanggal_lahir, "%d/%m/%Y") as tgl_format', FALSE)
			->unset_column('tanggal_daftar,kd_puskesmas,tgl_format')
			//->edit_column('tanggal_lahir', '$1', 'convert_date_indo(tanggal_lahir)')
			->add_column('Umur', '$1', 'dateDifference(tanggal_lahir,tanggal_daftar)')
			->add_column('Aksi', '
				<a href="'.base_url().'pendaftaran/pendaftaran/ubah/$1" class="btn btn-primary btn-circle" title="Ubah"><i class="iconsweets-create iconsweets-white"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'pendaftaran/pendaftaran/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus"><i class="iconsweets-trashcan iconsweets-white" ></i></a> <a href="'.base_url().'pendaftaran/pendaftaran/view/$1" class="btn btn-info btn-circle" title="Lihat Rekam Medis"><i class="iconsweets-documents iconsweets-white"></i></a> <a href="'.base_url().'pendaftaran/pelayanan/$1" class="btn btn-warning btn-circle" title="Pelayanan"><i class="iconsweets-arrowright iconsweets-white"></i></a>
			','kd_rekam_medis')
			->from('pasien')
			->where('kd_puskesmas', $id);
			
        echo $this->datatables->generate();
	}
	
	function pendaftaran_gigi($id)
	{
		$this->datatables->select('kd_rekam_medis,nm_lengkap,nik,tanggal_lahir,tanggal_daftar,kd_puskesmas,DATE_FORMAT(tanggal_lahir, "%d/%m/%Y") as tgl_format', FALSE)
			->unset_column('tanggal_daftar,kd_puskesmas,tgl_format')
			//->edit_column('tanggal_lahir', '$1', 'convert_date_indo(tanggal_lahir)')
			->add_column('Umur', '$1', 'dateDifference(tanggal_lahir,tanggal_daftar)')
			->add_column('Aksi', '
				<a href="'.base_url().'pendaftaran/pendaftaran/ubah/$1" class="btn btn-primary btn-circle" title="Ubah"><i class="iconsweets-create iconsweets-white"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'pendaftaran/pendaftaran/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus"><i class="iconsweets-trashcan iconsweets-white" ></i></a> <a href="'.base_url().'pendaftaran/pendaftaran/view/$1" class="btn btn-info btn-circle" title="Lihat Rekam Medis"><i class="iconsweets-documents iconsweets-white"></i></a>','kd_rekam_medis')
			->from('pasien')
			->where('kd_puskesmas', $id);
			
        echo $this->datatables->generate();
	}
	
	
	function pelayanan()
	{
		/*
		$this->datatables->select('pelayanan.kd_trans_pelayanan,pelayanan.tgl_pelayanan,pelayanan.kd_rekam_medis,pasien.nm_lengkap,jenis_layanan.jenis_layanan,unit_pelayanan.nm_unit,pelayanan.kd_puskesmas')
			->unset_column('pelayanan.kd_puskesmas')
			//->edit_column('pelayanan.tgl_pelayanan', '$1', 'convert_date_indo(pelayanan.tgl_pelayanan)')
			//->add_column('Tanggal', '$1', 'convert_date_indo(pelayanan.tgl_pelayanan)')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/pelayanan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'op_pendaftaran/pelayanan/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','pelayanan.kd_trans_pelayanan')
			->from('pelayanan')
			->join('pasien', 'pelayanan.kd_rekam_medis = pasien.kd_rekam_medis')
			->join('jenis_layanan', 'pelayanan.kd_jenis_layanan = jenis_layanan.kd_jenis_layanan')
			->join('unit_pelayanan', 'pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan');
		*/	
		
		$this->datatables->select('pelayanan.kd_trans_pelayanan,DATE_FORMAT(pelayanan.tgl_pelayanan, "%d-%m-%Y") as tgl_format,pelayanan.kd_rekam_medis,pasien.nm_lengkap,jenis_layanan.jenis_layanan,unit_pelayanan.nm_unit,pelayanan.kd_puskesmas,pelayanan.tgl_pelayanan', false)
			->unset_column('pelayanan.kd_puskesmas')
			//->edit_column('pelayanan.tgl_pelayanan', '$1', 'convert_date_indo(pelayanan.tgl_pelayanan)')
			//->add_column('Tanggal', '$1', 'convert_date_indo(pelayanan.tgl_pelayanan)')
			->add_column('Aksi', '
				<a href="'.base_url().'op_pendaftaran/pelayanan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'op_pendaftaran/pelayanan/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','pelayanan.kd_trans_pelayanan')
			->from('pelayanan')
			->join('pasien', 'pelayanan.kd_rekam_medis = pasien.kd_rekam_medis')
			->join('jenis_layanan', 'pelayanan.kd_jenis_layanan = jenis_layanan.kd_jenis_layanan')
			->join('unit_pelayanan', 'pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan');
			
        echo $this->datatables->generate();
	}
}
