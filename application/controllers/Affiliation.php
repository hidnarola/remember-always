<?php

/**
 * Service Provider Controller
 * Manage profile related functions
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Affiliation extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('affiliation_model');
    }

    /**
     * Display 
     */
    public function index() {
        
    }

    /**
     * Add a new affiliation.
     *
     */
    public function add($id = null) {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }
        
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $affiliation = $this->affiliation_model->sql_select(TBL_AFFILIATIONS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($affiliation)) {
                $data['affiliation'] = $affiliation;
                $states = $this->affiliation_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => $affiliation['country'])]);
                if (!empty($states)) {
                    $data['states'] = $states;
                }
                $cities = $this->affiliation_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => $affiliation['state'])]);
                if (!empty($cities)) {
                    $data['cities'] = $cities;
                }
                
            } else {
                custom_show_404();
            }
        } 
        $countries = $this->affiliation_model->sql_select(TBL_COUNTRY . ' c');
        $data['countries'] = $countries;
        $categories = $this->affiliation_model->sql_select(TBL_AFFILIATIONS_CATEGORY, null, ['where' => array('is_delete' => 0)]);
        $data['categories'] = $categories;
        if ($this->input->method() == 'post') {
            $states = $this->affiliation_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => base64_decode($this->input->post('country')))]);
            if (!empty($states)) {
                $data['states'] = $states;
            }
            $cities = $this->affiliation_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => base64_decode($this->input->post('state')))]);
            if (!empty($cities)) {
                $data['cities'] = $cities;
            }
        }
        $this->form_validation->set_rules('category', 'Affiliation Category', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
        } else {
            $dataArr = ['user_id' => $this->user_id,
                'category_id' => base64_decode(trim($this->input->post('category'))),
                'name' => trim(htmlentities($this->input->post('name'))),
                'description' => $this->input->post('description'),
                'country' => base64_decode(trim($this->input->post('country'))),
                'state' => base64_decode(trim($this->input->post('state'))),
                'city' => base64_decode(trim($this->input->post('city')))];
            if ($_FILES['image']['name'] != '') {
                $image_data = upload_image('image', AFFILIATION_IMAGE);
                if (is_array($image_data)) {
                    $flag = 1;
                    $data['image_validation'] = $image_data['errors'];
                } else {
                    if (is_numeric($id)) {
                        if (!empty($affiliation)) {
                            unlink(AFFILIATION_IMAGE . $affiliation['image']);
                        }
                    }
                    $provider_image = $image_data;
                    $dataArr['image'] = $provider_image;
                }
            } else {
                if (is_numeric($id)) {
                    if (!empty($affiliation)) {
                        $provider_image = $provider_data['image'];
                        $dataArr['image'] = $provider_data['image'];
                    }
                }
            }
//            p($dataArr, 1);
            if (is_numeric($id)) {
                $dataArr['updated_at'] = date('Y-m-d H:i:s');
                $this->affiliation_model->common_insert_update('update', TBL_AFFILIATIONS, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Affiliation details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->affiliation_model->common_insert_update('insert', TBL_AFFILIATIONS, $dataArr);
                $this->session->set_flashdata('success', 'Affiliation has been added.');
            }
            redirect('affiliation/add');
        }
        $data['title'] = 'Affiliation';
        $data['breadcrumb'] = ['title' => 'Add Affiliation', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'affiliation/manage', $data);
    }
    
    /**
     * Get cities  or state based on type passed as data.
     * */
    public function get_data() {
        $id = base64_decode($this->input->post('id'));
        $type = $this->input->post('type');
        $options = '';
        if ($type == 'city') {
            $options = '<option value="">-- Select City --</option>';
            if (is_numeric($id)) {
                $data = $this->affiliation_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => trim($id))]);
                if (!empty($data)) {
                    foreach ($data as $row) {
                        $options .= "<option value = '" . base64_encode($row['id']) . "'>" . $row['name'] . "</option>";
                    }
                }
            }
        } else if ($type == 'state') {
            $options = '<option value="">-- Select State --</option>';
            if (is_numeric($id)) {
                $data = $this->affiliation_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => trim($id))]);
                if (!empty($data)) {
                    foreach ($data as $row) {
                        $options .= "<option value = '" . base64_encode($row['id']) . "'>" . $row['name'] . "</option>";
                    }
                }
            }
        }
        echo $options;
    }
}
