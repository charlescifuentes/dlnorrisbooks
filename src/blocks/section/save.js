/**
 * Serializes the inner blocks into post content.
 *
 * The wrapper element is intentionally omitted here — it is produced by
 * `render.php` on the server so the band markup can stay in PHP alongside the
 * rest of the theme's templates.
 */

import { InnerBlocks } from '@wordpress/block-editor';

export default function save() {
	return <InnerBlocks.Content />;
}
