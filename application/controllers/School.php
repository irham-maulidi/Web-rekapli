<?php defined('BASEPATH') OR exit('No direct script access allowed');

class school extends CI_Controller {

 	public function __construct()
    {
        parent::__construct();
        $this->load->model('m_schools');
        $this->auth->restrict();
    }

    private static $title = "sekolah &minus; Arsip Arsip Digital Rekap LI";
    private static $table = 'schools';
    private static $primaryKey = 's_id';

    public function index()
	{
        $data['title'] = "Data ".self::$title;
        $data['content'] = "dashboard/school";
		$this->load->view('dashboard/index', $data);
	}

    public function get_data()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $this->load->library('datatables_ssp');
            $columns = array(
                array('db' => 's_npsn', 'dt' => 's_npsn'),
                array('db' => 's_name', 'dt' => 's_name'),
                array('db' => 's_dob', 'dt' => 's_dob'),
                array('db' => 's_statussekolah', 'dt' => 's_statussekolah'),
                array('db' => 's_instansi', 'dt' => 's_instansi'),
                array('db' => 'm_id', 'dt' => 'm_id'),
                array('db' => 's_status', 'dt' => 's_status'),
                array(
                    'db' => 's_id',
                    'dt' => 'tindakan',
                    'formatter' => function($s_id) {
                        return '<a class="btn btn-warning btn-sm mb" href="'.site_url('school/print_data/'.$s_id).'" target="_blank" title="Cetak"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
                        <a class="btn btn-success btn-sm mb" href="'.site_url('school/view/'.$s_id).'">Lihat</a>
                        <a class="btn btn-info btn-sm mb" href="'.site_url('school/edit/'.$s_id).'">Ubah</a>
                        <a class="btn btn-danger btn-sm mb" onclick="return confirmDialog();" href="'.site_url('school/delete/'.$s_id).'" title="Hapus"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            <a class="btn btn-default btn-sm mb" href="'.site_url('school/status/'.$s_id).'" onclick="return confirmDialogStatus();">Kirim Data</a>'; 
                    } 
                ), 
            );

            $sql_details = [
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            ];

            $qjoin = "JOIN majors ON majors.m_id = schools.s_kec";


            if($this->session->userdata('u_level') == 'User Biasa'){

                $user_id = $this->session->userdata('u_id');

                echo json_encode(
                    Datatables_ssp::complex($_GET, $sql_details, self::$table, self::$primaryKey, $columns, NULL, "s_is_active = 'Aktif' AND s_is_deleted = 'FALSE' AND u_id = '$user_id'", $qjoin )
                );
            } else{
                echo json_encode(
                    Datatables_ssp::complex($_GET, $sql_details, self::$table, self::$primaryKey, $columns, NULL, "s_is_active = 'Aktif' AND s_is_deleted = 'FALSE'", $qjoin )
                );
            }
        }
    }

    private function validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('s_npsn', 'NPSN', 'trim|required');
        $this->form_validation->set_rules('s_name', 'Nama Sekolah', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('s_dob', 'Izin Operasional', 'trim|required');
        $this->form_validation->set_rules('s_statussekolah', 'Status Sekolah', 'trim|required');
        $this->form_validation->set_rules('s_instansi', 'Instansi', 'trim|required|max_length[4]');
        $this->form_validation->set_rules('s_kec', 'Kecamatan', 'trim|required|max_length[4]');
        // $this->form_validation->set_rules('s_yi', 'Tahun Masuk', 'trim|required|max_length[4]');
        $this->form_validation->set_rules('s_status', 'Status Data', 'trim|required');
        return $this->form_validation->run();
    }

    public function add()
    {
        $this->load->helper(['form', 'string', 'notification']);

        if ($this->validation()) {
            $s_npsn = $this->input->post('s_npsn', TRUE);
            $where = "s_npsn = '$s_npsn'";
            $data = $this->m_schools->is_exist($where);

            if ($data['s_npsn'] === $this->input->post('s_npsn', TRUE)) {
                $this->session->set_flashdata('alert', error('NPSN sudah ada sudah ada!'));
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);

            } else {
                $s_id = random_string('alnum', 10);

                $s_foto = $_FILES['s_foto']['name'];
                $s_sp = $_FILES['s_sp']['name'];
                $s_spn = $_FILES['s_spn']['name'];
                $s_li = $_FILES['s_li']['name'];
                $s_ps = $_FILES['s_ps']['name'];
                $s_pd = $_FILES['s_pd']['name'];
                $s_rb = $_FILES['s_rb']['name'];
                $s_spr = $_FILES['s_spr']['name'];
                $s_dp = $_FILES['s_dp']['name'];
                $s_jp = $_FILES['s_jp']['name'];

                $this->load->library('upload');
                // $this->upload->initialize($config);

                if (!empty($s_foto)) {
                    $config['upload_path'] = './uploads/foto/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['file_ext_tolower'] = TRUE;
                    $config['max_size'] = '30024';
                    $config['overwrite'] = TRUE;
                    $x = explode(".", $s_foto);
                    $ext = strtolower(end($x));
                    $config['file_name'] = $s_id."-foto.".$ext;
                    $foto = $config['file_name'];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('s_foto');
                }

                if (!empty($s_sp)) {
                    $config['upload_path'] = './uploads/Surat_Pengantar/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_ext_tolower'] = TRUE;
                    $config['max_size'] = '30024';
                    $config['overwrite'] = TRUE;
                    $x = explode(".", $s_sp);
                    $ext = strtolower(end($x));
                    $config['file_name'] = $s_id."-sp.".$ext;
                    $sp = $config['file_name'];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('s_sp');
                }

                if (!empty($s_spn)) {
                    $config['upload_path'] = './uploads/Surat_Pernyataan/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_ext_tolower'] = TRUE;
                    $config['max_size'] = '30024';
                    $config['overwrite'] = TRUE;
                    $x = explode(".", $s_spn);
                    $ext = strtolower(end($x));
                    $config['file_name'] = $s_id."-spn.".$ext;
                    $spn = $config['file_name'];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('s_spn');
                }

                if (!empty($s_li)) {
                    $config['upload_path'] = './uploads/Usulan_Rekap/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_ext_tolower'] = TRUE;
                    $config['max_size'] = '30024';
                    $config['overwrite'] = TRUE;
                    $x = explode(".", $s_li);
                    $ext = strtolower(end($x));
                    $config['file_name'] = $s_id."-li.".$ext;
                    $li = $config['file_name'];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('s_li');
                }

                if (!empty($s_ps)) {
                    $config['upload_path'] = './uploads/Profil_Sekolah/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_ext_tolower'] = TRUE;
                    $config['max_size'] = '30024';
                    $config['overwrite'] = TRUE;
                    $x = explode(".", $s_ps);
                    $ext = strtolower(end($x));
                    $config['file_name'] = $s_id."-ps.".$ext;
                    $ps = $config['file_name'];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('s_ps');
                }

                if (!empty($s_pd)) {
                    $config['upload_path'] = './uploads/Peserta_Didik/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_ext_tolower'] = TRUE;
                    $config['max_size'] = '30024';
                    $config['overwrite'] = TRUE;
                    $x = explode(".", $s_pd);
                    $ext = strtolower(end($x));
                    $config['file_name'] = $s_id."-pd.".$ext;
                    $pd = $config['file_name'];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('s_pd');
                }

                if (!empty($s_rb)) {
                    $config['upload_path'] = './uploads/Rombongan_Belajar/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_ext_tolower'] = TRUE;
                    $config['max_size'] = '30024';
                    $config['overwrite'] = TRUE;
                    $x = explode(".", $s_rb);
                    $ext = strtolower(end($x));
                    $config['file_name'] = $s_id."-rb.".$ext;
                    $rb = $config['file_name'];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('s_rb');
                }

                if (!empty($s_spr)) {
                    $config['upload_path'] = './uploads/Sarana&Prasarana/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_ext_tolower'] = TRUE;
                    $config['max_size'] = '30024';
                    $config['overwrite'] = TRUE;
                    $x = explode(".", $s_spr);
                    $ext = strtolower(end($x));
                    $config['file_name'] = $s_id."-spr.".$ext;
                    $spr = $config['file_name'];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('s_spr');
                }

                if (!empty($s_dp)) {
                    $config['upload_path'] = './uploads/Daftar_Pendidik/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_ext_tolower'] = TRUE;
                    $config['max_size'] = '30024';
                    $config['overwrite'] = TRUE;
                    $x = explode(".", $s_dp);
                    $ext = strtolower(end($x));
                    $config['file_name'] = $s_id."-dp.".$ext;
                    $dp = $config['file_name'];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('s_dp');
                }

                if (!empty($s_jp)) {
                    $config['upload_path'] = './uploads/Jadwal_Pembelajaran/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_ext_tolower'] = TRUE;
                    $config['max_size'] = '30024';
                    $config['overwrite'] = TRUE;
                    $x = explode(".", $s_jp);
                    $ext = strtolower(end($x));
                    $config['file_name'] = $s_id."-jp.".$ext;
                    $jp = $config['file_name'];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('s_jp');
                }

                if (!empty($s_foto) && !$this->upload->do_upload('s_foto')) {
                    $data['err_foto'] = $this->upload->display_errors();
                    $where = "m_is_deleted = 'False'";
                    $data['majors'] = $this->m_schools->get_majors($where);
                    $data['title'] = "Tambah ".self::$title;
                    $data['form_title'] = "Tambah sekolah";
                    $data['action'] = site_url(uri_string());
                    $data['content'] = 'dashboard/school-form';
                    $this->load->view('dashboard/index', $data);

                } else if (!empty($s_sp) && !$this->upload->do_upload('s_sp')) {
                    $data['err_sp'] = $this->upload->display_errors();
                    $where = "m_is_deleted = 'False'";
                    $data['majors'] = $this->m_schools->get_majors($where);
                    $data['title'] = "Tambah ".self::$title;
                    $data['form_title'] = "Tambah sekolah";
                    $data['action'] = site_url(uri_string());
                    $data['content'] = 'dashboard/school-form';
                    $this->load->view('dashboard/index', $data);

                } else if (!empty($s_spn) && !$this->upload->do_upload('s_spn')) {
                    $data['err_spn'] = $this->upload->display_errors();
                    $where = "m_is_deleted = 'False'";
                    $data['majors'] = $this->m_schools->get_majors($where);
                    $data['title'] = "Tambah ".self::$title;
                    $data['form_title'] = "Tambah sekolah";
                    $data['action'] = site_url(uri_string());
                    $data['content'] = 'dashboard/school-form';
                    $this->load->view('dashboard/index', $data);

                } else if (!empty($s_li) && !$this->upload->do_upload('s_li')) {
                    $data['err_li'] = $this->upload->display_errors();
                    $where = "m_is_deleted = 'False'";
                    $data['majors'] = $this->m_schools->get_majors($where);
                    $data['title'] = "Tambah ".self::$title;
                    $data['form_title'] = "Tambah sekolah";
                    $data['action'] = site_url(uri_string());
                    $data['content'] = 'dashboard/school-form';
                    $this->load->view('dashboard/index', $data);

                } else if (!empty($s_ps) && !$this->upload->do_upload('s_ps')) {
                    $data['err_ps'] = $this->upload->display_errors();
                    $where = "m_is_deleted = 'False'";
                    $data['majors'] = $this->m_schools->get_majors($where);
                    $data['title'] = "Tambah ".self::$title;
                    $data['form_title'] = "Tambah sekolah";
                    $data['action'] = site_url(uri_string());
                    $data['content'] = 'dashboard/school-form';
                    $this->load->view('dashboard/index', $data);

                } else if (!empty($s_pd) && !$this->upload->do_upload('s_pd')) {
                    $data['err_pd'] = $this->upload->display_errors();
                    $where = "m_is_deleted = 'False'";
                    $data['majors'] = $this->m_schools->get_majors($where);
                    $data['title'] = "Tambah ".self::$title;
                    $data['form_title'] = "Tambah sekolah";
                    $data['action'] = site_url(uri_string());
                    $data['content'] = 'dashboard/school-form';
                    $this->load->view('dashboard/index', $data);

                } else if (!empty($s_rb) && !$this->upload->do_upload('s_rb')) {
                    $data['err_rb'] = $this->upload->display_errors();
                    $where = "m_is_deleted = 'False'";
                    $data['majors'] = $this->m_schools->get_majors($where);
                    $data['title'] = "Tambah ".self::$title;
                    $data['form_title'] = "Tambah sekolah";
                    $data['action'] = site_url(uri_string());
                    $data['content'] = 'dashboard/school-form';
                    $this->load->view('dashboard/index', $data);

                } else if (!empty($s_spr) && !$this->upload->do_upload('s_spr')) {
                    $data['err_spr'] = $this->upload->display_errors();
                    $where = "m_is_deleted = 'False'";
                    $data['majors'] = $this->m_schools->get_majors($where);
                    $data['title'] = "Tambah ".self::$title;
                    $data['form_title'] = "Tambah sekolah";
                    $data['action'] = site_url(uri_string());
                    $data['content'] = 'dashboard/school-form';
                    $this->load->view('dashboard/index', $data);

                } else if (!empty($s_dp) && !$this->upload->do_upload('s_dp')) {
                    $data['err_pd'] = $this->upload->display_errors();
                    $where = "m_is_deleted = 'False'";
                    $data['majors'] = $this->m_schools->get_majors($where);
                    $data['title'] = "Tambah ".self::$title;
                    $data['form_title'] = "Tambah sekolah";
                    $data['action'] = site_url(uri_string());
                    $data['content'] = 'dashboard/school-form';
                    $this->load->view('dashboard/index', $data);
                    
                } else if (!empty($s_jp) && !$this->upload->do_upload('s_jp')) {
                    $data['err_jp'] = $this->upload->display_errors();
                    $where = "m_is_deleted = 'False'";
                    $data['majors'] = $this->m_schools->get_majors($where);
                    $data['title'] = "Tambah ".self::$title;
                    $data['form_title'] = "Tambah sekolah";
                    $data['action'] = site_url(uri_string());
                    $data['content'] = 'dashboard/school-form';
                    $this->load->view('dashboard/index', $data);        

                } else {

                    $data = [
                        's_id' => $s_id,
                        'u_id' => $this->session->userdata('u_id'),
                        's_npsn' => $this->input->post('s_npsn', TRUE),
                        's_npsn' => $this->input->post('s_npsn', TRUE),
                        's_name' => $this->input->post('s_name', TRUE),
                        's_dob' => $this->input->post('s_dob', TRUE),
                        's_statussekolah' => $this->input->post('s_statussekolah', TRUE),
                        's_instansi' => $this->input->post('s_instansi', TRUE),
                        's_kec' => $this->input->post('s_kec', TRUE),
                        // 's_yi' => $this->input->post('s_yi', TRUE),
                        's_foto' => (!empty($foto)) ? $foto : NULL,
                        's_sp' => (!empty($sp)) ? $sp : NULL,
                        's_spn' => (!empty($spn)) ? $spn : NULL,
                        's_li' => (!empty($li)) ? $li : NULL,
                        's_ps' => (!empty($ps)) ? $ps : NULL,
                        's_pd' => (!empty($pd)) ? $pd : NULL,
                        's_rb' => (!empty($rb)) ? $rb : NULL,
                        's_spr' => (!empty($spr)) ? $spr : NULL,
                        's_dp' => (!empty($dp)) ? $dp : NULL,
                        's_jp' => (!empty($jp)) ? $jp : NULL,
                        's_status' => $this->input->post('s_status', TRUE),
                        's_created_by' => $this->session->userdata['u_id'],
                        's_is_active' => 'Aktif'
                    ];

                    $this->m_schools->add($data);
                    $this->session->set_flashdata('alert', success('Data Sekolah berhasil ditambahkan.'));
                    $data['title'] = "Data ".self::$title;
                    $data['content'] = "dashboard/school";
                    redirect('school');
                }
            }

        } else {
            $where = "m_is_deleted = 'False'";
            $data['majors'] = $this->m_schools->get_majors($where);
            $data['title'] = "Tambah ".self::$title;
            $data['form_title'] = "Tambah sekolah";
            $data['s_name'] = "";
            $data['action'] = site_url(uri_string());
            $data['content'] = 'dashboard/school-form';
            $this->load->view('dashboard/index', $data);
        }
    }

    public function import()
    {
        $this->load->helper(['form', 'notification', 'string']);

        if (isset($_POST['import'])) {
            $file = $_FILES['scsv']['tmp_name'];

            if (empty($file)) {
                $this->session->set_flashdata('alert', error('Form file data sekolah wajib diisi!'));
                $data['title'] = "Impor Data ".self::$title;
                $data['form_title'] = "Impor Data sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-import';
                $this->load->view('dashboard/index', $data);
            }

            $eks = explode('.', $_FILES['scsv']['name']);

            if (strtolower(end($eks)) === 'csv') {
                $handle = fopen($file, "r");
                while (($row = fgetcsv($handle, 30024))) {

                    for ($i = 1; $i <= count($row) ; $i++) {
                        $s_id = random_string('alnum', 10);
                    }

                    $data = [
                        's_id' => $s_id,
                        's_npsn' => $row[1],
                        's_name' => $row[2],
                        's_dob' => $row[3],
                        's_statussekolah' => $row[4],
                        's_instansi' => $row[5],
                        's_kec' => $row[6],
                        's_yi' => $row[7],
                        's_yo' => $row[8],
                        's_foto' => NULL,
                        's_sp' => NULL,
                        's_spn' => NULL,
                        's_li' => NULL,
                        's_ps' => NULL,
                        's_pd' => NULL,
                        's_rb' => NULL,
                        's_spr' => NULL,
                        's_dp' => NULL,
                        's_jp' => NULL,
                        's_status' => 'Belum Ada Data',
                        's_created_at' => date('Y-m-d H:i:s'),
                        's_updated_at' => date('Y-m-d H:i:s'),
                        's_deleted_at' => NULL,
                        's_restored_at' => NULL,
                        's_created_by' => $this->session->userdata['u_id'],
                        's_updated_by' => $this->session->userdata['u_id'],
                        's_deleted_by' => NULL,
                        's_restored_by' => NULL,
                        's_is_deleted' => 'FALSE',
                        's_is_active' => 'Aktif'
                    ];

                    $this->db->insert(self::$table, $data);
                }

                fclose($handle);
                $this->session->set_flashdata('alert', success('Data sekolah berhasil diimport.'));
                $data['title'] = "Impor Data ".self::$title;
                $data['content'] = 'dashboard/school';
                redirect('school');

            } else {
                $this->session->set_flashdata('alert', error('Formal file yang diperbolehkan hanya *.csv.'));
                $data['title'] = "Impor Data ".self::$title;
                $data['form_title'] = "Impor Data Sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-import';
                $this->load->view('dashboard/index', $data);

            }
        } else {
            $data['title'] = "Impor Data ".self::$title;
            $data['form_title'] = "Impor Data sekolah";
            $data['action'] = site_url(uri_string());
            $data['content'] = 'dashboard/school-import';
            $this->load->view('dashboard/index', $data);
        }
    }

    public function view()
    {
        $s_id = $this->uri->segment(3);

        $where = "s_id = '$s_id'";

        $data['school'] = $this->m_schools->get_schools($where);
        $data['title'] = $data['school']['s_name']." &minus; Arsip Arsip Digital Rekap LI";
        $data['attachment'] = 'Lampiran';
        $data['content'] = 'dashboard/school-view';
        if (!$s_id) {
            redirect(site_url('school'));
        } else {
            $this->load->view('dashboard/index', $data);
        }
    }

    public function print_data()
    {
        $s_id = $this->uri->segment(3);

        $where = "s_id = '$s_id'";

        $data['school'] = $this->m_schools->get_schools($where);
        $data['title'] = $data['school']['s_name']." &minus; Arsip Arsip Digital Rekap LI";
        $data['attachment'] = 'Lampiran';
        if (!$s_id) {
            redirect(site_url('school'));
        } else {
            $this->load->view('dashboard/school-print', $data);
        }
    }

    public function status($s_id)
    {

         $this->load->helper('notification');
        $s_id = $this->uri->segment(3);

        $data = [
            's_yo' => date('Y'),
            's_updated_at' => date('Y-m-d H:i:s'),
            's_updated_by' => $this->session->userdata['u_id'],
            's_is_active' => 'Tidak Aktif'
        ];

        $this->m_schools->active($data, $s_id);
        $this->session->set_flashdata('alert', success('Status data sekolah berhasil dikirim.'));
        $data['title'] = "Data ".self::$title;
        $data['content'] = "dashboard/index";
        redirect(site_url('school'));
  //       $this->auth->not_admin();
  //       $this->load->helper('notification');

  //       $data = [
		// 	's_yo' => date('Y'),
		// 	's_updated_at' => date('Y-m-d H:i:s'),
		// 	's_updated_by' => $this->session->userdata['u_id'],
		// 	's_is_active' => 'Tidak Aktif'
		// ];

  //       $this->m_schools->status($data, $s_id);
  //       $this->session->set_flashdata('alert', success('Status data sekolah berhasil diperbarui.'));
  //       $data['title'] = "Data ".self::$title;
  //       $data['content'] = "dashboard/school";
  //       $this->load->view('dashboard/index', $data);
  //       redirect(site_url('school'));
    }

    public function edit()
    {
        $this->load->helper(['form', 'notification']);
        $s_id = $this->uri->segment(3);
        $where = "s_id = '$s_id'";
        $data['school'] = $this->m_schools->get_schools($where);

        if ($this->validation()) {

            $s_foto = $_FILES['s_foto']['name'];
            $s_sp = $_FILES['s_sp']['name'];
            $s_spn = $_FILES['s_spn']['name'];
            $s_li = $_FILES['s_li']['name'];
            $s_ps = $_FILES['s_ps']['name'];
            $s_pd = $_FILES['s_pd']['name'];
            $s_rb = $_FILES['s_rb']['name'];
            $s_spr = $_FILES['s_spr']['name'];
            $s_dp = $_FILES['s_dp']['name'];
            $s_jp = $_FILES['s_jp']['name'];

            $this->load->library('upload');

            if (!empty($s_foto)) {
                $config['upload_path'] = './uploads/foto/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '1024';
                $config['overwrite'] = TRUE;
                $x = explode(".", $s_foto);
                $ext = strtolower(end($x));
                $config['file_name'] = $s_id."-foto.".$ext;
                $foto = $config['file_name'];
                $this->upload->initialize($config);
                $this->upload->do_upload('s_foto');
            }

            if (!empty($s_sp)) {
                $config['upload_path'] = './uploads/Surat_Pengantar/';
                $config['allowed_types'] = 'pdf';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '1048576';
                $config['overwrite'] = TRUE;
                $x = explode(".", $s_sp);
                $ext = strtolower(end($x));
                $config['file_name'] = $s_id."-sp.".$ext;
                $sp = $config['file_name'];
                $this->upload->initialize($config);
                $this->upload->do_upload('s_sp');
            }

            if (!empty($s_spn)) {
                $config['upload_path'] = './uploads/Surat_Pernyataan/';
                $config['allowed_types'] = 'pdf';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '30024';
                $config['overwrite'] = TRUE;
                $x = explode(".", $s_spn);
                $ext = strtolower(end($x));
                $config['file_name'] = $s_id."-spn.".$ext;
                $spn = $config['file_name'];
                $this->upload->initialize($config);
                $this->upload->do_upload('s_spn');
            }

            if (!empty($s_li)) {
                $config['upload_path'] = './uploads/Usulan_Rekap/';
                $config['allowed_types'] = 'pdf';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '30024';
                $config['overwrite'] = TRUE;
                $x = explode(".", $s_li);
                $ext = strtolower(end($x));
                $config['file_name'] = $s_id."-li.".$ext;
                $li = $config['file_name'];
                $this->upload->initialize($config);
                $this->upload->do_upload('s_li');
            }

            if (!empty($s_ps)) {
                $config['upload_path'] = './uploads/Profil_Sekolah/';
                $config['allowed_types'] = 'pdf';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '30024';
                $config['overwrite'] = TRUE;
                $x = explode(".", $s_ps);
                $ext = strtolower(end($x));
                $config['file_name'] = $s_id."-ps.".$ext;
                $ps = $config['file_name'];
                $this->upload->initialize($config);
                $this->upload->do_upload('s_ps');
            }

            if (!empty($s_pd)) {
                $config['upload_path'] = './uploads/Peserta_Didik/';
                $config['allowed_types'] = 'pdf';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '30024';
                $config['overwrite'] = TRUE;
                $x = explode(".", $s_pd);
                $ext = strtolower(end($x));
                $config['file_name'] = $s_id."-pd.".$ext;
                $pd = $config['file_name'];
                $this->upload->initialize($config);
                $this->upload->do_upload('s_pd');
            }

            if (!empty($s_rb)) {
                $config['upload_path'] = './uploads/Rombongan_Belajar/';
                $config['allowed_types'] = 'pdf';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '30024';
                $config['overwrite'] = TRUE;
                $x = explode(".", $s_rb);
                $ext = strtolower(end($x));
                $config['file_name'] = $s_id."-rb.".$ext;
                $rb = $config['file_name'];
                $this->upload->initialize($config);
                $this->upload->do_upload('s_rb');
            }

            if (!empty($s_spr)) {
                $config['upload_path'] = './uploads/Sarana&Prasarana/';
                $config['allowed_types'] = 'pdf';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '30024';
                $config['overwrite'] = TRUE;
                $x = explode(".", $s_spr);
                $ext = strtolower(end($x));
                $config['file_name'] = $s_id."-spr.".$ext;
                $spr = $config['file_name'];
                $this->upload->initialize($config);
                $this->upload->do_upload('s_spr');
            }

             if (!empty($s_dp)) {
                $config['upload_path'] = './uploads/Daftar_Pendidik/';
                $config['allowed_types'] = 'pdf';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '30024';
                $config['overwrite'] = TRUE;
                $x = explode(".", $s_dp);
                $ext = strtolower(end($x));
                $config['file_name'] = $s_id."-dp.".$ext;
                $dp = $config['file_name'];
                $this->upload->initialize($config);
                $this->upload->do_upload('s_dp');
            }

             if (!empty($s_jp)) {
                $config['upload_path'] = './uploads/Jadwal_Pembelajaran/';
                $config['allowed_types'] = 'pdf';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '30024';
                $config['overwrite'] = TRUE;
                $x = explode(".", $s_jp);
                $ext = strtolower(end($x));
                $config['file_name'] = $s_id."-jp.".$ext;
                $jp = $config['file_name'];
                $this->upload->initialize($config);
                $this->upload->do_upload('s_jp');
            }

            if (!empty($s_foto) && !$this->upload->do_upload('s_foto')) {
                $data['err_foto'] = $this->upload->display_errors();
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);

            } else if (!empty($s_sp) && !$this->upload->do_upload('s_sp')) {
                $data['err_sp'] = $this->upload->display_errors();
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);

            } else if (!empty($s_spn) && !$this->upload->do_upload('s_spn')) {
                $data['err_spn'] = $this->upload->display_errors();
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);

            } else if (!empty($s_li) && !$this->upload->do_upload('s_li')) {
                $data['err_li'] = $this->upload->display_errors();
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);

            } else if (!empty($s_ps) && !$this->upload->do_upload('s_ps')) {
                $data['err_ps'] = $this->upload->display_errors();
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);

            } else if (!empty($s_pd) && !$this->upload->do_upload('s_pd')) {
                $data['err_pd'] = $this->upload->display_errors();
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);

            } else if (!empty($s_rb) && !$this->upload->do_upload('s_rb')) {
                $data['err_rb'] = $this->upload->display_errors();
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);

            } else if (!empty($s_spr) && !$this->upload->do_upload('s_spr')) {
                $data['err_spr'] = $this->upload->display_errors();
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);

            } else if (!empty($s_dp) && !$this->upload->do_upload('s_dp')) {
                $data['err_pd'] = $this->upload->display_errors();
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);
                    
            } else if (!empty($s_jp) && !$this->upload->do_upload('s_jp')) {
                $data['err_jp'] = $this->upload->display_errors();
                $where = "m_is_deleted = 'False'";
                $data['majors'] = $this->m_schools->get_majors($where);
                $data['title'] = "Tambah ".self::$title;
                $data['form_title'] = "Tambah sekolah";
                $data['action'] = site_url(uri_string());
                $data['content'] = 'dashboard/school-form';
                $this->load->view('dashboard/index', $data);    

            } else {

                $data = [
                    's_id' => $s_id,
                    's_npsn' => $this->input->post('s_npsn', TRUE),
                    's_npsn' => $this->input->post('s_npsn', TRUE),
                    's_name' => $this->input->post('s_name', TRUE),
                    's_dob' => $this->input->post('s_dob', TRUE),
                    's_statussekolah' => $this->input->post('s_statussekolah', TRUE),
                    's_instansi' => $this->input->post('s_instansi', TRUE),
                    's_kec' => $this->input->post('s_kec', TRUE),
                    // 's_yi' => $this->input->post('s_yi', TRUE),
                    's_foto' => (!empty($foto)) ? $foto : $data['school']['s_foto'],
                    's_sp' => (!empty($sp)) ? $sp : $data['school']['s_sp'],
                    's_spn' => (!empty($spn)) ? $spn : $data['school']['s_spn'],
                    's_li' => (!empty($li)) ? $li : $data['school']['s_li'],
                    's_ps' => (!empty($ps)) ? $ps : $data['school']['s_ps'],
                    's_pd' => (!empty($pd)) ? $pd : $data['school']['s_pd'],
                    's_rb' => (!empty($rb)) ? $rb : $data['school']['s_rb'],
                    's_spr' => (!empty($spr)) ? $spr : $data['school']['s_spr'],
                    's_dp' => (!empty($dp)) ? $dp : $data['school']['s_dp'],
                    's_jp' => (!empty($jp)) ? $jp : $data['school']['s_jp'],
                    's_status' => $this->input->post('s_status', TRUE),
                    's_updated_at' => date('Y-m-d H:i:s'),
        			's_updated_by' => $this->session->userdata['u_id'],
                ];

                $this->m_schools->edit($data, $s_id);
                $this->session->set_flashdata('alert', success('Data sekolah berhasil diperbarui.'));
                $data['title'] = "Data ".self::$title;
                $data['content'] = "dashboard/school";
                redirect(site_url('school'));
            }

        } else {
            $data['majors'] = $this->m_schools->get_majors();
            $data['title'] = "Edit ".self::$title;
            $data['form_title'] = "Edit Data ".$data['school']['s_name'] ;
            $data['action'] = site_url(uri_string());
            $data['content'] = 'dashboard/school-form';
            if (!$s_id) {
                redirect(site_url('school'));
            } else {
                $this->load->view('dashboard/index', $data);
            }
        }
    }

    public function delete($s_id)
    {
        $this->load->helper('notification');

        $data = [
            's_deleted_at' => date('Y-m-d H:i:s'),
            's_deleted_by' => $this->session->userdata['u_id'],
            's_is_deleted' => TRUE
        ];

        $this->m_schools->delete($data, $s_id);
        $this->session->set_flashdata('alert', success('Data sekolah berhasil dihapus.'));
        $data['title'] = "Data ".self::$title;
        $data['content'] = "dashboard/school";
        $this->load->view('dashboard/index', $data);
        redirect(site_url('school'));
    }

    public function deleted()
    {
        $data['title'] = "Data sekolah Terhapus &minus; Arsip Arsip Digital Rekap LI";
        $data['content'] = "dashboard/school-deleted";
        $this->load->view('dashboard/index', $data);
    }

    public function get_deleted()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $this->load->library('datatables_ssp');
            $columns = array(
                array('db' => 's_npsn', 'dt' => 's_npsn'),
                array('db' => 's_name', 'dt' => 's_name'),
                array('db' => 's_dob', 'dt' => 's_dob'),
                array('db' => 's_statussekolah', 'dt' => 's_statussekolah'),
                array('db' => 's_instansi', 'dt' => 's_instansi'),
                array('db' => 'm_id', 'dt' => 'm_id'),
                array('db' => 's_deleted_at', 'dt' => 's_deleted_at'),
                array(
                    'db' => 's_id',
                    'dt' => 'tindakan',
                    'formatter' => function($s_id) {
                        return '<a class="btn btn-success btn-sm" onclick="return confirmDialog();" href="'.site_url('school/restore/'.$s_id).'"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Restore</a>

                        <a class="btn btn-danger btn-sm mb" onclick="return confirmDialog();" href="'.site_url('school/deletes/'.$s_id).'" title="Hapus Permanen"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                    }
                ),
            );

            $sql_details = [
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            ];

            $qjoin = "JOIN majors ON majors.m_id = schools.s_kec";

            echo json_encode(
                Datatables_ssp::complex($_GET, $sql_details, self::$table, self::$primaryKey, $columns, NULL, "s_is_deleted = 'TRUE'", $qjoin)
            );
        }
    }

    public function restore()
    {
        $this->load->helper(['form', 'notification']);
        $s_id = $this->uri->segment(3);

        $data = [
			's_restored_at' => date('Y-m-d H:i:s'),
			's_restored_by' => $this->session->userdata['u_id'],
			's_is_deleted' => 'FALSE'
		];

        $this->m_schools->restore($data ,$s_id);
        $this->session->set_flashdata('alert', success('Data Sekolah berhasil direstore.'));
        $data['title'] = "Data ".self::$title;
        $data['content'] = "dashboard/school-deleted";
        redirect(site_url('school/deleted'));
    }

    public function archived()
    {
        $this->auth->admin();
        $data['title'] = "Arsip ".self::$title;
        $data['content'] = "dashboard/school-archived";
        $this->load->view('dashboard/index', $data);
    }

    public function get_archived()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $this->load->library('datatables_ssp');
            $columns = array(
                array('db' => 's_npsn', 'dt' => 's_npsn'),
                array('db' => 's_name', 'dt' => 's_name'),
                array('db' => 's_statussekolah', 'dt' => 's_statussekolah'),
                array('db' => 's_instansi', 'dt' => 's_instansi'),
                array('db' => 'm_id', 'dt' => 'm_id'),
                // array('db' => 's_yi', 'dt' => 's_yi'),
               // array('db' => 's_yo', 'dt' => 's_yo'),
                array('db' => 's_is_active', 'dt' => 's_is_active'),
                array(
                    'db' => 's_id',
                    'dt' => 'tindakan',
                    'formatter' => function($s_id) {
                        return '<a class="btn btn-info btn-sm mb" href="'.site_url('school/view/'.$s_id).'">Lihat</a>
                        <a class="btn btn-success btn-sm mb" onclick="return confirmDialog();" href="'.site_url('school/active/'.$s_id).'"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>Restore</a>';
                    }
                ),
            );

            $sql_details = [
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            ];

            $qjoin = "JOIN majors ON majors.m_id = schools.s_kec";

            echo json_encode(
                Datatables_ssp::complex($_GET, $sql_details, self::$table, self::$primaryKey, $columns, NULL, "s_is_active = 'Tidak Aktif'", $qjoin)
            );
        }
    }

    public function active()
    {
        $this->load->helper('notification');
        $s_id = $this->uri->segment(3);

        $data = [
			's_yo' => NULL,
			's_updated_at' => date('Y-m-d H:i:s'),
			's_updated_by' => $this->session->userdata['u_id'],
			's_is_active' => 'Aktif'
		];

        $this->m_schools->active($data, $s_id);
        $this->session->set_flashdata('alert', success('Status data sekolah berhasil diperbarui.'));
        $data['title'] = "Data ".self::$title;
        $data['content'] = "dashboard/school-archived";
        redirect(site_url('school/archived'));
    }

    public function deletes($s_id)
    {

        $this->load->helper('notification');
        $this->m_schools->deletes($s_id, 'schools');
        $this->session->set_flashdata('alert', success('Data sekolah berhasil dihapus.'));
        $data['title'] = "Data ".self::$title;
        $data['content'] = "dashboard/school";
         redirect(site_url('school/deleted'));
      
    }
}

