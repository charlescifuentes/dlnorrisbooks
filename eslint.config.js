import { fileURLToPath } from 'node:url';
import globals from 'globals';
import js from '@eslint/js';
import prettier from 'eslint-config-prettier';

import phpTemplates from 'eslint-plugin-php-templates';
import angularTemplateParser from '@angular-eslint/template-parser';
import tailwindcss from 'eslint-plugin-tailwindcss';

const tailwindRulesConfig = tailwindcss.configs['flat/recommended'].find(
	(config) => config.name === 'tailwindcss:rules'
);
const tailwindRules = tailwindRulesConfig?.rules || {};

export default [
	{
		// Block sources (src/blocks) are JSX validated by the @wordpress/scripts
		// webpack build and formatted by Prettier; the repo's espree-based
		// config is not JSX-aware, so it skips them. theme/blocks is generated.
		ignores: [
			'**/*.min.js',
			'**/vendor/',
			'src/blocks/**',
			'theme/blocks/**',
		],
	},
	{
		files: ['**/*.js'],
		languageOptions: {
			ecmaVersion: 'latest',
		},
		rules: {
			...js.configs.recommended.rules,
			...prettier.rules,
		},
	},
	{
		files: ['javascript/**/*.js'],
		languageOptions: {
			globals: {
				...globals.browser,
				wp: 'readonly',
			},
		},
	},
	{
		files: ['node_scripts/*.js', 'eslint.config.js', 'postcss.config.js'],
		languageOptions: {
			globals: {
				...globals.node,
			},
		},
	},
	{
		files: ['**/*.php'],
		languageOptions: {
			parser: phpTemplates.suppressParserErrors(angularTemplateParser),
		},
		plugins: {
			'php-templates': phpTemplates,
			tailwindcss,
		},
		processor: 'php-templates/strip-php',
		rules: {
			...tailwindRules,
			'tailwindcss/no-custom-classname': 'off',
		},
		settings: {
			tailwindcss: {
				config: fileURLToPath(
					new URL('./tailwind-intellisense.css', import.meta.url)
				),
			},
		},
	},
];
