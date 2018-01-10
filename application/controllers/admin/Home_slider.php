<?php

/**
 * Home Slider controller to manage slider images of Home Page
 * @author AKK
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_slider extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/home_slider_model');
    }

    /**
     * Display login page for login
     */
    public function index() {

        $this->data['title'] = 'Remember Always Admin | Home Slider';
        $this->template->load('admin', 'admin/home_slider/index', $this->data);
    }

    /**
     * Display login page for login
     */
    public function get_sliders() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->home_slider_model->get_all_slider('count');
        $final['redraw'] = 1;
        $sliders = $this->home_slider_model->get_all_slider('result');
        $final['data'] = $sliders;
        echo json_encode($final);
    }

    /**
     * Add a new slider .
     *
     */
    public function add($id = null) {
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $slider = $this->home_slider_model->sql_select(TBL_SLIDER, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($slider)) {
                $this->data['slider'] = $slider;
                $this->data['title'] = 'Remember Always Admin | Home Slider';
                $this->data['heading'] = 'Edit Home Slider';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Home Slider';
            $this->data['heading'] = 'Add Home Slider';
        }
        $this->form_validation->set_rules('description', 'Description', 'trim');
//        $this->form_validation->set_rules('image', 'Image', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
            $flag = 0;
            $dataArr = ['description' => trim(htmlentities($this->input->post('description')))];
            if ($_FILES['image']['name'] != '') {
                $image_data = upload_image('image', SLIDER_IMAGES);
                if (is_array($image_data)) {
                    $flag = 1;
                    $data['profile_image_validation'] = $image_data['errors'];
                } else {
                    $slider_image = $image_data;

                    // check height of uploaded slider image
                    $image_size = getimagesize(base_url() . SLIDER_IMAGES . $image_data);
                    if ($image_size[1] > 730) {
                        $path_parts = pathinfo(SLIDER_IMAGES . $image_data);
                        $new_image = $path_parts['filename'] . 'resize.' . $path_parts['extension'];
                        $slider_image = $new_image;
//                        $new_width = (730 * $image_size[0]) / $image_size[1];
                        $new_width = 1600;
                        $resize_data = resize_image(SLIDER_IMAGES . $image_data, SLIDER_IMAGES . $slider_image, $new_width, 730);
                        if (is_array($resize_data)) {
                            $flag = 1;
                            $data['profile_image_validation'] = $resize_data['errors'];
                        }
                    }
                    if ($flag == 0) {
                        if (is_numeric($id)) {
                            $slider = $this->home_slider_model->sql_select(TBL_SLIDER, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
                            if (!empty($slider)) {
                                unlink(SLIDER_IMAGES . $slider['image']);
                            }
                        }
                    }
                    $dataArr['image'] = $slider_image;
                }
            } else {
                if (is_numeric($id)) {
                    $slider = $this->home_slider_model->sql_select(TBL_SLIDER, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
                    if (!empty($slider)) {
                        $slider_image = $slider['image'];
                        $dataArr['image'] = $slider['image'];
                    }
                }
            }
            if ($flag == 0) {
                if (is_numeric($id)) {
                    $dataArr['updated_at'] = date('Y-m-d H:i:s');
                    $this->home_slider_model->common_insert_update('update', TBL_SLIDER, $dataArr, ['id' => $id]);
                    $this->session->set_flashdata('success', 'Slider details has been updated successfully.');
                } else {
                    $dataArr['created_at'] = date('Y-m-d H:i:s');
                    $dataArr['is_active'] = 1;
                    $id = $this->home_slider_model->common_insert_update('insert', TBL_SLIDER, $dataArr);
                    $this->session->set_flashdata('success', 'Slider details has been inserted successfully.');
                }
                redirect('admin/home_slider');
            }
        }
        $this->template->load('admin', 'admin/home_slider/manage', $this->data);
    }

    /**
     * Edit a slider .
     *
     */
    public function view($id) {
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $this->data['title'] = 'Remember Always Admin | Home Slider';
            $this->data['heading'] = 'View Home Slider Details';
            $slider = $this->home_slider_model->sql_select(TBL_SLIDER, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($slider)) {
                $this->data['slider'] = $slider;
            } else {
                custom_show_404();
            }
            $this->template->load('admin', 'admin/home_slider/view', $this->data);
        } else {
            custom_show_404();
        }
    }

    /**
     * view a slider .
     *
     */
    public function edit($id) {
        $this->add($id);
    }

    /**
     * Delete service category
     * @param int $id
     * */
    public function delete($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $slider = $this->home_slider_model->sql_select(TBL_SLIDER, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($slider)) {
                $update_array = array(
                    'is_delete' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->home_slider_model->common_insert_update('update', TBL_SLIDER, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Slider has been deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Unable to delete slider!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/home_slider');
    }

    /**
     * Hide slider
     * @param int $id
     * */
    public function hide($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $slider = $this->home_slider_model->sql_select(TBL_SLIDER, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($slider)) {
                $update_array = array(
                    'is_active' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->home_slider_model->common_insert_update('update', TBL_SLIDER, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Slider will now be hidden!');
            } else {
                $this->session->set_flashdata('error', 'Unable to hide slider!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/home_slider');
    }

    /**
     * Show service category
     * @param int $id
     * */
    public function show($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $slider = $this->home_slider_model->sql_select(TBL_SLIDER, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($slider)) {
                $update_array = array(
                    'is_active' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->home_slider_model->common_insert_update('update', TBL_SLIDER, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Slider will now be visible!');
            } else {
                $this->session->set_flashdata('error', 'Unable to show slider!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/home_slider');
    }

}
