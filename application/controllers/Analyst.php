<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//***************************Myriam Van Erum********************************
/**
 * Page coded by Myriam Van Erum 
 * Analyst controller
 */
class Analyst extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_control->analystLoggedIn();
        $this->load->model('Survey_model');
        $this->load->model('Question_model');
    }
    
    public function index() {
        $data['title'] = "HH Prospects";
        $this->LoadView('analyst/surveys', $data);
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
    
    public function getSurveys() {
        $data['surveys'] = $this->Survey_model->getAll();
        $this->load->view('analyst/surveys_table', $data);
    }
    
    public function questions() {
        $data['title'] = "HH Prospects";
        $this->LoadView('analyst/questions', $data);
    }
    
    public function getQuestions() {
        $data['questions'] = $this->Question_model->getAll();
        $this->load->view('analyst/questions_table', $data);
    }
    
    public function getQuestion($id) {
        $question = $this->Question_model->get($id);
        echo json_encode($question);
    }
    
    public function analysis() {
        $data['title'] = "HH Prospects";
        $this->LoadView('analyst/analysis', $data);
    }
}
