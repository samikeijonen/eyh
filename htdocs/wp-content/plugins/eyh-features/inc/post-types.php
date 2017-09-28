<?php
/**
 * Register Post Types.
 *
 * @package EYHFeatures
 * @since   1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Register Custom Post Type 'school'.
function eyh_features_post_type_school() {
	$labels_school = array(
		'name'                  => esc_html_x( 'School', 'Post Type General Name', 'eyh-features' ),
		'singular_name'         => esc_html_x( 'School', 'Post Type Singular Name', 'eyh-features' ),
		'menu_name'             => esc_html__( 'Schools', 'eyh-features' ),
		'name_admin_bar'        => esc_html__( 'School', 'eyh-features' ),
		'archives'              => esc_html__( 'School Archives', 'eyh-features' ),
		'parent_item_colon'     => esc_html__( 'Parent School:', 'eyh-features' ),
		'all_items'             => esc_html__( 'All School', 'eyh-features' ),
		'add_new_item'          => esc_html__( 'Add New School', 'eyh-features' ),
		'add_new'               => esc_html__( 'Add New School', 'eyh-features' ),
		'new_item'              => esc_html__( 'New School', 'eyh-features' ),
		'edit_item'             => esc_html__( 'Edit School', 'eyh-features' ),
		'update_item'           => esc_html__( 'Update School', 'eyh-features' ),
		'view_item'             => esc_html__( 'View School', 'eyh-features' ),
		'search_items'          => esc_html__( 'Search Schools', 'eyh-features' ),
		'not_found'             => esc_html__( 'Not found', 'eyh-features' ),
		'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'eyh-features' ),
		'featured_image'        => esc_html__( 'School Image', 'eyh-features' ),
		'set_featured_image'    => esc_html__( 'Set school image', 'eyh-features' ),
		'remove_featured_image' => esc_html__( 'Remove school image', 'eyh-features' ),
		'use_featured_image'    => esc_html__( 'Use as school image', 'eyh-features' ),
		'insert_into_item'      => esc_html__( 'Insert into item', 'eyh-features' ),
		'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'eyh-features' ),
		'items_list'            => esc_html__( 'School list', 'eyh-features' ),
		'items_list_navigation' => esc_html__( 'School list navigation', 'eyh-features' ),
		'filter_items_list'     => esc_html__( 'Filter school list', 'eyh-features' ),
	);

	$args_school = array(
		'label'                 => esc_html__( 'School', 'eyh-features' ),
		'description'           => esc_html__( 'Espoo schools', 'eyh-features' ),
		'labels'                => $labels_school,
		'supports'              => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'custom-fields', ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-admin-users',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite'               => array( 'slug' => 'koulu' ),
	);

	register_post_type( 'school', $args_school );
}
add_action( 'init', 'eyh_features_post_type_school', 0 );
