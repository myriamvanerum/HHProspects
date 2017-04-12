<?php

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('string');
    }

    function get($id) {
        $this->db->where('user_id', $id);
        $query = $this->db->get('user');
        return $query->row();
    }

    function getAll() {
        $this->db->order_by('user_first_name', 'asc');
        $query = $this->db->get('user');
        return $query->result();
    }

    function getUser($email) {
        $this->db->where('user_email', $email);
        $query = $this->db->get('user');
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return null;
        }
    }

}
