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

$dlnorrisbooks_wrapper = get_block_wrapper_attributes( array( 'class' => 'testimonial not-prose' ) );
?>
<section <?php echo $dlnorrisbooks_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="testimonial__inner">
		<?php if ( '' !== $dlnorrisbooks_quote ) : ?>
			<blockquote class="testimonial__quote"><?php echo wp_kses_post( $dlnorrisbooks_quote ); ?></blockquote>
		<?php endif; ?>

		<?php if ( '' !== $dlnorrisbooks_citation ) : ?>
			<p class="testimonial__cite">
				<span class="testimonial__rule" aria-hidden="true"></span>
				<span class="testimonial__source"><?php echo wp_kses_post( $dlnorrisbooks_citation ); ?></span>
				<span class="testimonial__rule" aria-hidden="true"></span>
			</p>
		<?php endif; ?>
	</div>
</section>
