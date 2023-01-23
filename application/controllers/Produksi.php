<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['sale_m','produksi_m']);
	}

    function index()
    {
        $item = $this->sale_m->get_item_detail();
        $item_produksi = $this->produksi_m->get_item_produksi();
        $item_cart = $this->produksi_m->get_cart_produksi();

        $data = array(
            'item' => $item,
            'item_produksi' => $item_produksi,
            'item_cart' => $item_cart
        );

        $this->template->load('template', 'transaction/produksi/produksi_form_v', $data);
    }

    function cart_produksi_data()
    {
        $item_cart = $this->produksi_m->get_cart_produksi();
        $data = array(
            'item_cart' => $item_cart,
        );
        $this->load->view('transaction/produksi/cart_produksi', $data);
    }

    function process()
    {
        $post = $_POST;

        if (isset($post['add_cart'])) {

            // var_dump($post);

            $cek = $this->produksi_m->get_cart_produksi($post['item_id_detail']);
            if ($cek->num_rows() > 0) {
                $this->produksi_m->update_cart_produksi($post);
            } else {
                $this->produksi_m->add_cart_produksi($post);
            }

            if ($this->db->affected_rows() > 0) {
                $params = array('success' => true);
            } else {
                $params = array('success' => false);
            }
            echo json_encode($params);
        }

        if (isset($post['edit'])) {
            // var_dump($post);
            // die;
            $this->produksi_m->update($post);

            if ($this->db->affected_rows() > 0) {
                $params = array('success' => true);
            } else {
                $params = array('success' => false);
            }
            echo json_encode($params);
        }

        if (isset($post['delete_item_cart'])) {

            $this->produksi_m->delete_cart($post);

            if ($this->db->affected_rows() > 0) {
                $params = array('success' => true);
            } else {
                $params = array('success' => false);
            }
            echo json_encode($params);
        }

        // if (isset($_POST['proccess_stock_out'])) {

        //     $item_cart = $this->stockout_m->get_cart_stockout();
        //     if ($item_cart->num_rows() > 0) {

        //         foreach ($item_cart->result() as $value) {
        //             $params = array(
        //                 'item_code' => $value->item_code,
        //                 'type' => 'out',
        //                 'detail' => 'stock out',
        //                 'barcode' => $value->barcode,
        //                 'item_id' => $value->item_id,
        //                 'item_id_detail' => $value->item_id_detail,
        //                 'qty' => $value->qty,
        //                 'info' => $value->info,
        //                 'expired_date' => $value->exp_date,
        //                 'user_id' => $this->session->userdata('userid')
        //             );
        //             $this->stockout_m->insert_stock_out($params);
        //             $this->stockout_m->update_qty_min_p_item_detail($params);
        //             // $this->stockout_m->update_qty_min_p_item($params);
        //         }

        //         $this->stockout_m->delete_cart_stock_out($params);

        //         if ($this->db->affected_rows() > 0) {
        //             $this->session->set_flashdata('success_sweet_alert', 'Stock Out Berhasil');
        //         } else {
        //             $this->session->set_flashdata('error_sweet_alert', 'Gagal Stock Out');
        //         }
        //     } else {
        //         $this->session->set_flashdata('error_sweet_alert', 'Tidak Ada Data Stock Out');
        //     }

        //     redirect('stockout');
        // }
    }

}