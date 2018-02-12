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
        mail("ku@narola.email", "My subject", 'test ');
        $configs = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'demo.narola@gmail.com',
            'smtp_pass' => 'Narola@21',
            'transport' => 'Smtp',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'headerCharset' => 'iso-8859-1',
            'mailtype' => 'html'
        );
        $this->load->library('email', $configs);
//                $this->email->initialize($configs);
        $this->email->from('anp@narola.email', 'EMAIL_FROM_NAME');
        $this->email->to('ku@narola.email');

        $msg = 'test email';
        $this->email->subject('Email Verification - Remember Always');
        $this->email->message(stripslashes($msg));
        $this->email->set_mailtype("html");
        $this->email->send();
        echo $this->email->print_debugger();
    }

}
