<?php defined('BASEPATH') or exit('No direct script access allowed');

class Stockout extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['item_m', 'supplier_m', 'stock_m', 'sale_m', 'stockout_m']);
    }

    function get_stock_in_code(){
        $stock_in_code = $this->stockout_m->stock_in_code();
        var_dump($stock_in_code);
    }

    function get_stock_out_code(){
        $stock_out_code = $this->stockout_m->stock_out_code();
        var_dump($stock_out_code);
    }

    function index()
    {
        $delete_cart_stockout = $this->db->query("delete from t_cart_stockout");
        $item = $this->sale_m->get_item_detail();
        $item_cart = $this->stockout_m->get_cart_stockout();

        $data = array(
            'item' => $item,
            'item_cart' => $item_cart
        );

        $this->template->load('template', 'transaction/stock_out/form_stock_out', $data);
    }

    function process()
    {
        $post = $_POST;

        if (isset($post['add_cart'])) {
            $cek = $this->stockout_m->get_cart_stockout($post['item_id_detail']);
            if ($cek->num_rows() > 0) {
                $this->stockout_m->update_cart_stockout($post);
            } else {
                $this->stockout_m->add_cart_stockout($post);
            }

            if ($this->db->affected_rows() > 0) {
                $params = array('success' => true);
            } else {
                $params = array('success' => false);
            }
            echo json_encode($params);
        }

        if (isset($post['edit_info'])) {
            $this->stockout_m->update_info($post);

            if ($this->db->affected_rows() > 0) {
                $params = array('success' => true);
            } else {
                $params = array('success' => false);
            }
            echo json_encode($params);
        }

        if (isset($post['delete_item_cart'])) {

            $this->stockout_m->delete_cart($post);

            if ($this->db->affected_rows() > 0) {
                $params = array('success' => true);
            } else {
                $params = array('success' => false);
            }
            echo json_encode($params);
        }

        if (isset($_POST['proccess_stock_out'])) {

            $item_cart = $this->stockout_m->get_cart_stockout();
            if ($item_cart->num_rows() > 0) {
                $doc_id = $this->stock_m->stock_doc_id();
                foreach ($item_cart->result() as $value) {
                    $params = array(
                        'doc_id' => $doc_id,
                        'item_code' => $value->item_code,
                        'type' => 'out',
                        'detail' => 'stock out',
                        'barcode' => $value->barcode,
                        'item_id' => $value->item_id,
                        'item_id_detail' => $value->item_id_detail,
                        'qty' => $value->qty,
                        'info' => $value->info,
                        'expired_date' => $value->exp_date,
                        'user_id' => $this->session->userdata('userid')
                    );
                    $this->stockout_m->insert_stock_out($params);
                    $this->stockout_m->update_qty_min_p_item_detail($params);
                    // $this->stockout_m->update_qty_min_p_item($params);
                }

                $this->stockout_m->delete_cart_stock_out($params);

                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success_sweet_alert', 'Stock Out Berhasil');
                } else {
                    $this->session->set_flashdata('error_sweet_alert', 'Gagal Stock Out');
                }
            } else {
                $this->session->set_flashdata('error_sweet_alert', 'Tidak Ada Data Stock Out');
            }

            redirect('stockout');
        }
    }

    function cart_stockout_data()
    {
        $item_cart = $this->stockout_m->get_cart_stockout();
        $data = array(
            'item_cart' => $item_cart,
        );
        $this->load->view('transaction/stock_out/cart_stock_out', $data);
    }
}
