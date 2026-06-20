/**
 * Editor interface for the Author block.
 *
 * Mirrors the server-rendered markup; eyebrow, heading and bio are edited
 * inline, the photo + link are managed in the sidebar.
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
		bio,
		linkText,
		linkUrl,
		imageId,
		imageUrl,
		imageAlt,
	} = attributes;

	const themeUri =
		(window.dlnorrisbooksTheme && window.dlnorrisbooksTheme.uri) || '';
	const image =
		imageUrl || `${themeUri}/assets/images/author-placeholder.webp`;

	const blockProps = useBlockProps({ className: 'author not-prose' });

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Link', 'dlnorrisbooks')}>
					<TextControl
						label={__('Link text', 'dlnorrisbooks')}
						value={linkText}
						onChange={(value) => setAttributes({ linkText: value })}
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<TextControl
						label={__('Link URL', 'dlnorrisbooks')}
						value={linkUrl}
						onChange={(value) => setAttributes({ linkUrl: value })}
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
				</PanelBody>
				<PanelBody title={__('Photo', 'dlnorrisbooks')}>
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
										? __('Replace photo', 'dlnorrisbooks')
										: __('Select photo', 'dlnorrisbooks')}
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
							{__('Use default photo', 'dlnorrisbooks')}
						</Button>
					)}
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<span
					className="author__wave author__wave--top"
					aria-hidden="true"
				/>
				<div className="author__inner">
					<div className="author__media">
						<span className="author__decor" aria-hidden="true" />
						<div className="author__frame">
							<img
								className="author__image"
								src={image}
								alt={imageAlt}
							/>
						</div>
					</div>

					<div className="author__content">
						<RichText
							tagName="span"
							className="author__eyebrow"
							value={eyebrow}
							onChange={(value) =>
								setAttributes({ eyebrow: value })
							}
							allowedFormats={[]}
							placeholder={__('Eyebrow', 'dlnorrisbooks')}
						/>
						<RichText
							tagName="h2"
							className="author__heading"
							value={heading}
							onChange={(value) =>
								setAttributes({ heading: value })
							}
							allowedFormats={['core/bold']}
							placeholder={__('Author heading…', 'dlnorrisbooks')}
						/>
						<RichText
							tagName="p"
							className="author__bio"
							value={bio}
							onChange={(value) => setAttributes({ bio: value })}
							allowedFormats={['core/italic', 'core/bold']}
							placeholder={__('Author bio…', 'dlnorrisbooks')}
						/>
						<a
							className="author__link"
							href={linkUrl}
							onClick={(event) => event.preventDefault()}
						>
							{linkText ||
								__('Read Full Biography', 'dlnorrisbooks')}
							<svg
								className="author__link-icon"
								width="12"
								height="12"
								viewBox="0 0 24 24"
								fill="none"
								aria-hidden="true"
							>
								<path
									d="M5 12h14M13 6l6 6-6 6"
									stroke="currentColor"
									strokeWidth="1.75"
									strokeLinecap="round"
									strokeLinejoin="round"
								/>
							</svg>
						</a>
					</div>
				</div>
			</div>
		</>
	);
}
