/**
 * Registers the `dlnorrisbooks/quote` block on the client.
 *
 * Dynamic (server-rendered) block — markup lives in `render.php`.
 */

import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit.js';

registerBlockType(metadata.name, {
	edit: Edit,
	save: () => null,
});
