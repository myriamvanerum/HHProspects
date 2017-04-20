<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('string');
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->row();
    }

    function getAll() {
        $this->db->order_by('first_name', 'asc');
        $query = $this->db->get('user');
        return $query->result();
    }

    function getUser($email) {
        $this->db->where('email', $email);
        $this->db->where('level >', 1);
        $query = $this->db->get('user');
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return null;
        }
    }
    
    function getUserSysop($email) {
        $this->db->where('email', $email);
        $this->db->where('level', 1);
        $query = $this->db->get('user');
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return null;
        }
    }
    
    function email_exists($email){
        $this->db->where('email', $email);
        $query = $this->db->get('user');
        if ($query->num_rows() !== 0) {
            return true;
        } else {
            return false;
        }
    }

}
