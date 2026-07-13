/**
 * Block editor modifications
 *
 * This file is loaded only by the block editor. Use it to modify the block
 * editor via its APIs.
 *
 * The JavaScript code you place here will be processed by esbuild, and the
 * output file will be created at `../theme/js/block-editor.min.js` and
 * enqueued in `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

/**
 * This import adds your front-end post title and Tailwind Typography classes
 * to the block editor. It also adds some helper classes so you can access the
 * post type when modifying the block editor’s appearance.
 */
import '@_tw/typography/block-editor-classes';

/**
 * Default new blocks to the theme's "wide" width.
 *
 * Out of the box blocks are inserted with Align: None (content width). This
 * filter sets the default `align` attribute to `wide` for every block that
 * supports wide alignment, so newly inserted content fills the wider column
 * without choosing "Wide width" each time. Existing blocks keep whatever
 * alignment they were saved with. Registered at module scope (before core
 * blocks register) so the default applies to them.
 *
 * Excluded on the `post` editor: single posts read in the narrower
 * content-width column (matching the single-post design), so blog post content
 * should default to content width, not wide. Pages and the `book` CPT keep the
 * wide default so their section canvas fills out.
 */
const dlnorrisbooksEditorPostType =
	(window.dlnorrisbooksTheme && window.dlnorrisbooksTheme.postType) || '';

wp.hooks.addFilter(
	'blocks.registerBlockType',
	'dlnorrisbooks/default-wide-align',
	(settings) => {
		if (dlnorrisbooksEditorPostType === 'post') {
			return settings;
		}

		const align = settings.supports && settings.supports.align;
		const allowsWide =
			align === true || (Array.isArray(align) && align.includes('wide'));

		if (allowsWide) {
			settings.attributes = settings.attributes || {};
			settings.attributes.align = {
				...settings.attributes.align,
				type: 'string',
				default: 'wide',
			};
		}

		return settings;
	}
);

wp.domReady(() => {
	/**
	 * Add support for Tailwind Typography’s `lead` class via a block style.
	 */
	wp.blocks.registerBlockStyle('core/paragraph', {
		name: 'lead',
		label: 'Lead',
	});

	// Add additional block editor modifications here. For example, you could
	// register another block style:
	//
	// wp.blocks.registerBlockStyle( 'core/quote', {
	// 	name: 'fancy-quote',
	// 	label: 'Fancy Quote',
	// } );
});
