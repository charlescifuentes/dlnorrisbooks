/**
 * The editor interface for the Section Band block.
 *
 * The visible band styling (`.section-band-{tone}`) is shared with the front
 * end via the theme's Tailwind build, so the editor preview matches the
 * server-rendered output.
 */

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	useInnerBlocksProps,
	InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';

const TEMPLATE = [
	[
		'core/heading',
		{ level: 2, placeholder: __('Section heading…', 'dlnorrisbooks') },
	],
	[
		'core/paragraph',
		{ placeholder: __('Section content…', 'dlnorrisbooks') },
	],
];

const TONE_OPTIONS = [
	{ label: __('Peach', 'dlnorrisbooks'), value: 'peach' },
	{ label: __('Oat', 'dlnorrisbooks'), value: 'oat' },
];

export default function Edit({ attributes, setAttributes }) {
	const { tone } = attributes;

	const blockProps = useBlockProps({
		className: `section-band-${tone}`,
	});

	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'mx-auto w-full max-w-wide' },
		{ template: TEMPLATE }
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Section', 'dlnorrisbooks')}>
					<SelectControl
						label={__('Tone', 'dlnorrisbooks')}
						value={tone}
						options={TONE_OPTIONS}
						onChange={(value) => setAttributes({ tone: value })}
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div {...innerBlocksProps} />
			</div>
		</>
	);
}
