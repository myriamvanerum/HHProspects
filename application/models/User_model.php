<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        $user = $query->row();
        $user->user_level = $this->getUserLevel($user->level);
        return $user;
    }

    function getAll() {
        $this->db->order_by('last_name', 'asc');
        $query = $this->db->get('user');
        $users = $query->result();
        foreach ($users as $user) {
            $user->user_level = $this->getUserLevel($user->level);
        }
        
        return $users;
    }
    
    function insert($user) {
        $this->db->insert('user', $user);
        return $this->db->insert_id();
    }
    
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('user');
    }
    
    function isUserResponsibleAdmin($id) {
        $this->db->where('admin_id', $id);
        $query = $this->db->get('student');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function getUserLevel($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user_level');
        return $query->row();
    }
    
    function getAllUserLevels() {
        $query = $this->db->get('user_level');
        return $query->result();
    }
    
    function getAllByLevel($level) {
        $this->db->order_by('last_name', 'asc');
        $this->db->where('level', $level);
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
        $this->db->where('level >', 1);
        $query = $this->db->get('user');
        if ($query->num_rows() !== 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function update_password($email, $password){
        $user = $this->getUser($email);
        
        $this->load->library('encryption');
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'cbc',
                    'key' => $this->config->encryption_key
                )
            );
        $user->password = $this->encryption->encrypt($password);
        
        $this->db->where('email', $user->email);
        $this->db->update('user', $user);
    }
    
    function logFailedLoginAttempt($login_attempt) {
        $this->db->insert('login_attempt', $login_attempt);
    }
    
    function deleteOldLoginAttempts($time) {
        $this->db->where('timestamp <', $time);
        $this->db->delete('login_attempt');
    }
    
    function countLoginAttempts($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->from('login_attempt');
        return $this->db->count_all_results();
    }

}
