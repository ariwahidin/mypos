<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['sale_m']);
        $this->load->library('escpos');
    }

    function index()
    {
        $profile = Escpos\CapabilityProfile::load("simple");
        $connector = new Escpos\PrintConnectors\WindowsPrintConnector($this->get_printer()->row()->printer_name);
        $printer = new Escpos\Printer($connector, $profile);
        $img = Escpos\EscposImage::load("assets/dist/img/DgChocoGallerys.png", false);
        $jumlah_print = $this->get_printer()->row()->jumlah_print;

        $printer->initialize();

        for ($i = 0; $i < $jumlah_print; $i++) {
            $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
            $printer->bitImage($img, Escpos\Printer::IMG_DOUBLE_WIDTH | Escpos\Printer::IMG_DOUBLE_HEIGHT | Escpos\Printer::JUSTIFY_CENTER);
            $printer->setJustification(); // Reset


            // $printer->setEmphasis(true);
            // $printer->text("Left margin\n");
            $printer->setEmphasis(false);

            // $printer->text("Default left\n");

            // foreach (array(1, 2, 4, 8, 16, 32, 64, 128, 256, 512) as $margin) {
            //     $printer->setPrintLeftMargin($margin);
            //     $printer->text("left margin $margin\n");
            // }

            $printer->setPrintLeftMargin(8);
            
            // $printer->setPrintLeftMargin(16);

            $printer->text("\n");
            $printer->text("MALL KELAPA GADING\n");
            $printer->text("DATE    : " . date('d-m-Y h:i:s') . "\n");
            $printer->text("ORDER   : F23-2302230001" . "\n");
            $printer->text("CASHIER : Lina" . "\n");
            $printer->text("-----------------------------------------\n");

            $printer->text($this->buatBaris1Kolom("TWN - Seasonal (English 50g+WNL 100g)#6x150g"));
            $printer->text($this->buatBaris3Kolom("2 PCS", "200.000", "400.000"));
            $printer->text($this->buatBaris3Kolom("Disc.", "25%", "-100.000"));
            $printer->text("\n");

            $printer->text($this->buatBaris1Kolom("TWN - Seasonal Breakfast Box 714gr # 12 x (50gr+380gr+284gr)"));
            $printer->text($this->buatBaris3Kolom("2 PCS", "100.000", "200.000"));
            $printer->text($this->buatBaris3Kolom("Disc.", "25%", "-50.000"));
            $printer->text("\n");

            $printer->text($this->buatBaris1Kolom("TWN - Seasonal Breakfast Box 714gr # 12 x (50gr+380gr+284gr)"));
            $printer->text($this->buatBaris3Kolom("2 PCS", "200.000", "400.000"));
            $printer->text("\n");

            $printer->text($this->buatBaris3Kolom("Service", "", "0"));
            $printer->text("-----------------------------------------\n");

            $printer->text($this->buatBaris3Kolom("Total", "5 PCS", "450.000"));
            $printer->text($this->buatBaris3Kolom("Disc Sale", "", "0"));
            $printer->text($this->buatBaris3Kolom("Grand Total", "", "450.000"));

            $printer->text("-----------------------------------------\n");

            $printer->text($this->buatBaris3Kolom("Type Bayar", "", "Cash"));
            $printer->text($this->buatBaris3Kolom("Total Bayar", "", "500.000"));
            $printer->text($this->buatBaris3Kolom("Change", "", "50.000"));

            $printer->text("-----------------------------------------\n");
            $printer->text("                   Thank You             \n");
            $printer->text("                  Test Print             \n");

            $printer->feed(2);
            $printer->cut();
        }

        $printer->close();
        redirect('printer');
    }

    function cetakStruk($id)
    {

        $id_toko = $this->db->query("SELECT id_toko FROM t_sale WHERE sale_id = '$id'")->row()->id_toko;
        $toko = $this->db->query("SELECT * FROM t_toko WHERE id = '$id_toko'")->row();
        $sale = $this->sale_m->get_sale($id)->row();
        $sale_detail = $this->sale_m->get_sale_detail($id)->result();


        $profile = Escpos\CapabilityProfile::load("simple");
        $connector = new Escpos\PrintConnectors\WindowsPrintConnector($this->get_printer()->row()->printer_name);
        $printer = new Escpos\Printer($connector, $profile);
        $img = Escpos\EscposImage::load("assets/dist/img/DgChocoGallerys.png", false);
        $jumlah_print = $this->get_printer()->row()->jumlah_print;


        $printer->initialize();

        for ($i = 0; $i < $jumlah_print; $i++) {

            $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
            $printer->bitImage($img, Escpos\Printer::IMG_DOUBLE_WIDTH | Escpos\Printer::IMG_DOUBLE_HEIGHT | Escpos\Printer::JUSTIFY_CENTER);
            $printer->setJustification(); // Reset
            $printer->text("\n");

            $printer->setEmphasis(false);
            $printer->setPrintLeftMargin(8);

            $printer->text($toko->nama_toko . "\n");
            $printer->text("DATE    : " . date('d-m-Y h:i:s', strtotime($sale->sale_created)) . "\n");
            $printer->text("ORDER   : " . $sale->invoice . "\n");
            $printer->text("CASHIER : " . $sale->nama_user . "\n");
            $printer->text("-----------------------------------------\n");

            foreach ($sale_detail as $data) {

                $printer->text($this->buatBaris1Kolom($data->name));
                $total_price = $data->qty * $data->price;
                $printer->text($this->buatBaris3Kolom($data->qty . " PCS", number_format($data->price), number_format($total_price)));

                if ($data->discount_item > 0) {
                    $discount_percent = round(($data->discount_item / $data->price) * 100);
                    $total_discount_item = number_format($data->qty * $data->discount_item);
                    $printer->text($this->buatBaris3Kolom("Disc.", $discount_percent . "%", "-" . $total_discount_item));
                }
                $printer->text("\n");
            }

            $printer->text("-----------------------------------------\n");

            $printer->text($this->buatBaris3Kolom("Total", $sale->total_item . " PCS", number_format($sale->total_item_value)));
            $printer->text($this->buatBaris3Kolom("Service", "", number_format($sale->service)));
            $printer->text($this->buatBaris3Kolom("Disc Sale", "", "-" . number_format($sale->discount)));
            $grand_total = ($sale->total_item_value + $sale->service) - $sale->discount;
            $printer->text($this->buatBaris3Kolom("Grand Total", "", number_format($grand_total)));

            $printer->text("-----------------------------------------\n");

            $printer->text($this->buatBaris3Kolom("Type Bayar", "", $sale->type_pembayaran));
            $printer->text($this->buatBaris3Kolom("Total Bayar", "", number_format($sale->cash)));
            $printer->text($this->buatBaris3Kolom("Change", "", number_format($sale->remaining)));
            $printer->text("Harga Sudah Termasuk PPN\n");

            $printer->text("-----------------------------------------\n");
            $printer->text("                 Thank You               \n");

            $printer->feed(2);
            $printer->cut();
        }

        $printer->close();
        redirect(base_url('sale'));
    }

    function get_printer()
    {
        $query = $this->db->query("select * from tb_printer");
        return $query;
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
