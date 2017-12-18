<?php

/**
 * Service Provider Controller
 * Manage profile related functions
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('blogs_model');
    }

    /**
     * Display login page for login
     */
    public function index() {
        $service_categories = $this->blogs_model->sql_select(TBL_SERVICE_CATEGORIES, '*', ['where' => ['is_delete' => 0]]);
        $services = $this->blogs_model->get_providers('result', $this->input->get());

        $data['service_categories'] = $service_categories;
        $data['services'] = $this->load_providers(0, true);

        $data['title'] = 'Services Provider Directory';
        $data['breadcrumb'] = ['title' => 'Services Provider Directory', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'service_provider/index', $data);
    }

    /**
     * Display login page for login
     */
    public function load_providers($start, $static = false) {
        $offset = 1;
        $services = $this->blogs_model->get_providers('result', $this->input->get(), $start, $offset);
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
     * Display Blog Post details
     */
    public function details($slug) {
        if (isset($slug) && !empty($slug)) {
            $blogs = $this->blogs_model->sql_select(TBL_BLOG_POST, '*', ['where' => ['is_delete' => 0]], ['order_by' => 'id DESC', 'limit' => 5]);
            $data['blogs'] = $blogs;
            $blog_data = $this->users_model->sql_select(TBL_BLOG_POST . ' b', 'title,image,description,b.slug,u.firstname,u.lastname,b.created_at', ['where' => ['b.is_delete' => 0, 'b.is_active' => 1, 'b.is_view' => 1, 'slug' => $slug]], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=b.user_id')], 'single' => true]);
            if (!empty($blog_data)) {
                $data['blog_data'] = $blog_data;
            } else {
                custom_show_404();
            }
            $data['title'] = 'Blog Details';
            $data['breadcrumb'] = ['title' => 'Blog Details', 'links' => [['link' => site_url(), 'title' => 'Home'], ['link' => site_url('blog'), 'title' => 'Blog Listing']]];
            $this->template->load('default', 'blog_post/details', $data);
        } else {
            custom_show_404();
        }
    }

}
