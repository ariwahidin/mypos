<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi_m extends CI_Model {


    public function get_item_produksi(){
        $sql ="select t1.*,t2.name as item_name from p_item_produksi t1
        inner join p_item t2 on t1.item_code = t2.item_code";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_cart_produksi($id_item_detail = null)
    {
        $user_id = $this->session->userdata('userid');
        $sql = "select t1.*, t2.item_code, t2.barcode, t2.name, t3.qty as stock from t_cart_produksi t1
        inner join p_item t2 on t1.item_id = t2.item_id
        inner join p_item_detail t3 on t1.item_id_detail = t3.id
        where t1.created_by = '$user_id'";

        if ($id_item_detail != null) {
            $sql .= " and t1.item_id_detail = $id_item_detail";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    public function update_cart_produksi($post)
    {
        $id_item_detail = $post['item_id_detail'];
        $qty = 1;

        $qty_cart = $this->db->query("select qty from t_cart_produksi where item_id_detail = '$id_item_detail'")->row()->qty;

        $qty_tot = $qty_cart + $qty;

        $stock = $this->db->query("select qty from p_item_detail where id = '$id_item_detail'")->row()->qty;

        if ($qty_tot <= $stock) {
            $sql = "update t_cart_produksi set qty = qty + '$qty' where item_id_detail = '$id_item_detail'";
            $query = $this->db->query($sql);
        }
    }

    public function delete_cart($post)
    {
        $this->db->where('id', $post['cart_id']);
        $this->db->delete('t_cart_produksi');
    }

    public function update($post)
    {
        $this->db->set('qty', $post['qty']);
        $this->db->where('id', $post['id_cart']);
        $this->db->update('t_cart_produksi');
    }

    public function add_cart_produksi($post)
    {

        $id_item_detail = $post['item_id_detail'];
        $item_detail = $this->db->query("select * from p_item_detail where id = '$id_item_detail'");
        $item_id = $item_detail->row()->item_id;
        $item_code = $item_detail->row()->item_code;
        $barcode = $item_detail->row()->barcode;
        $exp_date = $item_detail->row()->exp_date;
        $qty = 1;

        $params = array(
            'item_id' => $item_id,
            'item_id_detail' => $id_item_detail,
            'qty' => $qty,
            'exp_date' => $exp_date,
            'created_by' => $this->session->userdata('userid'),
        );

        $this->db->insert('t_cart_produksi', $params);
    }

}