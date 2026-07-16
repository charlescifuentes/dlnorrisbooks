/**
 * Editor interface for the Testimonial block.
 *
 * Mirrors the server-rendered markup; quote and attribution are edited inline.
 * Tone and side come from the inspector: `center` is the standalone band used
 * on the home page, while `left`/`right` stack into the zigzag reviews column.
 */

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';

const TONE_OPTIONS = [
	{ label: __('Blush', 'dlnorrisbooks'), value: 'blush' },
	{ label: __('Mist', 'dlnorrisbooks'), value: 'mist' },
];

const SIDE_OPTIONS = [
	{ label: __('Centered', 'dlnorrisbooks'), value: 'center' },
	{ label: __('Left', 'dlnorrisbooks'), value: 'left' },
	{ label: __('Right', 'dlnorrisbooks'), value: 'right' },
];

export default function Edit({ attributes, setAttributes }) {
	const { quote, citation, tone, side } = attributes;
	const hasRules = side === 'center';
	const blockProps = useBlockProps({
		className: [
			'testimonial',
			`testimonial--${tone}`,
			`testimonial--${side}`,
			hasRules ? '' : 'testimonial--stack',
			'not-prose',
		]
			.filter(Boolean)
			.join(' '),
	});

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Testimonial', 'dlnorrisbooks')}>
					<SelectControl
						label={__('Tone', 'dlnorrisbooks')}
						value={tone}
						options={TONE_OPTIONS}
						onChange={(value) => setAttributes({ tone: value })}
						__nextHasNoMarginBottom
					/>
					<SelectControl
						label={__('Alignment', 'dlnorrisbooks')}
						value={side}
						options={SIDE_OPTIONS}
						help={__(
							'Left and right stack into one continuous band — alternate them for a zigzag column of reviews.',
							'dlnorrisbooks'
						)}
						onChange={(value) => setAttributes({ side: value })}
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

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
						{hasRules && (
							<span
								className="testimonial__rule"
								aria-hidden="true"
							/>
						)}
						<RichText
							tagName="span"
							className="testimonial__source"
							value={citation}
							onChange={(value) =>
								setAttributes({ citation: value })
							}
							allowedFormats={[]}
							placeholder={__('Source', 'dlnorrisbooks')}
						/>
						{hasRules && (
							<span
								className="testimonial__rule"
								aria-hidden="true"
							/>
						)}
					</p>
				</div>
			</div>
		</>
	);
}
