<?php
/**
 * Plugin Name:       SN Slider
 * Plugin URI:        https://www.web4you.biz.pl
 * Description:       Beautiful custom post slider
 * Version:           1.0
 * Requires at least: 5.6
 * Requires PHP:      7.2
 * Author:            Sebastian Nieroda
 * Author URI:        https://www.web4you.biz.pl
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sn-slider
 * Domain Path:       /languages
 */

if(!defined('ABSPATH')){
	exit;
}

if( ! class_exists('SN_Slider')){
	class SN_Slider{
		public function __construct(){
			$this->define_constants();
			// Create admin menu
			add_action('admin_menu' , array($this , 'create_admin_menu') );
			// creste post type
			require_once(SN_SLIDER_PATH.'/post-types/class.sn-slider-cpt.php');
			$post_types = new SN_Slider_Post_Type();
		}

		// Constans
		public function define_constants(){
			define('SN_SLIDER_PATH' , plugin_dir_path( __FILE__ ));
			define('SN_SLIDER_URL' , plugin_dir_path(__FILE__));
			define('SN_SLIDER_VERSION' , '1.0.0');
		}

		// Activate
		public static function activate(){ 
			update_option('rewrite_rules' , '');
		}

		// Deactivate
		public static function deactivate(){
			flush_rewrite_rules();
			unregister_post_type( 'sn_slider' );
		}

		// Uninstall
		public static function uninstall(){
			
		}

		// Create admin menu
		public function create_admin_menu(){
			add_menu_page(
		        __( 'SN Slider Options', 'sn-slider' ),
		        'SN Slider',
		        'manage_options',
		        'sn_slider_admin',
		        array($this , 'sn_slider_settings_page'),
		        'dashicons-images-alt2',
		        6
		    );

		    // Submenu page
		     add_submenu_page(
		        'sn_slider_admin',
		        __( 'SN Slider options page', 'sn-slider' ),
		        __( 'Manage slides', 'sn-slider' ),
		        'manage_options',
		        'edit.php?post_type=sn_slider',
		        null ,
		        null
		    );

		      // Submenu page
		     add_submenu_page(
		        'sn_slider_admin',
		        __( 'SN Slider options page', 'sn-slider' ),
		        __( 'Settings', 'sn-slider' ),
		        'manage_options',
		        'edit.php?post_type=sn_slider',
		        null ,
		        null
		    );
		}

		// Admin settings page callback
		public function sn_slider_settings_page(){
			require (SN_SLIDER_PATH.'/views/settings-page.php');
		}




	}
}

if( class_exists('SN_Slider')){

	register_activation_hook( __FILE__ , array('SN_Slider' , 'activate'));
	register_deactivation_hook( __FILE__ , array('SN_Slider' , 'deactivate'));
	register_uninstall_hook( __FILE__ , array('SN_Slider' , 'uninstall'));
	$sn_slider = new SN_Slider();
}