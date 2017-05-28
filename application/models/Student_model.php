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
    
    // get a student. Also get corresponding admin and group.
    function getWithAdmin($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('student');        
        $student = $query->row();
        
        $student->admin = $this->User_model->get($student->admin_id);
        $student->group = $this->Group_model->get($student->group_id);

        return $student;
    }

    function getAll() {
        $this->db->order_by('last_name', 'asc');
        $query = $this->db->get('student');
        return $query->result();
    }
    
    function getFromGroup($group_id) {
        $this->db->where('group_id', $group_id);
        $query = $this->db->get('student');
        return $query->result();
    }
    
    // get all students. Also get corresponding admin and group.
    function getAllWithAdmin() {
        $this->db->order_by('last_name', 'asc');
        $query = $this->db->get('student');
        
        $students = $query->result();
        
        foreach($students as $student){
            $student->admin = $this->User_model->get($student->admin_id);
            $student->group = $this->Group_model->get($student->group_id);
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
    
    // delete old failed login attempts after 30 minutes
    function deleteOldLoginAttempts($time) {
        $this->db->where('timestamp <', $time);
        $this->db->delete('student_login_attempt');
    }
    
    // delete a students failed login attempts when he is assigned a new password
    function deleteLoginAttemptsOneStudent($id) {
        $this->db->where('student_id', $id);
        $this->db->delete('student_login_attempt');
    }
    
    function countLoginAttempts($student_id) {
        $this->db->where('student_id', $student_id);
        $this->db->from('student_login_attempt');
        return $this->db->count_all_results();
    }
    
    // log a failed login attempt for a student
    function logFailedLoginAttempt($login_attempt) {
        $this->db->insert('student_login_attempt', $login_attempt);
    }
    
    // log when password is reset for a student. this also triggers deleteLoginAttemptsOneStudent()
    function logPasswordReset($login_attempt) {
        $this->db->insert('student_failed_login_log', $login_attempt);
    }
    
    function insert($student) {
        $this->db->insert('student', $student);
    }
}
