<?php

require APPPATH . 'vendor/Facebook/autoload.php';

class Facebook extends My_Controller {

    private $fb_secret = [
        'app_id' => '131151487573446',
        'app_secret' => '10fb57cd44b0b62b73784d134c362f9b',
        'default_graph_version' => 'v2.10',
    ];
    private $callback_url = '';
    private $facebook = NULL;

    public function __construct() {

        parent::__construct();

        if ($this->is_user_loggedin)
            redirect();

        $this->callback_url = site_url('facebook/callback');
        $this->facebook = new Facebook\Facebook($this->fb_secret);
    }

    public function index() {
        $helper = $this->facebook->getRedirectLoginHelper();

        $scope = [
            'email',
            'public_profile',
            'user_friends',
        ];

        $url = $helper->getLoginUrl($this->callback_url, $scope);

        redirect($url);
    }

    public function connect() {
        $helper = $this->facebook->getRedirectLoginHelper();

        $scope = [
            'business_management',
            'email',
            'user_likes',
            'public_profile',
            'user_friends',
            'manage_pages',
            'publish_pages',
            'publish_actions',
            'user_photos',
            'user_managed_groups'
        ];

        $url = $helper->getLoginUrl($this->callback_url, $scope);

        redirect($url);
    }

    public function callback() {

        $helper = $this->facebook->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        $oAuth2Client = $this->facebook->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        $tokenMetadata->validateAppId($this->fb_secret['app_id']);

        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {

            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken, $this->fb_secret);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }
        }

        $token = $accessToken->getValue();
        $expiry_time = $accessToken->getExpiresAt();

        if (!empty($expiry_time)) {
            $expiry_time = $expiry_time->format('Y-m-d H:i:00');
        }

        try {
            $response = $this->facebook->get('/me?fields=id,name,email,first_name,last_name,birthday,education,gender,location,picture.type(large)', $token);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();


        if (!empty($user)) {

            $facebook_id = $user->getId();
            //check facebook id already present in database
            $db_user = $this->users_model->sql_select(TBL_USERS, '*', ['where' => ['facebook_id' => $facebook_id]], ['single' => true]);
            if (!empty($db_user)) {
                if ($db_user['is_delete'] == 1 || $db_user['is_active'] == 0) {
                    $this->session->set_flashdata('error', 'You account is blocked. Please contact system administrator');
                    redirect('login');
                } else {
                    $this->session->set_userdata('remalways_user', $db_user);
                    $this->session->set_flashdata('success', 'You are now logged in with Facebook successfully');
                    redirect('home');
                }
            } else {
                $data = [
                    'role' => 'user',
                    'firstname' => $user->getFirstName(),
                    'lastname' => $user->getLastName(),
                    'email' => $user->getEmail(),
                    'password' => null,
                    'profile_image' => $user->getPicture()->getUrl(),
                    'login_access_token' => $token,
                    'facebook_id' => $user->getId(),
                    'is_verify' => 1,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->users_model->common_insert_update('insert', TBL_USERS, $data);
                $this->session->set_userdata('remalways_user', $data);
                $this->session->set_flashdata('success', 'You are now logged in with Facebook successfully');
                redirect('home');
            }
        } else {
            $this->session->set_flashdata('error', 'Unable to connect with facebook');
        }
    }

}
