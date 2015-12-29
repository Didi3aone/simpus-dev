<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Datatable_master extends CI_Controller
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
	
	/***Default function, redirects to login page if no admin logged in yet***/
	public function index()
	{
		if (!$this->session->userdata('logged_in') == true)
			redirect('login');	
	}
	
	
function pengguna()
    {
 /*       $this->datatables->select('user.id_user,user.nama,user.nip,user.email,akses.akses,puskesmas.nm_puskesmas')
            ->unset_column('user.id_user')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_setting/pengguna/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_setting/pengguna/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','user.id_user')
			->from('user')
			->join('akses', 'user.id_akses = akses.id_akses')
			->join('puskesmas', 'user.kd_puskesmas = puskesmas.kd_puskesmas');
			//->where('user.id_akses','1');
			*/
			
		$sql = $this->datatables->select('user.id_user,user.nama,user.nip,user.username,akses.akses,puskesmas.nm_puskesmas');
        $sql->unset_column('user.id_user');
        $sql->add_column('Aksi', '
				<a href="'.base_url().'cont_master_setting/pengguna/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_setting/pengguna/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','user.id_user');
       $sql->from('user');
                        $sql->join ('akses', 'user.id_akses = akses.id_akses');
                        $sql->join ('puskesmas', 'user.kd_puskesmas = puskesmas.kd_puskesmas');
						  
                        if($this->session->userdata('id_akses') == 1 ){
                       
                        $sql->where ('user.id_akses','1');
                       
                        }
 
        echo $this->datatables->generate();
    }
	
	function group_pengguna()
    {
        $this->datatables->select('id_akses,akses')
            //->unset_column('id_akses')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_setting/group_pengguna/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_setting/group_pengguna/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','id_akses')
			->from('akses');
 
        echo $this->datatables->generate();
    }
	
	function agama()
    {
        $this->datatables->select('kd_agama,nm_agama')
            //->unset_column('kd_agama')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pasien/agama/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_master_pasien/agama/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_agama')
			->from('agama');
 
        echo $this->datatables->generate();
    }
	
	function propinsi()
    { 		
        $this->datatables->select('kd_propinsi,nm_propinsi')
          	->edit_column('nm_propinsi', '<a href="'.base_url().'cont_master_wil_puskesmas/kota/$1'.'">$2</a> ', 'kd_propinsi,nm_propinsi')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_wil_puskesmas/propinsi/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_master_wil_puskesmas/propinsi/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_propinsi')
			->from('propinsi');

        echo $this->datatables->generate();
    }
	
	function kota()
    {
        $this->datatables->select('kd_kota,nm_kota')
            //->unset_column('kd_kota')
			//->unset_column('nm_kota')
			
			->edit_column('nm_kota', '<a href="'.base_url().'cont_master_wil_puskesmas/kecamatan/$1'.'">$2</a> ', 'kd_kota,nm_kota')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_wil_puskesmas/kota/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_master_wil_puskesmas/kota/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_kota')
			->from('kota');
 
        echo $this->datatables->generate();
    }
	
	function puskesmas()
	{
		$this->datatables->select('puskesmas.kd_puskesmas,puskesmas.nm_puskesmas,puskesmas.alamat,kecamatan.nm_kecamatan,puskesmas.puskesmas_induk')
            //->unset_column('puskesmas.kd_puskesmas')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_wil_puskesmas/puskesmas/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_wil_puskesmas/puskesmas/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','puskesmas.kd_puskesmas')
			->from('puskesmas')
			//->join('jenis_puskesmas', 'puskesmas.id_jenis_puskesmas = jenis_puskesmas.id_jenis_puskesmas')
			->join('kecamatan', 'puskesmas.kd_kecamatan = kecamatan.kd_kecamatan');
 
        echo $this->datatables->generate();
	}
	
	function cara_bayar()
	{
		$this->datatables->select('kd_bayar,cara_bayar,kd_customer')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pasien/cara_bayar/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pasien/cara_bayar/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_bayar')
			->from('cara_bayar');
 
        echo $this->datatables->generate();
	}
	
	function jenis_kelamin()
	{
		$this->datatables->select('kd_jenis_kelamin,jenis_kelamin')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pasien/jenis_kelamin/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pasien/jenis_kelamin/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_jenis_kelamin')
			->from('jenis_kelamin');
 
        echo $this->datatables->generate();
	}
	
	function golongan_darah()
	{
		$this->datatables->select('kd_gol_darah,gol_darah')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pasien/golongan_darah/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pasien/golongan_darah/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_gol_darah')
			->from('golongan_darah');
 
        echo $this->datatables->generate();
	}
	
	function pendidikan()
	{
		$this->datatables->select('kd_pendidikan,pendidikan')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pasien/pendidikan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pasien/pendidikan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_pendidikan')
			->from('pendidikan');
 
        echo $this->datatables->generate();
	}
	
	function pekerjaan()
	{
		$this->datatables->select('kd_pekerjaan,pekerjaan')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pasien/pekerjaan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pasien/pekerjaan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_pekerjaan')
			->from('pekerjaan');
 
        echo $this->datatables->generate();
	}
	
	function obat()
	{
		$hy	= $this->datatables->select('obat.kd_obat,obat.nama_obat,satuan_kecil.sat_kecil_obat,terapi_obat.terapi_obat, obat.tgl_kadaluarsa');
			$hy ->from('obat');
			$hy ->join('golongan_obat', 'obat.kd_gol_obat = golongan_obat.kd_gol_obat');
			$hy ->join('satuan_kecil', 'obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat');
			$hy ->join('terapi_obat', 'obat.kd_terapi_obat = terapi_obat.kd_terapi_obat');
			
 			
			if($this->session->userdata('id_akses') == 1 ) {
				$hy ->add_column('Aksi', '
				<a href="'.base_url().'cont_master_farmasi/obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_farmasi/obat/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','obat.kd_obat');
			}
            elseif($this->session->userdata('id_akses')== 7 OR $this->session->userdata('id_akses') == 6 OR $this->session->userdata('id_akses') == 8){
                $hy ->add_column('Aksi', '
				<a href="'.base_url().'cont_master_farmasi/obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a>','obat.kd_obat');
            }
			
        echo $this->datatables->generate();
	}
	
	function obat_gudang_stok()
	{
		$this->datatables->select('obat.kd_obat,obat.nama_obat,golongan_obat.gol_obat,obat.obat_stok,satuan_kecil.sat_kecil_obat,terapi_obat.terapi_obat')
			->from('obat')
			->join('golongan_obat', 'obat.kd_gol_obat = golongan_obat.kd_gol_obat')
			->join('satuan_kecil', 'obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat')
			->join('terapi_obat', 'obat.kd_terapi_obat = terapi_obat.kd_terapi_obat');
 
        echo $this->datatables->generate();
	}
	
	function obat_apotek_stok()
	{
		$this->datatables->select('obat.kd_obat,obat.nama_obat,golongan_obat.gol_obat,obat.apotek_stok,satuan_kecil.sat_kecil_obat,terapi_obat.terapi_obat')
			->from('obat')
			->join('golongan_obat', 'obat.kd_gol_obat = golongan_obat.kd_gol_obat')
			->join('satuan_kecil', 'obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat')
			->join('terapi_obat', 'obat.kd_terapi_obat = terapi_obat.kd_terapi_obat');
 
        echo $this->datatables->generate();
	}
	
	function golongan_obat()
	{
		$hy = $this->datatables->select('kd_gol_obat,gol_obat');
		$hy ->from('golongan_obat');
 		if($this->session->userdata('id_akses') == 1) {
			$hy 	->add_column('Aksi', '
				<a href="'.base_url().'cont_master_farmasi/golongan_obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_farmasi/golongan_obat/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_gol_obat');	
			}
        echo $this->datatables->generate();
	}
	
	function jenis_obat()
	{
		$hy = $this->datatables->select('kd_jenis_obat,jenis_obat');
		$hy ->from('jenis_obat');
 		 if($this->session->userdata('id_akses') == 1) {
			$hy	->add_column('Aksi', '
				<a href="'.base_url().'cont_master_farmasi/jenis_obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_farmasi/jenis_obat/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_jenis_obat');	}
			
        echo $this->datatables->generate();
	}
	
	function milik_obat()
	{
		$this->datatables->select('kd_milik_obat,kepemilikan')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_farmasi/milik_obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_farmasi/milik_obat/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_milik_obat')
			->from('milik_obat');
 
        echo $this->datatables->generate();
	}
	
	function satuan_besar()
	{
		$this->datatables->select('kd_sat_besar_obat,sat_besar_obat')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_farmasi/satuan_besar/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_farmasi/satuan_besar/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_sat_besar_obat')
			->from('satuan_besar');
 
        echo $this->datatables->generate();
	}
	
	function satuan_kecil()
	{
		$hy = $this->datatables->select('kd_sat_kecil_obat,sat_kecil_obat');
		$hy	->from('satuan_kecil');
 	 		 if($this->session->userdata('id_akses') == 1) {
				$hy ->add_column('Aksi', '
				<a href="'.base_url().'cont_master_farmasi/satuan_kecil/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_farmasi/satuan_kecil/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_sat_kecil_obat'); }
        echo $this->datatables->generate();
	}
	
	function terapi_obat()
	{
		$this->datatables->select('kd_terapi_obat,terapi_obat')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_farmasi/terapi_obat/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_farmasi/terapi_obat/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_terapi_obat')
			->from('terapi_obat');
 
        echo $this->datatables->generate();
	}
	
	function unit_farmasi()
	{
		$this->datatables->select('kd_unit_farmasi,nama_unit_farmasi,farmasi_utama')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_farmasi/unit_farmasi/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_farmasi/unit_farmasi/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_unit_farmasi')
			->from('unit_farmasi');
 
        echo $this->datatables->generate();
	}
	

function takaran_dosis()
	{
		$hy	= $this->datatables->select('kd_dosis, takaran_dosis');
			$hy->unset_column('kd_dosis');
			$hy ->from('dosis');
		 if ($this->session->userdata('id_akses') != 1){	
			$hy ->add_column('Aksi', '
				<a href="'.base_url().'cont_master_farmasi/dosis/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> 
				<a href="'.base_url().'cont_master_farmasi/dosis/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_dosis');
		}
        echo $this->datatables->generate();
	}

	function golongan_petugas()
	{
		$this->datatables->select('kd_gol,nama_gol')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_petugas/golongan_petugas/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_petugas/golongan_petugas/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_gol')
			->from('golongan_petugas');
 
        echo $this->datatables->generate();
	}
	
	function posisi()
	{
		$this->datatables->select('kd_posisi,posisi')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_petugas/posisi/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_petugas/posisi/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_posisi')
			->from('posisi');
 
        echo $this->datatables->generate();

	}
	
	function spesialisasi()
	{
		$this->datatables->select('kd_spesialisasi,spesialisasi')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_petugas/spesialisasi/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_petugas/spesialisasi/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_spesialisasi')
			->from('spesialisasi');
 
        echo $this->datatables->generate();
	}
	
	function pendidikan_kesehatan()
	{
		$this->datatables->select('kd_pendidikan,pendidikan')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_petugas/pendidikan_kesehatan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_petugas/pendidikan_kesehatan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_pendidikan')
			->from('pendidikan_kesehatan');
 
        echo $this->datatables->generate();
	}
	
	function tindakan()
	{
		$hy = $this->datatables->select('kd_produk,produk,harga,keterangan_tindakan');
		$hy	->from('tindakan');
		$hy ->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pelayanan/tindakan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pelayanan/tindakan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_produk');
	
        echo $this->datatables->generate();
	}
	
	function asal_pasien()
	{
		$this->datatables->select('kd_asal,asl_pasien')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pelayanan/asal_pasien/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pelayanan/asal_pasien/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_asal')
			->from('asal_pasien');
 
        echo $this->datatables->generate();
	}
	
	function unit_pelayanan()
	{
		$this->datatables->select('unit_pelayanan.kd_unit_pelayanan,unit_pelayanan.nm_unit,unit_pelayanan.kd_puskesmas')
			->unset_column('unit_pelayanan.kd_unit_pelayanan,unit_pelayanan.kd_puskesmas,puskesmas.nm_puskesmas ')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pelayanan/unit_pelayanan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pelayanan/unit_pelayanan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','unit_pelayanan.kd_unit_pelayanan')
			->from('unit_pelayanan')
			->join('puskesmas','unit_pelayanan.kd_puskesmas = puskesmas.kd_puskesmas');
 
        echo $this->datatables->generate();
	}
	
	function icd_induk()
	{
		$this->datatables->select('kd_icd_induk,nm_icd_induk')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pelayanan/icd_induk/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pelayanan/icd_induk/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_icd_induk')
			->from('icd_induk');
 
        echo $this->datatables->generate();
	}
	
	function icd()
	{
		$this->datatables->select('kd_penyakit,kd_icd_induk,penyakit')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pelayanan/icd/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pelayanan/icd/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_penyakit')
			->from('icd');
 
        echo $this->datatables->generate();
	}
	
	function dokter()
	{
		$sql = $this->datatables->select('dokter.kd_dokter,dokter.nm_dokter,unit_pelayanan.nm_unit, puskesmas.nm_puskesmas');		
		$sql ->from('dokter');
		$sql ->join('puskesmas','dokter.kd_puskesmas = puskesmas.kd_puskesmas');
 		$sql ->join('unit_pelayanan','dokter.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan');
		 		//if($this->session->userdata('id_akses') != 1 ){ //selain admin dinkes
                     $sql->unset_column('puskesmas.nm_puskesmas'); 
                     $sql->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pelayanan/dokter/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pelayanan/dokter/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','dokter.kd_dokter');   
			// } 
        echo $this->datatables->generate();
	}
	
	function petugas()
	{
		$sql = $this->datatables->select('puskesmas.nm_puskesmas,petugas.kd_petugas,petugas.nama_petugas,unit_pelayanan.nm_unit,posisi.posisi');
			//$sql->unset_column('golongan_petugas.nama_gol, pendidikan_kesehatan.pendidikan');
			$sql->from('petugas');
			$sql->join('unit_pelayanan','petugas.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan');
			//$sql->join('golongan_petugas','petugas.kd_gol = golongan_petugas.kd_gol');
			$sql->join('posisi','petugas.kd_posisi = posisi.kd_posisi');
			//$sql->join('spesialisasi','petugas.kd_spesialisasi =  spesialisasi.kd_spesialisasi');
			//$sql->join('pendidikan_kesehatan','petugas.kd_pendidikan = pendidikan_kesehatan.kd_pendidikan');
			$sql->join('puskesmas','petugas.kd_puskesmas = puskesmas.kd_puskesmas');
			
		 //if($this->session->userdata('id_akses') != 1 ){
                     $sql->unset_column('puskesmas.nm_puskesmas'); 
                     $sql->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pelayanan/petugas/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pelayanan/petugas/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','petugas.kd_petugas');   
                       
                 /*       } else {
							$sql->add_column('Nama Puskesmas','kd_puskesmas');
						}	*/
				
        echo $this->datatables->generate();
	}
	
	function kamar()
	{
		$this->datatables->select('kamar.kd_kamar,ruangan.nm_ruangan,kamar.kd_bed')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pelayanan/kamar/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pelayanan/kamar/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kamar.kd_kamar')
			->from('kamar')
			->join('ruangan','kamar.kd_ruangan = ruangan.kd_ruangan');
			
        echo $this->datatables->generate();
	}
	
	function status_keluar_pasien()
	{
		$this->datatables->select('kd_status_pasien,keterangan')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pelayanan/status_keluar_pasien/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pelayanan/status_keluar_pasien/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','kd_status_pasien')
			->from('status_keluar_pasien');
			
        echo $this->datatables->generate();
	}
	
	function ruangan()
	{
		$this->datatables->select('ruangan.kd_ruangan,ruangan.nm_ruangan, jml_kmr')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_master_pelayanan/ruangan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> <a href="'.base_url().'cont_master_pelayanan/ruangan/hapus/$1" class="btn btn-danger btn-circle" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
			','ruangan.kd_ruangan')
			->from('ruangan');
			//->join('puskesmas','ruangan.kd_puskesmas = puskesmas.kd_puskesmas');
			
        echo $this->datatables->generate();
	}
	
	function pendaftaran()
	{
			//$hy = $this->datatables->select('pasien.kd_rekam_medis,pasien.idkartu_medical, pasien.nm_lengkap,pasien.alamat,Round(DATEDIFF( CURDATE( ) , pasien.tanggal_lahir )/365) as umur,cara_bayar.cara_bayar,pasien.kd_puskesmas', FALSE); bogor timur
			//$hy = $this->datatables->select('kd_rekam_medis,no_reg,nm_lengkap,alamat,Round(DATEDIFF( CURDATE( ) , tanggal_lahir )/365) as umur, kd_bayar,kd_puskesmas', FALSE);
			$hy = $this->datatables->select('pasien.kd_rekam_medis, pasien.nm_lengkap,pasien.alamat,kelurahan.nm_kelurahan, Round(DATEDIFF( CURDATE( ) , pasien.tanggal_lahir )/365) as umur,cara_bayar.cara_bayar,pasien.kd_puskesmas', FALSE); //tanah sareal
			$hy ->unset_column('pasien.kd_puskesmas');
			$hy ->from('pasien');
			$hy -> join('cara_bayar','cara_bayar.kd_bayar=pasien.kd_bayar','left');
			$hy -> join('kelurahan','pasien.kd_kelurahan=kelurahan.kd_kelurahan','left');

			if($this->session->userdata('id_akses') == 2 ){ //pendaftaran
				$hy ->add_column('Aksi', '
				<a href="'.base_url().'cont_transaksi_pendaftaran/pendaftaran/ubah/$1" class="btn btn-primary btn-circle" title="Ubah"><i class="iconsweets-create iconsweets-white"></i></a> 
				<a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_transaksi_pendaftaran/pendaftaran/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus"><i class="iconsweets-trashcan iconsweets-white" ></i></a>  
				<a href="'.base_url().'cont_transaksi_pelayanan/pelayanan_today/$1" class="btn btn-warning btn-circle" title="Pilih Poli"><i class="iconsweets-arrowright iconsweets-white"></i></a>
			','pasien.kd_rekam_medis');     
                       
                        } else {
				$hy ->add_column('Aksi', '
				<a href="'.base_url().'cont_transaksi_pendaftaran/pendaftaran/ubah/$1" class="btn btn-primary btn-circle" title="Ubah"><i class="iconsweets-create iconsweets-white"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_transaksi_pendaftaran/pendaftaran/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus"><i class="iconsweets-trashcan iconsweets-white" ></i></a> <a href="'.base_url().'cont_transaksi_pendaftaran/pendaftaran/view/$1" class="btn btn-info btn-circle" title="Lihat Rekam Medis"><i class="iconsweets-documents iconsweets-white"></i></a> <a href="'.base_url().'cont_transaksi_pelayanan/pelayanan_today/$1" class="btn btn-warning btn-circle" title="Pilih Poli"><i class="iconsweets-arrowright iconsweets-white"></i></a>
			','pasien.kd_rekam_medis');
						}
                    
			
        echo $this->datatables->generate();
	}


	
	function pelayanan()
	{
		/*
		$this->datatables->select('pelayanan.kd_trans_pelayanan,DATE_FORMAT(pelayanan.tgl_pelayanan, "%d-%m-%Y") as tgl_format,pelayanan.kd_rekam_medis,pasien.nm_lengkap,jenis_layanan.jenis_layanan,unit_pelayanan.nm_unit,pelayanan.kd_puskesmas,pelayanan.tgl_pelayanan', false)
			->unset_column('pelayanan.kd_puskesmas')
			//->edit_column('pelayanan.tgl_pelayanan', '$1', 'convert_date_indo(pelayanan.tgl_pelayanan)')
			//->add_column('Tanggal', '$1', 'convert_date_indo(pelayanan.tgl_pelayanan)')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_transaksi_pelayanan/pelayanan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white" title="Ubah"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_transaksi_pelayanan/pelayanan/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus"><i class="iconsweets-trashcan iconsweets-white" ></i></a><a href="'.base_url().'cont_transaksi_pelayanan/cetak_resep/$1" class="btn btn-inverse btn-circle" target="blank" title="Cetak Resep"><i class="iconsweets-printer iconsweets-white"></i></a>
			','pelayanan.kd_trans_pelayanan')
			->from('pelayanan')
			->join('pasien', 'pelayanan.kd_rekam_medis = pasien.kd_rekam_medis')
			->join('jenis_layanan', 'pelayanan.kd_jenis_layanan = jenis_layanan.kd_jenis_layanan')
			->join('unit_pelayanan', 'pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan')
			->where('unit_pelayanan.kd_unit_pelayanan',$this->session->userdata('kd_unit_pelayanan'));
			
		//$this->db->order_by('pelayanan.kd_trans_pelayanan','asc');
		*/
				
		$sql = $this->datatables->select('pelayanan.kd_trans_pelayanan, DATE_FORMAT(pelayanan.tgl_pelayanan, "%d-%m-%Y") as tgl_format, pelayanan.kd_rekam_medis, pasien.nm_lengkap, jenis_layanan.jenis_layanan, unit_pelayanan.nm_unit, pelayanan.kd_puskesmas, pelayanan.tgl_pelayanan', false);
                        $sql->unset_column('pelayanan.kd_puskesmas,pelayanan.tgl_pelayanan');
                        $sql->add_column('Aksi', '
                                <a href="'.base_url().'cont_transaksi_pelayanan/pelayanan/ubah/$1" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white" title="Ubah"></i></a> <a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_transaksi_pelayanan/pelayanan/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus"><i class="iconsweets-trashcan iconsweets-white" ></i></a><a href="'.base_url().'cont_transaksi_pelayanan/pelayanan_today/view/$2" class="btn btn-inverse btn-circle" target="blank" title="Lihat Rekam Medis"><i class="iconsweets-printer iconsweets-white"></i></a>
                        
                        ','pelayanan.kd_trans_pelayanan, pelayanan.kd_rekam_medis');
                        $sql->from('pelayanan');
                        $sql->join('pasien', 'pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
                        $sql->join('jenis_layanan', 'pelayanan.kd_jenis_layanan = jenis_layanan.kd_jenis_layanan');
                        $sql->join('unit_pelayanan', 'pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan');
						//$sql->where('pelayanan.tgl_pelayanan',date ('Y-m-d'));
                       
               
                        if($this->session->userdata('id_akses') == 5 || $this->session->userdata('id_akses') == 10 || $this->session->userdata('id_akses') == 11 || $this->session->userdata('id_akses') == 12){
                       
                        $sql->where('unit_pelayanan.kd_unit_pelayanan',$this->session->userdata('kd_unit_pelayanan'));
                       
                        }
                    
              echo $this->datatables->generate();
	}
	

	function pelayanan_today()
	{            
/*	$sql = $this->datatables->select('pelayanan.kd_petugas, pelayanan.no_antrian, pelayanan.kd_trans_pelayanan,  
DATE_FORMAT(pelayanan.tgl_pelayanan, "%d-%m-%Y") as tgl_format, pelayanan.kd_rekam_medis, pasien.nm_lengkap, pasien.idkartu_medical, pasien.alamat, pelayanan.umur, unit_pelayanan.singkatan, cara_bayar.cara_bayar, pasien.no_asuransi, status_keluar_pasien.style, status_keluar_pasien.keterangan, pelayanan.kd_puskesmas, pelayanan.tgl_pelayanan', false); */

$sql = $this->datatables->select('pelayanan.kd_petugas, pelayanan.kd_trans_pelayanan,  pelayanan.no_antrian,
DATE_FORMAT(pelayanan.tgl_pelayanan, "%d-%m-%Y") as tgl_format, pelayanan.kd_rekam_medis, pasien.nm_lengkap, pasien.alamat, kelurahan.nm_kelurahan, pelayanan.umur, unit_pelayanan.singkatan, cara_bayar.cara_bayar, pasien.no_asuransi, status_keluar_pasien.style, status_keluar_pasien.keterangan, pelayanan.kd_puskesmas, pelayanan.tgl_pelayanan', false);
            $sql->unset_column('pelayanan.kd_puskesmas,pelayanan.tgl_pelayanan');
            $sql->unset_column('pelayanan.kd_petugas');
            $sql->unset_column('status_keluar_pasien.keterangan');
			$sql->unset_column('tgl_format');
			$sql->unset_column('unit_pelayanan.singkatan');
			$sql->from('pelayanan');
			$sql->join('pasien', 'pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
			$sql->join('cara_bayar', 'pelayanan.kd_bayar = cara_bayar.kd_bayar');            
            $sql->join('unit_pelayanan', 'pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan');
            $sql->join('status_keluar_pasien', 'pelayanan.kd_status_pasien=status_keluar_pasien.kd_status_pasien');
			$sql->join('kelurahan', 'pasien.kd_kelurahan=kelurahan.kd_kelurahan','left');

			$sql->where('pelayanan.tgl_pelayanan',date ('Y-m-d'));
//			$sql->order_by('pelayanan.kd_trans_pelayanan','desc');

			if ($this->session->userdata('id_akses') == 2) // pendaftaran, tanpa status keluar pasien
				{	
							//$sql->unset_column('status_keluar_pasien.style');
							//$sql->unset_column('pasien.alamat');
							//$sql->unset_column('pelayanan.umur');
							$sql->edit_column('status_keluar_pasien.style', '<button class="btn $1 btn-circle" title="$2"><i class="iconsweets-wifi2 iconsweets-white"></i></button>', 'status_keluar_pasien.style, status_keluar_pasien.keterangan');
							$sql->add_column('Aksi', '
                                
					<div class="btn-group">
                                            <button class="btn">P i l i h</button>
                                            <button data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></button>
                        <ul class="dropdown-menu">
											  <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_antrian/$1" target="_blank">Cetak No Antrian</a></li>
											  <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_kertas_resep/$1" target="_blank">Kertas Resep</a></li>
											  <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_rujukan/$1" target="_blank">Cetak Rujukan</a></li>
											  <li class="divider"></li>
                                              <li><a href="'.base_url().'cont_transaksi_pelayanan/pelayanan_today/ubah/$1">Ubah</a></li>
                                              <li><a href="#" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_transaksi_pelayanan/pelayanan_today/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus">Hapus</a></li>
					    </ul>
                                          </div>
			','pelayanan.kd_trans_pelayanan');
				
			//	<li><a href="'.base_url().'c_bayar_tindakan/bayar_tindakan/tambah/bayar/$1">Bayar</a></li>
               // <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_resep/$1" target="blank" title="Cetak Resep">Cetak Resep</a></li>
				
				} // filter untuk pasien per poli dan ugd dan PTRM
				elseif($this->session->userdata('id_akses') == 10 || $this->session->userdata('id_akses') == 11 || $this->session->userdata('id_akses') == 12 || $this->session->userdata('id_akses') == 13 || $this->session->userdata('id_akses') == 14 || $this->session->userdata('id_akses') == 15 || $this->session->userdata('id_akses') == 16 || $this->session->userdata('id_akses') == 17)
				{ 	// tambahkan alamat dan umur, unset unit layanan dan cara bayar
					$sql->where('unit_pelayanan.kd_unit_pelayanan',$this->session->userdata('kd_unit_pelayanan'));
					$sql->unset_column('unit_pelayanan.singkatan');
					$sql->unset_column('cara_bayar.cara_bayar');
					$sql->unset_column('pasien.no_asuransi');
					$sql->unset_column('pasien.idkartu_medical');
					$sql->unset_column('kelurahan.nm_kelurahan');
					$sql->edit_column('status_keluar_pasien.style', '<button class="btn $1 btn-circle" title="$2"><i class="iconsweets-wifi2 iconsweets-white"></i></button>', 'status_keluar_pasien.style, status_keluar_pasien.keterangan');
							$sql->add_column('Aksi', '
							<div class="btn-group">
                                            <button class="btn">P i l i h</button>
                                            <button data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                              <li><a href="'.base_url().'cont_transaksi_pelayanan/pelayanan_today/ubah/$1" >Ubah</a></li>
                                              <li><a href="#" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_transaksi_pelayanan/pelayanan_today/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus">Hapus</a></li>
                                              <li class="divider"></li>
                                            <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_antrian/$1" target="_blank">Cetak No Antrian</a></li>
                                        	<li><a href="'.base_url().'cont_transaksi_pelayanan/pelayanan_today/view/$2" target="_blank">Lihat Rekam Medis</a></li> 
											<li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_resep/$1" target="blank" title="Cetak Resep">Cetak Resep</a></li>
											 <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_rujukan/$1" target="_blank">Cetak Rujukan</a></li>
                                            </ul>
                                          </div>			 
                        ','pelayanan.kd_trans_pelayanan, pelayanan.kd_rekam_medis');
				}  
				//filter aksi untuk admin, operator, nambah bayar
				else if($this->session->userdata('id_akses') == 1  || $this->session->userdata('id_akses') == 7 )
						{ 	$sql->unset_column('pelayanan.kd_petugas'); 
							$sql->edit_column('status_keluar_pasien.style', '<button class="btn $1 btn-circle" title="$2"><i class="iconsweets-wifi2 iconsweets-white"></i></button>', 'status_keluar_pasien.style, status_keluar_pasien.keterangan');
							$sql->unset_column('pasien.no_asuransi');
							$sql->unset_column('pasien.idkartu_medical');
							$sql->unset_column('kelurahan.nm_kelurahan');
							$sql->add_column('Aksi', '
                                
					<div class="btn-group">
                                            <button class="btn">P i l i h</button>
                                            <button data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                              <li><a href="'.base_url().'cont_transaksi_pelayanan/pelayanan_today/ubah/$1">Ubah</a></li>
                                              <li><a href="#" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_transaksi_pelayanan/pelayanan_today/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus">Hapus</a></li>
                                              <li><a href="'.base_url().'c_bayar_tindakan/bayar_tindakan/tambah/bayar/$1">Bayar</a></li>
                                              <li class="divider"></li>
                                              <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_antrian/$1" target="_blank">Cetak No Antrian</a></li>
                                              <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_resep/$1" target="blank" title="Cetak Resep">Cetak Resep</a></li>
											   <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_rujukan/$1" target="_blank">Cetak Rujukan</a></li>
					      	                                            
					    </ul>
                                          </div>
			','pelayanan.kd_trans_pelayanan');
                        } else if ($this->session->userdata('id_akses') == 9 ) // aksi kasir
						{
						$sql->unset_column('pasien.no_asuransi');
						$sql->unset_column('pasien.idkartu_medical');
						$sql->edit_column('status_keluar_pasien.style', '<button class="btn $1 btn-circle" title="$2"><i class="iconsweets-wifi2 iconsweets-white"></i></button>', 'status_keluar_pasien.style, status_keluar_pasien.keterangan');

						$sql->add_column('Aksi', '
                               			<a title="Bayar Tindakan" href="'.base_url().'c_bayar_tindakan/bayar_tindakan/tambah/bayar/$1" class="btn btn-success btn-circle"><i class="iconsweets-money2 iconsweets-white"></i></a>
						<a title="Cetak Resep" href="'.base_url().'cont_transaksi_pelayanan/cetak_resep/$1" target="_balnk" class="btn btn-info btn-circle"><i class="iconsweets-printer iconsweets-white"></i></a> 
			','pelayanan.kd_trans_pelayanan');
						} 
						else {	// aksi untuk user selain diatas
							$sql->edit_column('status_keluar_pasien.style', '<button class="btn $1 btn-circle" title="$2"><i class="iconsweets-wifi2 iconsweets-white"></i></button>', 'status_keluar_pasien.style, status_keluar_pasien.keterangan');
							$sql->unset_column('pasien.no_asuransi');
							$sql->unset_column('pasien.idkartu_medical');
							$sql->add_column('Aksi', '
					<div class="btn-group">
                                            <button class="btn">P i l i h</button>
                                            <button data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                              <li><a href="'.base_url().'cont_transaksi_pelayanan/pelayanan_today/ubah/$1" >Ubah</a></li>
                                              <li><a href="#" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_transaksi_pelayanan/pelayanan_today/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus">Hapus</a></li>
                                              <li class="divider"></li>
                                              <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_antrian/$1" target="_blank">Cetak No Antrian</a></li>
                                              <li><a href="'.base_url().'cont_transaksi_pelayanan/cetak_resep/$1" target="blank" title="Cetak Resep">Cetak Resep</a></li>
                                            </ul>
                                          </div>			 
                        ','pelayanan.kd_trans_pelayanan');
						}
              echo $this->datatables->generate();
	}	

	function pelayanan_today_lab()
	{            
						$sql = $this->datatables->select('pelayanan_tindakan.kd_trans_pelayanan,pelayanan.kd_rekam_medis,pasien.nm_lengkap,pasien.alamat,pelayanan.umur,tindakan.produk,pelayanan_tindakan.qty,pelayanan_tindakan.sta_bayar,tindakan.kriteria,pelayanan.tgl_pelayanan', false);
                        $sql->unset_column('tindakan.kriteria,pelayanan.tgl_pelayanan');
                        $sql->unset_column('pelayanan_tindakan.sta_bayar');
						$sql->from('tindakan');
                        $sql->join('pelayanan_tindakan','tindakan.kd_produk = pelayanan_tindakan.kd_produk');
		$sql->join('pelayanan','pelayanan_tindakan.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan');
		$sql->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
		$sql->where('pelayanan.tgl_pelayanan',date ('Y-m-d'));
     /*  	$sql->where('tindakan.kriteria','laboratorium');        	
						$sql->add_column('Aksi', '
					<div class="btn-group">
                                            <button class="btn">P i l i h</button>
                                            <button data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                              <li><a href="'.base_url().'cont_transaksi_pelayanan/pelayanan_today/sta_aksi/$1" >Update</a></li>
                                              
                                            </ul>
                                          </div>			 
                        ','pelayanan.kd_trans_pelayanan');	*/
						
              echo $this->datatables->generate();
	}
	
	
	
	function view_rekmed()
	{
	/*	$this->datatables->select('pelayanan.kd_trans_pelayanan,pelayanan.kd_rekam_medis,pasien.nm_lengkap,pelayanan.tgl_pelayanan', FALSE)
			->unset_column('pelayanan.tgl_pelayanan')
			//->add_column('$1')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_view_rekmed/view_rekmed/view/$1" class="btn btn-info btn-circle" title="Lihat Rekam Medis"><i class="iconsweets-documents iconsweets-white"></i></a> <a href="'.base_url().'cont_transaksi_pelayanan/pelayanan/$1" class="btn btn-warning btn-circle" title="Pelayanan"><i class="iconsweets-arrowright iconsweets-white"></i></a>
			','kd_rekam_medis')
			->from('pelayanan')
			->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
			//->where('pelayanan.tgl_pelayanan',date ('Y-m-d'));
			
        echo $this->datatables->generate();
		*/
		
		$this->datatables->select('kd_rekam_medis,nm_lengkap,nik,tanggal_lahir,tanggal_daftar,kd_puskesmas,DATE_FORMAT(tanggal_lahir, "%d/%m/%Y") as tgl_format', FALSE)
			->unset_column('tanggal_daftar,kd_puskesmas,tgl_format')
			//->edit_column('tanggal_lahir', '$1', 'convert_date_indo(tanggal_lahir)')
			->add_column('Umur', '$1', 'dateDifference(tanggal_lahir,tanggal_daftar)')
			->add_column('Aksi', '
				<a href="'.base_url().'cont_transaksi_pendaftaran/pendaftaran/ubah/$1" class="btn btn-primary btn-circle" title="Ubah"><i class="iconsweets-create iconsweets-white"></i></a>
				<a href="#" class="btn btn-danger btn-circle" onClick="event.preventDefault(); return jConfirm(\'Anda yakin ingin menghapus data ini?\',\'Konfirmasi Hapus Data\', function(r){if(r==true){var href = \''.base_url().'cont_transaksi_pendaftaran/pendaftaran/hapus/$1\';window.location.href=href;}else{event.preventDefault();}});" title="Hapus"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
				<a href="'.base_url().'cont_transaksi_pendaftaran/pendaftaran/view/$1" class="btn btn-info btn-circle" title="Lihat Rekam Medis"><i class="iconsweets-documents iconsweets-white"></i></a> <a href="'.base_url().'cont_transaksi_pelayanan/pelayanan/$1" class="btn btn-warning btn-circle" title="Pelayanan"><i class="iconsweets-arrowright iconsweets-white"></i></a>
			','kd_rekam_medis')
			->from('pasien');
        echo $this->datatables->generate();
	}
	
	//DATE_FORMAT(tanggal_lahir, "%d/%m/%Y") as tanggal_lahir
	function cari_pasien(){
		$this->datatables->select('kd_rekam_medis,nm_lengkap,tanggal_lahir,alamat', false)
			->add_column('Pilih', '<div class="btn-group"><a class="btn btn-small btn-info" href="javascript:pilih(\'$1\');"><i class="icon-check icon-white"></i></a></div>','kd_rekam_medis')
			->from('pasien');
        echo $this->datatables->generate();
		
	}
	
}
