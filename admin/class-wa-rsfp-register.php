<?php
/**
 * Register the post types.
 *
 * @since    1.1.0
 */
function register_post_types() {

	/**
	 * Directory › Knowledge
	 */
	$labels = [
		'name'                     => esc_html__( 'Directory', 'wa-rsfp' ),
		'singular_name'            => esc_html__( 'Knowledge', 'wa-rsfp' ),
		'add_new'                  => esc_html__( 'Add New', 'wa-rsfp' ),
		'add_new_item'             => esc_html__( 'Add New Knowledge', 'wa-rsfp' ),
		'edit_item'                => esc_html__( 'Edit Knowledge', 'wa-rsfp' ),
		'new_item'                 => esc_html__( 'New Knowledge', 'wa-rsfp' ),
		'view_item'                => esc_html__( 'View Knowledge', 'wa-rsfp' ),
		'view_items'               => esc_html__( 'View Knowledges', 'wa-rsfp' ),
		'search_items'             => esc_html__( 'Search Knowledges', 'wa-rsfp' ),
		'not_found'                => esc_html__( 'No Knowledges found.', 'wa-rsfp' ),
		'not_found_in_trash'       => esc_html__( 'No Knowledges found in Trash.', 'wa-rsfp' ),
		'parent_item_colon'        => esc_html__( 'Parent Directory:', 'wa-rsfp' ),
		'all_items'                => esc_html__( 'All Knowledges', 'wa-rsfp' ),
		'archives'                 => esc_html__( 'Directory Archives', 'wa-rsfp' ),
		'attributes'               => esc_html__( 'Directory Attributes', 'wa-rsfp' ),
		'insert_into_item'         => esc_html__( 'Insert into Directory', 'wa-rsfp' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this Knowledge', 'wa-rsfp' ),
		'featured_image'           => esc_html__( 'Featured image', 'wa-rsfp' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'wa-rsfp' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'wa-rsfp' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'wa-rsfp' ),
		'menu_name'                => esc_html__( 'Directory', 'wa-rsfp' ),
		'filter_items_list'        => esc_html__( 'Filter Knowledges list', 'wa-rsfp' ),
		'filter_by_date'           => esc_html__( 'Filter Knowledges date', 'wa-rsfp' ),
		'items_list_navigation'    => esc_html__( 'Directory list navigation', 'wa-rsfp' ),
		'items_list'               => esc_html__( 'Directory list', 'wa-rsfp' ),
		'item_published'           => esc_html__( 'Knowledge published.', 'wa-rsfp' ),
		'item_published_privately' => esc_html__( 'Knowledge published privately.', 'wa-rsfp' ),
		'item_reverted_to_draft'   => esc_html__( 'Knowledge reverted to draft.', 'wa-rsfp' ),
		'item_scheduled'           => esc_html__( 'Knowledge scheduled.', 'wa-rsfp' ),
		'item_updated'             => esc_html__( 'Knowledge updated.', 'wa-rsfp' ),
		'text_domain'              => esc_html__( 'wa-rsfp', 'wa-rsfp' ),
	];
	$args = [
		'label'               => esc_html__( 'Directories', 'wa-rsfp' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		//'menu_position'       => 10,
		'menu_icon'           => 'dashicons-pressthis',
		'capability_type'     => 'post',
		'supports'            => ['title', 'thumbnail', 'editor', 'comments', 'author', 'revisions', 'custom-fields'], // https://stackoverflow.com/questions/77310854/wordpress-useentityprop-returns-undefined
		'taxonomies'          => ['geography','production','thematic'], //'category', 'post_tag'
		'rewrite'             => [
			'with_front' => false,
		],
		//https://stackoverflow.com/questions/72302604/wordpress-default-blocks-loaded-on-new-post
		'template' => array(
			// Add blocks to default content
			// Used to make the page template default and editable / removable ( instead of page model )
			array(
				'directory/wa-rsfp-directory-block',
			),
			// array(
			// 	'core/paragraph',
			// 	array(
			// 		'align'   => 'center',
			// 		'content' => 'Place content you already in the block, even a link to a site like <a href="stackoverflow.com">stackoverflow</a>.',
			// 	),
			// ),
			// array(
			// 	'core/buttons',
			// 	array(
			// 		'layout' => array(
			// 			'type'           => 'flex',
			// 			'justifyContent' => 'center',
			// 		),
			// 	),
			// 	array(
			// 		array(
			// 			'core/button',
			// 			array(
			// 				'text'      => 'button text',
			// 				'url'       => 'https://the-url.com/',
			// 				'className' => 'a-custom-class-name',
			// 			),
			// 		),
			// 	),
			// ),
		)
	];
	register_post_type( 'directory', $args );

	/**
	 * Farm (relation)
	 */
	$labels = [
		'name'                     => esc_html__( 'Farms', 'wa-rsfp' ),
		'singular_name'            => esc_html__( 'Farm', 'wa-rsfp' ),
		'add_new'                  => esc_html__( 'Add New', 'wa-rsfp' ),
		'add_new_item'             => esc_html__( 'Add New Farm', 'wa-rsfp' ),
		'edit_item'                => esc_html__( 'Edit Farm', 'wa-rsfp' ),
		'new_item'                 => esc_html__( 'New Farm', 'wa-rsfp' ),
		'view_item'                => esc_html__( 'View Farm', 'wa-rsfp' ),
		'view_items'               => esc_html__( 'View Farms', 'wa-rsfp' ),
		'search_items'             => esc_html__( 'Search Farms', 'wa-rsfp' ),
		'not_found'                => esc_html__( 'No farms found.', 'wa-rsfp' ),
		'not_found_in_trash'       => esc_html__( 'No farms found in Trash.', 'wa-rsfp' ),
		'parent_item_colon'        => esc_html__( 'Parent Farm:', 'wa-rsfp' ),
		'all_items'                => esc_html__( 'All Farms', 'wa-rsfp' ),
		'archives'                 => esc_html__( 'Farm Archives', 'wa-rsfp' ),
		'attributes'               => esc_html__( 'Farm Attributes', 'wa-rsfp' ),
		'insert_into_item'         => esc_html__( 'Insert into farm', 'wa-rsfp' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this farm', 'wa-rsfp' ),
		'featured_image'           => esc_html__( 'Featured image', 'wa-rsfp' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'wa-rsfp' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'wa-rsfp' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'wa-rsfp' ),
		'menu_name'                => esc_html__( 'Farms', 'wa-rsfp' ),
		'filter_items_list'        => esc_html__( 'Filter farms list', 'wa-rsfp' ),
		'filter_by_date'           => esc_html__( 'Filter farms date', 'wa-rsfp' ),
		'items_list_navigation'    => esc_html__( 'Farms list navigation', 'wa-rsfp' ),
		'items_list'               => esc_html__( 'Farms list', 'wa-rsfp' ),
		'item_published'           => esc_html__( 'Farm published.', 'wa-rsfp' ),
		'item_published_privately' => esc_html__( 'Farm published privately.', 'wa-rsfp' ),
		'item_reverted_to_draft'   => esc_html__( 'Farm reverted to draft.', 'wa-rsfp' ),
		'item_scheduled'           => esc_html__( 'Farm scheduled.', 'wa-rsfp' ),
		'item_updated'             => esc_html__( 'Farm updated.', 'wa-rsfp' ),
		'text_domain'              => esc_html__( 'wa-rsfp', 'wa-rsfp' ),
	];
	$args = [
		'label'               => esc_html__( 'Farms', 'wa-rsfp' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		//'menu_position'       => 20,
		'menu_icon'           => 'dashicons-carrot',
		'capability_type'     => 'post',
		'supports'            => ['title', 'thumbnail', 'author'],
		'taxonomies'          => [],
		'rewrite'             => [
			'with_front' => false,
		],
	];

	register_post_type( 'farm', $args );

	/**
	 * Operation (relation)
	 */
	$labels = [
		'name'                     => esc_html__( 'Operations', 'wa-rsfp' ),
		'singular_name'            => esc_html__( 'Operation', 'wa-rsfp' ),
		'add_new'                  => esc_html__( 'Add New', 'wa-rsfp' ),
		'add_new_item'             => esc_html__( 'Add New Operation', 'wa-rsfp' ),
		'edit_item'                => esc_html__( 'Edit Operation', 'wa-rsfp' ),
		'new_item'                 => esc_html__( 'New Operation', 'wa-rsfp' ),
		'view_item'                => esc_html__( 'View Operation', 'wa-rsfp' ),
		'view_items'               => esc_html__( 'View Operations', 'wa-rsfp' ),
		'search_items'             => esc_html__( 'Search Operations', 'wa-rsfp' ),
		'not_found'                => esc_html__( 'No operations found.', 'wa-rsfp' ),
		'not_found_in_trash'       => esc_html__( 'No operations found in Trash.', 'wa-rsfp' ),
		'parent_item_colon'        => esc_html__( 'Parent Operation:', 'wa-rsfp' ),
		'all_items'                => esc_html__( 'All Operations', 'wa-rsfp' ),
		'archives'                 => esc_html__( 'Operation Archives', 'wa-rsfp' ),
		'attributes'               => esc_html__( 'Operation Attributes', 'wa-rsfp' ),
		'insert_into_item'         => esc_html__( 'Insert into operation', 'wa-rsfp' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this operation', 'wa-rsfp' ),
		'featured_image'           => esc_html__( 'Featured image', 'wa-rsfp' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'wa-rsfp' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'wa-rsfp' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'wa-rsfp' ),
		'menu_name'                => esc_html__( 'Operations', 'wa-rsfp' ),
		'filter_items_list'        => esc_html__( 'Filter operations list', 'wa-rsfp' ),
		'filter_by_date'           => esc_html__( 'Filter operations date', 'wa-rsfp' ),
		'items_list_navigation'    => esc_html__( 'Operations list navigation', 'wa-rsfp' ),
		'items_list'               => esc_html__( 'Operations list', 'wa-rsfp' ),
		'item_published'           => esc_html__( 'Operation published.', 'wa-rsfp' ),
		'item_published_privately' => esc_html__( 'Operation published privately.', 'wa-rsfp' ),
		'item_reverted_to_draft'   => esc_html__( 'Operation reverted to draft.', 'wa-rsfp' ),
		'item_scheduled'           => esc_html__( 'Operation scheduled.', 'wa-rsfp' ),
		'item_updated'             => esc_html__( 'Operation updated.', 'wa-rsfp' ),
		'text_domain'              => esc_html__( 'wa-rsfp', 'wa-rsfp' ),
	];
	$args = [
		'label'               => esc_html__( 'Operations', 'wa-rsfp' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		//'menu_position'       => 40,
		'menu_icon'           => 'dashicons-flag',
		'capability_type'     => 'post',
		'supports'            => ['title', 'editor', 'author'], //'thumbnail',
		'taxonomies'          => ['thematic'],
		'rewrite'             => [
			'with_front' => false,
		],
	];

	register_post_type( 'operation', $args );

	/**
	 * Structure (relation)
	 */
	$labels = [
		'name'                     => esc_html__( 'Structures', 'wa-rsfp' ),
		'singular_name'            => esc_html__( 'Structure', 'wa-rsfp' ),
		'add_new'                  => esc_html__( 'Add New', 'wa-rsfp' ),
		'add_new_item'             => esc_html__( 'Add New Structure', 'wa-rsfp' ),
		'edit_item'                => esc_html__( 'Edit Structure', 'wa-rsfp' ),
		'new_item'                 => esc_html__( 'New Structure', 'wa-rsfp' ),
		'view_item'                => esc_html__( 'View Structure', 'wa-rsfp' ),
		'view_items'               => esc_html__( 'View Structures', 'wa-rsfp' ),
		'search_items'             => esc_html__( 'Search Structures', 'wa-rsfp' ),
		'not_found'                => esc_html__( 'No structures found.', 'wa-rsfp' ),
		'not_found_in_trash'       => esc_html__( 'No structures found in Trash.', 'wa-rsfp' ),
		'parent_item_colon'        => esc_html__( 'Parent Structure:', 'wa-rsfp' ),
		'all_items'                => esc_html__( 'All Structures', 'wa-rsfp' ),
		'archives'                 => esc_html__( 'Structure Archives', 'wa-rsfp' ),
		'attributes'               => esc_html__( 'Structure Attributes', 'wa-rsfp' ),
		'insert_into_item'         => esc_html__( 'Insert into structure', 'wa-rsfp' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this structure', 'wa-rsfp' ),
		'featured_image'           => esc_html__( 'Featured image', 'wa-rsfp' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'wa-rsfp' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'wa-rsfp' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'wa-rsfp' ),
		'menu_name'                => esc_html__( 'Structures', 'wa-rsfp' ),
		'filter_items_list'        => esc_html__( 'Filter structures list', 'wa-rsfp' ),
		'filter_by_date'           => esc_html__( 'Filter structures date', 'wa-rsfp' ),
		'items_list_navigation'    => esc_html__( 'Structures list navigation', 'wa-rsfp' ),
		'items_list'               => esc_html__( 'Structures list', 'wa-rsfp' ),
		'item_published'           => esc_html__( 'Structure published.', 'wa-rsfp' ),
		'item_published_privately' => esc_html__( 'Structure published privately.', 'wa-rsfp' ),
		'item_reverted_to_draft'   => esc_html__( 'Structure reverted to draft.', 'wa-rsfp' ),
		'item_scheduled'           => esc_html__( 'Structure scheduled.', 'wa-rsfp' ),
		'item_updated'             => esc_html__( 'Structure updated.', 'wa-rsfp' ),
	];
	$args = [
		'label'               => esc_html__( 'Structures', 'wa-rsfp' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		//'menu_position'       => 30,
		'menu_icon'           => 'dashicons-admin-generic',
		'capability_type'     => 'post',
		'supports'            => ['title', 'thumbnail', 'author'],
		'taxonomies'          => ['geography'],
		'rewrite'             => [
			'with_front' => false,
		],
	];

	register_post_type( 'structure', $args );

	/**
	 * Partner
	 */
	$labels = [
		'name'                     => esc_html__( 'Partners', 'wa-rsfp' ),
		'singular_name'            => esc_html__( 'Partner', 'wa-rsfp' ),
		'add_new'                  => esc_html__( 'Add New', 'wa-rsfp' ),
		'add_new_item'             => esc_html__( 'Add New Partner', 'wa-rsfp' ),
		'edit_item'                => esc_html__( 'Edit Partner', 'wa-rsfp' ),
		'new_item'                 => esc_html__( 'New Partner', 'wa-rsfp' ),
		'view_item'                => esc_html__( 'View Partner', 'wa-rsfp' ),
		'view_items'               => esc_html__( 'View Partners', 'wa-rsfp' ),
		'search_items'             => esc_html__( 'Search Partners', 'wa-rsfp' ),
		'not_found'                => esc_html__( 'No partners found.', 'wa-rsfp' ),
		'not_found_in_trash'       => esc_html__( 'No partners found in Trash.', 'wa-rsfp' ),
		'parent_item_colon'        => esc_html__( 'Parent Partner:', 'wa-rsfp' ),
		'all_items'                => esc_html__( 'All Partners', 'wa-rsfp' ),
		'archives'                 => esc_html__( 'Partner Archives', 'wa-rsfp' ),
		'attributes'               => esc_html__( 'Partner Attributes', 'wa-rsfp' ),
		'insert_into_item'         => esc_html__( 'Insert into partner', 'wa-rsfp' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this partner', 'wa-rsfp' ),
		'featured_image'           => esc_html__( 'Featured image', 'wa-rsfp' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'wa-rsfp' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'wa-rsfp' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'wa-rsfp' ),
		'menu_name'                => esc_html__( 'Partners', 'wa-rsfp' ),
		'filter_items_list'        => esc_html__( 'Filter partners list', 'wa-rsfp' ),
		'filter_by_date'           => esc_html__( '', 'wa-rsfp' ),
		'items_list_navigation'    => esc_html__( 'Partners list navigation', 'wa-rsfp' ),
		'items_list'               => esc_html__( 'Partners list', 'wa-rsfp' ),
		'item_published'           => esc_html__( 'Partner published.', 'wa-rsfp' ),
		'item_published_privately' => esc_html__( 'Partner published privately.', 'wa-rsfp' ),
		'item_reverted_to_draft'   => esc_html__( 'Partner reverted to draft.', 'wa-rsfp' ),
		'item_scheduled'           => esc_html__( 'Partner scheduled.', 'wa-rsfp' ),
		'item_updated'             => esc_html__( 'Partner updated.', 'wa-rsfp' ),
		'text_domain'              => esc_html__( 'wa-rsfp', 'wa-rsfp' ),
	];
	$args = [
		'label'               => esc_html__( 'Partners', 'wa-rsfp' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		//'menu_position'       => 50,
		'menu_icon'           => 'dashicons-groups',
		'capability_type'     => 'post',
		'supports'            => ['title', 'thumbnail'],
		'taxonomies'          => ['partner-category'],
		'rewrite'             => [
			'with_front' => false,
		],
	];

	register_post_type( 'partner', $args );

}
?>