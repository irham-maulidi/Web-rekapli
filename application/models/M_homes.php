<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_homes extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	private static $table = 'schools';

	public function get_result($keyword)
	{
		$query = $this
					->db
					->select('*')
	                ->from(self::$table)
					->join('majors', 'majors.m_id = schools.s_kec', 'left')
	                ->like('s_npsn', $keyword)
	                ->or_like('s_name', $keyword)
					->or_like('s_dob', $keyword)
					->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
	}

	public function get_data($s_id)
	{
		$where = "s_id = '$s_id'";

		$query = $this
					->db
					->select('*')
					->from(self::$table)
					->join('majors', 'majors.m_id = schools.s_kec', 'left')
					->where($where)
					->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return NULL;
		}
	}
}
