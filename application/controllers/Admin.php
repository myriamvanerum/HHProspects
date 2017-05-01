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
        $this->load->model('Group_model');
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
    
    public function getStudent($id) {
        $student = $this->Student_model->getWithAdmin($id);
        echo json_encode($student);
    }
    
    public function getAdmins() {
        $admins = $this->User_model->getAllByLevel(2);
        echo json_encode($admins);
    }
    
    public function getGroups() {
        $groups = $this->Group_model->getAll();
        echo json_encode($groups);
    }
    
    public function insertStudent() {
        $student = new stdClass();
        $student->first_name = $this->input->post('first_name');
        $student->last_name = $this->input->post('last_name');
        $student->email = $this->input->post('email');
        $student->person_number = $this->input->post('person_number');
        $student->country = $this->input->post('country');
        $student->admin_id = $this->input->post('admin_id');
        $student->group_id = $this->input->post('group_id');
        $student->zip_code = $this->input->post('zip_code');
        $student->language = $this->input->post('language');
        $student->instruction_language = $this->input->post('instruction_language');
        $student->application_number = $this->input->post('application_number');
        $this->Student_model->insert($student);
    }
}
