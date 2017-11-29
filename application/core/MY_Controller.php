<?php

/**
 * For default operation
 * @author KU
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $is_user_loggedin, $is_admin_loggedin = false;

    public function __construct() {
        parent::__construct();

        $this->controller = $this->router->fetch_class();
        $this->action = $this->router->fetch_method();
        $directory = $this->router->fetch_directory();
        //check if directory is admin or not
        if ($directory == 'admin/') {
            $session = $this->session->userdata('remalways_admin');
            if (!empty($session['id']) && !empty($session['email']))
                $this->is_admin_loggedin = true;
            else {
                $encoded_email = get_cookie(REMEMBER_ME_ADMIN_COOKIE);
                $email = $this->encrypt->decode($encoded_email);
                if (!empty($email)) {
                    $admin = $this->users_model->sql_select(TBL_USERS, '*', ['where' => ['email' => $email, 'is_delete' => 0, 'is_active' => 1, 'role' => 'admin']], ['single' => true]);
                    if (!empty($admin)) {
                        unset($admin['password']);
                        $this->session->set_userdata('remalways_admin', $admin);
                        $this->is_admin_loggedin = true;
                    }
                }
            }
            //-- If not logged in and try to access inner pages then redirect user to login page
            if (!$this->is_admin_loggedin) {
                if (strtolower($this->controller) != 'login') {
                    $redirect = site_url(uri_string());
                    redirect('admin/login?redirect=' . base64_encode($redirect));
                }
            } else { //-- If logged in and access login page the redirect user to home page
                if (strtolower($this->controller) == 'login' && strtolower($this->action) != 'logout') {
                    redirect('admin/dashboard');
                }
            }
        } else {
            $session = $this->session->userdata('remalways_user');
            if (!empty($session['id']) && !empty($session['email']))
                $this->is_user_loggedin = true;
            else {
                $encoded_email = get_cookie(REMEMBER_ME_USER_COOKIE);
                $email = $this->encrypt->decode($encoded_email);
                if (!empty($email)) {
                    $admin = $this->users_model->sql_select(TBL_USERS, '*', ['where' => ['email' => $email, 'is_delete' => 0, 'is_active' => 1, 'role' => 'user']], ['single' => true]);
                    if (!empty($admin)) {
                        unset($admin['password']);
                        $this->session->set_userdata('remalways_user', $admin);
                        $this->is_user_loggedin = true;
                    }
                }
            }
        }
    }

}
