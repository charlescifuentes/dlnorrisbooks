/**
 * Editor interface for the Testimonial block.
 *
 * Mirrors the server-rendered markup; quote and attribution are edited inline.
 */

import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function Edit({ attributes, setAttributes }) {
	const { quote, citation } = attributes;
	const blockProps = useBlockProps({ className: 'testimonial not-prose' });

	return (
		<div {...blockProps}>
			<div className="testimonial__inner">
				<RichText
					tagName="blockquote"
					className="testimonial__quote"
					value={quote}
					onChange={(value) => setAttributes({ quote: value })}
					allowedFormats={['core/italic', 'core/bold']}
					placeholder={__('Add a testimonial…', 'dlnorrisbooks')}
				/>
				<p className="testimonial__cite">
					<span className="testimonial__rule" aria-hidden="true" />
					<RichText
						tagName="span"
						className="testimonial__source"
						value={citation}
						onChange={(value) => setAttributes({ citation: value })}
						allowedFormats={[]}
						placeholder={__('Source', 'dlnorrisbooks')}
					/>
					<span className="testimonial__rule" aria-hidden="true" />
				</p>
			</div>
		</div>
	);
}
