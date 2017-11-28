<?php

/**
 * Home Controller
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display login page for login
     */
    public function index() {
        $data['title'] = 'Remember Always';
        $this->load->view('coming_soon', $data);
//        $this->template->load('default', 'home', $data);
    }

}
