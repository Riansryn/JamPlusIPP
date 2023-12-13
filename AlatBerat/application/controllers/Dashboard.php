<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php'; // Load Composer autoload

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Dashboard User';
        $kry_data = $this->session->userdata();
        $kry_id = $this->session->userdata('kry_id');
        if (!$kry_id) {
            redirect('Auth'); 
        }
        if ($kry_data) {
            $user_apps_roles = $this->db->get_where('sso_user', ['kry_id' => $kry_data['kry_id']])->result_array();
            $apps = [];
            foreach ($user_apps_roles as $uar) {
                $app_data = $this->db->get_where('sso_aplikasi', ['apk_id' => $uar['apk_id']])->row_array();
                
                if ($app_data) {
                    $apps[$app_data['apk_id']]['app_nama'] = $app_data['apk_nama'];
                    $role_data = $this->db->get_where('sso_role', ['rol_id' => $uar['rol_id']])->row_array();
                    if ($role_data) {
                        $token = $this->Encrypt($app_data['apk_base_tautan'] . "@" . $kry_data['kry_id'] . "@" . $app_data['apk_id'] . "@" . $role_data['rol_id'], "PolmanAstra_SSO");
                        $apps[$app_data['apk_id']]['roles'][] = [
                            'role_id' => $role_data['rol_id'],
                            'role_nama' => $role_data['rol_nama'],
                            'token' => $token
                        ];
                    }
                }
            }
            
            $data['apps'] = $apps;
            
    
            $this->load->view('templates/header_dash', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('dashboard/dashboard', $data);
            $this->load->view('templates/footer_dash');
        }
    }

    private function Decrypt($chipertext, $key) {
        $text = $chipertext;
        for ($i = 1; $i <= 10; $i++) {
            $text = $this->Descramble($text);
        }
    
        $text = base64_decode($text);
        return str_replace($key, "", $text);
    }

    private function Descramble($param) {
        $text = "";
        $text2 = "";
        $text3 = "";
        if ($this->isEven(strlen($param))) {
            for ($i = 0; $i < strlen($param) / 2; $i++) {
                $text2 .= $param[$i];
            }
    
            for ($j = strlen($param) / 2; $j < strlen($param); $j++) {
                $text3 .= $param[$j];
            }
    
            for ($k = 0; $k < strlen($text2); $k++) {
                $text .= $text2[$k] . $text3[$k];
            }
        } else {
            for ($i = 0; $i < (strlen($param) / 2) + 1; $i++) {
                $text2 .= $param[$i];
            }
    
            for ($j = (strlen($param) / 2) + 1; $j < strlen($param); $j++) {
                $text3 .= $param[$j];
            }
    
            for ($k = 0; $k < strlen($text3); $k++) {
                $text .= $text2[$k] . $text3[$k];
            }
    
            $text .= $text2[strlen($text2) - 1];
        }
    
        return $text;
    }
    

    private function Encrypt($plaintext, $key) {
        $text = base64_encode($plaintext . $key);
        for ($i = 1; $i <= 10; $i++) {
            $text = $this->Scramble($text);
        }
        return $text;
    }

    private function Scramble($param) {
        $text2 = "";
        $text3 = "";
        for ($i = 0; $i < strlen($param); $i++) {
            if ($this->isEven($i)) {
                $text2 .= $param[$i];
            } else {
                $text3 .= $param[$i];
            }
        }
        return $text2 . $text3;
    }

    private function isEven($number) {
        return $number % 2 == 0;
    }
    
}