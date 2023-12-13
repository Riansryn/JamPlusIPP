<?php

class Ipp_pekerjaan_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// Read
	public function pekerjaan($pkj_creaby)
	{

		return $this->db->get_where('ipp_pekerjaan', array('pkj_creaby' => $pkj_creaby))->result();
	}

	public function pekerjaan_by_id($pkj_creaby, $pkj_id)
	{
		return $this->db->get_where('ipp_pekerjaan', array('pkj_creaby' => $pkj_creaby, 'pkj_id' => $pkj_id))->row();
	}

	public function pekerjaanSemua()
	{

		return $this->db->get('ipp_pekerjaan')->result();
	}

	// Create
	public function tambah_pekerjaan($data)
	{

		$this->db->insert('ipp_pekerjaan', $data);
		return $this->db->insert_id();
	}

	// update
	public function ubah_pekerjaan($pkj_id, $pkj_creaby, $data)
	{
		return $this->db->update('ipp_pekerjaan', $data, array('pkj_creaby' => $pkj_creaby, 'pkj_id' => $pkj_id));
	}

	// Check
	public function pengecekan_pekerjaan($kry_id)
	{
		$result = $this->db->get_where('ipp_pekerjaan', array('pkj_creaby' => $kry_id, 'pkj_status' => 1))->num_rows();

		return ($result !== null && $result !== false) ? $result : 0;
	}

	// Does
	public function melakukan_pekerjaan($pkj_id, $data)
	{

		$this->db->where('pkj_id', $pkj_id);
		$this->db->where('pkj_status', 0);
		return $this->db->update('ipp_pekerjaan', $data);
	}

	// Done
	public function menyelesaikan_pekerjaan($pkj_id, $data)
	{

		$this->db->where('pkj_id', $pkj_id);
		$this->db->where('pkj_status', 1);
		return $this->db->update('ipp_pekerjaan', $data);
	}

	// filter
	public function filter_pekerjaan($kry_id, $month, $year)
	{
		return $this->db->get_where('ipp_pekerjaan', array('pkj_modiby' => $kry_id, 'MONTH(pkj_modidate)' => $month, 'YEAR(pkj_modidate)' => $year, 'pkj_status' => 2))->result();
	}

}
