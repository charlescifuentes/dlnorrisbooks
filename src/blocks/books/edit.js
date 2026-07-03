/**
 * Editor interface for the Books block.
 *
 * This is a CPT query block, so the cards are previewed with ServerSideRender
 * (the same PHP render used on the front end). Text + settings are edited in
 * the sidebar.
 */

import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	RangeControl,
	ToggleControl,
} from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit({ attributes, setAttributes }) {
	const { eyebrow, title, count, showWaves, showCta, ctaText, ctaUrl } =
		attributes;
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
				<PanelBody title={__('Appearance', 'dlnorrisbooks')}>
					<ToggleControl
						label={__('Wavy edges', 'dlnorrisbooks')}
						help={__(
							'Curved top and bottom dividers that blend the band into neighbouring sections. Turn off for a flat band on standalone pages.',
							'dlnorrisbooks'
						)}
						checked={showWaves}
						onChange={(value) =>
							setAttributes({ showWaves: value })
						}
						__nextHasNoMarginBottom
					/>
				</PanelBody>
				<PanelBody title={__('Call to action', 'dlnorrisbooks')}>
					<ToggleControl
						label={__('Show button', 'dlnorrisbooks')}
						help={__(
							'The "View All Books" button. Turn off on the Books page itself, where the full collection is already shown.',
							'dlnorrisbooks'
						)}
						checked={showCta}
						onChange={(value) =>
							setAttributes({ showCta: value })
						}
						__nextHasNoMarginBottom
					/>
					{showCta && (
						<>
							<TextControl
								label={__('Button text', 'dlnorrisbooks')}
								value={ctaText}
								onChange={(value) =>
									setAttributes({ ctaText: value })
								}
								__nextHasNoMarginBottom
								__next40pxDefaultSize
							/>
							<TextControl
								label={__('Button URL', 'dlnorrisbooks')}
								value={ctaUrl}
								onChange={(value) =>
									setAttributes({ ctaUrl: value })
								}
								__nextHasNoMarginBottom
								__next40pxDefaultSize
							/>
						</>
					)}
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
