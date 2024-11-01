<?php
/**
*	Admin Parent Class
*/
class WSP_Admin 
{	
	private $wsp_version;
	private $wsp_assets_prefix;

	function __construct( $version ){
		$this->wsp_version = $version;
		$this->wsp_assets_prefix = substr(WSP_PRFX, 0, -1) . '-';
	}
	
	/**
	*	Loading the admin menu
	*/
	public function wsp_admin_menu(){
		
		add_menu_page(	esc_html__('Scroll To Post', WSP_TXT_DOMAIN),
						esc_html__('Scroll To Post', WSP_TXT_DOMAIN),
						'manage_options', // area of the admin panel
						'wsp-admin-panel',
						array( $this, WSP_PRFX . 'load_admin_panel' ),
						'',
						100 
					);
	}
	
	/**
	*	Loading admin panel assets
	*/
	function wsp_enqueue_assets(){
		if (isset($_GET['page']) && $_GET['page'] == 'wsp-admin-panel'){
			wp_enqueue_style(
								$this->wsp_assets_prefix . 'admin-style',
								WSP_ASSETS . 'css/' . $this->wsp_assets_prefix . 'admin-style.css',
								array(),
								$this->wsp_version,
								FALSE
							);
			
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');

			if ( !wp_script_is( 'jquery' ) ) {
				wp_enqueue_script('jquery');
			}
			wp_enqueue_script(
								$this->wsp_assets_prefix . 'admin-script',
								WSP_ASSETS . 'js/' . $this->wsp_assets_prefix . 'admin-script.js',
								array('jquery'),
								$this->wsp_version,
								TRUE
							);
			$wspAdminArray = array(
				'wspIdsOfColorPicker' => array('#wsp_post_title_color', '#wsp_parent_border_color', '#wsp_background_color')
			);
			
			// handler, jsObject, data
			wp_localize_script( 'wsp-admin-script', 'wspAdminScript', $wspAdminArray );
		}
	}
	
	/**
	*	Loading admin panel view/forms
	*/
	function wsp_load_admin_panel(){
		require_once WSP_PATH . 'admin/view/' . $this->wsp_assets_prefix . 'settings.php';
	}

	protected function wsp_display_notification($type, $msg){ ?>
		<div class="wsp-alert <?php printf('%s', $type); ?>">
			<span class="wsp-closebtn">&times;</span> 
			<strong><?php esc_html_e(ucfirst($type), WSP_TXT_DOMAIN); ?>!</strong> <?php esc_html_e($msg, WSP_TXT_DOMAIN); ?>
		</div>
	<?php }
}
?>