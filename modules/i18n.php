<?php
namespace gsdI18n;
use \gsdI18n\i18n;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait i18n {
	
	static function myplugin_load_textdomain() {
		load_plugin_textdomain( 'gsd', false, GSD_PLUGIN_PATH . '/languages' ); 
	}

}
