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
        $this->load->model('Email_model');
        $this->load->library('encryption');
    }
    
    public function index() {
        $data['title'] = "Admin homepage - HH Prospects";
        
        $this->LoadView('admin/students', $data);
    }
    
    public function emails() {
        $data['title'] = "Emails - HH Prospects";
        
        $this->LoadView('admin/emails', $data);
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
        $this->load->view('admin/students_table', $data);
    }
    
    public function getStudent($id) {
        $student = $this->Student_model->getWithAdmin($id);
        echo json_encode($student);
    }
    
    public function getAdmins() {
        $admins = $this->User_model->getAllByLevel(2);
        echo json_encode($admins);
    }
    
    public function getGroupsJSON() {
        $groups = $this->Group_model->getAll();
        echo json_encode($groups);
    }
    
    public function insertStudent() {
        $student = new stdClass();
        $student->first_name = $this->input->post('first_name');
        $student->last_name = $this->input->post('last_name');
        $student->email = trim($this->input->post('email'));
        $student->country = $this->input->post('country');
        $student->admin_id = $this->input->post('admin_id');
        $student->group_id = $this->input->post('group_id');
        $student->zip_code = $this->input->post('zip_code');
        $student->language = $this->input->post('language');
        $student->instruction_language = $this->input->post('instruction_language');
        
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'cbc',
                    'key' => $this->config->encryption_key
                )
        );
        $unencryptedPassword = $this->authex->randomPassword();
        $student->password = $this->encryption->encrypt($unencryptedPassword);
        
        $this->Student_model->insert($student);
        
        $this->email->from('noreply@hh.se', 'Halmstad University Prospects');
        $this->email->to($student->email);
        $this->email->subject('HH Prospects New Account');
        $this->email->message("Hi " . $student->first_name . " " . $student->last_name . "\nA new account was made for you on the Halmstad University Prospects webapp.\nHere is your new password: " . $unencryptedPassword);
        $this->email->send();
    }
    
    public function uploadFile() {
        echo "not functional";
    }
    
    public function insertGroup() {
        $group = new stdClass();
        $group->name = trim($this->input->post('name'));
        $this->Group_model->insert($group);
    }
    
    public function getEmailTemplates() {
        $data['email_templates'] = $this->Email_model->getAll();
        $this->load->view('admin/emails_table', $data);
    }
    
    public function getEmailTemplate($id) {
        $email = $this->Email_model->get($id);
        echo json_encode($email);
    }
    
    public function insertEmailTemplate() {
        $email = new stdClass();
        $email->name = trim($this->input->post('name'));
        $email->subject = $this->input->post('subject');
        $email->content = $this->input->post('content');
        $this->Email_model->insert($email);
    }
    
    public function sendEmail($id) {
        $email = $this->Email_model->get($id);
        $group_id = $this->input->post('group_id');
        $students = $this->Student_model->getFromGroup($group_id);
        $email_addresses = array_column($students, 'email');
        
        $this->email->from('noreply@hh.se', 'Halmstad University Prospects');
        $this->email->bcc($email_addresses);
        $this->email->subject($email->subject);
        
        $data = array();
        $data['email_content'] = preg_replace("/\r\n|\r|\n/",'<br/>', $email->content);
        
        //$this->email->message($this->load->view('emails/email_template', $data, TRUE));
        $this->email->message(preg_replace("/\r\n|\r|\n/",'<br/>', $email->content));
        $this->email->set_mailtype("html");
        $this->email->send();
    }
}
