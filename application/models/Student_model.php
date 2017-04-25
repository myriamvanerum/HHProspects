<?php

class Student_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('string');
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('student');
        return $query->row();
    }

    function getAll() {
        $this->db->order_by('first_name', 'asc');
        $query = $this->db->get('student');
        return $query->result();
    }

    function getStudentByEmail($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('student');
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return null;
        }
    }
    
    function email_exists($email){
        $this->db->where('email', $email);
        $query = $this->db->get('student');
        if ($query->num_rows() !== 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function update_password($email, $password){
        $student = $this->getStudentByEmail($email);
        
        $this->load->library('encryption');
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'cbc',
                    'key' => $this->config->encryption_key
                )
            );
        $student->password = $this->encryption->encrypt($password);
        
        $this->db->where('email', $student->email);
        $this->db->update('student', $student);
    }

}
