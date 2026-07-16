<?php
/**
 * Server render for the `dlnorrisbooks/contact` block.
 *
 * The Figma Main Content Area (node 116:1148): a cream form card spanning seven
 * of twelve columns, with a sidebar of contact detail groups beside it.
 *
 * The card holds InnerBlocks rather than markup of its own — the form itself is
 * expected to be a Jetpack Form block, which handles submission, spam filtering
 * and storage. The theme only skins it (see `contact.css`).
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    InnerBlocks HTML — the form.
 * @var WP_Block $block      Block instance.
 *
 * @package dlnorrisbooks
 */

$dlnorrisbooks_details = isset( $attributes['details'] ) && is_array( $attributes['details'] )
	? $attributes['details']
	: array();

$dlnorrisbooks_wrapper = get_block_wrapper_attributes( array( 'class' => 'contact not-prose' ) );
?>
<section <?php echo $dlnorrisbooks_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="contact__inner">
		<div class="contact__form">
			<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>

		<?php if ( ! empty( $dlnorrisbooks_details ) ) : ?>
			<aside class="contact__details">
				<?php foreach ( $dlnorrisbooks_details as $dlnorrisbooks_group ) : ?>
					<?php
					$dlnorrisbooks_label = isset( $dlnorrisbooks_group['label'] ) ? $dlnorrisbooks_group['label'] : '';
					$dlnorrisbooks_name  = isset( $dlnorrisbooks_group['name'] ) ? $dlnorrisbooks_group['name'] : '';
					$dlnorrisbooks_body  = isset( $dlnorrisbooks_group['body'] ) ? $dlnorrisbooks_group['body'] : '';
					?>
					<div class="contact-detail">
						<?php if ( '' !== $dlnorrisbooks_label ) : ?>
							<p class="contact-detail__label"><?php echo wp_kses_post( $dlnorrisbooks_label ); ?></p>
						<?php endif; ?>

						<div class="contact-detail__group">
							<?php if ( '' !== $dlnorrisbooks_name ) : ?>
								<p class="contact-detail__name"><?php echo wp_kses_post( $dlnorrisbooks_name ); ?></p>
							<?php endif; ?>

							<?php if ( '' !== $dlnorrisbooks_body ) : ?>
								<p class="contact-detail__body"><?php echo wp_kses_post( $dlnorrisbooks_body ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</aside>
		<?php endif; ?>
	</div>
</section>
