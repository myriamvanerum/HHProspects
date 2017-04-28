<?php

class Student_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('string');
        $this->load->model('Student_model');
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
    
    function getAllWithAdmin() {
        $this->db->order_by('first_name', 'asc');
        $query = $this->db->get('student');
        
        $students = $query->result();
        
        foreach($students as $student){
            $student->admin = $this->User_model->get($student->admin_id);
        }

        return $students;
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
    
    function deleteOldLoginAttempts($time) {
        $this->db->where('timestamp <', $time);
        $this->db->delete('student_login_attempt');
    }
    
    function deleteLoginAttemptsOneStudent($id) {
        $this->db->where('student_id', $id);
        $this->db->delete('student_login_attempt');
    }
    
    function countLoginAttempts($student_id) {
        $this->db->where('student_id', $student_id);
        $this->db->from('student_login_attempt');
        return $this->db->count_all_results();
    }
    
    function logFailedLoginAttempt($login_attempt) {
        $this->db->insert('student_login_attempt', $login_attempt);
    }
    
    function logPasswordReset($login_attempt) {
        $this->db->insert('student_failed_login_log', $login_attempt);
    }
}
