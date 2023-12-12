<?php
/*
	Customize Columns 
	http://code.tutsplus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
*/

/*
--------------
USER
*/

/*
  Adds Post Counts by Post Type per User in the User List withing WordPress' Admin console (URL path => /wp-admin/users.php)
  Written for: http://wordpress.stackexchange.com/questions/3233/showing-users-post-counts-by-custom-post-type-in-the-admins-user-list
  By: Mike Schinkel (http://mikeschinkel.com)
  Date: 24 October 2010
*/

add_filter('manage_users_columns' , 'add_extra_user_column', 20);
function add_extra_user_column($columns) {
    unset($columns['posts']);
    return array_merge( $columns, 
              array(
              		'posted' => __( 'Posted', 'wa-rsfp'),
              		)
              );
}


add_filter('manage_users_sortable_columns' , 'add_extra_user_sortable_column', 20);
function add_extra_user_sortable_column($columns) {
    return array_merge( $columns, 
              array(
              		'role' => 'role',
              		)
              );
}

add_action('manage_users_custom_column',  'users_manage_columns', 20, 3);
function users_manage_columns($value, $column_name, $user_id) {
    //$user = get_userdata( $user_id );
    switch ($column_name) {
		case 'posted' :
			$counts = get_author_post_type_counts();
		    $custom_column = array();
		    if (isset($counts[$user_id]) && is_array($counts[$user_id]))
		      foreach($counts[$user_id] as $count) {
		      	$link_to = 'href="'.admin_url('edit.php?post_type='.$count['post_type'].'&author='.$user_id.'&edition=0').'"';
		        $custom_column[] = "\t<tr><th>{$count['label']}</th>" .
		                             "<td><a {$link_to}>{$count['count']}</a></td></tr>";
		      }
		    $custom_column = implode("\n",$custom_column);
		    if (empty($custom_column))
		      $custom_column = "<th> — </th>";
		    $custom_column = "<table>\n{$custom_column}\n</table>";
		    $value = $custom_column;
        default:
            break;
    }
    return $value;
}

/*add_action('pre_user_query','manage_pre_user_query');
function manage_pre_user_query($user_search) {
    global $wpdb,$current_screen;

    if ( 'users' != $current_screen->id ) 
        return;

    $vars = $user_search->query_vars;

    switch ($vars['orderby']) {
		case 'role' :
		        $user_search->query_from .= " INNER JOIN {$wpdb->usermeta} m1 ON {$wpdb->users}.ID=m1.user_id AND (m1.meta_key='role')"; 
		        $user_search->query_orderby = ' ORDER BY UPPER(m1.meta_value) '. $vars['order'];
			break;
        default:
            break;
    }
}*/

function get_author_post_type_counts() {
  static $counts;
  if (!isset($counts)) {
    global $wpdb;
    global $wp_post_types;
    $sql = <<<SQL
	SELECT
	post_type,
	post_author,
	COUNT(*) AS post_count
	FROM
	{$wpdb->posts}
	WHERE 1=1
	AND post_type NOT IN ('revision','nav_menu_item', 'oembed_cache')
	AND post_status IN ('publish','pending')
	GROUP BY
	post_type,
	post_author
	SQL;
    $posts = $wpdb->get_results($sql);
    foreach($posts as $post) {
	    $post_type_object = $wp_post_types[$post_type = $post->post_type];
	     
	    if (!empty($post_type_object->label))
	    	$label = $post_type_object->label;
	    else if (!empty($post_type_object->labels->name))
	    	$label = $post_type_object->labels->name;
	    else
	    	$label = ucfirst(str_replace(array('-','_'),' ',$post_type));
	      	if (!isset($counts[$post_author = $post->post_author]))
	      		$counts[$post_author] = array();
	      	$counts[$post_author][] = array(
	        	'post_type' => $post_type,
	        	'label' => $label,
	        	'count' => $post->post_count,
	        );
    }
  }
  return $counts;
}


/*
--------------
directory
*/


// manage_edit-{$post_type}_columns
add_filter( 'manage_edit-directory_columns', 'directory_columns' ) ;
function directory_columns( $columns ) {
	$columns['_farmers_id'] = __( 'Farmer.s', 'wa-rsfp');
	$columns['_structures_id'] = __( 'Structure.s', 'wa-rsfp');
	$columns['_operations_id'] = __( 'Operation.s', 'wa-rsfp');
	return $columns;
}

// manage_edit-{$post_type}_sortable_columns
add_filter( 'manage_edit-directory_sortable_columns', 'directory_sortable_columns' );
function directory_sortable_columns( $columns ) {
	//$columns['_rsfp_belongs_directory_id'] = '_rsfp_belongs_directory_id';
	return $columns;
}

// manage_{$post_type}_posts_custom_column
add_action("manage_directory_posts_custom_column", 'directory_manage_columns', 10, 2);
function directory_manage_columns($column_name, $post_id) {
    switch ($column_name) {
		/*case '_rsfp_belongs_directory_id' :
			get_directory_byfarmerid($column_name, $post_id);			
			break;*/
		case '_farmers_id' :
		    $custom_column = implode("\n", get_relationship('farmer', $post_id) );
		    if (empty($custom_column))
		      $custom_column = "<th> — </th>";
			$custom_column = "<table>\n{$custom_column}\n</table>";
			//Render
		    echo $custom_column;
            break;
		case '_structures_id' :
		    $custom_column = implode("\n", get_relationship('structure', $post_id) );
		    if (empty($custom_column))
		      $custom_column = "<th> — </th>";
			$custom_column = "<table>\n{$custom_column}\n</table>";
			//Render
		    echo $custom_column;
            break;
		case '_operations_id' :
		    $custom_column = implode("\n", get_relationship('operation', $post_id) );
		    if (empty($custom_column))
		      $custom_column = "<th> — </th>";
			$custom_column = "<table>\n{$custom_column}\n</table>";
			//Render
		    echo $custom_column;
            break;
   		default:
            break;
    }

}


/*
--------------
farmer
*/

// manage_edit-{$post_type}_columns
add_filter( 'manage_edit-farmer_columns', 'farmer_columns' ) ;
function farmer_columns( $columns ) {
	//$columns['posted'] = __( 'Posted', 'wa-rsfp');
	$columns['_rsfp_belongs_directory_id'] = __( 'Farmer belongs to', 'wa-rsfp');
	return $columns;
}

// manage_edit-{$post_type}_sortable_columns
add_filter( 'manage_edit-farmer_sortable_columns', 'farmer_sortable_columns' );
function farmer_sortable_columns( $columns ) {
	//$columns['_rsfp_belongs_directory_id'] = '_rsfp_belongs_directory_id';
	return $columns;
}

// manage_{$post_type}_posts_custom_column
add_action("manage_farmer_posts_custom_column", 'farmer_manage_columns', 10, 2);
function farmer_manage_columns($column_name, $post_id) {
    switch ($column_name) {
		/*case '_rsfp_belongs_directory_id' :
			get_directory_byfarmerid($column_name, $post_id);			
			break;*/
		case '_rsfp_belongs_directory_id' :
			$datas = get_belongs('farmer', $post_id);
		    $custom_column = array();
		    if (isset($datas[$post_id]) && is_array($datas[$post_id]))
		      foreach($datas[$post_id] as $data) {
		      	$link_to = 'href="'.admin_url('edit.php?post_type=directory&rsfp_pids='.$data['ID'].'&farmer_pids='.$post_id).'"';
		        $custom_column[] = "\t<tr><td><strong>• <a {$link_to}>{$data['value']}</a></strong></td></tr>";
		      }
		    $custom_column = implode("\n",$custom_column);
		    if (empty($custom_column))
		      $custom_column = "<th> — </th>";
		    $custom_column = "<table>\n{$custom_column}\n</table>";
		    //Render
		    echo $custom_column;
		default:
            break;
    }
}

/*
--------------
structure
*/

// manage_edit-{$post_type}_columns
add_filter( 'manage_edit-structure_columns', 'structure_columns' ) ;
function structure_columns( $columns ) {
	//$columns['posted'] = __( 'Posted', 'wa-rsfp');
	$columns['_rsfp_belongs_directory_id'] = __( 'Structure belongs to', 'wa-rsfp');
	return $columns;
}

// manage_edit-{$post_type}_sortable_columns
add_filter( 'manage_edit-structure_sortable_columns', 'structure_sortable_columns' );
function structure_sortable_columns( $columns ) {
	//$columns['_rsfp_belongs_directory_id'] = '_rsfp_belongs_directory_id';
	return $columns;
}

// manage_{$post_type}_posts_custom_column
add_action("manage_structure_posts_custom_column", 'structure_manage_columns', 10, 2);
function structure_manage_columns($column_name, $post_id) {
    switch ($column_name) {
		/*case '_rsfp_belongs_directory_id' :
			get_directory_bystructureid($column_name, $post_id);			
			break;*/
		case '_rsfp_belongs_directory_id' :
			$datas = get_belongs('structure', $post_id);
		    $custom_column = array();
		    if (isset($datas[$post_id]) && is_array($datas[$post_id]))
		      foreach($datas[$post_id] as $data) {
		      	$link_to = 'href="'.admin_url('edit.php?post_type=directory&rsfp_pids='.$data['ID'].'&structure_pids='.$post_id).'"';
		        $custom_column[] = "\t<tr><td><strong>• <a {$link_to}>{$data['value']}</a></strong></td></tr>";
		      }
		    $custom_column = implode("\n",$custom_column);
		    if (empty($custom_column))
		      $custom_column = "<th> — </th>";
		    $custom_column = "<table>\n{$custom_column}\n</table>";
		    //Render
		    echo $custom_column;
		default:
            break;
    }
}

/*
--------------
operation
*/

// manage_edit-{$post_type}_columns
add_filter( 'manage_edit-operation_columns', 'operation_columns' ) ;
function operation_columns( $columns ) {
	//$columns['posted'] = __( 'Posted', 'wa-rsfp');
	$columns['_rsfp_belongs_directory_id'] = __( 'Operation belongs to', 'wa-rsfp');
	return $columns;
}

// manage_edit-{$post_type}_sortable_columns
add_filter( 'manage_edit-operation_sortable_columns', 'operation_sortable_columns' );
function operation_sortable_columns( $columns ) {
	//$columns['_rsfp_belongs_directory_id'] = '_rsfp_belongs_directory_id';
	return $columns;
}

// manage_{$post_type}_posts_custom_column
add_action("manage_operation_posts_custom_column", 'operation_manage_columns', 10, 2);
function operation_manage_columns($column_name, $post_id) {
    switch ($column_name) {
		/*case '_rsfp_belongs_directory_id' :
			get_directory_byoperationid($column_name, $post_id);			
			break;*/
		case '_rsfp_belongs_directory_id' :
			$datas = get_belongs('operation', $post_id);
		    $custom_column = array();
		    if (isset($datas[$post_id]) && is_array($datas[$post_id]))
		      foreach($datas[$post_id] as $data) {
		      	$link_to = 'href="'.admin_url('edit.php?post_type=directory&rsfp_pids='.$data['ID'].'&operation_pids='.$post_id).'"';
		        $custom_column[] = "\t<tr><td><strong>• <a {$link_to}>{$data['value']}</a></strong></td></tr>";
		      }
		    $custom_column = implode("\n",$custom_column);
		    if (empty($custom_column))
		      $custom_column = "<th> — </th>";
		    $custom_column = "<table>\n{$custom_column}\n</table>";
		    //Render
		    echo $custom_column;
		default:
            break;
    }
}

/*
--------------
partner
*/

// manage_edit-{$post_type}_columns
add_filter( 'manage_edit-partner_columns', 'partner_columns' ) ;
function partner_columns( $columns ) {
	//$columns['posted'] = __( 'Posted', 'wa-rsfp');
	$columns['_rsfp_belongs_directory_id'] = __( 'Partner belongs to', 'wa-rsfp');
	return $columns;
}

// manage_edit-{$post_type}_sortable_columns
add_filter( 'manage_edit-partner_sortable_columns', 'partner_sortable_columns' );
function partner_sortable_columns( $columns ) {
	//$columns['_rsfp_belongs_directory_id'] = '_rsfp_belongs_directory_id';
	return $columns;
}

// manage_{$post_type}_posts_custom_column
add_action("manage_partner_posts_custom_column", 'partner_manage_columns', 10, 2);
function partner_manage_columns($column_name, $post_id) {
    switch ($column_name) {
		/*case '_rsfp_belongs_directory_id' :
			get_directory_bypartnerid($column_name, $post_id);			
			break;*/
		case '_rsfp_belongs_directory_id' :
			$datas = get_belongs('partner', $post_id);
		    $custom_column = array();
		    if (isset($datas[$post_id]) && is_array($datas[$post_id]))
		      foreach($datas[$post_id] as $data) {
		      	$link_to = 'href="'.admin_url('edit.php?post_type=directory&rsfp_pids='.$data['ID'].'&partner_pids='.$post_id).'"';
		        $custom_column[] = "\t<tr><td><strong>• <a {$link_to}>{$data['value']}</a></strong></td></tr>";
		      }
		    $custom_column = implode("\n",$custom_column);
		    if (empty($custom_column))
		      $custom_column = "<th> — </th>";
		    $custom_column = "<table>\n{$custom_column}\n</table>";
		    //Render
		    echo $custom_column;
		default:
            break;
    }
}


/**
 * Taxonomy : production
 */

add_filter( 'manage_edit-production_columns', 'taxs_columns' ) ;
add_filter( 'manage_edit-thematic_columns', 'taxs_columns' ) ;
function taxs_columns( $columns ) {
	//$columns['p_general_image'] = __( 'Image', 'wa-rsfp');

	$newcols = array();
	foreach($columns as $col_key => $col_title) {
		print( $col_key );
		if ($col_key=='name') // Put the Thumbnail column before the Title column
			$newcols['p_general_image'] = __('<span class="dashicons-before dashicons-visibility" style="color:silver;"></span>', 'wa-rsfp');
		$newcols[$col_key] = $col_title;
	}
	return $newcols;

	//return $columns;
}
 // manage_{$taxonomy}_custom_column
add_filter("manage_production_custom_column", 'taxs_manage_columns', 10, 3);
add_filter("manage_thematic_custom_column", 'taxs_manage_columns', 10, 3);
function taxs_manage_columns($out, $column_name, $term_id) {
    switch ($column_name) {
		case 'p_general_image' :
			$out = '';
			get_image_fromid(get_term_meta( $term_id, $column_name, true));			
			break;
        default:
            break;
    }
    return $out;    
}


/*
	Functions 
*/

/**
 * Usage:
 * http://example.com/wp-admin/edit.php?my_pids=4088,4090,4092,4094
 */
add_filter( 'pre_get_posts', 'limit_post_list_byid' );

function limit_post_list_byid( $query ) 
{
    // Don't run on frontend
    if( !is_admin() )
        return $query;

    global $pagenow;

    // Restrict to Edit page
    if( 'edit.php' !== $pagenow )
        return $query;

    // Check for our filter
    if( !isset( $_GET['rsfp_pids'] ) )
        return $query;

    // Finally, filter
    $limit_posts = explode( ',', $_GET['rsfp_pids'] ); // Convert comma delimited to array    

	//  Check if existing post__in 
	$post__in = $query->get( 'post__in');
	//print_r($post__in);

    // Finally, filter
    //$query->set( 'post__in', $limit_posts );      
    $query->set( 'post__in', array_merge($post__in,$limit_posts) );     

    return $query;
}

// Get Farmer documents 
function get_directory_byfarmerid($column_name, $post_id) {
	if ( empty( $post_id ) )
		echo __( '<span style="color:silver;">—</span>' ); // marker.png
	else
		printf( __( '<h2>%s</h2>' ), $post_id );
}

//Get relationships  
function get_relationship($post_type, $post_id) {
	$post_ids = rwmb_meta( 'd_relationships_'.$post_type, array(), $post_id );
	$ret = array();
	if (isset($post_ids) && is_array($post_ids))
	  foreach($post_ids as $post_id) {
		$ret[] = sprintf(
			'<li data-for="%s" style="display: inline-block;margin-right:5px;">
				<div class="--media-icon image-icon" style="height:63px;width:63px;border:solid 4px white;border-radius: 2px;box-shadow: 1px 1px 4px rgba(0,0,0,.25)">%s</div>
				<strong>• <a href="%s">%s</a></strong>
				<span class="row-actions">
				<a href="%s" title="Afficher dans la liste"><span class="dashicons-before dashicons-search"></span></a> 
				<a href="%s" title="Modifier"><span class="dashicons-before dashicons-edit"></span></a> 
				<a href="%s" title="Voir"><span class="dashicons-before dashicons-visibility"></span></a>
				</span>
			</li>',
			get_the_ID(),
			get_the_post_thumbnail( $post_id, "thumbnail", array('style'=>'height:63px;width:63px;')),
			esc_attr(esc_url(admin_url('edit.php?post_type='.$post_type.'&rsfp_pids='.$post_id))),
			get_the_title( $post_id ),
			esc_attr(esc_url(admin_url('edit.php?post_type='.$post_type.'&rsfp_pids='.$post_id))),
			esc_attr(esc_url(get_permalink( $post_id ))),
			esc_attr(esc_url(get_page_link( $post_id )))
		); //$field['field_name'],
	  }
	return $ret;
}

// Get Directory
function get_belongs($post_type, $post_id) {
	$belongs = array();
    global $wpdb;
    
	$meta_key = 'd_relationships_' . $post_type;
    $sql = <<<SQL
	SELECT
	wp_postmeta.meta_key,
	wp_postmeta.meta_value,
	wp_postmeta.post_id,
	wp_posts.ID,
	wp_posts.post_title
	FROM
	wp_postmeta,
	wp_posts
	WHERE
	wp_postmeta.meta_key LIKE '{$meta_key}'
	AND wp_postmeta.meta_value = {$post_id}
	AND wp_posts.ID = wp_postmeta.post_id
	AND wp_posts.post_status IN ('publish','pending')
	SQL;
    
    $posts = $wpdb->get_results($sql);
    foreach($posts as $post) {
      if (!empty($post->post_title))
        $post_title = $post->post_title;
      else
      	$post_title = '—';
      if (!isset($belongs[$post_id = $post->meta_value]))
        $belongs[$post_id] = array();
		$belongs[$post_id][] = array(
			'ID' => $post->ID,
			'value' => $post_title,
			);
		}
	return $belongs;
}


// Get attachement_id form an image url  
function get_attachment_id_from_url($url) {
	global $wpdb;
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$url'";
	return $wpdb->get_var($query);
}

// Get h2 
function get_h2($fd) {
	if ( empty( $fd ) )
		echo __( '<span style="color:silver;">—</span>' ); // marker.png
	else
		printf( __( '<h2>%s</h2>' ), $fd );
}

// Get price 
function get_price($fd) {
	if ( empty( $fd ) )
		echo __( '<span style="color:silver;">—</span>' ); // marker.png
	else
		printf( __( '<h2>%s €</h2>' ), $fd );
}

// Get percentage 
function get_percentage($fd) {
	if ( empty( $fd ) )
		echo __( '<span style="color:silver;">—</span>' ); // marker.png
	else
		printf( __( '<h2>%s &#37;</h2>' ), $fd );
}

// Get code 
function get_code($fd) {
	if ( empty( $fd ) )
		echo __( '<span style="color:silver;">—</span>' ); // marker.png
	else
		printf( __( '<code>%s</code>' ), $fd );
}

// Get type 
function get_type($fd) {
	global $type;
	$t = $type[$fd];
	if ( empty( $fd ) || $fd == -1 )
		echo __( '<span style="color:silver;">—</span>' ); // marker.png
	if ( !empty( $t ) ) 
		echo __( '<code class="type '.$t.'">'.$t.'</code>');
}

// Get typeid
function get_typeid($fd) {
	if ( !empty( $fd ) )
		printf( __( '<span class="typeid">%s</span>' ), $fd );
}

// Get Image 
function get_image($fd) {
	if ( function_exists( 'wpcf_fields_image_resize_image' ) ) 
		$attachment_id = get_attachment_id_from_url($fd);
		$image = wp_get_attachment_image_src( $attachment_id, 'thumbnail');

	if ( empty( $image ) )
		echo __( '<span class="empty">∅</span>' ); // marker.png
	else
		printf( __( '<div class="tax-img-holder"><img class="wpcf-offre-visuel" src="%s" alt="Image" width="50" /></div>' ), $image[0] );
}

// Get Image 
function get_image_fromid($attachment_id) {
	$image = wp_get_attachment_image_src( $attachment_id, 'thumbnail');
	if ( empty( $image ) )
		echo __( '<span class="empty">—</span>' ); // marker.png
	else
		printf( __( '<div class="tax-img-holder"><img class="wpcf-offre-visuel" src="%s" alt="Image" width="50" /></div>' ), $image[0] );
}

//Get meta
function get_meta_usermeta($column_name, $user_id) {
	$meta = get_user_meta($user_id, $column_name, true );
	if ( empty( $meta ) )
		return __( '<span style="color:silver;">—</span>' );
	else
		return '<h3>' . $meta . '</h3>';
}

//Get meta
function get_meta_usercb($column_name, $user_id) {
	$meta = get_user_meta($user_id, $column_name, true );
	if ( empty( $meta ) )
		return __( '<span style="color:silver;">—</span>' );
	else
		return '<span class="dashicons-before dashicons-yes"></span>';
}

//Get meta
function get_meta($column_name, $post_id) {
	$meta = get_post_meta($post_id, $column_name, true );
	if ( empty( $meta ) )
		echo __( '<span style="color:silver;">—</span>' );
	else
		printf( __( '<h3>%s</h3>' ), $meta);
}

// Get select
function get_select_bymeta($column_name, $post_id) {
	$meta = get_post_meta($post_id, $column_name, true );
	
	$customField = substr($column_name, 5); 
	$fieldConfig = wpcf_admin_fields_get_field($customField);
	$fieldOptions = array();
	if (isset($fieldConfig['data']['options'])) {
	   foreach ($fieldConfig['data']['options'] as $key => $option ) {
	   		if( isset($option['title']) ) 
	   			$fieldOptions[$option['title']] = $option['value'];
	   }
	}
	$found_key = array_search( types_get_field_meta_value( $customField, $post_id, true), $fieldOptions);

	if ( empty( $found_key ) )
		echo __( '<span style="color:silver;">—</span>' );
	else
		printf( __( '<h4>%s</h4>' ), $found_key);
	
}

// Get term meta
function get_edition_termmeta($taxonomy, $term_id) {
	$meta = get_term_meta($term_id, $taxonomy, true );
	$term = get_term( $meta, 'edition');
	$name = $term->name;

	if ( empty( $term ) )
		echo __( '<span style="color:silver;">—</span>' );
	else
		printf( __( '<h2>%s</h2>' ), $name);
	
}

//Get time
function get_time_bymeta($column_name, $post_id) {
	$meta = get_post_meta($post_id, $column_name, true );
	if ( empty( $meta ) )
		echo __( '<span style="color:silver;">—</span>' );
	else
		printf( __( '<h5><span class="dashicons-before dashicons-clock"></span> %s min.</h6>' ), $meta);
}

//Get date
function get_date_bymeta($column_name, $post_id) {
	$meta = get_post_meta($post_id, $column_name, true );

    require_once WPTOOLSET_FORMS_ABSPATH . '/classes/class.date.php';
    $meta = WPToolset_Field_Date::timetodate($meta);

	if ( empty( $meta ) )
		echo __( '<span style="color:silver;">—</span>' );
	else
		printf( __( '%s' ), $meta);
}

// Get post
function get_post_bymeta($column_name, $post_id) {
	$meta = get_post_meta($post_id, $column_name, true );
	$post_title = get_the_title($meta);
	if ( empty( $meta ) )
		echo __( '<span style="color:silver;">—</span>' );
	else
		printf( __( '<h3>%s</h3>' ), $post_title);
}

//Get post w/ ink
function get_postlink_bymeta($column_name, $post_id) {
	$meta = get_post_meta($post_id, $column_name, true );
	$post_title = get_the_title($meta);
	$post_link = get_edit_post_link($meta);
	if ( empty( $meta ) )
		echo __( '<span style="color:silver;">—</span>' );
	else
		printf( __( '<h3><a href="%s">%s</a></h3>' ), $post_link, $post_title);
}

//Get contact 
function get_contactlink_bymeta($column_name, $post_id) {
	$meta = get_post_meta($post_id, $column_name, true );
    
    $ln = get_post_meta($meta, 'wpcf-c-name', true );
	$fn = get_post_meta($meta, 'wpcf-c-firstname', true );
    $post_authorname = $ln . '&nbsp;' . $fn ;
	
	$post_title = get_the_title($meta);
	$post_content = ($ln!='')?$post_authorname:$post_title;
	$post_link = get_edit_post_link($meta);
	if ( empty( $meta ) )
		echo __( '<span style="color:silver;">—</span>' );
	else
		printf( __( '<h3 style="margin-bottom:4px;"><a href="%s">%s</a></h3><small><em>( %s )</em></small>' ), $post_link, $post_content, $post_title);
}

//Get post w/ link in a btn 
function get_postlinkbtn_bymeta($column_name, $post_id) {
	$meta = get_post_meta($post_id, $column_name, true );
	$post_title = get_the_title($meta);
	$post_link = get_edit_post_link($meta);
	if ( empty( $meta ) )
		echo __( '<span style="color:silver;">—</span>' );
	else
		printf( __( '<br/><a href="%s" title="%s" class="page-title-action">View</a>' ), $post_link, $post_title);
}

// Get post
function get_rating_bymeta($column_name, $post_id) {
	$meta = get_post_meta($post_id, $column_name, true );
	if ( empty( $meta ) ) :
		echo __( '<span style="color:silver;">—</span>' );
	else :
		switch($meta) {
			case '1':
				$meta = '	<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-empty"></span>
							<span class="dashicons-before dashicons-star-empty"></span>
							<span class="dashicons-before dashicons-star-empty"></span>
							<span class="dashicons-before dashicons-star-empty"></span>';
			break;
			case '2':
				$meta = '	<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-empty"></span>
							<span class="dashicons-before dashicons-star-empty"></span>
							<span class="dashicons-before dashicons-star-empty"></span>';
			break;
			case '3':
				$meta = '	<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-empty"></span>
							<span class="dashicons-before dashicons-star-empty"></span>';
			break;
			case '4':
				$meta = '	<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-empty"></span>';
			break;
			case '5':
				$meta = '	<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-filled"></span>
							<span class="dashicons-before dashicons-star-filled"></span>';
			break;
		}
		printf( __( '%s' ), $meta);
	endif;
}


//Display Post Thumbnail Also In Edit Post and Page Overview
//http://www.hongkiat.com/blog/wordpress-tweaks-for-post-management/

if ( !function_exists('wa_addthumbcolumn') && function_exists('add_theme_support') ) {

	add_theme_support('post-thumbnails', array( 'directory', 'farmer', 'structure', 'operation', 'partner' ) );
	
	function wa_addthumbcolumn($cols) {

		$newcols = array();
		foreach($cols as $key => $title) {
			if ($key=='title') // Put the Thumbnail column before the Title column
				//$newcols['thumbnail'] = __('Thumbnail');
				$newcols['thumbnail'] = __('<span class="dashicons-before dashicons-visibility" style="color:silver;"></span>');
			$newcols[$key] = $title;
		}
		return $newcols;

	    //$cols['thumbnail'] = __('Thumbnail');
	    //return $cols;
	}
	 
	function wa_addthumbvalue($column_name, $post_id) {
	    $width = (int) 45;
	    $height = (int) 45;
	    if ( 'thumbnail' == $column_name ) {
	        // thumbnail of WP 2.9
	        $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
	         
	        // image from gallery
	        $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
	         
	        if ($thumbnail_id)
	            $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
	        elseif ($attachments) {
	            foreach ( $attachments as $attachment_id => $attachment ) {
	            $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
	        }
	    }
	    if ( isset($thumb) && $thumb ) { echo $thumb; }
	    else { echo __('—'); }
	    }
	}
	 
	// for posts only
	add_filter( 'manage_directory_posts_columns', 'wa_addthumbcolumn' , 99);
	add_action( 'manage_directory_posts_custom_column', 'wa_addthumbvalue', 10, 2 ); // NE PAS AFFICHER SI PRESENT DANS LE THEME

	add_filter( 'manage_farmer_posts_columns', 'wa_addthumbcolumn' , 99);
	add_action( 'manage_farmer_posts_custom_column', 'wa_addthumbvalue', 10, 2 ); // NE PAS AFFICHER SI PRESENT DANS LE THEME

	add_filter( 'manage_structure_posts_columns', 'wa_addthumbcolumn' , 99);
	add_action( 'manage_structure_posts_custom_column', 'wa_addthumbvalue', 10, 2 ); // NE PAS AFFICHER SI PRESENT DANS LE THEME

	add_filter( 'manage_operation_posts_columns', 'wa_addthumbcolumn' , 99);
	add_action( 'manage_operation_posts_custom_column', 'wa_addthumbvalue', 10, 2 ); // NE PAS AFFICHER SI PRESENT DANS LE THEME

	add_filter( 'manage_partner_posts_columns', 'wa_addthumbcolumn' , 99);
	add_action( 'manage_partner_posts_custom_column', 'wa_addthumbvalue', 10, 2 ); // NE PAS AFFICHER SI PRESENT DANS LE THEME
}