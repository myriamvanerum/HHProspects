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
        $CI->load->model('User_model');
        $CI->load->helper('string');
        $CI->load->library('encryption');
    }

    function login($email, $password) {
        $CI = & get_instance();
        $user = $CI->User_model->getUser($email);
        
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
    
    function loginSysop($email, $password) {
        $CI = & get_instance();
        $user = $CI->User_model->getUserSysop($email);
        
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
            return $CI->User_model->get($id);
        }
    }

    function logout() {
        $CI = & get_instance();
        $CI->session->sess_destroy();
    }

}
