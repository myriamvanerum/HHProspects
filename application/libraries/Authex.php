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
        $CI->load->model('Student_model');
        $CI->load->library('encryption');
    }

    function login($email, $password) {
        $CI = & get_instance();
        $user = $CI->User_model->getUser($email);

        $CI->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'cbc',
                    'key' => hex2bin('36ed175638a3c87faf371fb3e49fac287a23ee9ef0e441efd72d11217c2fe6cd')
                )
        );

        if ($CI->encryption->decrypt($user->password) == $password) {
            $CI->session->set_userdata('id', $user->id);
            return true;
        } else {
            return false;
        }
    }

    function loginSysop($email, $password) {
        $CI = & get_instance();

        // delete all failed login attempts older than half an hour
        $this->deleteOldLoginAttempts();

        $user = $CI->User_model->getUserSysop($email);

        $CI->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'cbc',
                    'key' => hex2bin('36ed175638a3c87faf371fb3e49fac287a23ee9ef0e441efd72d11217c2fe6cd')
                )
        );

        // Check if there are 3 or more failed login_attempts in the database, if so, don't check login, show error message
        $loginCount = $CI->User_model->countLoginAttempts($user->id);

        if ($loginCount < 3) {

            if ($CI->encryption->decrypt($user->password) == $password) {
                $CI->session->set_userdata('id', $user->id);
                return true;
            } else {
                $login_attempt = new stdClass();
                $login_attempt->user_id = $user->id;
                $login_attempt->timestamp = date('Y-m-d H:i:s');

                $CI->User_model->logFailedLoginAttempt($login_attempt);
                
                // Is this the third failed attempt?
                $loginCount++;
                
                if ($loginCount === 3)
                {
                    $this->sendEmailTooManyAttempts($user->email, $login_attempt->timestamp);
                }

                return false;
            }
        } else {
            return false;
        }
    }
    
    public function sendEmailTooManyAttempts($user_email, $timestamp) {
        $CI = & get_instance();
        
        $CI->email->from('prospects@hh.se', 'Halmstad University Prospects');
        $adminEmail = "myriamvanerum@hotmail.com";
        $CI->email->to($adminEmail);
        $CI->email->subject('Failed SYSOP Login Attempts');
        
        $data = array();
        $data['user_email'] = $user_email;
        $data['timestamp'] = $timestamp;
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        
        $CI->email->message($CI->load->view('emails/sysop_login_attempts_email', $data, TRUE));
        $CI->email->set_mailtype("html");
        $CI->email->send();
    }

    function deleteOldLoginAttempts() {
        $CI = & get_instance();

        $time = date('Y-m-d H:i:s', time() - 30 * 60);
        $CI->User_model->deleteOldLoginAttempts($time);
    }
    
    function loginStudent($email, $password) {
        $CI = & get_instance();
        $student = $CI->Student_model->getStudentByEmail($email);

        $CI->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'cbc',
                    'key' => hex2bin('36ed175638a3c87faf371fb3e49fac287a23ee9ef0e441efd72d11217c2fe6cd')
                )
        );

        if ($CI->encryption->decrypt($student->password) == $password) {
            $CI->session->set_userdata('student_id', $student->id);
            return true;
        } else {
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
