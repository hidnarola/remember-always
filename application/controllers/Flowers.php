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
    public function index($start = 0) {
        $category_data = array('sy' => 'Funeral and Sympathy',
            'fa' => 'Funeral Table arrangements',
            'fb' => 'Funeral Baskets',
            'fs' => 'Funeral Sprays',
            'fp' => 'Funeral Plants',
            'fl' => 'Funeral Inside Casket',
            'fw' => 'Funeral Wreaths',
            'fh' => 'Funeral Hearts',
            'fx' => 'Funeral Crosses',
            'fc' => 'Funeral Casket sprays');
        $prize_data = array('fu60' => 'Flowers Under $60',
            'f60t80' => 'Flowers between $60 and $60',
            'f80t100' => 'Flowers between $80 and $100',
            'fa100' => 'Flowers above $100');
        $floristone = new Floristone();
        $count = 6;
        $start = $start + 1;
        $url = "https://www.floristone.com/api/rest/flowershop/getproducts?count=$count&start=$start";
        if (!empty($this->input->get())) {
            $data = $this->input->get();
            if (isset($data['category']) && !empty($data['category'])) {
                $url .= "&category=" . $data['category'];
            }
        } else {
            $url .= "&category=sy";
        }

        $output = $floristone->send_flower($url);
        $page_config = front_pagination();
        $page_config['per_page'] = 6;
        $page_config['reuse_query_string'] = true;
        $page_config['base_url'] = site_url('flowers');
//        /* overall totak products or flowers available */
        if (!isset($output->errors)) {
            $page_config["total_rows"] = $output->TOTAL;
            $data['flowers'] = $output->PRODUCTS;
        } else {
//            p($output->errors);
        }
        $this->pagination->initialize($page_config);

        $data['categories'] = $category_data;
        $data['prize_categories'] = $prize_data;
        $data['title'] = 'Flowers';
        $data['breadcrumb'] = ['title' => 'Flowers', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'flowers/index', $data);
    }

    /**
     * Display particular flower details
     */
    public function view($code = null) {
        if (!empty($code)) {
            $floristone = new Floristone();
            $url = "https://www.floristone.com/api/rest/flowershop/getproducts?code=$code";
            $output = $floristone->send_flower($url);
            /* overall totak products or flowers available */
            if (!isset($output->errors)) {
                $data['flower'] = $output->PRODUCTS[0];
            } else {
                custom_show_404();
            }
            $data['title'] = 'Flower Details';
            $data['breadcrumb'] = ['title' => 'Flower Details', 'links' => [['link' => site_url(), 'title' => 'Home'], ['link' => site_url('flowers'), 'title' => 'Flowers']]];
            $this->template->load('default', 'flowers/details', $data);
        } else {
            custom_show_404();
        }
    }

    /**
     * Display particular flower details
     */
    public function cart() {
        $floristone = new Floristone();
//        $cartname = 'abcdefg';
        $cartname = 'abcdefg';
        $url = "https://www.floristone.com/api/rest/shoppingcart?sessionid=$cartname";
        $output = $floristone->send_flower($url);
        /* overall totak products or flowers available */
        if (!isset($output->errors)) {
            var_dump($output);
        } else {
            var_dump($output);
//            custom_show_404();
        }
    }

    /**
     * Display particular flower details
     */
    public function manage_cart($code = null) {
        if (!empty($code) && $code != null) {
            if (empty($this->session->userdata('cart_id'))) {
                if (!$this->is_user_loggedin) {
                    $cartname = hash('sha256', $_SERVER['REMOTE_ADDR']);
                } else {
                    $cartname = hash('sha256', $this->session->userdata('remalways_user')['email']);
                }
                $this->session->set_userdata('cart_id', $cartname);
            } else {
                $cartname = $this->session->userdata('cart_id');
            }
            p($cartname);
            $floristone = new Floristone();
            $product = 'F1-509';
            $action = 'add';
        }
    }

}
