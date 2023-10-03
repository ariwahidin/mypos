<?php defined('BASEPATH') or exit('No direct script access allowed');

class Toko_m extends CI_Model
{

    public function get_toko()
    {
        $sql = "select * from t_toko";
        $query = $this->db->query($sql);
        return $query;
    }
}
