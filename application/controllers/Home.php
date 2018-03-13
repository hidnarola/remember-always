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
        $data['recent_profiles'] = $this->users_model->sql_select(TBL_PROFILES, 'slug,profile_image,firstname,lastname,nickname,date_of_birth,date_of_death,life_bio', ['where' => ['is_delete' => 0, 'is_published' => 1]], ['order_by' => 'created_at DESC', 'limit' => 5]);
        $data['most_visited_profiles'] = $this->users_model->sql_select(TBL_PROFILES, 'slug,profile_image,firstname,lastname,nickname,date_of_birth,date_of_death,life_bio', ['where' => ['is_delete' => 0, 'is_published' => 1, 'most_visited' => 1]], ['order_by' => 'created_at DESC', 'limit' => 5]);
        $data['notable_profiles'] = $this->users_model->sql_select(TBL_PROFILES, 'slug,profile_image,firstname,lastname,nickname,date_of_birth,date_of_death,life_bio', ['where' => ['is_delete' => 0, 'is_published' => 1, 'notable' => 1]], ['order_by' => 'created_at DESC', 'limit' => 5]);
        $this->template->load('default', 'home', $data);
    }

    public function test() {
        echo shell_exec('whoami');
        $output = shell_exec('sudo /home/ec2-user/bin/ffmpeg 2>&1');
        echo "<pre>$output</pre>";
        exit;
        /*
          echo shell_exec('whoami');
          $output1 = shell_exec('ffmpeg 2>&1');
          echo "<pre>$output1</pre>";

          $output = shell_exec('/home/ec2-user/bin/ffmpeg 2>&1');
          echo "<pre>$output</pre>";
          exit; */
        $cmd = "/home/ec2-user/bin/ffmpeg -i /var/www/html/uploads/post-images/5a27691f2dc501512532255.png -vf scale=500:-1 /var/www/html/uploads/post-images/new_1.png";
        $locale = 'en_IN.UTF-8';
        setlocale(LC_ALL, $locale);
        putenv('LC_ALL=' . $locale);
        echo shell_exec($cmd);
//        echo shell_exec('/home/ec2-user/bin/ffmpeg -i /var/www/html/uploads/post-images/5a27691f2dc501512532255.png -vf scale=500:-1 /var/www/html/uploads/post-images/new_1.png');
    }

}
