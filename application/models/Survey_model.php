<?php

class Survey_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('Group_model');
        $this->load->model('Question_model');
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('survey');
        $survey = $query->row();
        
        $survey->group = $this->Group_model->get($survey->group_id);
        $survey->questions = $this->Question_model->getQuestionsBySurvey($survey->id);
        
        return $survey;
    }

    function getAll() {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('survey');
        $surveys = $query->result();
        
        foreach($surveys as $survey){
            $survey->group = $this->Group_model->get($survey->group_id);
            $survey->question_count = $this->Question_model->getSurveyQuestionCount($survey->id);
        }

        return $surveys;
    }
    
    function insert($survey) {
        $this->db->insert('survey', $survey);
        return $this->db->insert_id();
    }
    
    function toggleActive($survey) {
        $this->db->where('id', $survey->id);
        $this->db->update('survey', $survey);
    }
    
    function getStudentActiveSurvey($group_id) {
        $this->db->where('group_id', $group_id);
        $this->db->where('active', TRUE);
        $this->db->where('starts_on <', date('Y-m-d H:i:s'));
        $this->db->where('ends_on >', date('Y-m-d H:i:s'));
        $query = $this->db->get('survey');
        if ($query->num_rows() > 0) {
            $survey = $query->first_row();
            //$survey->questions = $this->Question_model->getSurveyQuestions($survey->id);
        } else {
            return null;
        }
    }
}
