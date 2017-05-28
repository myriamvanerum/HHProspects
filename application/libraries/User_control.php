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

    // Check if user is not logged in. Redirect otherwise.
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
    
    // Check if admin is logged in. Redirect otherwise.
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
    
    // Check if analyst is logged in. Redirect otherwise.
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
    
    // Check if SYSOP is logged in. Redirect otherwise.
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
    
    // Check if student is logged in. Redirect otherwise.
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