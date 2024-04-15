<?php

class Fundify_Donation_Post_Type
{
    public function __construct()
    {
        add_action('init', array($this, 'register_donation_post_type'));
        add_action('init', array($this, 'register_donation_taxonomy'));
        add_action('add_meta_boxes', array($this, 'add_donation_meta_boxes'));
        add_action('save_post', array($this, 'save_donation_meta'));
    }

    // Register Donation Custom Post Type
    public function register_donation_post_type()
    {
        $labels = array(
            'name'               => _x('Donations', 'post type general name', 'textdomain'),
            'singular_name'      => _x('Donation', 'post type singular name', 'textdomain'),
            'menu_name'          => _x('Donations', 'admin menu', 'textdomain'),
            'name_admin_bar'     => _x('Donation', 'add new on admin bar', 'textdomain'),
            'add_new'            => _x('Add New', 'donation', 'textdomain'),
            'add_new_item'       => __('Add New Donation', 'textdomain'),
            'new_item'           => __('New Donation', 'textdomain'),
            'edit_item'          => __('Edit Donation', 'textdomain'),
            'view_item'          => __('View Donation', 'textdomain'),
            'all_items'          => __('All Donations', 'textdomain'),
            'search_items'       => __('Search Donations', 'textdomain'),
            'parent_item_colon'  => __('Parent Donations:', 'textdomain'),
            'not_found'          => __('No donations found.', 'textdomain'),
            'not_found_in_trash' => __('No donations found in Trash.', 'textdomain')
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __('Description.', 'textdomain'),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => false,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'donation'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'custom-fields'), // Add or remove post features as needed
        );

        register_post_type('fundify_donations', $args);
    }

    // Register Custom Taxonomy for Donation
    public function register_donation_taxonomy()
    {
        $labels = array(
            'name'              => _x('Donation Categories', 'taxonomy general name', 'textdomain'),
            'singular_name'     => _x('Donation Category', 'taxonomy singular name', 'textdomain'),
            'search_items'      => __('Search Donation Categories', 'textdomain'),
            'all_items'         => __('All Donation Categories', 'textdomain'),
            'parent_item'       => __('Parent Donation Category', 'textdomain'),
            'parent_item_colon' => __('Parent Donation Category:', 'textdomain'),
            'edit_item'         => __('Edit Donation Category', 'textdomain'),
            'update_item'       => __('Update Donation Category', 'textdomain'),
            'add_new_item'      => __('Add New Donation Category', 'textdomain'),
            'new_item_name'     => __('New Donation Category Name', 'textdomain'),
            'menu_name'         => __('Donation Category', 'textdomain'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'donation-category'),
        );

        register_taxonomy('donation_category', array('fundify_donations'), $args);
    }

    // Add Custom Meta Boxes for Donation
    public function add_donation_meta_boxes()
    {
        add_meta_box(
            'donation_goal_meta_box',
            __('Donation Goal', 'textdomain'),
            array($this, 'donation_goal_meta_box_callback'),
            'donation',
            'side',
            'default'
        );
    }

    // Donation Goal Meta Box Callback
    public function donation_goal_meta_box_callback($post)
    {
        wp_nonce_field('custom_donation_goal_nonce', 'custom_donation_goal_nonce');

        $goal = get_post_meta($post->ID, '_donation_goal', true);

        echo '<label for="donation_goal_field">';
        _e('Goal Amount:', 'textdomain');
        echo '</label> ';
        echo '<input type="text" id="donation_goal_field" name="donation_goal_field" value="' . esc_attr($goal) . '" size="25" />';
    }

    // Save Donation Meta
    public function save_donation_meta($post_id)
    {
        if (!isset($_POST['custom_donation_goal_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['custom_donation_goal_nonce'], 'custom_donation_goal_nonce')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['post_type']) && 'donation' == $_POST['post_type']) {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }

        $goal = isset($_POST['donation_goal_field']) ? sanitize_text_field($_POST['donation_goal_field']) : '';

        update_post_meta($post_id, '_donation_goal', $goal);
    }
}

// Initialize the Custom Donation Post Type
new Fundify_Donation_Post_Type();
