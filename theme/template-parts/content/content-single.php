<?php
/**
 * Template part for displaying single posts.
 *
 * Renders a full-bleed hero from the featured image, a centered intro
 * (back link + category eyebrow + italic title + ornamental flourish), the
 * post body in the shared reading column, and an author sign-off. Mirrors the
 * Figma single-post template (node 96:976).
 *
 * @package dlnorrisbooks
 */

// Link back to the blog listing page (slug `blog`), falling back to home.
$dlnorrisbooks_blog_page = get_page_by_path( 'blog' );
$dlnorrisbooks_blog_url  = $dlnorrisbooks_blog_page ? get_permalink( $dlnorrisbooks_blog_page ) : home_url( '/' );

// Primary category name for the eyebrow.
$dlnorrisbooks_terms    = get_the_terms( get_the_ID(), 'category' );
$dlnorrisbooks_category = ( is_array( $dlnorrisbooks_terms ) && ! empty( $dlnorrisbooks_terms ) )
	? $dlnorrisbooks_terms[0]->name
	: '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-single' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-hero">
			<?php
			the_post_thumbnail(
				'full',
				array(
					'class'   => 'post-hero__img',
					'loading' => 'eager',
				)
			);
			?>
		</div>
	<?php endif; ?>

	<div class="post-body-band">

		<div class="post-intro">
			<a class="post-back" href="<?php echo esc_url( $dlnorrisbooks_blog_url ); ?>">
				<svg class="post-back__icon" width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
					<path d="M19 12H5M11 6l-6 6 6 6" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
				<?php esc_html_e( 'Back to Blog', 'dlnorrisbooks' ); ?>
			</a>

			<div class="post-intro__heading">
				<?php if ( '' !== $dlnorrisbooks_category ) : ?>
					<span class="post-eyebrow"><?php echo esc_html( $dlnorrisbooks_category ); ?></span>
				<?php endif; ?>

				<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>

				<div class="post-flourish" aria-hidden="true">
					<span class="post-flourish__line"></span>
					<span class="post-flourish__mark">&#10022;</span>
					<span class="post-flourish__line"></span>
				</div>
			</div>
		</div>

		<div <?php dlnorrisbooks_content_class( 'entry-content' ); ?>>
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div>' . __( 'Pages:', 'dlnorrisbooks' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->

	</div><!-- .post-body-band -->

</article><!-- #post-${ID} -->
