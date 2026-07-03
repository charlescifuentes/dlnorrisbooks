<?php
/**
 * The template for displaying a single Book (the `book` custom post type).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dlnorrisbooks
 */

get_header();
?>

	<section id="primary">
		<main id="main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'single-book' );

				// End the loop.
			endwhile;

			// Newsletter band — reuse the site newsletter block with its defaults.
			echo do_blocks( '<!-- wp:dlnorrisbooks/newsletter /-->' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
