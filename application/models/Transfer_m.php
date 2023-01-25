<?php defined('BASEPATH') or exit('No direct script access allowed');

class Transfer_m extends CI_Model
{
    public function docnum()
    {
        $sql = "SELECT MAX(MID(docnum,11,4)) AS docnum 
        FROM tb_transfer_stock 
        WHERE MID(docnum,3,8) = DATE_FORMAT(CURDATE(),'%Y%m%d')";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $n = ((int)$row->docnum) + 1;
            $no = sprintf("%'.04d", $n);
        } else {
            $no = "0001";
        }
        
        // $kode_toko = $this->db->query("SELECT code_store FROM t_toko WHERE is_active = 'y'")->row()->code_store;
        $docnum = 'DG'. date('Ymd') . $no;
        return $docnum;
    }

    // public function stock_out_code()
    // {
    //     $sql = "SELECT MAX(MID(stock_code,16,4)) AS stock_code 
    //     FROM t_header_stock 
    //     WHERE MID(stock_code,10,6) = DATE_FORMAT(CURDATE(),'%y%m%d')";
    //     $query = $this->db->query($sql);

    //     if ($query->num_rows() > 0) {
    //         $row = $query->row();
    //         $n = ((int)$row->stock_code) + 1;
    //         $no = sprintf("%'.04d", $n);
    //     } else {
    //         $no = "0001";
    //     }

    //     $kode_toko = $this->db->query("SELECT code_store FROM t_toko WHERE is_active = 'y'")->row()->code_store;
    //     $stock_code = $kode_toko . '-OUT-'. date('ymd') . $no;
    //     return $stock_code;
    // }

    public function add_cart($post)
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

        $this->db->insert('t_cart_transfer_stockout', $params);
    }

    public function update_cart($post)
    {
        $id_item_detail = $post['item_id_detail'];
        $qty = 1;

        $qty_cart = $this->db->query("select qty from t_cart_transfer_stockout where item_id_detail = '$id_item_detail'")->row()->qty;

        $qty_tot = $qty_cart + $qty;

        $stock = $this->db->query("select qty from p_item_detail where id = '$id_item_detail'")->row()->qty;

        if ($qty_tot <= $stock) {
            $sql = "update t_cart_transfer_stockout set qty = qty + '$qty' where item_id_detail = '$id_item_detail'";
            $query = $this->db->query($sql);
        }
    }

    public function get_cart($id_item_detail = null)
    {
        $user_id = $this->session->userdata('userid');
        $sql = "select t1.*, t2.item_code, t2.barcode, t2.name, t3.qty as stock from t_cart_transfer_stockout t1
        inner join p_item t2 on t1.item_id = t2.item_id
        inner join p_item_detail t3 on t1.item_id_detail = t3.id
        where t1.created_by = '$user_id'";

        if ($id_item_detail != null) {
            $sql .= " and t1.item_id_detail = $id_item_detail";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    public function update_qty($post)
    {
        // var_dump($post);
        $this->db->set('qty', $post['qty']);
        $this->db->where('id', $post['id_cart']);
        $this->db->update('t_cart_transfer_stockout');
    }

    public function delete_cart($post)
    {
        $this->db->where('id', $post['cart_id']);
        $this->db->delete('t_cart_transfer_stockout');
    }

    public function insert_transfer($post)
    {
        $docnum = $this->docnum();
        $whs_code_rec = $post['whs_code'];
        $whs_code_send = $this->db->query("select whs_code from t_toko where is_active = 'y'")->row()->whs_code;
        $type = 'out';
        $user_id = $this->session->userdata('userid');

        $params = array(
            'docnum' => $docnum,
            'whs_code_rec' => $whs_code_rec,
            'whs_code_send' => $whs_code_send,
            'type_transfer' => $type,
            'created_by' => $user_id,
        );

        $this->db->insert('tb_transfer_stock', $params);
        return $this->db->insert_id();
    }

    public function insert_transfer_detail($data){
        $this->db->insert('tb_transfer_stock_detail', $data);
    }

    function update_qty_p_item_detail($params)
    {
        $qty = $params['qty'];
        $id_item_detail = $params['id_item_detail'];
        $sql = "UPDATE p_item_detail set qty = qty - '$qty' where id ='$id_item_detail '";
        $this->db->query($sql);
    }

    public function delete_cart_transfer(){
        $user_id = $this->session->userdata('userid');
        $sql = "delete from t_cart_transfer_stockout where created_by = '$user_id'";
        $this->db->query($sql);
    }

    // public function update_qty_min_p_item_detail($params){
    //     $item_id_detail = $params['item_id_detail'];
    //     $qty = $params['qty'];
    //     $sql = "update p_item_detail set qty = qty - '$qty' where id = '$item_id_detail'";
    //     $this->db->query($sql);
    // }

    // public function update_qty_min_p_item($params){
    //     $item_code = $params['item_code'];
    //     $qty = $params['qty'];
    //     $sql = "update p_item set stock = stock - '$qty' where item_code = '$item_code'";
    //     $this->db->query($sql);
    // }

    // public function delete_cart_stock_out($params){
    //     $user_id = $params['user_id'];
    //     $sql = "delete from t_cart_stockout where created_by = '$user_id'";
    //     $this->db->query($sql);
    // }
}
