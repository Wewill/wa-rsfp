<?php

/**
 * Register the blocks.
 *
 * @since    1.1.0
 */
function register_blocks() {
	$prefix = 'waff_blocks_';

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
					A:<?php echo rwmb_meta( 'description', $post_id ) ?>
					B:<?php echo get_post_meta($post_id, 'description', true) ?>
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