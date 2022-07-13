<?php

    namespace CT;

    // If this file is called directly, abort.
    if (! defined( 'WPINC' )) {
        die;
    }

    class CT_bootstrap {

        public $set_base_dir;
        public $base_system_dir;
        public $base_config_dir;
        public $base_controller_dir;
        public $base_model_dir;
        public $base_library_dir;
        public $base_helper_dir;
        public $base_view_dir;
        public $base_starter_dir;

        public function __construct()
        {
            @ob_start();
            if( session_status() === PHP_SESSION_NONE ) session_start();

        }

        public function load(){

            // -------includes config
            include_once plugin_dir_path(__DIR__) .'config/config.php';
            
            $this->base_system_dir = $config['base_path'] . $config['system_path'];
            $this->base_config_dir = $config['base_path'] . $config['config_path'];
            $this->base_library_dir = $config['base_path'] . $config['libraries_path'];
            $this->base_helper_dir = $config['base_path'] . $config['helpers_path'];
            $this->base_controller_dir = $config['base_path'] . $config['controllers_path'];
            $this->base_model_dir = $config['base_path'] . $config['models_path'];
            $this->base_view_dir = $config['base_path'] . $config['views_path'];
            $this->base_starter_dir = $config['base_path'] . $config['starter_path'];

            date_default_timezone_set($config['default_time_zone']);

            // -------display errors
            if ($config['dev_mode'] !== FALSE) {
                ini_set('display_errors', '1');
                ini_set('display_startup_errors', '1');
                error_reporting(E_ALL);
            }else{
                ini_set('display_errors', 0);
                ini_set('display_startup_errors', 0);
                error_reporting(0);
            }

            // ------includes file system
            include_once $this->base_system_dir . 'Clean_url.php';
            include_once $this->base_system_dir . 'CT_autoload.php';
            include_once $this->base_system_dir . 'CT_controller.php';
            include_once $this->base_system_dir . 'CT_model.php';

            // instances
            $cleanUrlController = new Clean_url();

            // ------cleaner url action
            // set url 
            $setUrlController = isset($_GET['page']) && trim($_GET['page']) !== '' ? 
                trim($_GET['page']) : trim($config['page_404']);

            // set url clean & safe routing url
            if ($config['safe_url'] !== FALSE) {
                $setUrlController = $cleanUrlController->cleaner($setUrlController, $config['regex_safe_url']);
            }

            // instances
            $CT_autoload = new CT_autoload();
            $CT_autoload->loadAllAutoloads();

            $CT_controller = new CT_controller($this, $config, $setUrlController);
            $CT_controller->loadInit($setUrlController);

        }

    }