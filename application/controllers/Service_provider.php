<?php

/**
 * Service Provider Controller
 * Manage profile related functions
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_provider extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('providers_model');
    }

    /**
     * Display login page for login
     */
    public function index() {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }

        $service_categories = $this->providers_model->sql_select(TBL_SERVICE_CATEGORIES, '*', ['where' => ['is_delete' => 0]]);
        $services = $this->providers_model->get_providers('result', $this->input->get());
//        p(qry());

        $data['service_categories'] = $service_categories;
        $data['services'] = $services;
        $data['title'] = 'Services Provider Directory';
        $data['breadcrumb'] = ['title' => 'Services Provider Directory', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'service_provider/index', $data);
    }

    /**
     * Display service provider details
     */
    public function view($slug) {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }

         if (isset($slug) && !empty($slug)) {
            $service_categories = $this->providers_model->sql_select(TBL_SERVICE_CATEGORIES, '*', ['where' => ['is_delete' => 0]]);
            $data['service_categories'] = $service_categories;
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS . ' sp', 'sp.*,sc.name as category_name,c.name as city_name,s.name as state_name', ['where' => array('sp.slug' => $slug, 'sp.is_delete' => 0)], ['single' => true, 'join' => [array('table' => TBL_SERVICE_CATEGORIES . ' sc', 'condition' => 'sc.id=sp.service_category_id AND sc.is_delete=0'), array('table' => TBL_STATE . ' s', 'condition' => 's.id=sp.state'), array('table' => TBL_CITY . ' c', 'condition' => 'c.id=sp.city')]]);
            if (!empty($provider_data)) {
                $data['provider_data'] = $provider_data;
            } else {
                custom_show_404();
            }
            $data['title'] = 'Services Provider Directory';
            $data['breadcrumb'] = ['title' => 'Services Provider Directory', 'links' => [['link' => site_url(), 'title' => 'Home']]];
            $this->template->load('default', 'service_provider/details', $data);
        } else {
            custom_show_404();
        }
    }
    
    /**
     * Add a new service provider directory listing.
     *
     */
    public function add($id = null) {
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($provider_data)) {
                $cities = $this->providers_model->sql_select(TBL_CITY . ' c', 'c.*', ['where' => array('c.state_id' => $provider_data['state'])]);
                $this->data['cities'] = $cities;
                $this->data['provider_data'] = $provider_data;
                $this->data['title'] = 'Remember Always Admin | Service Providers';
                $this->data['heading'] = 'Edit Service Provider';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Service Providers';
            $this->data['heading'] = 'Add Service Provider';
        }

        $states = $this->providers_model->sql_select(TBL_STATE . ' s', 's.*', ['where' => array('c.id' => 231)], ['join' => [array('table' => TBL_COUNTRY . ' c', 'condition' => 'c.id=s.country_id')]]);
        $this->data['states'] = $states;
        $service_categories = $this->providers_model->sql_select(TBL_SERVICE_CATEGORIES, null, ['where' => array('is_delete' => 0)]);
        $this->data['service_categories'] = $service_categories;
        if ($this->input->method() == 'post') {
            $cities = $this->providers_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => base64_decode($this->input->post('state')))]);
            if (!empty($cities)) {
                $this->data['cities'] = $cities;
            }
        }
        $this->form_validation->set_rules('service_category', 'Service Category', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('street1', 'Street Address 1', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('website', 'Website Url', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
            p($_FILES);
            p($this->input->post(),1);
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
                'service_category_id' => trim(htmlentities($this->input->post('service_category'))),
                'name' => trim(htmlentities($this->input->post('name'))),
                'description' => $this->input->post('description'),
                'location' => $this->input->post('location'),
                'latitute' => $this->input->post('latitute'),
                'longitute' => $this->input->post('longitute'),
                'street1' => trim($this->input->post('street1')),
                'city' => base64_decode(trim($this->input->post('city'))),
                'state' => base64_decode(trim($this->input->post('state'))),
                'phone_number' => trim($this->input->post('phone')),
                'website_url' => trim($this->input->post('website')),
            ];
            if (!empty($this->input->post('street2'))) {
                $dataArr['street2'] = $this->input->post('street2');
            }
            if (!empty($this->input->post('zipcode'))) {
                $dataArr['zipcode'] = $this->input->post('zipcode');
            }
            if ($_FILES['image']['name'] != '') {
                $image_data = upload_image('image', PROVIDER_IMAGES);
                if (is_array($image_data)) {
                    $flag = 1;
                    $data['profile_image_validation'] = $image_data['errors'];
                } else {
                    if (is_numeric($id)) {
                        if (!empty($provider_data)) {
                            unlink(PROVIDER_IMAGES . $provider_data['image']);
                        }
                    }
                    $provider_image = $image_data;
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
//            p($dataArr, 1);
            if (is_numeric($id)) {
                $dataArr['modified_at'] = date('Y-m-d H:i:s');
                $this->providers_model->common_insert_update('update', TBL_SERVICE_PROVIDERS, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Service Provider details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->providers_model->common_insert_update('insert', TBL_SERVICE_PROVIDERS, $dataArr);
                $this->session->set_flashdata('success', 'Service Provider listing has been added successfully.');
            }
//            redirect('admin/providers');
        }
        $this->template->load('default', 'service_provider/manage', $this->data);
    }
}
