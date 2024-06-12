<?php

/*
* Settings
*/ 
// Not working ... 

function register_custom_meta_settings() {
	// Settings
	add_filter( 'mb_settings_pages', 'add_setting_page', 10);
	add_filter( 'rwmb_meta_boxes', 'add_custom_fields_to_setting_page', 10);
}

function add_setting_page( $settings_pages ) {
	$settings_pages[] = [
		'menu_title' => __( 'Plugin settings', 'wa-rsfp' ),
		'id'         => 'warsfp',
		'parent'     => 'options-general.php',
		'class'      => 'custom_css',
		'style'      => 'no-boxes',
		// 'message'    => __( 'Custom message', 'wa-rsfp' ), // Saved custom message
		'customizer' => true,
		'icon_url'   => 'dashicons-admin-generic',
	];

	return $settings_pages;
}

function add_custom_fields_to_setting_page( $meta_boxes ) {
	$prefix = 'warsfp_';

	$meta_boxes[] = [
		'id'             => 'warsfp-fields',
		'settings_pages' => ['warsfp'],
		'fields'         => [
			[
				'name'            => __( 'Homeslide content', 'wa-rsfp' ),
				'id'              => $prefix . 'homeslide_content',
                'type'       => 'text_list',
                'options'    => [
                    'Ligne 1' => 'Ligne 1',
                    'Ligne 2' => 'Ligne 2',
                ],
                'clone'      => true,
                'sort_clone' => true,
                'max_clone'  => 5,
				// 'options'         => $this->posts_options_callback(),
			],
		],
	];

	return $meta_boxes;
}

// function posts_options_callback() {
// 	return get_post_types();
// }

/**
 * Get results
 */

function get_profiles_from_setting_page() {
	return rwmb_meta( 'warsfp_profiles', [ 'object_type' => 'setting' ], 'warsfp' );
}
