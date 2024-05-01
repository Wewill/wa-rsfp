<?php
/**
 * Register the post types custom meta fields.
 *
 * @since    1.1.0
 */
function register_custom_meta_fields() {
	// Posts
	add_filter( 'rwmb_meta_boxes', 'directory_fields', 10);
	add_filter( 'rwmb_meta_boxes', 'farm_fields', 10);
	add_filter( 'rwmb_meta_boxes', 'structure_fields', 10);
	add_filter( 'rwmb_meta_boxes', 'operation_fields', 10);
	add_filter( 'rwmb_meta_boxes', 'partner_fields', 10);

	// Taxonomies 
	add_filter( 'rwmb_meta_boxes', 'geography_fields', 10);
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
                'show_in_rest' => true,
            ],
            // Old version
			// [
            //     'name'              => __( 'Introduction', 'wa-rsfp' ),
            //     'id'                => $prefix . 'general_introduction',
            //     'type'              => 'wysiwyg',
            //     'options'           => [
            //         'media_buttons'  => false,
            //         'drag_drop_upload' => false,
            //         // 'default_editor' => true,
            //         'teeny' => true,
            //         'textarea_rows'  => 4,
            //     ],
			// 	'label_description' => __( '<span class="label">INFO</span> Fill with formatted text', 'wa-rsfp' ),
			// 	'desc' => __( '<span class="label">TIPS</span> Lead content will be showed after title', 'wa-rsfp' ),
            // ],
            [
                'name'       => __( 'Introduction', 'wa-rsfp' ),
                'id'         => $prefix . 'general_introduction',
                'type'       => 'textarea',
                // 'required'   => true,
                'limit'      => 600,
                'rows'       => 5,
                'class' => 'enable-markdown',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Lead content will be showed after title', 'wa-rsfp' ) . '<br/>' .   __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H).', 'wa-rsfp' ),
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
                'type'       => 'divider',
                'before'      => __( '<span class="label">INFO</span> <b>Production</b> category & <b>Thematic</b> category are to choose after publishing post in taxonomies on side panel.', 'wa-rsfp' ),
                'save_field' => false,
            ],
            [
                'name'       => __( 'Farm.s', 'wa-rsfp' ),
                'id'         => $prefix . 'relationships_farm',
                'type'       => 'post',
                'post_type'  => ['farm'],
                'field_type' => 'select_advanced',
                'add_new'    => true,
                'multiple'   => true,
                'label_description' => __( '<span class="label">INFO</span> Associate one or many post.s', 'wa-rsfp' ),
                //'desc'              => __( '<span class="label">TIPS</span> Lorem ipsum.', 'wa-rsfp' ),
            ],
            [
                'name' => __( 'Preview', 'wa-rsfp' ),
                'id'   =>  $prefix . 'relationships_preview_farm',
                'type' => 'previewpost',
                'meta_value' => $prefix . 'relationships_farm'
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
                'name' => __( 'Preview', 'wa-rsfp' ),
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
                'name' => __( 'Preview', 'wa-rsfp' ),
                'id'   =>  $prefix . 'relationships_preview_operation',
                'type' => 'previewpost',
                'meta_value' => $prefix . 'relationships_operation'
            ],
            // [
            //     'name'       => __( 'Partner.s', 'wa-rsfp' ),
            //     'id'         => $prefix . 'relationships_partner',
            //     'type'       => 'post',
            //     'post_type'  => ['partner'],
            //     'field_type' => 'select_advanced',
            //     'add_new'    => true,
            //     'multiple'   => true,
            //     'label_description' => __( '<span class="label">INFO</span> Associate one or many post.s', 'wa-rsfp' ),
            // ],
            // [
            //     'name' => __( 'Preview', 'wa-rsfp' ),
            //     'id'   =>  $prefix . 'relationships_preview_partner',
            //     'type' => 'previewpost',
            //     'meta_value' => $prefix . 'relationships_partner'
            // ],
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
					'agriculture_biologique'    => __( 'Agriculteur Biologique', 'wa-rsfp' ),
					'demeter' 		            => __( 'Demeter', 'wa-rsfp' ),
                    'bio_coherence' 		    => __( 'Bio Cohérence', 'wa-rsfp' ),
					'nature_progres' 		    => __( 'Nature & Progrès', 'wa-rsfp' ),
					'label_rouge' 		        => __( 'Label Rouge', 'wa-rsfp' ),
					'aop' 		                => __( 'AOP', 'wa-rsfp' ),
					'igp' 		                => __( 'IGP', 'wa-rsfp' ),
					'stg' 		                => __( 'STG', 'wa-rsfp' ),
				],
				'inline'          => true,
				'select_all_none' => true,
				'label_description' => __( '<span class="label">INFO</span> Choose one or many option.s', 'wa-rsfp' ),
			],
            [
                'name' => __( 'Commercialization', 'wa-rsfp' ),
                'id'   => $prefix . 'identity_commercializations',
                'type'       => 'textarea',
                // 'required'   => true,
                'clone'      => true,
                'sort_clone' => true,
                'limit'      => 300,
                'rows'       => 2,
                'max_clone'  => 20,
                'class' => 'enable-markdown',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H)', 'wa-rsfp' ),
            ],
			// [
            //     'name' => __( 'Carbon footprint', 'wa-rsfp' ),
            //     'id'   => $prefix . 'identity_carbon_footprint',
            //     'type' => 'text',
			// 	'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            // ],
		],
	];

	// Knowledge 
	$meta_boxes[] = [
		'title'      => __( 'Directory › Knowledge', 'wa-rsfp' ),
		'id'         => 'directory-knowledge',
		'post_types' => ['directory'],
		'fields'     => [
			[
                'name'              => __( 'Diagram.s', 'wa-rsfp' ),
                'id'                => $prefix . 'knowledge_diagrams',
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
                'name'       => __( 'Viability.s', 'wa-rsfp' ),
                'id'         => $prefix . 'knowledge_viabilitys',
                'type'       => 'textarea',
                // 'required'   => true,
                'clone'      => true,
                'sort_clone' => true,
                'limit'      => 300,
                'rows'       => 2,
                'class' => 'enable-markdown',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ) . '<br/>' .   __( '<span class="label">INFO</span> This will be rendered as a list of items', 'wa-rsfp' ),
				'desc' => __( 'Ex. : chiffre d\'affaire actuel et évolution, charges, EBE, salaires, valeurs ajoutées ...', 'wa-rsfp' ) . '<br/>' .   __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H).', 'wa-rsfp' ),
            ],
            [
                'name'       => __( 'Vivability.s', 'wa-rsfp' ),
                'id'         => $prefix . 'knowledge_vivabilitys',
                'type'       => 'textarea',
                'clone'      => true,
                'sort_clone' => true,
                'limit'      => 300,
                'rows'       => 2,
                'class' => 'enable-markdown',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ) . '<br/>' .   __( '<span class="label">INFO</span> This will be rendered as a list of items', 'wa-rsfp' ),
				'desc' => __( 'Ex. : répartition des tâches, horaires quotidiens, congés ...', 'wa-rsfp' ) . '<br/>' .   __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H).', 'wa-rsfp' ),
            ],
            // Filled w/ taxconomy themactics
            // [
            //     'name'    => __( 'Knowledge AP', 'wa-rsfp' ),
            //     'id'      => $prefix . 'knowledge_knowledge_ap',
            //     'type'    => 'checkbox_list',
            //     'options' => [
            //         'nature'       		=> __( 'Travail avec la nature', 'wa-rsfp' ),
            //         'autonomie'       	=> __( 'Autonomie', 'wa-rsfp' ),
            //         'transmissiblite'   => __( 'Transmissiblité', 'wa-rsfp' ),
            //         'local'       		=> __( 'Développement local', 'wa-rsfp' ),
            //         'repartition'       => __( 'Répartition', 'wa-rsfp' ),
            //         'qualite'       	=> __( 'Qualité', 'wa-rsfp' ),
            //     ],
			// 	'inline'          => true,
			// 	'select_all_none' => true,
			// 	'label_description' => __( '<span class="label">INFO</span> Choose AP acquired kwnoledge.s', 'wa-rsfp' ),
            // ],
            [
                'name'       => /*translators:Chronologie Frise d'acquisition du savoir-faire*/__( 'Acquisition.s', 'wa-rsfp' ),
                'id'         => $prefix . 'knowledge_acquisitions',
                'type'       => 'text_list',
                'options'    => [
                    ' Date'  => 'Date',
                    ' Content' => 'Content',
                ],
                'clone'      => true,
                'sort_clone' => true,
				'label_description' => __( '<span class="label">INFO</span> Fill acquisitation.s as a chronology', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H).', 'wa-rsfp' ),
            ],
            [
                'name'       => /*translators:Parcours à l'installation*/__( 'Installation period', 'wa-rsfp' ),
                'id'         => $prefix . 'knowledge_installation_period',
                'type'       => 'textarea',
                //'limit'      => 100,
                'rows'       => 15,
                'class' => 'enable-markdown',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ) ,
                'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H).', 'wa-rsfp' ),
            ],
            [
                'name'       => /*translators:Compétence.s acquise.s*/__( 'Skill.s', 'wa-rsfp' ),
                'id'         => $prefix . 'knowledge_skills',
                'type'       => 'textarea',
                // 'required'   => true,
                'clone'      => true,
                'sort_clone' => true,
                'limit'      => 300,
                'rows'       => 2,
                'class' => 'enable-markdown',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ) . '<br/>' .   __( '<span class="label">INFO</span> This will be rendered as a list of items', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H).', 'wa-rsfp' ),
            ],
		],
	];

    // Stages 
	$meta_boxes[] = [
		'title'      => __( 'Directory › Opening', 'wa-rsfp' ),
		'id'         => 'directory-opening',
		'post_types' => ['directory'],
		'fields'     => [
			[
				'name'            => __( 'Open to stage ?', 'wa-rsfp' ),
				'id'              => $prefix . 'stage_opentostage',
				'type'            => 'checkbox_list',
				'options'         => [
					'stage_decouverte'  		=> __( 'Stage de découverte', 'wa-rsfp' ),
					'stage_non_remunere' 		=> __( 'Stage non rémunéré', 'wa-rsfp' ),
					'stage_remunere'     		=> __( 'Stage rémunéré', 'wa-rsfp' ),
					'apprentissage'     => __( 'Apprentissage', 'wa-rsfp' ),
				],
				'inline'          => true,
				'select_all_none' => true,
				'label_description' => __( '<span class="label">INFO</span> Choose one or many option.s', 'wa-rsfp' ),
			],
			[
				'name'            => __( 'Open to visit ?', 'wa-rsfp' ),
				'id'              => $prefix . 'stage_opentovisit',
				'type'            => 'checkbox_list',
				'options'         => [
					'visite_libre'  	=> __( 'Visite libre', 'wa-rsfp' ),
					'visite_scolaire'  	=> __( 'Visite établissement scolaire', 'wa-rsfp' ),
					'visite_collective'     => __( 'Visite collective', 'wa-rsfp' ),
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
                'type'       => 'divider',
                'before'      => __( '<span class="label">INFO</span> <b>Featured image</b> please choose an image below on side panel.', 'wa-rsfp' ),
                'save_field' => false,
            ],
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
                'clone'      => true,
                'sort_clone' => true,
                'max_clone'  => 20,
                'label_description' => __( '<span class="label">INFO</span> Recommanded : choose an external video link from online platform', 'wa-rsfp' ),
            ],
            [
                'name' => __( 'Video file', 'wa-rsfp' ),
                'id'   => $prefix . 'medias_video',
                'type' => 'video',
				'label_description' => __( '<span class="label">INFO</span> Upload a video file directly to the media library', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Video has to be *.mp4 well compressed format.', 'wa-rsfp' ),
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
				'desc' => __( '<span class="label">TIPS</span> Fill here internal informations such as re-reading, notes or reminder. Those informations will not be displayed in front.', 'wa-rsfp' ),
            ],
		],
    ];

    return $meta_boxes;
}

function farm_fields( $meta_boxes ) {
    $prefix = 'f_';

    $meta_boxes[] = [
        'title'      => __( 'Farm › General', 'wa-rsfp' ),
        'id'         => 'farm-general',
        'post_types' => ['farm'],
        'fields'     => [
            [
                'name'              => __( 'Legal entity', 'wa-rsfp' ),
                'id'                => $prefix . 'general_legal_entity',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Only required if legal entity is different than title.', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Farmer.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_farmers',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with one or many simple text', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Farmer.s name, surname or full-name. You can add couple names or add fields to a collective farm.', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
            ],
            [
                'name'              => __( 'Email.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_emails',
                'type'              => 'email',
                'label_description' => __( '<span class="label">INFO</span> Fill with one or many email', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
            ],
            [
                'name'              => __( 'Phone.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_phones',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many phone', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Phone number can be a direct line, mobile phone, fax... Recommanded format : 0X XX XX XX XX', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
                'attributes'        => [
                    'type'    => 'tel',
                    //'pattern' => '[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}',
                    'pattern' => '(?:(?:\+)33|0)(?:\s*[1-9]|(?:\(+)\s*[1-9](?:\)))(?:[\s.-]*\d{2}){4}', // https://stackoverflow.com/questions/38483885/regex-for-french-telephone-numbers
                ],
            ],
            [
                'name'              => __( 'Address.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_address',
                'type'              => 'fieldset_text',
                'desc' => __( '<span class="label">INFO</span> Fill one or many complete address that will shown in farm sheet', 'wa-rsfp' ),
                'options'           => [
                    'address_line1'     => 'Address',
                    'address_line2'     => 'Address (more)',
                    'postal_code_city'  => 'Postal code & City (ex. 75000 Paris)',
                    'country'           => 'Country',
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
            // [
            //     'name'              => __( 'Biography', 'wa-rsfp' ),
            //     'id'                => $prefix . 'general_biography',
            //     'type'              => 'wysiwyg',
            //     'options'           => [
            //         'media_buttons'  => false,
            //         'drag_drop_upload' => false,
            //         // 'default_editor' => true,
            //         'teeny' => true,
            //         'textarea_rows'  => 4,
            //     ],
            //     'label_description' => __( '<span class="label">INFO</span> Fill with a short biography of farm / entity formatted text', 'wa-rsfp' ),
            // ],
            // [
            //     'name'              => __( 'Gallery', 'wa-rsfp' ),
            //     'id'                => $prefix . 'general_gallery',
            //     'type'              => 'image_advanced',
            //     'label_description' => __( '<span class="label">INFO</span> Fill with one or many image of farm / entity', 'wa-rsfp' ),
            //     'max_file_uploads'  => 10,
            // ],
        ],
    ];

    // Geolocation
    $meta_boxes[] = [
        'title'      => __( 'Farm › Geolocation', 'wa-rsfp' ),
        'id'         => 'farm-geolocation',
        'post_types' => ['farm'],
        'fields'     => [
            [
                'name'              => __( 'Geo address', 'wa-rsfp' ),
                'id'                => $prefix . 'geolocation_address',
                'type'              => 'text',
                'desc' => __( '<span class="label">INFO</span> Fill unique address to geolocate the farm (this address will not shown in website)', 'wa-rsfp' ),
            ],
            // Map field.
            [
                'id'            => $prefix . 'geolocation_map',
                'name'          => __( 'Location', 'wa-rsfp' ),
                'type'          => 'osm',
                'std'           => '48.84302835299519,2.3400878906250004',
                'language'      => 'fr',
                'region'        => 'fr',
                'address_field' => $prefix . 'geolocation_address',
            ],
            [
                'id' => $prefix . 'geolocation_lat',
                'name' => 'Lat',
                'binding' => 'lat',
            ],
            [
                'id' => $prefix . 'geolocation_lng',
                'name' => 'Lng',
                'binding' => 'lng',
            ],
        ],
        'geo' => true,
    ];


    // Transmission
    $meta_boxes[] = [
        'title'      => __( 'Farm › Transmission', 'wa-rsfp' ),
        'id'         => 'farm-transmission',
        'post_types' => ['farm'],
        'fields'     => [
            // [
            //     'name' => /*translators:Ferme à transmettre*/__( 'Farm to transmit', 'wa-rsfp' ),
            //     'id'   => $prefix . 'farm_to_transmit',
            //     'type' => 'checkbox',
            //     'desc' => __( '<span class="label">TIPS</span> Check this if the farm is currently looking for a transferee, transferees or associates.', 'wa-rsfp' ),
            // ],
            [
                'name' => /*translators:Ferme en transmission*/__( 'Farm in transmission', 'wa-rsfp' ),
                'id'   => $prefix . 'transmission_farm_in_transmission',
                'type' => 'checkbox',
                'desc' => __( '<span class="label">TIPS</span> Check this if the farm is currently in a transmission process.', 'wa-rsfp' ),
            ],
        ],
    ];

    // More
    $meta_boxes[] = [
        'title'      => __( 'Farm › More', 'wa-rsfp' ),
        'id'         => 'farm-more',
        'post_types' => ['farm'],
        'fields'     => [
            [
                'name'       => /*translators:Témoignage libre*/__( 'Testimony', 'wa-rsfp' ),
                'id'         => $prefix . 'more_testimony',
                'type'       => 'textarea',
                // 'required'   => true,
                'limit'      => 200,
                'rows'       => 3,
                'class' => 'enable-markdown',
				'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ) . ' / ' .  __( '(Optional) This content will be displayed in knowledge single page.', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H).', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Biography', 'wa-rsfp' ),
                'id'                => $prefix . 'more_biography',
                'type'       => 'textarea',
                // 'required'   => true,
                'limit'      => 200,
                'rows'       => 3,
                'class' => 'enable-markdown',
                'label_description' => __( '<span class="label">INFO</span> Fill with a short biography of farm / entity formatted text', 'wa-rsfp' ) . ' / ' .  __( '(Optional) This content will be displayed in knowledge single page.', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H).', 'wa-rsfp' ),
            ],
            // [
            //     'name'              => __( 'Gallery', 'wa-rsfp' ),
            //     'id'                => $prefix . 'general_gallery',
            //     'type'              => 'image_advanced',
            //     'label_description' => __( '<span class="label">INFO</span> Fill with one or many image of farm / entity', 'wa-rsfp' ),
            //     'max_file_uploads'  => 10,
            // ],
        ],
    ];

	// Internal
	$meta_boxes[] = [
		'title'      => __( 'Farm › Internal', 'wa-rsfp' ),
		'id'         => 'farm-internal',
		'post_types' => ['farm'],
		'fields'     => [
			[
				'name' => __( 'Notes', 'wa-rsfp' ),
				'id'   => $prefix . 'internal_notes',
				'type' => 'textarea',
				'label_description' => __( '<span class="label">INFO</span> Fill with long text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Fill here internal informations such as re-reading, notes or reminder. Those informations will not be displayed in front.', 'wa-rsfp' ),
			],
		],
	];

    return $meta_boxes;
}

// Add content to a Post image div metabox 
function add_image_desc_to_featured_image_metabox( $content, $post_id, $thumbnail_id ) {

	$allowed_postype= array(
		'farm'
	);
	
    if ( !in_array(get_post_type( $post_id ),$allowed_postype) ) {
        return $content;
	}

    $caption = '<p class="post-description">' . __( '<span class="label">INFO</span> This image will be used as a hero image.', 'wa-rsfp' ) . '</p>';
    $caption .= '<p>' . __( '<span class="important">Provide at least 1440x900px image in * .jpg format.', 'wa-rsfp' ) . '</p>';

    return $content . $caption;
}
add_filter( 'admin_post_thumbnail_html', 'add_image_desc_to_featured_image_metabox', 10, 3 );



function structure_fields( $meta_boxes ) {
    $prefix = 's_';

    $meta_boxes[] = [
        'title'      => __( 'Structure › General', 'wa-rsfp' ),
        'id'         => 'structure-general',
        'post_types' => ['structure'],
        'fields'     => [
            // [
            //     'name'              => __( 'Logotype', 'wa-rsfp' ),
            //     'id'                => $prefix . 'general_logotype',
            //     'type'              => 'image_advanced',
            //     'label_description' => __( '<span class="label">INFO</span> Fill with a logotype', 'wa-rsfp' ),
            //     'desc' => __( '<span class="label">TIPS</span> Choose an image 1000px squared in transparent *.png', 'wa-rsfp' ),
            //     'max_file_uploads'  => 1,
            // ],
            // [
            //     'name'              => __( 'Presentation image', 'wa-rsfp' ),
            //     'id'                => $prefix . 'general_image',
            //     'type'              => 'image_advanced',
            //     'label_description' => __( '<span class="label">INFO</span> Fill with an image', 'wa-rsfp' ),
            //     'desc' => __( '<span class="label">TIPS</span> Choose an image 1200px x 600px  in *.jpg', 'wa-rsfp' ),
            //     'max_file_uploads'  => 1,
            // ],
            [
                'name'              => __( 'Referent', 'wa-rsfp' ),
                'id'                => $prefix . 'general_referent',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with simple text', 'wa-rsfp' ),
            ],
            [
                'name'              => __( 'Email.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_email',
                'type'              => 'email',
                'label_description' => __( '<span class="label">INFO</span> Fill with one or many email', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
            ],
            [
                'name'              => __( 'Phone.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_phones',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many phone', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Phone number can be a direct line, mobile phone, fax... Recommanded format : 0X XX XX XX XX', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
                'attributes'        => [
                    'type'    => 'tel',
                    //'pattern' => '[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}',
                    'pattern' => '(?:(?:\+)33|0)(?:\s*[1-9]|(?:\(+)\s*[1-9](?:\)))(?:[\s.-]*\d{2}){4}', // https://stackoverflow.com/questions/38483885/regex-for-french-telephone-numbers
                ],
            ],
            [
                'name'              => __( 'Address.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_address',
                'type'              => 'fieldset_text',
                'desc' => __( '<span class="label">INFO</span> Fill one or many complete address', 'wa-rsfp' ),
                'options'           => [
                    'address_line1'     => 'Address',
                    'address_line2'     => 'Address (more)',
                    'postal_code_city'  => 'Postal code & City (ex. 75000 Paris)',
                    'country'           => 'Country',
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

    // More
    $meta_boxes[] = [
        'title'      => __( 'Structure › More', 'wa-rsfp' ),
        'id'         => 'structure-more',
        'post_types' => ['structure'],
        'fields'     => [
            [
                'name'              => __( 'Description', 'wa-rsfp' ),
                'id'                => $prefix . 'more_description',
                'type'       => 'textarea',
                // 'required'   => true,
                'limit'      => 200,
                'rows'       => 3,
                'class' => 'enable-markdown',
                'label_description' => __( '<span class="label">INFO</span> Fill with a short description of structure formatted text', 'wa-rsfp' ) . ' / ' .  __( '(Optional) This content will be displayed in knowledge single page.', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H).', 'wa-rsfp' ),
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
				'desc' => __( '<span class="label">TIPS</span> Fill here internal informations such as re-reading, notes or reminder. Those informations will not be displayed in front.', 'wa-rsfp' ),
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
            // [
            //     'name'              => __( 'Logotype', 'wa-rsfp' ),
            //     'id'                => $prefix . 'general_logotype',
            //     'type'              => 'image_advanced',
            //     'label_description' => __( '<span class="label">INFO</span> Fill with a logotype', 'wa-rsfp' ),
            //     'desc' => __( '<span class="label">TIPS</span> Choose an image 1000px squared in transparent *.png', 'wa-rsfp' ),
            //     'max_file_uploads'  => 1,
            // ],
            [
                'name'              => __( 'Presentation image', 'wa-rsfp' ),
                'id'                => $prefix . 'general_image',
                'type'              => 'image_advanced',
                'label_description' => __( '<span class="label">INFO</span> Fill with an image', 'wa-rsfp' ),
                'desc' => __( '<span class="label">TIPS</span> Choose an image 1200px x 600px  in *.jpg', 'wa-rsfp' ),
                'max_file_uploads'  => 1,
            ],
            [
                'name'              => __( 'Leader.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_leaders',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with one or many simple text', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
            ],
            [
                'name'              => __( 'Email.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_emails',
                'type'              => 'email',
                'label_description' => __( '<span class="label">INFO</span> Fill with one or many email', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
            ],
            [
                'name'              => __( 'Phone.s', 'wa-rsfp' ),
                'id'                => $prefix . 'general_phones',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill one or many phone', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Phone number can be a direct line, mobile phone, fax... Recommanded format : 0X XX XX XX XX', 'wa-rsfp' ),
                'clone'             => true,
                'sort_clone'        => true,
                'attributes'        => [
                    'type'    => 'tel',
                    //'pattern' => '[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}',
                    'pattern' => '(?:(?:\+)33|0)(?:\s*[1-9]|(?:\(+)\s*[1-9](?:\)))(?:[\s.-]*\d{2}){4}', // https://stackoverflow.com/questions/38483885/regex-for-french-telephone-numbers
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
			// 	'type' => 'textarea',
            //     'label_description' => __( '<span class="label">INFO</span> Fill with formatted text', 'wa-rsfp' ),
            // ],
        ],
    ];

    // More
    $meta_boxes[] = [
        'title'      => __( 'Operation › More', 'wa-rsfp' ),
        'id'         => 'operation-more',
        'post_types' => ['operation'],
        'fields'     => [
            [
                'name'              => __( 'Description', 'wa-rsfp' ),
                'id'                => $prefix . 'more_description',
                'type'       => 'textarea',
                // 'required'   => true,
                'limit'      => 200,
                'rows'       => 3,
                'class' => 'enable-markdown',
                'label_description' => __( '<span class="label">INFO</span> Fill with a short description of structure formatted text', 'wa-rsfp' ) . ' / ' .  __( '(Optional) This content will be displayed in knowledge single page.', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Markdown is available : *italic* (Command + b) **bold** (Command + i) ***label*** (Command + Shift + L) #small# (Command + Shift + S) ##huge## (Command + Shift + H).', 'wa-rsfp' ),
            ],
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
				'desc' => __( '<span class="label">TIPS</span> Fill here internal informations such as re-reading, notes or reminder. Those informations will not be displayed in front.', 'wa-rsfp' ),
			],
		],
	];

    return $meta_boxes;
}

function partner_fields( $meta_boxes ) {
    $prefix = 'p_';

    $meta_boxes[] = [
        'title'      => __( 'Partner › General', 'wa-rsfp' ),
        'id'         => 'partner-general',
        'post_types' => ['partner'],
        'fields'     => [
            [
                'name'              => __( 'Link', 'wa-rsfp' ),
                'id'                => $prefix . 'general_link',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill one link', 'wa-rsfp' ),
                'desc'              => __( '<span class="label">TIPS</span> Link can be a website, page, social network...', 'wa-rsfp' ),
                'attributes'        => [
                    'type'    => 'url',
                ],
            ],
        ],
    ];

	// Internal
	$meta_boxes[] = [
		'title'      => __( 'Partner › Internal', 'wa-rsfp' ),
		'id'         => 'partner-internal',
		'post_types' => ['partner'],
		'fields'     => [
			[
				'name' => __( 'Notes', 'wa-rsfp' ),
				'id'   => $prefix . 'internal_notes',
				'type' => 'textarea',
				'label_description' => __( '<span class="label">INFO</span> Fill with long text', 'wa-rsfp' ),
				'desc' => __( '<span class="label">TIPS</span> Fill here internal informations such as re-reading, notes or reminder. Those informations will not be displayed in front.', 'wa-rsfp' ),
			],
		],
	];

    return $meta_boxes;
}


// Add content to a Post image div metabox 
function add_logotype_desc_to_featured_image_metabox( $content, $post_id, $thumbnail_id ) {

	$allowed_postype= array(
		'structure',
		'partner'
	);
	
    if ( !in_array(get_post_type( $post_id ),$allowed_postype) ) {
        return $content;
	}

    $caption = '<p class="post-description">' . __( '<span class="label">INFO</span> This image will be used as a logotype', 'wa-rsfp' ) . '</p>';
    $caption .= '<p>' . __( '<span class="important">Provide at least 1000x1000px image in transparent * .png format.', 'wa-rsfp' ) . '</p>';

    return $content . $caption;
}
add_filter( 'admin_post_thumbnail_html', 'add_logotype_desc_to_featured_image_metabox', 10, 3 );


// Taxonomies
function geography_fields( $meta_boxes ) {
    $prefix = 'g_';

    $meta_boxes[] = [
        'title'      => __( 'Geography › Special', 'wa-rsfp' ),
        'id'         => 'geography-special',
        'taxonomies' => ['geography'],
        'fields'     => [
            [
                'name'              => __( 'Code', 'wa-rsfp' ),
                'id'                => $prefix . 'special_code',
                'type'              => 'text',
                'label_description' => __( '<span class="label">INFO</span> Fill with geojson area code', 'wa-rsfp' ),
            ],
       ],
    ];

    return $meta_boxes;
}

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
            [
                'name'             => __( 'Color', 'wa-rsfp' ),
                'id'               => $prefix . 'general_color',
                'type'             => 'color',
				'label_description' => __( '<span class="label">INFO</span> Choose an color', 'wa-rsfp' ),
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
            // [
            //     'name' => __( 'Content', 'wa-rsfp' ),
            //     'id'   => $prefix . 'general_content',
            //     'type'              => 'wysiwyg',
            //     'options'           => [
            //         'media_buttons'  => false,
            //         'drag_drop_upload' => false,
            //         // 'default_editor' => true,
            //         'teeny' => true,
            //         'textarea_rows'  => 4,
            //     ],
			// 	'label_description' => __( '<span class="label">INFO</span> Fill with formatted text', 'wa-rsfp' ),
            // ],
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