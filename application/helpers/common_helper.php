<?php

/**
 * Common Helper
 * Common functions used
 * @author KU
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Common Send Email Function
 * @param string $to - To Email ID
 * @param string $template - Email Template file
 * @param Array $data - Data to be passed
 * @return boolean
 */
function send_mail($to = '', $template = '', $data = []) {
    if (empty($to) || empty($template) || empty($data)) {
        return false;
    }
    $ci = &get_instance();
    $ci->load->library('email');

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_user'] = 'pav.narola@gmail.com';
    $config['smtp_pass'] = 'narola21';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';
    $config['validation'] = TRUE;

    $ci->email->initialize($config);

    $ci->email->to($to);
    $ci->email->from('do-not-reply@rememberalways.com', 'Remember Always');
//    $ci->email->from('no-reply@rememberalways.com');
    $ci->email->subject($data['subject']);
    $view = $ci->load->view('email_templates/' . $template, $data, TRUE);
    $ci->email->message($view);
    $ci->email->send();
}

/**
 * Print array/string.
 * @param array $data - data which is going to be printed
 * @param boolean $is_die - if set to true then excecution will stop after print. 
 */
function p($data, $is_die = false) {

    if (is_array($data)) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    } else {
        echo $data;
    }

    if ($is_die)
        die;
}

/**
 * Print last executed query
 * @param boolean $bool - if set to true then execution will stop after print
 */
function qry($bool = false) {
    $CI = & get_instance();
    echo $CI->db->last_query();
    if ($bool)
        die;
}

/**
 * Return verification code with check already exit or not for users table
 */
function verification_code() {
    $CI = & get_instance();
    for ($i = 0; $i < 1; $i++) {
        $verification_string = 'abcdefghijk123' . time();
        $verification_code = str_shuffle($verification_string);

        $check_code = $CI->users_model->check_verification_code($verification_code);
        if (sizeof($check_code) > 0) {
            $i--;
        } else {
            return $verification_code;
        }
    }
}

/**
 * Return unique slug with table check
 */

/**
 * Return slug with unique check in table
 * @param string $text
 * @param string $table
 * @param int $id
 * @return string
 */
function slug($text, $table, $id = NULL) {
    $CI = & get_instance();
    $CI->load->model('users_model');

    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // lowercase
    $text = strtolower($text);

    $used_actions = ['create', 'edit', 'index', 'publish',
        'load_gallery', 'load_posts', 'load_timeline', 'view_timeline', 'upload_cover_image', 'upload_gallery', 'delete_gallery', 'proceed_steps',
        'add_facts', 'check_facts', 'delete_facts', 'add_affiliation', 'check_affiliation', 'delete_affiliation', 'add_timeline', 'delete_timeline',
        'lifetimeline', 'get_states', 'get_cities', 'add_services', 'add_fundraiser', 'delete_fundmedia', 'upload_post', 'delete_post', 'send_profile_email'];
    if (empty($text)) {
        $text = 'n-a';
    } elseif (in_array($text, $used_actions)) { //-- check if slug contains "create" OR "upload_gallery" keyword as its action of controller
        $text = 'n-a';
    }

    if ($table != '') {
        //--- when text with table name then check generated slug is already exist or not
        for ($i = 0; $i < 1; $i++) {
            if ($id != NULL) {
                $where = ['slug' => $text, 'id!=' => $id];
            } else {
                $where = ['slug' => $text];
            }
            $result = $CI->users_model->sql_select($table, '*', ['where' => $where], ['single' => true]);
            if (sizeof($result) > 0) {
                $explode_slug = explode("-", $text);
                $last_char = $explode_slug[count($explode_slug) - 1];
                if (is_numeric($last_char)) {
                    $last_char++;
                    unset($explode_slug[count($explode_slug) - 1]);
                    $text = implode($explode_slug, "-");
                    $text .= "-" . $last_char;
                } else {
                    $text .= "-1";
                }
                $i--;
            } else {
                return $text;
            }
        }
    } else {
        return $text;
    }
}

/**
 * Uploads image
 * @param string $image_name
 * @param string $image_path
 * @return array - Either name of the image if uploaded successfully or Array of errors if image is not uploaded successfully
 */
function upload_image($image_name, $image_path) {

    $CI = & get_instance();
    $extension = explode('/', $_FILES[$image_name]['type']);
    $randname = uniqid() . time() . '.' . end($extension);
    $config = array(
        'upload_path' => $image_path,
        'allowed_types' => "png|jpg|jpeg|gif",
        'max_size' => (MAX_IMAGE_SIZE * 1024),
        // 'max_height'      => "768",
        // 'max_width'       => "1024" ,
        'file_name' => $randname
    );
    //--Load the upload library
    $CI->load->library('upload');
    $CI->upload->initialize($config);
    if ($CI->upload->do_upload($image_name)) {
        $img_data = $CI->upload->data();
        /*
          $randname = uniqid() . time();
          $file_name = $randname . $img_data['file_ext'];
          $old_path = $img_data['full_path'];
          $new_path = $img_data['file_path'] . $file_name;
          exec(FFMPEG_PATH . ' -i ' . $old_path . ' -vf scale=500:-1 ' . $new_path);
          unlink($img_data['full_path']);
          $imgname = $file_name; */

//        $new_line = exec(FFMPEG_PATH . ' -i ' . $filepath . ' -vf "scale=min\'(4032,iw)\':-2" ' . $filepath_new);
        $imgname = $img_data['file_name'];
    } else {
        $imgname = array('errors' => $CI->upload->display_errors());
    }
    return $imgname;
}

/**
 * Uploads video
 * @param string $img_data_name
 * @param string $img_data_path
 * @return array - Either name of the video if uploaded successfully or Array of errors if video is not uploaded successfully
 */
function upload_video($img_data_name, $img_data_path) {
    $CI = & get_instance();
    $extension = explode('/', $_FILES[$img_data_name]['type']);
    $randname = uniqid() . time() . '.' . end($extension);
    $config = array(
        'upload_path' => $img_data_path,
        'allowed_types' => "mp4",
        'max_size' => (MAX_VIDEO_SIZE * 1024),
        'file_name' => $randname
    );
    //--Load the upload library
    $CI->load->library('upload');
    $CI->upload->initialize($config);
    if ($CI->upload->do_upload($img_data_name)) {
        $img_data = $CI->upload->data();
        $randname = uniqid() . time();
        $file_name = $randname . $img_data['file_ext'];
        $img_file_name = $randname . '.jpg';
        exec(FFMPEG_PATH . ' -i ' . $img_data['full_path'] . ' -vcodec libx264 -crf 20 ' . $img_data['file_path'] . $file_name);
        exec(FFMPEG_PATH . ' -i ' . $img_data['full_path'] . ' -ss 00:00:01.000 -vframes 1 ' . $img_data['file_path'] . $img_file_name);
        unlink($img_data['full_path']);
        $vdoname = $file_name;
    } else {
        $vdoname = array('errors' => $CI->upload->display_errors());
    }
    return $vdoname;
}

/**
 * Uploads image
 * @param string $image_name
 * @param string $image_path
 * @return array - Either name of the image if uploaded successfully or Array of errors if image is not uploaded successfully
 */
function upload_multiple_image($image_name, $extension, $image_path, $type = 'image', $allow_extension = null) {
    $CI = & get_instance();
//    $extension = explode('/', $_FILES[$image_name]['type']);
    $randname = uniqid() . time() . '.' . $extension;
    $config = array(
        'upload_path' => $image_path,
        'allowed_types' => "png|jpg|jpeg|gif",
        'max_size' => "2048",
        // 'max_height'      => "768",
        // 'max_width'       => "1024" ,
        'file_name' => $randname
    );
    if ($type == 'image') {
        $config['max_size'] = MAX_IMAGE_SIZE * 1024;
    } else if ($type == 'video') {
        $config['max_size'] = MAX_VIDEO_SIZE * 1024;
    }
    if ($allow_extension != null) {
        $config['allowed_types'] = $allow_extension;
    }
    //--Load the upload library
    $CI->load->library('upload');
    $CI->upload->initialize($config);
    if ($CI->upload->do_upload($image_name)) {
        $img_data = $CI->upload->data();
        p($img_data,1);
        if ($type == 'video') {
            $randname = uniqid() . time();
            $file_name = $randname . $img_data['file_ext'];
            $img_file_name = $randname . '.jpg';
            exec(FFMPEG_PATH . ' -i ' . $img_data['full_path'] . ' -vcodec libx264 -crf 20 ' . $img_data['file_path'] . $file_name);
            exec(FFMPEG_PATH . ' -i ' . $img_data['full_path'] . ' -ss 00:00:01.000 -vframes 1 ' . $img_data['file_path'] . $img_file_name);
            unlink($img_data['full_path']);
            $imgname = $file_name;
        } else {
            $randname = uniqid() . time();
            $file_name = $randname . $img_data['file_ext'];
            $old_path = $img_data['full_path'];
            $new_path = $img_data['file_path'] . $file_name;
            exec(FFMPEG_PATH . ' -i ' . $old_path . ' -vf scale=500:-1 ' . $new_path);
            unlink($img_data['full_path']);
            $imgname = $file_name;
        }
    } else {
        $imgname = array('errors' => $CI->upload->display_errors());
    }
    return $imgname;
}

/**
 * Generated random password
 * @return generated password
 */
function randomPassword() {
//    475F0EDD
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

/**
 * Set up configuration array for pagination
 * @return array - Configuration array for pagination
 */
function front_pagination() {
    $config['full_tag_open'] = '<ul class="paggination">';
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['first_link'] = 'First';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li style="display:none"></li><li class="active"><a data-type="checked">';
    $config['cur_tag_close'] = '</a></li><li style="display:none"></li>';
    $config['prev_link'] = '&laquo;';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&raquo;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['last_link'] = 'Last';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    return $config;
}

/**
 * Resize image to specified dimensions
 * @param string $src - Source of image
 * @param string $dest - Destination of image
 * @param int $width - Width of image
 * @param int $height - Height of image
 */
function resize_image($src, $dest, $width, $height) {
    $CI = & get_instance();
    $CI->load->library('image_lib');
    $CI->image_lib->clear();
    $config['image_library'] = 'gd2';
    $config['source_image'] = $src;
    $config['maintain_ratio'] = FALSE;
    $config['width'] = $width;
    $config['height'] = $height;
    $config['new_image'] = $dest;
    $CI->image_lib->initialize($config);
    $data = '';
    if (!$CI->image_lib->resize()) {
        $data = array('errors' => $CI->image_lib->display_errors());
    }
    return $data;
}

/**
 * Returns file size in GB/MB or KB
 * @param int $bytes
 * @return string
 */
function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}

/**
 * Crops the image
 * @param int $source_x
 * @param int $source_y
 * @param int $width
 * @param int $height
 * @param string $image_name
 */
function crop_image($source_x, $source_y, $width, $height, $image_name) {
    ini_set('memory_limit', '500M');

    $output_path = CROP_FACES;
    $extension = pathinfo($image_name, PATHINFO_EXTENSION);
    $filename = pathinfo($image_name, PATHINFO_FILENAME);


    if ($extension == 'jpg' || $extension == 'jpeg') {
        $image = imagecreatefromjpeg($image_name);
    } else if ($extension == 'png') {
        $image = imagecreatefrompng($image_name);
    }

    $new_image = imagecreatetruecolor($width, $height);
    imagecopy($new_image, $image, 0, 0, $source_x, $source_y, $width, $height);
    // Now $new_image has the portion cropped from the source and you can output or save it.
    if ($extension == 'jpg' || $extension == 'jpeg') {
        imagejpeg($new_image, $output_path . $filename . '.' . $extension);
    } else if ($extension == 'png') {
        imagepng($new_image, $output_path . $filename . '.' . $extension);
    }
}

/**
 * 404 Error Handler
 *
 * @uses CI_Exceptions::show_error()
 * @param string $page Page URI
 * @param bool $log_error Whether to log the error
 * @return void
 */
function custom_show_404($page = '', $log_error = TRUE) {
    $CI = & get_instance();
    $directory = $CI->router->fetch_directory();
    if ($directory == 'admin/') {
        $CI->load->view('Templates/show_404');
    } else {
        $CI->load->view('Templates/Front_show_404');
    }
    echo $CI->output->get_output();
    exit; // EXIT_UNKNOWN_FILE
}

/**
 * Format number of date difference between two dates
 *
 * @param object $days_diff
 * @return string result
 */
function format_days($days_diff) {
    $result = '';
    if ($days_diff->y > 0) {
        if ($days_diff->y > 1) {
            $result .= $days_diff->y . ' Years';
        } else {
            $result .= $days_diff->y . ' Year';
        }
    } else if ($days_diff->m > 0) {
        if ($days_diff->m > 1) {
            $result .= $days_diff->m . ' Months';
        } else {
            $result .= $days_diff->m . ' Month';
        }
    } else if ($days_diff->d > 0) {
        if ($days_diff->d > 1) {
            $result .= $days_diff->d . ' Days';
        } else {
            $result .= $days_diff->d . ' Day';
        }
    } else if ($days_diff->h > 0) {
        if ($days_diff->h > 1) {
            $result .= $days_diff->h . ' Hours';
        } else {
            $result .= $days_diff->h . ' Hour';
        }
    } else if ($days_diff->i > 0) {
        if ($days_diff->i > 1) {
            $result .= $days_diff->i . ' Minutes';
        } else {
            $result .= $days_diff->i . ' Minute';
        }
    } else if ($days_diff->s > 0) {
        if ($days_diff->s > 1) {
            $result .= $days_diff->s . ' Seconds';
        } else {
            $result .= $days_diff->s . ' Second';
        }
    } else {
        $result .= 'Just Now';
    }
    return $result;
}

/**
 * Format the date 
 *
 * @param object $date is the date to be passed.
 * @param object $type is the type that user want, it can be date,month,year.
 * @return string result
 * @author akk
 */
function custom_format_date($data, $type, $full = false) {
    $result = '';
    $month = array('1' => array('short_name' => 'Jan', 'name' => 'Janurary'),
        '2' => array('short_name' => 'Feb', 'name' => 'Feburary'),
        '3' => array('short_name' => 'Mar', 'name' => 'March'),
        '4' => array('short_name' => 'Apr', 'name' => 'April'),
        '5' => array('short_name' => 'May', 'name' => 'May'),
        '6' => array('short_name' => 'June', 'name' => 'June'),
        '7' => array('short_name' => 'July', 'name' => 'July'),
        '8' => array('short_name' => 'Aug', 'name' => 'August'),
        '9' => array('short_name' => 'Sep', 'name' => 'September'),
        '10' => array('short_name' => 'Oct', 'name' => 'October'),
        '11' => array('short_name' => 'Nov', 'name' => 'November'),
        '12' => array('short_name' => 'Dec', 'name' => 'December'),
    );
    if (!empty($data) && $type == 'date') {
        $result = date('M d, Y', strtotime($data));
    } else if (!empty($data) && $type == 'month') {
        if (key_exists($data, $month) && $full == true) {
            $result = $month[$data]['name'];
        } else if (key_exists($data, $month) && $full == false) {
            $result = $month[$data]['short_name'];
        }
    }

    return $result;
}

/**
 * get_pages get pages based on perameter
 * @param  @type
 * @author AKK
 */
function get_pages($type) {
    $CI = & get_instance();
//    $CI->load->model('MY_Model');
    if ($type == 'header') {
        $result = $CI->users_model->get_pages($type);
        if ($result) {
            $menu_array = array();
            foreach ($result as $key => $value) {
                if ($value['parent_id'] == 0 && $value['active'] == 1) {
                    $menu_array[$value['id']] = $value;
                }
            }
            foreach ($result as $key => $value) {
                if ($value['parent_id'] != 0) {
                    if (isset($menu_array[$value['parent_id']])) {
                        $menu_array[$value['parent_id']]['sub_menus'][] = $value;
                    }
                }
            }
            return $menu_array;
        }
    }

    if ($type == 'footer') {
        $result = $CI->users_model->get_pages($type);
        if ($result) {
            $menu_array = array();
            foreach ($result as $key => $value) {
                // if($value['parent_id'] == 0){
                $menu_array[$key] = $value;
                // } 
            }
            return $menu_array;
        }
    }
}
