<?php
/**
 * Template part for displaying a single Book.
 *
 * Renders the two-column hero (cover panel + teal details panel) from the
 * post's featured image and title, then the book body via `the_content()`.
 * Mirrors the Figma single-book template (node 41:1154). The live books use
 * only title, featured image, and body content, so there are no custom
 * fields here (genre/year, award line, and buy links from the mockup are
 * omitted until such data exists).
 *
 * @package dlnorrisbooks
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'book-single' ); ?>>

	<section class="book-hero">
		<div class="book-hero__grid">
			<div class="book-hero__cover-panel">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="book-hero__cover">
						<?php
						the_post_thumbnail(
							'large',
							array(
								'class'   => 'book-hero__cover-img',
								'loading' => 'eager',
							)
						);
						?>
					</div>
				<?php endif; ?>
			</div>

			<div class="book-hero__details">
				<?php the_title( '<h1 class="book-hero__title">', '</h1>' ); ?>

				<?php
				// Optional subtitle line from the ACF "Subtitle" field.
				$dlnorrisbooks_subtitle = function_exists( 'get_field' ) ? get_field( 'book_subtitle' ) : '';
				if ( ! empty( $dlnorrisbooks_subtitle ) ) :
					?>
					<p class="book-hero__subtitle"><?php echo esc_html( $dlnorrisbooks_subtitle ); ?></p>
				<?php endif; ?>

				<?php
				// Purchase buttons from the ACF "Purchase Buttons" repeater.
				if ( function_exists( 'have_rows' ) && have_rows( 'book_buttons' ) ) :
					?>
					<div class="book-hero__buttons">
						<?php
						while ( have_rows( 'book_buttons' ) ) :
							the_row();
							$dlnorrisbooks_btn_label = get_sub_field( 'label' );
							$dlnorrisbooks_btn_url   = get_sub_field( 'url' );

							if ( empty( $dlnorrisbooks_btn_label ) || empty( $dlnorrisbooks_btn_url ) ) {
								continue;
							}
							?>
							<a class="btn-pill" href="<?php echo esc_url( $dlnorrisbooks_btn_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $dlnorrisbooks_btn_label ); ?></a>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<div class="book-body">
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
	</div><!-- .book-body -->

</article><!-- #post-${ID} -->
