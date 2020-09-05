<?php
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'cred_register_required_plugins' );
function cred_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => 'Exclusive Addons for Elementor',
			'slug'               => 'exclusive-addons-for-elementor',
		),
	);
	$config = array(
		'id'           => 'tgmpa',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
