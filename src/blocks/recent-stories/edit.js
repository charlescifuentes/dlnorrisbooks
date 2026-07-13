/**
 * Editor interface for the Recent Stories block.
 *
 * CPT/posts query block — cards previewed with ServerSideRender; text and
 * settings edited in the sidebar.
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
	const {
		showHeading,
		eyebrow,
		title,
		count,
		showCta,
		ctaText,
		ctaUrl,
		paginate,
	} = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Heading', 'dlnorrisbooks')}>
					<ToggleControl
						label={__('Show heading', 'dlnorrisbooks')}
						help={__(
							'Hide to use this block as a plain post list.',
							'dlnorrisbooks'
						)}
						checked={showHeading}
						onChange={(value) =>
							setAttributes({ showHeading: value })
						}
						__nextHasNoMarginBottom
					/>
					{showHeading && (
						<>
							<TextControl
								label={__('Eyebrow', 'dlnorrisbooks')}
								value={eyebrow}
								onChange={(value) =>
									setAttributes({ eyebrow: value })
								}
								__nextHasNoMarginBottom
								__next40pxDefaultSize
							/>
							<TextControl
								label={__('Title', 'dlnorrisbooks')}
								value={title}
								onChange={(value) =>
									setAttributes({ title: value })
								}
								__nextHasNoMarginBottom
								__next40pxDefaultSize
							/>
						</>
					)}
				</PanelBody>
				<PanelBody title={__('Posts', 'dlnorrisbooks')}>
					<RangeControl
						label={
							paginate
								? __('Posts per page', 'dlnorrisbooks')
								: __('Number of posts', 'dlnorrisbooks')
						}
						value={count}
						onChange={(value) => setAttributes({ count: value })}
						min={1}
						max={12}
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<ToggleControl
						label={__('Enable pagination', 'dlnorrisbooks')}
						help={__(
							'Page through every post. Best on a dedicated blog page.',
							'dlnorrisbooks'
						)}
						checked={paginate}
						onChange={(value) => setAttributes({ paginate: value })}
						__nextHasNoMarginBottom
					/>
				</PanelBody>
				<PanelBody title={__('Archive link', 'dlnorrisbooks')}>
					<ToggleControl
						label={__('Show archive link', 'dlnorrisbooks')}
						checked={showCta}
						onChange={(value) => setAttributes({ showCta: value })}
						__nextHasNoMarginBottom
					/>
					{showCta && (
						<>
							<TextControl
								label={__('Link text', 'dlnorrisbooks')}
								value={ctaText}
								onChange={(value) =>
									setAttributes({ ctaText: value })
								}
								__nextHasNoMarginBottom
								__next40pxDefaultSize
							/>
							<TextControl
								label={__('Link URL', 'dlnorrisbooks')}
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
					block="dlnorrisbooks/recent-stories"
					attributes={attributes}
				/>
			</div>
		</>
	);
}
