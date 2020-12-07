module.exports = {
	purge: [
		'./resources/**/*.php',
		'./resources/**/*.js'
	],
	theme: {
		extend: {
			//
		},
	},
	variants: {},
	plugins: [
		require('@tailwindcss/typography')
	]
}
