<?php

/**
 * Flowers Controller
 * Manage flowers related functions
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Flowers extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('floristone');
//        custom_show_404();
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

        /*
          $prize_data = array(
          'fu60' => 'Flowers Under $60',
          'f60t80' => 'Flowers between $60 and $80',
          'f80t100' => 'Flowers between $80 and $100',
          'fa100' => 'Flowers above $100'); */

        $prize_data = array(
            'f60t80' => 'Flowers under $80',
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
//                p($output->PRODUCTS);
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
        $countries = $this->users_model->sql_select(TBL_COUNTRY . ' c', null, ['where_in' => ['id' => array('38', '231')]]);
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
                        $options .= "<option value = '" . $row['name'] . "'>" . $row['name'] . "</option>";
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
                        $shortcode = '';
                        if ($row['shortcode'] != NULL) {
                            $temp = explode('-', $row['shortcode']);
                            $shortcode = $temp[1];
                        }
                        $options .= "<option value = '" . $shortcode . "' data-bind='" . base64_encode($row['id']) . "'>" . $row['name'] . "</option>";
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
                $options .= "<option value = '" . $val . "'>" . date('l - M d, Y', strtotime($val)) . "</option>";
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
                    $cartname = hash('md5', $_SERVER['REMOTE_PORT']);
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
                    $data['success'] = true;
                    $data['data'] = 'Flower have been added to cart!';
                } else {
                    $data['success'] = false;
                    $data['error'] = 'Something went wrong pelase try again!';
                }
            } else if ($action == 'remove') {
                $delete_cart_option = array(CURLOPT_PUT => true);
                $delete_cart_url = "https://www.floristone.com/api/rest/shoppingcart?sessionid=$cartname&productcode=$product&action=$action";
                $floristone = new Floristone();
                $delete_cart_output = $floristone->send_flower($delete_cart_url, $delete_cart_option);
                if (!isset($delete_cart_output->errors)) {
                    $data['success'] = true;
                    $data['data'] = 'Flower have been remove from cart!';
                } else {
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

    public function place_order() {
        $process_step = $this->input->post('process_step');
        $data = [];
        if ($process_step == 1) {
            if (empty($this->session->userdata('place_order'))) {
                $this->session->set_userdata('place_order', $this->input->post());
            } else {
                $this->session->set_userdata('place_order', $this->input->post());
            }
            $data['success'] = true;
            $data['data'] = 'Proceed';
        } else if ($process_step == 2) {
            $process_first_step_data = $this->session->userdata('place_order');
            $current_data = $this->input->post();
            $customer = json_encode(array(
                'name' => $current_data['c_fname'] . ' ' . $current_data['c_lname'],
                'address1' => $current_data['c_address1'],
                'address2' => $current_data['c_address2'],
                'zipcode' => $current_data['c_zipcode'],
                'city' => $current_data['c_city'],
                'state' => $current_data['c_state'],
                'country' => $current_data['c_country'],
                'phone' => $current_data['c_phone'],
                'email' => $current_data['c_email'],
                'ip' => $_SERVER['REMOTE_ADDR']
            ));
            $ccinfo = json_encode(array(
                'type' => strtolower($current_data['c_card']),
                'ccnum' => $current_data['c_cardnumber'],
                'cvv2' => $current_data['c_code'],
                'expmonth' => $current_data['c_month'],
                'expyear' => $current_data['c_year']
            ));
            $products = array();
            $ordertotal = '';
            $order_data = json_decode($this->get_order_total('recepient'));
//            var_dump($order_data);
            if ($order_data->success == true) {
                $final_order_data = json_decode($order_data->data);
                $ordertotal = $final_order_data->order_total;
                $products = $final_order_data->product;
            }
            $api_order_data = array('products' => $products, 'customer' => $customer, 'ccinfo' => $ccinfo, 'ordertotal' => $ordertotal);
            if (isset($_POST['substitute'])) {
                $api_order_data['allowsubstitutions'] = 1;
            }
            $api_order_floristone = new Floristone();
            $api_order_url = "https://www.floristone.com/api/rest/flowershop/placeorder";
            $api_order_option = array(CURLOPT_POST => true, CURLOPT_POSTFIELDS => $api_order_data);
            $api_order_output = $api_order_floristone->send_flower($api_order_url, $api_order_option);
            if (!isset($api_order_output->errors)) {
                $data['success'] = true;
                $data['order_no'] = $api_order_output->ORDERNO;
                $delete_cart_floristone = new Floristone();
                $cart = $this->session->userdata('cart_id');
                $delete_cart_url = "https://www.floristone.com/api/rest/shoppingcart?sessionid=$cart";
                $delete_cart_option = array(CURLOPT_CUSTOMREQUEST => "DELETE");
                $delete_cart_output = $delete_cart_floristone->send_flower($delete_cart_url, $delete_cart_option);
                $this->session->unset_userdata('cart_id');
            } else {
                $data['success'] = false;
                $data['error'] = 'Something went wrong Your order is not placed please check your data is correct!';
            }
        } else {
            $data['success'] = false;
            $data['error'] = 'Invalid request, Please try again!';
        }
        echo json_encode($data);
        exit;
    }

    public function get_order_total($recipient = null) {
        $data = [];
        $floristone = new Floristone();
        $cartname = $this->session->userdata('cart_id');
        $url = "https://www.floristone.com/api/rest/shoppingcart?sessionid=$cartname";
        $output = $floristone->send_flower($url);
        $products = array();
        $final_products = array();
        $cart_item = [];
        $zipcode = '';
        if (!empty($this->session->userdata('place_order'))) {
            $zipcode = $this->session->userdata('place_order')['r_zipcode'];
        }
        if (isset($output->products) && !empty($output->products)) {
            if ($recipient == 'recepient') {
                foreach ($output->products as $key => $value) {
                    $code = $value->CODE;
                    $cart_floristone = new Floristone();
                    $cart_url = "https://www.floristone.com/api/rest/flowershop/getproducts?code=$code";
                    $cart_output = $cart_floristone->send_flower($cart_url);
                    if (!isset($cart_output->errors)) {
                        $products [] = array('code' => $code,
                            'price' => $cart_output->PRODUCTS[0]->PRICE,
                            "recipient" => array("zipcode" => $zipcode)
                        );
                        $final_products [] = array('code' => $code,
                            'price' => $cart_output->PRODUCTS[0]->PRICE,
                            'deliverydate' => date('Y-m-d', strtotime($this->session->userdata('place_order')['r_d_date'])),
                            'cardmessage' => $this->session->userdata('place_order')['r_card_msg'],
                            'specialinstructions' => $this->session->userdata('place_order')['r_zipcode'],
                            'recipient' => array(
                                'name' => $this->session->userdata('place_order')['r_name'],
                                'institution' => $this->session->userdata('place_order')['r_institute'],
                                'address1' => $this->session->userdata('place_order')['r_address1'],
                                'address2' => $this->session->userdata('place_order')['r_address2'],
                                'city' => $this->session->userdata('place_order')['r_city'],
                                'state' => $this->session->userdata('place_order')['r_state'],
                                'country' => $this->session->userdata('place_order')['r_country'],
                                'phone' => $this->session->userdata('place_order')['r_phone'],
                                'zipcode' => $zipcode
                            )
                        );
                    }
                }
            } else {
                foreach ($output->products as $key => $value) {
                    $code = $value->CODE;
                    $cart_floristone = new Floristone();
                    $cart_url = "https://www.floristone.com/api/rest/flowershop/getproducts?code=$code";
                    $cart_output = $cart_floristone->send_flower($cart_url);
                    if (!isset($cart_output->errors)) {
                        $products [] = array('code' => $code,
                            'price' => $cart_output->PRODUCTS[0]->PRICE,
                            "recipient" => array("zipcode" => $zipcode)
                        );
                    }
                }
            }
        }
        if ($recipient == 'recepient') {
            if (!empty($products)) {
                $total_floristone = new Floristone();
                $total_url = "https://www.floristone.com/api/rest/flowershop/gettotal?products=" . json_encode($products);
                $total_output = $total_floristone->send_flower($total_url);
                if (!isset($total_output->errors)) {
                    $data['success'] = true;
                    $data['data'] = json_encode(array('order_total' => $total_output->ORDERTOTAL, 'product' => json_encode($final_products)));
                } else {
                    $data['success'] = false;
                    $data['error'] = 'Something went wrong pelase try again!';
                }
            } else {
                $data['success'] = false;
                $data['error'] = 'No Products available.';
            }
        } else {
            if (!empty($products)) {
                $total_floristone = new Floristone();
                $total_url = "https://www.floristone.com/api/rest/flowershop/gettotal?products=" . json_encode($products);
                $total_output = $total_floristone->send_flower($total_url);
                if (!isset($total_output->errors)) {
                    $data['success'] = true;
                    $data['data'] = json_encode($total_output, JSON_FORCE_OBJECT);
                } else {
                    $data['success'] = false;
                    $data['error'] = 'Something went wrong pelase try again!';
                }
            } else {
                $data['success'] = false;
                $data['error'] = 'No Products available.';
            }
        }
        if ($recipient == 'recepient') {
            return json_encode($data);
//            exit;
        }
        echo json_encode($data);
        exit;
    }

    public function get_order_details($order_no = null) {
        if (!empty($order_no) && $order_no != null) {
            $data = [];
            $floristone = new Floristone();
            $url = "https://www.floristone.com/api/rest/flowershop/getorderinfo?orderno=$order_no";
            $output = $floristone->send_flower($url);
            if (!isset($output->errors)) {
//                var_dump($output);
                $data['order_data'] = $output;
            }
            $data['title'] = 'Order Details';
            $data['breadcrumb'] = ['title' => 'Order Details', 'links' => [['link' => site_url(), 'title' => 'Home'], ['link' => site_url('flowers'), 'title' => 'Flowers']]];
            $this->template->load('default', 'flowers/order_details', $data);
        } else {
            custom_show_404();
        }
    }

}
