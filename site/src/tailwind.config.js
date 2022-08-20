/** @type {import('tailwindcss').Config} */
const colors = require("tailwindcss/colors");

module.exports = {
  content: ["./resources/views/**/*.{php,html,js}"],
  darkMode: "class",
  theme: {
    fontFamily: {
      sans: ["Graphik", "sans-serif"],
      serif: ["Merriweather", "serif"],
    },
    container: {
      center: true,
      padding: {
        DEFAULT: "1rem",
        sm: "2rem",
        lg: "4rem",
        xl: "5rem",
        "2xl": "6rem",
      },
    },
    extend: {
      listStyleType: {
        lowerroman: 'lower-roman',
      },
      colors: {
        transparent: "transparent",
        current: "currentColor",
        navbar: colors.gray,
        anchor: colors.blue,
        muted: colors.slate,
        background: colors.zinc,
        foreground: colors.gray,
        primary: colors.teal,
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/line-clamp'),
  ],
};
