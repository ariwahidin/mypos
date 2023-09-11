<?php defined('BASEPATH') or exit('No direct script access allowed');

class Item extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['item_m', 'category_m', 'unit_m', 'stock_m']);
    }

    function whs_code()
    {
        $whs_code = $this->db->query("select whs_code from t_toko where is_active = 'y'")->row()->whs_code;
        return $whs_code;
    }

    function get_ajax()
    {
        $list = $this->item_m->get_datatables();
        // var_dump($list);
        // die;
        $data = array();
        $no = @$_POST['start'];

        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $item->item_code;
            $row[] = $item->barcode; //. '<br><a href="' . site_url('item/barcode_qrcode/' . $item->item_id) . '" class="btn btn-default btn-xs">Generate <i class="fa fa-barcode"></i></a>';
            $row[] = $item->name;
            $row[] = ucwords($item->category_name);
            $row[] = $item->unit_name;
            $row[] = number_format($item->harga_jual);
            $row[] = number_format($item->harga_bersih);
            $row[] = '<a href="' . base_url('item/item_stock_detail/') . $item->item_code . '">' . $item->stock . '</a>';
            // $row[] = $item->image != null ? '<img src="' . base_url('uploads/product/' . $item->image) . '" class="img" style="width:100px">' : null;
            // add html for action
            // $row[] = '<a href="' . site_url('item/del/' . $item->item_id) . '" onclick="return confirm(\'Yakin hapus data?\')"  class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->item_m->count_all(),
            "recordsFiltered" => $this->item_m->count_filtered(),
            "data" => $data,
        );

        // output to json format
        echo json_encode($output);
    }

    public function index()
    {

        $data =  array(
            'item' => $this->item_m->get_item(),
        );

        $this->template->load('template', 'product/item/item_data', $data);
    }

    public function addFromExcel()
    {
        $data = array();
        $this->template->load('template', 'product/item/addFromExcel', $data);
    }

    public function uploadExcel()
    {
        if (isset($_POST['submitBtn'])) {
            // Periksa apakah file berhasil diunggah
            if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] == 0) {
                // Tentukan direktori tujuan untuk menyimpan file yang diunggah
                $target_dir = "uploads/excel-file/";
                // var_dump($target_dir);
                // die;

                $target_file = $target_dir . basename($_FILES["fileInput"]["name"]);

                // Pindahkan file yang diunggah ke direktori tujuan
                if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file)) {
                    // Baca isi file Excel yang diunggah menggunakan pustaka PHPExcel
                    // var_dump($target_file);
                    include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
                    $objPHPExcel = PHPExcel_IOFactory::load($target_file);
                    $worksheet = $objPHPExcel->getActiveSheet();

                    // Konversi isi file Excel menjadi format HTML
                    // $html = $worksheet->toArray();
                    // var_dump($html);
                    $excel = $worksheet->toArray();
                    $data_excel_valid = array();


                    foreach ($excel as $data) {

                        $cek = $this->db->get_where('p_item', array('item_code' => $data[0]));

                        if ($cek->num_rows() > 0) {
                            $rows = array(
                                'item_id' => $cek->row()->item_id,
                                'item_code' => $data[0],
                                'barcode' => $data[1],
                                'name' => $data[2],
                                'qty' => $data[3],
                                'expired_date' => date('Y-m-d', strtotime($data[4]))
                            );
                            array_push($data_excel_valid, $rows);
                        }
                    }

                    $data = array(
                        'target_file' => $target_file,
                        'excel_data' => $data_excel_valid
                    );

                    $this->template->load('template', 'product/item/dataFromExcel', $data);
                } else {
                    echo "Gagal mengunggah file.";
                }
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
            }
        }

        if (isset($_POST['submitProses'])) {
            // var_dump($_POST);
            include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
            $objPHPExcel = PHPExcel_IOFactory::load($_POST['file_target']);
            $worksheet = $objPHPExcel->getActiveSheet();
            $excel = $worksheet->toArray();
            // var_dump($excel);

            $params = array();

            foreach ($excel as $data) {

                $cek = $this->db->get_where('p_item', array('item_code' => $data[0]));

                if ($cek->num_rows() > 0) {
                    $rows = array(
                        'item_id' => $cek->row()->item_id,
                        'item_code' => $data[0],
                        'barcode' => $data[1],
                        'name' => $data[2],
                        'qty' => $data[3],
                        'expired_date' => date('Y-m-d', strtotime($data[4]))
                    );
                    array_push($params, $rows);
                }
            }

            $this->stock_m->deleteAllStockDetail();
            $this->stock_m->simpan_item_detail_from_excel($params);
            $this->stock_m->add_stock_from_excel($params);


            if ($this->db->affected_rows() > 0) {
                // echo "data berhasil di proses";
                $this->session->set_flashdata('success', 'Proses Data Berhasil');
            } else {
                // echo "gagal proses data";
                $this->session->set_flashdata('error', 'Gagal Proses Data');
            }

            $file_path = $_POST['file_target'];

            if (file_exists($file_path)) {
                unlink($file_path);
            }
            redirect('item/addFromExcel');
        }
    }

    public function suggest()
    {
        $data = array(
            'item_suggest' => $this->item_m->get_suggest_qty()
        );
        $this->template->load('template', 'product/item/item_suggest', $data);
    }

    public function order()
    {

        $delete_cart_suggest = $this->item_m->delete_cart();
        $data = array(
            'item_suggest' => $this->item_m->get_suggest_qty(),
            'cart_order' => $this->item_m->get_cart_order()
        );
        $this->template->load('template', 'product/item/order', $data);
    }

    public function add_cart()
    {
        $post = $this->input->post();

        $item_selected = $this->item_m->get_suggest_qty($post["item_code"]);
        $add_cart = $this->item_m->add_cart($item_selected);
        $cart = $this->item_m->get_cart_order();
        $data = array(
            'cart_order' => $cart
        );
        $this->load->view('product/item/table_order', $data);
    }

    public function delete_cart()
    {
        $id = $this->input->post('id');
        $this->item_m->delete_cart($id);
        $cart = $this->item_m->get_cart_order();
        $data = array(
            'cart_order' => $cart
        );
        $this->load->view('product/item/table_order', $data);
    }

    public function order_item()
    {
        $item_order = $this->item_m->get_item_order();
        $data = array(
            'item_order' => $item_order
        );
        $this->template->load('template', 'product/item/data_order', $data);
    }

    public  function proses_order()
    {
        $cart = $this->item_m->get_cart_order();
        if ($cart->num_rows() > 0) {

            $whs_code = $this->db->query("select whs_code from t_toko where is_active = 'y'")->row()->whs_code;
            $post_data = array(
                'whs_code' => $whs_code,
                'item_order' => $cart->result()
            );

            $url = my_api() . 'item/order';
            $api = post_curl($url, $post_data);

            if ($api['status_code'] == 200) {

                if ($api['data']->status == 1) {
                    $nomor_order = $api['data']->no_order;
                    $this->item_m->simpan_order_stock($nomor_order);
                    if ($this->db->affected_rows() > 0) {
                        $response = array(
                            'success' => true,
                            'messages' => $api['data']->messages,
                            'status' => $api['data']->status
                        );
                    } else {
                        $response = array(
                            'success' => false,
                            'messages' => 'Gagal insert data local'
                        );
                    }
                } else {
                    $response = array(
                        'success' => false,
                        'messages' => $api['data']->messages,
                        'status' => $api['data']->status
                    );
                }
            } else {
                $response = array(
                    'success' => false,
                    'status_code' => $api['status_code']
                );
            }
        } else {
            $response = array('success' => false);
        }
        echo json_encode($response);
    }

    public function add()
    {
        $item = new stdClass();
        $item->item_code = null;
        $item->item_id = null;
        $item->barcode = null;
        $item->name = null;
        $item->price = null;
        $item->category_id = null;

        $query_category = $this->category_m->get();

        $query_unit = $this->unit_m->get();
        $unit[null] = '- Pilih -';
        foreach ($query_unit->result() as $unt) {
            $unit[$unt->unit_id] = $unt->name;
        }


        $data = array(

            'page' => 'add',
            'row' => $item,
            'category' => $query_category,
            'unit' => $unit, 'selectedunit' => null,
        );
        $this->template->load('template', 'product/item/item_form', $data);
    }



    public function edit($id)
    {
        $query = $this->item_m->get($id);
        if ($query->num_rows() > 0) {
            $item = $query->row();
            $query_category = $this->category_m->get();

            $query_unit = $this->unit_m->get();
            $unit[null] = '- Pilih -';
            foreach ($query_unit->result() as $unt) {
                $unit[$unt->unit_id] = $unt->name;
            }
            $tax = $this->db->query("SELECT * FROM tax");

            $data = array(
                'tax' => $tax,
                'page' => 'edit',
                'row' => $item,
                'category' => $query_category,
                'unit' => $unit, 'selectedunit' => $item->unit_id,
            );
            $this->template->load('template', 'product/item/item_form', $data);
        } else {
            echo "<script>alert('Data tidak ditemukan');";
            echo "window.location='" . site_url('item') . "';</script>";
        }
    }

    public function process()
    {
        $config['upload_path']    = './uploads/product/';
        $config['allowed_types']  = 'gif|jpg|png|jpeg';
        $config['max_size']       = 2048;
        $config['file_name']      = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);
        $this->load->library('upload', $config);

        $post = $this->input->post(null, TRUE);
        $post['item_name_toko'] = $post['product_name'];
        if (isset($_POST['add'])) {
            if ($this->item_m->check_barcode($post['barcode'])->num_rows() > 0) {
                $this->session->set_flashdata('error', "Barcode $post[barcode] sudah dipakai barang lain");
                redirect('item');
            } else if ($this->item_m->check_item_code($post['item_code'])->num_rows() > 0) {
                $this->session->set_flashdata('error', "Item Code $post[item_code] sudah dipakai barang lain");
                redirect('item');
            } else {
                if (@$_FILES['image']['name'] != null) {
                    if ($this->upload->do_upload('image')) {
                        $post['image'] = $this->upload->data('file_name');
                        $this->item_m->add($post);
                        if ($this->db->affected_rows() > 0) {
                            $this->session->set_flashdata('success', 'Data berhasil disimpan');
                        }
                        redirect('item');
                    } else {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect('item');
                    }
                } else {
                    $post['image'] = null;
                    $this->item_m->add($post);
                    if ($this->db->affected_rows() > 0) {
                        $this->session->set_flashdata('success', 'Data berhasil disimpan');
                    }
                    redirect('item');
                }
            }
        } else if (isset($_POST['edit'])) {
            if ($this->item_m->check_barcode($post['barcode'], $post['id'])->num_rows() > 0) {
                $this->session->set_flashdata('error', "Barcode $post[barcode] sudah dipakai barang lain");
                redirect('item/edit/' . $post['id']);
            } else if ($this->item_m->check_item_code($post['item_code'], $post['id'])->num_rows() > 0) {
                $this->session->set_flashdata('error', "Item Code $post[item_code] sudah dipakai barang lain");
                redirect('item/add');
            } else {
                if (@$_FILES['image']['name'] != null) {
                    if ($this->upload->do_upload('image')) {

                        $item = $this->item_m->get($post['id'])->row();
                        if ($item->image != null) {
                            $target_file = './uploads/product/' . $item->image;
                            unlink($target_file);
                        }

                        $post['image'] = $this->upload->data('file_name');
                        $this->item_m->edit($post);
                        if ($this->db->affected_rows() > 0) {
                            $this->session->set_flashdata('success', 'Data berhasil disimpan');
                        }
                        redirect('item');
                    } else {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect('item/add');
                    }
                } else {
                    $post['image'] = null;
                    $this->item_m->edit($post);
                    if ($this->db->affected_rows() > 0) {
                        $this->session->set_flashdata('success', 'Data berhasil disimpan');
                    }
                    redirect('item');
                }
            }
        }
    }

    public function del($id)
    {
        $item = $this->item_m->get($id)->row();
        if ($item->image != null) {
            $target_file = './uploads/product/' . $item->image;
            unlink($target_file);
        }

        $this->item_m->del($id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        }
        redirect('item');
    }

    function barcode_qrcode($id)
    {
        $data['row'] = $this->item_m->get($id)->row();
        $this->template->load('template', 'product/item/barcode_qrcode', $data);
    }

    function barcode_print($id)
    {
        $data['row'] = $this->item_m->get($id)->row();
        $html = $this->load->view('product/item/barcode_print', $data, true);
        $this->fungsi->PdfGenerator($html, 'barcode-' . $data['row']->barcode, 'A4', 'landscape');
    }

    function qrcode_print($id)
    {
        $data['row'] = $this->item_m->get($id)->row();
        $html = $this->load->view('product/item/qrcode_print', $data, true);
        $this->fungsi->PdfGenerator($html, 'qrcode-' . $data['row']->barcode, 'A4', 'potrait');
    }

    function item_stock_detail($item_code)
    {
        $item = $this->db->query("select t1.*, t2.name as item_name 
        from p_item_detail t1
        inner join p_item t2 on t1.item_code = t2.item_code
        where t1.item_code = '$item_code'");
        $data = array(
            'item_code' => $item_code,
            'item' => $item
        );
        $this->template->load('template', 'product/item/item_stock_detail_v', $data);
    }

    function add_stock()
    {
        $post = $this->input->post();
        // var_dump($post);
        // die;
        $this->stock_m->add_stock_manual($post);
        $this->item_m->add_stock($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Stock berhasil ditambah');
        } else {
            $this->session->set_flashdata('error', 'Gagal tambah data');
        }
        redirect('item');
    }

    function refresh_order()
    {
        $whs_code = $this->whs_code();
        $post_data = array(
            'whs_code' => $whs_code
        );

        $url = my_api() . 'item/getorder';
        $api = post_curl($url, $post_data);

        if (count($api["data"]) > 0) {
            $refresh = $this->item_m->refresh_order($api["data"]);
            if ($refresh > 0) {
                $this->session->set_flashdata('success', 'Berhasil refresh');
            } else {
                $this->session->set_flashdata('success', 'Data Sudah Up to date');
            }
        }

        redirect('item/order_item');
    }

    function order_detail()
    {
        $no_order = $this->input->post('no_order');
        $detail = $this->item_m->get_detail_order($no_order);
        $data = array(
            'detail' => $detail
        );
        $this->load->view('product/item/modal_order_detail', $data);
    }


    function discount()
    {
        $data = array();
        $this->template->load('template', 'product/item/item_discount', $data);
    }

    function loadItemDiscount()
    {
        $data = array(
            'item' => $this->item_m->getItemDiscount(),
        );
        $this->load->view('product/item/table_item_discount', $data);
    }

    function getDiscountItem()
    {
        $url = 'item/getPromoDetail';
        $api = get_curl($url);

        if ($api['success'] == true) {
            
            // //delete item discount sebelum di timpa item discount baru
            // $delete = $this->item_m->deleteAllItemDiscount();

            $item = $api['item'];
            $update = $this->item_m->updateItemDiscount($item);

            if ($update > 0) {
                $response = array(
                    'updated' => $update,
                    'icon' => 'success',
                    'message' => 'Berhasil Update Data',
                    'success' => true
                );
            } else {
                $response = array(
                    'success' => false,
                    'icon' => 'warning',
                    'updated' => $update,
                    'message' => 'Data sudah up to date',
                );
            }

        } else {
            $response = array(
                'success' => false,
                'icon' => 'error',
                'message' => 'Tidak ada data',
            );
        }
        echo json_encode($response);
    }
}
