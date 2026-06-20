<?php
/**
 * Template part for displaying the footer content
 *
 * Mirrors the Figma Footer component: brand wordmark (left), footer nav
 * (center) and copyright (right) on a pale teal band.
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

		<?php if ( has_nav_menu( 'menu-2' ) ) : ?>
			<nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Footer', 'dlnorrisbooks' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-2',
						'menu_class'     => 'site-footer__menu',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		<?php endif; ?>

		<p class="site-footer__copyright">
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

	</div>
</footer><!-- #colophon -->
