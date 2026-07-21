<?php
/**
 * Server render for the `dlnorrisbooks/hero` block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    InnerBlocks HTML (unused).
 * @var WP_Block $block      Block instance.
 *
 * @package dlnorrisbooks
 */

$dlnorrisbooks_eyebrow  = isset( $attributes['eyebrow'] ) ? $attributes['eyebrow'] : '';
$dlnorrisbooks_heading  = isset( $attributes['heading'] ) ? $attributes['heading'] : '';
$dlnorrisbooks_subtitle = isset( $attributes['subtitle'] ) ? $attributes['subtitle'] : '';
$dlnorrisbooks_cta_text = isset( $attributes['ctaText'] ) ? $attributes['ctaText'] : '';
$dlnorrisbooks_cta_url  = isset( $attributes['ctaUrl'] ) ? $attributes['ctaUrl'] : '';

// Unless a specific URL was set, the button scrolls down to the Books section
// (anchored in the books block). '#' is the attribute's placeholder default.
if ( '' === $dlnorrisbooks_cta_url || '#' === $dlnorrisbooks_cta_url ) {
	$dlnorrisbooks_cta_url = '#the-books';
}

$dlnorrisbooks_assets       = get_template_directory_uri() . '/assets/images/hero/';
$dlnorrisbooks_portrait_url = ! empty( $attributes['portraitUrl'] ) ? $attributes['portraitUrl'] : $dlnorrisbooks_assets . 'portrait.webp';
$dlnorrisbooks_portrait_alt = isset( $attributes['portraitAlt'] ) ? $attributes['portraitAlt'] : '';

$dlnorrisbooks_wrapper = get_block_wrapper_attributes( array( 'class' => 'hero not-prose' ) );
?>
<section <?php echo $dlnorrisbooks_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="hero__inner">

		<div class="hero__content">
			<?php if ( '' !== $dlnorrisbooks_eyebrow ) : ?>
				<p class="hero__eyebrow"><?php echo wp_kses_post( $dlnorrisbooks_eyebrow ); ?></p>
			<?php endif; ?>

			<?php if ( '' !== $dlnorrisbooks_heading ) : ?>
				<h1 class="hero__heading"><?php echo wp_kses_post( $dlnorrisbooks_heading ); ?></h1>
			<?php endif; ?>

			<?php if ( '' !== $dlnorrisbooks_subtitle ) : ?>
				<p class="hero__subtitle"><?php echo wp_kses_post( $dlnorrisbooks_subtitle ); ?></p>
			<?php endif; ?>

			<?php if ( '' !== $dlnorrisbooks_cta_text ) : ?>
				<a class="hero__cta btn-pill" href="<?php echo esc_url( $dlnorrisbooks_cta_url ); ?>">
					<?php echo esc_html( $dlnorrisbooks_cta_text ); ?>
				</a>
			<?php endif; ?>
		</div>

		<div class="hero__media">
			<?php
			if ( ! empty( $attributes['portraitId'] ) ) {
				echo wp_get_attachment_image(
					(int) $attributes['portraitId'],
					'large',
					false,
					array(
						'class'    => 'hero__portrait',
						'loading'  => 'eager',
						'decoding' => 'async',
					)
				);
			} else {
				printf(
					'<img class="hero__portrait" src="%s" alt="%s" loading="eager" decoding="async" />',
					esc_url( $dlnorrisbooks_portrait_url ),
					esc_attr( $dlnorrisbooks_portrait_alt )
				);
			}
			?>
		</div>

	</div>
</section>
