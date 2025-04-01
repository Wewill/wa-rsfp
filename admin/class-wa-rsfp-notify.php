<?php

/*
* Notify by email when a new post is created, pending, or published for review for specific post types: farm, directory
*/

class WA_RSFP_Notify {

    public function __construct() {
        // Hook into post status transitions
        add_action('transition_post_status', [$this, 'notify_on_post_status_change'], 10, 3);
    }

    public function notify_on_post_status_change($new_status, $old_status, $post) {
        // Check if the post type is one of the specified types
        $allowed_post_types = ['farm', 'directory'];
        if (!in_array($post->post_type, $allowed_post_types)) {
            return;
        }

        // Check if the status transition is relevant
        if (($new_status === 'pending' || $new_status === 'publish') && $old_status !== $new_status) {

            // Subject
            $subject = '"' . $post->post_title . ($new_status === 'pending' ? '" est en attente de révision' : '" a été publiée');

            // Message
            // $message = sprintf(
            //     "Une fiche de type '%s' a changer de status.\n\nTitre: %s\nStatus: %s",
            //     $post->post_type,
            //     $post->post_title,
            //     $new_status,
            // );

            // Farm and Directory specific messages
            if ( $post->post_type === 'farm' ) {
                if ( $new_status === 'pending') {
                    $message .= sprintf(
                        "Une fiche ferme nommée <b>%s</b> est à réviser.",
                        $post->post_title
                    );
                }  else {
                    $message .= sprintf(
                        "Votre fiche ferme nommée <b>%s</b> a été publiée.",
                        $post->post_title
                    );
                }
            }

            if ( $post->post_type === 'directory' ) {
                if ( $new_status === 'pending') {
                    $message .= sprintf(
                        "Une fiche répertoire nommée <b>%s</b> est à réviser.",
                        $post->post_title
                    );
                }  else {
                    $message .= sprintf(
                        "Une fiche répertoire nommée <b>%s</b> a été publiée.",
                        $post->post_title
                    );
                }
            }

            // Add user details to message
            $author_id = $post->post_author;
            $author = get_userdata($author_id);

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
            
            // Récuperer la geography
			$user_geography = get_user_meta($author_id, 'user_geography', true);
			$filtered_geography_term = array_filter($geography_terms, function($t) use ($user_geography) {
				return $t->slug === $user_geography;
			});
			$geography_name = ($user_geography && $filtered_geography_term) ? reset($filtered_geography_term)->name : 'N/A';

			// Récuperer la geography
			$user_structure = get_user_meta($author_id, 'user_structure', true);
			$filtered_structure_post = array_filter($structure_posts, function($p) use ($user_structure) {
				return $p->ID === (int)$user_structure;
			});
			$structure_name = ( $user_structure && $filtered_structure_post) ? reset($filtered_structure_post)->post_title : 'N/A';

            // Add user details to message
            $message .= sprintf(
                "\nCette fiche a été créée par <b>%s</b> de la structure <b>%s <em>(%s)</em></b>",
                !empty($author->first_name) && !empty($author->last_name) ? $author->first_name . ' ' . $author->last_name : (!empty($author->display_name) ? $author->display_name : $author->user_login),
                $structure_name,
                $geography_name
            );

            // Send name to template
            $name = $author->display_name;
            $email = $author->user_email;

            // Admin user 
            $admin = get_userdata(2); // Romane 
            $admin_email = $admin->user_email;
            $admin_name = $admin->display_name;

            // To address
            // If pending > send mail to admin, if published > send mail to user
            if ($new_status === 'pending') {
                $to = $admin_email;
            } else {
                $to = $email;
            }
            // $to = 'maintenance-web@wilhemarnoldy.fr'; // Replace with the recipient's email address

            // Headers 
            $headers = array(
                'From: Le répertoire des savoir-faire paysans <contact@savoirfairepaysans.fr>',
                'Reply-To: no-reply@savoirfairepaysans.fr',
                'BCC: maintenance-web@wilhemarnoldy.fr'
            );

            // Attachments used as custom args
            $attachments = array(
                'name' => ($new_status === 'pending') ? $admin_name : $name,
                'link' => get_permalink($post->ID),
                'email' => ($new_status === 'pending') ? $admin_email : $email,
            );
            
            // Send the email
            // error_log("Sending email to $to with subject '$subject' and message: $message");
            wp_mail($to, $subject, $message, $headers, $attachments);
        }
    }
}

// Initialize the class
new WA_RSFP_Notify();

/*
    Improve wp_mail with a beautiful modern and responsive HTML email template
*/

add_filter('wp_mail_content_type', function() {
    return 'text/html';
});

add_filter('wp_mail', function($args) {
    // Path to the external HTML template file
    $template_path = plugin_dir_path(__FILE__) . 'email-template.html';

    // Check if the template file exists
    if (file_exists($template_path)) {
        // Load the template content
        $html_template = file_get_contents($template_path);

        // Get custom args passed in the attachments :
        $name = $args['attachments']['name'] ?? '';
        $link = $args['attachments']['link'] ?? '';
        $email = $args['attachments']['email'] ?? '';

        // Replace placeholders in the template with dynamic content
        $args['message'] = str_replace(
            ['{{name}}', '{{message}}', '{{year}}', '{{link}}'],
            [
                esc_html($name),
                nl2br($args['message'] ?? ''),
                esc_html(date('Y')),
                esc_url($link)
            ],
            $html_template
        );

    } else {
        error_log("Email template file not found: $template_path");
    }

    return $args;
});