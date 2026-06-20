/**
 * Registers the `dlnorrisbooks/section` block on the client.
 *
 * This is a dynamic (server-rendered) block: the wrapper markup lives in
 * `render.php`, while the inner blocks are serialized via `save.js`.
 */

import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit.js';
import save from './save.js';

registerBlockType(metadata.name, {
	edit: Edit,
	save,
});
