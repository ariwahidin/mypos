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


    // function insert_karyawan()
    // {
    //     global $connect;
    //     $check = array('id' => '', 'nama' => '', 'jenis_kelamin' => '', 'alamat' => '');
    //     $check_match = count(array_intersect_key($_POST, $check));
    //     if ($check_match == count($check)) {

    //         $result = mysqli_query($connect, "INSERT INTO karyawan SET
    //            id = '$_POST[id]',
    //            nama = '$_POST[nama]',
    //            jenis_kelamin = '$_POST[jenis_kelamin]',
    //            alamat = '$_POST[alamat]'");

    //         if ($result) {
    //             $response = array(
    //                 'status' => 1,
    //                 'message' => 'Insert Success'
    //             );
    //         } else {
    //             $response = array(
    //                 'status' => 0,
    //                 'message' => 'Insert Failed.'
    //             );
    //         }
    //     } else {
    //         $response = array(
    //             'status' => 0,
    //             'message' => 'Wrong Parameter'
    //         );
    //     }
    //     header('Content-Type: application/json');
    //     echo json_encode($response);
    // }

    function stock_in()
    {
        // var_dump($_POST);
        // var_dump($_SESSION);
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

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($post),
            ),
        );

        $context  = stream_context_create($options);
        $response = file_get_contents('http://119.110.68.194:8099/pandurasa-whs/item/get_item_transfer', false, $context);
        $result = json_decode($response);

        $data = array(
            'whs_code' => $whs_code,
            'result' => $result,
            'input_search' => $post
        );

        // var_dump($result);

        $this->template->load('template', 'transaction/stock_in/data_transfer', $data);
    }
}
