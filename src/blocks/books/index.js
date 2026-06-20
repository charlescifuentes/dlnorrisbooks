/**
 * Registers the `dlnorrisbooks/books` block on the client.
 *
 * Dynamic query block — the cards are server-rendered from the Books CPT in
 * `render.php`, previewed in the editor via ServerSideRender.
 */

import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit.js';

registerBlockType(metadata.name, {
	edit: Edit,
	save: () => null,
});
