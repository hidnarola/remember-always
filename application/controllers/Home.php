<?php

/**
 * Home Controller
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Landing page
     */
    public function index() {
        $data['title'] = 'Remember Always';
        $data['slider_images'] = $this->users_model->sql_select(TBL_SLIDER, 'image,description', ['where' => ['is_delete' => 0, 'is_active' => 1]]);
        $data['blogs'] = $this->users_model->sql_select(TBL_BLOG_POST . ' b', 'title,image,description,b.slug,u.firstname,u.lastname,b.created_at', ['where' => ['b.is_delete' => 0, 'b.is_active' => 1, 'b.is_view' => 1]], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=b.user_id')]]);
        $this->template->load('default', 'home', $data);
    }

}
