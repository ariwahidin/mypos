<?php defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
    }

    public function index()
    {
        $type_bayar = $this->db->query("SELECT * FROM type_bayar");
        $data = array(
            'type_bayar' => $type_bayar,
        );
        $this->template->load('template', 'payment/payment_type', $data);
    }

    public function insert()
    {
        $post = $_POST;
        $params = array(
            'type_bayar' => $post['type_bayar'],
            'create_by' => $this->session->userdata('userid'),
            'create_date' => international_date_time()
        );
        $this->db->insert('type_bayar', $params);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Type Bayar Baru berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal tambah data');
        }
        redirect('payment');
    }
}
