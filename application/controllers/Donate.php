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
                $data['donations'] = $this->users_model->sql_select(TBL_DONATIONS . ' d', 'u.firstname,u.lastname,u.profile_image,d.details,d.amount,d.created_at', ['where' => ['d.is_delete' => 0, 'd.state' => 'authorized', 'p.slug' => $slug]], [
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
                $account_id = $this->encrypt->decode($fundraiser['wepay_account_id']);  // fundraisers's account_id
                $access_token = $this->encrypt->decode($fundraiser['wepay_access_token']); // fundraisers's access_token
                $data['fundraiser'] = $fundraiser;
                $data['fundraiser_media'] = $this->users_model->sql_select(TBL_FUNDRAISER_MEDIA, 'media,type', ['where' => ['fundraiser_profile_id' => $fundraiser['fundraiser_id']]]);

                if ($this->input->post('donate_amount') >= 5) {
                    $amount = $this->input->post('donate_amount');
                    require_once(APPPATH . 'libraries/Wepay.php');
                    // application settings
                    if (WEPAY_ENDPOINT == 'stage') {
                        Wepay::useStaging($this->client_id, $this->client_secret);
                    } else {
                        Wepay::useProduction($this->client_id, $this->client_secret);
                    }
                    $wepay = new WePay($access_token);
                    $redirect_uri = site_url('donate/thank_you/' . $slug);
                    // create the checkout
                    $response = $wepay->request('checkout/create', array(
                        'account_id' => $account_id,
                        'amount' => $amount,
                        'short_description' => 'Donation',
                        'type' => 'donation',
                        'currency' => 'USD',
                        'hosted_checkout' => ['mode' => 'iframe', 'redirect_uri' => $redirect_uri],
                    ));
                    if (!empty($response)) {
                        $data['title'] = 'Remember Always | Donation';
                        $data['checkout_id'] = $response->checkout_id;
                        if (WEPAY_ENDPOINT == 'stage') {
                            $data['checkout_uri'] = $response->hosted_checkout->checkout_uri;
                        } else {
                            $data['checkout_uri'] = $response->hosted_checkout->checkout_uri;
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

    /**
     * Final thank you page after payment success
     * @param string $slug
     */
    public function thank_you($slug = null) {
        $checkout_id = $this->input->get('checkout_id');
        if (!is_null($slug) && !empty($checkout_id)) {
            $fundraiser = $this->users_model->sql_select(TBL_FUNDRAISER_PROFILES . ' f', 'f.id as fundraiser_id,f.wepay_account_id,f.wepay_access_token,p.slug,p.id,p.firstname,p.lastname,f.title,f.goal,f.total_donation,f.end_date,f.details', ['where' => ['p.slug' => $slug, 'p.is_delete' => 0, 'p.is_published' => 1]], [
                'single' => true,
                'join' => [
                    array('table' => TBL_PROFILES . ' p', 'condition' => 'p.id=f.profile_id'),
            ]]);
            if (!empty($fundraiser) && $fundraiser['wepay_account_id'] != '' && $fundraiser['wepay_access_token'] != '') {
                $account_id = $this->encrypt->decode($fundraiser['wepay_account_id']);  // fundraisers's account_id
                $access_token = $this->encrypt->decode($fundraiser['wepay_access_token']); // fundraisers's access_token
                $data['fundraiser'] = $fundraiser;
                $data['fundraiser_media'] = $this->users_model->sql_select(TBL_FUNDRAISER_MEDIA, 'media,type', ['where' => ['fundraiser_profile_id' => $fundraiser['fundraiser_id']]]);

                require_once(APPPATH . 'libraries/Wepay.php');
                // application settings
                if (WEPAY_ENDPOINT == 'stage') {
                    Wepay::useStaging($this->client_id, $this->client_secret);
                } else {
                    Wepay::useProduction($this->client_id, $this->client_secret);
                }
                $wepay = new WePay($access_token);
                // create the checkout
                $response = $wepay->request('checkout', array(
                    'checkout_id' => $checkout_id,
                ));
                $user_id = null;
                $ip = $this->input->ip_address();
                if ($this->is_user_loggedin) {
                    $user_id = $this->user_id;
                }

                if (!empty($response)) {

                    $donation_arr = [
                        'user_id' => $user_id,
                        'profile_id' => $fundraiser['id'],
                        'checkout_id' => $checkout_id,
                        'account_id' => $this->encrypt->encode($response->account_id),
                        'amount' => $response->amount,
                        'gross' => $response->gross,
                        'state' => $response->state,
                        'ip_address' => $ip,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    $this->users_model->common_insert_update('insert', TBL_DONATIONS, $donation_arr);
                    if ($response->state == 'released' || $response->state == 'authorized') {
                        $total_donation = $fundraiser['total_donation'] + $response->amount;
                        $this->users_model->common_insert_update('update', TBL_FUNDRAISER_PROFILES, ['total_donation' => $total_donation], ['id' => $fundraiser['fundraiser_id']]);
                    }
                    $this->session->set_flashdata('success', 'Thank you for donation!');
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong! Please try again later.');
                }
                redirect('donate/' . $slug);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

}
