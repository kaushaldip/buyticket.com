<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Custon define variable 
| Define by ajay @ March 10 2013
|--------------------------------------------------------------------------
*/
if($_SERVER['HTTP_HOST'] == "localhost:8888" || $_SERVER['HTTP_HOST'] == "192.168.2.89" || $_SERVER['HTTP_HOST'] == "es77")
{
    define('ROOT_SITE_PATH','http://'.$_SERVER['HTTP_HOST'].'/buyticket.com/');
    define('BASEURL','http://'.$_SERVER['HTTP_HOST'].'/buyticket.com/');
}    
else
{
    define('ROOT_SITE_PATH','http://'.$_SERVER['HTTP_HOST'].'/buyticket.com/');
    define('BASEURL','http://'.$_SERVER['HTTP_HOST'].'/buyticket.com/');
}

define('ADMIN_CSS_DIR_FULL_PATH',						ROOT_SITE_PATH.'assets/admin_css/');
define('ADMIN_IMG_DIR_FULL_PATH',						BASEURL.'assets/admin_css/images/');
define('ADMIN_JS_DIR_FULL_PATH',						ROOT_SITE_PATH.'assets/js/admin/');

define('MAIN_CSS_DIR_FULL_PATH',						ROOT_SITE_PATH.'assets/css/');
define('MAIN_IMAGES_DIR_FULL_PATH',						ROOT_SITE_PATH.'assets/images/');
//define('MAIN_IMG_DIR_FULL_PATH',						BASEURL.'assets/img/');
define('MAIN_JS_DIR_FULL_PATH',							ROOT_SITE_PATH.'assets/js/');
define('ASSETS_PATH',									ROOT_SITE_PATH.'assets/');
define('ASSETS_CALENDER',								ROOT_SITE_PATH.'assets/calender/');

//admin login session
define('ADMIN_LOGIN_ID',							'admin_user_id');
define('ADMIN_LOGIN_USERNAME',							'admin_user_username');

//admin & dashboard path
define('ADMIN_LOGIN_PATH',					'administrator');
define('ADMIN_DASHBOARD_PATH',					'dashboard');

//upload file location
define('UPLOAD_FILE_PATH',					'upload_files/');
define('PROFILE_IMG_PATH',					'upload_files/profile_img/');

define('CHARACTER_SET',                '23456789ABCDEFGHJKLMNPQRSTUVWXYZ');

define('SESSION','TEIMJSIYOGESTICKAT');

define('MY_ACCOUNT','my-auktis');

/* End of file constants.php */
/* Location: ./application/config/constants.php */