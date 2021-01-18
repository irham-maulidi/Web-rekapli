<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_schools extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	private static $table = 'schools';
	private static $pk = 's_id';

	public function is_exist($where)
	{
		return $this->db->where($where)->get(self::$table)->row_array();
	}

	public function get_schools($where)
	{
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

	public function get_majors()
	{
		return $this->db->get('majors')->result_array();
	}

	public function add($data)
	{
    	return $this->db->insert(self::$table, $data);
	}

	public function do_import($data)
	{
        return $this->db->insert(self::$table, $data);
	}

	public function edit($data, $s_id)
	{
		return $this->db->set($data)->where(self::$pk, $s_id)->update(self::$table);
	}

	public function status($data, $s_id)
	{
		return $this->db->set($data)->where(self::$pk, $s_id)->update(self::$table);
	}

	public function active($data, $s_id)
	{
		return $this->db->set($data)->where(self::$pk, $s_id)->update(self::$table);
	}

	public function delete($data, $s_id)
	{
		return $this->db->set($data)->where(self::$pk, $s_id)->update(self::$table);
	}

	public function restore($data, $s_id)
	{
		return $this->db->set($data)->where(self::$pk, $s_id)->update(self::$table);
	}

	public function deletes($s_id ,$table = 'schools')
	{

		$this->db->query("DELETE FROM $table WHERE s_id ='$s_id'");	
	}	
	
}
