/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')

module.exports = {
  content: ["./resources/**/*.{php,html,js}"],
  darkMode: 'class',
  theme: {
    fontFamily: {
      sans: ['Graphik', 'sans-serif'],
      serif: ['Merriweather', 'serif'],
    },
    container: {
      padding: {
        center: true,
        DEFAULT: '1rem',
        sm: '2rem',
        lg: '4rem',
        xl: '5rem',
        '2xl': '6rem',
      },
    },
    extend: {
      colors: {
        transparent: 'transparent',
        current: 'currentColor',
        background: '#121212',
        background2: '#191919',
        background3: '#1e1e1e',
        foreground: '#e2e2e2',
        foreground2: '#a9a9a9',
        primary: '#a6dfa0',
        primary2: '#b3cfb0',
        primary3: '#99ef90',
        secondary: '#dfbca0',
        success: '#8cff80',
        danger: '#cf6679',
        warning: '#ffc15e',
        info: '#38aecc',
      },
    },
  },
  plugins: [],
}
