<?php defined('BASEPATH') or exit('No direct script access allowed');

class Stock_m extends CI_Model
{


    public function stock_doc_id()
    {
        $sql = "SELECT MAX(MID(doc_id,11,4)) AS doc_id 
        FROM t_stock 
        WHERE MID(doc_id,3,8) = DATE_FORMAT(CURDATE(),'%Y%m%d')";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $n = ((int)$row->doc_id) + 1;
            $no = sprintf("%'.04d", $n);
        } else {
            $no = "0001";
        }

        $doc_id = 'ST' . date('Ymd') . $no;
        return $doc_id;
    }

    public function get($id = null)
    {
        $this->db->from('t_stock');
        if ($id != null) {
            $this->db->where('stock_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function del($id)
    {
        $this->db->where('stock_id', $id);
        $this->db->delete('t_stock');
    }

    // public function get_stock_detail(){
    //     $sql = "select * from p_item_detail";
    //     $query = $this->db->query($sql);
    //     return $query;
    // }

    public function get_stock_detail($barcode = null)
    {
        $sql = "select t1.*, t2.name as item_name , t2.harga_jual
		from p_item_detail t1
		inner join p_item t2 on t1.item_code = t2.item_code 
        where t1.qty > 0";

        if ($barcode != null) {
            $sql .= " and t1.barcode = '$barcode'";
        }

        $query = $this->db->query($sql);
        return $query;
    }


    public function get_stock_in()
    {
        $this->db->select('t_stock.docnum,t_stock.whs_code, t_stock.stock_id, p_item.barcode,
        p_item.name as item_name, qty, date, detail,
        supplier.name as supplier_name, p_item.item_id, 
        t_stock.info, t_stock.expired_date, t_stock.created');
        $this->db->from('t_stock');
        $this->db->join('p_item', 't_stock.item_id = p_item.item_id');
        $this->db->join('supplier', 't_stock.supplier_id = supplier.supplier_id', 'left');
        $this->db->where('type', 'in');
        $this->db->order_by('stock_id', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function cek_docnum($post)
    {
        // var_dump($post);
        $docnum = $post['docnum'][0];
        $sql = "select * from t_stock where docnum = '$docnum'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function cek_item_code_not_exists($post)
    {
        // var_dump($post);
        $item_code_not_exists = array();
        for ($i = 0; $i < count($post['item_code']); $i++) {
            $item_code = $post['item_code'][$i];
            $cek = $this->db->query("SELECT item_id FROM p_item WHERE item_code = '$item_code'")->num_rows();
            if ($cek < 1) {
                array_push($item_code_not_exists, $item_code);
            }
        }
        return $item_code_not_exists;
    }


    public function cek_barcode_not_exists($post)
    {
        // var_dump($post);
        $barcode_not_exists = array();
        for ($i = 0; $i < count($post['item_code']); $i++) {
            $barcode = $post['barcode'][$i];
            $cek = $this->db->query("SELECT item_id FROM p_item WHERE barcode = '$barcode'")->num_rows();
            if ($cek < 1) {
                array_push($barcode_not_exists, $barcode);
            }
        }
        return $barcode_not_exists;
    }

    public function add_stock_in($post)
    {
        $row = array();
        $doc_id = $this->stock_doc_id();
        for ($i = 0; $i < count($post['item_code']); $i++) {
            $item_code = $post['item_code'][$i];
            $params = [
                'doc_id' => $doc_id,
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
            array_push($row, $params);
        };
        $this->db->insert_batch('t_stock', $row);
    }

    public function simpan_item_detail($post)
    {
        $params = array();
        for ($i = 0; $i < count($post['item_code']); $i++) {
            $item_code = $post['item_code'][$i];
            $expired_date = $post['exp_date'][$i];
            $qty = $post['qty_ed'][$i];
            $params = [
                // 'docnum' => $post['docnum'][$i],
                // 'whs_code' => $post['whs_code'][$i],
                'item_id' => $this->db->query("select item_id from p_item where item_code = '$item_code'")->row()->item_id,
                'item_code' => $item_code,
                'barcode' => $post['barcode'][$i],
                'qty' => $qty,
                'exp_date' => $expired_date,
            ];
            $cek_expired_date_is_same = $this->db->query("select * from p_item_detail where item_code = '$item_code' and exp_date = '$expired_date'");
            if ($cek_expired_date_is_same->num_rows() > 0) {
                $this->db->query("update p_item_detail set qty = qty + $qty where item_code = '$item_code' and exp_date ='$expired_date'");
            } else {
                $this->db->insert('p_item_detail', $params);
            }
        };
    }

    function update_stock_in($post)
    {
        for ($i = 0; $i < count($post['item_code']); $i++) {
            $qty = $post['qty_ed'][$i];
            $item_code = $post['item_code'][$i];
            $id = $this->db->query("select item_id from p_item where item_code = '$item_code'")->row()->item_id;
            $exp_date = date('Y-m-d', strtotime($post['exp_date'][$i]));
            $date = international_date_time();
            $sql = "UPDATE p_item 
                    SET stock = stock + '$qty',
                    exp_date = '$exp_date',
                    updated = '$date', 
                    updated_info = 'stock_in' 
                    WHERE item_id = '$id'";
            $this->db->query($sql);
        }
    }

    public function get_stock_out()
    {
        $this->db->select('t_stock.stock_id, p_item.barcode,
        p_item.name, qty, date, detail, p_item.item_id, 
        t_stock.info, t_stock.expired_date, t_stock.created');
        $this->db->from('t_stock');
        $this->db->join('p_item', 't_stock.item_id = p_item.item_id');
        $this->db->where('type', 'out');
        $this->db->order_by('stock_id', 'desc');
        $query = $this->db->get();
        // var_dump($this->db->error());
        // die;
        return $query;
    }

    public function add_stock_out($post)
    {
        $params = [
            'item_id' => $post['item_id'],
            'type' => 'out',
            'detail' => $post['detail'],
            'qty' => $post['qty'],
            'date' => $post['date'],
            'user_id' => $this->session->userdata('userid'),
        ];
        $this->db->insert('t_stock', $params);
    }

    public function insert_stock_out_produksi($post, $id_produksi)
    {
        $item_code = $post['item_produksi'];
        $qty = $post['qty_item_produksi'];
        $exp_date = $post['exp_date'];
        $item_id = $this->db->query("select item_id from p_item where item_code ='$item_code'")->row()->item_id;
        $barcode = $this->db->query("select barcode from p_item where item_id = '$item_id'")->row()->barcode;
        $doc_id = $this->stock_doc_id();
        $params = array(
            'doc_id' => $doc_id,
            'item_code' => $item_code,
            'item_id' => $item_id,
            'barcode' => $barcode,
            'id_item_produksi' => $id_produksi,
            'type' => 'in',
            'detail' => 'stock in',
            'info' => 'stock in produksi',
            'qty' => $qty,
            'expired_date' => $exp_date,
            'user_id' => $this->session->userdata('userid'),
        );
        $this->db->insert('t_stock', $params);
    }

    // public function get_stock_in_data(){
    //     $sql = "select t1.*, t2.name as item_name from t_stock t1
    //     inner join p_item t2 on t1.item_id = t2.item_id
    //     where t1.type = 'in'";
    //     $query = $this->db->query($sql);
    //     return $query;
    // }
}
