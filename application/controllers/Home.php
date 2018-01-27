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
        require_once(APPPATH . 'vendor/stripe/init.php');

        $stripe = \Stripe\Stripe::setApiKey("sk_test_N9gt1bWxLOcFaoNGuYI1mCvk");
    }

    public function wepay() {
        require_once(APPPATH . 'libraries/Wepay.php');
        $this->load->view('wepay');
    }

    public function payment() {
        require_once(APPPATH . 'libraries/Wepay.php');

        // oauth2 parameters
        $code = $this->input->post('code'); // the code parameter from step 2
        $redirect_uri = site_url() . 'home/wepay/'; // this is the redirect_uri you used in step 1
        // application settings
        $client_id = "122816";
        $client_secret = "1c97f56650";
        // change to useProduction for live environments
        Wepay::useProduction($client_id, $client_secret);
        $wepay = new WePay(NULL); // we don't have an access_token yet so we can pass NULL here
        // create an account for a user
        $response = WePay::getToken($code, $redirect_uri);
        $token = $response->access_token;
        echo 'token is' . $token;
        $wepay = new WePay($token);
        $response = $wepay->request('account/create/', array(
            'name' => 'Pav Account',
            'description' => 'For testing account'
        ));

        // display the response
        var_dump($response);
        print_r($response);
    }

    public function checkout() {
        // WePay PHP SDK - http://git.io/mY7iQQ
        require_once(APPPATH . 'libraries/Wepay.php');
        // application settings
        $account_id = 1073237299; // your app's account_id
        $client_id = 122816;
        $client_secret = "727523550";
        $access_token = "PRODUCTION_3c0034508d21778cd9123118f73964b514c6ab6d2b29f3b91aa82c448b47410b"; // your app's access_token
        // change to useProduction for live environments
        Wepay::useProduction($client_id, $client_secret);
        $wepay = new WePay($access_token);
        // create the checkout
        $response = $wepay->request('checkout/create', array(
            'account_id' => $account_id,
            'amount' => '24.95',
            'short_description' => 'Services rendered by freelancer',
            'type' => 'service',
            'currency' => 'USD'
        ));
        // display the response
        $checkout_id = $response->checkout_id;
        $checkout_uri = $response->checkout_uri;

        print_r($response);
    }

    public function custompage() {
        $this->load->view('custompage');
    }

}
