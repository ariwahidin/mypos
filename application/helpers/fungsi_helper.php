<?php

function check_already_login()
{
    $ci = &get_instance();
    $user_session = $ci->session->userdata('userid');
    if ($user_session) {
        redirect('dashboard');
    }
}

function check_not_login()
{
    $ci = &get_instance();
    $user_session = $ci->session->userdata('userid');
    if (!$user_session) {
        redirect('auth/login');
    }
}

function check_admin()
{
    $ci = &get_instance();
    $ci->load->library('fungsi');
    if ($ci->fungsi->user_login()->level != 1) {
        redirect('dashboard');
    }
}

function indo_currency($nominal)
{
    $result = 'Rp ' . number_format($nominal, 2, ',', '.');
    return $result;
}

function indo_date_time()
{
    $timezone = new DateTimeZone('Asia/Jakarta');
    $date = new DateTime();
    $date->setTimeZone($timezone);
    return $date->format('d/m/Y H:i:s');
}

function international_date_time()
{
    $timezone = new DateTimeZone('Asia/Jakarta');
    $date = new DateTime();
    $date->setTimeZone($timezone);
    return $date->format('Y-m-d H:i:s');
}

function indo_date_only()
{
    $timezone = new DateTimeZone('Asia/Jakarta');
    $date = new DateTime();
    $date->setTimeZone($timezone);
    return $date->format('d/m/Y');
}

function indo_date($date)
{
    $d = substr($date, 8, 2);
    $m = substr($date, 5, 2);
    $y = substr($date, 0, 4);
    return $d . '/' . $m . '/' . $y;
}

function get_total_item($sale_id)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(qty) as total_item FROM t_sale_detail WHERE sale_id = '$sale_id'";
    $query = $ci->db->query($sql);
    return $query->row()->total_item;
}

function type_bayar($id)
{
    $ci = &get_instance();
    $sql = "SELECT type_bayar FROM type_bayar WHERE id = '$id'";
    $query = $ci->db->query($sql);
    return $query->row()->type_bayar;
}

function barcode_exists($barcode)
{
    $ci = &get_instance();
    $sql = "select barcode from p_item where barcode = '$barcode'";
    $query = $ci->db->query($sql);
    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

function item_is_update($barcode, $harga_jual, $harga_bersih)
{
    $ci = &get_instance();
    $sql = "select * from p_item where barcode = '$barcode' and ROUND(harga_jual,0) = ROUND('$harga_jual',0) and ROUND(harga_bersih,0) = ROUND('$harga_bersih',0)";
    $query = $ci->db->query($sql);
    if ($query->num_rows() > 0) {
        return false;
    } else {
        return true;
    }
}

function get_counter()
{
    $ci = &get_instance();
    $sql = "SELECT * FROM t_toko WHERE is_active = 'y'";
    $query = $ci->db->query($sql);
    return $query->row();
}

function barcode_is_exits($barcode)
{
    $ci = &get_instance();
    $url = 'http://119.110.68.194/pandurasa-whs/item/barcode_exists';
    $toko = $ci->db->query("SELECT * FROM t_toko WHERE is_active = 'y'")->row();
    $post = [
        'kode_seller' => $toko->kode_seller,
        'kode_area' => $toko->kode_area,
        'kode_counter' => $toko->code_store,
        'barcode' => $barcode,
    ];
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($post),
        ],
    ];
    $response = file_get_contents($url, false, stream_context_create($options));
    $result = json_decode($response);

    if ($result->success == true) {
        return true;
    } else {
        return false;
    }
}

function my_api()
{
    $api_address = 'http://103.135.26.106:23407/pandurasa-whs/';
    return $api_address;
}

function test_koneksi()
{
    $url = my_api() . 'test/test_connection_post';
    $post_data = ['post' => 'ini isi data post'];
    $api = post_curl($url, $post_data);
    return $api;
}

function post_curl($url, $post_data)
{
    $client = curl_init($url);
    $data_json = json_encode($post_data);
    $post = [
        'data_post' => $data_json,
    ];
    curl_setopt($client, CURLOPT_POST, 1);
    curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($post));
    curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($client);
    $status_code = curl_getinfo($client, CURLINFO_HTTP_CODE);
    curl_close($client);

    if ($status_code == 200) {
        $result = [
            'status_code' => $status_code,
            'data' => json_decode($response),
        ];
    } else {
        $result = [
            'status_code' => $status_code,
        ];
    }

    return $result;
}

function get_curl($u)
{
    $url = 'http://103.135.26.106:23407/pandurasa-whs/'.$u;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}
