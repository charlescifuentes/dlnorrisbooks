<?php
/**
 * Server render for the `dlnorrisbooks/testimonial` block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    InnerBlocks HTML (unused).
 * @var WP_Block $block      Block instance.
 *
 * @package dlnorrisbooks
 */

$dlnorrisbooks_quote    = isset( $attributes['quote'] ) ? $attributes['quote'] : '';
$dlnorrisbooks_citation = isset( $attributes['citation'] ) ? $attributes['citation'] : '';

$dlnorrisbooks_tone = isset( $attributes['tone'] ) ? $attributes['tone'] : 'blush';
$dlnorrisbooks_tone = in_array( $dlnorrisbooks_tone, array( 'blush', 'mist' ), true ) ? $dlnorrisbooks_tone : 'blush';

$dlnorrisbooks_side = isset( $attributes['side'] ) ? $attributes['side'] : 'center';
$dlnorrisbooks_side = in_array( $dlnorrisbooks_side, array( 'center', 'left', 'right' ), true ) ? $dlnorrisbooks_side : 'center';

// The flanking rules belong to the centered variant; the zigzag variant takes
// an em dash instead (supplied in CSS).
$dlnorrisbooks_has_rules = 'center' === $dlnorrisbooks_side;

// `--stack` marks the zigzag variants, which merge with their neighbours into a
// single band instead of standing alone.
$dlnorrisbooks_classes = sprintf(
	'testimonial testimonial--%s testimonial--%s',
	$dlnorrisbooks_tone,
	$dlnorrisbooks_side
);
if ( ! $dlnorrisbooks_has_rules ) {
	$dlnorrisbooks_classes .= ' testimonial--stack';
}

$dlnorrisbooks_wrapper = get_block_wrapper_attributes(
	array(
		'class' => $dlnorrisbooks_classes . ' not-prose',
	)
);
?>
<section <?php echo $dlnorrisbooks_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="testimonial__inner">
		<?php if ( '' !== $dlnorrisbooks_quote ) : ?>
			<blockquote class="testimonial__quote"><?php echo wp_kses_post( $dlnorrisbooks_quote ); ?></blockquote>
		<?php endif; ?>

		<?php if ( '' !== $dlnorrisbooks_citation ) : ?>
			<p class="testimonial__cite">
				<?php if ( $dlnorrisbooks_has_rules ) : ?>
					<span class="testimonial__rule" aria-hidden="true"></span>
				<?php endif; ?>
				<span class="testimonial__source"><?php echo wp_kses_post( $dlnorrisbooks_citation ); ?></span>
				<?php if ( $dlnorrisbooks_has_rules ) : ?>
					<span class="testimonial__rule" aria-hidden="true"></span>
				<?php endif; ?>
			</p>
		<?php endif; ?>
	</div>
</section>
