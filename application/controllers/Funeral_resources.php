<?php

/**
 * funeral_resources Controller
 * Display all funeral resources
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Funeral_resources extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display funeral planing page
     */
    public function index() {
        $data['title'] = 'Funeral Resources';
        $data['breadcrumb'] = ['title' => 'Funeral Planing', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'resources/funeral_planing', $data);
    }

}
