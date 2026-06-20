<?php
/**
 * Server render for the `dlnorrisbooks/section` block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    InnerBlocks HTML.
 * @var WP_Block $block      Block instance.
 *
 * @package dlnorrisbooks
 */

$dlnorrisbooks_tone = isset( $attributes['tone'] ) ? $attributes['tone'] : 'peach';
$dlnorrisbooks_tone = in_array( $dlnorrisbooks_tone, array( 'peach', 'oat' ), true ) ? $dlnorrisbooks_tone : 'peach';

$dlnorrisbooks_wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'section-band-' . $dlnorrisbooks_tone,
	)
);
?>
<div <?php echo $dlnorrisbooks_wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="mx-auto w-full max-w-wide">
		<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</div>
