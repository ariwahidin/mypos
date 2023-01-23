<?php defined('BASEPATH') or exit('No direct script access allowed');

class Item extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['item_m', 'category_m', 'unit_m']);
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
            $row[] = '<a href="'.base_url('item/item_stock_detail/').$item->item_code.'">'.$item->stock.'</a>';
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

        // $item = new stdClass();
        // $item->item_code = null;
        // $item->item_id = null;
        // $item->barcode = null;
        // $item->name = null;
        // $item->price = null;
        // $item->category_id = null;
        // $query_category = $this->category_m->get();
        // $query_unit = $this->unit_m->get();

        // $unit[null] = '- Pilih -';
        // foreach ($query_unit->result() as $unt) {
        //     $unit[$unt->unit_id] = $unt->name;
        // }


        // $tax = $this->db->query("SELECT * FROM tax");

        $data =  array(
            'item' => $this->item_m->get_item(),
        );

        $this->template->load('template', 'product/item/item_data', $data);
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
                'tax' =>$tax,
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

    function item_stock_detail($item_code){
        $item = $this->db->query("select t1.*, t2.name as item_name 
        from p_item_detail t1
        inner join p_item t2 on t1.item_code = t2.item_code
        where t1.item_code = '$item_code'");
        $data = array(
            'item_code' => $item_code,
            'item'=>$item 
        );
        $this->template->load('template', 'product/item/item_stock_detail_v',$data);
    }
}
