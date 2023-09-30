<?php defined('BASEPATH') or exit('No direct script access allowed');

class Produksi_m extends CI_Model
{

    public function get_item_detail($barcode = null)
    {

        $sql = "select t1.*, t2.name as item_name , t2.harga_jual
		from p_item_detail t1
		inner join p_item t2 on t1.item_code = t2.item_code 
        where t1.qty > 0
        and t1.item_code not in(select item_code from p_item_produksi)";

        if ($barcode != null) {
            $sql .= " and t1.barcode = '$barcode'";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    public function get_item_detail_ready($post)
    {
        // var_dump($post);
        $item_id = $post['item_id'];
        $sql = "select t1.*, t2.name  from p_item_detail t1
        inner join p_item t2 on t1.item_id = t2.item_id 
        where t1.item_id = '$item_id'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function update_cart_ready($post)
    {
        // var_dump($post);
        $id_item_detail = $post['id_item_detail'];
        $item_id = $post['item_id'];
        $exp_date = $post['exp_date'];
        $cart_id = $post['cart_id'];
        $sql = "update t_cart_produksi set item_id_detail='$id_item_detail', exp_date = '$exp_date' where id = '$cart_id'";
        $this->db->query($sql);
    }

    public function get_item_produksi()
    {
        $sql = "select t1.*,t2.name as item_name from p_item_produksi t1
        inner join p_item t2 on t1.item_code = t2.item_code";
        $query = $this->db->query($sql);
        return $query;
    }

    public function insert_into_cart($post)
    {
        $user_id = $this->session->userdata('userid');
        $id_item_produksi = $post['item_produksi'];
        $sql = "insert into t_cart_produksi (item_id,qty,created_by)
        (select item_id, qty, '$user_id' from tb_item_produksi_detail t1 where id_item_produksi = '$id_item_produksi')";
        $this->db->query($sql);
    }

    public function get_item_produksi_exists()
    {
        $sql = "select t1.*, t2.name as item_name from tb_item_produksi t1
        inner join p_item t2 on t1.item_code = t2.item_code";
        $query = $this->db->query($sql);
        return $query;
    }

    function insert_tb_item_produksi($post)
    {
        $data = array(
            'item_code' => $post['item_produksi'],
            'created_by' => $this->session->userdata('userid')
        );
        $this->db->insert('tb_item_produksi', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function insert_tb_item_produksi_detail($params)
    {
        $this->db->insert('tb_item_produksi_detail', $params);
    }

    function insert_p_item_detail($post, $id)
    {
        $item_code = $post['item_produksi'];
        $p_item = $this->db->query("select * from p_item where item_code = '$item_code'");
        $item_id = $p_item->row()->item_id;
        $barcode = $p_item->row()->barcode;
        $name = $p_item->row()->name . ' (' . $p_item->row()->item_code . '-' . $id . ')';
        $params = array(
            'item_id' => $item_id,
            'item_code' => $item_code,
            'barcode' => $barcode,
            'name' => $name,
            'qty' => $post['qty_item_produksi'],
            'exp_date' => $post['exp_date'],
            'created_by' => $this->session->userdata('userid'),
        );
        $this->db->insert('p_item_detail', $params);
        // var_dump($this->db->error());
    }

    function update_qty_p_item_detail($params)
    {
        $qty = $params['qty'];
        $id_item_detail = $params['id_item_detail'];
        $sql = "UPDATE p_item_detail set qty = qty - '$qty' where id ='$id_item_detail '";
        $this->db->query($sql);
    }

    function delete_cart_produksi()
    {
        $id_user = $this->session->userdata('userid');
        $sql = "delete from t_cart_produksi where created_by = '$id_user'";
        $this->db->query($sql);
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

    public function get_cart_produksi_ready($id_item_detail = null)
    {
        $user_id = $this->session->userdata('userid');
        $sql = "select t1.*, t2.item_code, t2.barcode, t2.name from t_cart_produksi t1
        inner join p_item t2 on t1.item_id = t2.item_id
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
