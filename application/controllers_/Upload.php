<?php defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['item_m', 'supplier_m', 'stock_m', 'toko_m']);
    }

    function index()
    {
        $status_upload = "belum upload";
        $whs_code = $this->toko_m->get_toko()->row()->whs_code;
        $url = 'stock/getstocktoday?whs_code=' . $whs_code;
        $stock = get_curl($url);
        if($stock['success'] == true){
            $status_upload = "sudah upload";
        }

        $data = array(
            'status_upload' => $status_upload,
        );

        $this->template->load('template', 'upload/upload_data', $data);
    }

    function upload_data()
    {
        $post = $this->input->post();
        $start_date = $post['start_date'];
        $end_date = $post['end_date'];

        $sql_sales_summary = "select
        (select whs_code from t_toko where is_active = 'y') as whs_code,
        t1.invoice, t2.nama_toko , t2.toko_cabang, t1.total_item_value as subtotal,
        t1.discount , t1.service , t1.tax , t1.final_price as grand_total,
        t3.type_bayar , t1.nomor_kartu, t1.nama_pemilik_kartu as nama, cast(t1.created as date) as tanggal
        from t_sale t1
        inner join t_toko t2 on t1.id_toko = t2.id
        inner join type_bayar t3 on t1.type_bayar = t3.id
        where DATE_FORMAT(t1.created, '%Y-%m-%d') BETWEEN DATE_FORMAT('$start_date', '%Y-%m-%d') AND DATE_FORMAT('$end_date', '%Y-%m-%d')";

        $sql_sales_detail = "select
        (select whs_code from t_toko where is_active = 'y') as whs_code,
        t1.invoice as invoice,t4.nama_toko,
        t3.item_code,t3.barcode  ,t3.name as item_name, t2.qty, t2.price as price_item,
        t2.discount_item, t2.total,t2.exp_date, t1.created as tanggal_transaksi
        from t_sale t1
        inner join t_sale_detail t2 on t1.sale_id = t2.sale_id
        inner join p_item t3 on t2.item_id  = t3.item_id
        inner join t_toko t4 on t1.id_toko = t4.id
        where DATE_FORMAT(t1.created, '%Y-%m-%d') BETWEEN DATE_FORMAT('$start_date', '%Y-%m-%d') AND DATE_FORMAT('$end_date', '%Y-%m-%d')";

        $sales_summary = $this->db->query($sql_sales_summary)->result();
        $sales_detail = $this->db->query($sql_sales_detail)->result();

        if (count($sales_summary) < 1 || count($sales_detail) < 1) {
            $this->session->set_flashdata('error', 'Tidak ada data ditanggal tsb');
        } else {
            $post = [
                'post_sales_summary' => $sales_summary,
                'post_sales_detail' => $sales_detail,
            ];

            $url = my_api() . 'item/save_sale_detail';
            $api = post_curl($url, $post);

            // var_dump($api['data']);
            // die;

            if ($api['status_code'] != 200) {
                $this->session->set_flashdata('error', 'error ' . $api['status_code']);
            } elseif ($api['data']->status == 1) {
                $this->session->set_flashdata('success', $api['data']->messages);
            } else {
                $this->session->set_flashdata('error', $api['data']->messages);
            }
        }

        $this->session->set_flashdata('start_date', $start_date);
        $this->session->set_flashdata('end_date', $end_date);
        redirect('upload');
    }

    function uploadStock()
    {
        $response = array();
        $stock = $this->stock_m->getStockDetail();
        $post = [
            'stock' => $stock->result(),
        ];
        $url = my_api() . 'stock/save';
        $api = post_curl($url, $post);
        // var_dump($api);

        if ($api['data']->inserted > 0) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }

        echo json_encode($response);
    }
}
