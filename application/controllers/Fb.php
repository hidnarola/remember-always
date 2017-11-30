<?php

require APPPATH . 'vendor/Facebook/autoload.php';

class Fb extends My_Controller {

    private $fb_secret = [
        'app_id' => '131151487573446',
        'app_secret' => '10fb57cd44b0b62b73784d134c362f9b',
        'default_graph_version' => 'v2.10',
    ];
    private $callback_url = '';
    private $facebook = NULL;

    public function __construct() {

        parent::__construct();

        if (!$this->is_user_loggedin)
            redirect();

        $this->callback_url = base_url('facebook/callback');
        $this->facebook = new Facebook\Facebook($this->fb_secret);
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

        $data = [
            'user_id' => $this->session->userdata('id'),
            'account_name' => $user->getFirstName() . ' ' . $user->getLastName(),
            'image_url' => $user->getPicture()->getUrl(),
            'social_id' => $user->getId(),
            'type' => 1,
            'access_token' => $token,
            'access_token_timeout' => "'" . $expiry_time . "'",
        ];

//        $this->users_model->common_insert_update('insert', TBL_USERS, $data);
    }

}
