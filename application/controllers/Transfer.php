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

        $data = array(
            'item' => $item,
            'gudang' => $gudang,
            'item_cart' => $item_cart
        );

        $this->template->load('template', 'transaction/transfer/form_transfer_stockout', $data);
    }

    function in(){
        if(isset($_POST['cari'])){
            $this->get_item_transfer($_POST);
        }else{
            $toko = $this->db->query("select * from t_toko where is_active = 'y'");
            $data = array(
                'toko' => $toko
            );
            $this->template->load('template', 'transaction/transfer/form_transfer_stockin', $data);
        }

    }

    function get_item_transfer($post){
        $whs_code = $post['whs_code'];
        $docnum = $post['docnum'];

        $post = array(
            'whs_code' => $whs_code,
            'docnum' => $docnum
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($post),
            ),
        );

        $context  = stream_context_create($options);
        $response = file_get_contents('http://119.110.68.194:8099/pandurasa-whs/item/gettransferstock', false, $context);
        $result = json_decode($response);
        
        var_dump($result);
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
                // var_dump($post);
                $id = $this->transfer_m->insert_transfer($post);
                $docnum = $this->db->query("select docnum from tb_transfer_stock where id = '$id'")->row()->docnum;
                // var_dump($id); 

                foreach ($item_cart->result() as $value) {
                    $params = array(
                        'docnum' => $docnum,
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
                        'item_code' => $value->item_code,
                        'item_id' => $value->item_id,
                        'item_id_detail' => $value->item_id_detail,
                        'barcode' => $value->barcode,
                        'type' => 'out',
                        'detail' => 'stock out',
                        'info' => 'transfer stock out',
                        'docnum_transfer' => $docnum,
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


                    //send to server
                    $upload = $this->send($docnum);

                    if ($upload == true) {
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
                } else {
                    $response = array(
                        'success' => false
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

            //     redirect('stockout');
        }
    }


    function send($docnum)
    {
        $sql = "select t1.docnum, t2.whs_code_send, t2.whs_code_rec, t1.item_code, t1.exp_date, t1.qty, t1.barcode, t3.username 
        from tb_transfer_stock_detail t1
        inner join tb_transfer_stock t2 on t1.docnum = t2.docnum 
        inner join `user` t3 on t1.created_by = t3.user_id
        where t1.docnum = '$docnum'";
        $query = $this->db->query($sql);


        $post = array(
            'post_transfer' => $query->result(),
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($post),
            ),
        );

        $context  = stream_context_create($options);
        $response = file_get_contents('http://119.110.68.194:8099/pandurasa-whs/item/transferstock', false, $context);
        $result = json_decode($response);

        // var_dump($result);

        if($result->status == 1){
            $result = true;
        }else{
            $result = false;
        }
        
        return $result;

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
