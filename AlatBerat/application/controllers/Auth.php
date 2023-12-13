<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login';
            $this->load->view('templates/header_auth', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/footer_auth');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->db->get_where('sso_karyawan', ['kry_username' => $username])->row_array();

            if ($user) {
                if ($password == $user['kry_password']) {
                    $this->session->set_userdata($user);
                    redirect('Dashboard');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
                    redirect('Auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username is not registered!</div>');
                redirect('Auth');
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata('kry_nama'); 
        $this->session->unset_userdata('kry_username');
        $this->session->unset_userdata('usr_id');
        $this->session->unset_userdata('kry_id');
        $this->session->unset_userdata('sso_id');

        $this->session->sess_destroy(); // Menghapus semua data sesi

        redirect('auth');
    }
}
