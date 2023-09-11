<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mypos_Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // check_not_login();
        $this->load->model(['item_m', 'category_m', 'unit_m']);
    }

    public function get_item()
    {
        $sql = "SELECT * FROM p_item";
        $item = $this->db->query($sql);

        if ($item->num_rows() > 0) {
            $response = array(
                'status' => 1,
                'message' => 'Success',
                'data' => $item->result(),
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'No Data Found'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function stock_in()
    {
        $whs_code = $this->db->query("select whs_code from t_toko where is_active = 'y'")->row()->whs_code;

        if (!empty($_POST)) {
            $post = array(
                'whs_code' => $_POST['whs_code'],
                'surat_jalan' => $_POST['surat_jalan']
            );
        } else if (!empty($_SESSION['whs_code']) && !empty($_SESSION['surat_jalan'])) {
            $post = array(
                'whs_code' => $_SESSION['whs_code'],
                'surat_jalan' => $_SESSION['surat_jalan']
            );
        } else {
            $post = array(
                'whs_code' => "",
                'surat_jalan' => ""
            );
        }

        $url = my_api() . 'item/get_item_transfer';
        $api = post_curl($url, $post);

        if ($api['status_code'] == 200) {

            $data = array(
                'whs_code' => $whs_code,
                'result' => $api['data'],
                'input_search' => $post
            );
            $this->template->load('template', 'transaction/stock_in/data_transfer', $data);
        } else {
            $data = array(
                'status_code' => $api['status_code']
            );
            $this->template->load('template', 'error_page', $data);
        }
    }
}
