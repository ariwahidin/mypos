<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sale_m extends CI_Model
{

    public function invoice_no()
    {
        $sql = "SELECT MAX(MID(invoice,12,4)) AS invoice_no 
        FROM t_sale 
        WHERE MID(invoice,6,6) = DATE_FORMAT(CURDATE(),'%y%m%d')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $n = ((int)$row->invoice_no) + 1;
            $no = sprintf("%'.04d", $n);
        } else {
            $no = "0001";
        }
        $kode_toko = $this->db->query("SELECT code_store FROM t_toko WHERE is_active = 'y'")->row()->code_store;
        $invoice = $kode_toko . '-' . date('ymd') . $no;
        return $invoice;
    }

    public function cek_stok_cukup($post)
    {
        // var_dump($post);
        // die;
        $item_id_detail = $post['item_id_detail'];
        $stock = $this->db->query("select * from p_item_detail where id = '$item_id_detail'")->row()->qty;
        $qty = $post['qty'];
        $sql = "select * from t_cart where item_id_detail = '$item_id_detail'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            if ($stock <= $query->row()->qty) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function get_cart($params = null)
    {
        $this->db->select('t_cart.*, p_item.barcode, p_item_detail.qty as stock, p_item.name as item_name, t_cart.price as cart_price');
        $this->db->from('t_cart');
        $this->db->join('p_item', 't_cart.item_id = p_item.item_id', 'left');
        $this->db->join('p_item_detail', 't_cart.item_id_detail = p_item_detail.id', 'left');
        if ($params != null) {
            $this->db->where($params);
        }
        $this->db->where('user_id', $this->session->userdata('userid'));
        $query = $this->db->get();
        // var_dump($this->db->error());
        return $query;
    }

    public function get_item_detail($barcode = null)
    {

        // $sql = "select t1.*, t2.name as item_name , t2.harga_jual
        // from p_item_detail t1
        // inner join p_item t2 on t1.item_code = t2.item_code 
        // where t1.qty > 0";

        // Query Diubah 30/05/2023
        // $sql = "select t1.id, t1.item_id, t1.item_code, t2.barcode, t2.name, t1.qty, 
        //         t1.exp_date, t1.created_by, t1.created_at,  t2.name as item_name , t2.harga_jual
        //         from p_item_detail t1
        //         inner join p_item t2 on t1.item_code = t2.item_code 
        //         where t1.qty > 0";

        $sql = "select t1.id, t1.item_id, t1.item_code, t2.barcode, t2.name, t1.qty, 
        t1.exp_date, t1.created_by, t1.created_at, 
        t2.name as item_name , t2.harga_jual, case when t3.discount is null then 0 else t3.discount end as discount
        from p_item_detail t1
        inner join p_item t2 on t1.item_code = t2.item_code
        left join p_item_discount t3 on t1.item_code  = t3.item_code and t1.exp_date = t3.exp_date 
        where t1.qty > 0";

        if ($barcode != null) {
            $sql .= " and t2.barcode = '$barcode'";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    public function add_cart($post)
    {
        $sql = "SELECT MAX(cart_id) AS cart_no FROM t_cart";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $cart_no = ((int)$row->cart_no) + 1;
        } else {
            $cart_no = "1";
        }

        $exp = str_replace("/", "-", $post['exp_date']);
        $date_expired = date('Y-m-d', strtotime($exp));
        $discount_item = (float)$post['price'] * ((float)$post['discount'] / 100);
        $price_after_discount = (float)$post['price'] - $discount_item;

        $params = array(
            'cart_id' => $cart_no,
            'item_id' => $post['item_id'],
            'item_id_detail' => $post['item_id_detail'],
            'price' => $post['price'],
            'qty' => $post['qty'],
            'discount_item' => $discount_item,
            'discount_percent' => (float)$post['discount'],
            'total' => ($price_after_discount * $post['qty']),
            'item_expired' => $date_expired,
            'item_expired_2' => $date_expired,
            'user_id' => $this->session->userdata('userid')
        );
        // var_dump($params);
        // die;
        $this->db->insert('t_cart', $params);

        // var_dump($this->db->error());
    }

    public function update_cart_qty($post)
    {
        // var_dump($post);
        // die;
        $sql = "UPDATE t_cart SET price = '$post[price]',
        qty = qty + '$post[qty]',
        total = ('$post[price]' - discount_item) * qty
        WHERE item_id_detail = '$post[item_id_detail]'";
        $this->db->query($sql);
    }

    public function del_cart($params = null)
    {
        if ($params != null) {
            $this->db->where($params);
        }
        $this->db->delete('t_cart');
    }

    public function edit_cart($post)
    {
        // var_dump($post);
        // die;
        // $id_cart = $post['cart_id'];
        // $item_id = $this->db->query("select item_id from t_cart where cart_id = '$id_cart'")->row()->item_id;
        $params = array(
            'price' => $post['price'],
            'qty' => $post['qty'],
            'discount_item' => $post['discount'],
            'total' => $post['total'],
            'item_expired_2' => date('Y-m-d', strtotime(str_replace('/', '-', $post['expired']))),
        );
        $this->db->where('cart_id', $post['cart_id']);
        $this->db->update('t_cart', $params);
    }

    public function get_total_item_value()
    {
        $userid = $this->session->userdata('userid');
        $sql = "select sum(total) as total_item_value from t_cart where user_id = '$userid'";
        $query = $this->db->query($sql);
        return $query->row()->total_item_value;
    }

    public function add_sale($post)
    {
        $params = array(
            'invoice' => $this->invoice_no(),
            'customer_id' => $post['customer_id'] == "" ? null : $post['customer_id'],
            'id_toko' => $this->db->query("SELECT id FROM t_toko WHERE is_active = 'y'")->row()->id,
            'total_price' => $post['subtotal'],
            'discount' => $post['discount'],
            'service' => $post['service'],
            'tax' => $post['grand_total'] - ($post['grand_total'] / (1 + ($this->db->query("select tax from tax")->row()->tax))),
            'final_price' => $post['grand_total'],
            'total_item_value' => $this->get_total_item_value(),
            'cash' => $post['total_bayar'],
            'total_bayar' => $post['total_bayar'],
            'remaining' => $post['change'],
            'type_bayar' => $post['type_bayar'],
            'nomor_kartu' => $post['nomor_kartu'],
            'nama_pemilik_kartu' => $post['nama_pemilik_kartu'],
            'note' => $post['note'],
            'date' => $post['date'],
            'user_id' => $this->session->userdata('userid'),
        );
        $this->db->insert('t_sale', $params);
        return $this->db->insert_id();
    }

    public function add_sale_detail($params)
    {
        // var_dump($params);
        // die();
        $this->db->insert_batch('t_sale_detail', $params);
        // var_dump($this->db->error());
        // die;
    }

    public function get_sale($id = null)
    {
        $sql = "select t_sale.*,customer.name as customer_name,
        sum(tsd.qty) as total_item, tb.type_bayar as type_pembayaran,
        user.username as user_name, user.name as nama_user, t_sale.created as sale_created
        from t_sale
        left join customer on t_sale.customer_id = customer.customer_id
        inner join user on t_sale.user_id = user.user_id
        inner join type_bayar tb on tb.id = t_sale.type_bayar
        inner join t_sale_detail tsd on tsd.sale_id = t_sale.sale_id";

        if ($id != null) {
            $sql .= " where t_sale.sale_id = '$id'";
        }

        $sql .= " group by sale_id";
        $sql .= " order by date desc";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_sale_pagination($limit = null, $start = null)
    {
        $post = $this->session->userdata('search');
        $this->db->select('*,customer.name as customer_name, user.username as user_name, t_sale.created as sale_created, type_bayar.type_bayar as type_bayar_name');
        $this->db->from('t_sale');
        $this->db->join('customer', 't_sale.customer_id = customer.customer_id', 'left');
        $this->db->join('user', 't_sale.user_id = user.user_id');
        $this->db->join('type_bayar', 't_sale.type_bayar = type_bayar.id');
        if (!empty($post['date1']) && !empty($post['date2'])) {
            $this->db->where("t_sale.date BETWEEN '$post[date1]' AND '$post[date2]'");
        }
        if (!empty($post['customer'])) {
            if ($post['customer'] == 'null') {
                $this->db->where("t_sale.customer_id IS NULL");
            } else {
                $this->db->where("t_sale.customer_id", $post['customer']);
            }
        }
        if (!empty($post['invoice'])) {
            $this->db->like("invoice", $post['invoice']);
        }
        $this->db->limit($limit, $start);
        $this->db->order_by('sale_id', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function get_sale_detail($sale_id)
    {

        $sql = "SELECT t2.item_code, t1.sale_id, t1.item_id, t2.barcode, t2.name, 
        t1.price, sum(t1.qty) as qty, avg(t1.discount_item) as discount_item, 
        sum(t1.total) as total  
        FROM t_sale_detail t1 
        JOIN p_item t2 ON t1.item_id = t2.item_id 
        WHERE t1.sale_id = '$sale_id'
        group by t2.item_code, t1.discount_item";
        // var_dump($sql);
        // die;

        $query = $this->db->query($sql);

        // print_r($this->db->last_query());
        // die;
        return $query;
    }

    public function get_sales_today_per_user()
    {
        $user_id = $this->session->userdata('userid');
        $sql = "select nama_toko, toko_cabang, item_name, price, sum(qty) as qty, sum(total_price) total_price, sum(total) as total, sum(discount_item) as discount_item, 
        sum(ss.total_discount_item) / sum(total_price) * 100 as discount_percent, 
        sum(ss.total_discount_item) as total_discount_item,
        avg(xx.total_service) as total_service, avg(xx.total_discount) as total_discount,
        ss.tanggal_transaksi, name, ss.user_id
        from
        (
        select t5.nama_toko, t5.toko_cabang, t1.item_id, t1.item_id_detail, t2.item_code, t2.barcode, t2.name as item_name, 
        t2.price, t1.qty, t2.price * t1.qty as total_price, t1.discount_item, t1.discount_item * t1.qty as total_discount_item,
        t1.total, date(t3.created) as tanggal_transaksi, t3.user_id, t4.name
        from t_sale_detail t1
        inner join p_item t2 on t2.item_id = t1.item_id
        inner join t_sale t3 on t3.sale_id = t1.sale_id
        inner join user t4 on t4.user_id  = t3.user_id
        inner join t_toko t5 on t5.id = t3.id_toko 
        where t3.user_id = '$user_id' and date(t3.created) = curdate()  
        order by t2.barcode desc
        )ss
        inner join
        (
        select user_id , date(created) as tanggal_transaksi, sum(service) as total_service, sum(discount) as total_discount from t_sale t1 
        where user_id = '$user_id' and date(created) = curdate()
        group by user_id 
        )xx
        on ss.user_id = xx.user_id 
        group by ss.item_code, ss.item_name, ss.price, ss.discount_item";

        // print_r($sql);
        // die;
        $query = $this->db->query($sql);
        return $query;
    }

    public function del_sale($id)
    {
        $this->db->where('sale_id', $id);
        $this->db->delete('t_sale');
    }

    public function del_sale_detail($sale_id)
    {
        $this->db->where('sale_id', $sale_id);
        $this->db->delete('t_sale_detail');
    }

    public function get_type_bayar()
    {
        $sql = "SELECT * FROM type_bayar";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_tax()
    {
        $sql = "SELECT * FROM tax";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_detail_penjualan($post)
    {
        // var_dump($post);
        // die;
        $sql = "select t1.invoice as invoice,t4.nama_toko, t4.toko_cabang, 
        t3.item_code,t3.barcode  ,t3.name as item_name, t2.qty, t2.price as price_item, 
        t2.discount_item, t2.total,t2.exp_date, t1.created as tanggal
        from t_sale t1
        inner join t_sale_detail t2 on t1.sale_id = t2.sale_id
        inner join p_item t3 on t2.item_id  = t3.item_id 
        inner join t_toko t4 on t1.id_toko = t4.id";

        if ($post['date1'] != '' && $post['date2'] != '' && $post['invoice'] == '') {
            $date1 = $post['date1'];
            $date2 = date('Y-m-d', strtotime($post['date2'] . "+1 days"));

            $sql .= " where t1.created between '$date1' and '$date2'";
        } else if ($post['date1'] != '' && $post['date2'] != '' && $post['invoice'] != '') {
            $date1 = $post['date1'];
            $date2 = date('Y-m-d', strtotime($post['date2'] . "+1 days"));
            $invoice = $post['invoice'];
            $sql .= " where t1.created between '$date1' and '$date2' and t1.invoice like '%$invoice%'";
        } else if ($invoice = $post['invoice'] != '') {
            $invoice = $post['invoice'];
            $sql .= " where t1.invoice like '%$invoice%'";
        }

        $sql .= " order by t1.invoice desc";

        $query = $this->db->query($sql);

        return $query;
    }

    public function get_summary_sales($post)
    {

        $sql = "select t1.invoice, t2.nama_toko , t2.toko_cabang, t1.total_item_value as subtotal, 
        t1.discount , t1.service , t1.tax , t1.final_price as grand_total,
        t3.type_bayar , t1.nomor_kartu, t1.nama_pemilik_kartu as nama, cast(t1.created as date) as tanggal
        from t_sale t1 
        inner join t_toko t2 on t1.id_toko = t2.id
        inner join type_bayar t3 on t1.type_bayar = t3.id";

        if ($post['date1'] != '' && $post['date2'] != '' && $post['invoice'] == '') {
            $date1 = $post['date1'];
            $date2 = date('Y-m-d', strtotime($post['date2'] . "+1 days"));
            $sql .= " where t1.created between '$date1' and '$date2'";
        } else if ($post['date1'] != '' && $post['date2'] != '' && $post['invoice'] != '') {
            $date1 = $post['date1'];
            $date2 = date('Y-m-d', strtotime($post['date2'] . "+1 days"));
            $invoice = $post['invoice'];
            $sql .= " where t1.created between '$date1' and '$date2' and t1.invoice like '%$invoice%'";
        } else if ($invoice = $post['invoice'] != '') {
            $invoice = $post['invoice'];
            $sql .= " where t1.invoice like '%$invoice%'";
        }

        $sql .= " order by t1.invoice desc";

        $query = $this->db->query($sql);
        return $query;
    }

    public function get_cms_bri($post)
    {
        $date1 = $_POST['date1'];
        $date2 = date('Y-m-d', strtotime($_POST['date2'] . "+1 days"));
        $sql = "select * from t_sale where created between '$date1' and '$date2'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_sales_daily()
    {
        $user_id = $this->session->userdata('userid');
        $sql = "select ss.barcode, ss.name as item_name, sum(ss.qty) as qty , sum(ss.total) as total, ss.tanggal
        from
        (select t1.sale_id, t2.barcode, t2.name, t1.qty, t1.total, date(t3.created) as tanggal  
        from t_sale_detail t1
        inner join p_item t2 on t1.item_id = t2.item_id 
        inner join t_sale t3 on t1.sale_id = t3.sale_id 
        where date(t3.created) = date(now())
        and t3.user_id = '$user_id'
        )ss
        group by ss.barcode";

        $query = $this->db->query($sql);
        return $query;
    }

    public function get_sum_daily()
    {
        $user_id = $this->session->userdata('userid');
        $sql = "select sum(discount) as total_discount, sum(service) as total_service, user_id, date(created) as tanggal 
        from t_sale t1
        where date(t1.created) = date(now()) and user_id = '$user_id'
        group by date(t1.created)";
        $query = $this->db->query($sql);
        return $query;
    }
}
