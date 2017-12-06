<?php

class Google extends MY_Controller {

    private $google = [
        'client_id' => '1025861085817-cmtca7p2p3hpkulmb3597t4inga4rdeo.apps.googleusercontent.com',
        'client_secret' => 'z2gBM6O4LkKxUUOoqyzDJhPu',
        'redirect_uri' => '',
        'api_key' => '',
        'app_name' => 'Remember Always'
    ];

    public function __construct() {
        parent::__construct();
        if ($this->is_user_loggedin) {
            redirect();
        }
        $this->google['redirect_uri'] = site_url('google/callback');
        $this->load->library('googleplus', $this->google);
    }

    public function index() {

        redirect($this->googleplus->client->createAuthUrl());
    }

    public function callback() {

        try {

            $this->googleplus->client->authenticate($this->input->get('code'));
            $access_token = $this->googleplus->client->getAccessToken();
            $this->googleplus->client->setAccessToken($access_token);
            $me = $this->googleplus->plus->people->get('me');


            $access_token = json_decode($access_token, 1);


            if (!empty($access_token['refresh_token']))
                $data['refresh_token'] = $access_token['refresh_token'];


            if (!empty($me)) {

                $google_id = $me->id;
                //check google id already present in database
                $db_user = $this->users_model->sql_select(TBL_USERS, '*', ['where' => ['google_id' => $google_id]], ['single' => true]);
                if (!empty($db_user)) {
                    if ($db_user['is_delete'] == 1 || $db_user['is_active'] == 0) {
                        $this->session->set_flashdata('error', 'You account is blocked. Please contact system administrator');
                        redirect('login');
                    } else {
                        $this->session->set_userdata('remalways_user', $db_user);
                        $this->session->set_flashdata('success', 'You are now logged in with Google successfully');
                        redirect('/');
                    }
                } else {

                    $data = [
                        'role' => 'user',
                        'firstname' => $me["name"]['givenName'],
                        'lastname' => $me["name"]['familyName'],
                        'email' => $me["emails"][0]['value'],
                        'password' => null,
                        'profile_image' => $me['image']['url'],
                        'login_access_token' => $access_token['access_token'],
                        'google_id' => $google_id,
                        'is_verify' => 1,
                        'is_active' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $user_id = $this->users_model->common_insert_update('insert', TBL_USERS, $data);
                    $data['id'] = $user_id;
                    $this->session->set_userdata('remalways_user', $data);
                    $this->session->set_flashdata('success', 'You are now logged in with google successfully');
                    redirect('/');
                }
            } else {
                $this->session->set_flashdata('error', 'Unable to connect with facebook');
            }
        } catch (Exception $e) {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
            exit;
        }
    }

    private function update_access_token($app_id, $refresh_token) {
        $request = [
            'url' => 'https://www.googleapis.com/oauth2/v4/token',
            'method' => 'POST',
            'header' => ["Content-Type: application/x-www-form-urlencoded"],
            'post_params' => [
                'client_id' => $this->google['client_id'],
                'client_secret' => $this->google['client_secret'],
                'refresh_token' => $refresh_token,
                'grant_type' => 'refresh_token'
            ]
        ];

//        $responce = $this->social_media_model->curl($request);
    }

}
