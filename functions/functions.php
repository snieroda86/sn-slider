<?php 

if( ! function_exists('sn_slider_options')){
	function sn_slider_options(){
		$show_bullets = isset(SN_Slider_Settings::$options['sn_slider_bullets']) && SN_Slider_Settings::$options['sn_slider_bullets'] == 1 ? true : false ;

		wp_enqueue_script( 'sn-slider-options-js', SN_SLIDER_URL.'vendor/flex-slider/flexslider.js' , array('jquery'), SN_SLIDER_VERSION , true );
		wp_localize_script( 'sn-slider-options-js', 'SLIDER_OPTIONS', array(
			'controlNav' => $show_bullets
		) );
	}	
}
