<?php

/**
 * Extend meta box UI fields 
 */

class RWMB_PreviewPost_Field extends RWMB_Field {
    public static function html( $meta, $field ) {
		// print_r($field);
		$html = '';
		if ( $field['meta_value'] == null || $field['meta_value'] == '' ) return "No meta_value.";
		$post_ids = rwmb_meta( $field['meta_value'] );
		//print_r($post_ids);
		if ( count($post_ids) > 0 ) :
			$html .= "<ul>";
			foreach( $post_ids as $post_id ) : 
				$html .= sprintf(
					'<li data-for="%s" style="display: inline-block;margin-right:5px;">
						<div class="--media-icon image-icon" style="height:63px;width:63px;border:solid 4px white;border-radius: 2px;box-shadow: 1px 1px 4px rgba(0,0,0,.25)">%s</div>
						• <a href="%s">%s</a>
					</li>',
					$field['id'],
					get_the_post_thumbnail( $post_id, "thumbnail"),
					get_permalink( $post_id ),
					get_the_title( $post_id ),
					
				); //$field['field_name'],
			endforeach;
			$html .= "</ul>";
			return $html;
		else :
			return "Please choose a post.";
		endif;
    }
}