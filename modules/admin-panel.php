<?php
namespace gsdAdminPanel;
use \gsdAdminPanel\adminPanel;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait adminPanel {
	

	static function admin_menu() {
		
		
		add_menu_page(
			__('Organization settings', 'gsd'),
			__('Google Structured data', 'gsd'),
			'manage_options',
			'gsd',
			'\gsdOrganiztion\organiztion::settings_page');

		add_submenu_page( 'gsd', __('Local business settings', 'gsd'), __('Local business', 'gsd'), 'manage_options', 'gsd-local', '\gsdLocalBusiness\localBusiness::settings_local' );
	}
	
	static function init(){
				
		add_action( 'admin_menu', '\gsdAdminPanel\adminPanel::admin_menu' );
		add_action( 'init', '\gsdI18n\i18n::myplugin_load_textdomain' );
		add_action( 'wp_head', '\gsdOrganiztion\organiztion::load_front_gsd_organization' );
		add_action( 'wp_head', '\gsdLocalBusiness\localBusiness::load_front_gsd_local_business' );
		add_action('admin_enqueue_scripts', '\gsdScriptAndStyle\scriptAndStyle::init');

	}

	
}



