<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dlnorrisbooks
 */

?>

<header id="masthead" class="site-header">
	<div class="site-header__inner">
		<div class="site-header__brand">
			<?php dlnorrisbooks_site_branding(); ?>
		</div>

		<nav
			id="site-navigation"
			class="site-header__nav primary-navigation"
			aria-label="<?php esc_attr_e( 'Main Navigation', 'dlnorrisbooks' ); ?>"
		>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'primary-menu',
					'container'      => false,
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<div class="site-header__end">
			<?php dlnorrisbooks_header_cta_link(); ?>

			<button
				type="button"
				class="menu-toggle"
				aria-controls="primary-menu"
				aria-expanded="false"
				aria-label="<?php esc_attr_e( 'Open menu', 'dlnorrisbooks' ); ?>"
			>
				<svg class="menu-toggle__icon menu-toggle__icon--open" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
					<path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
				</svg>
				<svg class="menu-toggle__icon menu-toggle__icon--close" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
					<path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
				</svg>
			</button>
		</div>
	</div>
</header><!-- #masthead -->
