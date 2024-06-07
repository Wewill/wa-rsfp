<?php
add_action('admin_notices', 'general_admin_notice');
function general_admin_notice(){
    global $post, $pagenow, $typenow;

	$general_notices = array(
		//structure
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('structure'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => 'Fiches.s structures', 'content' => 'Dans cet onglet se trouve la <b>liste des associations du réseau FADEAR ou réseau partenaire recensées dans le <em>Répertoire</em></b>, qui peuvent potentiellement êtres administrateurs de leur structure sur le site. Les fiches sont également classifiées via une ou plusieurs catégories de <b>géographie (régions)</b>.', 'class' => 'default',
			'icon' => 'dashicons dashicons-admin-generic',
		],
		//directory 
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('directory'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '<em>Répertoire</em> des savoir-faire › Fiches', 'content' => 'Dans cet onglet se trouve la <b>liste des fiches de savoir-faire du <em>Répertoire</em></b>. Chaque fiche peut être reliée à une ou plusieurs <b>fiche.s structure</b> ( association du réseau FADEAR ou réseau partenaire ), à une ou plusieurs <b>fiche.s opérations</b> ( partenaire opérationnel ), à un ou plusieurs <b>fiche ferme.s</b> et son.ses paysans.s du <em>Répertoire</em>. Les fiches sont également classifiées via une ou plusieurs catégories de <b>géographie (départements)</b>,  <b>production</b> et <b>thématiques</b>.<br/><br/><b>Comment localiser un savoir-faire sur la carte ?</b> En associant une catégorie geographie, le savoir-faire sera localisé au centre du département. En geolocalisant une ferme et en l\'associant au savoir-faire, le savoir-faire sera précisement localiser selon les coordonnées de la ferme.', 'class' => 'default',
			'icon' => 'dashicons dashicons-pressthis',
		],
		//directory > geography 
		[	'allowed_pagenow' => array('edit-tags.php'), 
			'allowed_posttype' => array(''),
			'allowed_taxonomy' => array('geography'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => 'Dans cet onglet se trouvent le.s département.s et région.s afin de localiser les enregistrements.', 'class' => 'default',
			'icon' => 'dashicons dashicons-admin-site',
		],
		//directory > production 
		[	'allowed_pagenow' => array('edit-tags.php'), 
			'allowed_posttype' => array(''),
			'allowed_taxonomy' => array('production'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => 'Dans cet onglet se trouvent le.s catégorie.s de type de production utilisée.s afin de classer les savoir-faire dans le <em>Répertoire</em>.', 'class' => 'default',
			'icon' => 'dashicons dashicons-hammer',
		],
		//directory > thematic 
		[	'allowed_pagenow' => array('edit-tags.php'), 
			'allowed_posttype' => array(''),
			'allowed_taxonomy' => array('thematic'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => 'Dans cet onglet se trouvent le.s thématique.s transversale.s utilisées afin de classer les savoir-faire et operation dans le <em>Répertoire</em> selon les savoir-faire acquis. Le premier niveau représente les six savoir-faire de la fleur de l\'ARDEAR. ( <em>Travail avec la nature, Autonomie, Transmissiblité, Développement local, Répartition, Qualité</em> )', 'class' => 'default',
			'icon' => 'dashicons dashicons-sticky',
		],
		//farm
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('farm'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => 'Fiche.s ferme.s', 'content' => 'Dans cet onglet se trouve la <b>liste des fermes enregistrée.s dans le <em>Répertoire</em></b>. Chaque ferme contient un ou des paysans, des coordoonées et est associée à une ou plusieurs fiches du <em>Répertoire</em> qui le concerne. La catégorie "Type de ferme" permets de classifier les fermes selon vos souhaits.', 'class' => 'default',
			'icon' => 'dashicons dashicons-carrot',
		],
		//operation
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('operation'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => 'Fiche.s opérations › les partenaires de travail', 'content' => 'Dans cet onglet se trouvent <b>les partenaires non administrateurs, les partenaires opérationnels avec lesquels les paysans travaillent (tels qu’Atelier Paysan) du <em>Répertoire</em></b>. Ces partenaires peuvent figurer sur les fiches et ils disposent de pages single dédiés. Les fiches sont également classifiées via une ou plusieurs catégories de <b>thématiques</b>.', 'class' => 'default',
			'icon' => 'dashicons dashicons-flag',
		],
		//thematic
		// [	'allowed_pagenow' => array('edit.php'), 
		// 	'allowed_posttype' => array('thematic'),
		// 	'allowed_taxonomy' => array(),
		// 	'allowed_page' => array(),
		// 	'allowed_roles' => array('administrator', 'editor', 'contributor'), 
		// 	'title' => 'Focus thématiques', 'content' => 'Dans cet onglet se trouve la liste des espaces thématiques du <em>Répertoire</em>. Ces espaces sont en cours de construction et ne sont pas encore utilisés.', 'class' => 'default',
		// 	'icon' => 'dashicons dashicons-carrot',
		// ],
		//partner
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('partner'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => 'Partenaires financiers', 'content' => 'Dans cet onglet se trouve la <b>liste des partenaires dont les logos sont présents sur l’onglet Partenaires et dans le pied de page du <em>Répertoire</em></b> des Savoir-Faire Paysans. Les fiches sont également classifiées via une ou plusieurs catégories de <b>type de partenaire</b>.', 'class' => 'default',
			'icon' => 'dashicons dashicons-groups',
		],	
		//export TODO
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array('rsfp_export'),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => 'Pour obtenir un fichier Excel des coordonnées des paysans.', 'class' => 'error' ],
		//rsfp_farm > export TODO
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('rsfp_farm'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array('rsfp_export'),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => 'Pour obtenir un fichier Excel des coordonnées des paysans.', 'class' => 'info' ],
		// //rsfp_farm_document > rsfp_categories 
		// [	'allowed_pagenow' => array('edit-tags.php'), 
		// 	'allowed_posttype' => array('rsfp_focus'),
		// 	'allowed_taxonomy' => array('rsfp_topics'),
		// 	'allowed_page' => array(),
		// 	'allowed_roles' => array('administrator', 'editor', 'contributor'), 
		// 	'title' => '', 'content' => 'Dans cet onglet se trouvent les thématiques utilisées pour classer les focus thématiques.', 'class' => 'info' ],
		//farm > partner_type 
		[	'allowed_pagenow' => array('edit-tags.php'), 
			'allowed_posttype' => array('farm'),
			'allowed_taxonomy' => array('farm_type'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => 'Dans cet onglet se trouvent le.s type.s de ferme utilisé.s pour classer la.s ferme.s.', 'class' => 'default',
			'icon' => 'dashicons dashicons-carrot',
		],
		//partner > partner_type 
		[	'allowed_pagenow' => array('edit-tags.php'), 
			'allowed_posttype' => array('partner'),
			'allowed_taxonomy' => array('partner_type'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => 'Dans cet onglet se trouvent le.s type.s de partenaires utilisé.s pour classer le.s partenaire.s.', 'class' => 'default',
			'icon' => 'dashicons dashicons-groups',
		],
		// Index
		[	'allowed_pagenow' => array('index.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => __('Bienvenue dans le <em>Répertoire</em> des savoir-faire paysans', 'war'), 'content' => __('<strong>Nouveau ?</strong> Pour publier du contenu sur le <em>Répertoire</em>, merci de consulter préalablement le  <a href="/wp-content/plugins/wa-rsfp/dist/pdf/RSFP_Tutoriel_etre_administrateur.pdf">Tutoriel RSFP - Être adminitrateur du site</a>.', 'war'), 'class' => 'default', 'wrapper' => 'h1',
			'icon' => 'dashicons dashicons-pressthis',
		],
		// Post
		[	'allowed_pagenow' => array('edit.php'),
			'allowed_posttype' => array('post'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => __('Dans cet onglet se trouve la liste des articles du site. Pour le moment cette rubrique n’est pas utilisée.', 'war'), 'class' => 'updated' ],
		// Post > taxonomy A la une 
		[	'allowed_pagenow' => array('edit-tags.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array('rsfp_featured'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => __('Cette liste permet d\'afficher les contenus à la une.', 'war'), 'class' => 'info' ],
		// Page
		[	'allowed_pagenow' => array('edit.php'),
			'allowed_posttype' => array('page'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => __('Dans cet onglet se trouve la liste des pages du site. Les pages correspondent aux paragraphes présents en ligne dans la présentation du site. Les pages ne sont pas vouées à être modifiées ou ajoutées par des administrateurs de structure (autres ADEAR) sans concertation avec l’ARDEAR Grand Est.', 'war'), 'class' => 'updated' ],
		// Medias
		[	'allowed_pagenow' => array('upload.php'),
			'allowed_posttype' => array('attachment'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => __('Dans la bibliothèque de médias se trouvent tous les fichiers images et vidéos qui sont utilisés dans les fiches paysan, contenus du site, logotypes.', 'war'), 'class' => 'updated' ],
		// Commentaires
		[	'allowed_pagenow' => array('edit-comments.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => __('Dans cet onglet se trouve la liste des commentaires des navigants depuis les fiches savoir-faire.', 'war'), 'class' => 'updated' ],
		// Utilisateurs
		[	'allowed_pagenow' => array('users.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => __('Les utilisateurs sont classés selon leur rôles ( éditeur, abonné.e...). <strong>Les éditeurs</strong> sont administrateurs soit les salariés de l’ARDEAR Grand-Est. <strong>Les abonné.e.s</strong> sont tous les utilisateurs / membres qui ont créé un compte sur le <em>Répertoire</em> pour voir les contacts des paysans associés aux fiches. <strong>Les contributeurs</strong> sont les administrateurs de structure des associations du réseau FADEAR qui ont le droit de publier des fiches et du contenu sur le <em>Répertoire</em>.', 'war'), 'class' => 'updated',
			'icon' => 'dashicons dashicons-admin-users',
		],
		// Utilisateurs > rsfp_export_members
		[	'allowed_pagenow' => array('users.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array('rsfp_export_members'),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => __('Pour obtenir un fichier Excel des membres.', 'war'), 'class' => 'info' ],
		// Utilisateurs > rsfp_activations
		[	'allowed_pagenow' => array('users.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array('rsfp_activations'),
			'allowed_roles' => array('administrator', 'editor', 'contributor'), 
			'title' => '', 'content' => __('Cette liste répertorie les membres en attente d’activation de leur compte. Seule l’ARDEAR Grand Est valide actuellement les créations de compte.', 'war'), 'class' => 'info' ],
	);		

    $current_screen = get_current_screen();
    $taxonomy = $current_screen->taxonomy;
    
    // Get posttype
    if ( isset($post->ID) )
		$post_type = get_post_type( $post->ID );
	else
		$post_type = $current_screen->post_type;
		
	// Get page 
	if ( $pagenow && isset( $_GET['page'] ) )
		$page = sanitize_text_field($_GET['page']);
	else
		$page = null;
	
	// Get taxonomy 
	if ( $pagenow && isset( $_GET['taxonomy'] ) )
		$taxonomy = sanitize_text_field($_GET['taxonomy']);
	else
		$taxonomy = null;

	// Get user
	$user = wp_get_current_user();

	// Color ref 
	$default_color = '#FF735D'; // '#3a464e'
	$class_colors = array('default' => $default_color, 'error' => '#dc3232', 'warning' => '#ffb900', 'info' => '#2271b1', 'updated' => '#ccd0d4');//var(--wp-admin-theme-color)
	$bg_color = 'background: rgb(251,249,246); background: linear-gradient(90deg, rgba(251,249,246,1) 0%, rgba(255,255,255,1) 35%, rgba(255,255,255,0) 100%);'; //https://cssgradient.io

	// print_r('<pre>');
	// print_r('#page : ' . $page);
	// print_r('#taxonomy : ' . $taxonomy);
	// print_r('#pagenow : ' .$pagenow);
	// print_r('#typenow : ' .$typenow);
	// print_r('#post_id : ' .$post->ID);
	// print_r('#post_type : ' .$post_type);
	// print_r('#roles : ' . (array) $user->roles);
	// print_r('#general_notices : ' . count($general_notices));
	// print_r('</pre>');

	/*
		Select allowed_roles + Select allowed pagenow + Select allowed page
	*/
	foreach ($general_notices as $notice) :
		// echo('<pre>');
		// echo('<b>= '); 
		// 	echo implode('+', $notice['allowed_pagenow']).' + '.implode('+', $notice['allowed_posttype']).' + '.implode('+', $notice['allowed_taxonomy']).' + '.implode('+', $notice['allowed_page']);
		// echo('</b><br/>#'); 
		// 	echo var_dump(in_array( $pagenow,  $notice['allowed_pagenow'] ));
		// echo('<br/>##'); 
		// 	echo var_dump(in_array( $user->roles[0], $notice['allowed_roles'] ));
		// echo('<br/>###'); 
		// 	echo var_dump($notice['allowed_page']);
		// 	echo var_dump(in_array( $page, $notice['allowed_page']));

		// echo('<br/>*' . $post_type); 
		// 	echo var_dump(( !empty($notice['allowed_posttype']) && empty($notice['allowed_page']) && in_array( $post_type, $notice['allowed_posttype']) ));
		// 	echo var_dump(in_array( $post_type, $notice['allowed_posttype']));
		// echo('<br/>**' . $taxonomy ); 
		// 	echo var_dump(( !empty($notice['allowed_taxonomy']) && in_array( $taxonomy, $notice['allowed_taxonomy']) ));
		// 	echo var_dump(in_array( $taxonomy, $notice['allowed_taxonomy']));
		// echo('<br/>***' . $page ); 
		// 	echo var_dump(( !empty($notice['allowed_page']) && !empty($notice['allowed_posttype']) && in_array( $page, $notice['allowed_page']) ));
		// 	echo var_dump(in_array( $page, $notice['allowed_page']));
		// echo('<br/>&&&POSTYPE ' . $post_type); 
		// 	echo var_dump(empty($notice['allowed_posttype']) );
		// echo('<br/>&&&TAX ' . $taxonomy); 
		// 	echo var_dump(empty($notice['allowed_taxonomy']) );
		// echo('<br/>&&&PAGE ' . $page); 
		// 	echo var_dump(empty($notice['allowed_page']) );
		// echo('</pre>');

		// Check page and roles
	    if ( in_array( $pagenow,  $notice['allowed_pagenow'])
	 			&&
	    	 in_array( $user->roles[0], $notice['allowed_roles'])
	    ) {
	    	// Then check particular post_type 
	    	if ( 
	    		( ( !empty($notice['allowed_page']) && empty($notice['allowed_posttype']) ) && in_array( $page, $notice['allowed_page']) )
	    			||
	    		( empty($notice['allowed_page']) && empty($page) && in_array( $post_type, $notice['allowed_posttype']) )
	    			||
	    		( !empty($notice['allowed_taxonomy']) && in_array( $taxonomy, $notice['allowed_taxonomy']) )
	    			||
	    		( ( !empty($notice['allowed_posttype']) && !empty($notice['allowed_page']) ) && ( in_array( $post_type, $notice['allowed_posttype']) && in_array( $page, $notice['allowed_page'])) )
	    			||
				( empty($notice['allowed_posttype']) &&
				  empty($notice['allowed_taxonomy']) &&
				  empty($notice['allowed_page']) &&
				  empty($post_type) &&
				  empty($taxonomy) &&
				  empty($page)
				)
	    	) {
	    	
	    		/*echo "==";
	    		print_r(var_dump($notice['allowed_posttype']));
	    		print_r(var_dump($notice['allowed_page']));

	    		print_r(var_dump(empty($notice['allowed_posttype'])));
	    		print_r(var_dump(empty($notice['allowed_page'])));
	    		print_r(var_dump( ( empty($notice['allowed_posttype']) && empty($notice['allowed_page'])) ));
	    		print_r(var_dump( ( !empty($notice['allowed_posttype']) && !empty($notice['allowed_page'])) ));
	    		print_r(var_dump( ( empty($notice['allowed_posttype']) && !empty($notice['allowed_page'])) ));
	    		print_r(var_dump(in_array( $post_type, $notice['allowed_posttype'])));
	    		print_r(var_dump(in_array( $page, $notice['allowed_page'])));
	    		print_r(var_dump( ( in_array( $post_type, $notice['allowed_posttype']) && in_array( $page, $notice['allowed_page']) )));
	    		print_r(var_dump( ( in_array( $post_type, $notice['allowed_posttype']) && !in_array( $page, $notice['allowed_page']) )));
	    		print_r(var_dump( ( !in_array( $post_type, $notice['allowed_posttype']) && !in_array( $page, $notice['allowed_page']) )));
	    		print_r(var_dump( ( in_array( $post_type, $notice['allowed_posttype']) || in_array( $page, $notice['allowed_page']) )));
	    		print_r(var_dump( ( in_array( $post_type, $notice['allowed_posttype']) || !in_array( $page, $notice['allowed_page']) )));
	    		print_r(var_dump( ( !in_array( $post_type, $notice['allowed_posttype']) || !in_array( $page, $notice['allowed_page']) )));
	    		echo "FINAL:";
	    		print_r(var_dump( ( empty($notice['allowed_page']) && in_array( $post_type, $notice['allowed_posttype']) ) ));
	    		print_r(var_dump( ( empty($notice['allowed_posttype']) && in_array( $post_type, $notice['allowed_posttype']) ) ));*/
			
				$notice['wrapper'] = (isset($notice['wrapper']))?$notice['wrapper']:'';
			    ?>
			    <div class="notice notice-<?= $notice['class'] ?>" style="position:relative; border-radius: 4px; border-left-color: <?= $class_colors[$notice['class']]; ?>; <?= $bg_color; ?>">
					<?php if ( $notice['icon'] !== null ) : ?>
					<div style="height:100%; width:80px; margin-left:20px; margin-right:15px; position: absolute; left: 0;">
						<span class="<?= $notice['icon']; ?>"  style="opacity:50%; <?= $notice['title'] !== '' ? 'font-size:80px; width: 80px; height: 80px;':'font-size:50px; width: 50px; height: 50px;'; ?> position: absolute!important; transform: translate(-50%,-50%)!important; left: 50%!important; top: 50%!important; color: <?= $class_colors[$notice['class']]; ?>"></span>
					</div>
					<?php endif; ?>
			        <div style="<?= $notice['icon'] !== null ? 'height:100%; width:calc( 100% - 115px ); position: relative; ' . ($notice['title'] !== '' ? 'left: 95px;':'left: 75px;') . ' margin-left:20px; margin-top:20px; margin-bottom:20px;' : ''; ?>">
						<p>
							<?= (($notice['title'] != '')?'<'.(($notice['wrapper'] != '')?$notice['wrapper']:'strong').' style="'.(($notice['wrapper'] != '')?'':'font-size: 21px; font-weight: 400; display:block;margin-bottom:10px;').'color:'.$class_colors[$notice['class']].'">'.$notice['title'].'</'.(($notice['wrapper'] != '')?$notice['wrapper']:'strong').'>':'') ?>
							<?= $notice['content'] ?>
						</p>
					</div>
			    </div>
			    <?php
		    
		    }
		}
	endforeach;  
}