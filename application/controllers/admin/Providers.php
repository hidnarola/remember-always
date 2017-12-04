<?php

/**
 * Providers Controller to manage service providers
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Providers extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/providers_model');
    }

    /**
     * Display listing of service provider
     */
    public function index() {

        $data['title'] = 'Remember Always Admin | Service Providers';
        $this->template->load('admin', 'admin/service_providers/index', $data);
    }

    /**
     * Get providers data for AJAX table
     * */
    public function get_providers() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->providers_model->get_providers('count');
        $final['redraw'] = 1;
        $providers = $this->providers_model->get_providers('result');
        $start = $this->input->get('start') + 1;
        foreach ($providers as $key => $val) {
            $providers[$key] = $val;
            $providers[$key]['sr_no'] = $start;
            $providers[$key]['created_at'] = date('d M Y', strtotime($val['created_at']));
            $start++;
        }

        $final['data'] = $providers;
        echo json_encode($final);
    }

    /**
     * Add a new service provider.
     *
     */
    public function add($id = null) {
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($provider_data)) {
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

        $service_categories = $this->providers_model->sql_select(TBL_SERVICE_CATEGORIES, null, ['where' => array('is_delete' => 0)]);
        $this->data['service_categories'] = $service_categories;

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
//            p($this->input->post(), 1);
            $flag = 0;
            $dataArr = [
                'service_category_id' => trim(htmlentities($this->input->post('service_category'))),
                'name' => trim(htmlentities($this->input->post('name'))),
                'description' => $this->input->post('description'),
                'latitute' => $this->input->post('latitute'),
                'longitute' => $this->input->post('longitute'),
                'street1' => trim($this->input->post('street1')),
                'city' => trim($this->input->post('city')),
                'state' => trim($this->input->post('state')),
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
                $this->session->set_flashdata('success', 'Service Provider details has been inserted successfully.');
            }
            redirect('admin/providers');
        }
        $this->template->load('admin', 'admin/service_providers/manage', $this->data);
    }
    
     /**
     * view a service provider .
     *
     */
    public function edit($id) {
        $this->add($id);
    }
    
    /**
     * Edit a Service Provider.
     *
     */
    public function view($id) {
         
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $this->data['title'] = 'Remember Always Admin | Service Providers';
            $this->data['heading'] = 'View Service Provider Details';
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS . ' sp', 'sp.*,sc.name as category_name', ['where' => array('sp.id' => trim($id), 'sp.is_delete' => 0)], ['single' => true, 'join' => [array('table' => TBL_SERVICE_CATEGORIES . ' sc', 'condition' => 'sc.id=sp.service_category_id AND sc.is_delete=0')]]);
//            p($provider_data);
            if (!empty($provider_data)) {
                $this->data['provider_data'] = $provider_data;
            } else {
                custom_show_404();
            }
            $this->template->load('admin', 'admin/service_providers/view', $this->data);
        } else {
            custom_show_404();
        }
    }
    
    /**
     * Delete service provider
     * @param int $id
     * */
    public function delete($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($provider_data)) {
                $update_array = array(
                    'is_delete' => 1,
                    'modified_at' => date('Y-m-d H:i:s'),
                );
                $this->providers_model->common_insert_update('update', TBL_SERVICE_PROVIDERS, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Service provider has been deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Unable to Service provider slider!');
            }
        }else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/providers');
    }
}
