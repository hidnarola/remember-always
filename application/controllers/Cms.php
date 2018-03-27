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
            $data['title'] = $get_result['meta_title'];
            $data['page_title'] = $get_result['title'];
            $data['page_data'] = $get_result;
            $this->meta_description = $get_result['meta_description'];
            $this->meta_title = $get_result['meta_title'];
            $this->meta_keyword = $get_result['meta_keyword'];
            $data['breadcrumb'] = ['title' => $get_result['title'], 'links' => [['link' => site_url(), 'title' => 'Home']]];
            $this->template->load('default', 'cms/index', $data);
        } else {
            show_404();
        }
    }

    /**
     * Display FAQs page
     */
    public function faqs() {
        $data['title'] = 'Remember Always | FAQs';
        $data['breadcrumb'] = ['title' => 'FAQs', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'cms/faqs', $data);
    }

    /**
     * Display contact us page
     */
    public function contact() {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[8]|max_length[15]');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|min_length[10]');
        $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required|callback_captcha_validation', array('required' => 'Please verify captcha'));

        if ($this->form_validation->run() == true) {
            //-- Send Email to remember always support 
            $email_data['subject'] = 'Remember Always - Contact us';

            $email_data['name'] = $this->input->post('name');
            $email_data['email'] = $this->input->post('email');
            $email_data['phone'] = $this->input->post('phone');
            $email_data['subject'] = $this->input->post('subject');
            $email_data['message'] = $this->input->post('message');

            send_mail(SUPPORT_EMAIL, 'contactus', $email_data);
//            send_mail('ku@narola.email', 'contactus', $email_data);
            $this->session->set_flashdata('success', 'Thank you for contacting us. We will be in touch with you very soon.');
            redirect('contact');
        }
        $data['title'] = 'Remember Always | Contact Us';
        $data['breadcrumb'] = ['title' => 'Contact Us', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'cms/contact_us', $data);
    }

    /**
     * Callback function to captcha validation
     * @return boolean
     */
    public function captcha_validation() {
        $secret = GOOGLE_SECRET_KEY;
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $this->input->post('g-recaptcha-response'));
        $responseData = json_decode($verifyResponse);
        if ($responseData->success) {
            return TRUE;
        } else {
            $this->form_validation->set_message('captcha_validation', 'You have not verified captcha properly! Please verify it first');
            return FALSE;
        }
    }

}
