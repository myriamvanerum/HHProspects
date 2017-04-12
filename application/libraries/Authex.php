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
                    'key' => hex2bin('36ed175638a3c87faf371fb3e49fac287a23ee9ef0e441efd72d11217c2fe6cd')
                )
            );
        
        if ($CI->encryption->decrypt($user->user_password) == $password)
        {
            $CI->session->set_userdata('user_id', $user->id);
            return true;
        }
        else
        {
            return false;
        }
    }

    function loggedIn() {
        $CI = & get_instance();
        if ($CI->session->userdata('user_id')) {
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
            $id = $CI->session->userdata('user_id');
            return $CI->Login_model->get($id);
        }
    }

    function logout() {
        $CI = & get_instance();
        $CI->session->sess_destroy();
    }

    /**
     * controleren of het email adres bestaat, zo ja dan een willekeurig password genereren voor de link die je aankrijgt via mail
     */
    function controle($emailadres) {
        $CI = & get_instance();

        if ($CI->Wachtwoord_model->email_bestaat($emailadres)) {
            $password = sha1($emailadres);
            $this->sendRecoverymail($emailadres, $password);
            //$this->geefLinkWeer($emailadres, $password);
            return true;
        } else {
            return false;
        }
    }

    /**
     * mail versturen met een link erin die gaat naar de reset_wachtwoord functie
     */
    function sendRecoverymail($emailadres, $password) {

        $CI = & get_instance();
        $CI->email->from('r0578968@thomasmore.be', 'Sven Swennen');
        $CI->email->to($emailadres);
        $CI->email->subject('Nieuw paswoord');
        $CI->email->message('Klik op deze link voor het aanpassen van je wachtwoord: ' . anchor(base_url() . 'hhprospects.php/Wachtwoord/reset_wachtwoord/' . $emailadres . '/' . $password, 'klik hier'));
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
