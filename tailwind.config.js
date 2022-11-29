module.exports = {
	purge: {
		enabled: true,
		content: [
			'./resources/**/*.php',
			'./resources/**/*.js',
			'./resources/**/*.html'
		],
		options: {
			safelist: []
		}
	},
	theme: {
		extend: {
			typography: {
				'current': {
					css: {
						color: 'inherit'
					}
				}
			},
			colors: {
				gray: {
					50: '#E7E7E8',
					100: '#CFD0D2',
					200: '#B7B9BC',
					300: '#9FA2A5',
					400: '#878B8F',
					500: '#6F7479',
					600: '#575D62',
					700: '#3F464C',
					800: '#272F36',
					900: '#101820',
				}
			}
		},
	},
	variants: {},
	plugins: [
		require('@tailwindcss/typography'),
		require('@tailwindcss/line-clamp'),
		require('@tailwindcss/aspect-ratio'),
		require('@tailwindcss/forms')
	]
}
