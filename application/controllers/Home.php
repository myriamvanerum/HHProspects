<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

//	public function index()
//	{
//		$this->load->view('welcome_message');
//	}

    public function index() {
        $data['title'] = "Halmstad University Prospects";
//        $data['navbarActive'] = "De Weide Wereld";
//        $data['gebruiker'] = json_encode($this->authex->getUserInfo());
//
//        $this->load->model('Paragraaf_model');
//        $data['paragrafen'] = $this->Paragraaf_model->getAllHomepaginaParagrafen();

        $this->LoadView('welcome_message', $data);
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
