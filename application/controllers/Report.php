<?php defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['sale_m', 'item_m', 'supplier_m']);
    }

    public function sale()
    {
        $this->load->model('customer_m');
        $this->load->library('pagination');
        $download = false;

        if (isset($_POST['reset'])) {
            $this->session->unset_userdata('search');
        }

        if (isset($_POST['filter'])) {
            $post = $this->input->post(null, TRUE);
            $this->session->set_userdata('search', $post);
        } else {
            $post = $this->session->set_userdata('search');
        }

        if (isset($_POST['summary_sales'])) {
            $summary = $this->sale_m->get_summary_sales($_POST);
            if ($summary->num_rows() > 0) {
                $data = array(
                    'summary' => $summary,
                );
                $this->load->view('report/summary', $data);
                // $this->sale();
                return false;
            } else {
                $this->session->set_flashdata('error', 'Data yang dicari tidak tersedia');
                redirect('report/sale');
                return false;
            }
        }

        if (isset($_POST['summary_detail'])) {
            $detail = $this->sale_m->get_detail_penjualan($_POST);

            if ($detail->num_rows() > 0) {

                $data = array(
                    'detail' => $detail,
                );

                $this->load->view('report/detail', $data);
                return false;
            } else {

                $this->session->set_flashdata('error', 'Data yang di cari tidak tersedia');
                redirect('report/sale');
                return false;
            }
        }

        if (isset($_POST['cms_bri'])) {
            // var_dump($_POST);
            if ($_POST['date1'] != '' && $_POST['date2'] != '') {
                $data_sale = $this->sale_m->get_cms_bri($_POST);
                if ($data_sale->num_rows() > 0) {
                    $string = 'date,sales_no,nilai,service_charge,receipt_no' . PHP_EOL;
                    foreach ($data_sale->result() as $dt) {
                        $string .= date('d/m/Y h:i:s', strtotime($dt->created)) . '|' . $dt->invoice . '|' . (float)$dt->final_price . '|' . (float)$dt->service . '|' . $dt->invoice . PHP_EOL;
                    }
                    $file = "output_cms/" . 'R[NOPD]' . date('Ymdhis', strtotime($data_sale->row()->created)) . '.txt';
                    $txt = fopen($file, "w") or die("Unable to open file!");
                    fwrite($txt, $string);
                    fclose($txt);
                    header('Content-Description: File Transfer');
                    header('Content-Disposition: attachment; filename=' . basename($file));
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    header("Content-Type: text/plain");
                    readfile($file);
                }
            }
        }

        $config['base_url'] = site_url('report/sale');
        $config['total_rows'] = $this->sale_m->get_sale_pagination()->num_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['customer'] = $this->customer_m->get()->result();
        $data['row'] = $this->sale_m->get_sale_pagination($config['per_page'], $this->uri->segment(3));
        $data['post'] = $post;
        $data['download'] = $download;
        $this->template->load('template', 'report/sale_report', $data);
    }

    public function sale_product($sale_id = null)
    {
        $detail = $this->sale_m->get_sale_detail($sale_id)->result();
        echo json_encode($detail);
    }

    public function daily(){
        $daily = $this->sale_m->get_sales_daily();
        $sum_daily = $this->sale_m->get_sum_daily();
        $tax = $this->db->query("select tax_value from tax")->row()->tax_value / 100;
        $data = array(
            'daily' => $daily,
            'sum' => $sum_daily,
            'tax' => $tax
        );
        $this->template->load('template', 'report/sales_daily', $data);
    }
}
