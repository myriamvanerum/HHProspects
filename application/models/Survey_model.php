<?php

class Survey_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('Group_model');
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('survey');
        return $query->row();
    }

    function getAll() {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('survey');
        $surveys = $query->result();
        
        foreach($surveys as $survey){
            $survey->group = $this->Group_model->get($survey->group_id);
        }

        return $surveys;
    }
    
    function insert($survey) {
        $this->db->insert('survey', $survey);
    }
}
