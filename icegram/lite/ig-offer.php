<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $icegram;
// BFCM 2025 Campaign
if ( ( get_option( 'ig_offer_bfcm_2025_icegram' ) !== 'yes' ) && Icegram::is_offer_period( 'bfcm') ) { 
    
    $icegram_img_url = $this->plugin_url .'/assets/images/bfcm-engage-free-pro-banner-2025.png';
    
    $icegram_plan = $icegram->get_plan();
    if( 'max' === $icegram_plan ){        
        $icegram_img_url = $this->plugin_url .'/assets/images/bfcm-common-max-banner-2025.png';
    }
    // elseif( 'plus' === $icegram_plan || 'pro' === $icegram_plan ){
    //     $icegram_img_url = $this->plugin_url .'/assets/images/bfcm2021_pro.png';
    // }

    $icegram_dismiss_url = add_query_arg( 
        array(
            'ig_dismiss_admin_notice' => '1',
            'ig_option_name' => 'ig_offer_bfcm_2025',
            'ig_nonce' => wp_create_nonce( 'ig_dismiss_notice' )
        )
    );

    ?>
    <style type="text/css">
        .ig_sale_offer {
            width: 65%;
            margin: 0 auto;
            text-align: center;
            padding-top: 1.2em;
        }

    </style>
    <div class="ig_sale_offer">
        <a target="_blank" href="<?php echo esc_url( $icegram_dismiss_url ); ?>"><img src="<?php echo esc_url( $icegram_img_url ); ?>"/></a>
    </div>
<?php } ?>
