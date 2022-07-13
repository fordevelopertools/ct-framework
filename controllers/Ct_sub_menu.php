<?php

namespace CT;

class Ct_sub_menu Extends CT_controller
{

    public function __construct()
    {
        // Add Something
    }

    public function index(){

        $dataUsers = [
            'name'      =>  'Creative Toolbox',
            'message'   =>  'Welcome!, This is Sub Menu'
        ];

        $data['data_users'] = $dataUsers;

        $this->view('v_creative_toolbox_dashboard', $data);

    }
    
}