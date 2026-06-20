/**
 * Registers the `dlnorrisbooks/recent-stories` block on the client.
 *
 * Dynamic query block — cards are server-rendered from the latest posts in
 * `render.php`, previewed in the editor via ServerSideRender.
 */

import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit.js';

registerBlockType(metadata.name, {
	edit: Edit,
	save: () => null,
});
