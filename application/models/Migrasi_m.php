<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migrasi_m extends CI_Model
{
    // // untuk update t_cart
    // public function up_tb_cart()
    // {

    //     $add_item_code = "ALTER TABLE t_cart ADD column item_code varchar(255) after item_id_detail";
    //     if ($this->db->query($add_item_code)) {
    //         echo "berhasil tambah kolom item code" . "<br>";
    //     } else {
    //         echo "gagal tambah kolom item code" . "<br>";
    //     }

    //     $add_kode_promo = "ALTER TABLE t_cart ADD column kode_promo varchar(255) after total";
    //     if ($this->db->query($add_kode_promo)) {
    //         echo "berhasil tambah kolom kode promo" . "<br>";
    //     } else {
    //         echo "gagal tambah kolom kode promo" . "<br>";
    //     }
    //     $add_created_at = "ALTER TABLE t_cart ADD column created_at datetime DEFAULT current_timestamp after user_id";
    //     if ($this->db->query($add_created_at)) {
    //         echo "berhasil tambah kolom created_at" . "<br>";
    //     } else {
    //         echo "gagal tambah kolom created_at" . "<br>";
    //     }
    // }

    // // untuk create p_promo
    // public function up_table_promo()
    // {
    //     $sql = "CREATE TABLE `p_promo` (
    //         `id` int(11) NOT NULL AUTO_INCREMENT,
    //         `kode_promo` varchar(255) DEFAULT NULL,
    //         `nama_promo` varchar(255) DEFAULT NULL,
    //         `min_belanja` float DEFAULT NULL,
    //         `min_qty` float DEFAULT NULL,
    //         `qty_bonus` float DEFAULT NULL,
    //         `is_disc_show` enum('y','n') NOT NULL DEFAULT 'n',
    //         `is_active` enum('y','n') DEFAULT 'n',
    //         `created_by` varchar(255) DEFAULT NULL,
    //         `created` datetime DEFAULT NULL,
    //         PRIMARY KEY (`id`),
    //         UNIQUE KEY `unik_kode_promo` (`kode_promo`)
    //       )";

    //     if ($this->db->query($sql)) {
    //         $result = "table promo berhasil dibuat"."<br>";
    //     } else {
    //         $result = "gagal buat table promo"."<br>";
    //     }
    //     return $result;
    // }

    // // untuk create p_promo_detail
    // public function up_promo_detail()
    // {
    //     $sql = "CREATE TABLE `p_promo_detail` (
    //         `id` int(11) NOT NULL AUTO_INCREMENT,
    //         `kode_promo` varchar(255) DEFAULT NULL,
    //         `item_code` varchar(255) DEFAULT NULL,
    //         `discount` float DEFAULT NULL,
    //         `exp_date_from` date DEFAULT NULL,
    //         `exp_date_to` date DEFAULT NULL,
    //         `start_periode` date DEFAULT NULL,
    //         `end_periode` date DEFAULT NULL,
    //         `created_by` varchar(255) DEFAULT NULL,
    //         `created_at` datetime DEFAULT NULL,
    //         PRIMARY KEY (`id`)
    //       )";
    //     if ($this->db->query($sql)) {
    //         $result = "table promo detail berhasil dibuat"."<br>";
    //     } else {
    //         $result = "gagal buat table promo detail"."<br>";
    //     }
    //     return $result;
    // }

    // // untuk update table t_sale_detail
    // public function up_table_sale_detail()
    // {
    //     $sql = "ALTER TABLE t_sale_detail ADD column kode_promo varchar(255) after total";
    //     if ($this->db->query($sql)) {
    //         $result = "table t_sale detail berhasil di update"."<br>";
    //     } else {
    //         $result = "gagal update table t_sale detail"."<br>";
    //     }
    //     return $result;
    // }

    // //update tb printer

    // public function up_tb_printer()
    // {
    //     $sql1 = "ALTER TABLE tb_printer ADD column margin_left int after jumlah_print";
    //     if ($this->db->query($sql1)) {
    //         echo "tambah kolom margin_left berhasil" . "<br>";
    //     } else {
    //         echo "gagal tambah margin_left" . "<br>";
    //     }

    //     $sql2 = "ALTER TABLE tb_printer ADD column print_logo varchar(255) after margin_left";
    //     if ($this->db->query($sql2)) {
    //         echo "tambah kolom margin_left print_logo" . "<br>";
    //     } else {
    //         echo "gagal tambah print_logo" . "<br>";
    //     }

    //     $sql3 = "ALTER TABLE tb_printer ADD column alt_text varchar(255) after print_logo";
    //     if ($this->db->query($sql3)) {
    //         echo "tambah kolom alt_text berhasil" . "<br>";
    //     } else {
    //         echo "gagal tambah alt_text" . "<br>";
    //     }

    //     $sql4 = "ALTER TABLE tb_printer ADD column created_at datetime after alt_text";
    //     if ($this->db->query($sql4)) {
    //         echo "tambah kolom created_at berhasil" . "<br>";
    //     } else {
    //         echo "gagal tambah created_at" . "<br>";
    //     }

    //     $sql5 = "ALTER TABLE tb_printer ADD column created_by varchar(255) after created_at";
    //     if ($this->db->query($sql5)) {
    //         echo "tambah kolom created_by berhasil" . "<br>";
    //     } else {
    //         echo "gagal tambah created_by" . "<br>";
    //     }

    //     $sql6 = "ALTER TABLE tb_printer ADD column updated_at datetime after created_by";
    //     if ($this->db->query($sql6)) {
    //         echo "tambah kolom updated_at berhasil" . "<br>";
    //     } else {
    //         echo "gagal tambah updated_at" . "<br>";
    //     }

    //     $sql7 = "ALTER TABLE tb_printer ADD column updated_by varchar(255) after updated_at";
    //     if ($this->db->query($sql7)) {
    //         echo "tambah kolom updated_by berhasil" . "<br>";
    //     } else {
    //         echo "gagal tambah updated_by" . "<br>";
    //     }
    // }

    // POS Versi 2.2
    public function addColumMultipleInPromo()
    {
        $sql = "ALTER TABLE p_promo ADD column is_multiple ENUM('y','n') DEFAULT 'n' AFTER is_active";
        $query = $this->db->query($sql);
        $result = 0;
        if ($query) {
            $result = 1;
        }
        return $result;
    }

    public function create_tb_version()
    {
        $sql = "CREATE TABLE `tb_version` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `version` varchar(255) DEFAULT NULL,
            `update_by` varchar(255) DEFAULT NULL,
            `update_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
          )";
        $result = 0;
        if ($this->db->query($sql)) {
            $result = 1;
        }
        return $result;
    }
}
