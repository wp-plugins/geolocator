<?php

add_action( 'admin_menu', 'geolocator_admin_create_menu', 2000 );

/**
 * Create submenu in Settings section.
 *
 * @return void
 */
function geolocator_admin_create_menu() {

	add_options_page(
		__('Geolocator Settings', 'geolocator'),
		__('Geolocator', 'geolocator'),
		'manage_options',
		'geolocator_options',
		'geolocator_admin_settings_page'
	);

}

/**
 * Get plugin settings page content.
 *
 * @return string
 */
function geolocator_admin_settings_page() {

	?>
	<div class="wrap">
		<h2><?php _e( 'Geolocator Settings', 'geolocator' ); ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'geolocator_options' ); ?>
			<?php do_settings_sections( 'geolocator' ); ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php

}

add_action( 'admin_init', 'geolocator_admin_init', 2050 );

/**
 * Register and define settings.
 *
 * @return void
 */
function geolocator_admin_init()
{
	register_setting(
		'geolocator_options',
		'geolocator_options',
		'geolocator_validate_options'
	);

	add_settings_section(
		'geolocator_main',
		false,
		false,
		'geolocator'
	);

	add_settings_field(
		'geolocator_provider',
		__( 'API Provider', 'geolocator' ),
		'geolocator_setting_select_provider',
		'geolocator',
		'geolocator_main'
	);
}

/**
 * Display and fill the form field.
 *
 * @return string
 */
function geolocator_setting_select_provider()
{
	$options = get_option( 'geolocator_options' );
	$list = array(
		'telize' => 'Telize',
		'ipapi' => 'IP API',
	);

	?>
	<select name="geolocator_options[provider]">
		<?php foreach($list as $key => $title): ?>
			<option value="<?php echo $key; ?>"<?php if($options['provider'] == $key): ?> selected="selected"<?php endif; ?>>
				<?php _e($title, 'geolocator'); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<p class="description"><?php _e('IP based location detection.', 'geolocator'); ?></p>
	<?php
}

/**
 * Validate the options.
 *
 * @return array
 */
function geolocator_validate_options($input)
{
	$valid = array();
	$valid['provider'] = trim($input['provider']);

	geolocator_remove_cookie();

	return $valid;
}

/* End of file settings.php */