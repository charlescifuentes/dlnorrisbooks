<?php
/**
 * The template for displaying all single posts
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

				get_template_part( 'template-parts/content/content', 'single' );

				// "You might also enjoy" — related posts.
				get_template_part( 'template-parts/content/related-stories' );

				// End the loop.
			endwhile;

			// Newsletter band — reuse the site newsletter block with its defaults.
			echo do_blocks( '<!-- wp:dlnorrisbooks/newsletter /-->' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
