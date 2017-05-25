<?php

class Question_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('question');
        $question = $query->row();
        
        $question->question_type = $this->getType($question->question_type_id);
        $question->answer_options = $this->getAnswerOptions($question->id);

        return $question;
    }

    function getAll() {
        $this->db->order_by('title', 'asc');
        $query = $this->db->get('question');
        $questions = $query->result();
        
        foreach($questions as $question){
            $question->question_type = $this->getType($question->question_type_id);
        }

        return $questions;
    }
    
    function getAllActive($searchString, $ids) {
        $this->db->where('active', TRUE);
        $this->db->like('text', $searchString);
        $this->db->where_not_in('id', $ids);
        $this->db->order_by('text', 'asc');
        $query = $this->db->get('question');
        $questions = $query->result();
        
        foreach($questions as $question){
            $question->question_type = $this->getType($question->question_type_id);
        }

        return $questions;
    }
    
    function getByIdArray($ids) {
        $this->db->where_in('id', $ids);
        $query = $this->db->get('question');
        $questions = $query->result();
        
        foreach($questions as $question){
            $question->question_type = $this->getType($question->question_type_id);
        }

        return $questions;
    }
    
    function insert($question) {
        $this->db->insert('question', $question);
        return $this->db->insert_id();
    }
    
    function getType($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('question_type');
        return $query->row();
    }
    
    function getAnswerOptions($question_id) {
        $this->db->where('question_id', $question_id);
        $query = $this->db->get('question_answer_option');
        $question_answer_options = $query->result();
        
        $answer_options = array();
        
        foreach($question_answer_options as $question_answer_option){
            $this->db->where('id', $question_answer_option->answer_option_id);
            $query = $this->db->get('answer_option');
            $answer_option =  $query->row();
            array_push($answer_options, $answer_option->answer);
        }
        
        return $answer_options;
        
    }
    
    function getAllQuestionTypes() {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('question_type');
        return $query->result();
    }
    
    function insertAnswerOption($answer_options, $question_id) {
        foreach ($answer_options as $answer_option_text) {
            $question_answer_option = new stdClass();
            $question_answer_option->question_id = $question_id;
            
            $answer_option = new stdClass();
            $answer_option->answer = $answer_option_text;
                
            // Does this answer_option already exist?
            $answer_option_id = $this->existsAnswerOption($answer_option_text);
            
            if ($answer_option_id != 0)
            {
                // yes --> save association with this id
                $question_answer_option->answer_option_id = $answer_option_id;                
            }
            else
            {
                // no --> insert + save association with new id
                $this->db->insert('answer_option', $answer_option);
                $question_answer_option->answer_option_id = $this->db->insert_id();
            }
            
            $this->db->insert('question_answer_option', $question_answer_option);
        }
    }
    
    function existsAnswerOption($answer) {
        $this->db->where('LOWER(answer)', strtolower(trim($answer)));
        $query = $this->db->get('answer_option');
        $answer_option = $query->row();
        if ($query->num_rows() >= 1) {
            return $answer_option->id;
        } else {
            return 0;
        }
    }
    
    function getSurveyQuestionCount($survey_id){
        $this->db->where('survey_id', $survey_id);
        $query = $this->db->get('survey_question');
        return $query->num_rows();
    }
    
    function isQuestionUsedInSurvey($id) {
        $this->db->where('question_id', $id);
        $query = $this->db->get('survey_question');
        if ($query->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }
    
    function delete($id) {
        $this->db->where('question_id', $id);
        $this->db->delete('question_answer_option');
        
        $this->db->where('id', $id);
        $this->db->delete('question');
    }
    
    function getSurveyQuestions($survey_id) {
        $this->db->where('survey_id', $survey_id);
        $query = $this->db->get('survey_question');
        $survey_questions = $query->result();
        
        $questions = array();
        
        foreach($survey_questions as $survey_question){
            $question = $this->get($survey_question->question_id);
            array_push($questions, $question);
        }
        
        foreach ($questions as $question) {
            $question->question_type = $this->getType($question->question_type_id);
            $question->answer_options = $this->getAnswerOptions($question->id);
        }
        
        return $questions;
        
    }
    
    function toggleActive($question) {
        $this->db->where('id', $question->id);
        $this->db->update('question', $question);
    }
    
    function insertSurveyQuestions($question_ids, $survey_id) {
        foreach ($question_ids as $question_id) {
            $survey_question = new stdClass();
            $survey_question->question_id = $question_id;
            $survey_question->survey_id = $survey_id;
            $this->db->insert('survey_question', $survey_question);
        }
    }
}
