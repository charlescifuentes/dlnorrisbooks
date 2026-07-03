<?php
/**
 * Advanced Custom Fields definitions for this theme.
 *
 * Field groups are registered in code (rather than only stored in the
 * database) so they are version-controlled and deploy with the theme. The
 * whole file no-ops gracefully when ACF is not active.
 *
 * @package dlnorrisbooks
 */

/**
 * Register the Book Details field group for the `book` custom post type.
 *
 * Currently holds a single optional Subtitle line, shown beneath the title
 * in the single-book hero (see `template-parts/content/content-single-book.php`).
 */
function dlnorrisbooks_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_dlnorrisbooks_book_details',
			'title'                 => __( 'Book Details', 'dlnorrisbooks' ),
			'fields'                => array(
				array(
					'key'          => 'field_dlnorrisbooks_book_subtitle',
					'label'        => __( 'Subtitle', 'dlnorrisbooks' ),
					'name'         => 'book_subtitle',
					'type'         => 'text',
					'instructions' => __( 'Optional line shown beneath the title in the book hero (e.g. the book’s subtitle or an award).', 'dlnorrisbooks' ),
					'required'     => 0,
				),
				array(
					'key'          => 'field_dlnorrisbooks_book_buttons',
					'label'        => __( 'Purchase Buttons', 'dlnorrisbooks' ),
					'name'         => 'book_buttons',
					'type'         => 'repeater',
					'instructions' => __( 'Buttons shown in the book hero (e.g. Amazon, Barnes & Noble, the D. L. Norris Bookshop). Add one row per button; each can link anywhere, including a WooCommerce product.', 'dlnorrisbooks' ),
					'required'     => 0,
					'layout'       => 'table',
					'button_label' => __( 'Add button', 'dlnorrisbooks' ),
					'sub_fields'   => array(
						array(
							'key'      => 'field_dlnorrisbooks_book_button_label',
							'label'    => __( 'Label', 'dlnorrisbooks' ),
							'name'     => 'label',
							'type'     => 'text',
							'required' => 1,
						),
						array(
							'key'      => 'field_dlnorrisbooks_book_button_url',
							'label'    => __( 'URL', 'dlnorrisbooks' ),
							'name'     => 'url',
							'type'     => 'url',
							'required' => 1,
						),
					),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'book',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'active'                => true,
			'show_in_rest'          => 1,
		)
	);
}
add_action( 'acf/init', 'dlnorrisbooks_register_acf_fields' );
