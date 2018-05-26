<?php

/**
 * Affiliation Controller
 * Manage affiliation related functions
 * @author AKK 
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
        $affiliation_categories = $this->affiliation_model->sql_select(TBL_AFFILIATIONS_CATEGORY, '*', ['where' => ['is_delete' => 0]]);

        $data['affiliation_categories'] = $affiliation_categories;
        $data['affiliations'] = $this->load_affiliations(0, true);
        if (!empty($this->input->get())) {
            $data['data'] = $this->input->get();
        }
        $data['title'] = 'Affiliation';

        $data['breadcrumb'] = ['title' => 'Affiliation', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'affiliation/index', $data);
    }

    /**
     * Display affiliations
     */
    public function load_affiliations($start, $static = false) {
        $offset = 5;
        $affiliations = $this->affiliation_model->get_all_affiliation('result', $this->input->get(), $start, $offset);
        if ($static === true) {
            return $affiliations;
        } else {
            if (!empty($affiliations)) {
                echo json_encode($affiliations);
            } else {
                echo '';
            }
        }
    }

    /**
     * Add a new affiliation.
     *
     */
    public function add($slug = null) {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }
        $affiliation_id = null;
        $data['breadcrumb'] = ['title' => 'Add Affiliation', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        if (!empty($slug)) {
            $affiliation = $this->affiliation_model->sql_select(TBL_AFFILIATIONS, null, ['where' => array('slug' => trim($slug), 'is_delete' => 0)], ['single' => true]);
            if (!empty($affiliation)) {
                $affiliation_id = $affiliation['id'];
                $data['affiliation'] = $affiliation;
                $states = $this->affiliation_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => $affiliation['country'])]);
                if (!empty($states)) {
                    $data['states'] = $states;
                }
                $cities = $this->affiliation_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => $affiliation['state'])]);
                if (!empty($cities)) {
                    $data['cities'] = $cities;
                }
                $data['breadcrumb'] = ['title' => 'Edit Affiliation', 'links' => [['link' => site_url(), 'title' => 'Home']]];
            } else {
                custom_show_404();
            }
        }
        $data['countries'] = $this->users_model->customQuery('SELECT id,name FROM ' . TBL_COUNTRY . ' order by id=231 DESC');
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
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
        } else {
            if (!empty(trim($this->input->post('name')))) {
                $slug = trim($this->input->post('name'));
            }
            if (isset($affiliation) && !empty($affiliation)) {
                $slug = slug($slug, TBL_AFFILIATIONS, trim($affiliation['id']));
            } else {
                $slug = slug($slug, TBL_AFFILIATIONS);
            }

            $city = $this->input->post('city');
            $state = base64_decode($this->input->post('state'));
            //-- Check city is available in db if not then insert with new record
            $city_data = $this->users_model->sql_select(TBL_CITY, 'id,name', ['where' => ['name' => $city, 'state_id' => $state]], ['single' => true]);
            if (empty($city_data)) {
                $city_arr = ['name' => $city, 'state_id' => $state];
                $city_id = $this->users_model->common_insert_update('insert', TBL_CITY, $city_arr);
            } else {
                $city_id = $city_data['id'];
            }

            $dataArr = ['user_id' => $this->user_id,
                'slug' => $slug,
                'category_id' => base64_decode(trim($this->input->post('category'))),
                'name' => trim(htmlentities($this->input->post('name'))),
                'description' => $this->input->post('description'),
                'country' => base64_decode(trim($this->input->post('country'))),
                'state' => base64_decode(trim($this->input->post('state'))),
                'city' => $city_id];

            if ($_FILES['image']['name'] != '') {
                $image_data = upload_image('image', AFFILIATION_IMAGE);
                if (is_array($image_data)) {
                    $flag = 1;
                    $data['image_validation'] = $image_data['errors'];
                } else {
                    if (!empty($slug)) {
                        if (!empty($affiliation)) {
                            unlink(AFFILIATION_IMAGE . $affiliation['image']);
                        }
                    }
                    $provider_image = $image_data;
                    $dataArr['image'] = $provider_image;
                }
            } else {
                if (!empty($slug)) {
                    if (!empty($affiliation)) {
                        $provider_image = $affiliation['image'];
                        $dataArr['image'] = $affiliation['image'];
                    }
                }
            }
            if (!empty($affiliation_id)) {
                $dataArr['updated_at'] = date('Y-m-d H:i:s');
                $this->affiliation_model->common_insert_update('update', TBL_AFFILIATIONS, $dataArr, ['id' => $affiliation['id']]);
                $this->session->set_flashdata('success', 'Affiliation details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $dataArr['is_approved'] = 0;
                $id = $this->affiliation_model->common_insert_update('insert', TBL_AFFILIATIONS, $dataArr);
                $this->session->set_flashdata('success', 'Affiliation has been added successfully. It will be visible once approved by Administrator');
            }
            redirect('dashboard/affiliations');
        }
        $data['title'] = 'Affiliation';
        $this->template->load('default', 'affiliation/manage', $data);
    }

    /**
     * Edit a affiliation.
     *
     */
    public function edit($slug) {
        $this->add($slug);
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
                        $options .= "<option value = '" . $row['name'] . "'>" . $row['name'] . "</option>";
                    }
                }
            }
        } else if ($type == 'state') {
            $options = '<option value="">-- Select State --</option>';
            if (is_numeric($id)) {
                $data = $this->affiliation_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => trim($id))]);
                if (!empty($data)) {
                    foreach ($data as $row) {
                        $code = '';
                        if ($row['shortcode'] != '') {
                            $codes = explode('-', $row['shortcode']);
                            $code = ' (' . $codes[1] . ')';
                        }
                        $options .= "<option value = '" . base64_encode($row['id']) . "'>" . $row['name'] . $code . "</option>";
                    }
                }
            }
        }
        echo $options;
    }

    /**
     * View a Affiliation.
     *
     */
    public function view($slug) {
        if (isset($slug) && !empty($slug)) {
            $affiliation_data = $this->affiliation_model->sql_select(TBL_AFFILIATIONS . ' a', 'a.*,ac.name as category_name,co.name as country_name,c.name as city_name,s.name as state_name', ['where' => array('a.slug' => trim($slug), 'a.is_delete' => 0)], ['single' => true, 'join' => [array('table' => TBL_AFFILIATIONS_CATEGORY . ' ac', 'condition' => 'ac.id=a.category_id AND ac.is_delete=0'), array('table' => TBL_COUNTRY . ' co', 'condition' => 'co.id=a.country'), array('table' => TBL_STATE . ' s', 'condition' => 's.id=a.state'), array('table' => TBL_CITY . ' c', 'condition' => 'c.id=a.city')]]);
            if (!empty($affiliation_data)) {
                $profiles = $this->affiliation_model->sql_select(TBL_PROFILE_AFFILIATION . ' pa', 'pa.*,p.firstname,p.lastname,p.profile_image,p.slug', ['where' => array('pa.affiliation_id' => trim($affiliation_data['id']), 'is_published' => 1)], ['join' => [array('table' => TBL_PROFILES . ' p', 'condition' => 'p.id=pa.profile_id AND p.is_delete=0')]]);
                $data['profiles'] = $profiles;
                $data['affiliation'] = $affiliation_data;
                $data['title'] = 'Affiliations';
                $data['breadcrumb'] = ['title' => $affiliation_data['name'], 'links' => [['link' => site_url(), 'title' => 'Home'], ['link' => site_url('affiliation'), 'title' => 'Affiliations']]];
                $this->template->load('default', 'affiliation/details', $data);
            } else {
                custom_show_404();
            }
        } else {
            custom_show_404();
        }
    }

}
