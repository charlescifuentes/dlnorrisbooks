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

$dlnorrisbooks_eyebrow  = isset( $attributes['eyebrow'] ) ? $attributes['eyebrow'] : '';
$dlnorrisbooks_title    = isset( $attributes['title'] ) ? $attributes['title'] : '';
$dlnorrisbooks_count    = isset( $attributes['count'] ) ? absint( $attributes['count'] ) : 4;
$dlnorrisbooks_cta_text = isset( $attributes['ctaText'] ) ? $attributes['ctaText'] : '';

$dlnorrisbooks_posts_page = (int) get_option( 'page_for_posts' );
$dlnorrisbooks_cta_url    = ! empty( $attributes['ctaUrl'] )
	? $attributes['ctaUrl']
	: ( $dlnorrisbooks_posts_page ? get_permalink( $dlnorrisbooks_posts_page ) : home_url( '/' ) );

$dlnorrisbooks_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => $dlnorrisbooks_count,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$dlnorrisbooks_wrapper = get_block_wrapper_attributes( array( 'class' => 'stories not-prose' ) );
?>
<section <?php echo $dlnorrisbooks_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="stories__inner">

		<header class="stories__header">
			<div class="stories__heading">
				<?php if ( '' !== $dlnorrisbooks_eyebrow ) : ?>
					<span class="stories__eyebrow"><?php echo esc_html( $dlnorrisbooks_eyebrow ); ?></span>
				<?php endif; ?>
				<?php if ( '' !== $dlnorrisbooks_title ) : ?>
					<h2 class="stories__title"><?php echo esc_html( $dlnorrisbooks_title ); ?></h2>
				<?php endif; ?>
			</div>
			<?php if ( '' !== $dlnorrisbooks_cta_text && $dlnorrisbooks_cta_url ) : ?>
				<a class="stories__archive" href="<?php echo esc_url( $dlnorrisbooks_cta_url ); ?>">
					<?php echo esc_html( $dlnorrisbooks_cta_text ); ?>
					<svg class="stories__archive-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
						<path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</a>
			<?php endif; ?>
		</header>

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
		<?php else : ?>
			<p class="stories__empty"><?php esc_html_e( 'No stories published yet.', 'dlnorrisbooks' ); ?></p>
		<?php endif; ?>

	</div>
</section>
