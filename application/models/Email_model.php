<?php

class Email_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('string');
        $this->load->model('Group_model');
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('email_template');
        return $query->row();
    }

    function getAll() {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('email_template');
        return $query->result();
    }
    
    function insert($email) {
        $this->db->insert('email_template', $email);
    }
    
    function update($email) {
        $this->db->where('id', $email->id);
        $this->db->update('email_template', $email);
    }
    
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('email_template');
    }
}
