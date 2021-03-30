<?php
/**
 * CLA Workstation Ordering Application
 *
 * @package cla-wsorder
 * @since 0.1.0
 * @copyright Copyright (c) 2021, Texas A&M College of Liberal Arts IT
 * @author Zachary K. Watkins
 * @license GPL-2.0+
 */

// Initialize Genesis.
require_once get_template_directory() . '/lib/init.php';

// Define some useful constants.
define( 'CLA_THEME_DIRNAME', 'cla-wsorder' );
define( 'CLA_THEME_DIRPATH', get_stylesheet_directory() );
define( 'CLA_THEME_DIRURL', get_stylesheet_directory_uri() );
define( 'CLA_THEME_TEXTDOMAIN', 'cla-wsorder' );
define( 'CLA_THEME_TEMPLATE_PATH', CLA_THEME_DIRPATH . '/templates' );

// Autoload all classes.
require_once CLA_THEME_DIRPATH . '/src/class-cla-wsorder.php';
spl_autoload_register( 'CLA_WSOrder::autoload' );
CLA_WSOrder::get_instance();
