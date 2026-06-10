<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package dlnorrisbooks
 */

/**
 * Adds classes to primary navigation menu items.
 *
 * @param string[] $classes Menu item classes.
 * @param WP_Post  $item    Menu item object.
 * @param stdClass $args    Menu arguments.
 * @return string[]
 */
function dlnorrisbooks_nav_menu_css_class( $classes, $item, $args ) {
	if ( empty( $args->theme_location ) || 'menu-1' !== $args->theme_location ) {
		return $classes;
	}

	if (
		in_array( 'cta', $classes, true ) ||
		false !== stripos( $item->title, 'subscribe' )
	) {
		$classes[] = 'menu-item-cta';
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'dlnorrisbooks_nav_menu_css_class', 10, 3 );

/**
 * Adds classes to primary navigation menu links.
 *
 * @param array    $atts Menu link attributes.
 * @param WP_Post  $item Menu item object.
 * @param stdClass $args Menu arguments.
 * @return array
 */
function dlnorrisbooks_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( empty( $args->theme_location ) || 'menu-1' !== $args->theme_location ) {
		return $atts;
	}

	$is_cta = in_array( 'cta', $item->classes, true ) || false !== stripos( $item->title, 'subscribe' );

	$atts['class'] = $is_cta ? 'btn-pill' : 'primary-menu__link';

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'dlnorrisbooks_nav_menu_link_attributes', 10, 3 );

/**
 * Removes the Subscribe CTA from the primary nav (rendered separately on the right).
 *
 * @param WP_Post[] $items Menu items.
 * @param stdClass  $args  Menu arguments.
 * @return WP_Post[]
 */
function dlnorrisbooks_exclude_header_cta_from_menu( $items, $args ) {
	if ( empty( $args->theme_location ) || 'menu-1' !== $args->theme_location ) {
		return $items;
	}

	return array_values(
		array_filter(
			$items,
			function ( $item ) {
				return ! (
					in_array( 'cta', $item->classes, true ) ||
					false !== stripos( $item->title, 'subscribe' )
				);
			}
		)
	);
}
add_filter( 'wp_nav_menu_objects', 'dlnorrisbooks_exclude_header_cta_from_menu', 10, 2 );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function dlnorrisbooks_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'dlnorrisbooks_pingback_header' );

/**
 * Changes comment form default fields.
 *
 * @param array $defaults The default comment form arguments.
 *
 * @return array Returns the modified fields.
 */
function dlnorrisbooks_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'dlnorrisbooks_comment_form_defaults' );

/**
 * Filters the default archive titles.
 */
function dlnorrisbooks_get_the_archive_title() {
	if ( is_category() ) {
		$title = __( 'Category Archives: ', 'dlnorrisbooks' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$title = __( 'Tag Archives: ', 'dlnorrisbooks' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$title = __( 'Author Archives: ', 'dlnorrisbooks' ) . '<span>' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives: ', 'dlnorrisbooks' ) . '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'dlnorrisbooks' ) ) . '</span>';
	} elseif ( is_month() ) {
		$title = __( 'Monthly Archives: ', 'dlnorrisbooks' ) . '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'dlnorrisbooks' ) ) . '</span>';
	} elseif ( is_day() ) {
		$title = __( 'Daily Archives: ', 'dlnorrisbooks' ) . '<span>' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$cpt   = get_post_type_object( get_queried_object()->name );
		$title = sprintf(
			/* translators: %s: Post type singular name */
			esc_html__( '%s Archives', 'dlnorrisbooks' ),
			$cpt->labels->singular_name
		);
	} elseif ( is_tax() ) {
		$tax   = get_taxonomy( get_queried_object()->taxonomy );
		$title = sprintf(
			/* translators: %s: Taxonomy singular name */
			esc_html__( '%s Archives', 'dlnorrisbooks' ),
			$tax->labels->singular_name
		);
	} else {
		$title = __( 'Archives:', 'dlnorrisbooks' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'dlnorrisbooks_get_the_archive_title' );

/**
 * Determines whether the post thumbnail can be displayed.
 */
function dlnorrisbooks_can_show_post_thumbnail() {
	return apply_filters( 'dlnorrisbooks_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Returns the size for avatars used in the theme.
 */
function dlnorrisbooks_get_avatar_size() {
	return 60;
}

/**
 * Create the continue reading link
 *
 * @param string $more_string The string shown within the more link.
 */
function dlnorrisbooks_continue_reading_link( $more_string ) {

	if ( ! is_admin() ) {
		$continue_reading = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'dlnorrisbooks' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="sr-only">"', '"</span>', false )
		);

		$more_string = '<a href="' . esc_url( get_permalink() ) . '">' . $continue_reading . '</a>';
	}

	return $more_string;
}

// Filter the excerpt more link.
add_filter( 'excerpt_more', 'dlnorrisbooks_continue_reading_link' );

// Filter the content more link.
add_filter( 'the_content_more_link', 'dlnorrisbooks_continue_reading_link' );

/**
 * Outputs a comment in the HTML5 format.
 *
 * This function overrides the default WordPress comment output in HTML5
 * format, adding the required class for Tailwind Typography. Based on the
 * `html5_comment()` function from WordPress core.
 *
 * @param WP_Comment $comment Comment to display.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function dlnorrisbooks_html5_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

	$commenter          = wp_get_current_commenter();
	$show_pending_links = ! empty( $commenter['comment_author'] );

	if ( $commenter['comment_author_email'] ) {
		$moderation_note = __( 'Your comment is awaiting moderation.', 'dlnorrisbooks' );
	} else {
		$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'dlnorrisbooks' );
	}
	?>
	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					if ( 0 !== $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
					<?php
					$comment_author = get_comment_author_link( $comment );

					if ( '0' === $comment->comment_approved && ! $show_pending_links ) {
						$comment_author = get_comment_author( $comment );
					}

					printf(
						/* translators: %s: Comment author link. */
						wp_kses_post( __( '%s <span class="says">says:</span>', 'dlnorrisbooks' ) ),
						sprintf( '<b class="fn">%s</b>', wp_kses_post( $comment_author ) )
					);
					?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<?php
					printf(
						'<a href="%s"><time datetime="%s">%s</time></a>',
						esc_url( get_comment_link( $comment, $args ) ),
						esc_attr( get_comment_time( 'c' ) ),
						esc_html(
							sprintf(
							/* translators: 1: Comment date, 2: Comment time. */
								__( '%1$s at %2$s', 'dlnorrisbooks' ),
								get_comment_date( '', $comment ),
								get_comment_time()
							)
						)
					);

					edit_comment_link( __( 'Edit', 'dlnorrisbooks' ), ' <span class="edit-link">', '</span>' );
					?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' === $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?php echo esc_html( $moderation_note ); ?></em>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div <?php dlnorrisbooks_content_class( 'comment-content' ); ?>>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
			if ( '1' === $comment->comment_approved || $show_pending_links ) {
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						)
					)
				);
			}
			?>
		</article><!-- .comment-body -->
	<?php
}
