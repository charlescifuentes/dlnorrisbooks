<?php
/**
 * Server render for the `dlnorrisbooks/newsletter` block.
 *
 * The signup form is produced from the `formShortcode` attribute (e.g. the
 * Jetpack Blog Subscriptions shortcode). When that shortcode is not registered
 * — for example locally without Jetpack — a static placeholder form is shown.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    InnerBlocks HTML (unused).
 * @var WP_Block $block      Block instance.
 *
 * @package dlnorrisbooks
 */

$dlnorrisbooks_eyebrow     = isset( $attributes['eyebrow'] ) ? $attributes['eyebrow'] : '';
$dlnorrisbooks_heading     = isset( $attributes['heading'] ) ? $attributes['heading'] : '';
$dlnorrisbooks_description = isset( $attributes['description'] ) ? $attributes['description'] : '';
$dlnorrisbooks_shortcode   = isset( $attributes['formShortcode'] ) ? trim( $attributes['formShortcode'] ) : '';

$dlnorrisbooks_form = '';
if ( '' !== $dlnorrisbooks_shortcode ) {
	$dlnorrisbooks_rendered = do_shortcode( $dlnorrisbooks_shortcode );
	// Use it only if the shortcode actually resolved to markup.
	if ( '' !== trim( $dlnorrisbooks_rendered ) && trim( $dlnorrisbooks_rendered ) !== $dlnorrisbooks_shortcode ) {
		$dlnorrisbooks_form = $dlnorrisbooks_rendered;
	}
}

$dlnorrisbooks_wrapper = get_block_wrapper_attributes( array( 'class' => 'newsletter not-prose' ) );
?>
<section <?php echo $dlnorrisbooks_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="newsletter__inner">
		<?php if ( '' !== $dlnorrisbooks_eyebrow ) : ?>
			<span class="newsletter__eyebrow"><?php echo wp_kses_post( $dlnorrisbooks_eyebrow ); ?></span>
		<?php endif; ?>

		<?php if ( '' !== $dlnorrisbooks_heading ) : ?>
			<h2 class="newsletter__heading"><?php echo wp_kses_post( $dlnorrisbooks_heading ); ?></h2>
		<?php endif; ?>

		<?php if ( '' !== $dlnorrisbooks_description ) : ?>
			<p class="newsletter__description"><?php echo wp_kses_post( $dlnorrisbooks_description ); ?></p>
		<?php endif; ?>

		<div class="newsletter__form">
			<?php if ( '' !== $dlnorrisbooks_form ) : ?>
				<?php echo $dlnorrisbooks_form; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php else : ?>
				<form class="newsletter__fallback" method="post" action="">
					<input
						type="email"
						class="newsletter__input"
						name="email"
						placeholder="<?php esc_attr_e( 'Your email address…', 'dlnorrisbooks' ); ?>"
						aria-label="<?php esc_attr_e( 'Email address', 'dlnorrisbooks' ); ?>"
					/>
					<button type="submit" class="newsletter__submit">
						<?php esc_html_e( 'Subscribe', 'dlnorrisbooks' ); ?>
					</button>
				</form>
			<?php endif; ?>
		</div>
	</div>
</section>
