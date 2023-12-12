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
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => 'Structures', 'content' => 'Dans cet onglet se trouve la liste des associations du réseau FADEAR ou réseau partenaire recensées dans le Répertoire, qui pourront potentiellement être à terme des administrateurs du site.', 'class' => 'default' ],
		//directory 
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('directory'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => 'Répertoire des savoir-faire', 'content' => 'Dans cet onglet se trouve la liste des fiches de savoir-faire du Répertoire. Chaque fiche peut être reliée à une association du réseau FADEAR ou réseau partenaire, à un ou plusieurs paysans du Répertoire, et à une ou plusieurs catégories de production ou thématiques.', 'class' => 'default' ],
		//directory > geography 
		[	'allowed_pagenow' => array('edit-tags.php'), 
			'allowed_posttype' => array(''),
			'allowed_taxonomy' => array('geography'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => 'Dans cet onglet se trouvent le.s departement.s afin de localiser les enregistrements.', 'class' => 'default' ],
		//directory > production 
		[	'allowed_pagenow' => array('edit-tags.php'), 
			'allowed_posttype' => array(''),
			'allowed_taxonomy' => array('production'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => 'Dans cet onglet se trouvent le.s catégorie.s de type de production utilisée.s pour classer les savoir-faire dans le Répertoire.', 'class' => 'default' ],
		//directory > thematic 
		[	'allowed_pagenow' => array('edit-tags.php'), 
			'allowed_posttype' => array(''),
			'allowed_taxonomy' => array('thematic'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => 'Dans cet onglet se trouvent le.s thématique.s transversale.s utilisées pour classer les savoir-faire et operation dans le Répertoire.', 'class' => 'default' ],
		//farmer
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('farmer'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => 'Fiche.s paysan.s', 'content' => 'Dans cet onglet se trouve la liste des paysans présents dans le Répertoire. Chaque paysan est associé à une ou plusieurs fiches du Répertoire qui le concerne.', 'class' => 'default' ],
		//export TODO
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array('rsfp_export'),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => 'Pour obtenir un fichier Excel des coordonnées des paysans.', 'class' => 'error' ],
		//rsfp_farmer > export TODO
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('rsfp_farmer'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array('rsfp_export'),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => 'Pour obtenir un fichier Excel des coordonnées des paysans.', 'class' => 'info' ],
		//operation
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('operation'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => 'Partenaires de travail', 'content' => 'Dans cet onglet se trouvent les partenaires non administrateurs avec lesquels les paysans travaillent (tels qu’Atelier Paysan). Ces partenaires peuvent figurer sur les fiches.', 'class' => 'default' ],
		//thematic
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('thematic'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => 'Focus thématiques', 'content' => 'Dans cet onglet se trouve la liste des espaces thématiques du Répertoire. Ces espaces sont en cours de construction et ne sont pas encore utilisés.', 'class' => 'default' ],
		// //rsfp_farmer_document > rsfp_categories 
		// [	'allowed_pagenow' => array('edit-tags.php'), 
		// 	'allowed_posttype' => array('rsfp_focus'),
		// 	'allowed_taxonomy' => array('rsfp_topics'),
		// 	'allowed_page' => array(),
		// 	'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
		// 	'title' => '', 'content' => 'Dans cet onglet se trouvent les thématiques utilisées pour classer les focus thématiques.', 'class' => 'info' ],
		//partner
		[	'allowed_pagenow' => array('edit.php'), 
			'allowed_posttype' => array('partner'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => 'Partenaires financiers', 'content' => 'Dans cet onglet se trouve la liste des partenaires dont les logos sont présents sur l’onglet Partenaires du Répertoire des Savoir-Faire Paysans.', 'class' => 'default' ],	
		//partner > partner_type 
		[	'allowed_pagenow' => array('edit-tags.php'), 
			'allowed_posttype' => array('partner'),
			'allowed_taxonomy' => array('partner_type'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => 'Dans cet onglet se trouvent le.s type.s de partenaires utilisé.s pour classer le.s partenaire.s.', 'class' => 'default' ],
		// Index
		[	'allowed_pagenow' => array('index.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => __('Bienvenue dans le Répertoire des savoir-faire paysans', 'war'), 'content' => __('<strong>Nouveau ?</strong> Pour publier du contenu sur le Répertoire, merci de consulter préalablement le  <a href="/wp-content/plugins/wa-rsfp/dist/pdf/RSFP_Tutoriel_etre_administrateur.pdf">Tutoriel RSFP - Être adminitrateur du site</a>.', 'war'), 'class' => 'updated', 'wrapper' => 'h1'],
		// Post
		[	'allowed_pagenow' => array('edit.php'),
			'allowed_posttype' => array('post'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => __('Dans cet onglet se trouve la liste des articles du site. Pour le moment cette rubrique n’est pas utilisée.', 'war'), 'class' => 'updated' ],
		// Post > taxonomy A la une 
		[	'allowed_pagenow' => array('edit-tags.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array('rsfp_featured'),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => __('Cette liste permet d\'afficher les contenus à la une.', 'war'), 'class' => 'info' ],
		// Page
		[	'allowed_pagenow' => array('edit.php'),
			'allowed_posttype' => array('page'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => __('Dans cet onglet se trouve la liste des pages du site. Les pages correspondent aux paragraphes présents en ligne dans la présentation du site. Les pages ne sont pas vouées à être modifiées ou ajoutées par des administrateurs de structure (autres ADEAR) sans concertation avec l’ARDEAR Grand Est.', 'war'), 'class' => 'updated' ],
		// Medias
		[	'allowed_pagenow' => array('upload.php'),
			'allowed_posttype' => array('attachment'),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => __('Dans la bibliothèque de médias se trouvent tous les fichiers images et vidéos qui sont utilisés dans les fiches paysan, contenus du site, logotypes.', 'war'), 'class' => 'updated' ],
		// Commentaires
		[	'allowed_pagenow' => array('edit-comments.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => __('Dans cet onglet se trouve la liste des commentaires des navigants depuis les fiches savoir-faire.', 'war'), 'class' => 'updated' ],
		// Utilisateurs
		[	'allowed_pagenow' => array('users.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array(),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => __('Les utilisateurs sont classés selon leur statut. Les administrateurs sont les salariés de l’ARDEAR Grand Est ainsi que le développeur web. Les membres sont tous les utilisateurs qui ont créé un compte sur le Répertoire pour voir les contacts des paysans des fiches. Les administrateurs de structure sont les associations du réseau FADEAR qui ont le droit de publier des fiches et du contenu sur le Répertoire.', 'war'), 'class' => 'updated' ],
		// Utilisateurs > rsfp_export_members
		[	'allowed_pagenow' => array('users.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array('rsfp_export_members'),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
			'title' => '', 'content' => __('Pour obtenir un fichier Excel des membres.', 'war'), 'class' => 'info' ],
		// Utilisateurs > rsfp_activations
		[	'allowed_pagenow' => array('users.php'),
			'allowed_posttype' => array(),
			'allowed_taxonomy' => array(),
			'allowed_page' => array('rsfp_activations'),
			'allowed_roles' => array('administrator', 'rsfp_role_member', 'rsfp_role_org_admin'), 
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
	$class_colors = array('default' => '#3a464e', 'error' => '#dc3232', 'warning' => '#ffb900', 'info' => '#2271b1', 'updated' => '#ccd0d4');//var(--wp-admin-theme-color)
		
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
			    <div class="notice notice-<?= $notice['class'] ?>">
			        <p>
						<?= (($notice['title'] !='')?'<'.(($notice['wrapper'] != '')?$notice['wrapper']:'strong').' style="'.(($notice['wrapper'] != '')?'':'font-size: 16px;display:block;').'color:'.$class_colors[$notice['class']].'">'.$notice['title'].'</'.(($notice['wrapper'] != '')?$notice['wrapper']:'strong').'><br/>':'') ?>
						<?= $notice['content'] ?>
					</p>
			    </div>
			    <?php
		    
		    }
		}
	endforeach;  
}