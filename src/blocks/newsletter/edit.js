/**
 * Editor interface for the Newsletter Band block.
 *
 * Text is edited inline; the subscription form is a shortcode set in the
 * sidebar (rendered server-side). The editor shows a static form preview.
 */

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, TextareaControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const { eyebrow, heading, description, formShortcode } = attributes;
	const blockProps = useBlockProps({ className: 'newsletter not-prose' });

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Subscription form', 'dlnorrisbooks')}>
					<TextareaControl
						label={__('Form shortcode', 'dlnorrisbooks')}
						help={__(
							'Shortcode for the signup form, e.g. [jetpack_subscription_form]. Rendered on the front end.',
							'dlnorrisbooks'
						)}
						value={formShortcode}
						onChange={(value) =>
							setAttributes({ formShortcode: value })
						}
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="newsletter__inner">
					<RichText
						tagName="span"
						className="newsletter__eyebrow"
						value={eyebrow}
						onChange={(value) => setAttributes({ eyebrow: value })}
						allowedFormats={[]}
						placeholder={__('Eyebrow', 'dlnorrisbooks')}
					/>
					<RichText
						tagName="h2"
						className="newsletter__heading"
						value={heading}
						onChange={(value) => setAttributes({ heading: value })}
						allowedFormats={[]}
						placeholder={__('Heading', 'dlnorrisbooks')}
					/>
					<RichText
						tagName="p"
						className="newsletter__description"
						value={description}
						onChange={(value) =>
							setAttributes({ description: value })
						}
						allowedFormats={[]}
						placeholder={__('Description', 'dlnorrisbooks')}
					/>
					<div className="newsletter__form">
						<form
							className="newsletter__fallback"
							onSubmit={(event) => event.preventDefault()}
						>
							<input
								type="email"
								className="newsletter__input"
								placeholder={__(
									'Your email address…',
									'dlnorrisbooks'
								)}
								disabled
							/>
							<button
								type="submit"
								className="newsletter__submit"
								disabled
							>
								{__('Subscribe', 'dlnorrisbooks')}
							</button>
						</form>
					</div>
				</div>
			</div>
		</>
	);
}
