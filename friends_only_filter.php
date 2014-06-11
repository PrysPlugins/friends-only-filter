<?php
/**
 * Plugin Name: Friends Only Filter
 * Plugin URI: https://github.com/PrysPlugins/friends-only-filter
 * Description: Filter the "Friends Only" plugin to allow more exceptions.
 * Version: 1.2
 * Author: Jeremy Pry
 * Author URI: http://jeremypry.com/
 * License: GPL2
 * GitHub Plugin URI: https://github.com/PrysPlugins/friends-only-filter
 * GitHub branch: master
 */

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
	die( "You can't do anything by accessing this file directly." );
}

add_filter( 'fo_sentry_off', 'jpry_fo_sentry_off' );
/**
 * Turn off the Friends Only Sentry if our custom header is present.
 *
 * @since 1.0
 *
 * @param bool $sentry_off Whether the sentry is currently off.
 * @return bool The new $sentry_off setting.
 */
function jpry_fo_sentry_off( $sentry_off ) {

	// Only process if the senty is NOT yet off
	if ( ! $sentry_off ) {
	
		// Check for our custom Header
		if ( 1 == getenv( 'HTTP_X_WPE_FO_COOKIE' ) ) {
			$sentry_off = true;
		}
	}
	
	return $sentry_off;
}
