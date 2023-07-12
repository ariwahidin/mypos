<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Printer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['printer_m']);
    }

    function index()
    {
        $insert = false;
        if (!empty($_POST)) {
            $id = $_POST['id'];
            $printer_name = $_POST['printer_name'];
            $jumlah_print = $_POST['jumlah_print'];
            $this->db->query("update tb_printer set printer_name = '$printer_name', jumlah_print = '$jumlah_print' where id = '$id'");

            // Simpan di file json
            $insert = $this->printer_m->set_printer_json($_POST);
        }

        if ($this->db->affected_rows() > 0 || $insert) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan');
        }

        $printer = $this->printer_m->get_printer();

        $data = array(
            'printer' => $printer,
            'margin_left' => $this->printer_m->get_margin_left(),
        );
        $this->template->load('template', 'printer/data_printer', $data);
    }
}
