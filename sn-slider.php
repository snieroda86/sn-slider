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

			// Functions
			require_once(SN_SLIDER_PATH.'functions/functions.php');
			// Create admin menu
			add_action('admin_menu' , array($this , 'create_admin_menu') );
			// creste post type
			require_once(SN_SLIDER_PATH.'/post-types/class.sn-slider-cpt.php');
			$SN_Slider_Post_Type = new SN_Slider_Post_Type();

			// creste settings
			require_once(SN_SLIDER_PATH.'/class.sn-slider-settings.php');
			$SN_Slider_Settings = new SN_Slider_Settings();

			// slider shortcode
			require_once(SN_SLIDER_PATH.'/shortcodes/class.sn-slider-shortcode.php');
			$SN_Slider_Shortcode = new SN_Slider_Shortcode();

			// Enqueue scripts
			add_action('wp_enqueue_scripts' , array($this , 'register_scripts'),999 );

			// Admin scripts
			add_action('admin_enqueue_scripts' , array($this, 'register_admin_scripts'));

			
		}

		// Constans
		public function define_constants(){
			define('SN_SLIDER_PATH' , plugin_dir_path( __FILE__ ));
			define('SN_SLIDER_URL' , plugin_dir_url(__FILE__));
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
			delete_option( 'sn_slider_options' );
			// Remove all posts related with plugin
			$posts = get_posts( array(
				'post_type' => 'sn_slider' ,
				'number_posts' => -1 ,
				'post_status' => 'any'
			) );

			foreach ($posts as $post) {
				wp_delete_post( $post->ID , true);
			}
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
			if( ! current_user_can( 'manage_options' )){
				return;
			}
			// Messages
			if(isset($_GET['settings-updated'])){
				add_settings_error( 'sn_slider_options', 'sn_slider_message' , 'Settings Saved' , 'success' );
			}
			// Display messages
			settings_errors('sn_slider_options');
			require (SN_SLIDER_PATH.'/views/settings-page.php');
		}

		// Regitser scripts
		public function register_scripts(){
			// JS files
			wp_register_script( 'sn-slider-main-jq', SN_SLIDER_URL.'vendor/flex-slider/jquery.flexslider-min.js' , array('jquery'), SN_SLIDER_VERSION , true );
			
			// CSS files
			wp_register_style( 'sn-slider-main-css', SN_SLIDER_URL.'vendor/flex-slider/flexslider.css' , array() , SN_SLIDER_VERSION , 'all' );
			wp_register_style( 'sn-slider-style-css', SN_SLIDER_URL.'assets/css/frontend.css' , array() , SN_SLIDER_VERSION , 'all' );
		}

		// Admin scripts
		public function register_admin_scripts(){
			global $typenow;
			if($typenow =='sn_slider'){
				wp_enqueue_style( 'sn-slider-admin-style', SN_SLIDER_URL.'assets/css/admin.css' , array() , SN_SLIDER_VERSION , 'all' );	
			}
			
		}




	}
}

if( class_exists('SN_Slider')){

	register_activation_hook( __FILE__ , array('SN_Slider' , 'activate'));
	register_deactivation_hook( __FILE__ , array('SN_Slider' , 'deactivate'));
	register_uninstall_hook( __FILE__ , array('SN_Slider' , 'uninstall'));
	$sn_slider = new SN_Slider();
}