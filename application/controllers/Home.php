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

    public function test() {
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = 'demo.narola@gmail.com';
        $config['smtp_pass'] = 'Narola@21';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html';
        $config['starttls'] = true;
        $config['validation'] = TRUE;
        $this->load->library('email', $config);
        $this->email->from('demo.narola@gmail.com', 'Narola');
        $this->email->to('ku@narola.email');
        $msg = 'test email';
        $this->email->subject('Email Verification - Remember Always');
        $this->email->set_mailtype("html");

        $this->email->message($msg);
        //$this->email->send();
        if ($this->email->send()) {
            echo 'Success';
            die;
        } else {
            print_r($this->email->print_debugger());
            die;
        }
    }

}
