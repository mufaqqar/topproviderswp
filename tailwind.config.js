module.exports = {
  content: [
    './**/*.php',
    './**/*.html',
    './src/**/*.{js,jsx,ts,tsx}',
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          green: '#96B93A',
          'green-hover': '#7a9a2e',
          purple: '#6041BB',
          'purple-hover': '#4f35a0',
          blue: '#044FC3',
          dark: '#071F37',
          gray: '#464646',
          'light-gray': '#6A6A93',
          'soft-bg': '#E7E2FE',
          'warm-bg': '#FBF1E2',
          'peach-bg': '#FFDBCE',
          'mint-bg': '#E8EBE4',
          blueprint: '#F3FAFF',
        },
      },
      fontFamily: {
        roboto: ['Roboto', 'sans-serif'],
        manrope: ['Manrope', 'sans-serif'],
      },
      boxShadow: {
        soft: '0 15px 15px rgba(0,0,0,0.05)',
        card: '0 4px 6px rgba(0,0,0,0.1)',
        feature: '0 15px 15px rgba(0,0,0,0.05)',
      },
      borderRadius: {
        '4xl': '90px',
      },
      maxWidth: {
        'content': '1110px',
        'hero': '850px',
        'form': '712px',
      },
    },
  },
  plugins: [],
}
