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

    public function downloadFileZip()
    {
        // URL API yang akan diambil
        $api_url = 'http://103.135.26.106:23407/pandurasa-whs/version/getVersion';

        // Inisialisasi cURL session
        $ch = curl_init();

        // Set pengaturan cURL
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Eksekusi cURL dan tangkap respons
        $response = curl_exec($ch);

        // Mendapatkan kode status HTTP
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Menutup session cURL
        curl_close($ch);

        // Menampilkan respons API
        if ($http_status === 200) {
            if ($response !== false) {
                $data = json_decode($response, true);
                if (isset($data['success'])) {
                    if ($data['success'] == true && $data['file_exists'] == true) {
                        $zipName = $data['version']['file_name'];
                        $url = $data['file_path'];
                        $this->updateAplikasi($zipName, $url);
                    }
                }
            } else {
                echo "Gagal mengambil data dari API.";
                exit;
            }
        } else {
            echo "Not Found";
            exit;
        }
    }

    function updateAplikasi($zipName, $url)
    {
        $zipFile = $zipName; // Nama file ZIP yang akan diunduh
        $fileUrl = $url . $zipFile; // Ganti dengan URL aktual file ZIP
        $wadahDir = 'file_update/';
        $extractPath = 'application/'; // Path tempat file ZIP akan diekstrak

        // Unduh file ZIP dari server
        // Periksa apakah direktori 'wadah/' sudah ada. Jika tidak, buat direktori tersebut.
        if (!file_exists($wadahDir)) {
            mkdir($wadahDir, 0777, true); // Membuat direktori 'wadah/' dengan izin 0777 (terserah Anda)
        }

        file_put_contents($wadahDir . $zipFile, fopen($fileUrl, 'r'));

        // Ekstrak file ZIP
        if (!file_exists($extractPath)) {
            mkdir($extractPath, 0777, true); // Membuat direktori 'wadah/' dengan izin 0777 (terserah Anda)
        }

        $zip = new ZipArchive;
        if ($zip->open($wadahDir . $zipFile) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
            echo 'Update berhasil diekstrak dan diinstal.';
        } else {
            echo 'Gagal mengekstrak update.';
        }

        // Hapus file ZIP setelah diekstrak
        // unlink($zipFile);
    }
}
