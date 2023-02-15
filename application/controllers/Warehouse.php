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
        $user_id = $this->session->userdata('userid');
        $delete_cart_sync = $this->db->query("delete from t_cart_sync_item where user_id = '$user_id'");

        $toko = $this->db->query("SELECT * FROM t_toko WHERE is_active = 'y'")->row();
        $post_parameter = array(
            'kode_seller' => $toko->kode_seller,
            'kode_area' => $toko->kode_area,
            'kode_counter' => $toko->code_store,
            'whs_code' => $toko->whs_code,
        );
        $post_parameter['store_name'] = $toko->nama_toko;

        $url = my_api() . 'item/get_item_harga';
        $api = post_curl($url, $post_parameter);


        if ($api['status_code'] == 200) {

            // var_dump($api['data']);
            // die;

            if (count($api['data']->data) > 0) {
                $row = array();
                foreach ($api['data']->data as $it) {
                    $params = array(
                        'whs_code' => $it->whs_code,
                        'item_code' => $it->item_code,
                        'barcode' => $it->barcode,
                        'item_name' => $it->item_name,
                        'brand_code' => $it->brand_code,
                        'min_stock' => $it->min_stock,
                        'harga_jual' => $it->harga_jual,
                        'harga_bersih' => $it->harga_bersih,
                        'harga_ppn' => $it->harga_ppn,
                        'percent_ppn' => $it->percent_ppn,
                        'user_id' => $this->session->userdata('userid')
                    );
                    array_push($row, $params);
                }
                $this->db->insert_batch('t_cart_sync_item ', $row);
                $singkronisasi = $this->item_m->singkronisasi();

                if ($singkronisasi['total_update'] > 0 || $singkronisasi['total_insert'] > 0) {
                    $this->session->set_flashdata('success', 'Update : ' . $singkronisasi['total_update'] . ', Item Baru : ' . $singkronisasi['total_insert']);
                } else {
                    $this->session->set_flashdata('error', 'Tidak ada data ter-update');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Error ' . $api['status_code']);
        }

        redirect('item');
    }
    
}
