<?php defined('BASEPATH') or exit('No direct script access allowed');

class Version extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['migrasi_m']);
    }

    public function index()
    {
        $data = array();
        $this->template->load('template', 'version/index');
    }

    public function cekVersion()
    {
        $url = 'Version/getVersion';
        $api = get_curl($url);

        if ($api['success'] == true) {
            var_dump($api);
            $response = array(
                'icon' => 'success',
                'message' => 'Data tersedia',
                'success' => true
            );
        } else {
            $response = array(
                'success' => false,
                'icon' => 'error',
                'message' => 'Tidak ada data',
            );
        }
        echo json_encode($response);
    }
}
