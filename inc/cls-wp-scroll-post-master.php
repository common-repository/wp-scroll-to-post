<?php
/**
 * Our main plugin class
*/
class WSP_Master {

	protected $wsp_loader;
	protected $wsp_version;

	/**
	 * Class Constructor
	*/
	function __construct(){
		$this->wsp_version = WSP_VERSION;
		add_action('plugins_loaded', array($this, 'wsp_load_plugin_textdomain'));
		$this->wsp_load_dependencies();
		$this->wsp_trigger_admin_hooks();
		$this->wsp_trigger_front_hooks();
	}

	function wsp_load_plugin_textdomain(){
		load_plugin_textdomain( WSP_TXT_DOMAIN, FALSE, WSP_TXT_DOMAIN . '/languages/' );
	}

	private function wsp_load_dependencies(){
		require_once WSP_PATH . 'admin/' . WSP_CLS_PRFX . '-admin.php';
		require_once WSP_PATH . 'front/' . WSP_CLS_PRFX . '-front.php';
		require_once WSP_PATH . 'inc/' . WSP_CLS_PRFX . '-loader.php';
		$this->wsp_loader = new WSP_Loader();
	}

	private function wsp_trigger_admin_hooks(){
		$wsp_admin = new WSP_Admin($this->wsp_version());
		$this->wsp_loader->add_action( 'admin_menu', $wsp_admin, WSP_PRFX . 'admin_menu' );
		$this->wsp_loader->add_action( 'admin_enqueue_scripts', $wsp_admin, WSP_PRFX . 'enqueue_assets' );
	}

	function wsp_trigger_front_hooks(){
		$wsp_front = new WSP_Front($this->wsp_version());
		$this->wsp_loader->add_action( 'wp_enqueue_scripts', $wsp_front, WSP_PRFX . 'front_assets' );
		$this->wsp_loader->add_action( 'wp_ajax_load_scroll_post', $wsp_front, WSP_PRFX . 'load_scroll_post' );
		$this->wsp_loader->add_action( 'wp_ajax_nopriv_load_scroll_post', $wsp_front, WSP_PRFX . 'load_scroll_post' );
		$this->wsp_loader->add_action( 'wp_footer', $wsp_front, WSP_PRFX . 'load_view' );
		//$wsp_front->wsp_load_shortcode();
	}

	function wsp_run(){
		$this->wsp_loader->wsp_run();
	}

	function wsp_version(){
		return $this->wsp_version;
	}

	function wsp_unregister_settings(){
		global $wpdb;
	
		$tbl = $wpdb->prefix . 'options';
		$search_string = WSP_PRFX . '%';
		
		$sql = $wpdb->prepare( "SELECT option_name FROM $tbl WHERE option_name LIKE %s", $search_string );
		$options = $wpdb->get_results( $sql , OBJECT );
	
		if(is_array($options) && count($options)) {
			foreach( $options as $option ) {
				delete_option( $option->option_name );
				delete_site_option( $option->option_name );
			}
		}
	}
}
?>
