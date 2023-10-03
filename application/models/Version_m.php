<?php defined('BASEPATH') or exit('No direct script access allowed');

class Version_m extends CI_Model
{

    public function getDateTime()
    {
        // Set zona waktu ke Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');

        // Mendapatkan tanggal dan waktu saat ini di zona waktu Jakarta
        $currentDateTime = date('Y-m-d H:i:s');
        return $currentDateTime;
    }

    public function getVersion()
    {
        $sql = "select * from tb_version
        order by id desc
        limit 1";
        $query = $this->db->query($sql);
        return $query;
    }

    public function insertVersion($post)
    {
        $user_id = $this->session->userdata('userid');
        $params = array(
            'version' => $post['new_version'],
            'update_by' => $user_id,
            'update_at' => $this->getDateTime()
        );
        $query = $this->db->insert('tb_version', $params);
        return $query;
    }
}
