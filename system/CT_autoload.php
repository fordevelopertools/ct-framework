<?php


namespace CT;

class CT_autoload
{
    public $config;
    public $bootstrap;
    public $openDirLibraries;
    public $openDirHelpers;
    public $openDirStarter;
    public $pathHelper;
    public $pathLibrary;
    public $pathView;

    public function __construct()
    {

        $this->config = $GLOBALS['CT_CONFIG'];
        $this->bootstrap = new \stdClass();

        $this->bootstrap->base_system_dir = $this->config['base_path'] . $this->config['system_path'];
        $this->bootstrap->base_config_dir = $this->config['base_path'] . $this->config['config_path'];
        $this->bootstrap->base_library_dir = $this->config['base_path'] . $this->config['libraries_path'];
        $this->bootstrap->base_helper_dir = $this->config['base_path'] . $this->config['helpers_path'];
        $this->bootstrap->base_controller_dir = $this->config['base_path'] . $this->config['controllers_path'];
        $this->bootstrap->base_model_dir = $this->config['base_path'] . $this->config['models_path'];
        $this->bootstrap->base_view_dir = $this->config['base_path'] . $this->config['views_path'];
        $this->bootstrap->base_starter_dir = $this->config['base_path'] . $this->config['starter_path'];

    }

    public function loadAllAutoloads()
    {

        include $this->bootstrap->base_config_dir . "autoload.php";
        $this->openDirLibraries = $autoload['libraries'];
        $this->openDirHelpers = $autoload['helpers'];
        $this->openDirStarter = $autoload['starter'];

        // check starter and includes
        if (is_array($this->openDirStarter) && count($this->openDirStarter) > 0) {
            foreach ($this->openDirStarter as $key => $strtrFileName) {
                // check file exits
                $fileSetStrtr = $this->bootstrap->base_starter_dir . ucfirst($strtrFileName) . '.php';
                if (is_file($fileSetStrtr)) {
                    include $fileSetStrtr;
                } else {
                    include $this->bootstrap->base_view_dir . $this->config['starter_error_view'] . '.php';
                }
            }
        }

        // check libraries and includes
        if (is_array($this->openDirLibraries) && count($this->openDirLibraries) > 0) {
            foreach ($this->openDirLibraries as $key => $libFileName) {
                // check file exits
                $fileSetLib = $this->bootstrap->base_library_dir . ucfirst($libFileName) . '.php';
                if (is_file($fileSetLib)) {
                    include $fileSetLib;
                } else {
                    include $this->bootstrap->base_view_dir . $this->config['library_error_view'] . '.php';
                }
            }
        }

        // check helpers and includes
        if (is_array($this->openDirHelpers) && count($this->openDirHelpers) > 0) {
            foreach ($this->openDirHelpers as $key => $hlpFileName) {
                // check file exits
                $fileSetHlp = $this->bootstrap->base_helper_dir . ucfirst($hlpFileName) . '.php';
                if (is_file($fileSetHlp)) {
                    include $fileSetHlp;
                } else {
                    include $this->bootstrap->base_view_dir . $this->config['helper_error_view'] . '.php';
                }
            }
        }
    }

    public function set($fileLoad = null, $typeLoad = null)
    {

        $this->pathHelper = $this->config['base_path'] . $this->config['helpers_path'];
        $this->pathLibrary = $this->config['base_path'] . $this->config['libraries_path'];
        $this->pathView = $this->config['base_path'] . $this->config['views_path'];

        if ($typeLoad !== null && $fileLoad !== null) {
            // check load type
            // check file exits
            $fileSetLoad = $typeLoad == 'helper' ?
                $this->pathHelper . ucfirst($fileLoad) . '.php' :
                $this->pathLibrary . ucfirst($fileLoad) . '.php';
            if (is_file($fileSetLoad)) {
                include $fileSetLoad;
            } else {

                $fileSetLoadError = $typeLoad == 'helper' ?
                    $this->pathView . $this->config['helper_error_view'] . '.php' :
                    $this->pathView . $this->config['library_error_view'] . '.php';

                include  $fileSetLoadError;
            }
        } else {
            return false;
        }
    }
}
