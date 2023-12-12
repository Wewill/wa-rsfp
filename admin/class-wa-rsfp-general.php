<?php

/*
	Display version in admin 
*/

// Custom Backend Footer
add_filter('admin_footer_text', 'admin_footer');
function admin_footer() {
	echo '<span id="footer-thankyou">'.__( '© RSFP V2 — Maintenance <a href="http://www.wilhemarnoldy.fr" target="_blank">Wilhem Arnoldy, www.wilhemarnoldy.fr</a>', 'wa-rsfp').'</span>';
}

add_action('admin_head', 'init_dev');
function init_dev() {	
	$subdomain = substr($_SERVER['SERVER_NAME'],0,3);
	
	if ( $subdomain == 'dev' )
		add_action('wp_before_admin_bar_render', 'add_dev_admin_bar');

	if ( $subdomain == 'loc' )
		add_action('wp_before_admin_bar_render', 'add_local_admin_bar');

	if ( $subdomain == 'www' )
		add_action('wp_before_admin_bar_render', 'add_www_admin_bar');
}


// Add dev adminbar text
function add_dev_admin_bar() {
	global $wp_admin_bar;

	$wp_admin_bar->add_node(array(
		'id'    => 'dev-link',
		'title'  => '<span class="vertical-center" style="color:#d54e21;font-size:9px;font-weight:bold;letter-spacing:1px;top: -1px;position:relative;">'.__( 'DEV / BAC À SABLE', 'wa-rsfp' ).'</span>',
		'href'  => admin_url()
	));
}

// Add local adminbar text
function add_local_admin_bar() {
	global $wp_admin_bar;

	$wp_admin_bar->add_node(array(
		'id'    => 'local-link',
		'title'  => '<span class="vertical-center" style="color:#efd708;font-size:9px;font-weight:bold;letter-spacing:1px;top: -1px;position:relative;">'.__( 'LOCAL', 'wa-rsfp' ).'</span>',
		'href'  => admin_url()
	));
}

// Add www adminbar text
function add_www_admin_bar() {
	global $wp_admin_bar;

	$wp_admin_bar->add_node(array(
		'id'    => 'www-link',
		'title'  => '<span class="vertical-center" style="color:#efd708;font-size:9px;font-weight:bold;letter-spacing:1px;top: -1px;position:relative;">'.__( 'LIVE', 'wa-rsfp' ).'</span>',
		'href'  => admin_url()
	));
}

/*
	-----------------------------------
	Add roles to body tag
*/

add_filter('admin_body_class','add_role_to_body');
function add_role_to_body($classes) {
    $current_user = new WP_User(get_current_user_id());
    $user_role = array_shift($current_user->roles);
    if (is_admin()) {
        $classes .= 'role-'. $user_role;
    } else {
        $classes[] = 'role-'. $user_role;
    }
    return $classes;
}

/*
	-----------------------------------
	DEBUG
*/

// POUR TESTER / DEBUG
// add_action( 'admin_head', 'wa_dbg_dev' );
function wa_dbg_dev() {
    global $typenow;
    print_r( $typenow );
    echo '<br>';
    global $pagenow;
    print_r( $pagenow );
    echo '<br>';
    print_r( $_GET[ 'taxonomy' ] );
    echo '<br>';
    $current_screen = get_current_screen();
    print_r( $current_screen->taxonomy );
}