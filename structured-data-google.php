<?php
/**
 * Plugin Name:			Structured data Google
 * Description:			Add Google Structured data to your website, local map, opening hours, contact information with json data only avialble for google.
 * Version:				1.0.0
 * Author:				Oren Hahiashvili
 * Author URI:			https://www.script.co.il
 * Requires at least:	3.5.0
 * Tested up to:		5.2.1
 *
 * Text Domain: gsd
 * Domain Path: /languages/
 *
 */

namespace gsd;

if (!defined('GSD_PLUGIN_PATH_URL')){
	define('GSD_PLUGIN_PATH_URL', plugin_dir_url( __FILE__ ) );
}

if (!defined('GSD_PLUGIN_PATH')){
	define('GSD_PLUGIN_PATH', basename( dirname( __FILE__ ) ) );
}


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$modulesToLoad = array(
	'parameters',
	'script-and-style',
	'organization',
	'local-business',
	'i18n',
	'admin-panel',
);

foreach ($modulesToLoad as $module){
	include_once dirname(__FILE__) . '/modules/' . $module . '.php';
}


class google_structured_data {


   		
	public static $organiztion_parameters,
	$local_business_parameters,
	$local_business_types,
	$organiztion_phone_types = array();
	
	
    
	function __construct() {
		
		\gsdParameters\parameters::defaultParams();
		\gsdParameters\parameters::setParamsValues();
		\gsdAdminPanel\adminPanel::init();


	}

}


new google_structured_data;