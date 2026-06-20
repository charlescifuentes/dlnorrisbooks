<?php
/**
 * Server render for the `dlnorrisbooks/author` block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    InnerBlocks HTML (unused).
 * @var WP_Block $block      Block instance.
 *
 * @package dlnorrisbooks
 */

$dlnorrisbooks_eyebrow   = isset( $attributes['eyebrow'] ) ? $attributes['eyebrow'] : '';
$dlnorrisbooks_heading   = isset( $attributes['heading'] ) ? $attributes['heading'] : '';
$dlnorrisbooks_bio       = isset( $attributes['bio'] ) ? $attributes['bio'] : '';
$dlnorrisbooks_link_text = isset( $attributes['linkText'] ) ? $attributes['linkText'] : '';
$dlnorrisbooks_link_url  = isset( $attributes['linkUrl'] ) ? $attributes['linkUrl'] : '';

$dlnorrisbooks_image_url = ! empty( $attributes['imageUrl'] )
	? $attributes['imageUrl']
	: get_template_directory_uri() . '/assets/images/author-placeholder.webp';
$dlnorrisbooks_image_alt = isset( $attributes['imageAlt'] ) ? $attributes['imageAlt'] : '';

$dlnorrisbooks_wrapper = get_block_wrapper_attributes( array( 'class' => 'author not-prose' ) );
?>
<section <?php echo $dlnorrisbooks_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<span class="author__wave author__wave--top" aria-hidden="true"></span>

	<div class="author__inner">
		<div class="author__media">
			<span class="author__decor" aria-hidden="true"></span>
			<div class="author__frame">
				<img
					class="author__image"
					src="<?php echo esc_url( $dlnorrisbooks_image_url ); ?>"
					alt="<?php echo esc_attr( $dlnorrisbooks_image_alt ); ?>"
					loading="lazy"
					decoding="async"
				/>
			</div>
		</div>

		<div class="author__content">
			<?php if ( '' !== $dlnorrisbooks_eyebrow ) : ?>
				<span class="author__eyebrow"><?php echo wp_kses_post( $dlnorrisbooks_eyebrow ); ?></span>
			<?php endif; ?>

			<?php if ( '' !== $dlnorrisbooks_heading ) : ?>
				<h2 class="author__heading"><?php echo wp_kses_post( $dlnorrisbooks_heading ); ?></h2>
			<?php endif; ?>

			<?php if ( '' !== $dlnorrisbooks_bio ) : ?>
				<p class="author__bio"><?php echo wp_kses_post( $dlnorrisbooks_bio ); ?></p>
			<?php endif; ?>

			<?php if ( '' !== $dlnorrisbooks_link_text && $dlnorrisbooks_link_url ) : ?>
				<a class="author__link" href="<?php echo esc_url( $dlnorrisbooks_link_url ); ?>">
					<?php echo esc_html( $dlnorrisbooks_link_text ); ?>
					<svg class="author__link-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
						<path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
