/**
 * Registers the `dlnorrisbooks/hero` block on the client.
 *
 * Dynamic (server-rendered) block — the markup lives in `render.php`; this
 * registers the editor interface only.
 */

import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit.js';

registerBlockType(metadata.name, {
	edit: Edit,
	save: () => null,
});
