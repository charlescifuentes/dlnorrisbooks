/**
 * Editor interface for the Contact block.
 *
 * The card is an InnerBlocks slot so the form can be a Jetpack Form block,
 * which owns submission, spam filtering and storage — the theme only skins it.
 * Jetpack is not present on every install (it is not active locally), so the
 * starting template is only seeded when the form block is actually registered.
 *
 * The sidebar detail groups are edited inline and can be added or removed from
 * the inspector.
 */

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	useInnerBlocksProps,
	RichText,
	InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as blocksStore } from '@wordpress/blocks';

const JETPACK_FORM = 'jetpack/contact-form';

const EMPTY_GROUP = { label: '', name: '', body: '' };

export default function Edit({ attributes, setAttributes }) {
	const { details } = attributes;

	const hasJetpackForm = useSelect(
		(select) => !!select(blocksStore).getBlockType(JETPACK_FORM),
		[]
	);

	const blockProps = useBlockProps({ className: 'contact not-prose' });
	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'contact__form' },
		{ template: hasJetpackForm ? [[JETPACK_FORM]] : undefined }
	);

	const updateGroup = (index, patch) =>
		setAttributes({
			details: details.map((group, i) =>
				i === index ? { ...group, ...patch } : group
			),
		});

	const removeGroup = (index) =>
		setAttributes({ details: details.filter((_, i) => i !== index) });

	const addGroup = () =>
		setAttributes({ details: [...details, { ...EMPTY_GROUP }] });

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Contact details', 'dlnorrisbooks')}>
					{details.map((group, index) => (
						<Button
							key={index}
							variant="link"
							isDestructive
							onClick={() => removeGroup(index)}
						>
							{
								/* translators: %s: contact detail group label. */
								group.label
									? __('Remove', 'dlnorrisbooks') +
										`: ${group.label}`
									: __('Remove group', 'dlnorrisbooks')
							}
						</Button>
					))}
					<Button variant="secondary" onClick={addGroup}>
						{__('Add detail group', 'dlnorrisbooks')}
					</Button>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="contact__inner">
					<div {...innerBlocksProps} />

					{details.length > 0 && (
						<aside className="contact__details">
							{details.map((group, index) => (
								<div className="contact-detail" key={index}>
									<RichText
										tagName="p"
										className="contact-detail__label"
										value={group.label}
										onChange={(label) =>
											updateGroup(index, { label })
										}
										allowedFormats={[]}
										placeholder={__(
											'Label',
											'dlnorrisbooks'
										)}
									/>
									<div className="contact-detail__group">
										<RichText
											tagName="p"
											className="contact-detail__name"
											value={group.name}
											onChange={(name) =>
												updateGroup(index, { name })
											}
											allowedFormats={[]}
											placeholder={__(
												'Name (optional)',
												'dlnorrisbooks'
											)}
										/>
										<RichText
											tagName="p"
											className="contact-detail__body"
											value={group.body}
											onChange={(body) =>
												updateGroup(index, { body })
											}
											allowedFormats={[
												'core/italic',
												'core/link',
											]}
											placeholder={__(
												'Details…',
												'dlnorrisbooks'
											)}
										/>
									</div>
								</div>
							))}
						</aside>
					)}
				</div>
			</div>
		</>
	);
}
