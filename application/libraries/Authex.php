<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Page coded by Myriam Van Erum
 * Authex library
 */
//***************************Sven Swennen********************************
class Authex {

    public function __construct() {
        $CI = & get_instance();
        $CI->load->model('Login_model');
        $CI->load->helper('string');
        $CI->load->library('encryption');
    }

    function login($email, $password) {
        $CI = & get_instance();
        $user = $CI->Login_model->getUser($email);
        
        $CI->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'cbc',
                    'key' => $this->config->encryption_key
                )
            );
        
        if ($CI->encryption->decrypt($user->password) == $password)
        {
            $CI->session->set_userdata('id', $user->id);
            return true;
        }
        else
        {
            return false;
        }
    }

    function loggedIn() {
        $CI = & get_instance();
        if ($CI->session->userdata('id')) {
            return true;
        } else {
            return false;
        }
    }

    function getUserInfo() {
        $CI = & get_instance();
        if (!$this->loggedIn()) {
            return null;
        } else {
            $id = $CI->session->userdata('id');
            return $CI->Login_model->get($id);
        }
    }

    function logout() {
        $CI = & get_instance();
        $CI->session->sess_destroy();
    }

    function control($email) {
        $CI = & get_instance();

        if ($CI->Login_model->email_exists($email)) {
            $password = sha1($email);
            $this->sendRecoveryMail($email, $password);
            return true;
        } else {
            return false;
        }
    }

    function sendRecoveryMail($email, $password) {

        $CI = & get_instance();
        $CI->email->from('pp@hh.se', 'Halmstad Hogskolan - Prospects');
        $CI->email->to($email);
        $CI->email->subject('Reset your password');
        $CI->email->message('Klik op deze link voor het aanpassen van je wachtwoord: ' . anchor(base_url() . 'hhprospects.php/Wachtwoord/reset_wachtwoord/' . $email . '/' . $password, 'klik hier'));
        $CI->email->send();
        echo $CI->email->print_debugger();
    }

    /**
     * nieuw wachtwoord aanmaken in de db voor een gebruiker met sha1 ter beveiliging
     */
    function update_wachtwoord($emailadres, $wachtwoord1) {
        $CI = & get_instance();
        $id = $CI->Wachtwoord_model->resetPassword($emailadres, $wachtwoord1);
        //return $id;
    }

}
