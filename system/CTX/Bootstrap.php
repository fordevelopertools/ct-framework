<?php

namespace CT\Ctx;

class Bootstrap
{
    public $argv;

    public function __construct($argv = null)
    {
        $this->argv = $argv;
    }

    public function default_404()
    {
        // ADD SOMETHING
    }

    public function system()
    {
        // include config
        include __DIR__ .'/../../config/config.php';
        // CTX Functions is Ready
        include __DIR__ .'/CtxFuncsReady.php';
        // go action by command line
        include __DIR__ .'/CtxActions.php';

        // run ctx commands
        $ctxActions = new CtxActions($this->argv);
        $ctxActions->goAction();

    }
}
