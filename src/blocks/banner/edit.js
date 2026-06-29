/**
 * Editor interface for the Page Banner block.
 *
 * Mirrors the server-rendered markup so the editor preview matches the front
 * end. The label is edited inline; the background image and its focal point are
 * set from the inspector. The default image is loaded from the theme's bundled
 * assets via the theme URI exposed on `window.dlnorrisbooksTheme`.
 */

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
} from '@wordpress/block-editor';
import { PanelBody, Button, FocalPointPicker } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const { label, imageId, imageUrl, imageAlt, focalPoint } = attributes;

	const themeUri =
		(window.dlnorrisbooksTheme && window.dlnorrisbooksTheme.uri) || '';
	const defaultImage = `${themeUri}/assets/images/banner/author-banner.jpg`;
	const image = imageUrl || defaultImage;

	const objectPosition = `${(focalPoint?.x ?? 0.5) * 100}% ${
		(focalPoint?.y ?? 0.5) * 100
	}%`;

	const blockProps = useBlockProps({ className: 'banner not-prose' });

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Background image', 'dlnorrisbooks')}>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={(media) =>
								setAttributes({
									imageId: media.id,
									imageUrl: media.url,
									imageAlt: media.alt || '',
								})
							}
							allowedTypes={['image']}
							value={imageId}
							render={({ open }) => (
								<Button variant="secondary" onClick={open}>
									{imageUrl
										? __('Replace image', 'dlnorrisbooks')
										: __('Select image', 'dlnorrisbooks')}
								</Button>
							)}
						/>
					</MediaUploadCheck>
					{imageUrl && (
						<Button
							variant="link"
							isDestructive
							onClick={() =>
								setAttributes({
									imageId: 0,
									imageUrl: '',
									imageAlt: '',
								})
							}
						>
							{__('Use default image', 'dlnorrisbooks')}
						</Button>
					)}
					<FocalPointPicker
						label={__('Focal point', 'dlnorrisbooks')}
						url={image}
						value={focalPoint}
						onChange={(value) =>
							setAttributes({ focalPoint: value })
						}
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="banner__media">
					<img
						className="banner__image"
						src={image}
						alt={imageAlt}
						style={{ objectPosition }}
					/>
					<span className="banner__overlay" aria-hidden="true" />
				</div>
				<div className="banner__inner">
					<div className="banner__card">
						<RichText
							tagName="p"
							className="banner__label"
							value={label}
							onChange={(value) =>
								setAttributes({ label: value })
							}
							allowedFormats={['core/italic']}
							placeholder={__('Banner label', 'dlnorrisbooks')}
						/>
					</div>
				</div>
			</div>
		</>
	);
}
