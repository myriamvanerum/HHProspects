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
    
    function insert($group) {
        $this->db->insert('group', $group);
    }
    
    function update($group) {
        $this->db->where('id', $group->id);
        $this->db->update('group', $group);
    }
    
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('group');
    }
}
