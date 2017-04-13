<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//***************************Myriam Van Erum********************************
/**
 * Page coded by Myriam Van Erum 
 * Login page
 */
class Login extends CI_Controller {

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

    public function login_screen() {
        $data['title'] = 'Login - HH Prospects';
        $data['error'] = json_encode($this->session->flashdata('error'));
        $data['user'] = json_encode($this->authex->getUserInfo());
        $this->LoadView('login/login', $data);
    }

    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if ($this->authex->login($email, $password)) {
            redirect('Home');
        } else {
            $this->session->set_flashdata('error', 1);

            redirect('Login/login_screen');
        }
    }

    public function logout() {
        $this->authex->logout();
        redirect('Home');
    }
    
    public function reset_password() {
        $data['title'] = 'Forgot your password? - HH Prospects';
        $data['user'] = $this->authex->getUserInfo();
        $data['error'] = $this->session->flashdata('error');
        $this->LoadView('login/forgot_password', $data);
    }
    
    public function send_email() {
        $email = trim($this->input->get('email'));

        $emailExists = $this->authex->control($email);

        if ($emailExists) {
            $data['title'] = 'E-mail verzonden';
            $data['navbarActive'] = "Inloggen";
            $data['email'] = $email;
            $data['gebruiker'] = $this->authex->getUserInfo();
            $this->LoadView('wachtwoord/verzonden', $data);
        } else {
            $this->session->set_flashdata('error', 1);
            redirect('Login/reset_password');
        }
    }

}
