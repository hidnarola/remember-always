<?php

/**
 * Fundraiser Controller
 * To manage fundraising merchant accounts with each fundraising profiles
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Fundraiser extends MY_Controller {

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
            $profile = $this->users_model->sql_select(TBL_PROFILES, 'id,firstname,lastname', ['where' => ['slug' => $slug, 'is_delete' => 0, 'user_id' => $this->user_id]], ['single' => true]);
            if (!empty($profile)) {
                $fundraiser = $this->users_model->sql_select(TBL_FUNDRAISER_PROFILES, 'id,title,details,wepay_account_id,wepay_access_token', ['where' => ['profile_id' => $profile['id'], 'is_delete' => 0]], ['single' => true]);
                $fundraiser_title = $profile['firstname'] . ' ' . $profile['lastname'] . '\'s Fundraiser';
//                $fundraiser_title = $profile['firstname'] . ' ' . $profile['lastname'] . '\'s Fundraiser -' . base64_encode($profile['id']);
                $fundraiser_decription = '';

                if (empty($fundraiser)) {
                    $data_arr = ['profile_id' => $profile['id'], 'created_at' => date('Y-m-d H:i:s')];
                    $fundraiser_id = $this->users_model->common_insert_update('insert', TBL_FUNDRAISER_PROFILES, $data_arr);
                } else {
                    $fundraiser_id = $fundraiser['id'];
                    if ($fundraiser['title'] != '') {
                        $fundraiser_title = $fundraiser['title'] . ' -' . base64_encode($profile['id']);
                    }
                    if ($fundraiser['details'] != '') {
                        $fundraiser_decription = $fundraiser['details'];
                    }
                }

                require_once(APPPATH . 'libraries/Wepay.php');

                // oauth2 parameters
                $code = $this->input->post('code'); // the code parameter from step 2
                $redirect_uri = $this->input->post('redirect_uri'); // this is the redirect_uri you used in step 1
                // application settings
                if (WEPAY_ENDPOINT == 'stage') {
                    Wepay::useStaging($this->client_id, $this->client_secret);
                } else {
                    Wepay::useProduction($this->client_id, $this->client_secret);
                }
                $wepay = new WePay(NULL); // we don't have an access_token yet so we can pass NULL here
                // create an account for a user
                $response = WePay::getToken($code, $redirect_uri);
                if (!empty($response)) {

                    $access_token = $response->access_token;
                    $wepay = new WePay($access_token);
                    $account_response = $wepay->request('account/create/', array(
                        'name' => $fundraiser_title,
                        'description' => $fundraiser_decription
                    ));

                    if (!empty($account_response)) {
                        $account_id = $account_response->account_id;

                        $encrypted_account_id = $this->encrypt->encode($account_id);
                        $encrypted_access_token = $this->encrypt->encode($access_token);
                        $wepay_arr = ['wepay_account_id' => $encrypted_account_id, 'wepay_access_token' => $encrypted_access_token];

                        $this->users_model->common_insert_update('update', TBL_FUNDRAISER_PROFILES, $wepay_arr, ['id' => $fundraiser_id]);
                        $data['success'] = true;
                    } else {
                        $data['error'] = 'Something went wrong!Please try again';
                        $data['success'] = false;
                    }
                } else {
                    $data['error'] = 'Something went wrong!Please try again';
                    $data['success'] = false;
                }
            } else {
                $data['error'] = 'Invalid Request!';
                $data['success'] = false;
            }
        } else {
            $data['error'] = 'Invalid Request!';
            $data['success'] = false;
        }
        echo json_encode($data);
        exit;
    }

}
