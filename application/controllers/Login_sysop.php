<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//***************************Myriam Van Erum********************************
/**
 * Page coded by Myriam Van Erum 
 * Login page for sysop
 */
class Login_sysop extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function LoadView($viewnaam, $data) {
        $partials = array(
            'title' => $data['title'],
            'header' => $this->parser->parse('main_header', $data, true),
            'content' => $this->parser->parse($viewnaam, $data, true),
            'footer' => $this->parser->parse('main_footer', $data, true)
        );
        $this->parser->parse('main_master', $partials);
    }

    public function index() {
        $this->user_control->notLoggedIn();
        
        $data['title'] = 'SYSOP Login - HH Prospects';
        $data['error'] = json_encode($this->session->flashdata('error'));
        $data['user'] = json_encode($this->authex->getUserInfo());
        $this->LoadView('login/login_sysop', $data);
    }

    public function login() {
        $email = trim($this->input->post('email'));
        $password = $this->input->post('password');

        if ($this->authex->loginSysop($email, $password)) {
            redirect('Sysop');
        } else {
            $this->session->set_flashdata('error', 1);

            redirect('Login_sysop/index');
        }
    }

    public function logout() {
        $this->authex->logout();
        redirect('Home');
    }

}
