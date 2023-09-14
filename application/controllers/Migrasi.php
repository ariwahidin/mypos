<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migrasi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['migrasi_m']);
    }

    function updateTable(){
        $this->migrasi_m->up_tb_cart();
        $tb_promo = $this->migrasi_m->up_table_promo();
        echo $tb_promo.'<br>';
        $tb_promo_detail = $this->migrasi_m->up_promo_detail();
        echo $tb_promo_detail.'<br>';
        $tb_sale = $this->migrasi_m->up_table_sale_detail();
        echo $tb_sale;
    }
}
