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
    
    public function getSurvey($id) {
        $survey = $this->Survey_model->get($id);
        echo json_encode($survey);
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
    
    public function isQuestionUsedInSurvey($id) {
        $questionUsed = $this->Question_model->isQuestionUsedInSurvey($id);
        echo json_encode($questionUsed);
    }
    
    public function getQuestionTypes() {
        $question_types = $this->Question_model->getAllQuestionTypes();
        echo json_encode($question_types);
    }
    
    public function insertQuestion() {
        $question = new stdClass();
        $question->title = $this->input->post('title');
        $question->question_type_id = $this->input->post('question_type');
        $question->description = $this->input->post('description');
        $question->text = $this->input->post('question');
        $question_id = $this->Question_model->insert($question);
        
        $answer_options = $this->input->post('answer_options');
        $this->Question_model->insertAnswerOption($answer_options, $question_id);
    }
    
    public function deleteQuestion($id) {
        $this->Question_model->delete($id);
    }
    
    public function analysis() {
        $data['title'] = "HH Prospects";
        $this->LoadView('analyst/analysis', $data);
    }
}
