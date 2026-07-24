<?php
/**
 * Template part for displaying the footer content
 *
 * Two-tier footer on a pale teal band:
 *  - Main row: brand wordmark (left) beside two stacked link columns
 *    (center/right), each headed by its assigned menu's name — used for the
 *    "Featured Short Stories" and "Stories of the Heart" collections.
 *  - Sub-footer row: copyright (left) with a horizontal utility menu (right).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dlnorrisbooks
 */

?>

<footer id="colophon" class="site-footer">
	<div class="site-footer__inner">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-footer__brand">
			<?php bloginfo( 'name' ); ?>
		</a>

		<?php
		// Each column self-guards, so an unassigned location simply renders
		// nothing and the grid track collapses.
		dlnorrisbooks_footer_menu_column( 'menu-3' );
		dlnorrisbooks_footer_menu_column( 'menu-4' );
		?>

	</div>

	<div class="site-subfooter">
		<div class="site-subfooter__inner">

			<p class="site-subfooter__copyright">
				<?php
				printf(
					/* translators: 1: copyright year, 2: site name. */
					esc_html__( '© %1$s %2$s.', 'dlnorrisbooks' ),
					esc_html( gmdate( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);

				$dlnorrisbooks_tagline = get_bloginfo( 'description' );
				if ( ! empty( $dlnorrisbooks_tagline ) ) {
					echo ' ' . esc_html( $dlnorrisbooks_tagline ) . '.';
				}
				?>
			</p>

			<?php if ( has_nav_menu( 'menu-2' ) ) : ?>
				<nav class="site-subfooter__nav" aria-label="<?php esc_attr_e( 'Legal', 'dlnorrisbooks' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-2',
							'menu_class'     => 'site-subfooter__menu',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			<?php endif; ?>

		</div>
	</div>
</footer><!-- #colophon -->
