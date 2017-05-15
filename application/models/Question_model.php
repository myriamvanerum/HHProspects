<?php

class Question_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('question');
        return $query->row();
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
}
