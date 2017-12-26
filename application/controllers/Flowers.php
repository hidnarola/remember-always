<?php

/**
 * Profile Controller
 * Manage profile related functions
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Flowers extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('floristone');
    }

    /**
     * Display login page for login
     */
    public function index($start = 1) {
        $floristone = new Floristone();
        $count = 5;
        $url = "https://www.floristone.com/api/rest/flowershop/getproducts?count=$count&start=$start";
        if (!empty($this->input->get())) {
            $data = $this->input->get();
            if (isset($data['category']) && !empty($data['category'])) {
                p($data['category']);
                $url .= "&category=" . $data['category'];
            }
        }
        $output = $floristone->send_flower($url);
        /* overall totak products or flowers available */
        if (!isset($output->errors)) {
            p($output->TOTAL);
            p($output->PRODUCTS);
        } else {
            p($output->errors);
        }
    }

    /**
     * Display particular flower details
     */
    public function view($code = null) {
        if (!empty($code)) {
            $floristone = new Floristone();
            $count = 5;
            $url = "https://www.floristone.com/api/rest/flowershop/getproducts?code=$code";
            $output = $floristone->send_flower($url);
            /* overall totak products or flowers available */
            if (!isset($output->errors)) {
                p($output->PRODUCTS);
            } else {
                custom_show_404();
            }
        } else {
            custom_show_404();
        }
    }

}
