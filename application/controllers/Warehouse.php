<?php defined('BASEPATH') or exit('No direct script access allowed');

class Warehouse extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['item_m']);
    }

    public function get_harga_item()
    {
        $toko = $this->db->query("SELECT * FROM t_toko WHERE is_active = 'y'")->row();
        $post_parameter = array(
            'kode_seller' => $toko->kode_seller,
            'kode_area' => $toko->kode_area,
            'kode_counter' => $toko->code_store,
            'whs_code' => $toko->whs_code,
        );
        $post_parameter['store_name'] = $toko->nama_toko;

        // var_dump($post_parameter);
        $curl_handle = curl_init(my_api().'item/get_item_harga');
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_parameter);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl_handle);
        curl_close($curl_handle);
        // var_dump($curl_response);
        $data = array(
            'item_harga' => json_decode($curl_response),
            'toko' => $post_parameter,
        );

        $this->template->load('template', 'warehouse/item', $data);

        // var_dump(json_decode($curl_response));
    }

    public function item_harga()
    {
        $url = my_api()."item/item_harga";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        if (empty($output)) {
            die("Tidak dapat terhubung ke server pusat");
            curl_close($ch); // close cURL handler
        } else {
            $info = curl_getinfo($ch);
            curl_close($ch); // close cURL handler

            if (empty($info['http_code'])) {
                die("No HTTP code was returned");
            } else {

                $data = array(
                    'item_harga' => json_decode($output),
                );

                $this->template->load('template', 'warehouse/item', $data);
            }
        }
    }

    public function add_all_master_item_pos()
    {
        $post = $_POST;
        // $row_before = $this->db->query("SELECT * FROM p_item")->num_rows();
        $row = [];
        $affected_rows = 0;
        for ($i = 0; $i < count($post['item_code']); $i++) {
            $check_item_code = $this->item_m->check_item_code($post['item_code'][$i]);
            if ($check_item_code->num_rows() > 0) {
                // echo "item sudah pernah terdaftar </br>";
                $check_harga_sama = $this->item_m->check_harga_sama($post['item_code'][$i], $post['harga_jual'][$i], $post['harga_bersih'][$i]);
                if ($check_harga_sama->num_rows() > 0) {
                    // echo "Harga sudah sama"
                } else {
                    $this->item_m->update_harga($post['item_code'][$i], $post['harga_jual'][$i], $post['harga_bersih'][$i]);
                    if ($this->db->affected_rows() > 0) {
                        $affected_rows += 1;
                    }
                }
            } else {
                // echo "item belum pernah terdaftar </br>";
                $params = [
                    'item_code' => $post['item_code'][$i],
                    'barcode' => $post['barcode'][$i],
                    'name' => $post['item_name'][$i],
                    'item_name_toko' => $post['item_name_toko'][$i],
                    'packing' => '',
                    'category_id' => '15',
                    'unit_id' => '5',
                    'price' => $post['harga_jual'][$i],
                    'harga_jual' => $post['harga_jual'][$i],
                    'harga_bersih' => $post['harga_bersih'][$i],
                    'image' => '',
                ];
                array_push($row, $params);
            }
        }

        $this->item_m->add_all_item($row);

        // var_dump($this->db->affected_rows());
        // var_dump($affected_rows);
        // die;

        $affected_rows = $affected_rows + $this->db->affected_rows();

        // $row_after = $this->db->query("SELECT * FROM p_item")->num_rows();
        // $row_inserted = $row_after - $row_before;

        if ($affected_rows > 0) {
            $this->session->set_flashdata('success', 'Berhasil disesuaikan');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada yang disesuaikan');
        }
        redirect('Warehouse/get_harga_item');
    }

    public function add_master_item_pos()
    {
        $post = $_POST;
        // var_dump($post);
        // die;
        $params = [
            'item_code' => $post['item_code'],
            'barcode' => $post['barcode'],
            'product_name' => $post['item_name'],
            'item_name_toko' => $post['item_name_toko'],
            'packing' => '',
            'category' => '15',
            'unit' => '5',
            'harga_bersih' => $post['harga_bersih'],
            'harga_jual' => $post['harga_jual'],
            'image' => '',
        ];

        if ($this->item_m->check_barcode($post['barcode'])->num_rows() > 0) {
            $this->session->set_flashdata('error', "Barcode $post[barcode] sudah dipakai barang lain");
            redirect('Warehouse/get_harga_item');
            return false;
        } else {
            $this->item_m->add($params);
        }

        // die;

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Item ' . $post['item_name'] . ' berhasil ditambahkan');
        }
        redirect('Warehouse/get_harga_item');
    }

    public function setting_harga()
    {
        $url = my_api()."item/get_harga";
        $toko = $this->db->query("SELECT * FROM t_toko WHERE is_active = 'y'")->row();
        $post = array(
            'kode_seller' => $toko->kode_seller,
            'kode_area' => $toko->kode_area,
            'kode_counter' => $toko->code_store,
        );
        // var_dump($post);
        // die;
        $options = array(
            "http" => array(
                "method" => "POST",
                "header" => "Content-Type: application/x-www-form-urlencoded",
                "content" => http_build_query($post)
            )
        );
        $response = file_get_contents($url, false, stream_context_create($options));
        $post['store_name'] = $toko->nama_toko;
        $data = [
            'response' => json_decode($response),
            'toko' => $post,
        ];
        $this->template->load('template', 'warehouse/harga', $data);
    }

    public function update_harga()
    {
        // var_dump($_SESSION);
        // die;
        $url = my_api()."item/update_harga_item";
        $_POST['username'] = $_SESSION['username'];
        $_POST['date'] = international_date_time();
        $options = array(
            "http" => array(
                "method" => "POST",
                "header" => "Content-Type: application/x-www-form-urlencoded",
                "content" => http_build_query($_POST)
            )
        );

        $response = file_get_contents($url, false, stream_context_create($options));
        $result = json_decode($response);
        if ($result->success == true) {
            $this->session->set_flashdata('success', $result->message);
        } else {
            $this->session->set_flashdata('error', $result->message);
        }
        redirect('warehouse/setting_harga');
    }

    public function sinkronisasi()
    {
        // var_dump($_POST);
        $post = $_POST;
        $this->item_m->sinkronisasi($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Item berhasil disesuaikan');
        } else {
            $this->session->set_flashdata('error', 'Gagal sesuaikan data');
        }
        redirect('warehouse/get_harga_item');
    }

    public function get_master_item()
    {

        $curl_handle = curl_init(my_api().'item/get_master_item');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl_handle);
        curl_close($curl_handle);

        $data = array(
            'status' => 'Ok',
            'item' => json_decode($curl_response),
        );

        $this->load->view('warehouse/modal_master_item', $data);
    }

    public function add_item_to_counter()
    {
        $post = $_POST;
        $toko = $this->db->query("SELECT * FROM t_toko WHERE is_active = 'y'")->row();
        $post_parameter = array(
            'kode_seller' => $toko->kode_seller,
            'kode_area' => $toko->kode_area,
            'kode_counter' => $toko->code_store,
            'item_code' => $post['item_code'],
            'barcode' => $post['barcode'],
            'brand_code' => $post['brand_code'],
            'created_date' => international_date_time(),
            'created_by' => $this->session->userdata('username'),
        );
        $curl_handle = curl_init(my_api().'item/add_new_item_to_counter');
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_parameter);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl_handle);
        $result = json_decode($curl_response);
        curl_close($curl_handle);
        // var_dump($curl_response);
        if ($result->success == true) {
            $params = array(
                'success' => true,
            );
        } else {
            $params =  array(
                'success' => false
            );
        }
        echo json_encode($params);
    }

    public function ajax_setting_harga()
    {
        $url = my_api()."item/get_harga";
        $toko = $this->db->query("SELECT * FROM t_toko WHERE is_active = 'y'")->row();
        $post = array(
            'kode_seller' => $toko->kode_seller,
            'kode_area' => $toko->kode_area,
            'kode_counter' => $toko->code_store,
        );
        $options = array(
            "http" => array(
                "method" => "POST",
                "header" => "Content-Type: application/x-www-form-urlencoded",
                "content" => http_build_query($post)
            )
        );
        $response = file_get_contents($url, false, stream_context_create($options));
        $post['store_name'] = $toko->nama_toko;
        $data = [
            'response' => json_decode($response),
            'toko' => $post,
        ];
        $this->load->view('warehouse/ajax_harga', $data);
    }
}
