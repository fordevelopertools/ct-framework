<?php

namespace CT;

class Ct_creative_toolbox Extends CT_controller
{

    public function __construct()
    {
        // Add Something
    }

    public function index(){

        $dataUsers = [
            'name'      =>  'Creative Toolbox',
            'message'   =>  'Welcome'
        ];

        $data['data_users'] = $dataUsers;

        $this->view('v_creative_toolbox_dashboard', $data);

    }
    
}