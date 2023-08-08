/** @type {import('tailwindcss').Config} */
const colors = require("tailwindcss/colors");

module.exports = {
  content: ["./resources/views/**/*.php", "./resources/ts/**/*.ts"],
  darkMode: "class",
  theme: {
    fontFamily: {
      // source (StackOverflow): https://github.com/StackExchange/Stacks/blob/develop/lib/css/exports/constants-type.less
      sans: [
        "-apple-system",
        "BlinkMacSystemFont", // San Francisco on macOS and iOS
        "Segoe UI Adjusted",
        "Segoe UI", // Windows
        "Liberation Sans", // Linux
        "sans-serif", // The final fallback for rendering in sans-serif
      ],
      serif: ["Georgia", "Cambria", "Times New Roman", "Times", "serif"],
      mono: [
        "ui-monospace", // San Francisco Mono on macOS and iOS
        "Cascadia Mono",
        "Segoe UI Mono", // Newer Windows monospace fonts that are optionally installed. Most likely to be rendered in Consolas
        "Liberation Mono", // Linux
        "Menlo",
        "Monaco",
        "Consolas", // A few sensible system font choices
        "monospace", // The final fallback for rendering in monospace.
      ],
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
        lowerroman: "lower-roman",
      },
      colors: {
        transparent: "transparent",
        current: "currentColor",
        navbar: colors.gray,
        muted: colors.slate,
        info: colors.indigo,
        danger: colors.red,
        background: colors.zinc,
        foreground: colors.gray,
        primary: colors.teal,
        anchor: colors.teal,
      },
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
