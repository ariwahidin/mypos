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

            // var_dump($_POST);
            // die;

            $id = $_POST['id'];
            $printer_name = $_POST['printer_name'];
            $jumlah_print = $_POST['jumlah_print'];
            $margin_left = $_POST['margin_left'];
            $print_logo = $_POST['print_logo'];
            $alt_text = $_POST['alt_text'];
            $params = array(
                'printer_name' => $printer_name,
                'jumlah_print' => $jumlah_print,
                'margin_left' => $margin_left,
                'margin_left' => $margin_left,
                'print_logo' => $print_logo,
                'alt_text' => $alt_text,
                'updated_by' => $this->session->userdata('username'),
                'updated_at' => international_date_time()
            );
            $this->db->where('id', $_POST['id']);
            $this->db->update('tb_printer', $params);

            // Simpan di file json
            $insert = $this->printer_m->set_printer_json($_POST);
        }

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan');
        }

        $printer = $this->printer_m->get_printer();

        $data = array(
            'printer' => $printer,
            // 'margin_left' => $this->printer_m->get_margin_left(),
            // 'settings_printer' => $this->printer_m->getPrinterSettings(),
        );
        $this->template->load('template', 'printer/data_printer', $data);
    }
}
