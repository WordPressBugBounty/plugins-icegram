<?php
/**
 * Admin View: Notice - Trial To Premium Offer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

$icegram_notice_optin_action = 'ig_trial_to_premium_redirect';

$icegram_optin_url = add_query_arg( 
    array(
        'ig_dismiss_admin_notice' => '1',
        'ig_option_name' => 'trial_to_premium_notice',
        'action' => $icegram_notice_optin_action,
        'ig_nonce' => wp_create_nonce( 'ig_dismiss_notice' )
    )
);

 $icegram_notice_optout_action = 'ig_trial_to_premium_dismiss';

$icegram_optout_url = add_query_arg( 
    array(
        'ig_dismiss_admin_notice' => '1',
        'ig_option_name' => 'trial_to_premium_notice',
        'action' => $icegram_notice_optout_action,
        'ig_nonce' => wp_create_nonce( 'ig_dismiss_notice' )
    )
);

$icegram_remaining_trial_days = Icegram_Trial::get_remaining_trial_days();

$icegram_day_or_days          = _n( 'day', 'days', $icegram_remaining_trial_days, 'icegram' );

$icegram_offer_type_to_show = 'trial';

$icegram_trial_expiration_message = '';
if ( $icegram_remaining_trial_days > 1 ) {
	/* translators: 1. Remaining trial days. 2. day or days text based on number of remaining trial days. */
	$icegram_trial_expiration_message = sprintf( __( 'Your free trial is going to <strong>expire in %1$s %2$s</strong>.', 'icegram' ), $icegram_remaining_trial_days, $icegram_day_or_days ); 
} else {	
	$icegram_trial_expiration_message = __( 'Today is the <strong>last day</strong> of your free trial.', 'icegram' );
}

// Add default value to message.
/* translators: 1. Discount % 2. Premium coupon code */
$icegram_discount_message      = sprintf( __( 'Get flat %1$s discount if you upgrade now!<br/>Use coupon code %2$s during checkout.', 'icegram' ), '<strong>10%</strong>', '<span class="ig_upsale_premium_code">PREMIUM10</span>' ); 

$icegram_offer_cta_optin_text  = __( 'Upgrade now', 'icegram' );

$icegram_offer_cta_optout_text = __( 'No, it\'s ok', 'icegram' );

// Override offer message with current active offer message.
if ( ! empty( $discount_messages[ $icegram_offer_type_to_show ] ) ) {
    $icegram_discount_message = ! empty( $discount_messages[ $icegram_offer_type_to_show ]['message'] ) ? $discount_messages[ $icegram_offer_type_to_show ]['message'] : $icegram_discount_message;

}

/* translators: 1. Trial expiration message. 2. Discount message. */
$icegram_offer_message = sprintf( __( 'Hi there,<br/>Hope you are enjoying <strong>Icegram</strong>.<br/>%1$s<br/>Upgrade now to continue using the trial template <br/>%2$s', 'icegram' ), $icegram_trial_expiration_message, $icegram_discount_message ); 
	
?>
<div id="ig-trial-to-premium-notice" class="notice notice-success">
	<p class="ig-upsale-message">
	<?php
		echo wp_kses_post( $icegram_offer_message );
	?>
	<br/>
	<a href="<?php echo esc_url( $icegram_optin_url ); ?>" target="_blank" id="ig-optin-trial-to-premium-offer" class="ig-primary-button ig-trial-cta">
		<?php
			echo esc_html( $icegram_offer_cta_optin_text );
		?>
	</a>
	<a href="<?php echo esc_url( $icegram_optout_url ); ?>" class="ig-title-button ig-trial-cta">
		<?php
			echo esc_html( $icegram_offer_cta_optout_text );
		?>
	</a>
	</p>
</div>

<style type="text/css">
	.ig-upsale-message{
		line-height:1.6;
	}
	.ig-trial-cta{
		padding:0.25rem 0.5rem;
		margin-top:0.5rem;
	}
</style>