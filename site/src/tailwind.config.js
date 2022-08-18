/** @type {import('tailwindcss').Config} */
const colors = require("tailwindcss/colors");

module.exports = {
  content: ["./resources/**/*.{php,html,js}"],
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
      colors: {
        transparent: "transparent",
        current: "currentColor",
        background: colors.neutral,
        foreground: colors.gray,
      },
    },
  },
  plugins: [],
};
