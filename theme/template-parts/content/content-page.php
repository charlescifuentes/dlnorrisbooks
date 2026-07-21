<?php
/**
 * Template part for displaying page content
 *
 * General pages are built entirely with blocks — the page heading is provided
 * by a block, so this template renders no theme title or featured image. The
 * content is a full-bleed canvas: blocks set to "Full width" span edge to edge
 * (and sit flush under the header / above the footer), while default blocks
 * stay constrained to the reading width via `entry-content` (see
 * `tailwind/custom/components/components.css`).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dlnorrisbooks
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>

	<?php
	// Cart / Checkout / My Account (WooCommerce block pages) open with the shared
	// themed banner; a no-op on every other page.
	if ( function_exists( 'dlnorrisbooks_wc_page_banner' ) ) {
		dlnorrisbooks_wc_page_banner();
	}
	?>

	<?php
	// Store pages (Cart / Checkout / My Account) are WooCommerce block UI, not
	// prose. Skip Tailwind Typography on them so its heading/link/spacing rules
	// don't fight the block layout; every other page keeps the reading styles.
	$dlnorrisbooks_is_store_page = function_exists( 'is_woocommerce' ) && ( is_cart() || is_checkout() || is_account_page() );
	?>
	<?php if ( $dlnorrisbooks_is_store_page ) : ?>
	<div class="entry-content wc-store-content not-prose">
	<?php else : ?>
	<div <?php dlnorrisbooks_content_class( 'entry-content' ); ?>>
	<?php endif; ?>
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div>' . __( 'Pages:', 'dlnorrisbooks' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers. */
						__( 'Edit <span class="sr-only">%s</span>', 'dlnorrisbooks' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
