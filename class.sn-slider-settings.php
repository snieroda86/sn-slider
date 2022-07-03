<?php 
if(! class_exists('SN_Slider_Settings')){
	class SN_Slider_Settings{
		public static $options;

		public function __construct(){
			self::$options = get_option('sn_slider_options');

			add_action('admin_init' , array($this , 'admin_init'));
		}

		// Create sections
		public function admin_init(){
			register_setting('sn_slider_group', 'sn_slider_options' , array($this , 'sn_slider_validate'));

			// Sections
			add_settings_section(
		        'sn_slider_main_section',
		        'How does it work?', 
		        NULL,
		        'sn_slider_page1'
		    );
		    add_settings_section(
		        'sn_slider_second_section',
		        'Other options', 
		        NULL,
		        'sn_slider_page2'
		    );
		    // Fields

		    add_settings_field(
			    'sn_slider_shortcode',
			    'Shortcode',
			    array($this , 'sn_slider_shortcode_callback'),
			    'sn_slider_page1',
			    'sn_slider_main_section'
			);
			add_settings_field(
			    'sn_slider_title',
			    'Slider title',
			    array($this , 'sn_slider_title_callback'),
			    'sn_slider_page2',
			    'sn_slider_second_section'
			);
			add_settings_field(
			    'sn_slider_bullets',
			    'Display bullets',
			    array($this , 'sn_slider_bullets_callback'),
			    'sn_slider_page2',
			    'sn_slider_second_section'
			);
			add_settings_field(
			    'sn_slider_style',
			    'Display style',
			    array($this , 'sn_slider_style_callback'),
			    'sn_slider_page2',
			    'sn_slider_second_section'
			);
		}

		// Shortcode display
		public function sn_slider_shortcode_callback(){
			?>
			<span>Use the shortcode [sn_slider] to display slider anywhere </span>
			<?php 
		}

		// Title section callback
		public function sn_slider_title_callback(){ ?>
			<input 
			type="text"
			name="sn_slider_options[sn_slider_title]"
			id="sn_slider_title"
			value="<?php echo isset( self::$options['sn_slider_title'] ) ? esc_attr( self::$options['sn_slider_title'] ) : ''; ?>"
			>
		<?php }

		// Display bullets
		public function sn_slider_bullets_callback(){ ?>
			<input 
			type="checkbox"
			name="sn_slider_options[sn_slider_bullets]"
			id="sn_slider_bullets"
			value="1"
			<?php 
			if(isset( self::$options['sn_slider_bullets'])){
				checked( '1' , self::$options['sn_slider_bullets'],  true );
			}
			?>
			>
			<label for="sn_slider_bullets">Check to show bullets</label>
		<?php }

		// Slider style callback
		public function sn_slider_style_callback(){ ?>
			<select 
			name="sn_slider_options[sn_slider_style]" 
			id="sn_slider_style">
				<option value="style-1"
				<?php isset(self::$options['sn_slider_style']) ? selected( 'style-1', self::$options['sn_slider_style'] , true ) : '';   ?>
				>Style 1</option>
				<option value="style-2"
				<?php isset(self::$options['sn_slider_style']) ? selected( 'style-2', self::$options['sn_slider_style'] , true ) : '';   ?>
				>Style 2</option>				
			</select>
		<?php }

		// Form fields validation 
		public function sn_slider_validate( $input){
			$new_input = array();

			foreach ($input as $key => $value) {
				switch ($key) {
				  case "sn_slider_title":
					  if(empty($value)){
					  	add_settings_error( 'sn_slider_options', 'sn_slider_message', 'Title field can not be empty.', 'error' );
					  	$value = __('Enter value here..' , 'sn-slider');
					  }
				    	$new_input[$key] = sanitize_text_field( $value );
				   break;
				  default:
				   $new_input[$key] = sanitize_text_field( $value );
				}
			}
			return $new_input;
		}
	}	
}
