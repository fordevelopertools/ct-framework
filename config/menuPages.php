<?php

// register parent menu
$menu_list = [];

$menu_list[] = [
    'menu_item' =>  [
        'page_title'            =>  'Creative Toolbox', // Title of the page
        'page_menu_text'        =>  'Creative Toolbox', // Text to show on the menu link
        'page_capability'       =>  'manage_options', // Capability requirement to see the link
        'page_slug'             =>  'ct-creative-toolbox', // The 'slug' - file to display when clicking the link,
        'page_render'           =>  array($this, 'default_404'), // render view by controller
        'page_menu_icon'        =>  $this->config['plugin_icon_url'], // icon plugin
        'page_menu_position'    =>   15 // position
    ]
];

// register submenu
$menu_list_sub = [];

$menu_list_sub[] = [
    'menu_item' =>  [
        'page_slug_current'     =>  'ct-creative-toolbox', // parent slug
        'page_title'            =>  'Sub Menu', // Title of the page
        'page_menu_text'        =>  'Sub Menu', // Text to show on the menu link
        'page_capability'       =>  'manage_options', // Capability requirement to see the link
        'page_slug'             =>  'ct-sub-menu', // The 'slug' - file to display when clicking the link,
        'page_render'           =>  array($this, 'default_404'), // render view by controller
        'page_menu_position'    =>  16 // position
    ]
];

#---------------- (start) ctx ------------------
#- don't delete or edit comments "#- ctxgenerate" from start to end ctx
#-ctxgenerate
#---------------- (end) ctx --------------------

// set globals config
$GLOBALS['CT_PAGEMENU'] = $menu_list;
$GLOBALS['CT_SUBPAGEMENU'] = $menu_list_sub;
