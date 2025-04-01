<?php
/*
Plugin Name: Export Membres RSFP
Description: Plugin pour exporter des membres avec des séparateurs personnalisés.
Version: 1.0
Author: Vous
*/

class Wa_Rsfp_Export {
    const ACTION = 'wa_rsfp_export_members';

    public function __construct() {
        // Ajouter le sous-menu dans le menu admin
        add_action('admin_menu', 					array($this, 'add_export_submenu') );
        // Enregistrer l'action pour l'exportation
        add_action('admin_post_' . self::ACTION, 	array($this, 'export'));
    }

    public function add_export_submenu() {
        add_submenu_page(
            'users.php',
            '⎋ ' . __('Export members', 'wa-rsfp'),
            '⎋ ' . __('Export members', 'wa-rsfp'),
            'edit_others_posts',
            'wa_rsfp_export',
            array($this, 'render')
        );
    }

    public function render() {
        ?>
        <div class="wrap">
            <h1 class="wp-heading-title"><strong><?= __('Members', 'wa-rsfp') ?> > </strong><?= __('export', 'wa-rsfp') ?></h1>
            <form method="get" action="<?= esc_attr(admin_url('admin-post.php')) ?>">
                <input type="hidden" name="action" value="<?= self::ACTION ?>" />
                <div class="mta-field">
                    <label class="mta-field__label" for="mta-sep">Séparateur</label>
                    <select class="mta-field__input" id="mta-sep" name="separator">
                        <option value="semicolon">Point-virgule</option>
                        <option value="comma">Virgule</option>
                        <option value="tab">Tabulation</option>
                    </select>
                </div>
                <p class="mta-form__actions">
                    <button type="submit" class="button button-primary"><?= __('Export', 'wa-rsfp') ?></button>
                </p>
            </form>
        </div>
        <?php
    }

    public function export() {
        // Vérifier le séparateur choisi
        $separator = isset($_GET['separator']) ? $_GET['separator'] : 'semicolon';
        switch ($separator) {
            case 'comma':
                $separator = ',';
                break;
            case 'tab':
                $separator = "\t";
                break;
            default:
                $separator = ';';
                break;
        }

        // Récupérer les utilisateurs avec le rôle "subscriber"
        $users = get_users(array('role__in' => array('subscriber')));

        if (empty($users)) {
            error_log('Wa_Rsfp_Export:: Aucun utilisateur trouvé.');
        }

        // Entêtes du fichier CSV
        $headers = [
            __('ID', 'wa-rsfp'),
            __('Username', 'wa-rsfp'),
            __('First name', 'wa-rsfp'),
            __('Last name', 'wa-rsfp'),
            __('Email', 'wa-rsfp'),

			__('Geography', 'wa-rsfp'),
			__('Structure', 'wa-rsfp'),
			__('Profil', 'wa-rsfp'),
	
            __('Date', 'wa-rsfp'),
            __('Verified', 'wa-rsfp')
        ];

		// Get geography taxonomies
		$geography_terms = get_terms( array(
			'taxonomy' => 'geography',
			'hide_empty' => false,
		));

		// Get posts structure
		$structure_posts = get_posts( array(
			'post_type' => 'structure',
			'post_status' => 'publish',
			'numberposts' => -1,
		));

		//Get Profils
		$profiles = array();
        if (function_exists('warl_get_profiles_from_setting_page')) {
            // Récupérer les profils depuis la page de paramètres
            $profiles = warl_get_profiles_from_setting_page();
        } else {
            error_log('Wa_Rsfp_Export:: La fonction warl_get_profiles_from_setting_page() est introuvable.');
        }

		// Output
		$output = implode($separator, $headers) . "\r\n";

		// Récupérer et ajouter les données des utilisateurs
        foreach ($users as $user) {

			// Récuperer le profil
			$user_profile = get_user_meta( $user->ID, 'user_profile', true); 
			$profile_name = 'N/A';
			foreach ($profiles as $profile) {
				if ($profile[0] === $user_profile) {
					$profile_name = $profile[1];
					break;
				}
			}

			// Récuperer la geography
			$user_geography = get_user_meta($user->ID, 'user_geography', true);
			$filtered_geography_term = array_filter($geography_terms, function($t) use ($user_geography) {
				return $t->slug === $user_geography;
			});
			$geography_name = ($user_geography && $filtered_geography_term) ? reset($filtered_geography_term)->name : 'N/A';

			// Récuperer la geography
			$user_structure = get_user_meta($user->ID, 'user_structure', true);
			$filtered_structure_post = array_filter($structure_posts, function($p) use ($user_structure) {
				return $p->ID === (int)$user_structure;
			});
			$structure_name = ( $user_structure && $filtered_structure_post) ? reset($filtered_structure_post)->post_title : 'N/A';

            $user_data = array(
                $user->ID,
                esc_html($user->user_login),
                esc_html($user->first_name),
                esc_html($user->last_name),
                esc_html($user->user_email),

				esc_html( $geography_name ), 
				esc_html( $structure_name ), 
				esc_html( $profile_name ), 
			
                esc_html($user->user_registered),
				get_user_meta($user->ID, 'email_verification', true) ? 'Oui' : 'Non',
			);

            $output .= implode($separator, $user_data) . "\r\n";
        }

        // Définir les en-têtes HTTP pour le téléchargement du fichier CSV
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="exportMembers.csv"');
        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        echo $output;
        exit;
    }
}

// Initialiser la classe
new Wa_Rsfp_Export();