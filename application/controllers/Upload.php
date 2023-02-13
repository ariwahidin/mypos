<?php defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['item_m', 'supplier_m', 'stock_m']);
    }

    function index()
    {
        $this->template->load('template', 'upload/upload_data');
    }

    function upload_data()
    {

        $sql_sales_summary = "select 
        (select whs_code from t_toko where is_active = 'y') as whs_code,
        t1.invoice, t2.nama_toko , t2.toko_cabang, t1.total_item_value as subtotal, 
        t1.discount , t1.service , t1.tax , t1.final_price as grand_total,
        t3.type_bayar , t1.nomor_kartu, t1.nama_pemilik_kartu as nama, cast(t1.created as date) as tanggal
        from t_sale t1 
        inner join t_toko t2 on t1.id_toko = t2.id
        inner join type_bayar t3 on t1.type_bayar = t3.id";

        $sql_sales_detail = "select 
        (select whs_code from t_toko where is_active = 'y') as whs_code,
        t1.invoice as invoice,t4.nama_toko, 
        t3.item_code,t3.barcode  ,t3.name as item_name, t2.qty, t2.price as price_item, 
        t2.discount_item, t2.total,t2.exp_date, t1.created as tanggal_transaksi
        from t_sale t1
        inner join t_sale_detail t2 on t1.sale_id = t2.sale_id
        inner join p_item t3 on t2.item_id  = t3.item_id 
        inner join t_toko t4 on t1.id_toko = t4.id";

        $sales_summary = $this->db->query($sql_sales_summary)->result();
        $sales_detail = $this->db->query($sql_sales_detail)->result();


        $post = array(
            'post_sales_summary' => $sales_summary,
            'post_sales_detail' => $sales_detail,
        );

        $url = my_api() . 'item/save_sale_detail';
        $api = post_curl($url, $post);

        if ($api['status_code'] != 200) {
            $this->session->set_flashdata('error', 'error ' . $api['status_code']);
        } else if ($api['data']->status == 1) {
            $this->session->set_flashdata('success', $api['data']->messages);
        } else {
            $this->session->set_flashdata('error', $api['data']->messages);
        }

        redirect('upload');
    }
}
