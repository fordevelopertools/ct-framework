<?php

namespace CT\Ctx;

class CtxActions extends CtxFuncsReady
{
    public $argv;
    public $CtxVersion  = '0.0.1';
    public $CtxDev = 'ForDeveloperTools';
    public $CtxSite = 'https://github.com/fordevelopertools/';

    public function __construct($argv = null)
    {
        $this->argv = $argv;
    }

    public function goAction()
    {
        $msg  = '';

        function setMsgClean($msg){
            return trim(preg_replace('/\t/', '', $msg));
        };

        // go action
        if ($this->argv !== null) {
            
            // serve
            if (
                isset($this->argv[1]) && 
                trim($this->argv[1]) !== '' && 
                trim($this->argv[1]) == 'serve'
            ) {

                $setPort = isset($this->argv[2]) ? trim($this->argv[2]) : ''; 
                $specDirRoot = isset($this->argv[3]) ? trim($this->argv[3]) : ''; 
                $this->serve($setPort, $specDirRoot);
                echo "\n";

            }
            
            // command list
            elseif (
                isset($this->argv[1]) && 
                trim($this->argv[1]) !== '' && 
                trim($this->argv[1]) == '-clist'
            ) {
                $msg = $this->loadListCommands();
                echo $msg;
                echo "\n";
            }

            // create
            elseif (
                isset($this->argv[1]) && 
                trim($this->argv[1]) !== '' && 
                trim($this->argv[1]) == '-create'
            ) {
                $this->create('', $this->argv);
                echo "\n";
            }

            // routing page & menu
            elseif (
                isset($this->argv[1]) && 
                trim($this->argv[1]) !== '' && 
                trim($this->argv[1]) == '-routing'
            ) {
                $this->routing($this->argv);
                echo "\n";
            }
            
            // ADD SOMETHING
            
            else{
                $msg = $this->loadDefaultMessage();
                echo $msg;
                echo "\n";
            }

        } else{
            echo 'Please set action.';
        }

    }
}
