<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_reports extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	private static $table = 'schools';

	public function get_result($where)
	{
		$query = $this
					->db
					->select('*')
					->from(self::$table)
					->join('majors', 'majors.m_id = schools.s_kec', 'left')
					->where($where)
					->order_by('s_created_at', 'ASC')
					->get();

		if ($query->num_rows() > 0) {
	     	return $query->result();
        } else {
        	return NULL;
        }
	}

	public function get_major($where)
	{
		return $this->db->where($where)->get('majors')->result();
	}
}
