<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backup extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
    }

    function index()
    {
        if ($this->input->post()) {
            $this->load->dbutil();
            $code_store = $this->db->query("select * from t_toko")->row()->code_store;
            $db_name = 'backup-db-' . $this->db->database .'-'.$code_store. '-on-' . date("Y-m-d-H-i-s") . '.sql';

            $prefs = array(
                'format' => 'zip',
                'filename' => $db_name,
                'add_insert' => TRUE,
                'foreign_key_checks' => FALSE,
            );

            $backup = $this->dbutil->backup($prefs);
            $save = 'pathtobkfolder' . $db_name;

            // buat file
            $this->load->helper('file');
            write_file($save, $backup);

            // download file
            $this->load->helper('download');
            force_download($db_name, $backup);
        }

        $printer = $this->db->query("select * from tb_printer");
        $data = array(
            'printer' => $printer
        );
        $this->template->load('template', 'backup/backup_data', $data);
    }
}
