<?php defined('BASEPATH') or exit('No direct script access allowed');

class Bonus extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        // $this->load->model(['bonnus_m']);
    }

    public function index()
    {
        $sql = "select t1.*, t2.item_code, t3.name, t3.harga_jual from tb_event t1 
        inner join tb_item_bonus t2 on t1.id_event = t2.id_event  
        inner join p_item t3 on t2.item_code = t3.item_code";

        $bonus = $this->db->query($sql);

        $item = $this->db->query("select item_id, item_code, name from p_item");
        $data = array(
            'bonus' => $bonus,
            'item' => $item
        );
        $this->template->load('template', 'toko/bonus_v', $data);
    }

    public function edit(){
        $post = $_POST;
        $start_date = date('Y-m-d h:i:s', strtotime(str_replace("/","-",$post['start_periode'])));
        $end_date = date('Y-m-d h:i:s', strtotime(str_replace("/","-",$post['end_periode'])));

        $data_edit = array(
            'min_sales' => $post['min_belanja'],
            'start_periode' => $start_date,
            'end_periode' => $end_date,
            'is_active' => $post['status'],
            'created_by' => $this->session->userdata('userid'),
            'created' => date('Y-m-d'),
        );

        $this->db->where('id_event', $post['id_event']);
        $this->db->update('tb_event', $data_edit);

        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('success', 'Edit Berhasil');
        }else{
            $this->session->set_flashdata('error', 'Gagal Edit');
        }

        redirect('bonus');
    }
}
