<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php'; // Load Composer autoload

class Pekerjaan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ipp_pekerjaan_model');
		$this->load->model('Ipp_kategori_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$user = $this->session->userdata('kry_id');

		$data['title'] = 'Dashboard';
		$data['kategori'] = $this->Ipp_kategori_model->kategori_aktif();
		$data['Dashboard'] = $this->Ipp_pekerjaan_model->pekerjaan($user);

		// Check if filtered data is available
		if ($this->input->post('filter_tanggal')) {
			$data['title'] = 'Dashboard';
			$data['Dashboard'] = $this->input->post('filter_tanggal');
		}

		$this->load->view('templates/header_dash', $data);
		$this->load->view('templates/sidebar_admin', $data);
		$this->load->view('pekerjaan/index', $data);
		$this->load->view('templates/footer_dash', $data);
	}

	public function create()
	{
		$data['title'] = 'Tambah Pekerjaan';
		$data['kategori'] = $this->Ipp_kategori_model->kategori_aktif();
		$this->load->view('templates/header_dash', $data);
		$this->load->view('templates/sidebar_admin', $data);
		$this->load->view('pekerjaan/create', $data);
		$this->load->view('templates/footer_dash');
	}

	public function update($pkj_id)
	{
		$user = $this->session->userdata('kry_id'); // Sesuaikan dengan key yang Anda gunakan untuk menyimpan data user di session

		$data['title'] = 'Tambah Pekerjaan';
		$data['kategori'] = $this->Ipp_kategori_model->kategori_aktif();
		$data['pekerjaan'] = $this->Ipp_pekerjaan_model->pekerjaan_by_id($user, $pkj_id);
		$this->load->view('templates/header_dash', $data);
		$this->load->view('templates/sidebar_admin', $data);
		$this->load->view('pekerjaan/edit', $data);
		$this->load->view('templates/footer_dash');
	}

	public function tambah()
	{
		$user = $this->session->userdata('kry_id'); // Sesuaikan dengan key yang Anda gunakan untuk menyimpan data user di session

		$data = array(
			'pkj_nama' => $this->input->post('nama_pekerjaan'),
			'pkj_tanggal' => $this->input->post('tanggal_pekerjaan'),
			'pkj_rencana_jam_awal' => $this->input->post('waktu_mulai'),
			'pkj_rencana_jam_akhir' => $this->input->post('waktu_selesai'),
			'ktg_id' => $this->input->post('kategori_pekerjaan'),
			'pkj_status' => 0,
			'pkj_creaby' => $user,
			'pkj_creadate' => date('Y-m-d H:i:s')
		);

		$this->Ipp_pekerjaan_model->tambah_pekerjaan($data);
		redirect('pekerjaan');
	}

	public function edit($pkj_id)
	{
		$user = $this->session->userdata('kry_id'); // Sesuaikan dengan key yang Anda gunakan untuk menyimpan data user di session

		$data = array(
			'pkj_nama' => $this->input->post('nama_pekerjaan'),
			'pkj_tanggal' => $this->input->post('tanggal_pekerjaan'),
			'pkj_rencana_jam_awal' => $this->input->post('waktu_mulai'),
			'pkj_rencana_jam_akhir' => $this->input->post('waktu_selesai'),
			'ktg_id' => $this->input->post('kategori_pekerjaan'),
		);

		$this->Ipp_pekerjaan_model->ubah_pekerjaan($pkj_id, $user, $data);
		redirect('pekerjaan');
	}

	public function kirim($pkj_id)
	{
		$user = $this->session->userdata('kry_id'); // Sesuaikan dengan key yang Anda gunakan untuk menyimpan data user di session
		$result = $this->Ipp_pekerjaan_model->pengecekan_pekerjaan($user);
		if ($result == 0 || $result == NULL) {
			$data = array(
				'pkj_aktual_jam_awal' => date('Y-m-d H:i:s'),
				'pkj_status' => 1,
				'pkj_modiby' => $user,
				'pkj_modidate' => date('Y-m-d H:i:s')
			);
			$this->session->set_flashdata('success', 'Selamat! Anda memulai pekerjaan!');
			$this->Ipp_pekerjaan_model->melakukan_pekerjaan($pkj_id, $data);
			redirect('pekerjaan');
		}

		$this->session->set_flashdata('error', 'Anda hanya bisa melakukan satu tugas saja!');
		redirect('pekerjaan');
	}

	public function selesai($pkj_id)
	{
		$user = $this->session->userdata('kry_id'); // Sesuaikan dengan key yang Anda gunakan untuk menyimpan data user di session

		$data = array(
			'pkj_aktual_jam_akhir' => date('Y-m-d H:i:s'),
			'pkj_status' => 2,
			'pkj_modiby' => $user,
			'pkj_modidate' => date('Y-m-d H:i:s')
		);
		$this->Ipp_pekerjaan_model->menyelesaikan_pekerjaan($pkj_id, $data);
		redirect('pekerjaan');
	}

	public function filterchart_pekerjaan()
	{
		$user = $this->session->userdata('kry_id');
		$date = $this->input->post('filter_tanggal');

		$str_date = strtotime($date);

		$month = date('m', $str_date);
		$year = date('Y', $str_date);

		$filtered_data['title'] = 'Filtered Dashboard';
		$filtered_data['kategori'] = $this->Ipp_kategori_model->kategori_aktif();
		$filtered_data['Dashboard'] = $this->Ipp_pekerjaan_model->filter_pekerjaan($user, $month, $year);

		// Redirect to the original dashboard with the filtered data
		redirect('pekerjaan/index', $filtered_data);
	}
}
