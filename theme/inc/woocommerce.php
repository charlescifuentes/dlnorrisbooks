<?php
/**
 * WooCommerce integration.
 *
 * The store is themed without copying any WooCommerce templates. Instead we
 * (a) declare support (in `functions.php`) so WooCommerce renders inside this
 * theme's header/footer, (b) swap WooCommerce's default content wrapper for the
 * theme container, and (c) style WooCommerce's own class names in
 * `tailwind/custom/components/woocommerce.css`. Keeping the canonical templates
 * means the store survives WooCommerce updates.
 *
 * @package dlnorrisbooks
 */

// Everything here is a no-op without WooCommerce; bail so the theme still works
// if the plugin is deactivated.
if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Replace WooCommerce's default content wrapper with the theme's container.
 *
 * WooCommerce's bundled archive/single templates output a `#primary`/`#main`
 * wrapper via these hooks; we swap in a full-width band whose inner column
 * matches the header and footer gutters. The sidebar is dropped entirely — the
 * store is a focused, single-column catalogue.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Open the store container.
 */
function dlnorrisbooks_wc_wrapper_start() {
	echo '<div id="primary" class="wc-page not-prose"><div class="wc-page__inner">';
}
add_action( 'woocommerce_before_main_content', 'dlnorrisbooks_wc_wrapper_start', 10 );

/**
 * Close the store container.
 */
function dlnorrisbooks_wc_wrapper_end() {
	echo '</div></div>';
}
add_action( 'woocommerce_after_main_content', 'dlnorrisbooks_wc_wrapper_end', 10 );

/**
 * Render a Page Intro banner (eyebrow, italic title, ornamental divider) so
 * every store view opens with the same visual language as the rest of the site.
 *
 * @param string $eyebrow Small-caps kicker above the title.
 * @param string $title   Banner heading.
 */
function dlnorrisbooks_wc_render_banner( $eyebrow, $title ) {
	?>
	<section class="page-intro wc-hero not-prose">
		<div class="page-intro__inner">
			<p class="page-intro__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<h1 class="page-intro__title"><?php echo esc_html( $title ); ?></h1>
			<div class="page-intro__flourish" aria-hidden="true">
				<span class="page-intro__rule"></span>
				<svg class="page-intro__mark" viewBox="0 0 16 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path d="M1 20V18H7V14H5C3.61667 14 2.4375 13.5125 1.4625 12.5375C0.4875 11.5625 0 10.3833 0 9C0 8 0.275 7.07917 0.825 6.2375C1.375 5.39583 2.11667 4.78333 3.05 4.4C3.2 3.15 3.74583 2.10417 4.6875 1.2625C5.62917 0.420833 6.73333 0 8 0C9.26667 0 10.3708 0.420833 11.3125 1.2625C12.2542 2.10417 12.8 3.15 12.95 4.4C13.8833 4.78333 14.625 5.39583 15.175 6.2375C15.725 7.07917 16 8 16 9C16 10.3833 15.5125 11.5625 14.5375 12.5375C13.5625 13.5125 12.3833 14 11 14H9V18H15V20H1V20M5 12H11C11.8333 12 12.5417 11.7083 13.125 11.125C13.7083 10.5417 14 9.83333 14 9C14 8.4 13.8292 7.85 13.4875 7.35C13.1458 6.85 12.7 6.48333 12.15 6.25L11.1 5.8L10.95 4.65C10.85 3.9 10.5208 3.27083 9.9625 2.7625C9.40417 2.25417 8.75 2 8 2C7.25 2 6.59583 2.25417 6.0375 2.7625C5.47917 3.27083 5.15 3.9 5.05 4.65L4.9 5.8L3.85 6.25C3.3 6.48333 2.85417 6.85 2.5125 7.35C2.17083 7.85 2 8.4 2 9C2 9.83333 2.29167 10.5417 2.875 11.125C3.45833 11.7083 4.16667 12 5 12V12Z" />
				</svg>
				<span class="page-intro__rule"></span>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Full-width shop banner. Rendered above the container, so WooCommerce's own
 * product header title is suppressed just below to avoid a duplicate heading.
 */
function dlnorrisbooks_wc_shop_banner() {
	if ( ! is_shop() && ! is_product_taxonomy() ) {
		return;
	}

	$dlnorrisbooks_eyebrow = is_product_taxonomy() ? __( 'Browse', 'dlnorrisbooks' ) : __( 'The Shop', 'dlnorrisbooks' );
	$dlnorrisbooks_title   = wp_strip_all_tags( woocommerce_page_title( false ) );
	dlnorrisbooks_wc_render_banner( $dlnorrisbooks_eyebrow, $dlnorrisbooks_title );
}
add_action( 'woocommerce_before_main_content', 'dlnorrisbooks_wc_shop_banner', 5 );

/**
 * Banner for the Cart, Checkout and My Account pages. These render through
 * `page.php` (they're ordinary WordPress pages holding WooCommerce blocks), so
 * `content-page.php` calls this to open them with the same themed heading as the
 * shop. A no-op on every non-store page.
 */
function dlnorrisbooks_wc_page_banner() {
	if ( is_cart() ) {
		$dlnorrisbooks_title = __( 'Cart', 'dlnorrisbooks' );
	} elseif ( is_checkout() ) {
		$dlnorrisbooks_title = __( 'Checkout', 'dlnorrisbooks' );
	} elseif ( is_account_page() ) {
		$dlnorrisbooks_title = __( 'My Account', 'dlnorrisbooks' );
	} else {
		return;
	}

	dlnorrisbooks_wc_render_banner( __( 'The Shop', 'dlnorrisbooks' ), $dlnorrisbooks_title );
}

// The themed banner above supplies the page title, so suppress WooCommerce's
// default products-header heading.
add_filter( 'woocommerce_show_page_title', '__return_false' );

/**
 * Show four products per row on the shop grid (the CSS grid is responsive, but
 * this keeps WooCommerce's own column count in step for any consumers of it).
 *
 * @param int $columns Default column count.
 * @return int
 */
function dlnorrisbooks_wc_loop_columns( $columns ) {
	return 3;
}
add_filter( 'loop_shop_columns', 'dlnorrisbooks_wc_loop_columns' );
