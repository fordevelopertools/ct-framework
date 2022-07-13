<?php

include __DIR__ .'/../system/CT_func_exists.php';

$config = [
    //time
    'default_time_zone'     =>  'asia/jakarta',

    //url
    'base_url_admin'        =>  admin_url('admin.php'),
    'controller_default'    =>  'page-not-found', // This Url Controller
    'method_default'        =>  'index',
    'method_not_found'      =>  'index',
    'safe_url'              =>  FALSE,
    'regex_safe_url'        => '/[^a-zA-Z0-9]/',
    'plugin_icon_url'       =>  site_url() . '/wp-content/plugins/creative-toolbox/assets/images/logos/favicon-16x16.png',
    'page_404'              =>  'page-not-found', // This Url Controller
    'view_error_default'    =>  'v_view_error',  // This View
    'model_error_view'      =>  'v_model_error', // This View
    'helper_error_view'     =>  '/error/v_error_helper', // this view
    'library_error_view'    =>  '/error/v_error_library', // this view
    'starter_error_view'    =>  '/error/v_error_starter', // this view

    //directory and files
    'base_path'             =>  plugin_dir_path(__DIR__),

    // current dir by base path
    // don't edit this if you don't understand the whole system flow
    'system_path'           =>  './system/',
    'config_path'           =>  './config/',
    'controllers_path'      =>  './controllers/',
    'models_path'           =>  './models/',
    'views_path'            =>  './views/',
    'libraries_path'        =>  './libraries/',
    'helpers_path'          =>  './helpers/',
    'starter_path'          =>  './starter/',
    
    // development mode. if is 'TRUE', you can see display error.
    'dev_mode'              =>  TRUE,

    //app info
    'developer_app'         =>  'ForDeveloperTools',
    'developer_link'        =>  'https://github.com/fordevelopertools',
    'copyright_app'         =>  'Creative Toolbox',

    //assets
    'assets_url'                    =>  site_url('wp-content/plugins/creative-toolbox/assets/'),
    'assets_template_ct_theme'      =>  site_url('wp-content/plugins/creative-toolbox/assets/templates/ct_theme/'),
    'assets_template_css_theme'     =>  site_url('wp-content/plugins/creative-toolbox/assets/templates/ct_theme/css/'),
    'assets_template_js_theme'      =>  site_url('wp-content/plugins/creative-toolbox/assets/templates/ct_theme/js/'),

    /*
		--------------------------------------
		- input file
		
		Example :

		- set default upload directory
		$config['default_upload_dir'] = './public/uploads/';

		- set max size file upload
		- type is bytes
		$config['default_max_size'] = '1024';

		- set allowed type of file, you can add for multiple types
		$config['default_allowed_type'] = 'png';

		- set default max upload
		$config['default_max_upload'] = '1';

		--------------------------------------
	*/

	'default_upload_dir'	=>	ABSPATH .'./ct-public/uploads/files/',
	'default_max_size'		=>	'1024', // in Bytes.
	'default_allow_type'    =>	'png|jpg|jpeg|gif|mp4|webp|webm|avi|3gp|svg|pdf|txt|xls|ppt|docs|doc',
	'default_max_upload'	=>	'25'
];

// set globals config
$GLOBALS['CT_CONFIG'] = $config;
