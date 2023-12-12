<?php
/**
 * Register the custom taxonomies.
 *
 * @since    1.1.0
 */
function register_taxonomies() {

    /**
     * Geography
     */
    $labels = [
		'name'                       => esc_html__( 'Geographies', 'wa-rsfp' ),
		'singular_name'              => esc_html__( 'Geography', 'wa-rsfp' ),
		'menu_name'                  => esc_html__( 'Geographies', 'wa-rsfp' ),
		'search_items'               => esc_html__( 'Search Geographies', 'wa-rsfp' ),
		'popular_items'              => esc_html__( 'Popular Geographies', 'wa-rsfp' ),
		'all_items'                  => esc_html__( 'All Geographies', 'wa-rsfp' ),
		'parent_item'                => esc_html__( 'Parent Geography', 'wa-rsfp' ),
		'parent_item_colon'          => esc_html__( 'Parent Geography:', 'wa-rsfp' ),
		'edit_item'                  => esc_html__( 'Edit Geography', 'wa-rsfp' ),
		'view_item'                  => esc_html__( 'View Geography', 'wa-rsfp' ),
		'update_item'                => esc_html__( 'Update Geography', 'wa-rsfp' ),
		'add_new_item'               => esc_html__( 'Add New Geography', 'wa-rsfp' ),
		'new_item_name'              => esc_html__( 'New Geography Name', 'wa-rsfp' ),
		'separate_items_with_commas' => esc_html__( 'Separate geographies with commas', 'wa-rsfp' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove geographies', 'wa-rsfp' ),
		'choose_from_most_used'      => esc_html__( 'Choose most used geographies', 'wa-rsfp' ),
		'not_found'                  => esc_html__( 'No geographies found.', 'wa-rsfp' ),
		'no_terms'                   => esc_html__( 'No geographies', 'wa-rsfp' ),
		'filter_by_item'             => esc_html__( 'Filter by geography', 'wa-rsfp' ),
		'items_list_navigation'      => esc_html__( 'Geographies list pagination', 'wa-rsfp' ),
		'items_list'                 => esc_html__( 'Geographies list', 'wa-rsfp' ),
		'most_used'                  => esc_html__( 'Most Used', 'wa-rsfp' ),
		'back_to_items'              => esc_html__( '&larr; Go to Geographies', 'wa-rsfp' ),
	];
	$args = [
		'label'              => esc_html__( 'Geographies', 'wa-rsfp' ),
		'labels'             => $labels,
		'description'        => esc_html__( 'List all department.s of France', 'wa-rsfp' ),
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => true,
		'show_in_quick_edit' => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'sort'               => true,
		'meta_box_cb'        => 'post_tags_meta_box',
		'rest_base'          => '',
		'rewrite'            => [
			'with_front'   => false,
			'hierarchical' => false,
		],
	];
	register_taxonomy( 'geography', ['structure', 'directory'], $args );

    /**
     * Production
     */
    $labels = [
		'name'                       => esc_html__( 'Productions', 'wa-rsfp' ),
		'singular_name'              => esc_html__( 'Production', 'wa-rsfp' ),
		'menu_name'                  => esc_html__( 'Productions', 'wa-rsfp' ),
		'search_items'               => esc_html__( 'Search Productions', 'wa-rsfp' ),
		'popular_items'              => esc_html__( 'Popular Productions', 'wa-rsfp' ),
		'all_items'                  => esc_html__( 'All Productions', 'wa-rsfp' ),
		'parent_item'                => esc_html__( 'Parent Production', 'wa-rsfp' ),
		'parent_item_colon'          => esc_html__( 'Parent Production:', 'wa-rsfp' ),
		'edit_item'                  => esc_html__( 'Edit Production', 'wa-rsfp' ),
		'view_item'                  => esc_html__( 'View Production', 'wa-rsfp' ),
		'update_item'                => esc_html__( 'Update Production', 'wa-rsfp' ),
		'add_new_item'               => esc_html__( 'Add New Production', 'wa-rsfp' ),
		'new_item_name'              => esc_html__( 'New Production Name', 'wa-rsfp' ),
		'separate_items_with_commas' => esc_html__( 'Separate productions with commas', 'wa-rsfp' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove productions', 'wa-rsfp' ),
		'choose_from_most_used'      => esc_html__( 'Choose most used productions', 'wa-rsfp' ),
		'not_found'                  => esc_html__( 'No productions found.', 'wa-rsfp' ),
		'no_terms'                   => esc_html__( 'No productions', 'wa-rsfp' ),
		'filter_by_item'             => esc_html__( 'Filter by production', 'wa-rsfp' ),
		'items_list_navigation'      => esc_html__( 'Productions list pagination', 'wa-rsfp' ),
		'items_list'                 => esc_html__( 'Productions list', 'wa-rsfp' ),
		'most_used'                  => esc_html__( 'Most Used', 'wa-rsfp' ),
		'back_to_items'              => esc_html__( '&larr; Go to Productions', 'wa-rsfp' ),
	];
	$args = [
		'label'              => esc_html__( 'Productions', 'wa-rsfp' ),
		'labels'             => $labels,
		'description'        => esc_html__( 'List all production.s type of a knowledge', 'wa-rsfp' ),
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => true,
		'show_in_quick_edit' => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'sort'               => true,
		'meta_box_cb'        => 'post_categories_meta_box',
		'rest_base'          => '',
		'rewrite'            => [
			'with_front'   => false,
			'hierarchical' => false,
		],
	];
	register_taxonomy( 'production', ['directory'], $args );

    /**
     * Thematics
     */
    $labels = [
		'name'                       => esc_html__( 'Thematics', 'wa-rsfp' ),
		'singular_name'              => esc_html__( 'Thematic', 'wa-rsfp' ),
		'menu_name'                  => esc_html__( 'Thematics', 'wa-rsfp' ),
		'search_items'               => esc_html__( 'Search Thematics', 'wa-rsfp' ),
		'popular_items'              => esc_html__( 'Popular Thematics', 'wa-rsfp' ),
		'all_items'                  => esc_html__( 'All Thematics', 'wa-rsfp' ),
		'parent_item'                => esc_html__( 'Parent Thematic', 'wa-rsfp' ),
		'parent_item_colon'          => esc_html__( 'Parent Thematic:', 'wa-rsfp' ),
		'edit_item'                  => esc_html__( 'Edit Thematic', 'wa-rsfp' ),
		'view_item'                  => esc_html__( 'View Thematic', 'wa-rsfp' ),
		'update_item'                => esc_html__( 'Update Thematic', 'wa-rsfp' ),
		'add_new_item'               => esc_html__( 'Add New Thematic', 'wa-rsfp' ),
		'new_item_name'              => esc_html__( 'New Thematic Name', 'wa-rsfp' ),
		'separate_items_with_commas' => esc_html__( 'Separate thematics with commas', 'wa-rsfp' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove thematics', 'wa-rsfp' ),
		'choose_from_most_used'      => esc_html__( 'Choose most used thematics', 'wa-rsfp' ),
		'not_found'                  => esc_html__( 'No thematics found.', 'wa-rsfp' ),
		'no_terms'                   => esc_html__( 'No thematics', 'wa-rsfp' ),
		'filter_by_item'             => esc_html__( 'Filter by thematic', 'wa-rsfp' ),
		'items_list_navigation'      => esc_html__( 'Thematics list pagination', 'wa-rsfp' ),
		'items_list'                 => esc_html__( 'Thematics list', 'wa-rsfp' ),
		'most_used'                  => esc_html__( 'Most Used', 'wa-rsfp' ),
		'back_to_items'              => esc_html__( '&larr; Go to Thematics', 'wa-rsfp' ),
	];
	$args = [
		'label'              => esc_html__( 'Thematics', 'wa-rsfp' ),
		'labels'             => $labels,
		'description'        => esc_html__( 'List all thematic.s topic & content of a knowledge or an operation', 'wa-rsfp' ),
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => true,
		'show_in_quick_edit' => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'sort'               => true,
		'meta_box_cb'        => 'post_categories_meta_box',
		'rest_base'          => '',
		'rewrite'            => [
			'with_front'   => false,
			'hierarchical' => false,
		],
	];
	register_taxonomy( 'thematic', ['directory', 'operation'], $args );

    /**
     * Partner types
     */
	$labels = [
		'name'                       => esc_html__( 'Partner types', 'wa-rsfp' ),
		'singular_name'              => esc_html__( 'Partner type', 'wa-rsfp' ),
		'menu_name'                  => esc_html__( 'Partner types', 'wa-rsfp' ),
		'search_items'               => esc_html__( 'Search Partner types', 'wa-rsfp' ),
		'popular_items'              => esc_html__( 'Popular Partner types', 'wa-rsfp' ),
		'all_items'                  => esc_html__( 'All Partner types', 'wa-rsfp' ),
		'parent_item'                => esc_html__( 'Parent Partner type', 'wa-rsfp' ),
		'parent_item_colon'          => esc_html__( 'Parent Partner type:', 'wa-rsfp' ),
		'edit_item'                  => esc_html__( 'Edit Partner type', 'wa-rsfp' ),
		'view_item'                  => esc_html__( 'View Partner type', 'wa-rsfp' ),
		'update_item'                => esc_html__( 'Update Partner type', 'wa-rsfp' ),
		'add_new_item'               => esc_html__( 'Add New Partner type', 'wa-rsfp' ),
		'new_item_name'              => esc_html__( 'New Partner type Name', 'wa-rsfp' ),
		'separate_items_with_commas' => esc_html__( 'Separate partner types with commas', 'wa-rsfp' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove partner types', 'wa-rsfp' ),
		'choose_from_most_used'      => esc_html__( 'Choose most used partner types', 'wa-rsfp' ),
		'not_found'                  => esc_html__( 'No partner types found.', 'wa-rsfp' ),
		'no_terms'                   => esc_html__( 'No partner types', 'wa-rsfp' ),
		'filter_by_item'             => esc_html__( 'Filter by partner type', 'wa-rsfp' ),
		'items_list_navigation'      => esc_html__( 'Partner types list pagination', 'wa-rsfp' ),
		'items_list'                 => esc_html__( 'Partner types list', 'wa-rsfp' ),
		'most_used'                  => esc_html__( 'Most Used', 'wa-rsfp' ),
		'back_to_items'              => esc_html__( '&larr; Go to Partner types', 'wa-rsfp' ),
	];
	$args = [
		'label'              => esc_html__( 'Partner types', 'wa-rsfp' ),
		'labels'             => $labels,
		'description'        => esc_html__( 'List partner type of a partner', 'wa-rsfp' ),
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => true,
		'show_in_quick_edit' => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'sort'               => true,
		'meta_box_cb'        => 'post_tags_meta_box',
		'rest_base'          => '',
		'rewrite'            => [
			'with_front'   => false,
			'hierarchical' => false,
		],
	];
	register_taxonomy( 'partner-type', ['partner'], $args );
    
}