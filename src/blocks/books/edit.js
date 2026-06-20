/**
 * Editor interface for the Books block.
 *
 * This is a CPT query block, so the cards are previewed with ServerSideRender
 * (the same PHP render used on the front end). Text + settings are edited in
 * the sidebar.
 */

import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, RangeControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit({ attributes, setAttributes }) {
	const { eyebrow, title, count, ctaText, ctaUrl } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Heading', 'dlnorrisbooks')}>
					<TextControl
						label={__('Eyebrow', 'dlnorrisbooks')}
						value={eyebrow}
						onChange={(value) => setAttributes({ eyebrow: value })}
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<TextControl
						label={__('Title', 'dlnorrisbooks')}
						value={title}
						onChange={(value) => setAttributes({ title: value })}
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
				</PanelBody>
				<PanelBody title={__('Books', 'dlnorrisbooks')}>
					<RangeControl
						label={__('Number of books', 'dlnorrisbooks')}
						value={count}
						onChange={(value) => setAttributes({ count: value })}
						min={1}
						max={12}
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
				</PanelBody>
				<PanelBody title={__('Call to action', 'dlnorrisbooks')}>
					<TextControl
						label={__('Button text', 'dlnorrisbooks')}
						value={ctaText}
						onChange={(value) => setAttributes({ ctaText: value })}
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<TextControl
						label={__('Button URL', 'dlnorrisbooks')}
						value={ctaUrl}
						onChange={(value) => setAttributes({ ctaUrl: value })}
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<ServerSideRender
					block="dlnorrisbooks/books"
					attributes={attributes}
				/>
			</div>
		</>
	);
}
