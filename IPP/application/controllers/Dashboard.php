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
        $cookie = $this->input->cookie('cookie');
        $data['title'] = 'Dashboard User';
        if ($cookie) {
            $ticket = json_decode($cookie, true);

            $kry_id = $ticket['kry_id'];
            $apk_id = $ticket['apk_id'];
            $rol_id = $ticket['rol_id'];
            $user = $this->db->get_where('sso_karyawan', ['kry_id' => $kry_id])->row_array();
            $this->session->set_userdata($user);
            $data['user'] = $user;
            $this->load->view('templates/header_dash', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('dashboard/dashboard', $data);
            $this->load->view('templates/footer_dash');
        } else {
            $sso_url = $this->config->item('sso_url');
            header("Location: " . $sso_url);
            exit;
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