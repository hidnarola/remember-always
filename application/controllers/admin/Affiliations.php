<?php

/**
 * Categories Controller for Affiliation provider categories
 * @author AKK 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Affiliations extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/affiliation_model');
    }

    /**
     * Display login page for login
     */
    public function index() {

        $this->data['title'] = 'Remember Always Admin | Affiliations';
        $this->template->load('admin', 'admin/affiliations/index', $this->data);
    }

    /**
     * Display login page for login
     */
    public function get_affiliation() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->affiliation_model->get_all_affiliation('count');
        $final['redraw'] = 1;
        $affiliation = $this->affiliation_model->get_all_affiliation('result');
        $start = $this->input->get('start') + 1;
        foreach ($affiliation as $key => $val) {
            $affiliation[$key] = $val;
            $affiliation[$key]['sr_no'] = $start;
            $affiliation[$key]['created_at'] = date('d M Y', strtotime($val['created_at']));
            $start++;
        }
        $final['data'] = $affiliation;
        echo json_encode($final);
    }

    /**
     * Add a new affiliation.
     *
     */
    public function add($id = null) {
        $uniqe_category_str = '';
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $affiliation = $this->affiliation_model->sql_select(TBL_AFFILIATIONS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($affiliation)) {
                $this->data['affiliation'] = $affiliation;
                $states = $this->affiliation_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => $affiliation['country'])]);
                if (!empty($states)) {
                    $this->data['states'] = $states;
                }
                $cities = $this->affiliation_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => $affiliation['state'])]);
                if (!empty($cities)) {
                    $this->data['cities'] = $cities;
                }
                $this->data['title'] = 'Remember Always Admin | Affiliation';
                $this->data['heading'] = 'Edit Affiliation';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Affiliation';
            $this->data['heading'] = 'Add Affiliation';
        }

        $this->data['countries'] = $this->users_model->customQuery('SELECT id,name FROM ' . TBL_COUNTRY . ' order by id=231 DESC');
        $categories = $this->affiliation_model->sql_select(TBL_AFFILIATIONS_CATEGORY, null, ['where' => array('is_delete' => 0)]);
        $this->data['categories'] = $categories;
        if ($this->input->method() == 'post') {
            $states = $this->affiliation_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => base64_decode($this->input->post('country')))]);
            if (!empty($states)) {
                $this->data['states'] = $states;
            }
            $cities = $this->affiliation_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => base64_decode($this->input->post('state')))]);
            if (!empty($cities)) {
                $this->data['cities'] = $cities;
            }
        }
        $this->form_validation->set_rules('category_id', 'Affiliation Category', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
            if (!empty(trim($this->input->post('name')))) {
                $slug = trim($this->input->post('name'));
            }
            if (isset($affiliation) && !empty($affiliation)) {
                $slug = slug($slug, TBL_AFFILIATIONS, trim($id));
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
                'category_id' => base64_decode(trim($this->input->post('category_id'))),
                'name' => trim(htmlentities($this->input->post('name'))),
                'description' => $this->input->post('description'),
                'country' => base64_decode(trim($this->input->post('country'))),
                'state' => base64_decode(trim($this->input->post('state'))),
                'city' => $city_id,
            ];
            if ($_FILES['image']['name'] != '') {
                $image_data = upload_image('image', AFFILIATION_IMAGE);
                if (is_array($image_data)) {
                    $flag = 1;
                    $data['profile_image_validation'] = $image_data['errors'];
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
                        $dataArr['image'] = $affiliation['image'];
                    }
                }
            }
            if (is_numeric($id)) {
                $dataArr['updated_at'] = date('Y-m-d H:i:s');
                $this->affiliation_model->common_insert_update('update', TBL_AFFILIATIONS, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Affiliation details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $dataArr['is_approved'] = 1;
                $id = $this->affiliation_model->common_insert_update('insert', TBL_AFFILIATIONS, $dataArr);
                $this->session->set_flashdata('success', 'Affiliation has been inserted successfully.');
            }
            redirect('admin/affiliations');
        }
        $this->template->load('admin', 'admin/affiliations/manage', $this->data);
    }

    /**
     * Edit a Affiliation.
     *
     */
    public function edit($id) {
        $this->add($id);
    }

    /**
     * View a Affiliation.
     *
     */
    public function view($id) {

        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $this->data['title'] = 'Remember Always Admin | Affiliations';
            $this->data['heading'] = 'View Affiliation Details';
            $affiliation_data = $this->affiliation_model->sql_select(TBL_AFFILIATIONS . ' a', 'a.*,ac.name as category_name,co.name as country_name,c.name as city_name,s.name as state_name', ['where' => array('a.id' => trim($id), 'a.is_delete' => 0)], ['single' => true, 'join' => [array('table' => TBL_AFFILIATIONS_CATEGORY . ' ac', 'condition' => 'ac.id=a.category_id AND ac.is_delete=0'), array('table' => TBL_COUNTRY . ' co', 'condition' => 'co.id=a.country'), array('table' => TBL_STATE . ' s', 'condition' => 's.id=a.state'), array('table' => TBL_CITY . ' c', 'condition' => 'c.id=a.city')]]);
            if (!empty($affiliation_data)) {
                $this->data['affiliation_data'] = $affiliation_data;
            } else {
                custom_show_404();
            }
            $this->template->load('admin', 'admin/affiliations/view', $this->data);
        } else {
            custom_show_404();
        }
    }

    /**
     * Delete affiliation category
     * @param int $id
     * */
    public function delete($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $affiliation = $this->affiliation_model->sql_select(TBL_AFFILIATIONS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($affiliation)) {
                $update_array = array(
                    'is_delete' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->affiliation_model->common_insert_update('update', TBL_AFFILIATIONS, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Affiliation has been deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Unable to delete allifiation!');
            }
        }
        redirect('admin/affiliations');
    }

    /**
     * Approve affiliation added by user.
     * @param int $id
     * */
    public function action($type = '', $id = NULL) {
        $id = base64_decode($id);
        $action_type = $type;
        if (is_numeric($id)) {
            $provider_data = $this->affiliation_model->sql_select(TBL_AFFILIATIONS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($provider_data)) {
                if ($action_type == 'approve') {
                    $update_array = array(
                        'is_approved' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                } else if ($action_type == 'unapprove') {
                    $update_array = array(
                        'is_approved' => 0,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                }
                $this->affiliation_model->common_insert_update('update', TBL_AFFILIATIONS, $update_array, ['id' => $id]);
                if ($action_type == 'approve') {
                    $this->session->set_flashdata('success', 'Affiliation has been approved successfully!');
                } else if ($action_type == 'unapprove') {
                    $this->session->set_flashdata('success', 'Affiliation has been unapproved successfully!');
                }
            } else {
                $this->session->set_flashdata('error', 'Unable to get Affiliation!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/affiliations');
    }

    /**
     * Get cities  or state based on type passed as data.
     * */
    public function get_data() {
        $id = base64_decode($this->input->get('id'));
        $type = $this->input->get('type');
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
     * Delete uploaded image 
     * @author AKK
     */
    public function delete_image() {
        $gallery = base64_decode($this->input->get('image'));
        $media = $this->affiliation_model->sql_select(TBL_AFFILIATIONS, 'image', ['where' => ['id' => $gallery, 'is_delete' => 0]], ['single' => true]);
        if (!empty($media)) {
            $update_array = array(
                'image' => NULL,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->affiliation_model->common_insert_update('update', TBL_AFFILIATIONS, $update_array, ['id' => $gallery]);
            unlink(AFFILIATION_IMAGE . $media['image']);
            $data['success'] = true;
        } else {
            $data['success'] = false;
            $data['error'] = "Invalid request!";
        }
        echo json_encode($data);
        exit;
    }

}
