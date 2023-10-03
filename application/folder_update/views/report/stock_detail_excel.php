<?php
// var_dump($stock->result());
// die;

// Load plugin PHPExcel nya
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';


// Panggil class PHPExcel nya
$excel = new PHPExcel();
// Settingan awal fil excel
$excel->getProperties()->setCreator('Pandurasa Kharisma')
    ->setLastModifiedBy('Pandurasa Kharisma')
    ->setTitle("STOCK DETAIL")
    ->setSubject("STOCK DETAIL")
    ->setDescription("STOCK DETAIL")
    ->setKeywords("STOCK DETAIL");
// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = array(
    'font' => array('bold' => true), // Set font nya jadi bold
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
);
// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
    'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
);
$excel->setActiveSheetIndex(0)->setCellValue('A2', "Waktu : ".date('d-m-Y H:i:s')); // Set kolom A1 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A2:F2'); // Set Merge Cell pada kolom A1 sampai E1
// $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE);
// $excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); 
// $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


$excel->setActiveSheetIndex(0)->setCellValue('A1', "Counter : ".$toko->row()->nama_toko); // Set kolom A1 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
// $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
// $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
// $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Buat header tabel nya pada baris ke 3
$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
$excel->setActiveSheetIndex(0)->setCellValue('B3', "ITEM CODE"); // Set kolom A3 dengan tulisan "NO"
$excel->setActiveSheetIndex(0)->setCellValue('C3', "BARCODE"); // Set kolom A3 dengan tulisan "NO"
$excel->setActiveSheetIndex(0)->setCellValue('D3', "DESC"); // Set kolom A3 dengan tulisan "NO"
$excel->setActiveSheetIndex(0)->setCellValue('E3', "STOCK"); // Set kolom A3 dengan tulisan "NO"
$excel->setActiveSheetIndex(0)->setCellValue('F3', "EXPIRED DATE"); // Set kolom A3 dengan tulisan "NO"
// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
foreach ($stock->result() as $data) {

    // Lakukan looping pada variabel siswa
    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->item_code);
    $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->barcode);
    $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->item_name);
    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->qty);
    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->exp_date);

    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);

    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(13.29);
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(10.57);
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(12.43);

    $no++; // Tambah 1 setiap kali looping
    $numrow++; // Tambah 1 setiap kali looping
}

// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("STOCK DETAIL");
$excel->setActiveSheetIndex(0);
// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Stock Detail '.$toko->row()->nama_toko.' '. date('dmYHis'). '.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');
$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');
