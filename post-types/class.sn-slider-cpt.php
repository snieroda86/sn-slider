<?php 

if(!class_exists('SN_Slider_Post_Type')){
	class SN_Slider_Post_Type{

		public function __construct(){
			add_action( 'init' , array($this , 'create_post_type'));
			add_action( 'add_meta_boxes' , array($this , 'create_meta_boxes') );
			add_action( 'save_post', array($this , 'save_post_meta') );
			add_filter('manage_sn_slider_posts_columns' , array($this , 'sn_slider_cpt_columns'));
			add_action('manage_sn_slider_posts_custom_column' , array($this , 'sn_slider_custom_columns') , 10 , 2);
			add_filter('manage_edit-sn_slider_sortable_columns' , array($this , 'sn_slider_sortable_columns'));
		}

		// Register pos type
		public function create_post_type(){
			register_post_type( 'sn_slider',
		    // CPT Options
		        array(
		            'labels' => array(
		                'name' => __( 'SN Slider' ),
		                'singular_name' => __( 'Slider' )
		            ),
		            'supports' => array( 'title', 'editor', 'thumbnail'),
		            'hierarchical'        => false,
			        'public'              => true,
			        'show_ui'             => true,
			        'show_in_menu'        => false,
			        'show_in_nav_menus'   => true,
			        'show_in_admin_bar'   => true,
			        'menu_position'       => 5,
			        'can_export'          => true,
			        'has_archive'         => false,
			        'exclude_from_search' => false,
			        'publicly_queryable'  => true,
			        'capability_type'     => 'post',
			        'show_in_rest' 		  => false,
			        'menu_icon' 		  => 'dashicons-slides'
			  
		  
		        )
		    );
		}

		/*Create meta box*/
		public function create_meta_boxes(){
			add_meta_box(
	            'sn_slider_meta_box',                 // Unique ID
	            'Slide button link',      // Box title
	            array($this , 'add_inner_meta_box'),  // Content callback, must be of type callable
	            'sn_slider'  ,                         // Post type
	            'normal' ,
	            'high'
	        );
		}
		// Metabox html
		public function add_inner_meta_box( $post ){
			require_once(SN_SLIDER_PATH.'/views/sn-slider_meta_box.php');
		}

		// Save post meta
		public function save_post_meta($post_id ){
			// Verify nonce 
			if(isset($_POST['sn_slider_nonce'])){
				if(! wp_verify_nonce( $_POST['sn_slider_nonce'] , 'sn_slider_nonce' )){
					return;
				}
			}

			// Check doing autosave
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
				return;
			}

			// Check post type
			if(isset($_POST['post_type']) && $_POST['post_type']==='sn_slider'){
				if( ! current_user_can( 'edit_post' , $post_id )){
					return;
				}elseif(! current_user_can( 'edit_page' , $post_id )){
					return;
				}
			}


			if(isset($_POST['action']) && $_POST['action'] == 'editpost'){
				$old_link_text = get_post_meta( $post_id, 'sn_slider_link_text', true );
				$old_link_url = get_post_meta( $post_id, 'sn_slider_link_url', true );
				$new_link_text =sanitize_text_field( $_POST['sn_slider_link_text'] ) ;
				$new_link_url = sanitize_text_field( $_POST['sn_slider_link_url'] );

				// Update link text
				if ( empty( $new_link_text )) {
			        update_post_meta(
			            $post_id,
			            'sn_slider_link_text',
			            'Button label here' 
			        );
			    }else{
			    	 update_post_meta(
			            $post_id,
			            'sn_slider_link_text',
			            $_POST['sn_slider_link_text'] ,
			            $old_link_text
			        );
			    }

			    // Update link url
				if ( empty( $new_link_url ) ) {
			        update_post_meta(
			            $post_id,
			            'sn_slider_link_url',
			            'Button url here...'
			        );
			    }else{
			    	 update_post_meta(
			            $post_id,
			            'sn_slider_link_url',
			            $_POST['sn_slider_link_url'] ,
			            $old_link_url
			        );
			    }
			}
		}

		// SN slider cpt columns
		public function sn_slider_cpt_columns($columns){
			$columns['sn_slider_link_text'] = esc_html__( 'Link text', 'sn-slider' );
			$columns['sn_slider_link_url'] = esc_html__( 'Link url', 'sn-slider' );

			return $columns;
		}

		// Slider  custom columns values display
		public function sn_slider_custom_columns( $column , $post_id ){
			switch ($column) {
			  case "sn_slider_link_text":
			    echo esc_html(get_post_meta( $post_id, 'sn_slider_link_text', true ) );
			  break;
			  case "sn_slider_link_url":
			    echo esc_url(get_post_meta( $post_id, 'sn_slider_link_url', true ) );
			  break;
			  
			  default:
			    echo "";
			}
		}

		// Slider columns sortable
		public function sn_slider_sortable_columns( $columns ){
			$columns['sn_slider_link_text'] = 'sn_slider_link_text';
			return $columns;
		}


	}
}
