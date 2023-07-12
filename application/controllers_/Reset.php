<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reset extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        // $this->load->model('category_m');
    }

    function reset_data()
    {
        $user_id = $this->session->userdata('userid');
        if ($user_id == 1) {
            $this->db->query("delete from t_sale");
            $this->db->query("delete from t_sale_detail");
            $this->db->query("delete from t_stock");
            $this->db->query("delete from tb_item_produksi");
            $this->db->query("delete from tb_item_produksi_detail");
            $this->db->query("delete from tb_transfer_stock");
            $this->db->query("delete from tb_transfer_stock_detail");
            if ($this->db->affected_rows() > 0) {
                echo "Data telah direset";
            }
        } else {
            echo "Access Denied";
        }
    }

    function delete_data(){
        //Hapus data sales berdasarkan tanggal
        if($user_id = $this->session->userdata('userid') == 1){
            // echo "Access Granted";
            $this->template->load('template','/reset/view_delete_data.php');
        }else{
            echo "Access Denied";
        }
    }

    function delete_data_sales(){
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        var_dump($start_date);
        var_dump($end_date);
    }

    function reset_item()
    {
        $user_id = $this->session->userdata('userid');
        if ($user_id == 1) {
            if (!empty($_POST)) {
                $exp_date = $_POST['exp_date'];
                $qty = $_POST['qty'];
                $this->db->query("delete from p_item_detail");
                $sql = "insert into p_item_detail(item_id, item_code,barcode, name, qty, exp_date, created_by)
                    select item_id, item_code,barcode, name, '$qty', '$exp_date', '$user_id' from p_item";
                $this->db->query($sql);
                if ($this->db->affected_rows() > 0) {
                    echo "Stock Item Telah Direset";
                } else {
                    echo "Gagal";
                }
            } else {
                echo "Tidak Ada Post";
            }
            $this->template->load('template', 'reset_item');
        } else {
            echo "Access Denied";
        }
    }

    function delete_all_item_detail()
    {
        if ($this->session->userdata('userid') == 1) {
            $this->db->query("delete from p_item_detail");
            if($this->db->affected_rows() > 0){
                echo "Success";
            }else{
                echo "Failed";
            }
        } else {
            echo "Access Denied";
        }
    }
}
