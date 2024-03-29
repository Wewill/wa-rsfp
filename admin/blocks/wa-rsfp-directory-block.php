<?php
/**
 * Plugin Name:       WA RSFP Directory blocks
 * Description:       Bunch of blocks specially designed for single directory pages.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           1.0
 * Author:            Wilhem Arnoldy
 * Author URI:        https://www.wilhemarnoldy.fr
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wa-rsfp
 *
 * @package           wa-rsfp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function wa_rsfp_directory_block() {
    // Register your block
	register_block_type( __DIR__ . '/build/block1' );

    // Assuming your block's name is 'my-custom-block', WordPress would automatically
    // enqueue a script with handle 'create-block-my-custom-block'
    // We'll use this handle to localize our script
	wp_localize_script(
        'create-block-wa-rsfp-directory-block', // This is the generated handle you need to replace with your actual block script handle
        'myBlockData', // Object name in JavaScript
        array(
            'childThemePath' => get_stylesheet_directory_uri()
        )
    );

	// FIX : Force declare post_meta in addition of metabox io to make it work
	register_post_meta(
		'directory',
		'd_general_subtitle',
		array(
			'show_in_rest'       => true,
			'single'             => true,
			'type'               => 'string',
			'sanitize_callback'  => 'wp_kses_post',
		)
	);

	register_post_meta(
		'directory',
		'd_general_introduction',
		array(
			'show_in_rest'       => true,
			'single'             => true,
			'type'               => 'string',
			'sanitize_callback'  => 'wp_kses_post',
		)
	);

	// Identity 
	register_post_meta(
		'directory',
		'd_identity_location',
		array(
			'show_in_rest'       => true,
			'single'             => true,
			'type'               => 'string',
			'sanitize_callback'  => 'wp_kses_post',
		)
	);
}
// add_action( 'init', 'wa_rsfp_directory_block' );
add_action( 'init', 'wa_rsfp_directory_block', 30 ); // Ensure load init after metabox.io action
