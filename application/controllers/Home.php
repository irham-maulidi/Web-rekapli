<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

 	public function __construct()
    {
        parent::__construct();
        $this->load->model('m_homes');
        $this->auth->auth();
    }

	public function index()
	{
        $this->load->helper('form');
        $data['title'] = "Arsip Rekap LI | Sungram";
        $data['action'] = "";
        $data['content'] = 'home';
		$this->load->view('index', $data);
	}

    public function result()
    {
        $keyword = $this->input->get('keyword', TRUE);

        if (is_null($keyword)) {
            $this->load->helper('form');
        } else {
            $this->load->model('m_homes');
            $this->load->helper('form');
            $data['result'] = $this->m_homes->get_result($keyword);
            $data['keyword'] = $keyword;
            $this->load->view('result', $data);
        }
    }

    public function view($s_id)
    {
        $this->load->helper('form');
        $s_id = $this->uri->segment(3);
        $data['school'] = $this->m_homes->get_data($s_id);
        $data['title'] = $data['school']['s_name']." &minus; Arsip Rekap LI | Sungram";
        $data['attachment'] = 'Lampiran';
        $data['content'] = 'result-view';

        if (!$s_id) {
            redirect(site_url());
        } else {
            $this->load->view('index', $data);
        }
    }

    public function print_data()
    {
        $s_id = $this->uri->segment(3);
        $data['school'] = $this->m_homes->get_data($s_id);
        $data['title'] = $data['school']['s_name']." &minus; Arsip Rekap LI | Sungram";
        $data['attachment'] = 'Lampiran';
        if (!$s_id) {
            redirect(site_url());
        } else {
            $this->load->view('result-print', $data);
        }
    }
}
