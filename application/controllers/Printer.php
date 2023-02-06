<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Printer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
    }

    function index()
    {

        if(!empty($_POST)){
            // var_dump($_POST);
            $id = $_POST['id'];
            $printer_name = $_POST['printer_name'];
            $jumlah_print = $_POST['jumlah_print'];
            $this->db->query("update tb_printer set printer_name = '$printer_name', jumlah_print = '$jumlah_print' where id = '$id'");
        }

        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('success','Data berhasil disimpan');
        }

        $printer = $this->db->query("select * from tb_printer");
        $data = array(
            'printer' => $printer
        );
        $this->template->load('template', 'printer/data_printer', $data);
    }
}
