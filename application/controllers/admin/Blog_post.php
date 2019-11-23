<?php

/**
 * Providers Controller to manage service users
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_post extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/blog_post_model');
    }

    /**
     * Display listing of service provider
     */
    public function index($user_id = null) {
        if ($user_id != null) {
            $data['user_id'] = $user_id;
        }
        $data['title'] = 'Remember Always Admin | Blog Posts';
        $this->template->load('admin', 'admin/blog_post/index', $data);
    }

    /**
     * Get users data for AJAX table
     * */
    public function get_posts() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->blog_post_model->get_posts('count');
        $final['redraw'] = 1;
        $users = $this->blog_post_model->get_posts('result');
        $start = $this->input->get('start') + 1;
        foreach ($users as $key => $val) {
            $users[$key] = $val;
            $users[$key]['sr_no'] = $start;
            $users[$key]['created_at'] = date('d M Y', strtotime($val['created_at']));
            $start++;
        }
//         p($users, 1);
        $final['data'] = $users;
        echo json_encode($final);
    }

    /**
     * Add a new service provider.
     *
     */
    public function add($id = null) {
        $flag = 0;
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
//            $post_data = $this->blog_post_model->sql_select(TBL_POSTS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            $post_data = $this->blog_post_model->sql_select(TBL_BLOG_POST . ' p', 'p.*,u.firstname as user_fname,u.lastname as user_lname,', ['where' => array('p.id' => $id, 'p.is_delete' => 0)], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=p.user_id AND u.is_delete=0')], 'single' => true]);
            if (!empty($post_data)) {
                $this->data['post_data'] = $post_data;
                $this->data['title'] = 'Remember Always Admin | Blog Posts';
                $this->data['heading'] = 'Edit Blog Post';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Blog Posts';
            $this->data['heading'] = 'Add Blog Post';
        }
        $users = $this->blog_post_model->sql_select(TBL_USERS, null, ['where' => array('is_delete' => 0)]);
        if (!empty($users)) {
            $this->data['users'] = $users;
        }
        $this->form_validation->set_rules('user_id', 'User', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
            $slug = '';
            if (!empty(trim($this->input->post('title')))) {
                $slug = trim($this->input->post('title'));
            }
            if (isset($post_data) && !empty($post_data)) {
                $slug = slug($slug, TBL_BLOG_POST, trim($id));
            } else {
                $slug = slug($slug, TBL_BLOG_POST);
            }
            $dataArr = array(
                'user_id' => base64_decode(trim($this->input->post('user_id'))),
                'slug' => $slug,
                'title' => trim(htmlentities($this->input->post('title'))),
                'description' => trim($this->input->post('description')),
            );
            if ($_FILES['image']['name'] != '') {
                $image_data = upload_image('image', BLOG_POST_IMAGES);
                if (is_array($image_data)) {
                    $flag = 1;
                    $data['profile_image_validation'] = $image_data['errors'];
                } else {
                    $post_image = $image_data;

                    // check height of uploaded slider image
//                    $image_size = getimagesize(base_url() . BLOG_POST_IMAGES . $image_data);
////                    p($image_size);
//                    if ($image_size[1] > 730) {
//                        $path_parts = pathinfo(BLOG_POST_IMAGES . $image_data);
//                        $new_image = $path_parts['filename'] . 'resize.' . $path_parts['extension'];
//                        $post_image = $new_image;
////                        $new_width = (730 * $image_size[0]) / $image_size[1];
//                        $new_width = 1600;
//                        $resize_data = resize_image(BLOG_POST_IMAGES . $image_data, BLOG_POST_IMAGES . $post_image, $new_width, 730);
//                        if (is_array($resize_data)) {
//                            $flag = 1;
//                            $data['profile_image_validation'] = $resize_data['errors'];
//                        }
//                    }
                    if ($flag == 0) {
                        if (is_numeric($id)) {
                            if (!empty($post_data)) {
                                unlink(BLOG_POST_IMAGES . $post_data['image']);
                            }
                        }
                    }
                    $dataArr['image'] = $post_image;
                }
            } else {
                if (is_numeric($id)) {
                    if (!empty($post_data)) {
                        $post_image = $post_data['image'];
                        $dataArr['image'] = $post_data['image'];
                    }
                }
            }
            if ($flag == 0) {
                if (is_numeric($id)) {
                    $dataArr['updated_at'] = date('Y-m-d H:i:s');
                    $this->blog_post_model->common_insert_update('update', TBL_BLOG_POST, $dataArr, ['id' => $id]);
                    $this->session->set_flashdata('success', 'Blog Post details has been updated successfully.');
                } else {
                    $dataArr['is_active'] = 0;
                    $dataArr['created_at'] = date('Y-m-d H:i:s');
                    $id = $this->blog_post_model->common_insert_update('insert', TBL_BLOG_POST, $dataArr);
                    $this->session->set_flashdata('success', 'Blog Post details has been inserted successfully.');
                }
                redirect('admin/blog_post');
            }
        }
        $this->template->load('admin', 'admin/blog_post/manage', $this->data);
    }

    /**
     * view a service provider .
     *
     */
    public function edit($id) {
        $this->add($id);
    }

    /**
     * Edit a Uesr.
     *
     */
    public function view($id, $user_id = null) {
        if (!is_null($id))
            $id = base64_decode($id);
        if (!is_null($user_id)) {
            $this->data['user_id'] = $user_id;
            $user_id = base64_decode($user_id);
        }
        if (is_numeric($id)) {
            $this->data['title'] = 'Remember Always Admin | Posts';
            $this->data['heading'] = 'View Post Details';
            $post_data = $this->blog_post_model->sql_select(TBL_BLOG_POST . ' p', 'p.id as p_id,p.created_at as p_date,p.title,p.description,p.image,u.firstname as user_fname,u.lastname as user_lname,', ['where' => array('p.id' => trim($id), 'p.is_delete' => 0)], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=p.user_id AND u.is_delete=0')], 'single' => true]);
            if (!empty($post_data)) {
                $this->data['post_data'] = $post_data;
            } else {
                custom_show_404();
            }
            $this->template->load('admin', 'admin/blog_post/view', $this->data);
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
            $post_data = $this->blog_post_model->sql_select(TBL_BLOG_POST, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($post_data)) {
                $update_array = array(
                    'is_delete' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->blog_post_model->common_insert_update('update', TBL_BLOG_POST, $update_array, ['id' => $id]);

                $this->session->set_flashdata('success', 'Blog Post has been deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Unable to locate Blog Post!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/blog_post');
    }

    /**
     * Hide or Show Blog Post in front-end.
     * @param int $id
     * */
    public function action($type = '', $id = NULL) {
        $id = base64_decode($id);
        $action_type = $type;
        if (is_numeric($id)) {
            $provider_data = $this->blog_post_model->sql_select(TBL_BLOG_POST, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($provider_data)) {
                if ($action_type == 'hide') {
                    $update_array = array(
                        'is_active' => 0,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                } else if ($action_type == 'show') {
                    $update_array = array(
                        'is_active' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                }
                $this->blog_post_model->common_insert_update('update', TBL_BLOG_POST, $update_array, ['id' => $id]);
                if ($action_type == 'hide') {
                    $this->session->set_flashdata('success', 'Blog Post has been hidden successfully!');
                } else if ($action_type == 'show') {
                    $this->session->set_flashdata('success', 'Blog Post has been visible successfully!');
                }
            } else {
                $this->session->set_flashdata('error', 'Unable to get Blog Post!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/blog_post');
    }

    /**
     * @method : Change_data_status function
     * @uses : This function is used to hide or show blog post for home page.
     * @author : AKK
     * */
    public function change_data_status() {
        if (!is_null($this->input->get('id')))
            $id = base64_decode($this->input->get('id'));
        if (is_numeric($id)) {
            $user_array = array('is_view' => $this->input->get('value'), 'updated_at' => date('Y-m-d H:i:s'));
            if ($this->input->get('value') == 0) {
                $this->blog_post_model->common_insert_update('update', TBL_BLOG_POST, $user_array, ['id' => $id]);
            }
            $count = $this->blog_post_model->sql_select(TBL_BLOG_POST, 'COUNT(*) as view_count', ['where' => array('is_view' => 1, 'is_delete' => 0)], ['single' => true]);
//            p($count['view_count']);
            if ($count['view_count'] < 3) {
                $this->blog_post_model->common_insert_update('update', TBL_BLOG_POST, $user_array, ['id' => $id]);
                echo 'success';
            } else {
                echo 'error';
            }
        }
        exit;
    }

}
