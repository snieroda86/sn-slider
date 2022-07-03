<?php

if(!class_exists('SN_Slider_Shortcode')){
	class SN_Slider_Shortcode{
		public function __construct(){
			add_shortcode( 'sn_slider', array($this , 'sn_slider_add_shortcode') );
		}

		public function sn_slider_add_shortcode($atts = [] , $content=null , $tag=''){
			$atts = array_change_key_case(array($atts , CASE_LOWER));
			extract(
				shortcode_atts( 
					array(
						'id' => '',
						'orderby' => 'date'
					),
					$atts,
					$tag
				)
			);

			if(!empty($id)){
				$id = array_map(absint(), explode(',', $id ));
			}

			// require slider html markup
			ob_start();
			require(SN_SLIDER_PATH.'views/sn-slider_shortcode.php');
			wp_enqueue_script('sn-slider-main-jq');
			wp_enqueue_script('sn-slider-options-js');
			wp_enqueue_style('sn-slider-main-css');
			wp_enqueue_style('sn-slider-style-css');
			return ob_get_clean();
		}
	}
}