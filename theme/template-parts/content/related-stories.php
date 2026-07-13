<?php
/**
 * "You might also enjoy" — up to two related posts shown as image + category +
 * title cards. Prefers posts sharing a category, then fills with recent posts.
 * Part of the single-post template (Figma node 96:976).
 *
 * Runs inside the loop and restores the global post afterwards.
 *
 * @package dlnorrisbooks
 */

$dlnorrisbooks_current_id = get_the_ID();
$dlnorrisbooks_cats       = wp_get_post_categories( $dlnorrisbooks_current_id );

// Same-category posts first.
$dlnorrisbooks_related_ids = array();
if ( ! empty( $dlnorrisbooks_cats ) ) {
	$dlnorrisbooks_related_ids = get_posts(
		array(
			'posts_per_page'      => 2,
			'post__not_in'        => array( $dlnorrisbooks_current_id ),
			'category__in'        => $dlnorrisbooks_cats,
			'fields'              => 'ids',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
}

// Fill any remaining slots with the most recent posts.
if ( count( $dlnorrisbooks_related_ids ) < 2 ) {
	$dlnorrisbooks_more = get_posts(
		array(
			'posts_per_page'      => 2 - count( $dlnorrisbooks_related_ids ),
			'post__not_in'        => array_merge( array( $dlnorrisbooks_current_id ), $dlnorrisbooks_related_ids ),
			'fields'              => 'ids',
			'orderby'             => 'date',
			'order'               => 'DESC',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);

	$dlnorrisbooks_related_ids = array_merge( $dlnorrisbooks_related_ids, $dlnorrisbooks_more );
}

if ( empty( $dlnorrisbooks_related_ids ) ) {
	return;
}
?>

<section class="related-stories not-prose">
	<div class="related-stories__inner">
		<h2 class="related-stories__title"><?php esc_html_e( 'You might also enjoy', 'dlnorrisbooks' ); ?></h2>

		<div class="related-stories__grid">
			<?php
			global $post;
			foreach ( $dlnorrisbooks_related_ids as $dlnorrisbooks_related_id ) :
				$post = get_post( $dlnorrisbooks_related_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $post );

				$dlnorrisbooks_card_terms = get_the_terms( $dlnorrisbooks_related_id, 'category' );
				$dlnorrisbooks_card_cat   = ( is_array( $dlnorrisbooks_card_terms ) && ! empty( $dlnorrisbooks_card_terms ) )
					? $dlnorrisbooks_card_terms[0]->name
					: '';
				?>
				<a class="related-card" href="<?php the_permalink(); ?>">
					<div class="related-card__media">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail(
								'medium',
								array(
									'class'   => 'related-card__img',
									'loading' => 'lazy',
								)
							);
						}
						?>
					</div>
					<div class="related-card__body">
						<?php if ( '' !== $dlnorrisbooks_card_cat ) : ?>
							<span class="related-card__eyebrow"><?php echo esc_html( $dlnorrisbooks_card_cat ); ?></span>
						<?php endif; ?>
						<h3 class="related-card__title"><?php the_title(); ?></h3>
					</div>
				</a>
				<?php
			endforeach;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
