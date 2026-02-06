<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
Proper structuring of message data fields in case of animation and theme key-value
Changed the array keys
title -> headline
promo_image -> icon
*/
global $wpdb, $wp_rewrite;

// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$icegram_meta_results = $wpdb->get_results( "SELECT * FROM {$wpdb->postmeta} WHERE meta_key LIKE 'icegram_message_%'" );

foreach ( $icegram_results as $icegram_result ) {

    $icegram_message_data = unserialize( $icegram_result->meta_value );
    if( is_array( $icegram_message_data ) && !empty( $icegram_message_data ) ) {        
        $icegram_message_type = $icegram_message_data['type'];
        if( isset( $icegram_message_data['theme'] ) && is_array( $icegram_message_data['theme'] ) && !empty( $icegram_message_data['theme'][$icegram_message_type] ) ) {
            $icegram_message_data['theme'] = $icegram_message_data['theme'][$icegram_message_type];
        }
        if( isset( $icegram_message_data['animation'] ) && is_array( $icegram_message_data['animation'] ) ) {
            if( !empty( $icegram_message_data['animation'][$icegram_message_type] ) ) {
                $icegram_message_data['animation'] = $icegram_message_data['animation'][$icegram_message_type];
            } else {
                unset( $icegram_message_data['animation'] );
            }
        }
        if( isset( $icegram_message_data['title'] ) ) {
            $icegram_message_data['headline'] = $icegram_message_data['title'];
            unset( $icegram_message_data['title'] );
        }
        if( isset( $icegram_message_data['promo_image'] ) ) {
            $icegram_message_data['icon'] = $icegram_message_data['promo_image'];
            unset( $icegram_message_data['promo_image'] );
        }
        update_post_meta( $icegram_result->post_id, $icegram_result->meta_key, $icegram_message_data );
    }

}

// Change post_type for messages and campaigns
 $icegram_old_post_types = array('message', 'campaign');
foreach ($icegram_old_post_types as $icegram_type) {
        
    $icegram_query = 'numberposts=-1&post_status=any&post_type='.$icegram_type;
    
    $icegram_items = get_posts($icegram_query);
    
    foreach ($icegram_items as $icegram_item) {
        
        $icegram_update['ID'] = $icegram_item->ID;
        
        $icegram_update['post_type'] = "ig_{$icegram_type}";
        wp_update_post( $icegram_update );
    }

    /*
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_type = REPLACE(post_type, %s, %s) 
                                   WHERE post_type LIKE %s", $type, 'ig_'.$type, $type ) );
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET guid = REPLACE(guid, %s, %s) 
                                   WHERE guid LIKE %s", "post_type={$type}", "post_type=ig_{$type}", "%post_type={$type}%" ) );

    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET guid = REPLACE(guid, %s, %s) 
                                   WHERE guid LIKE %s", "/{$type}/", "/ig_{$type}/", "%/{$type}/%" ) );
    */                               
}

if ($wp_rewrite) {
    $wp_rewrite->flush_rules();
}

update_option( 'icegram_db_version', '1.2' );
