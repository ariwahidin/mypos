<?php defined('BASEPATH') or exit('No direct script access allowed');

class Transfer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['item_m', 'supplier_m', 'stock_m', 'sale_m', 'transfer_m', 'stockout_m']);
    }

    function index()
    {
        $item = $this->sale_m->get_item_detail();
        $gudang = $this->db->query("select * from master_gudang");
        $item_cart = $this->transfer_m->get_cart();

        // die;

        $data = array(
            'item' => $item,
            'gudang' => $gudang,
            'item_cart' => $item_cart
        );

        $this->template->load('template', 'transaction/transfer/form_transfer_stockout', $data);
    }

    function data_transfer_in()
    {
        $transfer_in = $this->transfer_m->get_data_transfer_in();
        $data = array(
            'transfer_in' => $transfer_in,
        );
        $this->template->load('template', 'transaction/transfer/data_transfer_in', $data);
    }

    function data_transfer_out()
    {
        $stockout = $this->transfer_m->get_data_transfer_stock_out();
        $data = array(
            'stockout' => $stockout
        );
        $this->template->load('template', 'transaction/transfer/data_transfer_out', $data);
    }

    function show_detail_transfer_stockout()
    {
        $docnum = $_POST['docnum'];
        $sql = "select t1.barcode, t2.name, t1.qty, t1.exp_date from tb_transfer_stock_detail t1
        inner join p_item t2 on t1.item_code = t2.item_code
        where t1.docnum = '$docnum'";
        $detail = $this->db->query($sql);
        $data = array(
            'detail' => $detail
        );
        $this->load->view('transaction/transfer/modal_transfer_detail_stockout', $data);
    }

    function show_detail_transfer_stockin()
    {
        $docnum = $_POST['docnum'];
        $sql = "select distinct  
        t4.barcode, t4.name, t1.qty, t1.expired_date as exp_date
        from t_stock t1
        inner join master_gudang t2 on t1.whs_code = t2.whs_code
        inner join user t3 on t1.user_id = t3.user_id
        inner join p_item t4 on t1.item_code = t4.item_code 
        where t1.info = 'transfer stock in'
        and t1.docnum_transfer = '$docnum'";
        $detail = $this->db->query($sql);
        $data = array(
            'detail' => $detail
        );
        $this->load->view('transaction/transfer/modal_transfer_detail_stockin', $data);
    }

    function in()
    {
        $data['whs_code'] = $this->db->query("select whs_code from t_toko where is_active = 'y'")->row()->whs_code;
        $delete_cart = $this->transfer_m->delete_cart_transfer_stockin();

        if (isset($_POST['cari'])) {
            $item_transfer = $this->get_item_transfer($_POST);
            $data['docnum'] = $_POST['docnum'];
        }

        $data['item'] = $this->transfer_m->get_cart_transfer_stockin();
        $data['toko'] = $this->db->query("select * from t_toko where is_active = 'y'");
        $this->template->load('template', 'transaction/transfer/form_transfer_stockin', $data);
    }

    function proses_simpan_stockin()
    {
        $post = $_POST;

        $doc_id = $this->stock_m->stock_doc_id();

        $docnum_transfer = $this->db->query("SELECT docnum FROM t_cart_transfer_stockin");

        if ($docnum_transfer->num_rows() > 0) {
            $no_transfer = $docnum_transfer->row()->docnum;
            $cek = $this->db->query("SELECT * FROM t_stock WHERE docnum_transfer = '$no_transfer' AND type = 'in'");

            if ($cek->num_rows() > 0) {
                $response = array(
                    'exists' => true,
                );
            } else {
                $simpan = $this->transfer_m->simpan_transfer_stockin($doc_id);
                $update_stock = $this->transfer_m->update_stock_detail($doc_id);
                if ($this->db->affected_rows() > 0) {
                    $response = array('success' => true);
                } else {
                    $response = array('success' => false);
                }
            }
        }
        echo json_encode($response);
    }

    function get_item_transfer($post)
    {
        $whs_code = $post['whs_code'];
        $docnum = $post['docnum'];

        $post = array(
            'whs_code' => $whs_code,
            'docnum' => $docnum
        );

        $url = my_api() . 'item/gettransferstock';
        $api = post_curl($url, $post);

        if ($api['status_code'] != 200) {
            // echo "Tidak Ada Koneksi";
            $this->session->set_flashdata('error', 'Error ' . $api['status_code']);
            return false;
        }

        if (isset($api['data']->data)) {
            $insert_cart = $this->transfer_m->insert_cart($api['data']->data);
            $return = $this->db->affected_rows();
        } else {
            $return = $this->db->affected_rows();
        }

        return $return;
    }



    function process()
    {
        $post = $_POST;

        if (isset($post['add_cart'])) {

            // var_dump($post);

            $cek = $this->transfer_m->get_cart($post['item_id_detail']);
            if ($cek->num_rows() > 0) {
                $this->transfer_m->update_cart($post);
            } else {
                $this->transfer_m->add_cart($post);
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
            $this->transfer_m->update_qty($post);

            if ($this->db->affected_rows() > 0) {
                $params = array('success' => true);
            } else {
                $params = array('success' => false);
            }
            echo json_encode($params);
        }

        if (isset($post['delete_item_cart'])) {

            $this->transfer_m->delete_cart($post);

            if ($this->db->affected_rows() > 0) {
                $params = array('success' => true);
            } else {
                $params = array('success' => false);
            }
            echo json_encode($params);
        }

        if (isset($_POST['proccess_transfer'])) {



            $item_cart = $this->transfer_m->get_cart();

            if ($item_cart->num_rows() > 0) {

                $item_transfer = $this->transfer_m->get_cart();
                $user_id = $this->session->userdata('userid');
                $user = $this->db->query("select name from user where user_id = '$user_id'")->row()->name;

                $post_data = array(
                    "pengirim" => $this->db->query("SELECT whs_code FROM t_toko WHERE is_active = 'y'")->row()->whs_code,
                    "tujuan" => $post['whs_code'],
                    "created_by" => $user,
                    "post_transfer" => $item_transfer->result()
                );

                // Start Proses kirim data ke server
                $url = my_api() . 'item/transferstock';
                $api = post_curl($url, $post_data);

                if ($api['status_code'] != 200) {
                    echo json_encode(['koneksi' => $api['status_code']]);
                    return false;
                }

                $nomor_transfer = $api['data']->nomor_transfer;
                // End Kirim Data ke server

                $id = $this->transfer_m->insert_transfer($post, $nomor_transfer);
                $stock_id = $this->stock_m->stock_doc_id();

                foreach ($item_cart->result() as $value) {

                    $params = array(
                        'docnum' => $nomor_transfer,
                        'item_code' => $value->item_code,
                        'barcode' => $value->barcode,
                        'item_id' => $value->item_id,
                        'item_id_detail' => $value->item_id_detail,
                        'qty' => $value->qty,
                        'exp_date' => $value->exp_date,
                        'created_by' => $this->session->userdata('userid')
                    );

                    // insert tb transfer detail
                    $this->transfer_m->insert_transfer_detail($params);

                    $params_stockout = array(
                        'doc_id' => $stock_id,
                        'item_code' => $value->item_code,
                        'item_id' => $value->item_id,
                        'item_id_detail' => $value->item_id_detail,
                        'barcode' => $value->barcode,
                        'type' => 'out',
                        'detail' => 'stock out',
                        'info' => 'transfer stock out',
                        'docnum_transfer' => $nomor_transfer,
                        'expired_date' => $value->exp_date,
                        'qty' => $value->qty,
                        'user_id' => $this->session->userdata('userid')
                    );

                    //stok out
                    $this->stockout_m->insert_stock_out($params_stockout);

                    $params_update_min = array(
                        'qty' => $value->qty,
                        'id_item_detail' => $value->item_id_detail
                    );

                    //update qty min p_item_detail
                    $this->transfer_m->update_qty_p_item_detail($params_update_min);
                }

                $this->transfer_m->delete_cart_transfer();

                if ($this->db->affected_rows() > 0) {

                    $response = array(
                        'success' => true,
                        'uploaded' => true
                    );
                } else {
                    $response = array(
                        'success' => false,
                        'uploaded' => false
                    );
                }

                echo json_encode($response);
            } else {
                $response = array(
                    'success' => false,
                    'cart' => 0
                );
                echo json_encode($response);
            }
            // redirect('stockout');
        }
    }

    function cart_data()
    {
        $item_cart = $this->transfer_m->get_cart();
        $data = array(
            'item_cart' => $item_cart,
        );
        $this->load->view('transaction/transfer/cart_transfer', $data);
    }
}
