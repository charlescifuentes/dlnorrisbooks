<?php
/**
 * Server render for the `dlnorrisbooks/books` block.
 *
 * Queries the latest entries from the `book` custom post type and renders them
 * as cards on a wavy greige band.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    InnerBlocks HTML (unused).
 * @var WP_Block $block      Block instance.
 *
 * @package dlnorrisbooks
 */

$dlnorrisbooks_eyebrow  = isset( $attributes['eyebrow'] ) ? $attributes['eyebrow'] : '';
$dlnorrisbooks_title    = isset( $attributes['title'] ) ? $attributes['title'] : '';
$dlnorrisbooks_count    = isset( $attributes['count'] ) ? absint( $attributes['count'] ) : 5;
$dlnorrisbooks_cta_text = isset( $attributes['ctaText'] ) ? $attributes['ctaText'] : '';
$dlnorrisbooks_cta_url  = ! empty( $attributes['ctaUrl'] ) ? $attributes['ctaUrl'] : get_post_type_archive_link( 'book' );

// Wavy top/bottom dividers — on by default; toggled off for standalone pages.
$dlnorrisbooks_has_waves = ! isset( $attributes['showWaves'] ) || $attributes['showWaves'];

// "View All Books" button — on by default; toggled off on the Books page itself.
$dlnorrisbooks_has_cta = ! isset( $attributes['showCta'] ) || $attributes['showCta'];

$dlnorrisbooks_placeholder = get_template_directory_uri() . '/assets/images/book-placeholder.webp';

$dlnorrisbooks_query = new WP_Query(
	array(
		'post_type'           => 'book',
		'posts_per_page'      => $dlnorrisbooks_count,
		'post_status'         => 'publish',
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$dlnorrisbooks_class = 'books not-prose' . ( $dlnorrisbooks_has_waves ? '' : ' books--flat' );

// On the homepage the hero's "Start Reading" button scrolls to this section,
// so expose an anchor. Scoped to the front page to avoid a duplicate id if the
// block is ever reused elsewhere.
$dlnorrisbooks_wrapper_args = array( 'class' => $dlnorrisbooks_class );
if ( is_front_page() ) {
	$dlnorrisbooks_wrapper_args['id'] = 'the-books';
}
$dlnorrisbooks_wrapper = get_block_wrapper_attributes( $dlnorrisbooks_wrapper_args );
?>
<section <?php echo $dlnorrisbooks_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $dlnorrisbooks_has_waves ) : ?>
		<span class="books__wave books__wave--top" aria-hidden="true"></span>
	<?php endif; ?>

	<div class="books__inner">
		<header class="books__header">
			<?php if ( '' !== $dlnorrisbooks_eyebrow ) : ?>
				<p class="books__eyebrow"><?php echo esc_html( $dlnorrisbooks_eyebrow ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $dlnorrisbooks_title ) : ?>
				<h2 class="books__title"><?php echo esc_html( $dlnorrisbooks_title ); ?></h2>
			<?php endif; ?>
		</header>

		<?php if ( $dlnorrisbooks_query->have_posts() ) : ?>
			<ul class="books__grid" style="--books-columns:<?php echo absint( min( $dlnorrisbooks_query->post_count, 3 ) ); ?>">
				<?php
				while ( $dlnorrisbooks_query->have_posts() ) :
					$dlnorrisbooks_query->the_post();
					$dlnorrisbooks_excerpt = wp_trim_words( get_the_excerpt(), 12, '' );
					?>
					<li class="books__card">
						<a class="books__cover" href="<?php the_permalink(); ?>">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail(
									'medium_large',
									array(
										'class'   => 'books__cover-img',
										'loading' => 'lazy',
									)
								);
							} else {
								printf(
									'<img class="books__cover-img" src="%s" alt="" loading="lazy" decoding="async" />',
									esc_url( $dlnorrisbooks_placeholder )
								);
							}
							?>
						</a>
						<h3 class="books__card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<?php if ( '' !== $dlnorrisbooks_excerpt ) : ?>
							<p class="books__card-subtitle"><?php echo esc_html( $dlnorrisbooks_excerpt ); ?></p>
						<?php endif; ?>
					</li>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
		<?php else : ?>
			<p class="books__empty"><?php esc_html_e( 'No books published yet.', 'dlnorrisbooks' ); ?></p>
		<?php endif; ?>

		<?php if ( $dlnorrisbooks_has_cta && '' !== $dlnorrisbooks_cta_text && $dlnorrisbooks_cta_url ) : ?>
			<div class="books__cta-wrap">
				<a class="btn-pill btn-pill--solid books__cta" href="<?php echo esc_url( $dlnorrisbooks_cta_url ); ?>">
					<?php echo esc_html( $dlnorrisbooks_cta_text ); ?>
					<svg class="books__cta-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
						<path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</a>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $dlnorrisbooks_has_waves ) : ?>
		<span class="books__wave books__wave--bottom" aria-hidden="true"></span>
	<?php endif; ?>
</section>
