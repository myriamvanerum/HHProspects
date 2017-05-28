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
        $this->load->model('Group_model');
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
    
    // Surveys page
    public function index() {
        $data['title'] = "HH Prospects";
        $this->LoadView('analyst/surveys', $data);
    }
    
    public function getSurveys() {
        $data['surveys'] = $this->Survey_model->getAll();
        $this->load->view('analyst/surveys_table', $data);
    }
    
    public function getSurvey($id) {
        $survey = $this->Survey_model->get($id);
        echo json_encode($survey);
    }
    
    public function newSurvey() {
        $data['title'] = "HH Prospects";
        $this->LoadView('analyst/new_survey', $data);
    }
    
    public function getGroups() {
        $groups = $this->Group_model->getAll();
        echo json_encode($groups);
    }
    
    public function getAddQuestions() {
        $searchString = $this->input->post('searchString');
        $questionIds = $this->input->post('questionIds');
        $data['questions'] = $this->Question_model->getAllActive($searchString, $questionIds);
        $this->load->view('analyst/add_questions_table', $data);
    }
    
    public function toggleSurveyActive($id) {
        $survey = new stdClass();
        $survey->id = $id;
        $survey->active = $this->input->post('active');
        $survey->active = !$survey->active;
        $this->Survey_model->toggleActive($survey);
    }
    
    public function showAddedQuestions() {
        $questionIds = $this->input->post('questionIds');
        if (count($questionIds) != 0) {
            $data['questions'] = $this->Question_model->getByIdArray($questionIds);
            $this->load->view('analyst/survey_questions_table', $data);
        } else {
            echo "You haven't added any questions to this survey yet.<br><br>";
        } 
    }
    
    public function insertSurvey() {
        $survey = new stdClass();
        $survey->name = $this->input->post('name');
        $survey->group_id = $this->input->post('group');
        $survey->description = $this->input->post('description');
        $survey->comment = $this->input->post('comment');
        $survey->created_on = date('Y-m-d H:i:s');
        $survey->used_on = date('Y-m-d H:i:s');
        $survey->starts_on = $this->input->post('starts_on');
        $survey->ends_on = $this->input->post('ends_on');
        $survey->active = TRUE;
        $survey_id = $this->Survey_model->insert($survey);
        
        $question_ids = $this->input->post('questions');
        $this->Question_model->insertSurveyQuestions($question_ids, $survey_id);
        
        redirect('Analyst');
    }
    
    
    
    
    // questions page
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
    
    public function toggleQuestionActive($id) {
        $question = new stdClass();
        $question->id = $id;
        $question->active = $this->input->post('active');
        $question->active = !$question->active;
        $this->Question_model->toggleActive($question);
    }
    
    
    // analysis page
    public function analysis() {
        $data['title'] = "HH Prospects";
        $this->LoadView('analyst/analysis', $data);
    }
    
    public function getQuestionsAnalysis() {
        $questions = $this->Question_model->getAll();
        
        echo json_encode($questions);
    }
}
