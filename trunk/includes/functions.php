<?php

add_action( 'init', 'geolocator_location', 1000 );

/**
 * Get location of the user, save it in a cookie.
 *
 * @return array
 */
function geolocator_location() {

	global $location;

	if ( isset( $_COOKIE['geolocator_location'] ) ) {
		$location = unserialize( stripslashes( $_COOKIE['geolocator_location'] ) );
	} else {
		$options  = get_option( 'geolocator_options' );
		$provider = $options['provider'];

		$location = array();

		if ( isset( $_SERVER ) && array_key_exists( 'REMOTE_ADDR', $_SERVER ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];

			// Define variables depending on provider
			switch ( $provider ) {
				case 'telize':

					$endpoint      = 'http://www.telize.com/geoip/';
					$country_key   = 'country_code';
					$latitude_key  = 'latitude';
					$longitude_key = 'longitude';

					break;

				case 'ipapi':

					$endpoint      = 'http://ip-api.com/json/';
					$country_key   = 'countryCode';
					$latitude_key  = 'lat';
					$longitude_key = 'lon';

					break;
			}

			// Try to get user location data
			try {
				$response = wp_remote_get( $endpoint . $ip );

				if ( ! is_wp_error($response) && wp_remote_retrieve_response_code( $response ) == 200 ) {
					$json = wp_remote_retrieve_body( $response );
					$data = json_decode($json, true);

					if ( $data ) {
						if ( array_key_exists( $country_key, $data ) &&
						     array_key_exists( $latitude_key, $data ) &&
						     array_key_exists( $longitude_key, $data )
						) {
							$location = [
								'country'   => $data[ $country_key ],
								'latitude'  => $data[ $latitude_key ],
								'longitude' => $data[ $longitude_key ],
							];

							add_action( 'init', 'geolocator_set_cookie', 1100 );
						}
					}
				}
			} catch ( Exception $exception ) {
				// Do nothing
			}
		}
	}

	return $location;

}

/**
 * Set cookie with user location data.
 *
 * @return bool
 */
function geolocator_set_cookie() {

	global $location;

	if ( ! empty( $location ) ) {
		setcookie( 'geolocator_location', serialize( $location ), time() + 3600, COOKIEPATH, COOKIE_DOMAIN );

		return true;
	}

	return false;

}

/**
 * Remove cookie which store location data.
 *
 * @return bool
 */
function geolocator_remove_cookie() {

	setcookie( 'geolocator_location', null, time() - 3600, COOKIEPATH, COOKIE_DOMAIN );

	return true;

}

/**
 * Get user country code.
 *
 * @return bool|string
 */
function geolocator_country() {

	$location = geolocator_location();

	if ( ! empty( $location ) && array_key_exists( 'country', $location ) ) {
		return $location['country'];
	}

	return false;

}

/**
 * Get user latitude.
 *
 * @return bool|string
 */
function geolocator_latitude() {

	$location = geolocator_location();

	if ( ! empty( $location ) && array_key_exists( 'latitude', $location ) ) {
		return $location['latitude'];
	}

	return false;

}

/**
 * Get user longitude.
 *
 * @return bool|string
 */
function geolocator_longitude() {

	$location = geolocator_location();

	if ( ! empty( $location ) && array_key_exists( 'longitude', $location ) ) {
		return $location['longitude'];
	}

	return false;

}

/* End of file functions.php */