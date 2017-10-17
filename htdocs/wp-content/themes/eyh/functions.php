<?php
/**
 * This is child themes functions.php file. All modifications should be made in this file.
 *
 * All style changes should be in child themes style.css file.
 *
 * @package    EYH
 * @version    1.0.0
 * @author     Sami Keijonen <sami.keijonen@foxnet.fi>
 * @copyright  Copyright (c) 2017, Sami Keijonen
 * @link       https://foxland.fi/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Setup function.  All child themes should run their setup within this function. The idea is to add/remove
 * filters and actions after the parent theme has been set up. This function provides you that opportunity.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function eyh_styles_theme_setup() {

	// Load child theme text domain.
	load_child_theme_textdomain( 'eyh', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'eyh_styles_theme_setup', 11 );

/**
 * Register Google fonts.
 *
 * @since 1.0.0
 *
 * @return string Google fonts URL for the theme.
 */
function eyh_fonts_url() {

	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by PT Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_attr_x( 'on', 'PT Sans font: on or off', 'checathlon' ) ) {
		$fonts[] = 'PT Sans:400,700,400i,700i';
	}

	/* translators: If there are characters in your language that are not supported by Vollkorn, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_attr_x( 'on', 'Vollkorn font: on or off', 'checathlon' ) ) {
		$fonts[] = 'Lora:400,700,400i,700i';
	}

	// Filter Google fonts array.
	$fonts = apply_filters( 'eyhgoogle_fonts', $fonts );

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function eyh_scripts() {
	// Get '.min' suffix.
	$suffix = checathlon_get_min_suffix();

	// Add custom fonts, used in the main stylesheet.
	wp_dequeue_style( 'checathlon-fonts' );
	wp_enqueue_style( 'eyh-fonts', eyh_fonts_url(), array(), null );

	if ( is_page_template( 'templates/highschool-page.php' ) ) {
		// Add maps JS.
		wp_enqueue_script( 'eyh-map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDxjVJjY2SER3VdE37Pk1KV6eUPtem9uVw', array(), '201701018', true );

		// Add settings JS.
		wp_enqueue_script( 'eyh-map-api', get_stylesheet_directory_uri() . '/assets/scripts/app' . $suffix . '.js', array( 'jquery', 'eyh-map' ), '201701018', true );

		// Set args for getting education list.
		$education_args = array(
			'posts_per_page'         => 300,
			'orderby'                => 'date',
			'order'                  => 'ASC',
			'post_type'              => 'school',
			'post_status'            => 'publish',
			'update_post_meta_cache' => false,
			'no_found_rows'          => true // Skip SQL_CALC_FOUND_ROWS for performance (no pagination).
		);

		// Start WP Query.
		$education = new WP_Query( $education_args );

		if ( $education->have_posts() ) :
			// Prefix for metadata.
			$prefix = eyh_metabox_prefix();

			// Start location array for schools.
			$locations = array();

			while ( $education->have_posts() ) : $education->the_post();

				// Map location.
				$lat = get_post_meta( get_the_ID(), $prefix . 'school_lat', true );
				$lng = get_post_meta( get_the_ID(), $prefix . 'school_lng', true );

				// Add title and location info to array.
				$locations[] = array( esc_attr( get_post_field( 'post_name' ) ), esc_html( get_the_title( get_the_ID() ) ), $lat, $lng );

			endwhile;

		endif;

		// Add locations in JS array so we can loop them in map.
		wp_localize_script( 'eyh-map-api', 'EyhMap', array(
			'locations' => json_encode( $locations ),
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'eyh_scripts', 11 );

function eyh_default_bg( $args ) {
	$args['default-color'] = 'f1f5f8';
	return $args;
}
add_filter( 'checathlon_custom_background_args', 'eyh_default_bg' );
