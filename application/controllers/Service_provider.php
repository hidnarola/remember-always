<?php

/**
 * Service Provider Controller
 * Manage service provider related operations
 * @author AKK 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_provider extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('providers_model');
    }

    /**
     * Display listing of all service providers
     */
    public function index($start = 0) {
        $page_config = front_pagination();
        $page_config['per_page'] = 10;
        $page_config['base_url'] = site_url('service_provider');
        $display_msg = '';
        $display_msg_first = '';
        if ($this->input->get('keyword') != '') {
            $display_msg_first = 'Showing results';

            $display_msg = ' for <b>' . $this->input->get('keyword') . '</b>';
            $page_config['suffix'] = '?keyword=' . $this->input->get('keyword') . '&location=' . $this->input->get('location') . '&lat=' . $this->input->get('lat') . '&long=' . $this->input->get('long');

            if ($this->input->get('location') != '') {
                $display_msg .= ' near <span>' . $this->input->get('location') . '</span>';
                $page_config['suffix'] .= '&location=' . $this->input->get('location') . '&lat=' . $this->input->get('lat') . '&long=' . $this->input->get('long');
            }

            $page_config['first_url'] = site_url('search') . '?type=' . $this->input->get('type') . '&keyword=' . $this->input->get('keyword') . '&location=' . $this->input->get('location');
        } elseif ($this->input->get('location') != '') {
            $display_msg_first = 'Showing results';

            $page_config['suffix'] = '?location=' . $this->input->get('location') . '&lat=' . $this->input->get('lat') . '&long=' . $this->input->get('long');
            $display_msg .= ' near <span>' . $this->input->get('location') . '</span>';
            $page_config['first_url'] = site_url('service_provider') . '?location=' . $this->input->get('location') . '&lat=' . $this->input->get('lat') . '&long=' . $this->input->get('long');
        }

        $services = $this->get_yelp_businesses($start);
        $data['services'] = [];
        if (!empty($services) && !isset($services['error'])) {
            $total_count = ($services['total'] > 1000) ? 1000 : $services['total'];
            $page_config['total_rows'] = $total_count;
            $data['services'] = $services['businesses'];
        } else {
            $page_config['total_rows'] = 0;
        }
        $this->pagination->initialize($page_config);

        $data['links'] = $this->pagination->create_links();
        $data['total'] = $total_count;
        if ($total_count == 0) {
            $final_msg = 'No Results' . $display_msg;
        } else {
            $final_msg = $display_msg_first . $display_msg;
        }
        $data['display_msg'] = $final_msg;
        $data['title'] = 'Remember Always | Service Providers Directory';
        $data['breadcrumb'] = ['title' => 'Service Providers Directory', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'service_provider/index', $data);
    }

    public function test() {
        $this->config->load('yelp');

        $apiKey = $this->config->item('yelp_api');
        $api_host = $this->config->item('api_host');
        $search_path = $this->config->item('search_path');
        $business_path = $this->config->item('business_path');
//        $url_params = ['limit' => 10, 'offset' => $start, 'categories' => 'funeralservices'];
        $url_params = ['limit' => 10];
        $url_params['categories'] = 'funeralservices,cremationservices,mortuaryservices,flowers,florists,synagogues,'
                . 'churches,catering,eventservices,religiousitems,officiants,organic_stores,organdonorservices,donationcenter,religiousorgs,mosques,buddhist_temples,hindu_temples,taoisttemples';

        $url = $api_host . $search_path;
        if ($this->input->get('keyword') != '') {
            $url_params['term'] = $this->input->get('keyword');
        }
        if ($this->input->get('lat') != '' && $this->input->get('long') != '') {
            $url_params['latitude'] = $this->input->get('lat');
            $url_params['longitude'] = $this->input->get('long');
        } else {
            $url_params['location'] = 'US';
        }
        $url .= "?" . http_build_query($url_params);
        echo $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization:Bearer ' . $apiKey]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $arr = json_decode($result, true);
        if (!empty($arr)) {
            p($arr, 1);
        } else {
            return [];
        }
    }

    /**
     * Get yelp businesses
     * @param int $start
     * @athur KU
     */
    public function get_yelp_businesses($start) {
        $this->config->load('yelp');

        $apiKey = $this->config->item('yelp_api');
        $api_host = $this->config->item('api_host');
        $search_path = $this->config->item('search_path');
        $business_path = $this->config->item('business_path');
//        $url_params = ['limit' => 10, 'offset' => $start, 'categories' => 'funeralservices'];
        $url_params = ['limit' => 10, 'offset' => $start];
        $url_params['categories'] = 'funeralservices,cremationservices,mortuaryservices,flowers,florists,synagogues,'
                . 'churches,catering,eventservices,religiousitems,officiants,organic_stores,organdonorservices,donationcenter,religiousorgs,mosques,buddhist_temples,hindu_temples,taoisttemples';

        $url = $api_host . $search_path;
        if ($this->input->get('keyword') != '') {
            $url_params['term'] = $this->input->get('keyword');
        }
        if ($this->input->get('lat') != '' && $this->input->get('long') != '') {
            $url_params['latitude'] = $this->input->get('lat');
            $url_params['longitude'] = $this->input->get('long');
        } else {
            $url_params['location'] = 'US';
        }
        $url .= "?" . http_build_query($url_params);
//        echo $url; 
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization:Bearer ' . $apiKey]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $arr = json_decode($result, true);
        if (!empty($arr)) {
            return $arr;
        } else {
            return [];
        }
//        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//        curl_close($ch);
    }

    /**
     * Display listing of all service providers
     */
    public function index_old() {
        $service_categories = $this->providers_model->sql_select(TBL_SERVICE_CATEGORIES, '*', ['where' => ['is_delete' => 0]]);
        $data['service_categories'] = $service_categories;
        $data['services'] = $this->load_providers(0, true);

        $data['title'] = 'Remember Always | Service Providers Directory';
        $data['breadcrumb'] = ['title' => 'Service Providers Directory', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'service_provider/index_old', $data);
    }

    /**
     * Load service providers 
     */
    public function load_providers($start, $static = false) {
        $offset = 5;
        if ($this->input->get('category') == 'yelp') {
            $services = $this->get_yelp_businesses($start);
        } else {
            $services = $this->providers_model->get_providers('result', $this->input->get(), $start, $offset);
        }
        if ($static === true) {
            return $services;
        } else {
            if (!empty($services)) {
                echo json_encode($services);
            } else {
                echo '';
            }
        }
    }

    /**
     * Display service provider details
     */
    public function view($slug) {
        if (isset($slug) && !empty($slug)) {
            $service_categories = $this->providers_model->sql_select(TBL_SERVICE_CATEGORIES, '*', ['where' => ['is_delete' => 0]]);
            $data['service_categories'] = $service_categories;
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS . ' sp', 'sp.*,sc.name as category_name,c.name as city_name,s.name as state_name,cn.name as country_name', ['where' => array('sp.slug' => $slug, 'sp.is_delete' => 0)], ['single' => true,
                'join' => [array('table' => TBL_SERVICE_CATEGORIES . ' sc', 'condition' => 'sc.id=sp.service_category_id AND sc.is_delete=0'),
                    array('table' => TBL_COUNTRY . ' cn', 'condition' => 'cn.id=sp.country'),
                    array('table' => TBL_STATE . ' s', 'condition' => 's.id=sp.state'),
                    array('table' => TBL_CITY . ' c', 'condition' => 'c.id=sp.city')]]);
            if (!empty($provider_data)) {
                $data['provider_data'] = $provider_data;
            } else {
                custom_show_404();
            }
            $data['title'] = 'Service Providers Directory';
            $data['breadcrumb'] = ['title' => 'Post Service Provider Listing', 'links' => [['link' => site_url(), 'title' => 'Home'], ['link' => site_url('service_provider'), 'title' => 'Service Provider Listing']]];
            $this->template->load('default', 'service_provider/details', $data);
        } else {
            custom_show_404();
        }
    }

    /**
     * Add a new service provider directory listing.
     * @param int $id
     */
    public function add($id = null) {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }
        $data['countries'] = $this->providers_model->sql_select(TBL_COUNTRY, 'id,name');
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($provider_data)) {
                $data['states'] = $this->providers_model->sql_select(TBL_STATE, 'id,name', ['where' => array('country_id' => $provider_data['country'])]);
                $data['cities'] = $this->providers_model->sql_select(TBL_CITY, 'id,name', ['where' => array('state_id' => $provider_data['state'])]);
                $data['provider_data'] = $provider_data;
            } else {
                custom_show_404();
            }
        }


        $service_categories = $this->providers_model->sql_select(TBL_SERVICE_CATEGORIES, null, ['where' => array('is_delete' => 0)]);
        $data['service_categories'] = $service_categories;
        if ($this->input->method() == 'post') {
            $cities = $this->providers_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => base64_decode($this->input->post('state')))]);
            if (!empty($cities)) {
                $data['cities'] = $cities;
            }
        }
        $this->form_validation->set_rules('category', 'Service Category', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('street1', 'Street Address 1', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('state_hidden', 'State', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('website', 'Website Url', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
        } else {
            if (!empty(trim(htmlentities($this->input->post('name'))))) {
                $slug = trim(htmlentities($this->input->post('name')));
            }
            if (isset($provider_data) && !empty($provider_data)) {
                $slug = slug($slug, TBL_SERVICE_PROVIDERS, trim($id));
            } else {
                $slug = slug($slug, TBL_SERVICE_PROVIDERS);
            }
            $flag = 0;
            $dataArr = [
                'slug' => $slug,
                'service_category_id' => base64_decode(trim($this->input->post('category'))),
                'user_id' => $this->user_id,
                'name' => trim(htmlentities($this->input->post('name'))),
                'description' => $this->input->post('description'),
                'location' => $this->input->post('location'),
                'latitute' => $this->input->post('latitute'),
                'longitute' => $this->input->post('longitute'),
                'street1' => trim($this->input->post('street1')),
                'city' => base64_decode(trim($this->input->post('city'))),
                'state' => base64_decode(trim($this->input->post('state_hidden'))),
                'country' => base64_decode(trim($this->input->post('country'))),
                'phone_number' => trim($this->input->post('phone_number')),
                'website_url' => trim($this->input->post('website')),
            ];
            if (!empty($this->input->post('street2'))) {
                $dataArr['street2'] = $this->input->post('street2');
            }
            if (!empty($this->input->post('zipcode'))) {
                $dataArr['zipcode'] = $this->input->post('zipcode');
            }
            if ($_FILES['image']['name'] != '') {
                $directory = 'user_' . $this->user_id;
                if (!file_exists(PROVIDER_IMAGES . $directory)) {
                    mkdir(PROVIDER_IMAGES . $directory);
                }
                $image_data = upload_image('image', PROVIDER_IMAGES . $directory);
                if (is_array($image_data)) {
                    $flag = 1;
                    $data['provider_validation'] = $image_data['errors'];
                } else {
                    if (is_numeric($id)) {
                        if (!empty($provider_data)) {
                            unlink(PROVIDER_IMAGES . $provider_data['image']);
                        }
                    }
                    $provider_image = $directory . '/' . $image_data;
                    $dataArr['image'] = $provider_image;
                }
            } else {
                if (is_numeric($id)) {
                    if (!empty($provider_data)) {
                        $provider_image = $provider_data['image'];
                        $dataArr['image'] = $provider_data['image'];
                    }
                }
            }
            if (is_numeric($id)) {
                $dataArr['updated_at'] = date('Y-m-d H:i:s');
                $this->providers_model->common_insert_update('update', TBL_SERVICE_PROVIDERS, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Service Provider details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $dataArr['is_active'] = 0;
                $id = $this->providers_model->common_insert_update('insert', TBL_SERVICE_PROVIDERS, $dataArr);
                $this->session->set_flashdata('success', 'Service Provider listing has been added successfully. It will be visible once approved by Administrator');
            }
            redirect('service_provider');
        }
        $data['title'] = 'Post Service Provider Listing';
        $data['breadcrumb'] = ['title' => 'Post Service Provider Listing', 'links' => [['link' => site_url(), 'title' => 'Home'], ['link' => site_url('service_provider'), 'title' => 'Service Provider Listing']]];

        $this->template->load('default', 'service_provider/manage', $data);
    }

}
