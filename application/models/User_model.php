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
        //return $this->db->update_id();
    }

}
