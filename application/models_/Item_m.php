<?php defined('BASEPATH') or exit('No direct script access allowed');

class Item_m extends CI_Model
{

    // start datatables
    var $column_order = array(null, 'item_code', 'barcode', 'p_item.name', 'category_name', 'unit_name', 'price', 'stock', 'image'); //set column field database for datatable orderable
    var $column_search = array('item_code', 'barcode', 'p_item.name', 'harga_jual', 'harga_bersih', 'p_category.name'); //set column field database for datatable searchable
    var $order = array('stock' => 'desc'); // default order

    private function _get_datatables_query()
    {
        // var_dump($_POST);
        // die;
        $this->db->select('p_item.*, p_category.name as category_name, p_unit.name as unit_name');
        $this->db->from('p_item');
        $this->db->join('p_category', 'p_item.category_id = p_category.category_id');
        $this->db->join('p_unit', 'p_item.unit_id = p_unit.unit_id');
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_item()
    {
        $sql = "select item_id, item_code, barcode, name,harga_jual, sum(stock) as stock, ss.min_stock from
        (
        select t1.item_id, t1.item_code, t1.barcode, t1.name, t1.harga_jual,t1.min_stock, 
        case when t2.qty is null then 0 else t2.qty end as stock
        from p_item t1
        left join p_item_detail t2 on t1.item_code = t2.item_code
        order by t1.item_code
        )ss
        group by item_code
        order by stock desc";
        $query = $this->db->query($sql);
        return $query;
    }


    function get_suggest_qty($item_code = null)
    {
        $sql = "select * from 
        (
        select item_id, item_code, barcode, name,harga_jual, sum(stock) as stock, ss.min_stock, ss.min_stock -  sum(stock) as suggest_qty
        from
        (
        select t1.item_id, t1.item_code, t1.barcode, t1.name, t1.harga_jual,t1.min_stock, 
        case when t2.qty is null then 0 else t2.qty end as stock
        from p_item t1
        left join p_item_detail t2 on t1.item_code = t2.item_code
        order by t1.item_code
        )ss
        group by item_code
        order by stock desc
        )xx
        where xx.suggest_qty > 0";
        if ($item_code != null) {
            $s = implode("','", $item_code);
            $sql .= " AND xx.item_code IN('$s')";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    function add_cart($item_selected)
    {
        // var_dump($item_selected);
        foreach ($item_selected->result() as $data) {

            $cek = $this->db->get_where('t_cart_suggest_order', ['item_code' => $data->item_code]);

            if ($cek->num_rows() > 0) {
                // item sudah ada
            } else {
                $params = array(
                    'item_code' => $data->item_code,
                    'barcode' => $data->barcode,
                    'item_name' => $data->name,
                    'stock' => $data->stock,
                    'min_stock' => $data->min_stock,
                    'suggest_qty' => $data->suggest_qty,
                    'qty_order' => $data->suggest_qty,
                    'created_by' => $this->session->userdata('userid')
                );
                $this->db->insert('t_cart_suggest_order', $params);
            }
        }
    }

    function delete_cart($id = null)
    {
        $user_id = $this->session->userdata('userid');
        $sql = "DELETE FROM t_cart_suggest_order WHERE created_by = '$user_id'";
        if ($id != null) {
            $sql .= " AND id = '$id'";
        }
        $this->db->query($sql);
    }

    function simpan_order_stock($nomor_order)
    {
        $cart = $this->get_cart_order();
        $row = array();
        foreach ($cart->result() as $data) {
            $params = array(
                'no_order' => $nomor_order,
                'item_code' => $data->item_code,
                'barcode' => $data->barcode,
                'item_name' => $data->item_name,
                'stock' => $data->stock,
                'min_stock' => $data->min_stock,
                'qty_order' => $data->qty_order,
                'created_by' => $data->created_by
            );
            array_push($row, $params);
        }
        $this->db->insert_batch('tb_stock_order', $row);
    }

    function get_item_order()
    {
        $sql = "select distinct t1.no_order, t2.name, t1.created, t1.is_approve  
        from tb_stock_order t1
        inner join user t2 on t1.created_by = t2.user_id
        order by t1.created desc";
        // $sql = "select t1.*, t2.name as user  from tb_stock_order t1
        // inner join user t2 on t1.created_by = t2.user_id 
        // order by t1.created desc ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_cart_order()
    {
        $user_id = $this->session->userdata('userid');
        $sql = "SELECT t1.*, t2.name as user FROM t_cart_suggest_order t1 INNER JOIN user t2 on t1.created_by = t2.user_id where t1.created_by = '$user_id'";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all()
    {
        $this->db->from('p_item');
        return $this->db->count_all_results();
    }
    // end datatables

    public function get($id = null)
    {
        $this->db->select('p_item.*, p_category.name as category_name, p_unit.name as unit_name');
        $this->db->from('p_item');
        $this->db->join('p_category', 'p_category.category_id = p_item.category_id');
        $this->db->join('p_unit', 'p_unit.unit_id = p_item.unit_id');
        if ($id != null) {
            $this->db->where('item_id', $id);
        }
        // $this->db->order_by('stock', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function get_barcode($barcode = null)
    {
        $this->db->select('p_item.*, p_category.name as category_name, p_unit.name as unit_name');
        $this->db->from('p_item');
        $this->db->join('p_category', 'p_category.category_id = p_item.category_id');
        $this->db->join('p_unit', 'p_unit.unit_id = p_item.unit_id');
        if ($barcode != null) {
            $this->db->where('barcode', $barcode);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        // var_dump($post);
        // die;
        $params = [
            'item_code' => $post['item_code'],
            'barcode' => $post['barcode'],
            'name' => $post['product_name'],
            'item_name_toko' => $post['item_name_toko'],
            'packing' => $post['packing'],
            'category_id' => $post['category'],
            'unit_id' => $post['unit'],
            'price' => $post['harga_bersih'],
            'harga_jual' => $post['harga_jual'],
            'harga_bersih' => $post['harga_bersih'],
            'image' => $post['image'],
        ];

        // var_dump($params);
        // die;
        $this->db->insert('p_item', $params);
    }

    public function add_all_item($params)
    {
        $this->db->insert_batch('p_item', $params);
    }

    public function edit($post)
    {

        // var_dump($post);
        // die;
        $params = [
            'item_code' => $post['item_code'],
            'barcode' => $post['barcode'],
            'name' => $post['product_name'],
            'item_name_toko' => $post['product_name'],
            'packing' => $post['packing'],
            'category_id' => $post['category'],
            'unit_id' => $post['unit'],
            // 'price' => $post['harga_bersih'],
            // 'harga_jual' => $post['harga_jual'],
            // 'harga_bersih' => $post['harga_bersih'],
            'updated' => date('Y-m-d H:i:s')
        ];
        if ($post['image'] != null) {
            $params['image'] = $post['image'];
        }
        $this->db->where('item_id', $post['id']);
        $this->db->update('p_item', $params);
    }

    public function sinkronisasi($post)
    {
        // var_dump($post);
        // die;
        $params = [
            'price' => $post['harga_bersih'],
            'harga_jual' => $post['harga_jual'],
            'harga_bersih' => $post['harga_bersih'],
            'updated' => date('Y-m-d H:i:s')
        ];
        $this->db->update('p_item', $params, ['barcode' => $post['barcode']]);
        // var_dump($this->db->last_query());
        // die;
    }

    function check_barcode($code, $id = null)
    {
        $this->db->from('p_item');
        $this->db->where('barcode', $code);
        if ($id != null) {
            $this->db->where('item_id !=', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    function check_item_code($item_code, $id = null)
    {
        $this->db->from('p_item');
        $this->db->where('item_code', $item_code);
        if ($id != null) {
            $this->db->where('item_id !=', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    function check_harga_sama($item_code, $harga_jual, $harga_bersih)
    {
        $params = array(
            'item_code' => $item_code,
            'price' => $harga_jual,
            'harga_jual' => $harga_jual,
            'harga_bersih' => $harga_bersih
        );
        $query = $this->db->get_where('p_item', $params);
        var_dump($this->db->last_query());
        return $query;
    }

    function update_harga($item_code, $harga_jual, $harga_bersih)
    {
        $data = array(
            'price' => $harga_jual,
            'harga_jual' => $harga_jual,
            'harga_bersih' => $harga_bersih
        );

        $this->db->where('item_code', $item_code);
        $this->db->update('p_item', $data);
    }

    public function del($id)
    {
        $this->db->where('item_id', $id);
        $this->db->delete('p_item');
    }


    // function update_stock_in($data)
    // {
    //     $qty = $data['qty'];
    //     $id = $data['item_id'];
    //     $exp_date = date('Y-m-d', strtotime($data['exp_date']));
    //     $date = international_date_time();
    //     $sql = "UPDATE p_item 
    //     SET stock = stock + '$qty',
    //     exp_date = '$exp_date',
    //     updated = '$date', 
    //     updated_info = 'stock_in' 
    //     WHERE item_id = '$id'";
    //     $this->db->query($sql);
    // }

    function update_stock_out($data)
    {
        $qty = $data['qty'];
        $id = $data['item_id'];
        $date = international_date_time();
        $sql = "UPDATE p_item 
        SET stock = stock - '$qty', updated = '$date', updated_info = 'stock_out' 
        WHERE item_id = '$id'";
        $this->db->query($sql);
    }


    public function singkronisasi()
    {
        $item = $this->db->query("select * from t_cart_sync_item");
        $total_update = 0;
        $total_insert = 0;
        if ($item->num_rows() > 0) {
            foreach ($item->result() as $data) {
                $cek_barcode_exists = $this->db->query("select * from p_item where barcode = '$data->barcode'");
                if ($cek_barcode_exists->num_rows() > 0) {
                    $sql_update = "update p_item set item_code = '$data->item_code', name = '$data->item_name', 
                    min_stock = '$data->min_stock', item_name_toko = '$data->item_name', price = '$data->harga_jual', 
                    harga_jual = '$data->harga_jual', harga_bersih = '$data->harga_bersih' 
                    where barcode = '$data->barcode'";
                    $this->db->query($sql_update);
                    $total_update = $total_update + 1;
                } else {
                    $params =  array(
                        'item_code' => $data->item_code,
                        'barcode' => $data->barcode,
                        'name' => $data->item_name,
                        'min_stock' => $data->min_stock,
                        'item_name_toko' => $data->item_name,
                        'category_id' => '15',
                        'unit_id' => '5',
                        'price' => $data->harga_jual,
                        'harga_jual' => $data->harga_jual,
                        'harga_bersih' => $data->harga_bersih,
                    );
                    $this->db->insert('p_item', $params);
                    $total_insert = $total_insert + 1;
                }
            }
        }

        $result['total_update'] = $total_update;
        $result['total_insert'] = $total_insert;
        return $result;
    }

    function add_stock($post)
    {
        // var_dump($post);
        $item_code = $post['item_code'];
        $barcode = $post['barcode'];
        $item_name = $post['item_name'];
        $stock = $post['stock'];
        $exp_date = date('Y-m-d', strtotime($post['exp_date']));
        $user_id = $this->session->userdata('userid');
        $item_id = $this->db->query("select item_id from p_item where item_code = '$item_code'")->row()->item_id;
        $cek = $this->db->query("select * from p_item_detail where item_code = '$item_code' and exp_date = '$exp_date'");
        if ($cek->num_rows() > 0) {
            // update
            $sql = "update p_item_detail set qty = qty + '$stock' where item_code = '$item_code' and exp_date = '$exp_date'";
            $this->db->query($sql);
        } else {
            // insert
            $params = array(
                'item_id' => $item_id,
                'item_code' => $item_code,
                'barcode' => $barcode,
                'name' => $item_name,
                'qty' => $stock,
                'exp_date' => $exp_date,
                'created_by' => $user_id
            );
            $this->db->insert('p_item_detail', $params);
        }
    }

    function refresh_order($data)
    {
        $affected = 0;
        foreach ($data as $dt) {
            $data = array(
                'qty_order' => $dt->qty_order,
                'is_approve' => $dt->is_approve,
                'approve_by' => $dt->approved_by,
                'approve_at' => $dt->approved_at
            );

            $where = array(
                'no_order' => $dt->doc_id,
                'barcode' => $dt->barcode
            );

            $this->db->where($where);
            $this->db->update('tb_stock_order', $data);

            $affected += $this->db->affected_rows();
        }
        return $affected;
    }

    function get_detail_order($no_order)
    {
        $query = $this->db->get_where('tb_stock_order', array('no_order' => $no_order));
        return $query;
    }
}
