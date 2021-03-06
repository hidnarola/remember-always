<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/**
 * Constants for Tables
 */
define('TBL_AFFILIATIONS', 'affiliations');
define('TBL_AFFILIATIONS_CATEGORY', 'affiliation_categories');
define('TBL_CITY', 'cities');
define('TBL_COUNTRY', 'countries');
define('TBL_DONATIONS', 'donations');
define('TBL_FUNDRAISER_MEDIA', 'fundraiser_media');
define('TBL_FUNDRAISER_PROFILES', 'fundraiser_profiles');
define('TBL_FUNERAL_SERVICES', 'funeral_services');
define('TBL_FUN_FACTS', 'fun_facts');
define('TBL_LIFE_TIMELINE', 'life_timeline');
define('TBL_PAGES', 'pages');
define('TBL_POSTS', 'posts');
define('TBL_BLOG_POST', 'blog_post');
define('TBL_POST_MEDIAS', 'post_medias');
define('TBL_PROFILES', 'profiles');
define('TBL_PROFILE_AFFILIATION', 'profile_affiliation');
define('TBL_PROFILE_AFFILIATIONTEXTS', 'profile_affiliationtexts');
define('TBL_PROFILE_EDITORS', 'profile_editors');
define('TBL_GALLERY', 'profile_gallery');
define('TBL_PROFILE_RELATION', 'profile_relation');
define('TBL_RELATIONS', 'relations');
define('TBL_SERVICE_CATEGORIES', 'service_categories');
define('TBL_SERVICE_PROVIDERS', 'service_providers');
define('TBL_SLIDER', 'slider');
define('TBL_STATE', 'states');
define('TBL_USERS', 'users');
define('TBL_QUESTIONS', 'questions');
define('TBL_ANSWERS', 'answers');
define('TBL_COMMENTS', 'comments');

/**
 * Constants for Images
 */
define('UPLOADS', 'uploads/');
define('USER_IMAGES', 'uploads/user-images/');
define('SLIDER_IMAGES', 'uploads/slider-images/');
define('PROVIDER_IMAGES', 'uploads/provider-images/');
define('PROFILE_IMAGES', 'uploads/profile-images/');
define('POST_IMAGES', 'uploads/post-images/');
define('BLOG_POST_IMAGES', 'uploads/blog-post-images/');
define('PAGE_BANNER', 'uploads/banners/');
define('AFFILIATION_IMAGE', 'uploads/affiliation-images/');
define('FUNDRAISER_IMAGES', 'uploads/fundraiser-images/');
define('TEMP_IMAGES', 'uploads/temp-images/');

/**
 * Constants for Cookie
 */
define('REMEMBER_ME_ADMIN_COOKIE', 'remAlwaysAd908f7d89f');
define('REMEMBER_ME_USER_COOKIE', 'remAlways908f7d89f');
/**
 * Constants for google api key
 */
define('GOOGLE_MAP_KEY', 'AIzaSyAylcYpcGylc8GTu_PYJI7sqPVn6ITrVnM');

/**
 * Constants for max file size 
 */
define('MAX_IMAGE_SIZE', 10);
define('MAX_VIDEO_SIZE', 200);
define('MAX_IMAGES_COUNT', 500);
define('MAX_VIDEOS_COUNT', 50);

/* to set ffmpeg exe file path */
if ($_SERVER['HTTP_HOST'] == 'clientapp.narola.online') {
    define('FFMPEG_PATH', 'D:/wamp64/www/HD/ffmpeg/bin/ffmpeg.exe');
    /* Constants for wepay payment payment */
    define('WEPAY_ENDPOINT', 'stage'); // Use "stage" for development and "production" for "Production"
    define('WEPAY_ENVIRONMENT', 'Staging'); // Use "Staging" for development and "Production" for "Production"
} else {
    define('FFMPEG_PATH', '/usr/local/bin/ffmpeg');
    /* Constants for wepay payment payment */
    define('WEPAY_ENDPOINT', 'production');
    define('WEPAY_ENVIRONMENT', 'Production');
}

/**
 * Constants for Floristone api for send flowers
 */
define('TEST_API_KEY', '724510');
define('TEST_PASSWORD', 'K8Ew8o');

/* Support email */
define('SUPPORT_EMAIL', 'support@rememberalways.com');

/* Constants for captcha validations */
define('GOOGLE_SECRET_KEY', '6LfQPEIUAAAAAPnx8oNpNc1Vpz40c_auELJ-N6Q4');



