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
        $student = $this->authex->getStudentInfo();
        $questions = $this->input->post('questions');
                
        foreach ($questions as $questionArray) {
            $question = new stdClass();
            $question->id = (int)$questionArray['id'];
            $question->answer_or_comment = $questionArray['answer_or_comment'];
            
            if ($questionArray['date_answer'] != null) {
                $question->date_answer = $questionArray['date_answer'];
            } else
            {
                $question->date_answer = null;
            }
            
            $question->chosen_answers = array();
            foreach ($questionArray['chosen_answers'] as $answer) {
                if ($answer != "0") {
                    array_push($question->chosen_answers, (int)$answer);
                }
            }
            
            $this->Question_model->insertQuestionAnswers($question, $student->id);
        }
        
        $this->session->set_flashdata('success', 1);
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
