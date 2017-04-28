<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//***************************Myriam Van Erum********************************
/**
 * Page coded by Myriam Van Erum 
 * Admin controller
 */
class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->user_control->adminLoggedIn();
        $this->load->model('Student_model');
    }
    
    public function index() {
        $data['title'] = "HH Prospects";
        
        $this->LoadView('admin/home', $data);
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
    
    public function getStudents() {
        $data['students'] = $this->Student_model->getAllWithAdmin();
        $this->load->view('admin/students', $data);
    }
}
