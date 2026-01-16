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
	// See block JS for priority change
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
			'directory/wa-rsfp-directory-block',
			'meta-box/rsfp-readmore'
		);
	}

	// Because the thme restrict the blocks, add here custom blocks created in plugin
	// Add custom block
	//$allowed_blocks[] = 'directory/wa-rsfp-directory-block';
	// Add metabox.io testimony block
	//$allowed_blocks[] = 'meta-box/...';

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
		'id'              => 'rsfp-readmore',
        'icon'        	  => 'editor-insertmore',
		'supports'        => [
            'customClassName' => false,
		],
		'render_callback' => 'wa_rsfp_readmore_callback',
        // 'render_code' => '<!-- Read more for catalog maker purpose -->
		// <more id="{{ post_id }}" {{ attribute }}></more>
		// <!-- END : Read more for catalog maker purpose -->
		// ',
		'type'            => 'block',
		'context'         => 'side',
		'fields'          => [],
		'icon'            => [
            'foreground' 	=> '#ff4400ff',
			'src' 			=> 'format-standard',
		],
	];

	return $meta_boxes;
}

function wa_rsfp_readmore_callback( $attributes ) {
	$is_preview = defined( 'REST_REQUEST' ) && REST_REQUEST ?? true;
	// print_r($is_preview);

	// No data no render.
	//if ( empty( $attributes['data'] ) ) return;

	// Unique HTML ID if available.
	$id = '';
	if ( $attributes['name'] ) {
		$id = $attributes['name'] . '-';
	} elseif (  $attributes['data']['name'] ) {
		$id = $attributes['data']['name'] . '-';
	}
	$id .= ( $attributes['id'] && $attributes['id'] !== $attributes['name']) ? $attributes['id'] : wp_generate_uuid4();
	if ( ! empty( $attributes['anchor'] ) ) {
		$id = $attributes['anchor'];
	}

	// Block margin
	$themeClass = 'readmore';
	$class = $themeClass . ' ' . ( $attributes['className'] ?? '' );
	if ( ! empty( $attributes['align'] ) ) {
		$class .= " align{$attributes['align']}";
	}
	$data = '';
	$animation_class = '';
	if ( ! empty( $attributes['animation'] ) ) {
		$animation_class .= " coblocks-animate";
		$data .= " data-coblocks-animation='{$attributes['animation']}'";
	}
	?>
	<more id="<?= $id ?>" class="<?= $class ?> <?= $animation_class ?>" <?= $data ?>></more>
	<?php
}
