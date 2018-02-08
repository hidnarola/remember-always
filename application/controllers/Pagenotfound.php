<?php

/**
 * Pagenotfound Controller
 * Displays 404 error page when 404 error encountered 
 * @author KU
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagenotfound extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $directory = $this->router->fetch_directory();
        $segments = $this->router->uri->segments;

        //check if directory is admin or not
        $this->output->set_status_header('404'); // setting header to 404
        if ($directory == 'admin/' || in_array('admin', $segments)) {
            $this->load->view('Templates/show_404');
        } else {
            $this->load->view('Templates/Front_show_404');
        }
    }

}

?> 