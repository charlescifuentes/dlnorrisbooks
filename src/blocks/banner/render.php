<?php
/**
 * Server render for the `dlnorrisbooks/banner` block.
 *
 * A full-bleed image banner with a centered label card — the reusable page
 * hero used across the site (About, Books, Blog, …).
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    InnerBlocks HTML (unused).
 * @var WP_Block $block      Block instance.
 *
 * @package dlnorrisbooks
 */

$dlnorrisbooks_label = isset( $attributes['label'] ) ? $attributes['label'] : '';

$dlnorrisbooks_default_image = get_template_directory_uri() . '/assets/images/banner/author-banner.jpg';
$dlnorrisbooks_image_url     = ! empty( $attributes['imageUrl'] ) ? $attributes['imageUrl'] : $dlnorrisbooks_default_image;
$dlnorrisbooks_image_alt     = isset( $attributes['imageAlt'] ) ? $attributes['imageAlt'] : '';

$dlnorrisbooks_focal = isset( $attributes['focalPoint'] ) && is_array( $attributes['focalPoint'] )
	? $attributes['focalPoint']
	: array(
		'x' => 0.5,
		'y' => 0.5,
	);
$dlnorrisbooks_focal_x = isset( $dlnorrisbooks_focal['x'] ) ? (float) $dlnorrisbooks_focal['x'] : 0.5;
$dlnorrisbooks_focal_y = isset( $dlnorrisbooks_focal['y'] ) ? (float) $dlnorrisbooks_focal['y'] : 0.5;
$dlnorrisbooks_position = sprintf(
	'object-position:%s%% %s%%;',
	round( $dlnorrisbooks_focal_x * 100, 2 ),
	round( $dlnorrisbooks_focal_y * 100, 2 )
);

$dlnorrisbooks_wrapper = get_block_wrapper_attributes( array( 'class' => 'banner not-prose' ) );
?>
<section <?php echo $dlnorrisbooks_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="banner__media">
		<?php
		if ( ! empty( $attributes['imageId'] ) ) {
			echo wp_get_attachment_image(
				(int) $attributes['imageId'],
				'full',
				false,
				array(
					'class'    => 'banner__image',
					'style'    => $dlnorrisbooks_position,
					'loading'  => 'eager',
					'decoding' => 'async',
				)
			);
		} else {
			printf(
				'<img class="banner__image" src="%s" alt="%s" style="%s" loading="eager" decoding="async" />',
				esc_url( $dlnorrisbooks_image_url ),
				esc_attr( $dlnorrisbooks_image_alt ),
				esc_attr( $dlnorrisbooks_position )
			);
		}
		?>
		<span class="banner__overlay" aria-hidden="true"></span>
	</div>

	<div class="banner__inner">
		<?php if ( '' !== $dlnorrisbooks_label ) : ?>
			<div class="banner__card">
				<p class="banner__label"><?php echo wp_kses_post( $dlnorrisbooks_label ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
