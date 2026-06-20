<?php
/**
 * Custom post types for this theme.
 *
 * @package dlnorrisbooks
 */

/**
 * Register the `book` custom post type.
 *
 * Guarded with `post_type_exists()` so it does not conflict if the CPT is
 * also provided by a plugin.
 */
function dlnorrisbooks_register_book_cpt() {
	if ( post_type_exists( 'book' ) ) {
		return;
	}

	$labels = array(
		'name'               => _x( 'Books', 'post type general name', 'dlnorrisbooks' ),
		'singular_name'      => _x( 'Book', 'post type singular name', 'dlnorrisbooks' ),
		'menu_name'          => _x( 'Books', 'admin menu', 'dlnorrisbooks' ),
		'add_new'            => __( 'Add New', 'dlnorrisbooks' ),
		'add_new_item'       => __( 'Add New Book', 'dlnorrisbooks' ),
		'edit_item'          => __( 'Edit Book', 'dlnorrisbooks' ),
		'new_item'           => __( 'New Book', 'dlnorrisbooks' ),
		'view_item'          => __( 'View Book', 'dlnorrisbooks' ),
		'search_items'       => __( 'Search Books', 'dlnorrisbooks' ),
		'not_found'          => __( 'No books found', 'dlnorrisbooks' ),
		'not_found_in_trash' => __( 'No books found in Trash', 'dlnorrisbooks' ),
		'all_items'          => __( 'All Books', 'dlnorrisbooks' ),
	);

	register_post_type(
		'book',
		array(
			'labels'        => $labels,
			'public'        => true,
			'has_archive'   => true,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-book',
			'menu_position' => 5,
			'rewrite'       => array( 'slug' => 'books' ),
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		)
	);
}
add_action( 'init', 'dlnorrisbooks_register_book_cpt' );
