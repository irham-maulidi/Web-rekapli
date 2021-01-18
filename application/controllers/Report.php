<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

 	public function __construct()
    {
        parent::__construct();
        $this->auth->restrict();
        $this->load->model('m_reports');
    }

    public function index()
    {

        $s_instansi = $this->input->get('s_instansi', TRUE);
        $m_id = $this->input->get('m_id', TRUE);
        $s_status = $this->input->get('s_status', TRUE);

        if ($_GET) {
            sleep(1);

            $where = "s_instansi = '$s_instansi' AND m_id = '$m_id' AND s_status = '$s_status' AND s_is_active = 'Aktif' AND s_is_deleted = 'FALSE'";

            $data['result'] = $this->m_reports->get_result($where);
            $data['title'] = "Rekap Laporan &minus; Arsip Rekap LI | Sungram";
            $data['instansi'] = $this->input->get('s_instansi', TRUE);
            $data['major'] = $this->input->get('m_id', TRUE);
            $data['status'] = $this->input->get('s_status', TRUE);
            $this->load->view('dashboard/report-result', $data);
        } else {
            $this->load->helper('form');
            $where = "m_is_deleted = 'FALSE'";
            $data['majors'] = $this->m_reports->get_major($where);
            $data['title'] = "Rekap Laporan &minus; Arsip Rekap LI | Sungram";
            $data['content'] = "dashboard/report";


            $this->load->view('dashboard/index', $data);
        }
    }

    private function validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('s_instansi', 'Pilih Instansi', 'trim|required');
        $this->form_validation->set_rules('m_initial', 'Pilih Kecamatan', 'trim|required');
        $this->form_validation->set_rules('s_status', 'Status Kelengkapan Data', 'trim|required');
        return $this->form_validation->run();
    }
}
