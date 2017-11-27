<?php

/**
 * Dashboard controller for dashboard of Administrator
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

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
