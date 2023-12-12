<?php
/**
 * Register the post types custom meta fields.
 *
 * @since    1.1.0
 */
function register_custom_meta_fields() {
	// Posts
	add_filter( 'rwmb_meta_boxes', 'directory_fields', 10);
	add_filter( 'rwmb_meta_boxes', 'farmer_fields', 10);
	add_filter( 'rwmb_meta_boxes', 'structure_fields', 10);
	add_filter( 'rwmb_meta_boxes', 'operation_fields', 10);
	add_filter( 'rwmb_meta_boxes', 'partner_fields', 10);

	// Taxonomies 
	add_filter( 'rwmb_meta_boxes', 'thematic_fields', 10);
	add_filter( 'rwmb_meta_boxes', 'production_fields', 10);

}

// Posts 
function directory_fields( $meta_boxes ) {
    $prefix = 'd_';

	// General 
    $meta_boxes[] = [
        'title'      => __( 'Directory › General', 'wa-rsfp' ),
        'id'         => 'directory-general',
        'post_types' => ['directory'],
        'fields'     => [
			[
                'name' => __( 'Subtitle', 'wa-rsfp' ),
                'id'   => $prefix . 'general_subtitle',
                'type' => 'text',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Subtitle will be showed after title', 'wa-rsfp' ),
            ],
			[
                'name'              => __( 'Introduction', 'wa-rsfp' ),
                'id'                => $prefix . 'general_introduction',
                'type'              => 'wysiwyg',
                'options'           => [
                    'media_buttons'  => false,
                    'drag_drop_upload' => false,
                    // 'default_editor' => true,
                    'teeny' => true,
                    'textarea_rows'  => 4,
                ],
				'label_description' => __( '<span class="label">INFO</span> Fill with formatted text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Lead content will be showed after title', 'wa-rsfp' ),
            ],
		],
    ];

    // Relationships
    $meta_boxes[] = [
        'title'      => __( 'Directory › Relationships', 'wa-rsfp' ),
        'id'         => 'directory-relationships',
        'post_types' => ['directory'],
        'fields'     => [
            [
                'name'       => __( 'Farmer.s', 'wa-rsfp' ),
                'id'         => $prefix . 'relationships_farmer',
                'type'       => 'post',
                'post_type'  => ['farmer'],
                'field_type' => 'select_advanced',
                'add_new'    => true,
                'multiple'   => true,
                'label_description' => __( '<span class="label">INFO</span> Associate one or many post.s', 'wa-rsfp' ),
                //'desc'              => __( '<span class="label">TIPS</span> Lorem ipsum.', 'wa-rsfp' ),
            ],
            [
                'name' => 'Preview',
                'id'   =>  $prefix . 'relationships_preview_farmer',
                'type' => 'previewpost',
                'meta_value' => $prefix . 'relationships_farmer'
            ],
            [
                'name'       => __( 'Structure.s', 'wa-rsfp' ),
                'id'         => $prefix . 'relationships_structure',
                'type'       => 'post',
                'post_type'  => ['structure'],
                'field_type' => 'select_advanced',
                'add_new'    => true,
                'multiple'   => true,
                'label_description' => __( '<span class="label">INFO</span> Associate one or many post.s', 'wa-rsfp' ),
            ],
            [
                'name' => 'Preview',
                'id'   =>  $prefix . 'relationships_preview_structure',
                'type' => 'previewpost',
                'meta_value' => $prefix . 'relationships_structure'
            ],
            [
                'name'       => __( 'Operation.s', 'wa-rsfp' ),
                'id'         => $prefix . 'relationships_operation',
                'type'       => 'post',
                'post_type'  => ['operation'],
                'field_type' => 'select_advanced',
                'add_new'    => true,
                'multiple'   => true,
                'label_description' => __( '<span class="label">INFO</span> Associate one or many post.s', 'wa-rsfp' ),
            ],
            [
                'name' => 'Preview',
                'id'   =>  $prefix . 'relationships_preview_operation',
                'type' => 'previewpost',
                'meta_value' => $prefix . 'relationships_operation'
            ],
            [
                'name'       => __( 'Partner.s', 'wa-rsfp' ),
                'id'         => $prefix . 'relationships_partner',
                'type'       => 'post',
                'post_type'  => ['partner'],
                'field_type' => 'select_advanced',
                'add_new'    => true,
                'multiple'   => true,
                'label_description' => __( '<span class="label">INFO</span> Associate one or many post.s', 'wa-rsfp' ),
            ],
            [
                'name' => 'Preview',
                'id'   =>  $prefix . 'relationships_preview_partner',
                'type' => 'previewpost',
                'meta_value' => $prefix . 'relationships_partner'
            ],
        ],
    ];

	// Identity 
	$meta_boxes[] = [
		'title'      => __( 'Directory › Identity', 'wa-rsfp' ),
		'id'         => 'directory-identity',
		'post_types' => ['directory'],
		'fields'     => [
			[
                'name' => __( 'Location', 'wa-rsfp' ),
                'id'   => $prefix . 'identity_location',
                'type' => 'text',
                'desc' => __( '<span class="label">TIPS</span> Specify the locality, the commune, the department...', 'wa-rsfp' ),
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
			[
                'name' => __( 'Area (in ha)', 'wa-rsfp' ),
                'id'   => $prefix . 'identity_area',
                'type' => 'text',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
            [
                'name' => __( 'Number of people', 'wa-rsfp' ),
                'id'   => $prefix . 'identity_number_of_people',
                'type' => 'text',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
			[
                'type'       => 'divider',
                'before'      => __( '<span class="label">INFO</span> Production is to define after publishing in side taxonomies.', 'wa-rsfp' ),
                'save_field' => false,
            ],
            [
                'name' => __( 'Livestock', 'wa-rsfp' ),
                'id'   => $prefix . 'identity_livestock',
                'type' => 'text',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
			[
				'name'            => __( 'Label', 'wa-rsfp' ),
				'id'              => $prefix . 'identity_label',
				'type'            => 'checkbox_list',
				'options'         => [
					'bio'  				=> __( 'Agriculteur biologique', 'wa-rsfp' ),
					'demeter' 		=> __( 'Demeter', 'wa-rsfp' ),
				],
				'inline'          => true,
				'select_all_none' => true,
				'label_description' => __( '<span class="label">INFO</span> Choose one or many option.s', 'wa-rsfp' ),
			],
            [
                'name' => __( 'Commercialization', 'wa-rsfp' ),
                'id'   => $prefix . 'identity_commercialization',
                'type' => 'text',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
			[
                'name'              => __( 'Diagram.s', 'wa-rsfp' ),
                'id'                => $prefix . 'identity_diagrams',
                'type'              => 'text_list',
                'label_description' => __( '<span class="label">INFO</span> Fill to create a diagram. Value in %. Make sure total of values is 100%.', 'wa-rsfp' ),
                'options'           => [
                    'Label'       => 'Label',
                    'Description' => 'Description',
                    'Value'       => 'Value',
                ],
                'clone'             => true,
                'sort_clone'        => true,
                'max_clone'         => 100,
            ],
			[
                'name' => __( 'Carbon footprint', 'wa-rsfp' ),
                'id'   => $prefix . 'identity_carbon_footprint',
                'type' => 'text',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
		],
	];

	// Knowledge 
	$meta_boxes[] = [
		'title'      => __( 'Directory › Knowledge', 'wa-rsfp' ),
		'id'         => 'directory-knowledge',
		'post_types' => ['directory'],
		'fields'     => [
			[
                'name'       => __( 'Viability.s', 'wa-rsfp' ),
                'id'         => $prefix . 'knowledge_viabilitys',
                'type'       => 'textarea',
                // 'required'   => true,
                'clone'      => true,
                'sort_clone' => true,
                'limit'      => 100,
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* **bold** ***label*** #small# ##huge##', 'wa-rsfp' ),
            ],
            [
                'name'       => __( 'Vivability.s', 'wa-rsfp' ),
                'id'         => $prefix . 'knowledge_vivabilitys',
                'type'       => 'textarea',
                'clone'      => true,
                'sort_clone' => true,
                'limit'      => 100,
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* **bold** ***label*** #small# ##huge##', 'wa-rsfp' ),
            ],
            [
                'name'    => __( 'Knowledge AP', 'wa-rsfp' ),
                'id'      => $prefix . 'knowledge_knowledge_ap',
                'type'    => 'checkbox_list',
                'options' => [
                    'nature'       		=> __( 'Travail avec la nature', 'wa-rsfp' ),
                    'autonomie'       	=> __( 'Autonomie', 'wa-rsfp' ),
                    'transmissiblite'   => __( 'Transmissiblité', 'wa-rsfp' ),
                    'local'       		=> __( 'Développement local', 'wa-rsfp' ),
                    'repartition'       => __( 'Répartition', 'wa-rsfp' ),
                    'qualite'       	=> __( 'Qualité', 'wa-rsfp' ),
                ],
				'inline'          => true,
				'select_all_none' => true,
				'label_description' => __( '<span class="label">INFO</span> Choose AP acquired kwnoledge.s', 'wa-rsfp' ),
            ],
            [
                'name'       => __( 'Acquisition.s', 'wa-rsfp' ),
                'id'         => $prefix . 'knowledge_acquisitions',
                'type'       => 'text_list',
                'options'    => [
                    ' Date'  => 'Date',
                    ' Content' => 'Content',
                ],
                'clone'      => true,
                'sort_clone' => true,
				'label_description' => __( '<span class="label">INFO</span> Fill acquisitation.s as a chronology', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* **bold** ***label*** #small# ##huge##', 'wa-rsfp' ),
            ],
            [
                'name'       => __( 'Skill.s', 'wa-rsfp' ),
                'id'         => $prefix . 'knowledge_skills',
                'type'       => 'text',
                'clone'      => true,
                'sort_clone' => true,
                'limit'      => 100,
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* **bold** ***label*** #small# ##huge##', 'wa-rsfp' ),
            ],
		],
	];

    // Farm
    $meta_boxes[] = [
        'title'      => __( 'Directory › Farm', 'wa-rsfp' ),
        'post_types' => ['directory'],
        'fields'     => [
            [
                'name'              => __( 'Address.s', 'wa-rsfp' ),
                'id'                => $prefix . 'farm_address',
                'type'              => 'fieldset_text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many complete address', 'wa-rsfp' ),
                'options'           => [
                    'address_line1' => 'Address',
                    'address_line2' => 'Address (more)',
                    'postal_code'   => 'Postal code',
                    'city'          => 'City',
                    'country'       => 'Country',
                ],
                'clone'             => true,
                'sort_clone'        => true,
            ],
            [
                'name' => __( 'Transmission', 'wa-rsfp' ),
                'id'   => $prefix . 'farm_transmission',
                'type' => 'checkbox',
            ],
        ],
    ];

    // Stages 
	$meta_boxes[] = [
		'title'      => __( 'Directory › Stages', 'wa-rsfp' ),
		'id'         => 'directory-stage',
		'post_types' => ['directory'],
		'fields'     => [
			[
				'name'            => __( 'Open to stage', 'wa-rsfp' ),
				'id'              => $prefix . 'stage_opentostage',
				'type'            => 'checkbox_list',
				'options'         => [
					'decouverte'  		=> __( 'Stage de découverte', 'wa-rsfp' ),
					'non_remunere' 		=> __( 'Stage non rémunéré', 'wa-rsfp' ),
					'remunere'     		=> __( 'Stage rémunéré', 'wa-rsfp' ),
					'visite'  			=> __( 'Visite étudiant.e.s', 'wa-rsfp' ),
					'apprentissage'     => __( 'Apprentissage', 'wa-rsfp' ),
				],
				'inline'          => true,
				'select_all_none' => true,
				'label_description' => __( '<span class="label">INFO</span> Choose one or many option.s', 'wa-rsfp' ),
			],
		],
	];

    // Medias 
	$meta_boxes[] = [
		'title'      => __( 'Directory › Medias', 'wa-rsfp' ),
		'id'         => 'directory-medias',
		'post_types' => ['directory'],
		'fields'     => [
            [
                'name'             => __( 'Gallery files', 'wa-rsfp' ),
                'id'               => $prefix . 'medias_gallery',
                'type'             => 'image_advanced',
                'desc'             => __( '<span class="important">Maximum 20 images.</span>', 'wa-rsfp' ),
                'max_file_uploads' => 20,
				'label_description' => __( '<span class="label">INFO</span> Choose one or many image.s', 'wa-rsfp' ),
            ],
            [
                'name' => __( 'Vimeo & YouTube video link', 'wa-rsfp' ),
                'id'   => $prefix . 'medias_video_link',
                'type' => 'url',
				'label_description' => __( '<span class="label">INFO</span> Recommanded : choose an external video link from online platform', 'wa-rsfp' ),
            ],
            [
                'name' => __( 'Video file', 'wa-rsfp' ),
                'id'   => $prefix . 'medias_video',
                'type' => 'video',
				'label_description' => __( '<span class="label">INFO</span> Upload a video file directly to the media library', 'wa-rsfp' ),
            ],
			[
                'name'             => __( 'Files', 'wa-rsfp' ),
                'id'               => $prefix . 'medias_files',
                'type'             => 'file_upload',
                'desc'             => __( '<span class="important">Maximum 10 files.</span>', 'wa-rsfp' ),
                'max_file_uploads' => 10,
				'label_description' => __( '<span class="label">INFO</span> Upload one or many file.s', 'wa-rsfp' ),
            ],
		],
	];

	// Internal
	$meta_boxes[] = [
        'title'      => __( 'Directory › Internal', 'wa-rsfp' ),
        'id'         => 'directory-internal',
        'post_types' => ['directory'],
        'fields'     => [
			[
                'name' => __( 'Notes', 'wa-rsfp' ),
                'id'   => $prefix . 'internal_notes',
                'type' => 'textarea',
				'label_description' => __( '<span class="label">INFO</span> Fill with long text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Fill here internal informations such as re-reading, notes or reminder', 'wa-rsfp' ),
            ],
		],
    ];

    return $meta_boxes;
}

function farmer_fields( $meta_boxes ) {
    $prefix = 'f_';

    $meta_boxes[] = [
        'title'      => __( 'Farmer › General', 'wa-rsfp' ),
        'id'         => 'farmer-general',
        'post_types' => ['farmer'],
        'fields'     => [
            [
                'name'              => __( 'Image', 'wa-rsfp' ),
                'id'                => $prefix . 'general_image',
                'type'              => 'image_advanced',
                'label_description' => __( '<span class="label">INFO</span> Fill with an image of farmer / entity', 'wa-rsfp' ),
                'max_file_uploads'  => 1,
            ],
            [
                'name'              => __( 'Legal entity', 'wa-rsfp' ),
                'id'                => $prefix . 'general_legal_entity',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Last name', 'wa-rsfp' ),
                'id'                => $prefix . 'general_lastname',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'First name', 'wa-rsfp' ),
                'id'                => $prefix . 'general_firstname',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Email', 'wa-rsfp' ),
                'id'                => $prefix . 'general_email',
                'type'              => 'email',
                'label_description' => __( '<span class="label">INFO</span> Fill with an email', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Phone.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_phones',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many phone', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Phone number can be a direct line, mobile phone, fax...', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
                'attributes'        => [
                    'type'    => 'tel',
                    'pattern' => '[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}',
                ],
            ],
            [
                'name'              => __( 'Address.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_address',
                'type'              => 'fieldset_text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many complete address', 'wa-rsfp' ),
                'options'           => [
                    'address_line1' => 'Address',
                    'address_line2' => 'Address (more)',
                    'postal_code'   => 'Postal code',
                    'city'          => 'City',
                    'country'       => 'Country',
                ],
                'clone'             => true,
                'sort_clone'        => true,
            ],
            [
                'name'              => __( 'Biography', 'wa-rsfp' ),
                'id'                => $prefix . 'general_biography',
                'type'              => 'wysiwyg',
                'options'           => [
                    'media_buttons'  => false,
                    'drag_drop_upload' => false,
                    // 'default_editor' => true,
                    'teeny' => true,
                    'textarea_rows'  => 4,
                ],
                'label_description' => __( '<span class="label">INFO</span> Fill with a short biography of farmer / entity formatted text', 'wa-rsfp' ),
            ],
        ],
    ];

	// Internal
	$meta_boxes[] = [
		'title'      => __( 'Farmer › Internal', 'wa-rsfp' ),
		'id'         => 'farmer-internal',
		'post_types' => ['farmer'],
		'fields'     => [
			[
				'name' => __( 'Notes', 'wa-rsfp' ),
				'id'   => $prefix . 'internal_notes',
				'type' => 'textarea',
				'label_description' => __( '<span class="label">INFO</span> Fill with long text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Fill here internal informations such as re-reading, notes or reminder', 'wa-rsfp' ),
			],
		],
	];

    return $meta_boxes;
}

function structure_fields( $meta_boxes ) {
    $prefix = 's_';

    $meta_boxes[] = [
        'title'      => __( 'Structure › General', 'wa-rsfp' ),
        'id'         => 'structure-general',
        'post_types' => ['structure'],
        'fields'     => [
            [
                'name'              => __( 'Logotype', 'wa-rsfp' ),
                'id'                => $prefix . 'general_logotype',
                'type'              => 'image_advanced',
                'label_description' => __( '<span class="label">INFO</span> Fill with a logotype', 'wa-rsfp' ),
                'desc' => __( '<span class="label">TIPS</span> Choose an image 1000px squared in transparent *.png', 'wa-rsfp' ),
                'max_file_uploads'  => 1,
            ],
            [
                'name'              => __( 'Referent', 'wa-rsfp' ),
                'id'                => $prefix . 'general_referent',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Email', 'wa-rsfp' ),
                'id'                => $prefix . 'general_email',
                'type'              => 'email',
                'label_description' => __( '<span class="label">INFO</span> Fill with an email', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Phone.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_phones',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many phone', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Phone number can be a direct line, mobile phone, fax...', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
                'attributes'        => [
                    'type'    => 'tel',
                    'pattern' => '[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}',
                ],
            ],
            [
                'name'              => __( 'Address.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_address',
                'type'              => 'fieldset_text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many complete address', 'wa-rsfp' ),
                'options'           => [
                    'address_line1' => 'Address',
                    'address_line2' => 'Address (more)',
                    'postal_code'   => 'Postal code',
                    'city'          => 'City',
                    'country'       => 'Country',
                ],
                'clone'             => true,
                'sort_clone'        => true,
            ],
			[
                'name'              => __( 'Link.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_links',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many links', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Link.s can be a website, page, social network...', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
                'attributes'        => [
                    'type'    => 'url',
                ],
            ],
            [
                'name'              => __( 'Description', 'wa-rsfp' ),
                'id'                => $prefix . 'general_description',
                'type'              => 'wysiwyg',
                'options'           => [
                    'media_buttons'  => false,
                    'drag_drop_upload' => false,
                    // 'default_editor' => true,
                    'teeny' => true,
                    'textarea_rows'  => 4,
                ],
                'label_description' => __( '<span class="label">INFO</span> Fill with formatted text', 'wa-rsfp' ),
            ],
        ],
    ];

	// Internal
	$meta_boxes[] = [
		'title'      => __( 'Structure › Internal', 'wa-rsfp' ),
		'id'         => 'structure-internal',
		'post_types' => ['structure'],
		'fields'     => [
			[
				'name' => __( 'Notes', 'wa-rsfp' ),
				'id'   => $prefix . 'internal_notes',
				'type' => 'textarea',
				'label_description' => __( '<span class="label">INFO</span> Fill with long text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Fill here internal informations such as re-reading, notes or reminder', 'wa-rsfp' ),
			],
		],
	];

    return $meta_boxes;
}

function operation_fields( $meta_boxes ) {
    $prefix = 'o_';

    $meta_boxes[] = [
        'title'      => __( 'Operation › General', 'wa-rsfp' ),
        'id'         => 'operation-general',
        'post_types' => ['operation'],
        'fields'     => [
            [
                'name'              => __( 'Logotypes', 'wa-rsfp' ),
                'id'                => $prefix . 'general_logotypes',
                'type'              => 'image_advanced',
                'label_description' => __( '<span class="label">INFO</span> Fill with a logotype.s', 'wa-rsfp' ),
                'desc' => __( '<span class="label">TIPS</span> Choose an image 1000px squared in transparent *.png', 'wa-rsfp' ),
                'max_file_uploads'  => 20,
            ],
            [
                'name'              => __( 'Agent', 'wa-rsfp' ),
                'id'                => $prefix . 'general_agent',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
			[
                'name'              => __( 'Network', 'wa-rsfp' ),
                'id'                => $prefix . 'general_network',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Link.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_links',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many links', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Link.s can be a website, page, social network...', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
                'attributes'        => [
                    'type'    => 'url',
                ],
            ],
            // [
            //     'name'              => __( 'Description', 'wa-rsfp' ),
            //     'id'                => $prefix . 'general_description',
            //     'type'              => 'wysiwyg',
            //     'options'           => [
            //         'media_buttons'  => false,
            //         'drag_drop_upload' => false,
            //         // 'default_editor' => true,
            //         'teeny' => true,
            //         'textarea_rows'  => 4,
            //     ],
            //     'label_description' => __( '<span class="label">INFO</span> Fill with formatted text', 'wa-rsfp' ),
            // ],
        ],
    ];

	// Internal
	$meta_boxes[] = [
		'title'      => __( 'Operation › Internal', 'wa-rsfp' ),
		'id'         => 'operation-internal',
		'post_types' => ['operation'],
		'fields'     => [
			[
				'name' => __( 'Notes', 'wa-rsfp' ),
				'id'   => $prefix . 'internal_notes',
				'type' => 'textarea',
				'label_description' => __( '<span class="label">INFO</span> Fill with long text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Fill here internal informations such as re-reading, notes or reminder', 'wa-rsfp' ),
			],
		],
	];

    return $meta_boxes;
}

function partner_fields( $meta_boxes ) {
    $prefix = 'o_';

    $meta_boxes[] = [
        'title'      => __( 'Partner › General', 'wa-rsfp' ),
        'id'         => 'partner-general',
        'post_types' => ['partner'],
        'fields'     => [
            [
                'name'              => __( 'Logotype', 'wa-rsfp' ),
                'id'                => $prefix . 'general_logotype',
                'type'              => 'image_advanced',
                'label_description' => __( '<span class="label">INFO</span> Fill with a logotype', 'wa-rsfp' ),
                'desc' => __( '<span class="label">TIPS</span> Choose an image 1000px squared in transparent *.png', 'wa-rsfp' ),
                'max_file_uploads'  => 1,
            ],
            [
                'name'              => __( 'Leader', 'wa-rsfp' ),
                'id'                => $prefix . 'general_leader',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
			[
                'name'              => __( 'Network', 'wa-rsfp' ),
                'id'                => $prefix . 'general_network',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Email', 'wa-rsfp' ),
                'id'                => $prefix . 'general_email',
                'type'              => 'email',
                'label_description' => __( '<span class="label">INFO</span> Fill with an email', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Phone.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_phones',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many phone', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Phone number can be a direct line, mobile phone, fax...', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
                'attributes'        => [
                    'type'    => 'tel',
                    'pattern' => '[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}',
                ],
            ],
            [
                'name'              => __( 'Link.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_links',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many links', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Link.s can be a website, page, social network...', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
                'attributes'        => [
                    'type'    => 'url',
                ],
            ],
            // [
            //     'name'              => __( 'Description', 'wa-rsfp' ),
            //     'id'                => $prefix . 'general_description',
            //     'type'              => 'wysiwyg',
            //     'options'           => [
            //         'media_buttons'  => false,
            //         'drag_drop_upload' => false,
            //         // 'default_editor' => true,
            //         'teeny' => true,
            //         'textarea_rows'  => 4,
            //     ],
            //     'label_description' => __( '<span class="label">INFO</span> Fill with formatted text', 'wa-rsfp' ),
            // ],
        ],
    ];

	// Internal
	$meta_boxes[] = [
		'title'      => __( 'Operation › Internal', 'wa-rsfp' ),
		'id'         => 'operation-internal',
		'post_types' => ['operation'],
		'fields'     => [
			[
				'name' => __( 'Notes', 'wa-rsfp' ),
				'id'   => $prefix . 'internal_notes',
				'type' => 'textarea',
				'label_description' => __( '<span class="label">INFO</span> Fill with long text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Fill here internal informations such as re-reading, notes or reminder', 'wa-rsfp' ),
			],
		],
	];

    return $meta_boxes;
}


// Taxonomies
function thematic_fields( $meta_boxes ) {
    $prefix = 't_';

    $meta_boxes[] = [
        'title'      => __( 'Thematic › General', 'wa-rsfp' ),
        'id'         => 'thematic-general',
        'taxonomies' => ['thematic'],
        'fields'     => [
            [
                'name' => __( 'Content', 'wa-rsfp' ),
                'id'   => $prefix . 'general_content',
                'type'              => 'wysiwyg',
                'options'           => [
                    'media_buttons'  => false,
                    'drag_drop_upload' => false,
                    // 'default_editor' => true,
                    'teeny' => true,
                    'textarea_rows'  => 4,
                ],
				'label_description' => __( '<span class="label">INFO</span> Fill with formatted text', 'wa-rsfp' ),
            ],
            [
                'name'             => __( 'Image', 'wa-rsfp' ),
                'id'               => $prefix . 'general_image',
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
				'label_description' => __( '<span class="label">INFO</span> Choose an image as featured image', 'wa-rsfp' ),
            ],
        ],
    ];

    return $meta_boxes;
}

function production_fields( $meta_boxes ) {
    $prefix = 'p_';

    $meta_boxes[] = [
        'title'      => __( 'Production › General', 'wa-rsfp' ),
        'id'         => 'production-general',
        'taxonomies' => ['production'],
        'fields'     => [
            [
                'name' => __( 'Content', 'wa-rsfp' ),
                'id'   => $prefix . 'general_content',
                'type'              => 'wysiwyg',
                'options'           => [
                    'media_buttons'  => false,
                    'drag_drop_upload' => false,
                    // 'default_editor' => true,
                    'teeny' => true,
                    'textarea_rows'  => 4,
                ],
				'label_description' => __( '<span class="label">INFO</span> Fill with formatted text', 'wa-rsfp' ),
            ],
            [
                'name'             => __( 'Image', 'wa-rsfp' ),
                'id'               => $prefix . 'general_image',
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
				'label_description' => __( '<span class="label">INFO</span> Choose an image as featured image', 'wa-rsfp' ),
            ],
        ],
    ];

    return $meta_boxes;
}