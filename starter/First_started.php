<?php

namespace CT;

class First_started
{

    public $dirPublicDefault = ABSPATH .'./ct-public/';
    public $dirUploadDefault = ABSPATH .'./ct-public/uploads/';

    public function __construct()
    {

        /*
        auto create folder in root wordpress
        - './ct-public/'
        - './ct-public/uploads/'
        */

        if(!is_dir($this->dirPublicDefault)){
            @mkdir($this->dirPublicDefault);
        }else {
            if(!is_dir($this->dirUploadDefault)){
                @mkdir($this->dirUploadDefault);
            }
        }

    }

    // Add Something
}

$First_started = new First_started();
                    