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
    
    public function forgot_password() {
        $data['title'] = 'Forgot your password? - HH Prospects';
        $data['user'] = $this->authex->getUserInfo();
        $data['error'] = $this->session->flashdata('error');
        $this->LoadView('login/forgot_password', $data);
    }
    
    public function check_email() {
        $email = trim($this->input->get('email'));

        $emailExists = $this->authex->control($email);

        if ($emailExists) {
            $this->send_email($email);
            
            $data['title'] = 'Password reset email sent - HH Prospects';
            $data['email'] = $email;
            $this->LoadView('login/email_sent', $data);
        } else {
            $this->session->set_flashdata('error', 1);
            redirect('Login/forgot_password');
        }
    }
    
    public function send_email($email) {
        $this->email->from('prospects@hh.se', 'Halmstad University Prospects');
        $this->email->to($email);
        $this->email->subject('Reset your password');
        $data = array();
        $data['url'] = base_url() . 'index.php/Login/reset_password/' . sha1($email);
        $this->email->message($this->load->view('emails/reset_password_email', $data, TRUE));
        $this->email->set_mailtype("html");
        $this->email->send();
    }
    
    public function reset_password($encr_email) {
        echo $encr_email;
        
    }

}
