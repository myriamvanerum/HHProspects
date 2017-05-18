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
    
    function insert($question) {
        $this->db->insert('question', $question);
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
}
