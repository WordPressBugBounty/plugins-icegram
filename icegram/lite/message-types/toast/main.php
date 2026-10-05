<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( class_exists( 'Icegram_Message_Type_Toast' ) ) return;

/**
* Class Icegram Toast
*/
class Icegram_Message_Type_Toast extends Icegram_Message_Type {

	function __construct() {
		parent::__construct( dirname( __FILE__ ), plugins_url( '/', __FILE__ ) );
		add_filter( 'icegram_message_type_params_toast', array( $this, 'set_admin_style' ) );
		add_action( 'wp_head', array( $this, 'add_stand_out_inline_css' ), 999 );				
	}

	function add_stand_out_inline_css() {
		$image_url = ICEGRAM_PLUGIN_URL . 'lite/assets/images/stand-out.png';
		?>
		<style>
		.ig_toast.ig_stand-out.ig_container {
			background-image: -webkit-gradient(linear, left bottom, left top, color-stop(0, rgba(0, 0, 0, 0.1)), color-stop(1, rgba(255, 255, 255, 0.1))), url(<?php echo esc_url( $image_url ); ?>) !important;
			background-image: -moz-linear-gradient(bottom, rgba(0, 0, 0, 0.1) 0%, rgba(255, 255, 255, 0.1) 100%), url(<?php echo esc_url( $image_url ); ?>) !important;
			background-image: linear-gradient(to top, rgba(0, 0, 0, 0.1) 0%, rgba(255, 255, 255, 0.1) 100%), url(<?php echo esc_url( $image_url ); ?>) !important;
		}
		</style>
		<?php
	}


	function define_settings() {
		parent::define_settings();
		$this->settings['font-family']   		= '';	
		$this->settings['position']['values'] 	= array( '00', '01', '02', '11', '20', '21', '22' );	
		$this->settings['position']['default'] 	= '02';
		$this->settings['theme']['default']		= 'announce';
		unset ( $this->settings['text_color'],
				$this->settings['bg_color'],
				$this->settings['label'],
				$this->settings['embed_form']
				);
	}

	function set_admin_style( $params ) {

		$params['admin_style'] = array( 'label_bg_color' 		=> '#EDBB00',
										'theme_header_height'	=> '5em',
										'thumbnail_width' 		=> '43%',
										'thumbnail_height' 		=> '7.5em'
										);
		return $params;
	}
}