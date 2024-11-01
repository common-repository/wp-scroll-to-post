<?php
$wspShowMessage = false;

if(isset($_POST['updateSettings'])){
    $wspSettingsInfo = array(
                                'wsp_parent_border_color' => (!empty($_POST['wsp_parent_border_color'])) ? sanitize_text_field($_POST['wsp_parent_border_color']) : '#FF9700',
                                'wsp_background_color' => (!empty($_POST['wsp_background_color'])) ? sanitize_text_field($_POST['wsp_background_color']) : '#F2F2F2',
                                'wsp_post_title_color' => (!empty($_POST['wsp_post_title_color'])) ? sanitize_text_field($_POST['wsp_post_title_color']) : '#FF9700',
                                'wsp_post_category' => sanitize_text_field($_POST['wsp_post_category'])
                            );
     $wspShowMessage = update_option('wsp_settings', serialize($wspSettingsInfo));
}
$wsp_settings = stripslashes_deep(unserialize(get_option('wsp_settings')));
?>
<div id="wsp-wrap-all" class="wrap">
    <div class="settings-banner">
        <h2><?php esc_html_e('WP Scroll to Posts', WSP_TXT_DOMAIN); ?></h2>
    </div>
    <?php if($wspShowMessage): $this->wsp_display_notification('success', 'Your information updated successfully.'); endif; ?>

    <form name="wsp-table" role="form" class="form-horizontal" method="post" action="" id="wsp-settings-form">
        <table class="form-table">
        <tr class="wsp_parent_border_color">
            <th scope="row">
                <label for="wsp_parent_border_color"><?php esc_html_e('Parent Border Color:', WSP_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <input class="wsp-wp-color" type="text" name="wsp_parent_border_color" id="wsp_parent_border_color" value="<?php echo esc_attr($wsp_settings['wsp_parent_border_color']); ?>">
                <div id="colorpicker"></div>
            </td>
        </tr>
        <tr class="wsp_background_color">
            <th scope="row">
                <label for="wsp_background_color"><?php esc_html_e('Background Color:', WSP_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <input class="wsp-wp-color" type="text" name="wsp_background_color" id="wsp_background_color" value="<?php echo esc_attr($wsp_settings['wsp_background_color']); ?>">
                <div id="colorpicker"></div>
            </td>
        </tr>
        <tr class="wsp_post_title_color">
            <th scope="row">
                <label for="wsp_post_title_color"><?php esc_html_e('Post Title Color:', WSP_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <input class="wsp-wp-color" type="text" name="wsp_post_title_color" id="wsp_post_title_color" value="<?php echo esc_attr($wsp_settings['wsp_post_title_color']); ?>">
                <div id="colorpicker"></div>
            </td>
        </tr>
        <tr class="wsp_post_category">
            <th scope="row">
                <label for="wsp_post_category"><?php esc_html_e('Post Category:', WSP_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <select class="medium-text" id="wsp_post_category" name="wsp_post_category">
                    <option value="">All Category</option>
                    <?php 
                    $wsp_args = array(  	'type'                     => 'post',
                                            'child_of'                 => 0,
                                            'parent'                   => '',
                                            'orderby'                  => 'name',
                                            'order'                    => 'ASC',
                                            'hide_empty'               => 1,
                                            'hierarchical'             => 1,
                                            'exclude'                  => '',
                                            'include'                  => '',
                                            'number'                   => '',
                                            'taxonomy'                 => 'category',
                                            'pad_counts'               => false 	
                                        ); 
                    $wsp_categories = get_categories( $wsp_args ); 
                    foreach( $wsp_categories as $cat ) :
                    ?>
                    <option <?php if( $cat->cat_ID == $wsp_settings['wsp_post_category'] ) echo 'selected'; ?> value="<?php echo esc_attr($cat->cat_ID); ?>"><?php echo esc_html($cat->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        </table>
        <p class="submit"><button id="updateSettings" name="updateSettings" class="button button-primary"><?php esc_attr_e('Update Settings', WSP_TXT_DOMAIN); ?></button></p>
    </form>
</div>