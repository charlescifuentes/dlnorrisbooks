<?php
/**
 * Server render for the `dlnorrisbooks/recent-stories` block.
 *
 * Queries the latest blog posts and renders them as editorial cards.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    InnerBlocks HTML (unused).
 * @var WP_Block $block      Block instance.
 *
 * @package dlnorrisbooks
 */

$dlnorrisbooks_show_heading = ! isset( $attributes['showHeading'] ) || $attributes['showHeading'];
$dlnorrisbooks_eyebrow      = isset( $attributes['eyebrow'] ) ? $attributes['eyebrow'] : '';
$dlnorrisbooks_title        = isset( $attributes['title'] ) ? $attributes['title'] : '';
$dlnorrisbooks_count        = isset( $attributes['count'] ) ? absint( $attributes['count'] ) : 4;
$dlnorrisbooks_show_cta     = ! isset( $attributes['showCta'] ) || $attributes['showCta'];
$dlnorrisbooks_cta_text     = isset( $attributes['ctaText'] ) ? $attributes['ctaText'] : '';
$dlnorrisbooks_paginate     = ! empty( $attributes['paginate'] );

$dlnorrisbooks_posts_page = (int) get_option( 'page_for_posts' );
$dlnorrisbooks_cta_url    = ! empty( $attributes['ctaUrl'] )
	? $attributes['ctaUrl']
	: ( $dlnorrisbooks_posts_page ? get_permalink( $dlnorrisbooks_posts_page ) : home_url( '/' ) );

// When paginating, follow the current page. Static pages expose the page number
// as `page`; the posts index / archives use `paged`.
$dlnorrisbooks_paged = max(
	1,
	(int) get_query_var( 'paged' ),
	(int) get_query_var( 'page' )
);

$dlnorrisbooks_query_args = array(
	'post_type'           => 'post',
	'posts_per_page'      => $dlnorrisbooks_count,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
	'no_found_rows'       => ! $dlnorrisbooks_paginate,
);

if ( $dlnorrisbooks_paginate ) {
	$dlnorrisbooks_query_args['paged'] = $dlnorrisbooks_paged;
}

$dlnorrisbooks_query = new WP_Query( $dlnorrisbooks_query_args );

// Only render the header band if it will actually contain something.
$dlnorrisbooks_has_header = ( $dlnorrisbooks_show_heading && ( '' !== $dlnorrisbooks_eyebrow || '' !== $dlnorrisbooks_title ) )
	|| ( $dlnorrisbooks_show_cta && '' !== $dlnorrisbooks_cta_text && $dlnorrisbooks_cta_url );

$dlnorrisbooks_wrapper = get_block_wrapper_attributes( array( 'class' => 'stories not-prose' ) );
?>
<section <?php echo $dlnorrisbooks_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="stories__inner">

		<?php if ( $dlnorrisbooks_has_header ) : ?>
			<header class="stories__header">
				<?php if ( $dlnorrisbooks_show_heading && ( '' !== $dlnorrisbooks_eyebrow || '' !== $dlnorrisbooks_title ) ) : ?>
					<div class="stories__heading">
						<?php if ( '' !== $dlnorrisbooks_eyebrow ) : ?>
							<span class="stories__eyebrow"><?php echo esc_html( $dlnorrisbooks_eyebrow ); ?></span>
						<?php endif; ?>
						<?php if ( '' !== $dlnorrisbooks_title ) : ?>
							<h2 class="stories__title"><?php echo esc_html( $dlnorrisbooks_title ); ?></h2>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( $dlnorrisbooks_show_cta && '' !== $dlnorrisbooks_cta_text && $dlnorrisbooks_cta_url ) : ?>
					<a class="stories__archive" href="<?php echo esc_url( $dlnorrisbooks_cta_url ); ?>">
						<?php echo esc_html( $dlnorrisbooks_cta_text ); ?>
						<svg class="stories__archive-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
							<path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</a>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<?php if ( $dlnorrisbooks_query->have_posts() ) : ?>
			<ul class="stories__grid">
				<?php
				while ( $dlnorrisbooks_query->have_posts() ) :
					$dlnorrisbooks_query->the_post();
					$dlnorrisbooks_excerpt = wp_trim_words( get_the_excerpt(), 22, '…' );
					?>
					<li class="stories__item">
						<a class="story-card" href="<?php the_permalink(); ?>">
							<div class="story-card__media">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail(
										'large',
										array(
											'class'   => 'story-card__image',
											'loading' => 'lazy',
										)
									);
								}
								?>
							</div>
							<div class="story-card__body">
								<h3 class="story-card__title"><?php the_title(); ?></h3>
								<?php if ( '' !== $dlnorrisbooks_excerpt ) : ?>
									<p class="story-card__excerpt"><?php echo esc_html( $dlnorrisbooks_excerpt ); ?></p>
								<?php endif; ?>
							</div>
						</a>
					</li>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</ul>

			<?php
			if ( $dlnorrisbooks_paginate && $dlnorrisbooks_query->max_num_pages > 1 ) :
				// Build a page-number base off the current permalink so links
				// resolve to `/blog/2/` on a static page (where `page` is the
				// pagination query var) rather than the `/page/2/` archive form.
				$dlnorrisbooks_permalink = get_permalink();
				// `%_%` resolves to '' for page 1 (clean permalink) and to the
				// format for later pages, so the first-page link points straight
				// at `/blog/` instead of redirecting through `/blog/1/`.
				$dlnorrisbooks_pag_base = $dlnorrisbooks_permalink
					? trailingslashit( $dlnorrisbooks_permalink ) . '%_%'
					: '';

				$dlnorrisbooks_links = paginate_links(
					array(
						'base'      => $dlnorrisbooks_pag_base,
						'format'    => '%#%/',
						'current'   => $dlnorrisbooks_paged,
						'total'     => $dlnorrisbooks_query->max_num_pages,
						'type'      => 'list',
						'prev_text' => __( 'Previous', 'dlnorrisbooks' ),
						'next_text' => __( 'Next', 'dlnorrisbooks' ),
						'mid_size'  => 1,
					)
				);

				if ( $dlnorrisbooks_links ) :
					?>
					<nav class="stories__pagination" aria-label="<?php esc_attr_e( 'Stories pagination', 'dlnorrisbooks' ); ?>">
						<?php echo $dlnorrisbooks_links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</nav>
					<?php
				endif;
			endif;
			?>
		<?php else : ?>
			<p class="stories__empty"><?php esc_html_e( 'No stories published yet.', 'dlnorrisbooks' ); ?></p>
		<?php endif; ?>

	</div>
</section>
