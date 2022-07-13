<?php

    namespace CT;

    class CT_controller {

        public $bootstrap;
        public $config;
        public $setUrlController;
        public $ctView;
        public $baseSystemDir;
        public $defaultView;
        public $pathView;
        public $viewSet;
        public $modelFile;
        public $modelSet;
        public $defaultModel;
        public $pathModel;
        public $pathHelper;
        public $pathLibrary;

        public function __construct($bootstrap, $config, $setUrlController)
        {
            $this->bootstrap  = $bootstrap;
            $this->config = $config;
            $this->setUrlController = $setUrlController;
            $this->baseSystemDir = $this->bootstrap->base_system_dir;
        }

        public function autoload($fileLoad = null, $typeLoad = null)
        {
            include plugin_dir_path(__DIR__) .'config/config.php';

            $this->pathHelper = $config['base_path'] . $config['helpers_path'];
            $this->pathLibrary = $config['base_path'] . $config['libraries_path'];
            $this->pathView = $config['base_path'] . $config['views_path'];

            if ($typeLoad !== null && $fileLoad !== null) {
                // check load type
                // check file exits
                $fileSetLoad = $typeLoad == 'helper' ? 
                    $this->pathHelper . ucfirst($fileLoad) .'.php' :
                    $this->pathLibrary . ucfirst($fileLoad) .'.php';
                if (is_file($fileSetLoad)) {
                    include $fileSetLoad;
                }else{

                    $fileSetLoadError = $typeLoad == 'helper' ? 
                        $this->pathView . $config['helper_error_view'] .'.php' :
                        $this->pathView . $config['library_error_view'] .'.php';
                        
                    include  $fileSetLoadError;
                }
                
            }else{
                return false;
            }
        }

        public function view($viewFile = null, $dataView = []){

            include plugin_dir_path(__DIR__) .'config/config.php';

            $this->defaultView = $config['view_error_default'];
            $this->viewSet = $viewFile !== null ? $viewFile : $this->defaultView;
            $this->pathView = $config['base_path'] . $config['views_path'] . $this->viewSet .'.php';
            $this->pathView = is_file($this->pathView) ? 
                $this->pathView : $config['base_path'] . $config['views_path'] .  $this->defaultView .'.php';
            
            // check is view file exists
            if (count($dataView) > 0) {
                foreach ($dataView as $keyData => $valData) {
                    ${$keyData} = $valData;
                }
                if ($dataView !== null) {
                    $data = $dataView;
                }
            }
            
            include $this->pathView;

        }

        public function model($modelFile = null, $dataForModelConstruct = null){

            include plugin_dir_path(__DIR__) .'config/config.php';

            $this->defaultModelViewError = $config['model_error_view'];
            $this->modelSet = $modelFile;
            $this->pathModel = $config['base_path'] . $config['models_path'] . $this->modelSet .'.php';

            if (is_file($this->pathModel)) {

                include $this->pathModel;
                // check auto isntance class
                $classModelIns = "CT\\$this->modelSet";
                if ($dataForModelConstruct !== null) {
                    return new $classModelIns($dataForModelConstruct);
                } else {
                    return new $classModelIns();
                }

            } else {
                $this->view($this->defaultModelViewError);
            }
            
        }

        public function loadMenu(){
            add_action('admin_menu', array($this, 'set_menu_list'));
        }

        public function default_404(){
            
            // instances page 404
            include $this->bootstrap->base_controller_dir . 'Page_not_found.php';
            $pageNotFound  = new Ct_page_not_found();
            $pageNotFound->index();

        }

        public function set_menu_list(){

            $controllerData = $this->setUrlController;
            $controllerData = urldecode($controllerData);
            $getUrlSegment = explode('/', $controllerData);
            $controllerSet = isset($_GET['page']) && trim($_GET['page']) !== '' ? 
                $_GET['page'] : $this->config['controller_default'];

            $methodSet = isset($_GET['method']) && trim($_GET['method']) !== '' ? 
                $_GET['method'] : $this->config['method_default'];

            $realControllerName = ucfirst($controllerSet);
            $realControllerName = str_replace('-', '_', $realControllerName);

            include $this->bootstrap->base_config_dir . 'menuPages.php';

            //add menu by foreach all menu list item array
            // list main menu plugin
            $xCounterMenu = 0;
            foreach ($menu_list as $keyItem => $valueItem) {
                if ($valueItem['menu_item']['page_slug'] !== $controllerSet) {
                    add_menu_page(
                        $valueItem['menu_item']['page_title'], // Title of the page
                        $valueItem['menu_item']['page_menu_text'], // Text to show on the menu link
                        $valueItem['menu_item']['page_capability'], // Capability requirement to see the link
                        $valueItem['menu_item']['page_slug'], // The 'slug' - file to display when clicking the link,
                        $valueItem['menu_item']['page_render'],
                        $valueItem['menu_item']['page_menu_icon'], // icon plugin
                        $valueItem['menu_item']['page_menu_position']// item position
                    );
                }
                $xCounterMenu++;
            }

            // list sub main menu plugin
            $yCounterMenu = 0;
            foreach ($menu_list_sub as $keyItem => $valueItem) {

                if ($valueItem['menu_item']['page_slug'] !== $controllerSet) {
                    add_submenu_page(
                        $valueItem['menu_item']['page_slug_current'], // slug current menu
                        $valueItem['menu_item']['page_title'], // Title of the page
                        $valueItem['menu_item']['page_menu_text'], // Text to show on the menu link
                        $valueItem['menu_item']['page_capability'], // Capability requirement to see the link
                        $valueItem['menu_item']['page_slug'], // The 'slug' - file to display when clicking the link,
                        $valueItem['menu_item']['page_render'],
                        $valueItem['menu_item']['page_menu_position']// item position
                    );
                }
                $yCounterMenu++;
            }
        }

        public function loadInit($controllerData = null){

            $controllerData = urldecode($controllerData);
            $getUrlSegment = explode('/', $controllerData);
            $controllerSet = isset($_GET['page']) && trim($_GET['page']) !== '' ? 
                $_GET['page'] : $this->config['controller_default'];

            $methodSet = isset($_GET['method']) && trim($_GET['method']) !== '' ? 
                $_GET['method'] : $this->config['method_default'];

            $realControllerName = ucfirst($controllerSet);
            $realControllerName = str_replace('-', '_', $realControllerName);

            $controllerFileSet = $this->bootstrap->base_controller_dir . $realControllerName .'.php';

            if (file_exists($controllerFileSet)) {
                include_once $controllerFileSet;
                $instanceClassController = 'CT\\'. $realControllerName;
                $realControllerName =  new $instanceClassController();

                if(method_exists($realControllerName, $methodSet)){
                    $methodSet = $methodSet;
                }else{
                    $methodSet = $this->config['method_not_found'];
                }
            }

            // check type is sub or not. and getting information menu page item
            include $this->bootstrap->base_config_dir . 'menuPages.php';

            // check in is sub page menu or not or parent/current menu.
            $yCounterMenu = 0;
            $statusControllerpage = 'sub';
            $dataSetPageController = [];
            // first search in menu current
            foreach ($menu_list as $keyItem) {
                if($keyItem['menu_item']['page_slug'] == $controllerSet){
                    $dataSetPageController = $keyItem;
                    $statusControllerpage = 'current';
                    break;
                }
                $yCounterMenu++;
            }

            if($statusControllerpage == 'sub'){
                // first search in menu current
                foreach ($menu_list_sub as $keyItem) {
                    if($keyItem['menu_item']['page_slug'] == $controllerSet){
                        $dataSetPageController = $keyItem;
                        $statusControllerpage = 'sub';
                        break;
                    }
                    $yCounterMenu++;
                }
            }

            // set session for transfer data controller to func set load controller menu
            // validation if page tying to access controller or not.
            
            if ($statusControllerpage == 'sub') {

                if(isset($dataSetPageController['menu_item']['page_slug_current'])){
                    $_SESSION['controller_data_sub']  = [
                        'page_slug_current'     =>  $dataSetPageController['menu_item']['page_slug_current'],
                        'page_title'            =>  $dataSetPageController['menu_item']['page_title'], // Title of the page
                        'page_menu_text'        =>  $dataSetPageController['menu_item']['page_menu_text'], // Text to show on the menu link
                        'page_capability'       =>  $dataSetPageController['menu_item']['page_capability'], // Capability requirement to see the link
                        'page_slug'             =>  $dataSetPageController['menu_item']['page_slug'], // The 'slug' - file to display when clicking the link,
                        'page_render'           =>  array($realControllerName, $methodSet), // render view by controller
                        'page_menu_position'    =>  $dataSetPageController['menu_item']['page_menu_position']
                    ];
                    
                    $this->loadMenu();
                    add_action('admin_menu', array($this, 'setLoadControllerMenuSub'));
                }else{
                    $this->loadMenu();
                }

            } else {
                $_SESSION['controller_data_current']  = [
                    'page_title'            =>  $dataSetPageController['menu_item']['page_title'], // Title of the page
                    'page_menu_text'        =>  $dataSetPageController['menu_item']['page_menu_text'], // Text to show on the menu link
                    'page_capability'       =>  $dataSetPageController['menu_item']['page_capability'], // Capability requirement to see the link
                    'page_slug'             =>  $dataSetPageController['menu_item']['page_slug'], // The 'slug' - file to display when clicking the link,
                    'page_render'           =>  array($realControllerName, $methodSet), // render view by controller
                    'page_menu_icon'     =>  $dataSetPageController['menu_item']['page_menu_icon'],
                    'page_menu_position'    =>  $dataSetPageController['menu_item']['page_menu_position']
                ];
                add_action('admin_menu', array($this, 'setLoadControllerMenu'));
                $this->loadMenu();
            }

        }

        public function setLoadControllerMenu(){
            add_menu_page(
                $_SESSION['controller_data_current']['page_title'], // Title of the page
                $_SESSION['controller_data_current']['page_menu_text'], // Text to show on the menu link
                $_SESSION['controller_data_current']['page_capability'], // Capability requirement to see the link
                $_SESSION['controller_data_current']['page_slug'],
                $_SESSION['controller_data_current']['page_render'],
                $_SESSION['controller_data_current']['page_menu_icon'],
                $_SESSION['controller_data_current']['page_menu_position']
            );
        }

        public function setLoadControllerMenuSub(){
            add_submenu_page(
                $_SESSION['controller_data_sub']['page_slug_current'],
                $_SESSION['controller_data_sub']['page_title'], // Title of the page
                $_SESSION['controller_data_sub']['page_menu_text'], // Text to show on the menu link
                $_SESSION['controller_data_sub']['page_capability'], // Capability requirement to see the link
                $_SESSION['controller_data_sub']['page_slug'],
                $_SESSION['controller_data_sub']['page_render'],
                $_SESSION['controller_data_sub']['page_menu_position']
            );
        }

    }