<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migrasi_m extends CI_Model
{

    // untuk update t_cart
    public function up_tb_cart()
    {

        $add_item_code = "ALTER TABLE t_cart ADD column item_code varchar(255) after item_id_detail";
        if ($this->db->query($add_item_code)) {
            echo "berhasil tambah kolom item code" . "<br>";
        } else {
            echo "gagal tambah kolom item code" . "<br>";
        }

        $add_kode_promo = "ALTER TABLE t_cart ADD column kode_promo varchar(255) after total";
        if ($this->db->query($add_kode_promo)) {
            echo "berhasil tambah kolom kode promo" . "<br>";
        } else {
            echo "gagal tambah kolom kode promo" . "<br>";
        }
        $add_created_at = "ALTER TABLE t_cart ADD column created_at datetime DEFAULT current_timestamp after user_id";
        if ($this->db->query($add_created_at)) {
            echo "berhasil tambah kolom created_at" . "<br>";
        } else {
            echo "gagal tambah kolom created_at" . "<br>";
        }
    }

    // untuk create p_promo
    public function up_table_promo()
    {
        $sql = "CREATE TABLE `p_promo` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `kode_promo` varchar(255) DEFAULT NULL,
            `nama_promo` varchar(255) DEFAULT NULL,
            `min_belanja` float DEFAULT NULL,
            `min_qty` float DEFAULT NULL,
            `qty_bonus` float DEFAULT NULL,
            `is_disc_show` enum('y','n') NOT NULL DEFAULT 'n',
            `is_active` enum('y','n') DEFAULT 'n',
            `created_by` varchar(255) DEFAULT NULL,
            `created` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `unik_kode_promo` (`kode_promo`)
          )";

        if ($this->db->query($sql)) {
            $result = "table promo berhasil dibuat";
        } else {
            $result = "gagal buat table promo";
        }
        return $result;
    }

    // untuk create p_promo_detail
    public function up_promo_detail()
    {
        $sql = "CREATE TABLE `p_promo_detail` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `kode_promo` varchar(255) DEFAULT NULL,
            `item_code` varchar(255) DEFAULT NULL,
            `discount` float DEFAULT NULL,
            `exp_date_from` date DEFAULT NULL,
            `exp_date_to` date DEFAULT NULL,
            `start_periode` date DEFAULT NULL,
            `end_periode` date DEFAULT NULL,
            `created_by` varchar(255) DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
          )";
        if ($this->db->query($sql)) {
            $result = "table promo detail berhasil dibuat";
        } else {
            $result = "gagal buat table promo detail";
        }
        return $result;
    }

    // untuk update table t_sale_detail
    public function up_table_sale_detail()
    {
        $sql = "ALTER TABLE t_sale_detail ADD column kode_promo varchar(255) after total";
        if ($this->db->query($sql)) {
            $result = "table t_sale detail berhasil di update";
        } else {
            $result = "gagal update table t_sale detail";
        }
        return $result;
    }
}
