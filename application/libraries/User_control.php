<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Page coded by Myriam Van Erum
 * User_control library
 */
//***************************Sven Swennen********************************
class User_control {

    public function __construct() {
        $CI = & get_instance();
        $CI->load->library('authex');
    }

    public function notLoggedIn() {
        $CI = & get_instance();
        $user = $CI->authex->getUserInfo();
        $student = $CI->authex->getStudentInfo();
        if ($user != null)
        {
            switch ($user->level) {
                case 1:
                    // Sysop
                    redirect('Sysop');
                    break;
                case 2:
                    // Administrator
                    redirect('Admin');
                    break;
                case 3:
                    // Analyst
                    redirect('Analyst');
                    break;
            }
        } elseif ($student != null)
        {
            redirect('Student');
        }
    }
    
    public function adminLoggedIn() {
        $CI = & get_instance();
        $user = $CI->authex->getUserInfo();
        $student = $CI->authex->getStudentInfo();
        
        if ($user != null)
        {
            switch ($user->level) {
                case 1:
                    // Sysop
                    redirect('Sysop');
                    break;
                case 3:
                    // Analyst
                    redirect('Analyst');
                    break;
            }
        } elseif ($student != null) {
            redirect('Student');
        } else {
            redirect('Login');
        }
    }
    
    public function analystLoggedIn() {
        $CI = & get_instance();
        $user = $CI->authex->getUserInfo();
        $student = $CI->authex->getStudentInfo();
        
        if ($user != null)
        {
            switch ($user->level) {
                case 1:
                    // Sysop
                    redirect('Sysop');
                    break;
                case 2:
                    // Admin
                    redirect('Admin');
                    break;
            }
        } elseif ($student != null) {
            redirect('Student');
        } else {
            redirect('Login');
        }
    }
    
    public function sysopLoggedIn() {
        $CI = & get_instance();
        $user = $CI->authex->getUserInfo();
        $student = $CI->authex->getStudentInfo();
        
        if ($user != null)
        {
            switch ($user->level) {
                case 2:
                    // Admin
                    redirect('Admin');
                    break;
                case 3:
                    // Analyst
                    redirect('Analyst');
                    break;
            }
        } elseif ($student != null) {
            redirect('Student');
        } else {
            redirect('Login_sysop');
        }
    }
    
    public function studentLoggedIn() {
        $CI = & get_instance();
        $user = $CI->authex->getUserInfo();
        $student = $CI->authex->getStudentInfo();
        
        if ($user != null)
        {
            switch ($user->level) {
                case 1:
                    // Sysop
                    redirect('Sysop');
                    break;
                case 2:
                    // Admin
                    redirect('Admin');
                    break;
                case 3:
                    // Analyst
                    redirect('Analyst');
                    break;
            }
        } elseif ($student != null) {
            // Do nothing
        } else {
            redirect('Login_student');
        }
    }

}