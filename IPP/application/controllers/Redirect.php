<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php'; // Load Composer autoload

class Redirect extends CI_Controller
{
    public $session;
    public $input;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];

            $decryptedToken = $this->Decrypt($token, "PolmanAstra_SSO");
            $this->session->sess_destroy();
            $this->load->helper('cookie');
            $tokenParts = explode('@', $decryptedToken);
            $redirectURL = $tokenParts[0];

            $ticket = array(
                'kry_id' => $tokenParts[1],
                'apk_id' => $tokenParts[2],
                'rol_id' => $tokenParts[3]
            );

            $cookie = array(
                'name'   => 'cookie',
                'value'  => json_encode($ticket),
                'expire' => '3600',
                'domain' => 'localhost',
                'path'   => '/',
                'secure' => TRUE 
            );
        
            $this->input->set_cookie($cookie);            

            header("Location: " . $redirectURL);
            exit;

        } else {
            echo "Token not found!";
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