<?php

/*
Plugin Name: Contact Team Member
Plugin URI: http://theotherpole.com
Description: The best way to push users to contact you from your website.
Version: 1.3.3
Author: Jean-Christophe Perrin
Author URI: http://theotherpole.com
*/

// Copyright (c) 2016 The other pole. All rights reserved.
//
// Released under the GPL license 2 or later
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************

define( 'CTM_FILE_PATH', plugin_dir_path(__FILE__) );

define( 'CTM_DIR_NAME',  basename( CTM_FILE_PATH ) );

define( 'CTM_DIR_TEMPLATE',  'templates' );
define( 'CTM_URL_TEMPLATE',  plugins_url('/' . CTM_DIR_TEMPLATE, __FILE__) );

define( 'CTM_DIR_INCLUDES',  CTM_FILE_PATH . 'includes' . '/' );

define( 'CTM_DIR_SCRIPTS',  'js' );
define( 'CTM_URL_SCRIPTS',  plugins_url('/library/' . CTM_DIR_SCRIPTS, __FILE__));

define( 'CTM_DIR_STYLES',  'css' );
define( 'CTM_URL_STYLES',  plugins_url('/library/' . CTM_DIR_STYLES, __FILE__) );

/* CTM CORE */

require_once(CTM_DIR_INCLUDES . 'class.contact-team-member-core.php');
require_once(CTM_DIR_INCLUDES . 'class.contact-team-member.php');

register_activation_hook( __FILE__, array( 'CTM', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'CTM', 'plugin_deactivation' ) );
add_action( 'init', array( 'ContactTeamMember', 'init' ) );

/* CTM ADMIN */

require_once( CTM_DIR_INCLUDES . 'class.contact-team-member-admin.php' );
add_action( 'init', array( 'ContactTeamMemberAdmin', 'init' ) );
