<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'icegram_get_request_data' ) ) {
	
	function icegram_get_request_data( $var = '', $default = '', $clean = true ) {
		// phpcs:disable WordPress.Security.NonceVerification.Missing, WordPress.Security.NonceVerification.Recommended
		// Reason: read-only helper that returns sanitized data; icegram_get_data() will clean values as requested.
		$result = icegram_get_data( $_REQUEST, $var, $default, $clean );
		
		return $result;
	}
}

if ( ! function_exists( 'icegram_get_data' ) ) {
	
	function icegram_get_data( $array = array(), $var = '', $default = '', $clean = false ) {

		if ( ! empty( $var ) ) {
			$value = isset( $array[ $var ] ) ? wp_unslash( $array[ $var ] ) : $default;
		} else {
			$value = wp_unslash( $array );
		}

		if ( $clean ) {
			$value = icegram_clean( $value );
		}

		return $value;
	}
}

if ( ! function_exists( 'icegram_clean' ) ) {
	/**
	 * Clean String or array using sanitize_text_field
	 *
	 * @param $variable Data to sanitize
	 *
	 * @return array|string
	 *
	 * @since 3.1.12
	 */	
	function icegram_clean( $var ) {
		if ( is_array( $var ) ) {
			return array_map( 'icegram_clean', $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}
}

if ( ! function_exists('icegram_array_contains') ) {	
	function icegram_array_contains( $array, $findme ) {
		return array_filter($array, function ($val) use ( $findme ) {
			return strpos( $val, $findme ) !== false;
		});
	}
}
