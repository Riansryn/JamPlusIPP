<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php'; // Load Composer autoload

class Kategori extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ipp_kategori_model');
        
    }

    // Contoh penggunaan
    public function index()
    {
        $data['title'] = 'Master Kategori';
        $data['kategori'] = $this->Ipp_kategori_model->kategori();
        $this->load->view('templates/header_dash', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('kategori/index', $data);
        $this->load->view('templates/footer_dash');
    }

    public function create() {
        $data['title'] = 'Tambah Kategori';
        $this->load->view('templates/header_dash', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('kategori/create');
        $this->load->view('templates/footer_dash');
    }

    public function tambah()
    {
        $user = $this->session->userdata('kry_id'); // Sesuaikan dengan key yang Anda gunakan untuk menyimpan data user di session
       
        $data = array(
            'ktg_nama' => $this->input->post('nama_kategori'),
            'ktg_status' => $this->input->post('status'),
            'ktg_creaby' => $user,
            'ktg_creadate' => date('Y-m-d H:i:s')
        );
        
        $this->Ipp_kategori_model->tambah_kategori($data);
        redirect('Kategori/index');
    }

    public function detail($ktg_id)
    {
        $data['kategori'] = $this->Ipp_kategori_model->detail_kategori($ktg_id);
        $this->load->view('kategori_detail', $data);
    }

    public function update($ktg_id){

		$where = array('ktg_id' => $ktg_id);
		$data['ipp_kategori'] = $this->Ipp_kategori_model->get_kategori($where,'ipp_kategori')->result();

        $this->load->view('templates/header_dash', $data);
		$this->load->view('templates/sidebar_admin', $data);
        $this->load->view('kategori/edit');
        $this->load->view('templates/footer_dash');
	}

    public function edit(){
        $where = array('ktg_id' => $this->input->post('ktg_id'));
        $user = $this->session->userdata('kry_id');

        $data = array(
            'ktg_nama' => $this->input->post('nama_kategori'),
            'ktg_status' => $this->input->post('status'),
            'ktg_modiby' => $user,
            'ktg_modidate' => date('Y-m-d H:i:s')
        );

        $where = array(
            'ktg_id' => $this->input->post('ktg_id'),
        );

        $this->Ipp_kategori_model->update_kategori($where, $data);
        redirect('Kategori/index');
    }

    public function update_status(){
        $ktgId = $this->input->post('ktg_id');
        $status = $this->input->post('status');

        $data = array(
            'ktg_status' => ($status == 'Aktif') ? 1 : 0,
            'ktg_modiby' => $this->session->userdata('kry_id'),
            'ktg_modidate' => date('Y-m-d H:i:s')
        );

        $where = array(
            'ktg_id' => $ktgId,
        );

        $this->Ipp_kategori_model->update_kategori($where, $data);

        // Kirim respon ke AJAX
        echo json_encode(array('success' => true, 'message' => 'Status berhasil diperbarui.'));
    }

    public function hapus($ktg_id)
    {
        $this->Ipp_kategori_model->hapus_kategori($ktg_id);
        redirect('ipp_kategori/index');
    }
    
}