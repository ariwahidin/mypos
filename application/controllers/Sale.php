<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sale extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model('sale_m');
		$this->load->model(['customer_m', 'item_m', 'supplier_m']);
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

	public function prepare(){
		$sql = "select t1.*, t2.item_code, t3.name  from tb_event t1 
        inner join tb_item_bonus t2 on t1.id_event = t2.id_event
        inner join p_item t3 on t2.item_code = t3.item_code 
        where now() > t1.start_periode and now() < t1.end_periode and t1.is_active = 'y'";
		$item_bonus_active = $this->db->query($sql);
		$data = array(
			'item_bonus_acitve' => $item_bonus_active
		);
		$this->template->load('template', 'transaction/sale/prepare', $data);
	}

	function check_event()
	{
		$check_event = $this->db->query("select * from tb_event where now() > start_periode and now() < end_periode and is_active = 'y'");
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
		$this->cetakStrukDaily();
		// $receipt = $this->sale_m->get_sales_today_per_user();
		// $tax = $this->db->query("select tax + 1 as tax from tax")->row()->tax;
		// $data = array(
		// 	'tax' => $tax,
		// 	'receipt' => $receipt
		// );
		// $this->load->view('report/print_receipt_today', $data);
	}

	function get_printer()
    {
        $query = $this->db->query("select * from tb_printer");
        return $query;
    }

	function cetakStrukDaily()
    {
		$receipt = $this->sale_m->get_sales_today_per_user();
		$tax = $this->db->query("select tax + 1 as tax from tax")->row()->tax;

        $profile = Escpos\CapabilityProfile::load("simple");
        $connector = new Escpos\PrintConnectors\WindowsPrintConnector($this->get_printer()->row()->printer_name);
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
            $printer->setPrintLeftMargin(16);

            $printer->text($receipt->row()->toko_cabang . "\n");
            $printer->text("DATE    : " . date('d-m-Y', strtotime($receipt->row()->tanggal_transaksi)) . "\n");
            $printer->text("CASHIER : " . $receipt->row()->username . "\n");
            $printer->text("-----------------------------------------\n");

			$grand_total = 0;
			foreach($receipt->result() as $data){
				$grand_total += $data->total;
			}

            foreach ($receipt->result() as $data) {

                $printer->text($this->buatBaris1Kolom($data->item_name));
                $total_price = $data->qty * $data->price;
                $printer->text($this->buatBaris3Kolom($data->qty . " PCS", number_format($data->price), $data->discount_item > 0 ? number_format($data->price * $data->qty) : number_format($data->total)));

                if ($data->discount_item > 0) {
                    $discount_percent = ($data->discount_item / $data->price) * 100;
                    $total_discount_item = number_format($data->qty * $data->discount_item);
                    $printer->text($this->buatBaris3Kolom("Disc.", number_format($data->discount_percent) . "%", "-" . number_format($data->discount_item)));
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
}
