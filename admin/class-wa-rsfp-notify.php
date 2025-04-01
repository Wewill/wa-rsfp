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

        // // Check if the status transition is relevant
        // if (($new_status === 'pending' || $new_status === 'publish') && $old_status !== $new_status) {
            // Prepare email details
            // To address
            $to = 'maintenance-web@wilhemarnoldy.fr'; // Replace with the recipient's email address
            // Subject
            $subject = ($new_status === 'pending' ? 'Post Pending Review: ' : 'Post Published: ') . $post->post_title;
            // Message
            $message = sprintf(
                "A post of type '%s' has changed status.\n\nTitle: %s\nStatus: %s\nLink: %s",
                $post->post_type,
                $post->post_title,
                $new_status,
                get_permalink($post->ID)
            );

            // Add user details to message
            $author_id = $post->post_author;
            $author = get_userdata($author_id);
            $user_structure = get_user_meta($author_id, 'user_structure', true) ?: 'N/A';
            $user_geography = get_user_meta($author_id, 'user_geography', true) ?: 'N/A';

            $message .= sprintf(
                "\n\nAuthor Details:\nID: %d\nName: %s\nStructure: %s\nGeography: %s",
                $author_id,
                $author->display_name,
                $user_structure,
                $user_geography
            );

            // Send name to template
            $name = $author->display_name;

            // Send the email
            error_log("Sending email to $to with subject '$subject' and message: $message");
            wp_mail($to, $subject, $message, $name);
        // }
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

        // Replace placeholders in the template with dynamic content
        $args['message'] = str_replace(
            ['{{name}}', '{{message}}', '{{year}}'],
            [
                esc_html($args['name'] ?? ''),
                nl2br(esc_html($args['message'] ?? '')),
                esc_html(date('Y'))
            ],
            $html_template
        );
    } else {
        error_log("Email template file not found: $template_path");
    }

    return $args;
});