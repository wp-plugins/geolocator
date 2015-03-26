<?php
// Stop execution if uninstall not called from WordPress
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit;

// Delete option from options table
delete_option( 'geolocator_options' );

// Remove cookie with location data
geolocator_remove_cookie();

/* End of file uninstall.php */