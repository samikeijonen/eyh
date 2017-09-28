<?php
/**
 * Template Name: Layout Page
 *
 * Display layouts from CMB2.
 *
 * @package EYH
 */

get_header(); ?>

	<div id="primary" class="content-area main-padding">
		<main id="main" class="site-main main-width" role="main">

			<?php
			while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="entry-header page-header text-center">
						<?php the_title( '<h1 class="entry-title title-font no-margin-bottom text-italic main-padding">', '</h1>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry-inner-singular-wrapper">

							<div class="entry-content">
								<?php
									the_content();
									?>
							</div><!-- .entry-content -->

					</div><!-- .entry-inner-singular-wrapper -->

				</article><!-- #post-## -->

				<?php
				// Layout content.
				$prefix = eyh_metabox_prefix();
				$entries = get_post_meta( get_the_ID(), $prefix . 'layout_content', true );

				if ( isset( $entries ) && $entries ) : ?>
					<div class="grid-wrapper grid-wrapper-2 justify-content-center">
						<?php
						foreach ( (array) $entries as $key => $entry ) :
							echo '<div class="hentry">';
								echo '<div class="entry-inner-wrapper entry-inner entry-border-bottom">';
									$title = $content = '';

									if ( isset( $entry['title'] ) ) {
										echo '<h2>' . esc_html( $entry['title'] ) . '</h2>';
									}

									if ( isset( $entry['content'] ) ) {
										echo wpautop( wp_kses_post( $entry['content'] ) );
									}
								echo '</div>';
							echo '</div>';
						endforeach;
					echo '</div>';
				endif;
				?>

				<?php get_template_part( 'widget-areas/sidebar', 'after-content' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
