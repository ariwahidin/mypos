<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        check_not_login();
	}
	
	public function index()
	{
		$tax = $this->db->query("SELECT * FROM tax");
		$data = array(
			'tax' => $tax,
		);
		$this->template->load('template', 'tax/tax_data', $data);
	}

	public function edit_tax(){
		$post = $_POST;
		$params = array(
            'tax' => (float)$post['tax'] / 100,
			'tax_value' => (float)$post['tax'] + 100,
			'update_by'=> $this->session->userdata('userid'),
			'update_date' => international_date_time()
        );
        $this->db->where('id', $post['id_tax']);
        $this->db->update('tax', $params);

		if($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('success', 'Data Tax berhasil disimpan');
		}else{
			$this->session->set_flashdata('error', 'Data Tax tidak ter-update');
		}
		redirect('tax');
	}

}