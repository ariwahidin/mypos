<?php defined('BASEPATH') or exit('No direct script access allowed');

class Produksi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['sale_m', 'produksi_m', 'stockout_m', 'stock_m']);
    }

    function index()
    {
        $item = $this->produksi_m->get_item_detail();
        $item_produksi = $this->produksi_m->get_item_produksi();
        $item_cart = $this->produksi_m->get_cart_produksi();

        $data = array(
            'item' => $item,
            'item_produksi' => $item_produksi,
            'item_cart' => $item_cart
        );

        $this->template->load('template', 'transaction/produksi/produksi_form_v', $data);
    }

    function ready()
    {
        $user_id = $this->session->userdata('userid');
        $delete_cart = $this->db->query("delete from t_cart_produksi where created_by = '$user_id'");
        $item = $this->produksi_m->get_item_produksi_exists();
        $item_cart = $this->produksi_m->get_cart_produksi_ready();
        $data = array(
            'item_produksi' => $item,
            'item_cart' => $item_cart
        );
        $this->template->load('template', 'transaction/produksi/produksi_form_ready_v', $data);
    }

    function cart_produksi_data_ready()
    {
        $item_cart = $this->produksi_m->get_cart_produksi_ready();
        $data = array(
            'item_cart' => $item_cart,
        );
        $this->load->view('transaction/produksi/cart_produksi_ready', $data);
    }

    function show_modal_item()
    {
        $post = $_POST;
        $item = $this->produksi_m->get_item_detail_ready($post);
        $data = array(
            'item' => $item,
        );
        $this->load->view('transaction/produksi/modal_add_item_ready', $data);
    }

    function cart_produksi_data()
    {
        $item_cart = $this->produksi_m->get_cart_produksi();
        $data = array(
            'item_cart' => $item_cart,
        );
        $this->load->view('transaction/produksi/cart_produksi', $data);
    }

    function process_exists()
    {
        $post = $_POST;
        if (isset($post['add_cart'])) {
            // var_dump($post);
            // die;
            $user_id = $this->session->userdata('userid');
            $delete_cart = $this->db->query("delete from t_cart_produksi where created_by = '$user_id'");
            $this->produksi_m->insert_into_cart($post);
            if ($this->db->affected_rows() > 0) {
                $response = array('success' => true);
                echo json_encode($response);
            } else {
                $response = array('success' => false);
                echo json_encode($response);
            }
        }

        if (isset($post['edit_cart'])) {
            $this->produksi_m->update_cart_ready($post);
            if ($this->db->affected_rows() > 0) {
                $response = array('success' => true);
                echo json_encode($response);
            } else {
                $response = array('success' => false);
                echo json_encode($response);
            }
        }

        if (isset($post['proses_produksi'])) {
            // var_dump($post);
            $user_id = $this->session->userdata('userid');
            $cart = $this->db->query("select * from t_cart_produksi where created_by = '$user_id'");
            if ($cart->num_rows() > 0) {

                // validasi stock
                foreach ($cart->result() as $ct) {
                    $cart_id = $ct->id;
                    $row_complete =  $this->db->query("select * from t_cart_produksi where id = '$cart_id'");
                    if (is_null($row_complete->row()->item_id_detail)) {
                        $response = array(
                            'success' => false,
                            'complete' => false,
                        );
                        echo json_encode($response);
                        return false;
                    } else {
                    }
                }

                // var_dump($post);

                // proses stock out
                $item_cart = $this->produksi_m->get_cart_produksi();
                foreach ($item_cart->result() as $v) {
                    $params_stockout = array(
                        'item_code' => $v->item_code,
                        'item_id' => $v->item_id,
                        'item_id_detail' => $v->item_id_detail,
                        'id_item_produksi' => $post['item_produksi'],
                        'barcode' => $this->db->query("select barcode from p_item where item_code ='$v->item_code'")->row()->barcode,
                        'type' => 'out',
                        'detail' => 'stock out',
                        'info' => 'bahan baku produksi',
                        'expired_date' => $v->exp_date,
                        'qty' => $v->qty,
                        'user_id' => $this->session->userdata('userid')
                    );
                    // var_dump($params_stockout);

                    //stok out
                    $this->stockout_m->insert_stock_out($params_stockout);

                    $params_update_min = array(
                        'qty' => $v->qty,
                        'id_item_detail' => $v->item_id_detail
                    );
                    //upadate qty min p_item_detail
                    $this->produksi_m->update_qty_p_item_detail($params_update_min);
                }

                //stok in
                $id_item_produksi = $post['item_produksi'];
                $prm = array();
                $prm['item_produksi'] = $this->db->query("select item_code from tb_item_produksi where id='$id_item_produksi'")->row()->item_code;
                $prm['qty_item_produksi'] = $post['qty'];
                $prm['exp_date'] = $post['exp_date'];
                $this->stock_m->insert_stock_out_produksi($prm, $post['item_produksi']);

                //insert p_item_detail
                $this->produksi_m->insert_p_item_detail($prm, $id_item_produksi);

                //hapus cart produksi
                $this->produksi_m->delete_cart_produksi();

                if ($this->db->affected_rows() > 0) {
                    $response = array(
                        'success' => true
                    );
                    echo json_encode($response);
                } else {
                    $response = array(
                        'success' => false
                    );
                    echo json_encode($response);
                }
            } else {
                //tidak ada cart
                $response = array(
                    'success' => false,
                    'cart' => 0
                );
                echo json_encode($response);
            }
        }
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

        if (isset($_POST['proses_produksi'])) {

            $item_cart = $this->produksi_m->get_cart_produksi();
            if ($item_cart->num_rows() > 0) {
                $id = $this->produksi_m->insert_tb_item_produksi($post);

                foreach ($item_cart->result() as $value) {
                    $params = array(
                        'id_item_produksi' => $id,
                        'id_item_detail' => $value->item_id_detail,
                        'item_id' => $value->item_id,
                        'item_code' => $value->item_code,
                        'exp_date' => $value->exp_date,
                        'qty' => $value->qty,
                        'created_by' => $this->session->userdata('userid')
                    );

                    $params_stockout = array(
                        'item_code' => $value->item_code,
                        'item_id' => $value->item_id,
                        'item_id_detail' => $value->item_id_detail,
                        'id_item_produksi' => $id,
                        'barcode' => $this->db->query("select barcode from p_item where item_code ='$value->item_code'")->row()->barcode,
                        'type' => 'out',
                        'detail' => 'stock out',
                        'info' => 'bahan baku produksi',
                        'expired_date' => $value->exp_date,
                        'qty' => $value->qty,
                        'user_id' => $this->session->userdata('userid')
                    );


                    //simpan
                    $this->produksi_m->insert_tb_item_produksi_detail($params);

                    //stok out
                    $this->stockout_m->insert_stock_out($params_stockout);

                    $params_update_min = array(
                        'qty' => $value->qty,
                        'id_item_detail' => $value->item_id_detail
                    );
                    //upadate qty min p_item_detail
                    $this->produksi_m->update_qty_p_item_detail($params_update_min);
                }

                //stok in
                $this->stock_m->insert_stock_out_produksi($post, $id);

                //insert p_item_detail
                $this->produksi_m->insert_p_item_detail($post, $id);

                //hapus cart produksi
                $this->produksi_m->delete_cart_produksi();

                if ($this->db->affected_rows() > 0) {
                    $response = array(
                        'success' => true
                    );
                    echo json_encode($response);
                } else {
                    $response = array(
                        'success' => false
                    );
                    echo json_encode($response);
                }
            } else {
                // item cart tidak ada
                $params = array(
                    'success' => false,
                    'cart' => 0,
                );
                echo json_encode($params);
            }

            // redirect('stockout');
        }
    }
}
