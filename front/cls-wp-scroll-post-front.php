<?php
/**
*	Front Parent Class
*/
class WSP_Front 
{	
	private $wsp_version;

	function __construct( $version ){
		$this->wsp_version = $version;
		$this->wsp_assets_prefix = substr(WSP_PRFX, 0, -1) . '-';
	}
	
	function wsp_front_assets(){
		$wsp_settings = stripslashes_deep(unserialize(get_option('wsp_settings')));
		wp_enqueue_style(	'wsp-front-style',
							WSP_ASSETS . 'css/' . $this->wsp_assets_prefix . 'front-style.css',
							array(),
							$this->wsp_version,
							FALSE );
		if(is_array($wsp_settings)){
			$wspTitleColor = (esc_attr($wsp_settings['wsp_post_title_color'])!='') ? esc_attr($wsp_settings['wsp_post_title_color']) : '#242424';
			$wspParentBorderColor = (esc_attr($wsp_settings['wsp_parent_border_color'])!='') ? esc_attr($wsp_settings['wsp_parent_border_color']) : '#242424';
			$wspBgColor = (esc_attr($wsp_settings['wsp_background_color'])!='') ? esc_attr($wsp_settings['wsp_background_color']) : '#F2F2F2';
		} else{
			$wspTitleColor = "#242424";
			$wspParentBorderColor = "#242424";
			$wspBgColor = "#F2F2F2";
		}
		$wspCustomCss = "	#wsp_scroll_box{
								border-left: 1px solid {$wspParentBorderColor};
								border-top: 1px solid {$wspParentBorderColor};
								-moz-box-shadow: 0 0 15px {$wspParentBorderColor};
								-webkit-box-shadow: 0 0 15px {$wspParentBorderColor};
								box-shadow: 0 0 15px {$wspParentBorderColor};
								background: {$wspBgColor};
							}
							.wsp-content-parent .wsp-content a.wsp-title{
								color: {$wspTitleColor}!important;
							}
							";
		wp_add_inline_style( 'wsp-front-style', $wspCustomCss );

		// =======================================
		if ( !wp_script_is( 'jquery' ) ) {
			wp_enqueue_script('jquery');
		}
		wp_enqueue_script(  'wsp-front-script',
							WSP_ASSETS . 'js/wsp-front-script.js',
							array('jquery'),
							$this->wsp_version,
							TRUE );
		
		wp_localize_script( 'wsp-front-script', 'wsAjaxObject', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	}

	function wsp_load_shortcode(){
		add_shortcode( 'wp_scroll_post', array( $this, 'wsp_load_shortcode_view' ) );
	}
	
	function wsp_load_shortcode_view($wspAttr){
		$output = '';
		ob_start();
		include WSP_PATH . 'front/view/' . $this->wsp_assets_prefix . 'front-view.php';
		$output .= ob_get_clean();
		return $output;
	}

	function wsp_load_view(){
		include WSP_PATH . 'front/view/' . $this->wsp_assets_prefix . 'front-view.php';
	}

	function wsp_load_scroll_post(){
		if(is_array(stripslashes_deep(unserialize(get_option('wsp_settings'))))){
			$wsp_settings = stripslashes_deep(unserialize(get_option('wsp_settings')));
			$displayCategory = (isset($wsp_settings[ 'wsp_post_category' ])) ? $wsp_settings[ 'wsp_post_category' ] : 'Uncategorized';
		} else{
			$displayCategory = "Uncategorized";
		}
		$wspArgs = array(
			'cat' => $displayCategory, //category_name
			'post_type' => 'post',
			'orderby'   => 'rand',
			'posts_per_page' => 1
			);
		 
		$wspTheQuery = new WP_Query( $wspArgs );
		 
		if ( $wspTheQuery->have_posts() ) { ?>
		 
			<div class="wsp-content-parent">
			<?php while ( $wspTheQuery->have_posts() ) { $wspTheQuery->the_post(); ?>
				<div class="wsp-thumbnail">
					<?php 
					if(has_post_thumbnail()):
						the_post_thumbnail( 'thumbnail' ); 
					else: ?>
						<img src="<?php echo WSP_ASSETS . 'img/wp-default.png'; ?>">
					<?php endif; ?>
				</div>
				<div class="wsp-content">
					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="wsp-title">
						<?php the_title(); ?>
					</a>
					<p class="wsp-time-category">
						<?php echo the_time('M d, Y'); ?> | <?php the_category(', ') ?>
					</p>
				</div>
			<?php } ?>
			</div>
			<?php
			wp_reset_postdata();
		} else {
			echo "no posts found";
		}
		die();
	}
}
?>