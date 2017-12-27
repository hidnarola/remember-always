<?php

/**
 * Blog Controller
 * Display all blogs
 * @author AKK 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('blogs_model');
    }

    /**
     * Display Blog listing
     */
    public function index($start = 0) {
        $blog_list = $this->blogs_model->sql_select(TBL_BLOG_POST, '*', ['where' => ['is_delete' => 0, 'is_active' => 1]], ['order_by' => 'id DESC', 'limit' => 10]);
        $data['blog_list'] = $blog_list;

        $page_config = front_pagination();
        $page_config['per_page'] = 4;
        $page_config['base_url'] = site_url('blog');
        $page_config["total_rows"] = $this->load_blogs('count', 0);
        $data['blogs'] = $this->load_blogs('result', $start);
        $this->pagination->initialize($page_config);

        $data['title'] = 'All Blogs';
        $data['breadcrumb'] = ['title' => 'Blogs', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'blog_post/index', $data);
    }

    /**
     * Returns Blog based on content to be showed on page.
     */
    public function load_blogs($type = 'result', $start) {
        $offset = 4;
        $blogs = $this->blogs_model->get_blogs($type, null, $start, $offset);
        return $blogs;
    }

    /**
     * Display Blog Post details
     */
    public function details($slug) {
        if (isset($slug) && !empty($slug)) {
            $blogs = $this->blogs_model->sql_select(TBL_BLOG_POST, '*', ['where' => ['is_delete' => 0, 'is_active' => 1]], ['order_by' => 'id DESC', 'limit' => 5]);
            $data['blogs'] = $blogs;
            $blog_data = $this->users_model->sql_select(TBL_BLOG_POST . ' b', 'title,image,description,b.slug,u.firstname,u.lastname,b.created_at', ['where' => ['b.is_delete' => 0, 'b.is_active' => 1, 'slug' => $slug]], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=b.user_id')], 'single' => true]);
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
