<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//***************************Myriam Van Erum********************************
/**
 * Page coded by Myriam Van Erum 
 * Sysop controller
 */
class Sysop extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_control->sysopLoggedIn();
    }
    
    public function index() {
        $data['title'] = "HH Prospects";
        $this->LoadView('sysop/sysop', $data);
    }
    
    public function getUsers() {
        $data['users'] = $this->User_model->getAll();
        $this->load->view('sysop/users_table', $data);
    }
    
    public function getUser($id) {
        $user = $this->User_model->get($id);
        echo json_encode($user);
    }
    
    public function isUserResponsibleAdmin($id) {
        $userResponsible = $this->User_model->isUserResponsibleAdmin($id);
        echo json_encode($userResponsible);
    }
    
    public function deleteUser($id) {
        $this->User_model->delete($id);
    }

    public function LoadView($viewnaam, $data) {

        $partials = array(
            'title' => $data['title'],
            'header' => $this->parser->parse('main_header', $data, true),
            'content' => $this->parser->parse($viewnaam, $data, true),
            'footer' => $this->parser->parse('main_footer', $data, true)
        );
        
        $this->parser->parse('main_master', $partials);
    }
}
