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
                p($output->PRODUCTS);
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
        $cartname = $this->session->userdata('cart_id');
        $url = "https://www.floristone.com/api/rest/shoppingcart?sessionid=$cartname";
        $output = $floristone->send_flower($url);
        $cart_item = [];
        /* overall totak products or flowers available */
        if (!isset($output->errors)) {
            if (isset($output->products) && !empty($output->products)) {
                foreach ($output->products as $key => $value) {
                    $code = $output->products[$key]->CODE;
                    $cart_floristone = new Floristone();
                    $cart_url = "https://www.floristone.com/api/rest/flowershop/getproducts?code=$code";
                    $cart_output = $cart_floristone->send_flower($cart_url);
                    if (!isset($cart_output->errors)) {
                        $cart_item[] = $cart_output->PRODUCTS[0];
                    }
                }
//                $products = array(array('code' => 'S7-4450', 'rpa' => 0)); //one item
//                $products = json_encode($products);
//                $total_url = "https://www.floristone.com/api/rest/giftbaskets/gettotal?products=$products";
//                $floristone = new Floristone();
//                $output = $floristone->send_flower($total_url);
//                if (!isset($output->errors)) {
//                    var_dump($output);
//                } else {
//                    var_dump($output);
//                }
            }
        }
        if ($this->input->method() == 'post') {
            $states = $this->users_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => base64_decode($this->input->post('country')))]);
            if (!empty($states)) {
                $data['states'] = $states;
            }
            $cities = $this->users_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => base64_decode($this->input->post('state')))]);
            if (!empty($cities)) {
                $data['cities'] = $cities;
            }
        }
        $data['cart_items'] = $cart_item;
        $countries = $this->users_model->sql_select(TBL_COUNTRY . ' c');
        $data['countries'] = $countries;
        $data['title'] = 'My Cart';
        $data['breadcrumb'] = ['title' => 'My Cart', 'links' => [['link' => site_url(), 'title' => 'Home'], ['link' => site_url('flowers'), 'title' => 'Flowers']]];
        $this->template->load('default', 'flowers/order_form', $data);
    }

    /**
     * Get cities  or state based on type passed as data.
     * */
    public function get_data() {
        $type = $this->input->post('type');
        $options = '';
        if ($type == 'city') {
            $id = base64_decode($this->input->post('id'));
            $options = '<option value="">-- Select City --</option>';
            if (is_numeric($id)) {
                $data = $this->users_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => trim($id))]);
                if (!empty($data)) {
                    foreach ($data as $row) {
                        $options .= "<option value = '" . base64_encode($row['id']) . "'>" . $row['name'] . "</option>";
                    }
                }
            }
        } else if ($type == 'state') {
            $id = base64_decode($this->input->post('id'));
            $options = '<option value="">-- Select State --</option>';
            if (is_numeric($id)) {
                $data = $this->users_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => trim($id))]);
                if (!empty($data)) {
                    foreach ($data as $row) {
                        $options .= "<option value = '" . base64_encode($row['id']) . "'>" . $row['name'] . "</option>";
                    }
                }
            }
        } else if ($type == 'zip') {
            $zipcode = $this->input->post('id');
            $options = '<option value="">-- Delivery Date --</option>';
            $url = "https://www.floristone.com/api/rest/flowershop/checkdeliverydate?zipcode=$zipcode";
            $floristone = new Floristone();
            $output = $floristone->send_flower($url);
            $dates = $output->DATES;
            foreach ($dates as $val) {
                $options .= "<option value = '" . $val . "'>" . $val . "</option>";
            }
        }
        echo $options;
    }

    /**
     * Display particular flower details
     */
    public function manage_cart($code = null, $action = null) {
        $data = [];
        if (!empty($code) && $code != null) {
            if (empty($this->session->userdata('cart_id'))) {
                if (!$this->is_user_loggedin) {
                    $cartname = hash('md5', $_SERVER['REMOTE_ADDR']);
                } else {
                    $cartname = hash('md5', $this->session->userdata('remalways_user')['id']);
                }
                $session_option = array(CURLOPT_POST => true, CURLOPT_POSTFIELDS => array('sessionid' => $cartname));
                $session_url = "https://www.floristone.com/api/rest/shoppingcart";
                $floristone = new Floristone();
                $output = $floristone->send_flower($session_url, $session_option);
                if (!isset($output->errors)) {
                    if (!empty($output)) {
                        $this->session->set_userdata('cart_id', $cartname);
                    } else {
                        $cartname = '';
                    }
                } else {
                    $cartname = '';
                }
            } else {
                $cartname = $this->session->userdata('cart_id');
            }
            $floristone = new Floristone();
            $product = $code;
            if ($action == 'add') {
                $add_cart_option = array(CURLOPT_PUT => true);
                $add_cart_url = "https://www.floristone.com/api/rest/shoppingcart?sessionid=$cartname&productcode=$product&action=$action";
                $floristone = new Floristone();
                $add_cart_output = $floristone->send_flower($add_cart_url, $add_cart_option);
                if (!isset($add_cart_output->errors)) {
//                    var_dump($add_cart_output->STATUS);
                    $data['success'] = true;
                    $data['data'] = 'Flower have been added to cart!';
                } else {
//                    var_dump($add_cart_output);
                    $data['success'] = false;
                    $data['error'] = 'Something went wrong pelase try again!';
                }
            } else if ($action == 'remove') {
                $delete_cart_option = array(CURLOPT_PUT => true);
                $delete_cart_url = "https://www.floristone.com/api/rest/shoppingcart?sessionid=$cartname&productcode=$product&action=$action";
                $floristone = new Floristone();
                $delete_cart_output = $floristone->send_flower($delete_cart_url, $delete_cart_option);
                if (!isset($delete_cart_output->errors)) {
//                    var_dump($delete_cart_output->STATUS);
                    $data['success'] = true;
                    $data['data'] = 'Flower have been remove from cart!';
                } else {
//                    var_dump($delete_cart_output);
                    $data['success'] = false;
                    $data['error'] = 'Something went wrong pelase try again!';
                }
            } else {
                $data['success'] = false;
                $data['error'] = 'Invalid request, Please try again!';
            }
        } else {
            $data['success'] = false;
            $data['error'] = 'Invalid request, Please try again!';
        }

        echo json_encode($data);
        exit;
    }

    public function check_date($zipcode = '19803') {
//        19803
        $url = "https://www.floristone.com/api/rest/flowershop/checkdeliverydate?zipcode=$zipcode";
        $floristone = new Floristone();
        $output = $floristone->send_flower($url);
        $dates = $output->DATES;
        echo("Available Delivery Dates: ");
        for ($x = 0; $x < count($dates); $x++) {
            echo $dates[$x] . '<br/>';
        }
    }

}
