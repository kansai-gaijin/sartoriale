module.exports = {
  content: [
    "./resources/**/*.php",
    "./resources/templates/**/*.php",
    "./resources/templates/**/*.tpl.php",
    "./src/**/*.{css}",
    "./resources/templates/shortcodes/**/*.php",
    "./resources/templates/shortcodes/**/**/*.php",
  ],
  theme: {
    extend: {
      screens: {
        tblt: "993px",
      },
      fontFamily: {
        sans: ["Noto Serif JP", "serif"],
        eng: ["Cinzel Decorative", "cursive"],
      },
    },
  },
  plugins: [require("@tailwindcss/line-clamp")],
};
