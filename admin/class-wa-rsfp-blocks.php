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
	// $allowed_blocks[] = 'meta-box/test';

	return $allowed_blocks;
}		

//**	
// Register
// */

// Register Theme Blocks >> need rwmb_meta_boxes
// Register via MetaBox.io block
function register_custom_blocks() {
	// Blocks
	// add_filter( 'rwmb_meta_boxes', 'register_blocks');

}

function register_blocks( $meta_boxes ) {
	$prefix = 'waff_rsfp_';

	/**
	 * Test block
	 */
	$meta_boxes[] = [
		'title'           => __( 'Test', 'wa-rsfp' ),
		'id'              => 'test',
		'icon'            => 'admin-generic',
		'supports'        => [
			'align' => [''],
		],
		'render_callback' => function( $attributes, $preview, $post_id ) {
			?>
			<div class="testimonial testimonial--<?= mb_get_block_field( 'style' ) ?>">
			<b>Default block page :</b>
				<div class="testimonial__text">
					Inner blocks : 
					<InnerBlocks />
				</div>
				<div class="testimonial__image">
					Block fields (some_text):
					<?php mb_the_block_field( 'waff_blocks_some_text' ) ?>
				</div>
				<div class="testimonial__desc">
					Post fields (description): 
					A:<?php echo rwmb_meta( 'd_general_subtitle', $post_id ) ?>
					B:<?php echo get_post_meta($post_id, 'd_general_subtitle', true) ?>
				</div>
			</div>
			<?php
		},
		'type'            => 'block',
		'context'         => 'content',
		'fields'          => [
			[
				'name' => __( 'Text', 'wa-rsfp' ),
				'id'   => $prefix . 'text_vpj8e9ong3',
				'type' => 'text',
			],
			[
				'name' => __( 'Some text', 'wa-rsfp' ),
				'id'   => $prefix . 'some_text',
				'type' => 'text',
			],
			[
				'type' => 'select',
				'id'   => 'style',
				'name' => 'Style',
				'options' => [
					'default'     => 'Default',
					'image_above' => 'Image above',
				],
			],
			[
				'type' => 'single_image',
				'id'   => 'image',
				'name' => 'Image',
			],
		],
	];

	return $meta_boxes;
}