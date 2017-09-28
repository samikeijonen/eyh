<?php
/**
 * Template Name: Highschool Page
 *
 * Display highschools in custom table.
 *
 * @package EYH
 */

get_header();

// Prefix for metadata.
$prefix = eyh_metabox_prefix();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-inner-singular">

						<header class="entry-header page-header text-center">
							<?php the_title( '<h1 class="entry-title title-font no-margin-bottom text-italic main-padding">', '</h1>' ); ?>
						</header><!-- .entry-header -->

						<div class="entry-inner-singular-wrapper main-padding">

							<div class="entry-inner-content">
								<div class="entry-content">
								<?php
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

										echo '<h2 class="order-number"><span class="count-number">1</span><span class="count-text">' . esc_html__( 'Select highschools', 'eyh' ) . '</span></h2>';
										echo '<ul class="highschools-button-list">';

										while ( $education->have_posts() ) : $education->the_post();

											// Map info.
											$lat = get_post_meta( get_the_ID(), $prefix . 'school_lat', true );
											$lng = get_post_meta( get_the_ID(), $prefix . 'school_lng', true );

											echo '<li>';
												echo '<button class="select-highschool" data-map-lat="' . esc_attr( $lat ) . '" data-map-lng="' . esc_attr( $lng ) . '" data-select="' . esc_attr( get_post_field( 'post_name' ) ) . '">' . esc_html( get_the_title() ) . '</button>';
											echo '</li>';

										endwhile;

										echo '</ul>';

										// School info titles.
										$school_info_titles = array(
											$prefix . 'school_special'           => esc_html__( 'Special task', 'eyh-features' ),
											$prefix . 'school_average'           => esc_html__( 'Average/Points', 'eyh-features' ),
											$prefix . 'school_languages'         => esc_html__( 'Languages', 'eyh-features' ),
											$prefix . 'school_students_starting' => esc_html__( 'Students starting', 'eyh-features' ),
											$prefix . 'school_students'          => esc_html__( 'Students', 'eyh-features' ),
											$prefix . 'school_briefings'         => esc_html__( 'Briefings', 'eyh-features' ),
											$prefix . 'school_contact_info'      => esc_html__( 'Contact info', 'eyh-features' ),
											$prefix . 'school_diplomas'          => esc_html__( 'Diplomas', 'eyh-features' ),
										);

										echo '<h2 class="order-number"><span class="count-number">2</span><span class="count-text">' . esc_html__( 'Select data to compare', 'eyh' ) . '</span></h2>';
										echo '<ul class="highschools-button-list">';

										$k = 1;
										foreach ( $school_info_titles as $school_info_title ) :

											echo '<li>';
												echo '<button class="select-col" data-col="col-' . $k . '">' . esc_html( $school_info_title ) . '</button>';
											echo '</li>';

											$k++;
										endforeach;

										echo '</ul>';
								?>
								</div><!-- .entry-content -->

								<?php
								echo '<h2 class="order-number"><span class="count-number">3</span><span class="count-text">' . esc_html__( 'Scroll to right to see all data', 'eyh' ) . '</span></h2>';

								echo '<div class="table-scroll">';
								echo '<table class="highscools-comparison" id="highscools-comparison">';
									echo '<caption><span class="screen-reader-text">' . esc_html__( 'Espoo highschools comparison', 'eyh' ) . '</span></caption>';
									echo '<tr>';
										echo '<th class="school-data" scope="col">' . esc_html__( 'Highschool', 'eyh' ) . '</th>';

										$k = 1;
										foreach ( $school_info_titles as $id => $title ) :
											echo '<th class="school-data col col-' . $k . '" scope="col">' . esc_html( $title ) . '</th>';
											$k++;
										endforeach;

									echo '</tr>';

									while ( $education->have_posts() ) : $education->the_post();
										// URL.
										$url = get_post_meta( get_the_ID(), $prefix . 'school_url', true );

										echo '<tr class="highschool-content" id="' . esc_attr( get_post_field( 'post_name' ) ) . '">';
											echo '<th scope="row"><a href="' . esc_url( $url  ) . '">' . esc_html( get_the_title() ) . '</a></th>';

											$k = 1;
											foreach ( $school_info_titles as $id => $title ) :
												// Post meta.
												$meta = get_post_meta( get_the_ID(), $id, true );

												echo '<td class="col col-' . $k . '">' . wpautop( esc_html( $meta ) ) . '</td>';

												$k++;
											endforeach;
										echo '</tr>';
									endwhile;
								echo '</table>';
								echo '</div>';

							endif;
							// Reset post data.
							wp_reset_postdata();
							?>
							</div><!-- .entry-inner-content -->

							<div class="map" id="map"></div>

						</div><!-- .entry-inner-singular-wrapper -->

					</div><!-- .entry-inner-singular -->

				</article><!-- #post-## -->

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
