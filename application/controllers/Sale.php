<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sale extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model('sale_m');
		$this->load->model(['customer_m', 'item_m', 'supplier_m', 'printer_m']);
		$this->load->library('escpos');
	}

	public function index()
	{
		$user_id = $this->session->userdata('userid');
		$delete_cart_sale = $this->db->query("delete from t_cart where user_id = '$user_id'");
		$customer = $this->customer_m->get()->result();
		$item = $this->sale_m->get_item_detail()->result();
		$cart = $this->sale_m->get_cart();
		$type_bayar = $this->sale_m->get_type_bayar();
		$tax = $this->sale_m->get_tax();
		$min_belanja_tebus_murah = $this->sale_m->get_promo_tebus_murah();
		$data = array(
			'customer' => $customer,
			'item' => $item,
			'cart' => $cart,
			'type_bayar' => $type_bayar,
			'tax' => $tax->row()->tax,
			'invoice' => $this->sale_m->invoice_no(),
			'min_belanja_tebus_murah' => $min_belanja_tebus_murah->row()->min_belanja
		);
		// var_dump($this->db->error());
		$this->template->load('template', 'transaction/sale/sale_form', $data);
	}

	public function prepare()
	{
		$sql = "select t1.*, t2.item_code, t3.name  from tb_event t1 
        inner join tb_item_bonus t2 on t1.id_event = t2.id_event
        inner join p_item t3 on t2.item_code = t3.item_code 
        where now() > t1.start_periode and now() < t1.end_periode and t1.is_active = 'y'";
		$item_bonus_active = $this->db->query($sql);

		$promo = $this->sale_m->get_promo_active();
		$data = array(
			'item_bonus_acitve' => $item_bonus_active,
			'promo' => $promo
		);
		$this->template->load('template', 'transaction/sale/prepare', $data);
	}

	public function loadDetailPromo()
	{
		$kode_promo = $this->input->post('kode_promo');
		$detail = $this->sale_m->getDetailPromo($kode_promo);
		$data = array(
			'detail' => $detail
		);
		$this->load->view('transaction/sale/detail_promo', $data);
	}

	// function check_event()
	// {
	// 	$check_event = $this->db->query("select * from tb_event where now() > start_periode and now() < end_periode and is_active = 'y'");
	// 	if ($check_event->num_rows() > 0) {
	// 		$id_event = $check_event->row()->id_event;
	// 		$check_item_bonus = $this->db->query("select item_code from tb_item_bonus where id_event = '$id_event'");
	// 		if ($check_item_bonus->num_rows() > 0) {
	// 			$sql_cek = "select item_id_detail from t_cart
	// 			where item_id_detail =  
	// 			(select t2.id from tb_item_bonus t1 
	// 			inner join p_item_detail t2 on t2.item_code = t1.item_code
	// 			inner join t_cart t3 on t2.id = t3.item_id_detail
	// 			where t1.id_event = '$id_event')";
	// 			$item_id_detail_cart = $this->db->query($sql_cek);
	// 			// var_dump($this->db->error());
	// 			// var_dump($this->db->last_query());


	// 			if ($item_id_detail_cart->num_rows() > 0) {
	// 				$item_id_detail = $item_id_detail_cart->row()->item_id_detail;
	// 				$user_id = $this->session->userdata('userid');
	// 				$total_belanja = $this->db->query("select sum(total) as total_belanja from t_cart where user_id = '$user_id'")->row()->total_belanja;
	// 				$min_belanja = $this->db->query("select min_sales from tb_event where id_event = '$id_event'")->row()->min_sales;
	// 				$harga_item_bonusan = $this->db->query("select price from t_cart where item_id_detail = '$item_id_detail'")->row()->price;
	// 				// var_dump($total_belanja);
	// 				// var_dump($min_belanja);
	// 				// var_dump($harga_item_bonusan);

	// 				if (($total_belanja - $harga_item_bonusan) > $min_belanja) {
	// 					// update t_cart 
	// 					$update_cart = $this->db->query("update t_cart set discount_item = price, discount_percent = '100', total = '0' where item_id_detail = '$item_id_detail'");
	// 					if ($this->db->affected_rows() > 0) {
	// 						$params = array('success' => true);
	// 						echo json_encode($params);
	// 					} else {
	// 					}
	// 				} else {
	// 					// minimal belanja tidak terpenuhi
	// 				}
	// 			} else {
	// 				//tidak ada item bonus di cart
	// 			}
	// 		} else {
	// 			//tidak ada item bonus
	// 		}
	// 	} else {
	// 		//tidak ada event
	// 	}
	// }

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

		$data = array(
			'item' => $item
		);

		$this->load->view('transaction/sale/modal_item_data', $data);
		// if ($item->num_rows() > 0) {
		// 	$params = array(
		// 		'item' => $item->result(),
		// 		'success' => true
		// 	);
		// } else {
		// 	$params = array(
		// 		'success' => false,
		// 	);
		// }
		// echo json_encode($params);
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

	public function cekPromoPerItem($item_code, $id_item_detail = null)
	{
		$user_id = $this->session->userdata('userid');
		$kode_promo = $this->db->query("select b.kode_promo, a.item_code, a.item_expired,
        b.exp_date_from, b.exp_date_to, b.start_periode, b.end_periode
        from t_cart a 
        left join p_promo_detail b on a.item_code = b.item_code
        where a.item_code = '$item_code'
        and b.kode_promo = 'P002'
		and a.user_id = '$user_id'
        and a.item_expired >= b.exp_date_from and a.item_expired  <= b.exp_date_to
        and date(now()) >= b.start_periode and date(now()) <= b.end_periode");
		if ($kode_promo->num_rows() > 0) {
			if ($kode_promo->row()->kode_promo == 'P002') {
				$kode_promo = $kode_promo->row()->kode_promo;
				$promo = $this->db->query("select kode_promo, min_qty, nama_promo, qty_bonus from p_promo where kode_promo = 'P002'");
				$min_qty = $promo->row()->min_qty;
				$qty_bonus = $promo->row()->qty_bonus;
				$sum_qty = $this->db->query("select sum(qty) as total_qty from t_cart where item_code = '$item_code' and user_id = '$user_id'");
				$sum_qty = $sum_qty->row()->total_qty;
				$predic_qty = $sum_qty + $qty_bonus;
				$stock = $this->db->query("select sum(a.qty) as stock 
				from p_item_detail a 
				left join p_promo_detail b on a.item_code = b.item_code
				where a.item_code = '$item_code'
				and a.exp_date >= b.exp_date_from and a.exp_date <= b.exp_date_to
				and date(now()) >= b.start_periode and date(now()) <= b.end_periode");
				$stock = $stock->row()->stock;
				// var_dump($predic_qty);
				if ($predic_qty <= $stock) {
					$item_bonus = $this->sale_m->getItemBonusNearEd($item_code, $kode_promo);
					// var_dump($this->db->last_query());
					if ($item_bonus->num_rows() > 0) {
						$params = $item_bonus->row();
						$cek_qty_cart_terpenuhi = $this->sale_m->cekQtyCartForPromo($item_code, $kode_promo);
						$qty_cart = $cek_qty_cart_terpenuhi->row()->total_qty;

						if ($qty_cart >= $min_qty) {
							$cek_promo_sudah_ada_dicart = $this->sale_m->getPromoIsExist($item_code, $kode_promo);
							if ($cek_promo_sudah_ada_dicart->num_rows() < 1) {
								// var_dump($item_code);
								//lakukan menambahan item bonus ke dalam keranjang belanja
								$this->sale_m->add_cart_item_bonus($params);
								// var_dump($params);
								// var_dump($this->db->error());
							}
						} else {
							//hapus item promo yang sudah ada dicart apa bila item utama kurang dari min qty promo
							$this->sale_m->delete_cart_item_promo($item_code, $kode_promo);
						}
					}
				}
			}
		} else {
			$this->cekPromoBogof($item_code, $id_item_detail);
		}
	}

	public function cekPromoBogof($item_code, $id_item_detail)
	{
		$user_id = $this->session->userdata('userid');
		// cek apakah ada item promo bogof di cart dan apakah exp date sesuai dengan settingan promo
		$kode_promo = $this->db->query("select b.kode_promo, a.item_code, a.item_expired,
        b.exp_date_from, b.exp_date_to, b.start_periode, b.end_periode
        from t_cart a 
        left join p_promo_detail b on a.item_code = b.item_code
        where a.item_code = '$item_code'
        and b.kode_promo = 'P005'
		and a.user_id = '$user_id'
        and a.item_expired >= b.exp_date_from and a.item_expired  <= b.exp_date_to
        and date(now()) >= b.start_periode and date(now()) <= b.end_periode");
		if ($kode_promo->num_rows() > 0) {
			if ($kode_promo->row()->kode_promo == 'P005') {
				$kode_promo = $kode_promo->row()->kode_promo;
				$promo = $this->db->query("select kode_promo, min_qty, nama_promo, qty_bonus from p_promo where kode_promo = 'P005'");
				$min_qty = $promo->row()->min_qty;
				$qty_bonus = $promo->row()->qty_bonus;
				$sum_qty = $this->db->query("select sum(qty) as total_qty from t_cart where item_code = '$item_code' and user_id = '$user_id'");
				$sum_qty = $sum_qty->row()->total_qty;
				$predic_qty = $sum_qty + $qty_bonus;

				// get stocknya cukup atau tidak
				$stock = $this->db->query("select sum(a.qty) as stock 
				from p_item_detail a 
				left join p_promo_detail b on a.item_code = b.item_code
				where a.item_code = '$item_code'
				and a.exp_date >= b.exp_date_from and a.exp_date <= b.exp_date_to
				and date(now()) >= b.start_periode and date(now()) <= b.end_periode");
				$stock = $stock->row()->stock;
				// var_dump($predic_qty);
				if ($predic_qty <= $stock) {

					// ambil item yang exp date terdekat sesuai dengan yang disetting promo
					$item_bonus = $this->sale_m->getItemBonusNearEd($item_code, $kode_promo, $id_item_detail);
					// var_dump($this->db->last_query());
					if ($item_bonus->num_rows() > 0) {
						$params = $item_bonus->row();
						$cek_qty_cart_terpenuhi = $this->sale_m->cekQtyCartForPromo($item_code, $kode_promo);
						$qty_cart = $cek_qty_cart_terpenuhi->row()->total_qty;

						if ($qty_cart >= $min_qty) {
							$cek_promo_sudah_ada_dicart = $this->sale_m->getPromoIsExist($item_code, $kode_promo);
							if ($cek_promo_sudah_ada_dicart->num_rows() < 1) {
								// var_dump($item_code);
								//lakukan menambahan item bonus ke dalam keranjang belanja
								$this->sale_m->add_cart_item_bonus($params);
								// var_dump($params);
								// var_dump($this->db->error());
							}
						} else {
							//hapus item promo yang sudah ada dicart apa bila item utama kurang dari min qty promo
							$this->sale_m->delete_cart_item_promo($item_code, $kode_promo);
						}
					}
				}
			}
		}
	}

	public function process()
	{
		// var_dump( $_POST );
		// die;
		$data = $this->input->post(null, true);

		if (isset($_POST['add_cart'])) {

			$item_id_detail = $data['item_id_detail'];
			$item_code = $this->db->query("select item_code from p_item_detail where id='$item_id_detail'")->row()->item_code;

			$discount = $data['discount'];
			if ($data['kode_promo'] == null || $data['kode_promo'] == 'null') {
				$data['kode_promo'] = '';
			}

			$params = array(
				't_cart.item_id_detail' => $item_id_detail,
				't_cart.discount_percent' => $discount,
				't_cart.kode_promo' => $data['kode_promo']
			);


			$check_cart = $this->sale_m->get_cart($params);
			$stock_cukup = $this->sale_m->cek_stok_cukup($data);

			if ($stock_cukup == true) {
				if ($check_cart->num_rows() > 0) {
					$this->sale_m->update_cart_qty($data);
				} else {
					$this->sale_m->add_cart($data);
				}

				// $this->sale_m->add_cart( $data );
				if ($this->db->affected_rows() > 0) {
					$this->cekPromoPerItem($item_code, $item_id_detail);
					$this->cekPromoTebusMurahIsAccurate();
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
			$item_code = $this->db->query("select item_code from t_cart where item_id_detail='$id_item_detail'")->row()->item_code;
			if ($qty > $stock) {
				$params = array(
					'success' => false,
					'stock' => false,
				);
			} else {
				$sql = "update t_cart set qty = '$qty', total = (price - discount_item) * qty where cart_id = '$cart_id'";
				$this->db->query($sql);
				//cek promo

				if ($this->db->affected_rows() > 0) {
					$this->cekPromoPerItem($item_code);
					$this->cekPromoTebusMurahIsAccurate();
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
				$this->cekPromoTebusMurahIsAccurate();
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
					'kode_promo' => $value->kode_promo,
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

	public function checkFreePaperBag()
	{
		$user_id = $this->session->userdata('userid');
		// cek apakah promo aktif
		$cek_promo = $this->db->query("select * from p_promo where kode_promo = 'P004' and is_active = 'y'");
		if ($cek_promo->num_rows() > 0) {
			// cek item promonya apa
			$item_promo = $this->db->query("select * from p_promo_detail where kode_promo = 'P004'");
			if ($item_promo->num_rows() > 0) {
				$item_code = $item_promo->row()->item_code;
				//cek apakah ada item promo di cart
				$cek_cart = $this->db->query("select * from t_cart where item_code = '$item_code' and user_id = '$user_id'");
				if ($cek_cart->num_rows() > 0) {
					// hitung total belanja melebihi min belanja di luar item promo
					$total_belanja = $this->db->query("select sum(total) as total_belanja from t_cart where user_id = '$user_id' and item_code != '$item_code'");
					if ($total_belanja->num_rows() > 0) {
						$min_belanja = $cek_promo->row()->min_belanja;
						$price = $cek_cart->row()->price;
						$qty = $cek_cart->row()->qty;
						$discount = $item_promo->row()->discount;
						$total_belanja = $total_belanja->row()->total_belanja;
						// var_dump($total_belanja);
						// var_dump($min_belanja);
						if ($total_belanja >= $min_belanja) {
							// jika total belanja > min belanja update item promo berikan kode promo dan rubah discountnya
							$discount_item = $price * ($discount / 100);
							$total = ($price - $discount_item) * $qty;
							$data = array(
								'discount_item' => $discount_item,
								'discount_percent' => $discount,
								'total' => $total,
								'kode_promo' => 'P004'
							);
							$where = array(
								'item_code' => $item_code,
								'user_id' => $user_id
							);
							$this->db->where($where);
							$this->db->update('t_cart', $data);
						} else {
							// jika total belanja < min belanja jadikan harga normal tanpa discount
							$discount_item = $price * (0 / 100);
							$total = ($price - $discount_item) * $qty;
							$data = array(
								'discount_item' => $discount_item,
								'discount_percent' => 0,
								'total' => $total,
								'kode_promo' => ''
							);
							$where = array(
								'item_code' => $item_code,
								'user_id' => $user_id
							);
							$this->db->where($where);
							$this->db->update('t_cart', $data);
						}
					}
				}
			}
		}
	}

	public function cart_data()
	{
		$this->checkFreePaperBag();
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
			$item_code = $this->db->query("select item_code from t_cart where cart_id = '$cart_id'")->row()->item_code;
			$this->sale_m->del_cart(['cart_id' => $cart_id]);
		}

		if ($this->db->affected_rows() > 0) {
			if (isset($item_code)) {
				$this->cekPromoPerItem($item_code);
			}
			$this->cekPromoTebusMurahIsAccurate();
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
		$this->cetakStrukDaily();
		// $receipt = $this->sale_m->get_sales_today_per_user();
		// $tax = $this->db->query("select tax + 1 as tax from tax")->row()->tax;
		// $data = array(
		// 	'tax' => $tax,
		// 	'receipt' => $receipt
		// );
		// $this->load->view('report/print_receipt_today', $data);
	}


	function cetakStrukDaily()
	{
		$receipt = $this->sale_m->get_sales_today_per_user();

		// var_dump($receipt->result());
		// die;
		$tax = $this->db->query("select tax + 1 as tax from tax")->row()->tax;

		$profile = Escpos\CapabilityProfile::load("simple");
		$connector = new Escpos\PrintConnectors\WindowsPrintConnector($this->printer_m->get_printer()->row()->printer_name);
		$printer = new Escpos\Printer($connector, $profile);
		$img = Escpos\EscposImage::load("assets/dist/img/DgChocoGallerys.png", false);
		$jumlah_print = 1;


		$printer->initialize();

		for ($i = 0; $i < $jumlah_print; $i++) {

			$printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
			$printer->bitImage($img, Escpos\Printer::IMG_DOUBLE_WIDTH | Escpos\Printer::IMG_DOUBLE_HEIGHT | Escpos\Printer::JUSTIFY_CENTER);
			$printer->setJustification(); // Reset
			$printer->text("\n");

			$printer->setEmphasis(false);
			$printer->setPrintLeftMargin($this->printer_m->get_margin_left());

			$printer->text($receipt->row()->toko_cabang . "\n");
			$printer->text("DATE    : " . date('d-m-Y', strtotime($receipt->row()->tanggal_transaksi)) . "\n");
			$printer->text("CASHIER : " . $receipt->row()->name . "\n");
			$printer->text("-----------------------------------------\n");

			$grand_total = 0;
			foreach ($receipt->result() as $data) {
				$grand_total += $data->total;
			}

			foreach ($receipt->result() as $data) {

				$printer->text($this->buatBaris1Kolom($data->item_name));
				$total_price = $data->qty * $data->price;
				$printer->text($this->buatBaris3Kolom($data->qty . " PCS", number_format($data->price), $data->discount_item > 0 ? number_format($data->price * $data->qty) : number_format($data->total)));

				if ($data->discount_item > 0) {
					$discount_percent = ($data->discount_item / $data->price) * 100;
					$total_discount_item = number_format($data->qty * $data->discount_item);
					$printer->text($this->buatBaris3Kolom("Disc.", number_format($data->discount_percent) . "%", "-" . number_format($data->total_discount_item)));
				}
				$printer->text("\n");
			}

			$printer->text("-----------------------------------------\n");

			$printer->text($this->buatBaris3Kolom("Gross Total", "", number_format($grand_total / $tax)));
			$printer->text($this->buatBaris3Kolom("Serv & Char", "", number_format($receipt->row()->total_service)));
			$printer->text($this->buatBaris3Kolom("Discount", "", number_format($receipt->row()->total_discount)));
			$printer->text($this->buatBaris3Kolom("Tax", "", number_format($grand_total - ($grand_total / $tax))));
			$printer->text($this->buatBaris3Kolom("Grand Total", "", number_format($grand_total + ($receipt->row()->total_service) - ($receipt->row()->total_discount))));

			$printer->text("-----------------------------------------\n");

			$printer->text($this->buatBaris3Kolom("Printed : ", "", date('d-m-Y H:i:s', strtotime($this->db->query("select now() as now")->row()->now))));
			$printer->feed(2);
			$printer->cut();
		}
		$printer->close();
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

	function buatBaris1Kolom($kolom1)
	{
		// Mengatur lebar setiap kolom (dalam satuan karakter)
		$lebar_kolom_1 = 40;

		// Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
		$kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);

		// Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
		$kolom1Array = explode("\n", $kolom1);

		// Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
		$jmlBarisTerbanyak = count($kolom1Array);

		// Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
		$hasilBaris = array();

		// Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
		for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

			// memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
			$hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");

			// Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
			$hasilBaris[] = $hasilKolom1;
		}

		// Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
		return implode($hasilBaris, "\n") . "\n";
	}

	function buatBaris3Kolom($kolom1, $kolom2, $kolom3)
	{
		// Mengatur lebar setiap kolom (dalam satuan karakter)
		$lebar_kolom_1 = 11;
		$lebar_kolom_2 = 14;
		$lebar_kolom_3 = 14;

		// Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
		$kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
		$kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
		$kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);

		// Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
		$kolom1Array = explode("\n", $kolom1);
		$kolom2Array = explode("\n", $kolom2);
		$kolom3Array = explode("\n", $kolom3);

		// Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
		$jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array));

		// Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
		$hasilBaris = array();

		// Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
		for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

			// memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
			$hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
			// memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
			$hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_LEFT);

			$hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);

			// Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
			$hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3;
		}

		// Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
		return implode($hasilBaris, "\n") . "\n";
	}

	public function get_total_belanja()
	{
		$total_belanja = $this->sale_m->get_total_belanja();
		if ($total_belanja->num_rows() > 0) {
			$response = array(
				'success' => true,
				'total_belanja' => $total_belanja->row()->total_belanja
			);
		} else {
			$response = array(
				'success' => false
			);
		}
		echo json_encode($response);
	}

	public function cek_tebus_murah()
	{
		$total_belanja = $this->input->post('total_belanja');
		$tebus_murah = $this->sale_m->get_promo_tebus_murah();
		if ($tebus_murah->row()->is_active == 'y') {
			if ($total_belanja >= $tebus_murah->row()->min_belanja) {
				$cek_tebus_murah_is_exists_in_cart = $this->sale_m->cekTebusMurahExistsInCart();
				if ($cek_tebus_murah_is_exists_in_cart->num_rows() > 0) {
					$response = array(
						'success' => false
					);
				} else {
					$response = array(
						'success' => true
					);
				}
			} else {
				$response = array(
					'success' => false
				);
			}
		} else {
			$response = array(
				'success' => false
			);
		}
		echo json_encode($response);
	}

	public function cekPromoTebusMurahIsAccurate()
	{
		$cek_item_tebus_murah_in_cart = $this->sale_m->cek_item_tebus_murah_in_cart();
		if ($cek_item_tebus_murah_in_cart->num_rows() > 0) {
			$total_belanja = $this->sale_m->cekTotalBelanjaWithOutTebusMurah()->row()->total_belanja;
			$amount_tebus_murah = $this->sale_m->cek_amount_tebus_murah()->row()->min_belanja;
			if ($total_belanja < $amount_tebus_murah) {
				// jika amount kurang dari ketentuan, hapus item tebus murah
				$this->sale_m->delete_item_tebus_murah();
			}
		}
	}

	public function get_item_tebus_murah()
	{
		$item = $this->sale_m->get_item_promo_tebus_murah();
		$data = array(
			'item' => $item
		);
		$this->load->view('transaction/sale/modal_item_tebus_harga', $data);
	}

	public function keep_alive()
	{
		$response = array(
			'success' => true
		);
		echo json_encode($response);
	}

	public function cekStock()
	{
		$id_item_detail = $this->input->post('id_item_detail');
		$qty_stock = $this->sale_m->getStock($id_item_detail)->row()->stock;
		$qty_cart = $this->sale_m->getQtyCart($id_item_detail)->row()->qty;
		$stock_balance = $qty_stock - $qty_cart;
		$response = array(
			'stock' => $stock_balance
		);
		echo json_encode($response);
	}
}
