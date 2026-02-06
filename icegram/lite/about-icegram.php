<?php
/*
 * About Icegram
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Actions for support
add_action( 'admin_footer', 'icegram_support_ticket_content' );

function icegram_support_ticket_content() {
    global $current_user, $pagenow, $typenow, $icegram;
    $headers = '';
    if ( $pagenow != 'edit.php' ) return;
    if ( $typenow != 'ig_campaign') return;
    if ( !( $current_user instanceof WP_User ) || !current_user_can( 'manage_options' )) return;

    if( isset( $_POST['submit_query'] ) && $_POST['submit_query'] == "Send" && !empty($_POST['client_email'])){
        check_admin_referer( 'icegram-submit-query' );
        $additional_info = ( isset( $_POST['additional_information'] ) && ! empty( $_POST['additional_information'] ) ) ? sanitize_text_field( wp_unslash( $_POST['additional_information'] ) ) : '';
        $additional_info = str_replace( '###', '<br />', $additional_info );
        $additional_info = str_replace( array( '[', ']' ), '', $additional_info );

        $from = 'From: ';
        $from .= ( isset( $_POST['client_name'] ) && ! empty( $_POST['client_name'] ) ) ? sanitize_text_field( wp_unslash( $_POST['client_name'] ) ) : '';
        $from .= isset( $_POST['client_email'] ) ? ' <' . sanitize_email( wp_unslash( $_POST['client_email'] ) ) . '>' . "\r\n" : '';
        $headers .= $from;
        $headers .= str_replace('From: ', 'Reply-To: ', $from);
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        
        $message = isset( $_POST['message'] ) ? $additional_info . '<br /><br />'.nl2br(sanitize_text_field(wp_unslash( $_POST['message'] ) )) : '';
        $subject = isset( $_POST['subject'] ) ? sanitize_text_field(wp_unslash( $_POST['subject'] )) : '';

        $http_referer = wp_get_referer(); 
        
        wp_mail( 'hello@icegram.com', $subject, $message, $headers ); 
        header('Location: ' . $http_referer );

    }
    ?>
    <div id="icegram_post_query_form" style="display: none;">
        <?php

            if ( !wp_script_is('jquery') ) {
                wp_enqueue_script('jquery');
                wp_enqueue_style('jquery');
            }

            $first_name = get_user_meta($current_user->ID, 'first_name', true);
            $last_name = get_user_meta($current_user->ID, 'last_name', true);
            $name = $first_name . ' ' . $last_name;
            $customer_name = ( !empty( $name ) ) ? $name : $current_user->data->display_name;
            $customer_email = $current_user->data->user_email;

        ?>
        <style type="text/css">
            .ig_campaign_page_icegram-support div#TB_ajaxContent {
                height: 430px !important;
            }
        </style>
        <form id="icegram_form_post_query" method="POST" action="" enctype="multipart/form-data">
            <script type="text/javascript">
                jQuery(function(){
                    jQuery('input#icegram_submit_query').click(function(e){
                        var error = false;

                        var client_name = jQuery('input#client_name').val();
                        if ( client_name == '' ) {
                            jQuery('input#client_name').css('border-color', 'red');
                            error = true;
                        } else {
                            jQuery('input#client_name').css('border-color', '');
                        }

                        var client_email = jQuery('input#client_email').val();
                        if ( client_email == '' ) {
                            jQuery('input#client_email').css('border-color', 'red');
                            error = true;
                        } else {
                            jQuery('input#client_email').css('border-color', '');
                        }

                        var subject = jQuery('table#icegram_post_query_table input#subject').val();
                        if ( subject == '' ) {
                            jQuery('input#subject').css('border-color', 'red');
                            error = true;
                        } else {
                            jQuery('input#subject').css('border-color', '');
                        }

                        var message = jQuery('table#icegram_post_query_table textarea#message').val();
                        if ( message == '' ) {
                            jQuery('textarea#message').css('border-color', 'red');
                            error = true;
                        } else {
                            jQuery('textarea#message').css('border-color', '');
                        }

                        if ( error == true ) {
                            jQuery('label#error_message').text('* All fields are compulsory.');
                            e.preventDefault();
                        } else {
                            jQuery('label#error_message').text('');
                        }

                    });

                    jQuery(".icegram-contact-us a.thickbox").click( function(){
                        setTimeout(function() {
                            jQuery('#TB_ajaxWindowTitle').text('Send your query');
                        }, 0 );
                    });

                    jQuery('div#TB_ajaxWindowTitle').each(function(){
                       var window_title = jQuery(this).text(); 
                       if ( window_title.indexOf('Send your query') != -1 ) {
                           jQuery(this).remove();
                       }
                    });

                    jQuery('input,textarea').keyup(function(){
                        var value = jQuery(this).val();
                        if ( value.length > 0 ) {
                            jQuery(this).css('border-color', '');
                            jQuery('label#error_message').text('');
                        }
                    });
                    jQuery('.update-nag, .ig_st_notice').hide();

                });
            </script>
            <table id="icegram_post_query_table">
                <tr>
                    <td><label for="client_name"><?php esc_html_e('Name', 'icegram'); ?>*</label></td>
                    <td><input type="text" class="regular-text sm_text_field" id="client_name" name="client_name" value="<?php echo esc_attr($customer_name); ?>" /></td>
                </tr>
                <tr>
                    <td><label for="client_email"><?php esc_html_e('E-mail', 'icegram'); ?>*</label></td>
                    <td><input type="email" class="regular-text sm_text_field" id="client_email" name="client_email" value="<?php echo esc_attr($customer_email); ?>" /></td>
                </tr>
                <tr>
                    <td><label for="subject"><?php esc_html_e('Subject', 'icegram'); ?>*</label></td>
                    <td><input type="text" class="regular-text sm_text_field" id="subject" name="subject" value="<?php echo esc_attr( !empty( $subject ) ? $subject : ''); ?>" /></td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 12px;"><label for="message"><?php esc_html_e('Message', 'icegram'); ?>*</label></td>
                    <td><textarea id="message" name="message" rows="10" cols="60"><?php echo esc_attr( !empty( $message ) ? $message : ''); ?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><label id="error_message" style="color: red;"></label></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" class="button" id="icegram_submit_query" name="submit_query" value="Send" /></td>
                </tr>
            </table>
            <?php wp_nonce_field( 'icegram-submit-query'); ?>
            <input type="hidden" id="current_plugin" name="additional_info[current_plugin]" value="Icegram <?php echo esc_attr($icegram->version); ?>" />
        </form>
    </div>
    <?php
}

if ( !wp_script_is( 'thickbox' ) ) {
    if ( !function_exists( 'add_thickbox' ) ) {
        require_once ABSPATH . 'wp-includes/general-template.php';
    }
    add_thickbox();
} 


function icegram_get_about_page_vars() {
    global $icegram;
    
    $ig_sample_id = get_option('icegram_sample_data_imported');
    
    return array(
        'sample_id'     => $ig_sample_id,
        'view_campaign' => admin_url( 'post.php?post=' . $ig_sample_id[0] . '&action=edit' ),
        'preview_url'   => home_url( '?campaign_preview_id=' . $ig_sample_id[0] ),
        'assets_base'   => $icegram->plugin_url . '/assets/images/',
        'version'       => $icegram->version,
    );
}


$icegram_about_vars = icegram_get_about_page_vars();

?>
        <div class="wrap about-wrap icegram">   
            <div class="about-header">
                <div class="about-text icegram-about-text">
                <strong><?php esc_html_e( "Welcome to Icegram Engage.", "icegram" ); ?></strong>
                    <?php esc_html_e( "Your sample campaign is ready!", "icegram" )?>                
                    <p class="icegram-actions">
                        <a class="button button-primary button-large" href="<?php echo esc_url( $icegram_about_vars['preview_url'] ); ?>" target="_blank" ><?php esc_html_e( 'Preview Your First Campaign', 'icegram' ); ?></a>
                        <span style="margin: 0 .5em"><?php esc_html_e( "OR", "icegram")?></span>
                        <a href="<?php echo esc_url( $icegram_about_vars['view_campaign'] ); ?>"> <strong><?php esc_html_e( 'Edit & Publish it.', 'icegram' ); ?></strong></a>
                    </p>
                </div>
                <div class="icegram-badge">
                   <?php 
                    /* translators: %s is the plugin version */
                    echo esc_html( sprintf( __( 'Version: %s', 'icegram' ), $icegram_about_vars['version'] ) );
                    ?>
                </div>
                <div class="icegram-support">
                    <?php esc_html_e( 'Questions? Need Help?', "icegram" ); ?>
                    <div id="icegram-contact-us" class="icegram-contact-us"><a class="thickbox"  href="<?php echo esc_url( admin_url() . '#TB_inline?inlineId=icegram_post_query_form&post_type=ig_campaign' ); ?>"><?php esc_html_e("Contact Us", "icegram"); ?></a></div>
                </div>
                <?php do_action('icegram_about_changelog'); ?>
             </div>   
            <!-- <hr> -->
            <div class="changelog">
                <!-- <hr> -->
                <div class="about-text">
                <?php esc_html_e("Do read Icegram Engage's core concepts below to understand how you can use Icegram Engage to ", "icegram"); ?>
                <strong><?php esc_html_e("inspire, convert and engage", "icegram"); ?></strong>
                <?php esc_html_e("your audience.", "icegram"); ?>
                </div>

                <div class="feature-section col three-col">
                    <h2 class="icegram-dashicons dashicons-testimonial"><?php esc_html_e( "Messages", "icegram" ); ?></h2>
                    <div class="col-1">                                
                        <p><?php esc_html_e("A 'Message' is a communication you want to deliver to your audience.","icegram"); ?></p>
                        <p><?php esc_html_e("And Icegram Engage comes with not one, but four message types.","icegram"); ?></p>
                        <p><?php esc_html_e("Different message types look and behave differently, but they all have many common characteristics. For instance, most message types will allow you to set a headline, a body text, label for the ‘call to action’ button, a link for that button, theme and styling options, animation effect and position on screen where that message should show.","icegram"); ?></p>
                        <?php do_action('icegram_about_after_core_message_types_col1'); ?>
                    </div>
                    <div class="col-2">
                        <h4><?php esc_html_e("Action Bar", "icegram"); ?></h4>
                        <img src="<?php echo esc_url( $icegram_about_vars['assets_base'] ) . '/sketch-action-bar.png'; ?>" width="180" height="145">
                        <p><?php esc_html_e("An action bar is a proven attention grabber. It shows up as a solid bar either at top or bottom. Use it for your most important messages or time sensitive announcements. Put longer content in it and it acts like a collapsible panel!", "icegram"); ?></p>
                        <h4><?php esc_html_e("Messenger", "icegram"); ?></h4>
                        <img src="<?php echo esc_url( $icegram_about_vars['assets_base'] ) . '/sketch-messenger.png'; ?>" width="180" height="145">
                        <p><?php esc_html_e("A messenger is best used to invoke interest while your visitor is reading your content. Users perceive it as something new, important and urgent and are highly likely to click on it.", "icegram"); ?></p>
                        <?php do_action('icegram_about_after_core_message_types_col2'); ?>
                    </div>
                    <div class="col-3 last-feature">
                        <h4><?php esc_html_e("Toast Notification", "icegram"); ?></h4>
                        <img src="<?php echo esc_url( $icegram_about_vars['assets_base'] ) . '/sketch-toast-notification.png'; ?>" width="180" height="145">
                        <p><?php esc_html_e("Want to alert your visitor about some news, an update from your blog, a social proof or an offer? Use Icegram Engage’s unique toast notification, it will catch their attention, let them click on the message, and disappear after a while.", "icegram"); ?></p>
                        <h4><?php esc_html_e("Popup", "icegram"); ?></h4>
                        <img src="<?php echo esc_url( $icegram_about_vars['assets_base'] ) . '/sketch-popup.png'; ?>" width="180" height="145">
                        <p><?php esc_html_e("Lightbox popup windows are most widely used for lead capture, promotions and additional content display. Ask visitors to sign up to your newsletter, or like you on social networks, or tell them about a special offer...", "icegram"); ?></p>
                        <?php do_action('icegram_about_after_core_message_types_col3'); ?>
                    </div>
                </div>                
                <hr>

                <?php do_action('icegram_about_after_core_message_types'); ?>
                
                <div class="feature-section col three-col">
                    <h2 class="icegram-dashicons dashicons-megaphone"><?php esc_html_e("Campaigns", "icegram"); ?></h2>
                    <div class="col-1">                                
                        <p><strong><?php esc_html_e("Campaign = Messages + Rules", "icegram"); ?></strong></p>
                        <p><?php esc_html_e("A campaign allows sequencing multiple messages and defining targeting rules. Create different campaigns for different marketing goals. Icegram Engage supports showing multiple campaigns on any page.", "icegram"); ?></p>
						<p><?php esc_html_e("You can always preview your campaign to ensure campaign works the way you want, before making it live.", "icegram"); ?></p>
                        <?php do_action('icegram_about_after_core_campaigns_col1'); ?>
                    </div>
                    <div class="col-2">
                        <h4><?php esc_html_e("Multiple Messages & Sequencing", "icegram"); ?></h4>
                        <img src="<?php echo esc_url( $icegram_about_vars['assets_base'] ) . '/sketch-multiple-sequence.png'; ?>" width="180" height="145">
                        <p><?php esc_html_e("Add one or as many messages to a campaign as you want. Also choose the number of seconds after which each message should show up. Showing multiple messages for same goal, but with slightly different content / presentation, greatly improves conversions.", "icegram"); ?></p>
                        <?php do_action('icegram_about_after_core_campaigns_col2'); ?>
                    </div>
                    <div class="col-3 last-feature">                                
                        <h4><?php esc_html_e("Targeting Rules", "icegram"); ?></h4>
                        <img src="<?php echo esc_url( $icegram_about_vars['assets_base'] ) . '/sketch-rules.png'; ?>" width="180" height="145">
                        <p><?php esc_html_e("You can control who sees a campaign – and on what device, which pages does it show on, and what time period will it stay active for. You can run different campaigns with different rules to maximize engagement.", "icegram"); ?></p>
                        <?php do_action('icegram_about_after_core_campaigns_col3'); ?>
                    </div>
                </div>

                <?php do_action('icegram_about_after_core_campaigns'); ?>

                <hr>                
                <div class="feature-section col two-col">
                    <h2 class="icegram-dashicons dashicons-editor-help"><?php esc_html_e("FAQ / Common Problems", "icegram"); ?></h2>
                    <div class="col-1">

                        <h4><?php esc_html_e("Messages look broken / formatting is weird...", "icegram"); ?></h4>
                        <p><?php esc_html_e("This is most likely due to CSS conflicts with current theme. We suggest using simple formatting for messages. You can also write custom CSS in your theme to fix any problems.", "icegram"); ?></p>

                        <h4><?php esc_html_e("Extra Line Breaks / Paragraphs in messages...", "icegram"); ?></h4>
                        <p><?php esc_html_e("Go to HTML mode in content editor and pull your custom HTML code all together in one line. Don't leave blank lines between two tags. That should fix it.", "icegram"); ?></p>

                        <h4><?php esc_html_e("How do I add custom CSS for messages?", "icegram"); ?></h4>
                        <p><?php esc_html_e("You can use custom CSS/JS inline in your message HTML. You can also use your theme's custom JS / CSS feature to add your changes.", "icegram"); ?></p>

                        <h4><?php esc_html_e("Optin Forms / Mailing service integration...", "icegram"); ?></h4>
                        <p><?php esc_html_e("You can embed any optin / subscription form to your Icegram Engage messages using 'Embed Form' button above text editor. Paste in form HTML code and let Icegram Engage clean it up! You may even use a shortcode if you are using a WP plugin from your newsletter / lead capture service.", "icegram"); ?></p>

                        <h4><?php esc_html_e("How many messages should I show on a page?", "icegram"); ?></h4>
                        <p><?php esc_html_e("While Icegram Engage provides you lots of different message types and ability to add multiple messages to a campaign, we discourage you to go overboard. We've observed two messages on a page work well, but YMMV!", "icegram"); ?></p>

                        <?php do_action('icegram_about_after_faq_col1'); ?>

                    </div>
                    <div class="col-2 last-feature">                                
                        <h4><?php esc_html_e("Preview does not work / not refreshing...", "icegram"); ?></h4>
                        <p><?php esc_html_e("Doing a browser refresh while previewing will not show your most recent changes. Click 'Preview' button to see a preview with your latest changes.", "icegram"); ?></p>

                        <h4><?php esc_html_e("Can I use shortcodes in a message?", "icegram"); ?></h4>
                        <p><?php esc_html_e("Yes! Messages support shortcodes. You may need to adjust CSS so the shortcode output looks good in your message.", "icegram"); ?></p>

                        <h4><?php esc_html_e("WPML / Multilingual usage...", "icegram"); ?></h4>
                        <p><?php esc_html_e("Go to <code>Messages</code> from Icegram Engage menu. Edit a message and translate it like any other post. Icegram Engage will show translated message where possible. Choose <code>All posts</code> under WPML Language setting - Blog Posts to display, to fall back to default language messages.", "icegram"); ?></p>

                        <?php do_action('icegram_about_after_faq_col2'); ?>

                        <h4><?php esc_html_e("I can't find a way to do X...", "icegram"); ?></h4>
                        <p><?php esc_html_e("Icegram Engage is actively developed. If you can't find your favorite feature (or have a suggestion) contact us. We'd love to hear from you.", "icegram"); ?></p>

                        <h4><?php esc_html_e("I'm facing a problem and can't find a way out...", "icegram"); ?></h4>
                        <p><a class="thickbox"  href="<?php echo esc_url( admin_url() . '#TB_inline?inlineId=icegram_post_query_form&post_type=ig_campaign' ); ?>"><?php esc_html_e("Contact Us", "icegram"); ?></a><?php esc_html_e(", provide as much detail of the problem as you can. We will try to solve the problem ASAP.", "icegram"); ?></p>

                    </div>
                </div>

                <?php do_action('icegram_about_after_faq'); ?>

            </div>            
        </div>


