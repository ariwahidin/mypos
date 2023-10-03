<?php defined('BASEPATH') or exit('No direct script access allowed');

class Version extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['migrasi_m', 'version_m']);
    }

    public function index()
    {
        $data = array();
        $this->template->load('template', 'version/index');
    }

    public function checkingVersion()
    {
        // URL API yang akan diambil
        $api_url = my_api().'version/getVersion';

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

        $current_version = $this->version_m->getVersion();
        $result = array();

        // Menampilkan respons API
        if ($http_status === 200) {
            if ($response !== false) {
                $data = json_decode($response, true);
                if (isset($data['success'])) {
                    if ($data['success'] == true && $data['file_exists'] == true) {
                        $zipName = $data['version']['file_name'];
                        $url = $data['file_path'];
                        $new_version = $data['version']['version'];
                        $res = array(
                            'new_version' => $new_version,
                            'zip_name' => $zipName,
                            'url' => $url,
                        );
                        if ($current_version->num_rows() > 0) {
                            if ($current_version->row()->version == $new_version) {
                                $result = array(
                                    'success' => false,
                                    'message' => 'Aplikasi POS is up to date',
                                    'note' => 'Tidak ada update'
                                );
                            } else {
                                $result = array(
                                    'success' => true,
                                    'message' => 'File update tersedia',
                                    'note' => 'Apakah anda ingin melakukan update?',
                                    'data' => $res
                                );
                            }
                        } else {
                            $result = array(
                                'success' => true,
                                'message' => 'File update tersedia',
                                'note' => 'Apakah anda ingin melakukan update?',
                                'data' => $res
                            );
                        }
                    } else {
                        $result = array(
                            'success' => false,
                            'message' => 'File update tidak ditemukan',
                            'note' => ''
                        );
                    }
                } else {
                    $result = array(
                        'success' => false,
                        'message' => 'Tidak ada data',
                        'note' => ''
                    );
                }
            } else {
                $result = array(
                    'success' => false,
                    'message' => 'Tidak ada response',
                    'note' => ''
                );
            }
        } else {
            $result = array(
                'success' => false,
                'message' => 'Tidak terhubung',
                'note' => 'Cek koneksi internet'
            );
        }
        echo json_encode($result);
    }

    function updateAplikasi()
    {
        $post = $this->input->post();
        $newVersion = $post['new_version'];
        $zipName = $post['zip_name'];
        $url = $post['url'];

        $response = array();

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
            $response['message'] = 'Update berhasil diinstall';
            $updateTable = $this->updateTable();
            $this->version_m->insertVersion($post);
            if ($this->db->affected_rows() > 0) {
                $response['success'] = true;
                $response['updated_table'] = $updateTable;
            } else {
                $response['success'] = false;
            }
            // echo 'Update berhasil diekstrak dan diinstal.';
        } else {
            $response = array(
                'success' => false,
                'message' => 'Gagal install'
            );
            // echo 'Gagal mengekstrak update.';
        }

        // Hapus file ZIP setelah diekstrak
        // unlink($zipFile);

        echo json_encode($response);
    }

    public function updateTable()
    {
        $result = 0;
        $t1 = $this->migrasi_m->addColumMultipleInPromo();
        $t2 = $this->migrasi_m->create_tb_version();
        return $t1 + $t2;
    }
}
