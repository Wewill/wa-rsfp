<?php

/**
 * Register the blocks w/ metabox.io
 *
 * @since    1.1.0
 */

//**
// Allow
// */

// Allow custom blocks considering post_type 
function allow_blocks() {
	// Blocks 
	add_filter( 'allowed_block_types_all', 'post_type_allowed_block_types', 10, 2 );

}


function post_type_allowed_block_types( $allowed_blocks, $editor_context ) {

	// directory
	if ( isset( $editor_context->post ) && $editor_context->post->post_type === 'directory' ) {
		return array(
			'core/image', 
			'core/heading', 
			'core/paragraph', 
			'core/list', 
			'core/quote', 
			'core/pullquote', 
			'core/block', 
			'core/button', 
			'core/buttons', 
			'core/column', 
			'core/columns', 
			'core/table', 
			'core/text-columns', 
			//
			'coblocks/accordion',
			'coblocks/accordion-item',
			'coblocks/alert',
			'coblocks/counter',
			'coblocks/column',
			'coblocks/row',
			'coblocks/dynamic-separator',
			'coblocks/logos',
			'coblocks/icon',
			'coblocks/buttons',			
			// Remplacez ceci par l'identifiant du bloc que vous souhaitez autoriser
			// Ajoutez d'autres identifiants de blocs au besoin
			// 'directory/wa-rsfp-directory-block',
		);
	}

	// Because the thme restrict the blocks, add here custom blocks created in plugin
	// Add custom block
	$allowed_blocks[] = 'directory/wa-rsfp-directory-block';
	// Add metabox.io testimony block
	$allowed_blocks[] = 'meta-box/read-more';

	return $allowed_blocks;
}		

//**	
// Register
// */

// Register Theme Blocks >> need rwmb_meta_boxes
// Register via MetaBox.io block
function register_custom_blocks() {
	// Blocks
	add_filter( 'rwmb_meta_boxes', 'wa_rsfp_register_blocks');

}

function wa_rsfp_register_blocks( $meta_boxes ) {
	$prefix = 'wa_rsfp_';

	/**
	 * Test block
	 */
	$meta_boxes[] = [
		'title'           => __( '(RSFP) Read more', 'wa-rsfp' ),
        'description' => __( 'Adds a read more block to cut long text for catalog maker', 'wa-rsfp' ),
		'id'              => 'read-more',
        'icon'        	  => 'editor-insertmore',
		'supports'        => [
            'customClassName' => false,
		],
        'render_code' => '<!-- Read more for catalog maker purpose -->
		<more id="{{ post_id }}" {{ attribute }}></more>
		<!-- END : Read more for catalog maker purpose -->
		',
		'type'            => 'block',
		'context'         => 'content',
		'fields'          => [],
		'icon'            => [
            'foreground' 	=> '#ff4400ff',
			'src' 			=> 'format-standard',
		],
	];

	return $meta_boxes;
}