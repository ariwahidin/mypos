<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migrasi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['migrasi_m']);
    }

    public function index()
    {
        $data = array();
        $this->template->load('template', 'migrasi/migrasi');
    }

    function updateTable()
    {
        $this->migrasi_m->up_tb_cart();
        $tb_promo = $this->migrasi_m->up_table_promo();
        echo $tb_promo;
        $tb_promo_detail = $this->migrasi_m->up_promo_detail();
        echo $tb_promo_detail;
        $tb_sale = $this->migrasi_m->up_table_sale_detail();
        echo $tb_sale;
        $this->migrasi_m->up_tb_printer();
        $this->migrasi_m->addColumMultipleInPromo();
        echo "<br><a href=" . base_url('migrasi/index') . "> << Back</a>";
    }
}
