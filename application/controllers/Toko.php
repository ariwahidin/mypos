<?php defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_not_login();
	}

	public function index()
	{
		$toko = $this->db->query("SELECT * FROM t_toko where is_active = 'y'");
		$all_toko = $this->db->query("SELECT * FROM t_toko");
		$whs_code = $this->db->query("SELECT * from master_gudang");
		$data = array(
			'toko' => $toko,
			'all_toko' => $all_toko,
			'whs_code' => $whs_code,
		);
		$this->template->load('template', 'toko/toko', $data);
	}


	public function edit_toko()
	{
		$post = $_POST;

		// var_dump($post);
		// die;


		$params = array(
			'nama_toko' => $post['nama_toko'],
			'whs_code' => $post['whs_code'],
			'code_store' => $post['kode_store'],
			'toko_cabang' => $post['cabang_toko'],
			'alamat_toko' => $post['alamat'],
		);

		$this->db->where('id', $post['id_toko']);
		$this->db->update('t_toko', $params);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('success', 'Data Toko berhasil disimpan');
		} else {
			$this->session->set_flashdata('error', 'Data Toko tidak ter-update');
		}
		redirect('toko');
	}

	public function add_toko()
	{
		$post = $_POST;

		$store_id = strtoupper($post['store_id']);
		$cek_store_id = $this->db->query("SELECT * FROM t_toko WHERE store_id = '$store_id'");
		if($cek_store_id->num_rows() > 0){
			$this->session->set_flashdata('error', 'Store ID '. $post['store_id']. ' sudah ada!');
			redirect('toko');
			return false;
		}

		$code_store = strtoupper($post['store_code']);
		$cek_code_store = $this->db->query("SELECT * FROM t_toko WHERE code_store = '$code_store'");
		if($cek_code_store->num_rows() > 0){
			$this->session->set_flashdata('error', 'Kode Store '. $post['store_code']. ' sudah ada!');
			redirect('toko');
			return false;
		}


		$params = array(
			'store_id' => strtoupper($post['store_id']),
			'code_store' => strtoupper($post['store_code']),
			'nama_toko' => strtoupper($post['nama_toko']),
			'toko_cabang' => strtoupper($post['cabang_toko']),
			'alamat_toko' => ucwords($post['alamat']),
			'created' => international_date_time(),
			'created_by' => $this->session->userdata('userid'),
		);

		$this->db->insert('t_toko', $params);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('success', 'Toko berhasil ditambahkan');
		} else {
			$this->session->set_flashdata('error', 'Gagal tambah toko');
		}

		redirect('toko');
	}
}
