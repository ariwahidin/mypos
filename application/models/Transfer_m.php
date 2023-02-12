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
        $docnum = 'DG' . date('Ymd') . $no;
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

    function simpan_transfer_stockin($doc_id)
    {
        $cart = $this->get_cart_transfer_stockin();
        $row = array();
        foreach ($cart->result() as $data) {
            $params = [
                'doc_id' => $doc_id,
                'docnum_transfer' => $data->docnum,
                'whs_code' => $data->whs_code_rec,
                'item_id' => $this->db->query("select item_id from p_item where item_code = '$data->item_code'")->row()->item_id,
                'barcode' => $data->barcode,
                'item_code' => $data->item_code,
                'type' => 'in',
                'detail' => 'stock in',
                'info' => 'transfer stock in',
                'qty' => $data->qty,
                'expired_date' => $data->exp_date,
                'user_id' => $this->session->userdata('userid'),
            ];
            array_push($row, $params);
        }
        $this->db->insert_batch('t_stock', $row);
    }

    function update_stock_detail($doc_id)
    {
        // var_dump($doc_id);
        $data = $this->db->query("select t2.item_id, t1.item_code, t1.barcode, t2.name, t1.qty, t1.expired_date as exp_date from t_stock t1 
        inner join p_item t2 on t1.item_code = t2.item_code 
        where t1.doc_id = '$doc_id'")->result();

        foreach ($data as $dt) {
            $cek = $this->db->query("select * from p_item_detail where item_code = '$dt->item_code' and exp_date = '$dt->exp_date'");
            if ($cek->num_rows() > 0) {
                $this->db->query("update p_item_detail set qty = qty + '$dt->qty' where item_code = '$dt->item_code'");
            } else {
                $params = array(
                    'item_id' => $dt->item_id,
                    'item_code' => $dt->item_code,
                    'barcode' => $dt->barcode,
                    'name' => $dt->name,
                    'qty' => $dt->qty,
                    'exp_date' => $dt->exp_date,
                    'created_by' => $this->session->userdata('userid')
                );
                $this->db->insert('p_item_detail', $params);
            }
        }
    }


    function simpan_transfer_stock_in(){
        $params = array(
            'docnum',
            'whs_code_rec',
            'whs_code_send',
            'type_transfer' => 'in',
            'created_by' => $this->session->userdata('userid')
        );
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

    public function insert_transfer($post, $nomor_transfer)
    {
        $docnum = $nomor_transfer;
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

    public function insert_transfer_detail($data)
    {
        $this->db->insert('tb_transfer_stock_detail', $data);
    }

    function update_qty_p_item_detail($params)
    {
        $qty = $params['qty'];
        $id_item_detail = $params['id_item_detail'];
        $sql = "UPDATE p_item_detail set qty = qty - '$qty' where id ='$id_item_detail '";
        $this->db->query($sql);
    }

    public function delete_cart_transfer()
    {
        $user_id = $this->session->userdata('userid');
        $sql = "delete from t_cart_transfer_stockout where created_by = '$user_id'";
        $this->db->query($sql);
    }

    public function insert_cart($data)
    {
        $row = array();
        foreach ($data as $p) {
            $params = array(
                'docnum' => $p->docnum,
                'whs_code_send' => $p->whs_code_send,
                'whs_code_rec' => $p->whs_code_rec,
                'item_code' => $p->item_code,
                'barcode' => $p->barcode,
                'item_name' => $p->ItemName,
                'exp_date' => $p->exp_date,
                'qty' => $p->qty,
                'created_by' => $p->created_by,
                'created_at' => $p->created,
                'user_id' => $this->session->userdata('userid')
            );
            array_push($row, $params);
        }
        $query = $this->db->insert_batch('t_cart_transfer_stockin', $row);
    }

    public function get_cart_transfer_stockin()
    {
        $user_id = $this->session->userdata('userid');
        $query = $this->db->query("select * from t_cart_transfer_stockin where user_id = '$user_id'");
        return $query;
    }

    public function delete_cart_transfer_stockin()
    {
        $user_id = $this->session->userdata('userid');
        $query = $this->db->query("delete from t_cart_transfer_stockin where user_id = '$user_id'");
        return $query;
    }

    public function add_stock_in($post)
    {
        // var_dump($post);
        // die;
        $params = array();
        for ($i = 0; $i < count($post['item_code']); $i++) {
            $item_code = $post['item_code'][$i];
            $params = [
                'docnum' => $post['docnum'][$i],
                'whs_code' => $post['whs_code'][$i],
                'item_id' => $this->db->query("select item_id from p_item where item_code = '$item_code'")->row()->item_id,
                'barcode' => $post['barcode'][$i],
                'item_code' => $item_code,
                'type' => 'in',
                'detail' => 'stock in',
                'qty' => $post['qty_ed'][$i],
                'expired_date' => $post['exp_date'][$i],
                'user_id' => $this->session->userdata('userid'),
            ];
            //var_dump($params);
            $this->db->insert('t_stock', $params);
        };
        // die;
    }

    public function get_data_transfer_stock_out()
    {
        $sql = "select t1.docnum, t2.whs_name as tujuan,t1.type_transfer,
        sum(t4.qty) as total_qty, t3.name, t1.created  
        from tb_transfer_stock t1
        inner join master_gudang t2 on t1.whs_code_rec  = t2.whs_code 
        inner join user t3 on t1.created_by = t3.user_id 
        inner join tb_transfer_stock_detail t4 on t1.docnum = t4.docnum 
        group by t4.docnum 
        order by t1.created desc";

        $query = $this->db->query($sql);

        return $query;
    }

    public function get_data_transfer_in()
    {
        $sql = "select distinct  
        t1.docnum_transfer as docnum, t2.whs_name as pengirim,
        t1.type, t3.name as user, sum(t1.qty) as total_qty, t1.created 
        from t_stock t1
        inner join master_gudang t2 on t1.whs_code = t2.whs_code
        inner join user t3 on t1.user_id = t3.user_id
        where t1.info = 'transfer stock in'
        group by t1.docnum_transfer, t1.created
        order by t1.created desc";
        $query = $this->db->query($sql);
        return $query;
    }
}
