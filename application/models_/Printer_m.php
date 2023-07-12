<?php defined('BASEPATH') or exit('No direct script access allowed');

class Printer_m extends CI_Model
{

    function get_printer()
    {
        $query = $this->db->query("select * from tb_printer");
        return $query;
    }

    function get_margin_left()
    {
        $file_json = FCPATH . 'json_file/printer.json';
        $json_data = file_get_contents($file_json);
        $data_printer = json_decode($json_data);
        return (int)$data_printer->margin_left;
    }

    function set_printer_json($post)
    {
        $file_json = FCPATH . 'json_file/printer.json';
        $data_printer_input = array(
            'nama_printer' => $post['printer_name'],
            'jumlah_print' => $post['jumlah_print'],
            'margin_left' => $post['margin_left'],
        );
        $json_data = json_encode($data_printer_input);
        $insert = file_put_contents($file_json, $json_data);

        if ($insert) {
            return true;
        } else {
            return false;
        }
    }
}
