<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//***************************Myriam Van Erum********************************
/**
 * Page coded by Myriam Van Erum 
 * Student controller
 */
class Student extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_control->studentLoggedIn();
        $this->load->model('Student_model');
        $this->load->model('Survey_model');
    }
    
    public function index() {
        $student = $this->authex->getStudentInfo();
        $activeSurvey = $this->Survey_model->getStudentActiveSurvey($student->group_id, $student->id);
        
        if ($activeSurvey != null) {
            $data['title'] = "HH Prospects";
            $data['success'] = $this->session->flashdata('success');
            $data['surveys'] = array("surveys" => $activeSurvey);
            $this->LoadView('student/student', $data);
        } else {
            $data['title'] = "HH Prospects";
            $this->LoadView('student/no_survey', $data);
        }
    }
    
    public function sendSurvey() {
        
        $this->session->set_flashdata('success', 1);
        redirect("Student");
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
}
