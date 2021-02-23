module.exports = {
	purge: {
		enabled: true,
		content: [
			'./resources/**/*.php',
			'./resources/**/*.js'
		],
		safelist: []
	},
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
