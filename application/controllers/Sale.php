<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sale extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model('sale_m');
		$this->load->model(['customer_m', 'item_m', 'supplier_m']);
	}

	public function index()
	{
		// $delete_cart_sale = $this->db->query("delete from t_cart");
		$customer = $this->customer_m->get()->result();
		$item = $this->sale_m->get_item_detail()->result();
		$cart = $this->sale_m->get_cart();
		$type_bayar = $this->sale_m->get_type_bayar();
		$tax = $this->sale_m->get_tax();
		$data = array(
			'customer' => $customer,
			'item' => $item,
			'cart' => $cart,
			'type_bayar' => $type_bayar,
			'tax' => $tax->row()->tax,
			'invoice' => $this->sale_m->invoice_no(),
		);
		// var_dump($this->db->error());
		$this->template->load('template', 'transaction/sale/sale_form', $data);
	}

	function check_event()
	{
		$check_event = $this->db->query("select * from tb_event where now() > start_periode and now() < end_periode ");
		if ($check_event->num_rows() > 0) {
			$id_event = $check_event->row()->id_event;
			$check_item_bonus = $this->db->query("select item_code from tb_item_bonus where id_event = '$id_event'");
			if ($check_item_bonus->num_rows() > 0) {
				$sql_cek = "select item_id_detail from t_cart
				where item_id_detail =  
				(select t2.id from tb_item_bonus t1 
				inner join p_item_detail t2 on t2.item_code = t1.item_code 
				where t1.id_event = '$id_event')";
				$item_id_detail_cart = $this->db->query($sql_cek);
				if ($item_id_detail_cart->num_rows() > 0) {
					$item_id_detail = $item_id_detail_cart->row()->item_id_detail;
					$user_id = $this->session->userdata('userid');
					$total_belanja = $this->db->query("select sum(total) as total_belanja from t_cart where user_id = '$user_id'")->row()->total_belanja;
					$min_belanja = $this->db->query("select min_sales from tb_event where id_event = '$id_event'")->row()->min_sales;
					$harga_item_bonusan = $this->db->query("select price from t_cart where item_id_detail = '$item_id_detail'")->row()->price;
					// var_dump($total_belanja);
					// var_dump($min_belanja);
					// var_dump($harga_item_bonusan);

					if (($total_belanja - $harga_item_bonusan) > $min_belanja) {
						// update t_cart 
						$update_cart = $this->db->query("update t_cart set discount_item = price, discount_percent = '100', total = '0' where item_id_detail = '$item_id_detail'");
						if($this->db->affected_rows() > 0){
							$params = array('success' => true);
							echo json_encode($params);
						}else{

						}
					} else {
						// minimal belanja tidak terpenuhi
					}

				} else {
					//tidak ada item bonus di cart
				}
			} else {
				//tidak ada item bonus
			}
		} else {
			//tidak ada event
		}
	}

	// function get_item()
	// {
	// 	$barcode = $this->input->post( 'barcode' );
	// 	$item = $this->item_m->get_barcode( $barcode )->row();

	// 	if ( $this->db->affected_rows() > 0 ) {
	// 		$item->exp_date = date( 'd/m/Y', strtotime( $item->exp_date ) );
	// convert indo date
	// 		$params = array( 'success' => true, 'item' => $item );
	// 	} else {
	// 		$params = array( 'success' => false );
	// 	}
	// 	echo json_encode( $params );
	// }

	function get_item_detail()
	{

		$item = $this->sale_m->get_item_detail($_POST['barcode']);


		if ($item->num_rows() > 0) {
			$params = array(
				'item' => $item->result(),
				'success' => true
			);
		} else {
			$params = array(
				'success' => false,
			);
		}
		echo json_encode($params);
	}

	function md_show_item()
	{
		$this->load->view('transaction/sale/modal_item_data');
	}

	public function stock()
	{
		$item = $this->item_m->get();
		$supplier = $this->supplier_m->get()->result();
		$data = array(
			'item' => $item,
			'supplier' => $supplier,
		);
		$this->template->load('template', 'report/stock_data', $data);
	}

	public function process()
	{
		// var_dump( $_POST );
		// die;
		$data = $this->input->post(null, true);

		if (isset($_POST['add_cart'])) {

			// var_dump($data);
			// die;

			$item_id_detail = $this->input->post('item_id_detail');
			$check_cart = $this->sale_m->get_cart(['t_cart.item_id_detail' => $item_id_detail]);
			$stock_cukup = $this->sale_m->cek_stok_cukup($data);

			if ($stock_cukup == true) {
				if ($check_cart->num_rows() > 0) {
					$this->sale_m->update_cart_qty($data);
				} else {
					$this->sale_m->add_cart($data);
				}

				// $this->sale_m->add_cart( $data );
				if ($this->db->affected_rows() > 0) {
					$params = array('success' => true);
				} else {
					$params = array('success' => false);
				}
				echo json_encode($params);
			} else {

				$params = array(
					'success' => false,
					'stock_cukup' => false,
				);
				echo json_encode($params);
			}
		}

		if (isset($_POST['edit_qty'])) {
			// var_dump($data);
			// die;
			$qty = $data['qty'];
			$cart_id = $data['cart_id'];
			$id_item_detail = $this->db->query("select item_id_detail from t_cart where cart_id = '$cart_id'")->row()->item_id_detail;
			$stock = $this->db->query("select qty from p_item_detail where id = '$id_item_detail'")->row()->qty;

			if ($qty > $stock) {
				$params = array(
					'success' => false,
					'stock' => false,
				);
			} else {
				$sql = "update t_cart set qty = '$qty', total = (price - discount_item) * qty where cart_id = '$cart_id'";
				$this->db->query($sql);
				if ($this->db->affected_rows() > 0) {
					$params = array('success' => true);
				} else {
					$params = array('success' => false);
				}
			}
			echo json_encode($params);
		}

		if (isset($_POST['edit_disc'])) {
			// var_dump($data);
			// die;
			$discount_percent = $data['disc'];
			$cart_id = $data['cart_id'];
			$query = $this->db->query("select * from t_cart where cart_id = '$cart_id'");
			$harga_jual = $query->row()->price;
			// $item_id = $query->row()->item_id;
			$disc_item = ((float)$harga_jual * ($discount_percent / 100));
			$this->db->query("update t_cart set discount_percent = '$discount_percent', discount_item = '$disc_item', total = (price - '$disc_item') * qty where cart_id = '$cart_id'");
			// var_dump($this->db->last_query());
			// die;
			if ($this->db->affected_rows() > 0) {
				$params = array('success' => true);
			} else {
				$params = array('success' => false);
			}

			echo json_encode($params);
		}

		if (isset($_POST['edit_ed'])) {
			// var_dump($data);
			// die;
			$ed = $data['ed'];
			$exp = str_replace("/", "-", $ed);
			$date_expired = date('Y-m-d', strtotime($exp));
			$cart_id = $data['cart_id'];
			$this->db->query("update t_cart set item_expired_2 = '$date_expired' where cart_id = '$cart_id'");
			if ($this->db->affected_rows() > 0) {
				$params = array('success' => true);
			} else {
				$params = array('success' => false);
			}

			echo json_encode($params);
		}

		if (isset($_POST['edit_cart'])) {
			// var_dump($data);
			// die;
			$this->sale_m->edit_cart($data);

			if ($this->db->affected_rows() > 0) {
				$params = array('success' => true);
			} else {
				$params = array('success' => false);
			}
			echo json_encode($params);
		}

		if (isset($_POST['process_payment'])) {
			// var_dump( $data );
			// die;
			$sale_id = $this->sale_m->add_sale($data);
			$cart = $this->sale_m->get_cart()->result();
			$row = [];

			foreach ($cart as $c => $value) {
				array_push($row, array(
					'sale_id' => $sale_id,
					'item_id' => $value->item_id,
					'item_id_detail' => $value->item_id_detail,
					'price' => $value->price,
					'qty' => $value->qty,
					'exp_date' => $value->item_expired,
					'exp_date_2' => $value->item_expired_2,
					'discount_item' => $value->discount_item,
					'total' => $value->total,
				));
				$this->db->query("update p_item_detail set qty = qty - '$value->qty' where id = '$value->item_id_detail'");
			}

			$this->sale_m->add_sale_detail($row);
			$this->sale_m->del_cart(['user_id' => $this->session->userdata('userid')]);

			if ($this->db->affected_rows() > 0) {
				$params = array('success' => true, 'sale_id' => $sale_id);
			} else {
				$params = array('success' => false);
			}
			echo json_encode($params);
		}
	}

	public function cart_data()
	{
		$cart = $this->sale_m->get_cart();
		$data['cart'] = $cart;
		$this->load->view('transaction/sale/cart_data', $data);
	}

	public function cart_del()
	{

		if (isset($_POST['cancel_payment'])) {
			$this->sale_m->del_cart(['user_id' => $this->session->userdata('userid')]);
		} else {
			$cart_id = $this->input->post('cart_id');
			$this->sale_m->del_cart(['cart_id' => $cart_id]);
		}

		if ($this->db->affected_rows() > 0) {
			$params = array('success' => true);
		} else {
			$params = array('success' => false);
		}
		echo json_encode($params);
	}

	public function cetak($id, $back_href = null)
	{
		$this->db->query("UPDATE t_sale SET printed = printed + 1 WHERE sale_id = '$id'");
		$id_toko = $this->db->query("SELECT id_toko FROM t_sale WHERE sale_id = '$id'")->row()->id_toko;
		$toko = $this->db->query("SELECT * FROM t_toko WHERE id = '$id_toko'")->row();
		$data = array(
			'back_href' => base64_decode($back_href),
			'toko' => $toko,
			'sale_id' => $id,
			'sale' => $this->sale_m->get_sale($id)->row(),
			'sale_detail' => $this->sale_m->get_sale_detail($id)->result(),
		);
		$this->load->view('transaction/sale/receipt_print', $data);
	}

	public function print_receipt_today()
	{
		$receipt = $this->sale_m->get_sales_today_per_user();
		$tax = $this->db->query("select tax + 1 as tax from tax")->row()->tax;
		$data = array(
			'tax' => $tax,
			'receipt' => $receipt
		);
		$this->load->view('report/print_receipt_today', $data);
	}

	public function del($id)
	{
		$this->sale_m->del_sale($id);
		$this->sale_m->del_sale_detail($id);

		if ($this->db->affected_rows() > 0) {
			echo "<script>alert('Data penjualan berhasil dihapus');
			window.location='" . site_url('report/sale') . "'</script>";
		} else {
			echo "<script>alert('Data penjualan gagal dihapus');
			window.location='" . site_url('report/sale') . "'
			</script>";
		}
	}
}
