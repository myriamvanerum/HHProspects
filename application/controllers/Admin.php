<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//***************************Myriam Van Erum********************************
/**
 * Page coded by Myriam Van Erum 
 * Home page
 */
class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->user_control->adminLoggedIn();
    }
    
    public function index() {
        $data['title'] = "HH Prospects";
        $this->LoadView('sbadmin', $data);
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
