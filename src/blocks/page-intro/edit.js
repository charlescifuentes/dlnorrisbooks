/**
 * Editor interface for the Page Intro block.
 *
 * Mirrors the server-rendered markup; every field is edited inline. The intro
 * paragraph is optional — leave it empty for a heading on its own.
 */

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';

const INTRO_STYLE_OPTIONS = [
	{ label: __('Paragraph', 'dlnorrisbooks'), value: 'paragraph' },
	{ label: __('Pull quote', 'dlnorrisbooks'), value: 'quote' },
];

const ORNAMENT_PATH =
	'M1 20V18H7V14H5C3.61667 14 2.4375 13.5125 1.4625 12.5375C0.4875 11.5625 0 10.3833 0 9C0 8 0.275 7.07917 0.825 6.2375C1.375 5.39583 2.11667 4.78333 3.05 4.4C3.2 3.15 3.74583 2.10417 4.6875 1.2625C5.62917 0.420833 6.73333 0 8 0C9.26667 0 10.3708 0.420833 11.3125 1.2625C12.2542 2.10417 12.8 3.15 12.95 4.4C13.8833 4.78333 14.625 5.39583 15.175 6.2375C15.725 7.07917 16 8 16 9C16 10.3833 15.5125 11.5625 14.5375 12.5375C13.5625 13.5125 12.3833 14 11 14H9V18H15V20H1V20M5 12H11C11.8333 12 12.5417 11.7083 13.125 11.125C13.7083 10.5417 14 9.83333 14 9C14 8.4 13.8292 7.85 13.4875 7.35C13.1458 6.85 12.7 6.48333 12.15 6.25L11.1 5.8L10.95 4.65C10.85 3.9 10.5208 3.27083 9.9625 2.7625C9.40417 2.25417 8.75 2 8 2C7.25 2 6.59583 2.25417 6.0375 2.7625C5.47917 3.27083 5.15 3.9 5.05 4.65L4.9 5.8L3.85 6.25C3.3 6.48333 2.85417 6.85 2.5125 7.35C2.17083 7.85 2 8.4 2 9C2 9.83333 2.29167 10.5417 2.875 11.125C3.45833 11.7083 4.16667 12 5 12V12Z';

export default function Edit({ attributes, setAttributes }) {
	const { eyebrow, title, intro, introStyle } = attributes;
	const blockProps = useBlockProps({ className: 'page-intro not-prose' });

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Page Intro', 'dlnorrisbooks')}>
					<SelectControl
						label={__('Intro style', 'dlnorrisbooks')}
						value={introStyle}
						options={INTRO_STYLE_OPTIONS}
						help={__(
							'Paragraph reads as body copy; pull quote is the large centred italic.',
							'dlnorrisbooks'
						)}
						onChange={(value) =>
							setAttributes({ introStyle: value })
						}
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="page-intro__inner">
					<RichText
						tagName="p"
						className="page-intro__eyebrow"
						value={eyebrow}
						onChange={(value) => setAttributes({ eyebrow: value })}
						allowedFormats={[]}
						placeholder={__('Eyebrow', 'dlnorrisbooks')}
					/>
					<RichText
						tagName="h2"
						className="page-intro__title"
						value={title}
						onChange={(value) => setAttributes({ title: value })}
						allowedFormats={['core/italic']}
						placeholder={__('Page title', 'dlnorrisbooks')}
					/>
					<div className="page-intro__flourish" aria-hidden="true">
						<span className="page-intro__rule" />
						<svg
							className="page-intro__mark"
							viewBox="0 0 16 20"
							fill="currentColor"
							xmlns="http://www.w3.org/2000/svg"
						>
							<path d={ORNAMENT_PATH} />
						</svg>
						<span className="page-intro__rule" />
					</div>
					<RichText
						tagName="p"
						className={`page-intro__text page-intro__text--${introStyle}`}
						value={intro}
						onChange={(value) => setAttributes({ intro: value })}
						allowedFormats={[
							'core/italic',
							'core/bold',
							'core/link',
						]}
						placeholder={__(
							'Intro paragraph (optional)…',
							'dlnorrisbooks'
						)}
					/>
				</div>
			</div>
		</>
	);
}
