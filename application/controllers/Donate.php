<?php

/**
 * Donate Controller
 * Make donations to fund raiser profile
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Donate extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Donation';
        $this->template->load('default', 'donate/index', $data);
    }

    public function first() {
        $data['title'] = 'first';
        $this->template->load('default', 'donate/first', $data);
    }

    public function second() {
        $data['title'] = 'second';
        $this->template->load('default', 'donate/second', $data);
    }

    public function third() {
        $data['title'] = 'third';
        $this->template->load('default', 'donate/third', $data);
    }

}
