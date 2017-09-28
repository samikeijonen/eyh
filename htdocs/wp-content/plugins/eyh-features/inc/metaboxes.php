<?php
/**
 * Register Metaboxes.
 *
 * @package EYHFeatures
 * @since   1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function eyh_metabox_prefix() {
	return $prefix = '_eyh_';
}

function eyh_register_metaboxes() {
	$prefix = eyh_metabox_prefix();

	$cmb_school = new_cmb2_box( array(
		'id'           => $prefix . 'school_metabox',
		'title'        => esc_html__( 'School info', 'eyh-features' ),
		'object_types' => array( 'school' ), // Post type
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Lat for map', 'eyh-features' ),
		'id'   => $prefix . 'school_lat',
		'type' => 'text',
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Lng for map', 'eyh-features' ),
		'id'   => $prefix . 'school_lng',
		'type' => 'text',
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Website URL', 'eyh-features' ),
		'id'   => $prefix . 'school_url',
		'type' => 'text_url',
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Special task', 'eyh-features' ),
		'id'   => $prefix . 'school_special',
		'type' => 'text',
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Languages', 'eyh-features' ),
		'id'   => $prefix . 'school_languages',
		'type' => 'textarea_small',
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Average/Points', 'eyh-features' ),
		'id'   => $prefix . 'school_average',
		'type' => 'textarea_small',
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Students starting', 'eyh-features' ),
		'id'   => $prefix . 'school_students_starting',
		'type' => 'textarea_small',
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Students', 'eyh-features' ),
		'id'   => $prefix . 'school_students',
		'type' => 'text',
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Briefings', 'eyh-features' ),
		'id'   => $prefix . 'school_briefings',
		'type' => 'text',
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Contact info', 'eyh-features' ),
		'id'   => $prefix . 'school_contact_info',
		'type' => 'textarea',
	) );

	$cmb_school->add_field( array(
		'name' => esc_html__( 'Diplomas', 'eyh-features' ),
		'id'   => $prefix . 'school_diplomas',
		'type' => 'text',
	) );
}
add_action( 'cmb2_admin_init', 'eyh_register_metaboxes' );

function eyh_register_layout_metaboxes() {
	$prefix = eyh_metabox_prefix();

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'layout_metabox',
		'title'        => esc_html__( 'Layout content', 'eyh-features' ),
		'object_types' => array( 'page', ),
		'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/layout-page.php' ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'layout_content',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => esc_html__( 'Entry {#}', 'eyh-features' ), // {#} gets replaced by row number
			'add_button'    => esc_html__( 'Add Another Entry', 'eyh-features' ),
			'remove_button' => esc_html__( 'Remove Entry', 'eyh-features' ),
			'sortable'      => true, // beta
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => esc_html__( 'Title', 'eyh-features' ),
		'id'   => 'title',
		'type' => 'text',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => esc_html__( 'Content', 'eyh-features' ),
		'id'   => 'content',
		'type' => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 12,
		),
	) );
}
add_action( 'cmb2_admin_init', 'eyh_register_layout_metaboxes' );
