<?php

/**
 * Donate Controller
 * Make donations to fund raiser profile
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Donate extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
        $this->config->load('wepay');
        $this->client_id = $this->config->item('client_id');
        $this->client_secret = $this->config->item('client_secret');
    }

    /**
     * Display donation listing page of particular fundraiser profile
     * @param string $slug
     */
    public function index($slug = null) {
        if (!is_null($slug)) {
            $fundraiser = $this->users_model->sql_select(TBL_FUNDRAISER_PROFILES . ' f', 'f.id as fundraiser_id,p.slug,p.id,p.firstname,p.lastname,f.title,f.goal,f.total_donation,f.end_date,f.details', ['where' => ['p.slug' => $slug, 'p.is_delete' => 0, 'p.is_published' => 1]], [
                'single' => true,
                'join' => [
                    array('table' => TBL_PROFILES . ' p', 'condition' => 'p.id=f.profile_id'),
            ]]);
            if (!empty($fundraiser)) {
                $data['fundraiser_media'] = $this->users_model->sql_select(TBL_FUNDRAISER_MEDIA, 'media,type', ['where' => ['fundraiser_profile_id' => $fundraiser['fundraiser_id']]]);
                $data['donations'] = $this->users_model->sql_select(TBL_DONATIONS . ' d', 'u.firstname,u.lastname,u.profile_image,d.details,d.amount,d.created_at', ['where' => ['d.is_delete' => 0, 'p.slug' => $slug]], [
                    'join' => [
                        array('table' => TBL_PROFILES . ' p', 'condition' => 'd.profile_id=p.id'),
                        array('table' => TBL_USERS . ' u', 'condition' => 'd.user_id=u.id'),
                ]]);
                $data['fundraiser'] = $fundraiser;
                $data['title'] = $fundraiser['title'] . ' | Donations';
                $this->template->load('default', 'donate/index', $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function next($slug = null) {
        if (!is_null($slug)) {
            $fundraiser = $this->users_model->sql_select(TBL_FUNDRAISER_PROFILES . ' f', 'f.id as fundraiser_id,p.slug,p.id,p.firstname,p.lastname,f.title,f.goal,f.total_donation,f.end_date,f.details', ['where' => ['p.slug' => $slug, 'p.is_delete' => 0, 'p.is_published' => 1]], [
                'single' => true,
                'join' => [
                    array('table' => TBL_PROFILES . ' p', 'condition' => 'p.id=f.profile_id'),
            ]]);
            if (!empty($fundraiser)) {
                $data['fundraiser_media'] = $this->users_model->sql_select(TBL_FUNDRAISER_MEDIA, 'media,type', ['where' => ['fundraiser_profile_id' => $fundraiser['fundraiser_id']]]);
                $data['donations'] = $this->users_model->sql_select(TBL_DONATIONS . ' d', 'u.firstname,u.lastname,u.profile_image,d.details,d.amount,d.created_at', ['where' => ['d.is_delete' => 0, 'p.slug' => $slug]], [
                    'join' => [
                        array('table' => TBL_PROFILES . ' p', 'condition' => 'd.profile_id=p.id'),
                        array('table' => TBL_USERS . ' u', 'condition' => 'd.user_id=u.id'),
                ]]);
                $data['fundraiser'] = $fundraiser;
                $data['title'] = $fundraiser['title'] . ' | Donate';
                $this->template->load('default', 'donate/next', $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function payment($slug = null) {
        if (!is_null($slug)) {
            $fundraiser = $this->users_model->sql_select(TBL_FUNDRAISER_PROFILES . ' f', 'f.id as fundraiser_id,f.wepay_account_id,f.wepay_access_token,p.slug,p.id,p.firstname,p.lastname,f.title,f.goal,f.total_donation,f.end_date,f.details', ['where' => ['p.slug' => $slug, 'p.is_delete' => 0, 'p.is_published' => 1]], [
                'single' => true,
                'join' => [
                    array('table' => TBL_PROFILES . ' p', 'condition' => 'p.id=f.profile_id'),
            ]]);
            if (!empty($fundraiser) && $fundraiser['wepay_account_id'] != '' && $fundraiser['wepay_access_token'] != '') {
                if ($this->input->post('donate_amount') >= 5) {
                    $amount = $this->input->post('donate_amount');
                    require_once(APPPATH . 'libraries/Wepay.php');
                    // application settings
                    $account_id = $this->encrypt->decode($fundraiser['wepay_account_id']);  // fundraisers's account_id
                    $access_token = $this->encrypt->decode($fundraiser['wepay_access_token']); // fundraisers's access_token
                    // application settings
                    if (WEPAY_ENDPOINT == 'stage') {
                        Wepay::useStaging($this->client_id, $this->client_secret);
                    } else {
                        Wepay::useProduction($this->client_id, $this->client_secret);
                    }
                    $wepay = new WePay($access_token);
                    // create the checkout
                    $response = $wepay->request('checkout/create', array(
                        'account_id' => $account_id,
                        'amount' => $amount,
                        'short_description' => 'Donation',
                        'type' => 'service',
                        'currency' => 'USD'
                    ));
                    if (!empty($response)) {
                        $data['title'] = 'Remember Always | Donation';
                        $data['checkout_id'] = $response->checkout_id;
                        if (WEPAY_ENDPOINT == 'stage') {
                            $data['checkout_uri'] = "https://stage.wepay.com/api/checkout/".$data['checkout_id'];
                        } else {
                            $data['checkout_uri'] = "https://production.wepay.com/api/checkout/".$data['checkout_id'];
                        }
                        $this->template->load('default', 'donate/payment', $data);
                    } else {
                        redirect('donate/next/' . $slug);
                    }
                }
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function third() {
        $data['title'] = 'third';
        $this->template->load('default', 'donate/third', $data);
    }

}
