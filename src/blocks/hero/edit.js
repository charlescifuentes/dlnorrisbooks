/**
 * Editor interface for the Hero block.
 *
 * Mirrors the server-rendered markup so the editor preview matches the front
 * end. The default portrait is loaded from the theme's bundled assets via the
 * theme URI exposed on `window.dlnorrisbooksTheme`.
 */

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
} from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const {
		eyebrow,
		heading,
		subtitle,
		ctaText,
		ctaUrl,
		portraitId,
		portraitUrl,
		portraitAlt,
	} = attributes;

	const themeUri =
		(window.dlnorrisbooksTheme && window.dlnorrisbooksTheme.uri) || '';
	const heroAsset = (file) => `${themeUri}/assets/images/hero/${file}`;
	const portrait = portraitUrl || heroAsset('portrait.webp');

	const blockProps = useBlockProps({ className: 'hero not-prose' });

	return (
		<>
			<InspectorControls>
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
				<PanelBody title={__('Portrait', 'dlnorrisbooks')}>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={(media) =>
								setAttributes({
									portraitId: media.id,
									portraitUrl: media.url,
									portraitAlt: media.alt || '',
								})
							}
							allowedTypes={['image']}
							value={portraitId}
							render={({ open }) => (
								<Button variant="secondary" onClick={open}>
									{portraitUrl
										? __(
												'Replace portrait',
												'dlnorrisbooks'
											)
										: __(
												'Select portrait',
												'dlnorrisbooks'
											)}
								</Button>
							)}
						/>
					</MediaUploadCheck>
					{portraitUrl && (
						<Button
							variant="link"
							isDestructive
							onClick={() =>
								setAttributes({
									portraitId: 0,
									portraitUrl: '',
									portraitAlt: '',
								})
							}
						>
							{__('Use default portrait', 'dlnorrisbooks')}
						</Button>
					)}
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="hero__inner">
					<div className="hero__content">
						<RichText
							tagName="p"
							className="hero__eyebrow"
							value={eyebrow}
							onChange={(value) =>
								setAttributes({ eyebrow: value })
							}
							allowedFormats={[]}
							placeholder={__('Eyebrow', 'dlnorrisbooks')}
						/>
						<RichText
							tagName="h1"
							className="hero__heading"
							value={heading}
							onChange={(value) =>
								setAttributes({ heading: value })
							}
							allowedFormats={[]}
							placeholder={__('Heading', 'dlnorrisbooks')}
						/>
						<RichText
							tagName="p"
							className="hero__subtitle"
							value={subtitle}
							onChange={(value) =>
								setAttributes({ subtitle: value })
							}
							allowedFormats={['core/italic', 'core/bold']}
							placeholder={__('Subtitle', 'dlnorrisbooks')}
						/>
						<a
							className="hero__cta btn-pill"
							href={ctaUrl}
							onClick={(event) => event.preventDefault()}
						>
							{ctaText || __('Start Reading', 'dlnorrisbooks')}
						</a>
					</div>

					<div className="hero__media">
						<img
							className="hero__portrait"
							src={portrait}
							alt={portraitAlt}
						/>
					</div>
				</div>
			</div>
		</>
	);
}
