<?php defined('BASEPATH') or exit('No direct script access allowed');

class Stock extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['item_m', 'supplier_m', 'stock_m']);
    }

    public function stock_in_data()
    {
        $data['row'] = $this->stock_m->get_stock_in()->result();

        $stock_in = $this->stock_m->get_stock_in();

        if (isset($_POST['download_stock_in'])) {

            // var_dump($_POST);
            // die;

            if ($stock_in->num_rows() > 0) {

                $data = array(
                    'toko' => $this->db->query("SELECT * FROM t_toko where is_active = 'y'"),
                    'stock_in' => $stock_in,
                );

                $this->load->view('report/stock_in_excel', $data);
                return false;
            } else {

                $this->session->set_flashdata('error', 'Data yang di cari tidak tersedia');
                redirect('stock/in');
                return false;
            }
        }

        $this->template->load('template', 'transaction/stock_in/stock_in_data', $data);
    }

    public function stock_detail()
    {
        $stock = $this->stock_m->get_stock_detail();

        if (isset($_POST['download_stock_detail'])) {

            // var_dump($_POST);
            // die;

            if ($stock->num_rows() > 0) {

                $data = array(
                    'toko' => $this->db->query("SELECT * FROM t_toko where is_active = 'y'"),
                    'stock' => $stock,
                );

                $this->load->view('report/stock_detail_excel', $data);
                return false;
            } else {

                $this->session->set_flashdata('error', 'Data yang di cari tidak tersedia');
                redirect('stock/stock_detail');
                return false;
            }
        }


        $data =  array(
            'stock' => $stock,
        );
        $this->template->load('template', 'report/data_stock_detail', $data);
    }

    public function stock_in_add()
    {
        $item = $this->item_m->get()->result();
        $supplier = $this->supplier_m->get()->result();
        $data = ['item' => $item, 'supplier' => $supplier];
        $this->template->load('template', 'transaction/stock_in/stock_in_form', $data);
    }

    public function stock_in_del()
    {
        $stock_id = $this->uri->segment(4);
        $item_id = $this->uri->segment(5);
        $qty = $this->stock_m->get($stock_id)->row()->qty;
        $data = ['qty' => $qty, 'item_id' => $item_id];
        $this->item_m->update_stock_out($data);
        $this->stock_m->del($stock_id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data Stock-In berhasil dihapus');
        }
        redirect('stock/in');
    }

    public function process()
    {
        if (isset($_POST['in_add'])) {
            $post = $this->input->post(null, TRUE);
            $this->stock_m->add_stock_in($post);
            $this->item_m->update_stock_in($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Stock-In berhasil disimpan');
            }
            redirect('stock/in');
        } else if (isset($_POST['out_add'])) {
            $post = $this->input->post(null, TRUE);
            $row_item = $this->item_m->get($this->input->post('item_id'))->row();
            if ($row_item->stock < $this->input->post('qty')) {
                $this->session->set_flashdata('error', 'Qty melebihi stock barang');
                redirect('stock/out/add');
            } else {
                $this->stock_m->add_stock_out($post);
                $this->item_m->update_stock_out($post);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success', 'Data Stock-Out berhasil disimpan');
                }
                redirect('stock/out');
            }
        }
    }

    // public function process_stock()
    // {
    //     if (isset($_POST['in_add'])) {
    //         $post = $this->input->post(null, TRUE);
    //         $this->stock_m->add_stock_in($post);
    //         $this->item_m->update_stock_in($post);
    //         if ($this->db->affected_rows() > 0) {
    //             $this->session->set_flashdata('success', 'Data Stock-In berhasil disimpan');
    //         }
    //         redirect('sale/stock');
    //     } else if (isset($_POST['out_add'])) {
    //         $post = $this->input->post(null, TRUE);
    //         $row_item = $this->item_m->get($this->input->post('item_id'))->row();
    //         if ($row_item->stock < $this->input->post('qty')) {
    //             $this->session->set_flashdata('error', 'Qty melebihi stock barang');
    //             redirect('sale/stock');
    //         } else {
    //             $this->stock_m->add_stock_out($post);
    //             $this->item_m->update_stock_out($post);
    //             if ($this->db->affected_rows() > 0) {
    //                 $this->session->set_flashdata('success', 'Data Stock-Out berhasil disimpan');
    //             }
    //             redirect('sale/stock');
    //         }
    //     }
    // }


    public function stock_out_data()
    {
        $data['row'] = $this->stock_m->get_stock_out()->result();

        $stock_out = $this->stock_m->get_stock_out();

        if (isset($_POST['download_stock_out'])) {

            // var_dump($_POST);
            // die;

            if ($stock_out->num_rows() > 0) {

                $data = array(
                    'toko' => $this->db->query("SELECT * FROM t_toko where is_active = 'y'"),
                    'stock_out' => $stock_out,
                );

                $this->load->view('report/stock_out_excel', $data);
                return false;
            } else {

                $this->session->set_flashdata('error', 'Data yang di cari tidak tersedia');
                redirect('stock/out');
                return false;
            }
        }

        $this->template->load('template', 'transaction/stock_out/stock_out_data', $data);
    }

    public function stock_out_add()
    {
        $item = $this->item_m->get()->result();
        $data = ['item' => $item];
        $this->template->load('template', 'transaction/stock_out/stock_out_form', $data);
    }

    public function stock_out_del()
    {
        $stock_id = $this->uri->segment(4);
        $item_id = $this->uri->segment(5);
        $qty = $this->stock_m->get($stock_id)->row()->qty;
        $data = ['qty' => $qty, 'item_id' => $item_id];
        $this->item_m->update_stock_in($data);
        $this->stock_m->del($stock_id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data Stock-Out berhasil dihapus');
        }
        redirect('stock/out');
    }

    public function proccess_stock_in()
    {
        $post = $_POST;
        $cek_docnum = $this->stock_m->cek_docnum($post)->num_rows();
        $item_code_not_exists = $this->stock_m->cek_item_code_not_exists($post);
        $barcode_not_exists = $this->stock_m->cek_barcode_not_exists($post);

        if ($cek_docnum > 0) {
            $this->session->set_flashdata('error', 'Stock In Gagal, Data Stock In Dengan Surat Jalan ' . $post['docnum'][0] . ' Sudah Ada');
        } else if (count($item_code_not_exists) > 0) {
            $item_code = implode(', ', $item_code_not_exists);
            $this->session->set_flashdata('error', 'Stock In Gagal, Item Code ' . $item_code . ' Tidak Terdaftar Di Toko');
        } else if (count($barcode_not_exists) > 0) {
            $barcode = implode(', ', $barcode_not_exists);
            $this->session->set_flashdata('error', 'Stock In Gagal, Barcode ' . $barcode . ' Tidak Terdaftar Di Toko');
        } else {
            $this->stock_m->add_stock_in($post);
            $this->stock_m->simpan_item_detail($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Stock In Data Berhasil Disimpan');
            } else {
                $this->session->set_flashdata('error', 'Stock In Data Gagal');
            }
        }

        $data = array(
            'whs_code' => $post['whs_code'][0],
            'surat_jalan' => $post['docnum'][0]
        );

        $this->session->set_flashdata($data);

        redirect('mypos_api/stock_in');
    }
}
