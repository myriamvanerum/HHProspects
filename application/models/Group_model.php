<?php

class Group_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('group');
        return $query->row();
    }

    function getAll() {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('group');
        return $query->result();
    }
}
