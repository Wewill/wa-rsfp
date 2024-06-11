<?php

/**
 * Add custom shortcodes  
 */

function display_query_vars_shortcode() {
	// Get the query variables from the URL
	$query_vars = $_GET;

	// Initialize an empty string to store the output
	$output = '';

	// Check if there are any query variables
	if (!empty($query_vars)) {
		// Iterate through each query variable and append to the output string
		foreach ($query_vars as $key => $value) {
			// Sanitize the key and value to avoid XSS attacks
			$safe_key = esc_html($key);
			$safe_value = esc_html($value);
			$output .= "<p><strong>{$safe_key}:</strong> {$safe_value}</p>";
		}
	} else {
		// If no query variables are found
		$output = '<p>No query variables found.</p>';
	}

	// Return the output string to be displayed
	return $output;
}

add_shortcode('display_query_vars', 'display_query_vars_shortcode');

function display_contact_entity_shortcode() {
	// Get the query variables from the URL
	$query_vars = $_GET;

	// Initialize an empty string to store the output
	$output = '';

	// Check if query variables are not empty
	if (!empty($query_vars) && isset($query_vars['form_type'])) {
			
		// Get post data from ID + post type 
		if (isset($query_vars['ID'])) {
			$ID = $query_vars['ID'];
			$post = get_post($ID);
			$p_media_url 				= get_the_post_thumbnail_url( $ID, 'large' );
			// $p_media_thumbnail_url		= get_the_post_thumbnail_url( $ID, 'thumbnail' );
			// $p_image = $p_media_thumbnail_url ? '<div class="d-flex flex-center rounded-4 bg-color-layout overflow-hidden"><img decoding="async" src="'.$p_media_thumbnail_url.'" class="img-fluid fit-image rounded-4 img-transition-scale --h-100-px --w-100-px"></div>' : '<div class="d-flex flex-center rounded-4 bg-color-layout"><img decoding="async" src="https://placehold.co/300x300/white/white" class="img-fluid fit-image rounded-4 img-transition-scale --h-100-px --w-100-px op-0"><i class="position-absolute bi bi-image text-action-3"></i></div>';

			// print_r($post);
			$output .= sprintf('
				<div class="card --text-white bg-color-layout mt-0 mb-5 border-0 shadow shadow-md">
					<div class="row g-0">
						<div class="col-md-4">
							<img src="%s" class="img-fluid fit-image rounded-start mh-360-px" alt="%s">
						</div>
						<div class="col-md-8 ps-4">
							<div class="card-body">
								<div class="d-inline-flex align-items-center justify-content-center gap-2 mb-3">
									<i class="bi bi-postcard-heart mt-3 mb-2 h1 d-inline-block --text-white text-action-1"></i>
									<!-- <p class="fs-5 --text-muted --text-action-1 --text-white">Un lien priviégié et direct avec nos paysans !</p> -->
								</div>
								
								<h4 class="card-title mb-2 d-flex"><span class="badge text-bg-action-2 --text-white --bg-action-2 fs-6 lh-1 me-2">Je contacte</span> %s</h4>
								<p class="card-text"><strong>Un lien priviégié et direct avec nos paysans !</strong> Grâce au répertoire des savoir-faire paysans, je suis directement en relation avec ce contact par e-mail en remplissant le formulaire ci-dessous *</p>

								<div class="d-inline-flex gap-2 mb-3">
									<button class="d-inline-flex align-items-center btn btn-primary btn-lg px-4 rounded-pill" type="button">Je formule ma demande <i class="bi bi-arrow-right-short ms-2"></i></button> <button class="btn btn-outline-action-1 btn-lg px-4 rounded-pill" type="button">Je consulte la fiche</button>
								</div>

								<p class="card-text"><small class="text-action-2 op-5">* À noter, le Répertoire des Savoir-Faire Paysans n\'assure ni le suivi des échanges ni la disponibilité de la structure contacté.</small></p>
							</div>
						</div>
					</div>
				</div>',
				$p_media_url,
				$post->post_title,
				$post->post_title
			);

		}

	}

	// Return the output string to be displayed (if any)
	return $output;
}

add_shortcode('display_contact_entity', 'display_contact_entity_shortcode');