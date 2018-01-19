<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * index function
     * @uses load CMS page based on page slug
     * @author AKK
     * */
    public function index($page_slug) {
        $get_result = $this->users_model->sql_select(TBL_PAGES, null, ['where' => ['slug' => urldecode($page_slug)]], ['single' => true]);
        if ($get_result) {
            $data['title'] = 'Remember Always';
            $data['page_title'] = $get_result['title'];
            $data['page_data'] = $get_result;
            $data['meta_description'] = $get_result['meta_description'];
            $data['meta_title'] = $get_result['meta_title'];
            $data['meta_keyword'] = $get_result['meta_keyword'];
            $data['breadcrumb'] = ['title' => $get_result['title'], 'links' => [['link' => site_url(), 'title' => 'Home']]];
            $this->template->load('default', 'cms/index', $data);
        } else {
            show_404();
        }
    }

    /**
     * Display contact us page
     */
    public function contact() {
        $data['title'] = 'Remember Always | Contact Us';
        $data['breadcrumb'] = ['title' => 'Contact Us', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'cms/contact_us', $data);
    }

}
