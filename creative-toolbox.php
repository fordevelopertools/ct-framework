<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area.
 *
 * @link              https://github.com/fordevelopertools
 * @since             1.0.0
 * @package           Creative_Toolbox
 *
 * @wordpress-plugin
 * Plugin Name:       Creative Toolbox
 * Plugin URI:        https://github.com/fordevelopertools
 * Description:       Thank you for using Creative-Toolbox. Get started for your creative application :)
 * Version:           1.0.0
 * Author:            ForDeveloperTools
 * Author URI:        https://github.com/fordevelopertools
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 */

use CT\CT_bootstrap;

 // If this file is called directly, abort.
if (! defined( 'WPINC' )) {
    die;
}

include_once __DIR__ .'/system/Bootstrap.php';

// load system
$bootstrap = new CT_bootstrap();
$bootstrap->load();



