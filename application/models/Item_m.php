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
        $sql = "select item_id, item_code, barcode, name,harga_jual, sum(stock) as stock from
        (
        select t1.item_id, t1.item_code, t1.barcode, t1.name, t1.harga_jual, case when t2.qty is null then 0 else t2.qty end as stock
        from p_item t1
        left join p_item_detail t2 on t1.item_code = t2.item_code
        )ss
        group by item_code
        order by stock desc";
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
}
