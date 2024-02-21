<?php
/*
	Adds filters
	https://frankiejarrett.com/2011/09/create-a-dropdown-of-custom-taxonomies-in-wordpress-the-easy-way/
*/

//7
//http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/

// Ajoute des filtres sur les pages concernés 


/**
 * Display a custom taxonomy dropdown in admin
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
 
add_action('restrict_manage_posts', 'rsfp_filter_post_type_by_taxonomy');
function rsfp_filter_post_type_by_taxonomy() {
	global $typenow;
  	global $wp_query;

    // Production
	$taxonomy  = 'production';
	if ($typenow == 'directory') {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
        if($info_taxonomy) :
        wp_dropdown_categories(array(
			'show_option_all' => sprintf( __('All %s','wa-rsfp'), $info_taxonomy->label),
			// 'show_option_none'=> __("—",'wa-rsfp'),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
			'hide_if_empty'   => true,
			'hierarchical' 		=> 1,
			'value_field' 		=> 'slug', // Permet de recuperer la query pour selectionner
		));
        endif;
    };

    // Geography
	$taxonomy  = 'geography'; // change to your taxonomy
	if ($typenow == 'directory' || $typenow == 'structure') {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
        if($info_taxonomy) :
        wp_dropdown_categories(array(
			'show_option_all' => sprintf( __('All %s','wa-rsfp'), $info_taxonomy->label),
			// 'show_option_none'=> __("—",'wa-rsfp'),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => false,
			'hide_empty'      => true,
			'hide_if_empty'   => true,
			'hierarchical' 		=> 1,
			'value_field' 		=> 'slug', // Permet de recuperer la query pour selectionner
		));
        endif;
    };
    
    // Thematic
    $taxonomy  = 'thematic';
	if ($typenow == 'directory' || $typenow == 'operation') {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
        if($info_taxonomy) :
        wp_dropdown_categories(array(
			'show_option_all' => sprintf( __('All %s','wa-rsfp'), $info_taxonomy->label),
			// 'show_option_none'=> __("—",'wa-rsfp'),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
			'hide_if_empty'   => true,
			'hierarchical' 		=> 1,
			'value_field' 		=> 'slug', // Permet de recuperer la query pour selectionner
		));
        endif;
    };

    // Thematic
    $taxonomy  = 'partner_type';
	if ($typenow == 'partner') {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
        if($info_taxonomy) :
		wp_dropdown_categories(array(
			'show_option_all' => sprintf( __('All %s','wa-rsfp'), $info_taxonomy->label),
			// 'show_option_none'=> __("—",'wa-rsfp'),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
			'hide_if_empty'   => true,
			'hierarchical' 		=> 1,
			'value_field' 		=> 'slug', // Permet de recuperer la query pour selectionner
		));
        endif;
	};
	
	// Authors 
	if ($typenow == 'directory' || $typenow == 'farm' || $typenow == 'structure' || $typenow == 'operation' || $typenow == 'partner') {
		wp_dropdown_users(array(
			'name'              => 'author',
			'show_option_all' 	=> __("All Authors",'wa-rsfp'),
			// 'show_option_none'	=> __("—",'wa-rsfp'),
			'multi'         		=> 1,
			'orderby'         	=> 'display_name',
        	'role' 				=> array('administrator'), // Limt by role
			'selected' 			=> !empty($_GET['author']) ? $_GET['author'] : 0, // Permet de recuperer la query pour selectionner
	        'include_selected'  => false,
		));
	}

}

/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
// add_filter('parse_query', 'rsfp_filter_convert_id_to_term_in_query');
// function rsfp_filter_convert_id_to_term_in_query($query) {
// 	global $pagenow;
// 	$post_type = 'team'; // change to your post type
// 	$taxonomy  = 'group'; // change to your taxonomy
// 	$q_vars    = &$query->query_vars;
// 	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
// 		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
// 		$q_vars[$taxonomy] = $term->slug;
// 	}
// }



/**
 * Add extra dropdowns to the List Tables
 *
 * @param required string $post_type    The Post Type that is being displayed
 */
 
/*
 Farms 
*/

add_action('restrict_manage_posts', 'rsfp_filter_directory_by_metafield_farms');
function rsfp_filter_directory_by_metafield_farms($post_type){
    global $wpdb;

    /** Ensure this is the correct Post Type*/
    if($post_type !== 'directory')
        return;

    /** Grab the results from the DB */
	$farms = array();
    $sql = <<<SQL
    SELECT
    wp_postmeta.meta_key,
    wp_postmeta.meta_value,
    wp_posts.ID,
    wp_posts.post_title,
    COUNT(*) as count
    FROM
    wp_postmeta,
    wp_posts
    WHERE
    wp_postmeta.meta_key LIKE 'd_relationships_farm'
    AND wp_postmeta.meta_value = wp_posts.ID
    GROUP BY
    wp_postmeta.meta_value
    SQL;
    
    $posts = $wpdb->get_results($sql);

    /** Ensure there are options to show */
    if(empty($posts))
        return;
    
    foreach($posts as $post) {
      $farms[] = array(
        'ID' => $post->ID,
        'value' => $post->post_title,
        'count' => $post->count,
        );
    }
    
    // Re-order
    $value = array_column($farms, 'value');
	array_multisort($value, SORT_ASC, $farms);


    // get selected option if there is one selected
    if (isset( $_GET['rsfp_farm_pids'] ) && $_GET['rsfp_farm_pids'] != '') {
        $selectedFarm = $_GET['rsfp_farm_pids'];
    } else {
        $selectedFarm = -1;
    }

    /** Grab all of the options that should be shown */
    $options[] = sprintf('<option value="-1">%1$s</option>', __('All Farms', 'wa-rsfp'));
    foreach($farms as $farm) :
        $options[] = sprintf('<option value="%s" %s>%s</option>', 
            (int)$farm['ID'],
            ($farm['ID'] == $selectedFarm)?'selected':'',
            //esc_attr($farm['value'] . ' → '.(int)$farm['ID'] . ' ('.(int)$farm['count'].')'),
            esc_attr($farm['value'] . '  ('.(int)$farm['count'].')'),
        );
    endforeach;

    /** Output the dropdown menu */
    echo '<select class="" id="rsfp_farm_pids" name="rsfp_farm_pids">';
    echo join("\n", $options);
    echo '</select>';

}

/**
 * Usage:
 * http://example.com/wp-admin/edit.php?my_pids=4088,4090,4092,4094
 */
//add_filter( 'pre_get_posts', 'limit_directory_list_byfarmid', 80 );
function limit_directory_list_byfarmid( $query ) 
{
    // Don't run on frontend
    if( !is_admin() )
        return $query;

    global $pagenow;
    global $wpdb;
    
    // Ensure this is the correct Post Type
    if ( isset($_GET['post_type']) ) 
    	$post_type = esc_attr($_GET['post_type']);
    else 
    	$post_type = ''; 
    
    if( $post_type !== 'directory')
        return $query;

    // Restrict to Edit page
    if( 'edit.php' !== $pagenow )
        return $query;

    // Check for our filter
    if( !isset( $_GET['rsfp_farm_pids'] ) )
        return $query;
        
    $limit_posts = array();
    $farm_pids = (int)$_GET['rsfp_farm_pids'];
    // echo('###DEBUG');
    // print_r($farm_pids);
        
    $sql = <<<SQL
    SELECT
    wp_postmeta.meta_value,
    wp_postmeta.post_id
    FROM
    wp_postmeta
    WHERE
    wp_postmeta.meta_value = {$farm_pids}
    AND wp_postmeta.meta_key LIKE 'farms'
    SQL;

    $posts = $wpdb->get_results($sql);
    foreach($posts as $post) {
    	$limit_posts[] = $post->post_id;
    }    
    //print_r($limit_posts);
    
	//  Check if existing post__in 
	$post__in = $query->get( 'post__in');
	//print_r($post__in);

    // Finally, filter
    $query->set( 'post__in', array_merge($post__in,$limit_posts) );      

    return $query;
}


/*
 Operations 
*/

add_action('restrict_manage_posts', 'rsfp_filter_directory_by_metafield_operations');
function rsfp_filter_directory_by_metafield_operations($post_type){
    global $wpdb;

    /** Ensure this is the correct Post Type*/
    if($post_type !== 'directory')
        return;

    /** Grab the results from the DB */
	$operations = array();
    $sql = <<<SQL
    SELECT
    wp_postmeta.meta_key,
    wp_postmeta.meta_value,
    wp_posts.ID,
    wp_posts.post_title,
    COUNT(*) as count
    FROM
    wp_postmeta,
    wp_posts
    WHERE
    wp_postmeta.meta_key LIKE 'd_relationships_operation'
    AND wp_postmeta.meta_value = wp_posts.ID
    GROUP BY
    wp_postmeta.meta_value
    SQL;
    
    $posts = $wpdb->get_results($sql);

    /** Ensure there are options to show */
    if(empty($posts))
        return;
    
    foreach($posts as $post) {
      $operations[] = array(
        'ID' => $post->ID,
        'value' => $post->post_title,
        'count' => $post->count,
        );
    }
    
    // Re-order
    $value = array_column($operations, 'value');
	array_multisort($value, SORT_ASC, $operations);


    // get selected option if there is one selected
    if (isset( $_GET['rsfp_operation_pids'] ) && $_GET['rsfp_operation_pids'] != '') {
        $selectedOperation = $_GET['rsfp_operation_pids'];
    } else {
        $selectedOperation = -1;
    }

    /** Grab all of the options that should be shown */
    $options[] = sprintf('<option value="-1">%1$s</option>', __('All Operations', 'wa-rsfp'));
    foreach($operations as $operation) :
        $options[] = sprintf('<option value="%s" %s>%s</option>', 
            (int)$operation['ID'],
            ($operation['ID'] == $selectedOperation)?'selected':'',
            //esc_attr($operation['value'] . ' → '.(int)$operation['ID'] . ' ('.(int)$operation['count'].')'),
            esc_attr($operation['value'] . '  ('.(int)$operation['count'].')'),
        );
    endforeach;

    /** Output the dropdown menu */
    echo '<select class="" id="rsfp_operation_pids" name="rsfp_operation_pids">';
    echo join("\n", $options);
    echo '</select>';

}

/**
 * Usage:
 * http://example.com/wp-admin/edit.php?my_pids=4088,4090,4092,4094
 */
//add_filter( 'pre_get_posts', 'limit_directory_list_byoperationid', 80 );
function limit_directory_list_byoperationid( $query ) 
{
    // Don't run on frontend
    if( !is_admin() )
        return $query;

    global $pagenow;
    global $wpdb;
    
    // Ensure this is the correct Post Type
    if ( isset($_GET['post_type']) ) 
    	$post_type = esc_attr($_GET['post_type']);
    else 
    	$post_type = ''; 
    
    if( $post_type !== 'directory')
        return $query;

    // Restrict to Edit page
    if( 'edit.php' !== $pagenow )
        return $query;

    // Check for our filter
    if( !isset( $_GET['rsfp_operation_pids'] ) )
        return $query;
        
    $limit_posts = array();
    $operation_pids = (int)$_GET['rsfp_operation_pids'];
    //   echo('###DEBUG');
    //   print_r($operation_pids);
        
    $sql = <<<SQL
    SELECT
    wp_postmeta.meta_value,
    wp_postmeta.post_id
    FROM
    wp_postmeta
    WHERE
    wp_postmeta.meta_value = {$operation_pids}
    AND wp_postmeta.meta_key LIKE 'operations'
    SQL;

    $posts = $wpdb->get_results($sql);
    foreach($posts as $post) {
    	$limit_posts[] = $post->post_id;
    }    
    //    print_r($limit_posts);
    
	//  Check if existing post__in 
	$post__in = $query->get( 'post__in');
	//print_r($post__in);

    // Finally, filter
    $query->set( 'post__in', array_merge($post__in,$limit_posts) );      

    return $query;
}


/*
 Structures 
*/

add_action('restrict_manage_posts', 'rsfp_filter_directory_by_metafield_structures');
function rsfp_filter_directory_by_metafield_structures($post_type){
    global $wpdb;

    /** Ensure this is the correct Post Type*/
    if($post_type !== 'directory')
        return;

    /** Grab the results from the DB */
	$structures = array();
    $sql = <<<SQL
    SELECT
    wp_postmeta.meta_key,
    wp_postmeta.meta_value,
    wp_posts.ID,
    wp_posts.post_title,
    COUNT(*) as count
    FROM
    wp_postmeta,
    wp_posts
    WHERE
    wp_postmeta.meta_key LIKE 'd_relationships_structure'
    AND wp_postmeta.meta_value = wp_posts.ID
    GROUP BY
    wp_postmeta.meta_value
    SQL;
    
    $posts = $wpdb->get_results($sql);

    /** Ensure there are options to show */
    if(empty($posts))
        return;
    
    foreach($posts as $post) {
      $structures[] = array(
        'ID' => $post->ID,
        'value' => $post->post_title,
        'count' => $post->count,
        );
    }
    
    // Re-order
    $value = array_column($structures, 'value');
	array_multisort($value, SORT_ASC, $structures);


    // get selected option if there is one selected
    if (isset( $_GET['rsfp_structure_pids'] ) && $_GET['rsfp_structure_pids'] != '') {
        $selectedStructure = $_GET['rsfp_structure_pids'];
    } else {
        $selectedStructure = -1;
    }

    /** Grab all of the options that should be shown */
    $options[] = sprintf('<option value="-1">%1$s</option>', __('All Structures', 'wa-rsfp'));
    foreach($structures as $structure) :
        $options[] = sprintf('<option value="%s" %s>%s</option>', 
            (int)$structure['ID'],
            ($structure['ID'] == $selectedStructure)?'selected':'',
            //esc_attr($structure['value'] . ' → '.(int)$structure['ID'] . ' ('.(int)$structure['count'].')'),
            esc_attr($structure['value'] . '  ('.(int)$structure['count'].')'),
        );
    endforeach;

    /** Output the dropdown menu */
    echo '<select class="" id="rsfp_structure_pids" name="rsfp_structure_pids">';
    echo join("\n", $options);
    echo '</select>';

}

/**
 * Usage:
 * http://example.com/wp-admin/edit.php?my_pids=4088,4090,4092,4094
 */
//add_filter( 'pre_get_posts', 'limit_directory_list_bystructureid', 80 );
function limit_directory_list_bystructureid( $query ) 
{
    // Don't run on frontend
    if( !is_admin() )
        return $query;

    global $pagenow;
    global $wpdb;
    
    // Ensure this is the correct Post Type
    if ( isset($_GET['post_type']) ) 
    	$post_type = esc_attr($_GET['post_type']);
    else 
    	$post_type = ''; 
    
    if( $post_type !== 'directory')
        return $query;

    // Restrict to Edit page
    if( 'edit.php' !== $pagenow )
        return $query;

    // Check for our filter
    if( !isset( $_GET['rsfp_structure_pids'] ) )
        return $query;
        
    $limit_posts = array();
    $structure_pids = (int)$_GET['rsfp_structure_pids'];
    //   echo('###DEBUG');
    //   print_r($structure_pids);
        
    $sql = <<<SQL
    SELECT
    wp_postmeta.meta_value,
    wp_postmeta.post_id
    FROM
    wp_postmeta
    WHERE
    wp_postmeta.meta_value = {$structure_pids}
    AND wp_postmeta.meta_key LIKE 'structures'
    SQL;

    $posts = $wpdb->get_results($sql);
    foreach($posts as $post) {
    	$limit_posts[] = $post->post_id;
    }    
    //    print_r($limit_posts);
    
	//  Check if existing post__in 
	$post__in = $query->get( 'post__in');
	//print_r($post__in);

    // Finally, filter
    $query->set( 'post__in', array_merge($post__in,$limit_posts) );      

    return $query;
}


/*
 Partners 
*/

add_action('restrict_manage_posts', 'rsfp_filter_directory_by_metafield_partners');
function rsfp_filter_directory_by_metafield_partners($post_type){
    global $wpdb;

    /** Ensure this is the correct Post Type*/
    if($post_type !== 'directory')
        return;

    /** Grab the results from the DB */
	$partners = array();
    $sql = <<<SQL
    SELECT
    wp_postmeta.meta_key,
    wp_postmeta.meta_value,
    wp_posts.ID,
    wp_posts.post_title,
    COUNT(*) as count
    FROM
    wp_postmeta,
    wp_posts
    WHERE
    wp_postmeta.meta_key LIKE 'd_relationships_partner'
    AND wp_postmeta.meta_value = wp_posts.ID
    GROUP BY
    wp_postmeta.meta_value
    SQL;
    
    $posts = $wpdb->get_results($sql);

    /** Ensure there are options to show */
    if(empty($posts))
        return;
    
    foreach($posts as $post) {
      $partners[] = array(
        'ID' => $post->ID,
        'value' => $post->post_title,
        'count' => $post->count,
        );
    }
    
    // Re-order
    $value = array_column($partners, 'value');
	array_multisort($value, SORT_ASC, $partners);


    // get selected option if there is one selected
    if (isset( $_GET['rsfp_partner_pids'] ) && $_GET['rsfp_partner_pids'] != '') {
        $selectedPartner = $_GET['rsfp_partner_pids'];
    } else {
        $selectedPartner = -1;
    }

    /** Grab all of the options that should be shown */
    $options[] = sprintf('<option value="-1">%1$s</option>', __('All Partners', 'wa-rsfp'));
    foreach($partners as $partner) :
        $options[] = sprintf('<option value="%s" %s>%s</option>', 
            (int)$partner['ID'],
            ($partner['ID'] == $selectedPartner)?'selected':'',
            //esc_attr($partner['value'] . ' → '.(int)$partner['ID'] . ' ('.(int)$partner['count'].')'),
            esc_attr($partner['value'] . '  ('.(int)$partner['count'].')'),
        );
    endforeach;

    /** Output the dropdown menu */
    echo '<select class="" id="rsfp_partner_pids" name="rsfp_partner_pids">';
    echo join("\n", $options);
    echo '</select>';

}

/**
 * Usage:
 * http://example.com/wp-admin/edit.php?my_pids=4088,4090,4092,4094
 */
//add_filter( 'pre_get_posts', 'limit_directory_list_bypartnerid', 80 );
function limit_directory_list_bypartnerid( $query ) 
{
    // Don't run on frontend
    if( !is_admin() )
        return $query;

    global $pagenow;
    global $wpdb;
    
    // Ensure this is the correct Post Type
    if ( isset($_GET['post_type']) ) 
    	$post_type = esc_attr($_GET['post_type']);
    else 
    	$post_type = ''; 
    
    if( $post_type !== 'directory')
        return $query;

    // Restrict to Edit page
    if( 'edit.php' !== $pagenow )
        return $query;

    // Check for our filter
    if( !isset( $_GET['rsfp_partner_pids'] ) )
        return $query;
        
    $limit_posts = array();
    $partner_pids = (int)$_GET['rsfp_partner_pids'];
    //   echo('###DEBUG');
    //   print_r($partner_pids);
        
    $sql = <<<SQL
    SELECT
    wp_postmeta.meta_value,
    wp_postmeta.post_id
    FROM
    wp_postmeta
    WHERE
    wp_postmeta.meta_value = {$partner_pids}
    AND wp_postmeta.meta_key LIKE 'partners'
    SQL;

    $posts = $wpdb->get_results($sql);
    foreach($posts as $post) {
    	$limit_posts[] = $post->post_id;
    }    
    //    print_r($limit_posts);

	//  Check if existing post__in 
	$post__in = $query->get( 'post__in');
	//print_r($post__in);

    // Finally, filter
    $query->set( 'post__in', array_merge($post__in,$limit_posts) );      

    return $query;
}





// TODO RSFP > Reduire + ajouter les ID des posts metas 



/**
 * Extend WordPress search to include custom fields
 *
 * https://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
add_filter( 'posts_join', 'directory_search_join' );
add_filter( 'posts_join', 'farm_search_join' );
add_filter( 'posts_join', 'structure_search_join' );
add_filter( 'posts_join', 'operation_search_join' );
add_filter( 'posts_join', 'partner_search_join' );
function directory_search_join ( $join ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'directory' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}
function farm_search_join ( $join ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'farm' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}
function structure_search_join ( $join ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'structure' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}
function operation_search_join ( $join ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'operation' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}
function partner_search_join ( $join ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'partner' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
add_filter( 'posts_where', 'directory_search_where' );
add_filter( 'posts_where', 'farm_search_where' );
add_filter( 'posts_where', 'structure_search_where' );
add_filter( 'posts_where', 'operation_search_where' );
add_filter( 'posts_where', 'partner_search_where' );
function directory_search_where( $where ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "film".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'directory' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        // Searching for all from 's' var
        $s = get_search_query();

        // Search into farm
        $f_args = array(
            'post_type' => 'farm',
            's' => $s,
            'post_status' => 'publish',
            'fields' => 'ids'
        );
        $f_results = get_posts($f_args);
        $f_results_list = implode(',', $f_results);

        // Search into operation
        $o_args = array(
            'post_type' => 'operation',
            's' => $s,
            'post_status' => 'publish',
            'fields' => 'ids'
        );
        $o_results = get_posts($o_args);
        $o_results_list = implode(',', $o_results);

        // Search into structure
        $s_args = array(
            'post_type' => 'structure',
            's' => $s,
            'post_status' => 'publish',
            'fields' => 'ids'
        );
        $s_results = get_posts($s_args);
        $s_results_list = implode(',', $s_results);

        // Search into partner
        $p_args = array(
            'post_type' => 'partner',
            's' => $s,
            'post_status' => 'publish',
            'fields' => 'ids'
        );
        $p_results = get_posts($p_args);
        $p_results_list = implode(',', $p_results);

        // Add additionnal where cause for belongs post types
        $additionnal_where = '';
        if ( !empty($f_results) ) $additionnal_where .= " OR (" . $wpdb->postmeta . ".meta_key = 'd_relationships_farm' AND " . $wpdb->postmeta . ".meta_value IN (" . $f_results_list . ") )";
        if ( !empty($o_results) ) $additionnal_where .= " OR (" . $wpdb->postmeta . ".meta_key = 'd_relationships_operation' AND " . $wpdb->postmeta . ".meta_value IN (" . $o_results_list . ") )";
        if ( !empty($s_results) ) $additionnal_where .= " OR (" . $wpdb->postmeta . ".meta_key = 'd_relationships_structure' AND " . $wpdb->postmeta . ".meta_value IN (" . $s_results_list . ") )";
        if ( !empty($p_results) ) $additionnal_where .= " OR (" . $wpdb->postmeta . ".meta_key = 'd_relationships_partner' AND " . $wpdb->postmeta . ".meta_value IN (" . $p_results_list . ") )";

        // Provide search inside all metas + specific belongs post types
        $where = preg_replace(
            "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)" . $additionnal_where, $where );

    }
    return $where;
}
function farm_search_where( $where ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'farm' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        // Searching for all from 's' var
        $s = get_search_query();

        // Search into directory
        $d_args = array(
            'post_type' => 'directory',
            's' => $s,
            'post_status' => 'publish',
            'fields' => 'ids'
        );
        $d_results = get_posts($d_args);
        $d_results_list = implode(',', $d_results);

        // Then search belongs
        $meta_key = 'd_relationships_' . $_GET['post_type'];
        $sql = <<<SQL
    SELECT
      wp_postmeta.meta_value
    FROM
      wp_postmeta,
      wp_posts
    WHERE
      wp_postmeta.meta_key LIKE '{$meta_key}'
      AND wp_posts.ID IN ({$d_results_list})
      AND wp_posts.post_status IN ('publish','pending')
    SQL;
        $f_results = $wpdb->get_results($sql);
        $f_results_list = wp_list_pluck( $f_results, 'meta_value' );
        $f_results_list = implode(',', $f_results_list);

        // Add additionnal where cause for belongs post types
        $additionnal_where = '';
        if ( !empty($d_results) ) $additionnal_where .= " OR (" . $wpdb->posts . ".ID IN (" . $f_results_list . ") )";

        // Provide search inside all metas + specific belongs post types
        $where = preg_replace(
            "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)" . $additionnal_where, $where );
    }
    return $where;
}
function structure_search_where( $where ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'structure' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        // Searching for all from 's' var
        $s = get_search_query();

        // Search into directory
        $d_args = array(
            'post_type' => 'directory',
            's' => $s,
            'post_status' => 'publish',
            'fields' => 'ids'
        );
        $d_results = get_posts($d_args);
        $d_results_list = implode(',', $d_results);

        // Then search belongs
        $meta_key = 'd_relationships_' . $_GET['post_type'];
        $sql = <<<SQL
    SELECT
      wp_postmeta.meta_value
    FROM
      wp_postmeta,
      wp_posts
    WHERE
      wp_postmeta.meta_key LIKE '{$meta_key}'
      AND wp_posts.ID IN ({$d_results_list})
      AND wp_posts.post_status IN ('publish','pending')
    SQL;
        $f_results = $wpdb->get_results($sql);
        $f_results_list = wp_list_pluck( $f_results, 'meta_value' );
        $f_results_list = implode(',', $f_results_list);

        // Add additionnal where cause for belongs post types
        $additionnal_where = '';
        if ( !empty($d_results) ) $additionnal_where .= " OR (" . $wpdb->posts . ".ID IN (" . $f_results_list . ") )";

        // Provide search inside all metas + specific belongs post types
        $where = preg_replace(
            "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)" . $additionnal_where, $where );
    }
    return $where;
}
function operation_search_where( $where ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'operation' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        // Searching for all from 's' var
        $s = get_search_query();

        // Search into directory
        $d_args = array(
            'post_type' => 'directory',
            's' => $s,
            'post_status' => 'publish',
            'fields' => 'ids'
        );
        $d_results = get_posts($d_args);
        $d_results_list = implode(',', $d_results);

        // Then search belongs
        $meta_key = 'd_relationships_' . $_GET['post_type'];
        $sql = <<<SQL
    SELECT
      wp_postmeta.meta_value
    FROM
      wp_postmeta,
      wp_posts
    WHERE
      wp_postmeta.meta_key LIKE '{$meta_key}'
      AND wp_posts.ID IN ({$d_results_list})
      AND wp_posts.post_status IN ('publish','pending')
    SQL;
        $f_results = $wpdb->get_results($sql);
        $f_results_list = wp_list_pluck( $f_results, 'meta_value' );
        $f_results_list = implode(',', $f_results_list);

        // Add additionnal where cause for belongs post types
        $additionnal_where = '';
        if ( !empty($d_results) ) $additionnal_where .= " OR (" . $wpdb->posts . ".ID IN (" . $f_results_list . ") )";

        // Provide search inside all metas + specific belongs post types
        $where = preg_replace(
            "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)" . $additionnal_where, $where );
    }
    return $where;
}
function partner_search_where( $where ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'partner' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        // Searching for all from 's' var
        $s = get_search_query();

        // Search into directory
        $d_args = array(
            'post_type' => 'directory',
            's' => $s,
            'post_status' => 'publish',
            'fields' => 'ids'
        );
        $d_results = get_posts($d_args);
        $d_results_list = implode(',', $d_results);

        // Then search belongs
        $meta_key = 'd_relationships_' . $_GET['post_type'];
        $sql = <<<SQL
    SELECT
      wp_postmeta.meta_value
    FROM
      wp_postmeta,
      wp_posts
    WHERE
      wp_postmeta.meta_key LIKE '{$meta_key}'
      AND wp_posts.ID IN ({$d_results_list})
      AND wp_posts.post_status IN ('publish','pending')
    SQL;
        $f_results = $wpdb->get_results($sql);
        $f_results_list = wp_list_pluck( $f_results, 'meta_value' );
        $f_results_list = implode(',', $f_results_list);

        // Add additionnal where cause for belongs post types
        $additionnal_where = '';
        if ( !empty($d_results) ) $additionnal_where .= " OR (" . $wpdb->posts . ".ID IN (" . $f_results_list . ") )";

        // Provide search inside all metas + specific belongs post types
        $where = preg_replace(
            "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)" . $additionnal_where, $where );
    }
    return $where;
}

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );