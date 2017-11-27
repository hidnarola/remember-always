<?php

/**
 * Login Controller for Administrator Login
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display dashboard page
     */
    public function index() {
        $this->data['title'] = 'Remember Always Admin | Dashboard';
        $this->template->load('admin', 'admin/dashboard', $this->data);
    }
}
