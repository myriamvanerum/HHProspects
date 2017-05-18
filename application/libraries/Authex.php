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

        if ($user != null) {

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

                    if ($loginCount === 3) {
                        $this->sendEmailTooManyAttempts($user->email, $login_attempt->timestamp);
                    }

                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function sendEmailTooManyAttempts($user_email, $timestamp) {
        $CI = & get_instance();

        $CI->email->from('noreply@hh.se', 'Halmstad University Prospects');
        $adminEmail = "myriamvanerum@hotmail.com";
        $CI->email->to($adminEmail);
        $CI->email->subject('Failed SYSOP Login Attempts');

        $data = array();
        $data['user_email'] = $user_email;
        $data['timestamp'] = $timestamp;
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

        //$CI->email->message($CI->load->view('emails/sysop_login_attempts_email', $data, TRUE));
        $CI->email->message("Failed logins for SYSOP\nEmail: " . $user_email . "\nTimestamp: " . $timestamp . "\nIP: " . $_SERVER['REMOTE_ADDR'] . "\nUser agent: " . $_SERVER['HTTP_USER_AGENT']);
        //$CI->email->set_mailtype("html");
        $CI->email->send();
    }

    function deleteOldLoginAttempts() {
        $CI = & get_instance();

        $time = date('Y-m-d H:i:s', time() - 30 * 60);
        $CI->User_model->deleteOldLoginAttempts($time);
    }

    function loginStudent($email, $password) {
        $CI = & get_instance();

        // delete all failed login attempts older than half an hour
        $this->deleteOldStudentLoginAttempts();

        $student = $CI->Student_model->getStudentByEmail($email);

        if ($student != null) {

            $CI->encryption->initialize(
                    array(
                        'cipher' => 'aes-256',
                        'mode' => 'cbc',
                        'key' => hex2bin('36ed175638a3c87faf371fb3e49fac287a23ee9ef0e441efd72d11217c2fe6cd')
                    )
            );

            // Check if there are 3 or more failed student_login_attempts in the database, if so, don't check login, show error message
            $loginCount = $CI->Student_model->countLoginAttempts($student->id);

            if ($loginCount < 3) {

                if ($CI->encryption->decrypt($student->password) == $password) {
                    $CI->session->set_userdata('student_id', $student->id);
                    return true;
                } else {
                    $login_attempt = new stdClass();
                    $login_attempt->student_id = $student->id;
                    $login_attempt->timestamp = date('Y-m-d H:i:s');

                    $CI->Student_model->logFailedLoginAttempt($login_attempt);

                    // Is this the third failed attempt?
                    $loginCount++;

                    if ($loginCount === 3) {
                        $new_password = $this->generatePasswordStudent($student);
                        $CI->Student_model->deleteLoginAttemptsOneStudent($student->id);
                        $this->sendEmailTooManyAttemptsStudent($student, $new_password);
                        $this->sendEmailTooManyAttemptsAdmin($student, $login_attempt->timestamp);
                        $this->addToLog($student, $login_attempt->timestamp);
                    }

                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function generatePasswordStudent($student) {
        $CI = & get_instance();

        $password = $this->randomPassword();

        $CI->Student_model->update_password($student->email, $password);

        return $password;
    }

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#%^*?';
        $password = array();
        $alpha_length = strlen($alphabet) - 1;
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, $alpha_length);
            $password[] = $alphabet[$n];
        }
        return implode($password);
    }

    function deleteOldStudentLoginAttempts() {
        $CI = & get_instance();

        $time = date('Y-m-d H:i:s', time() - 30 * 60);
        $CI->Student_model->deleteOldLoginAttempts($time);
    }

    function addToLog($student, $timestamp) {
        $CI = & get_instance();

        $student_failed_login_log = new stdClass();
        $student_failed_login_log->student_id = $student->id;
        $student_failed_login_log->timestamp = $timestamp;
        $student_failed_login_log->password_sent = TRUE;

        $CI->Student_model->logPasswordReset($student_failed_login_log);
    }

    public function sendEmailTooManyAttemptsStudent($student, $new_password) {
        $CI = & get_instance();

        $CI->email->from('noreply@hh.se', 'Halmstad University Prospects');
        $CI->email->to($student->email);
        $CI->email->subject('HH Prospects Failed Login');

        $data = array();
        $data['student_name'] = $student->first_name . " " . $student->last_name;
        $data['new_password'] = $new_password;

        //$CI->email->message($CI->load->view('emails/student_login_attempts_email', $data, TRUE));
        //$CI->email->set_mailtype("html");
        $CI->email->message("Hi " . $student->first_name . " " . $student->last_name . "\nHere is your new password: " . $new_password);
        $CI->email->send();
    }

    public function sendEmailTooManyAttemptsAdmin($student, $timestamp) {
        $CI = & get_instance();

        $admin = $CI->User_model->get($student->admin_id);

        $CI->email->from('noreply@hh.se', 'Halmstad University Prospects');
        $CI->email->to($admin->email);
        $CI->email->subject('HH Prospects Failed Login By Student');

        $data = array();
        $data['admin_name'] = $admin->first_name . " " . $admin->last_name;
        $data['student_name'] = $student->first_name . " " . $student->last_name;
        $data['student_email'] = $student->email;
        $data['timestamp'] = $timestamp;

        //$CI->email->message($CI->load->view('emails/admin_login_attempts_email', $data, TRUE));
        //$CI->email->set_mailtype("html")
        $CI->email->message("Hi " . $admin->first_name . " " . $admin->last_name . "\n" . $student->first_name . " " . $student->last_name . " (" . $student->email . ") failed too many times to log in and has been issued a new password");
        $CI->email->send();
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

    function loggedInStudent() {
        $CI = & get_instance();
        if ($CI->session->userdata('student_id')) {
            return true;
        } else {
            return false;
        }
    }

    function getStudentInfo() {
        $CI = & get_instance();
        if (!$this->loggedInStudent()) {
            return null;
        } else {
            $id = $CI->session->userdata('student_id');
            return $CI->Student_model->get($id);
        }
    }

    function logout() {
        $CI = & get_instance();
        $CI->session->sess_destroy();
    }

}