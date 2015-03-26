<?php
/*
Plugin Name: Geolocator
Plugin URI: https://github.com/masikonis/wordpress-geolocator
Description: Get website visitor's geolocation data (country, latitude, longitude) based on IP address. You can have different behavior for visitors in different countries.
Author: Nerijus Masikonis
Version: 1.0
Author URI: http://www.masikonis.lt/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define( 'GEOLOCATOR_VERSION', '1.0' );

register_activation_hook( __FILE__, 'geolocator_plugin_activation' );
register_deactivation_hook( __FILE__, 'geolocator_plugin_deactivation' );

/**
 * Activate the plugin.
 *
 * @return void
 */
function geolocator_plugin_activation() {

	// Create default settings on activate
	$geolocator_options = array(
		'provider' => 'telize',
	);

	update_option( 'geolocator_options', $geolocator_options );

}

/**
 * Deactivate the plugin.
 *
 * @return void
 */
function geolocator_plugin_deactivation() {

	// Remove the cookie with location data
	geolocator_remove_cookie();

}

// Load translation files if exist
load_plugin_textdomain( 'geolocator', false, 'geolocator/languages' );

// Load required include files
require_once( 'includes/functions.php' );

if ( is_admin() ) {
	require_once( 'includes/settings.php' );
}

/* End of file geolocator.php */