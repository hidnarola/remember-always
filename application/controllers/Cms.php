<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * index function
     * @uses load CMS page based on page slug
     * @author KAP
     * */
    public function index($page_slug) {
        $get_result = $this->users_model->sql_select(TBL_PAGES, null, ['where' => ['slug =' . $this->db->escape(urldecode($page_slug))]], ['single' => true]);
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
     * contact_us function
     * @uses load contact us form
     * @author KAP
     * @modify //-- Added google recpatcha 
     * */
    /* public function contact_us() {
      $data['title'] = 'Spotashoot';
      $data['page_title'] = 'Contact Us';
      $this->form_validation->set_rules('name', 'name', 'trim|required');
      $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
      $this->form_validation->set_rules('message', 'message', 'trim|required');
      $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required|callback_captcha_validation', array('required' => 'Please verify captcha'));
      if ($this->form_validation->run() == FALSE) {
      $data['error'] = validation_errors();
      } else {
      $post_data = $this->input->post(null);
      $mail_data = array(
      'heading' => 'Inquiry Message',
      'message' => 'Letters of inquiry are a type of business message that asks the recipient for information or assistance.',
      'name' => $post_data['name'],
      'email' => $post_data['email'],
      'type' => $post_data['inquiry_type'],
      'feedback' => $post_data['message']
      );
      //--- check any image is attached or not
      if ($_FILES['cover_photo']['name'] != '') {
      $mail_data = array_merge($mail_data, array('note' => 'Please find attached file for more information.'));
      }

      $msg = $this->load->view('email_templates/feedback', $mail_data, true);

      //--- send email to spotashoot from user email with attachment
      contact_feedback_mail_send('info@spotashoot.com', $post_data['email'], $post_data['name'], 'Inquiry | ' . $post_data['name'], $msg, $_FILES);

      $mail_data = array(
      'heading' => 'Thank you for inquiry',
      'message' => 'Thank you for contacting us, one of our customer support agents will get back to you within the next 24-48 hours.',
      'name' => $post_data['name'],
      'email' => $post_data['email'],
      'type' => $post_data['inquiry_type'],
      'feedback' => $post_data['message']
      );
      $msg = $this->load->view('email_templates/thankyou_feedback', $mail_data, true);

      //--- send thank you email to user
      send_mail_front($post_data['email'], 'info@spotashoot.com', 'Thank you for inquiry | Spotashoot', $msg);
      $this->session->set_flashdata('message', array('msg' => 'Thank you for contacting us, one of our customer support agents will get back to you within the next 24-48 hours.', 'class' => 'alert-success'));
      redirect('contact-us');
      }
      $this->template->load('default', 'cms/contact_us', $data);
      }

      /**
     * feedback function
     * @uses load feedback form
     * @author KAP
     * */
    /* public function feedback() {
      $data['title'] = 'Spotashoot';
      $data['page_title'] = 'Feedback';
      $this->form_validation->set_rules('name', 'name', 'trim|required');
      $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
      $this->form_validation->set_rules('message', 'message', 'trim|required');
      if ($this->form_validation->run() == FALSE) {
      $data['error'] = validation_errors();
      } else {
      $post_data = $this->input->post(null);
      $mail_data = array(
      'heading' => 'Feedback Message',
      'message' => 'Until someone sends us a customer feedback message that better articulates the user experience and provides insight on how to improve that experience then we will own the Best Customer Feedback Message Ever!! Ever!!',
      'name' => $post_data['name'],
      'email' => $post_data['email'],
      'feedback' => $post_data['message']
      );
      //--- check any image is attached or not
      if ($_FILES['cover_photo']['name'] != '') {
      $mail_data = array_merge($mail_data, array('note' => 'Please find attached file for more information.'));
      }

      $msg = $this->load->view('email_templates/feedback', $mail_data, true);

      //--- send email to spotashoot from user email with attachment
      contact_feedback_mail_send('info@spotashoot.com', $post_data['email'], $post_data['name'], 'Feedback | ' . $post_data['name'], $msg, $_FILES);

      $mail_data = array(
      'heading' => 'Thank you for feedback',
      'message' => 'Thank you for taking the time to leave us a feedback, we take all feedbacks seriously and we shall look into it at the earliest and get in touch with you if needed.',
      'name' => $post_data['name'],
      'email' => $post_data['email'],
      'feedback' => $post_data['message']
      );
      $msg = $this->load->view('email_templates/thankyou_feedback', $mail_data, true);

      //--- send thank you email to user
      send_mail_front($post_data['email'], 'info@spotashoot.com', 'Thank you for feedback | Spotashoot', $msg);
      $this->session->set_flashdata('message', array('msg' => 'Thank you for taking the time to leave us a feedback, we take all feedbacks seriously and we shall look into it at the earliest and get in touch with you if needed.', 'class' => 'alert-success'));
      redirect('feedback');
      }
      $this->template->load('default', 'cms/feedback', $data);
      }

      /**
     * Callback function to captcha validation
     * @return boolean
     * @author KU
     */
    /*  public function captcha_validation() {
      $secret = GOOGLE_SECRET_KEY;
      //get verify response data
      $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $this->input->post('g-recaptcha-response'));
      $responseData = json_decode($verifyResponse);
      if ($responseData->success) {
      return TRUE;
      } else {
      $this->form_validation->set_message('captcha_validation', 'You have not verified captcha properly! Please try again.');
      return FALSE;
      }
      } */
}
