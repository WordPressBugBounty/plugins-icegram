<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( 'ig_campaign' == $post->post_type && ( get_option( 'ig_new_admin_ui_icegram' ) !== 'yes' ) ) { 
	
    $icegram_dismiss_url = add_query_arg( 
        array(
            'ig_dismiss_admin_notice' => '1',
            'ig_option_name' => 'ig_new_admin_ui',
            'ig_nonce' => wp_create_nonce( 'ig_dismiss_notice' )
        )
    ); 
	
	$icegram_contact_us = 'https://www.icegram.com/contact/';
	?>
    <div class="notice notice-success is-dismissable">
        <p>
            <?php echo wp_kses_post(' <strong>New:</strong> We are revamping the admin UI of the campaign setting. <strong><a target="_blank" href="' . $icegram_dismiss_url . '" >Here is</a></strong> the sneak-peek of it. Feel free to provide your feedback <strong><a target="_blank" href="' . $icegram_contact_us . '" >here</a></strong>'); ?>
        </p>
    </div>

<?php } ?>