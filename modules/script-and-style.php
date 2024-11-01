<?php
namespace gsdScriptAndStyle;
use \gsdScriptAndStyle\scriptAndStyle;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait scriptAndStyle {
	
	static function init(){
		
		$pages = array(
			'google-structured-data_page_gsd-local',
			'toplevel_page_gsd',
		);
		
		if (!in_array(get_current_screen()->base, $pages)) return; // DO NOT LOAD ANYTHING IF WERE NOT IN THE PLUGIN PAGES
	
		wp_enqueue_media();	// LOAD FILES MEDIA UPLOADER FOR SELECTING IMAGE BUSINESS GALLERY
		wp_enqueue_style( 'gsd-style', GSD_PLUGIN_PATH_URL . '/style.css', '1.0.0' ); // LOAD CSS STYLESHEETS
		wp_enqueue_script( 'gsd', GSD_PLUGIN_PATH_URL . '/main.js', array( 'jquery' ), '1.0.0' ); // LOAD JAVASCRIPT
			
	
	}
	
}
		