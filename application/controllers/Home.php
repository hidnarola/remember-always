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
        $data['slider'] = $this->users_model->sql_select(TBL_SLIDER, 'image,description', ['where' => ['is_delete' => 0, 'is_active' => 1]]);
//        $this->template->load('default', 'home', $data);
        $this->load->view('coming_soon', $data);
    }

}
