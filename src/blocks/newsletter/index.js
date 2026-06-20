/**
 * Registers the `dlnorrisbooks/newsletter` block on the client.
 *
 * Dynamic (server-rendered) block — markup lives in `render.php`; the form is
 * rendered from a shortcode on the server.
 */

import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit.js';

registerBlockType(metadata.name, {
	edit: Edit,
	save: () => null,
});
