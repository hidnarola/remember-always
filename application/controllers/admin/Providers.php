<?php

/**
 * Providers Controller to manage service providers
 * @author AKK 
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
                $this->data['states'] = $this->providers_model->sql_select(TBL_STATE, 'id,name', ['where' => array('country_id' => $provider_data['country'])]);
                $this->data['cities'] = $this->providers_model->sql_select(TBL_CITY, 'id,name', ['where' => array('state_id' => $provider_data['state'])]);
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

        $this->data['countries'] = $this->providers_model->sql_select(TBL_COUNTRY, 'id,name');

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
        $this->form_validation->set_rules('state_hidden', 'State', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('website', 'Website Url', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
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
                'service_category_id' => trim(htmlentities($this->input->post('service_category'))),
                'name' => trim(htmlentities($this->input->post('name'))),
                'description' => $this->input->post('description'),
                'location' => $this->input->post('location'),
                'latitute' => $this->input->post('latitute'),
                'longitute' => $this->input->post('longitute'),
                'street1' => trim($this->input->post('street1')),
                'city' => base64_decode(trim($this->input->post('city'))),
                'state' => base64_decode(trim($this->input->post('state_hidden'))),
                'country' => base64_decode(trim($this->input->post('country'))),
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
            if (is_numeric($id)) {
                $dataArr['updated_at'] = date('Y-m-d H:i:s');
                $this->providers_model->common_insert_update('update', TBL_SERVICE_PROVIDERS, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Service Provider details has been updated successfully.');
            } else {
                $dataArr['user_id'] = $this->user_id;
                $dataArr['is_active'] = 1;
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->providers_model->common_insert_update('insert', TBL_SERVICE_PROVIDERS, $dataArr);
                $this->session->set_flashdata('success', 'Service Provider details has been inserted successfully.');
            }
            redirect('admin/providers');
        }
        $this->template->load('admin', 'admin/service_providers/manage', $this->data);
    }

    /**
     * edit a service provider .
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
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS . ' sp', 'sp.*,sc.name as category_name,c.name as city_name,s.name as state_name', ['where' => array('sp.id' => trim($id), 'sp.is_delete' => 0)], ['single' => true, 'join' => [array('table' => TBL_SERVICE_CATEGORIES . ' sc', 'condition' => 'sc.id=sp.service_category_id AND sc.is_delete=0'), array('table' => TBL_STATE . ' s', 'condition' => 's.id=sp.state'), array('table' => TBL_CITY . ' c', 'condition' => 'c.id=sp.city')]]);
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
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->providers_model->common_insert_update('update', TBL_SERVICE_PROVIDERS, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Service provider has been deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Unable to Service provider slider!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/providers');
    }

    /**
     * Approve service provider added by user.
     * @param int $id
     * */
    public function action($type = '', $id = NULL) {
        $id = base64_decode($id);
        $action_type = $type;
        if (is_numeric($id)) {
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($provider_data)) {
                if ($action_type == 'approve') {
                    $update_array = array(
                        'is_active' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                } else if ($action_type == 'unapprove') {
                    $update_array = array(
                        'is_active' => 0,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                }
                $this->providers_model->common_insert_update('update', TBL_SERVICE_PROVIDERS, $update_array, ['id' => $id]);
                if ($action_type == 'approve') {
                    $this->session->set_flashdata('success', 'Service provider has been approved successfully!');
                } else if ($action_type == 'unapprove') {
                    $this->session->set_flashdata('success', 'Service provider has been unapproved successfully!');
                }
            } else {
                $this->session->set_flashdata('error', 'Unable to get Service provider!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/providers');
    }

    /**
     * Get cities based on state.
     * @param int $id
     * */
    public function get_city() {
        $id = base64_decode($this->input->post('stateid'));
        $options = '<option value="">-- Select City --</option>';
        if (is_numeric($id)) {
            $post_data = $this->providers_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => trim($id))]);
            if (!empty($post_data)) {
                foreach ($post_data as $row) {
                    $options .= "<option value = '" . base64_encode($row['id']) . "'>" . $row['name'] . "</option>";
                }
            }
        }
        echo $options;
    }

}
