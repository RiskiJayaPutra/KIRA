/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'background': '#fffffe',
        'headline': '#272343',
        'paragraph': '#2d334a',
        'button-fomo': '#ffd803',
        'button-text': '#272343',
        'stroke': '#272343',
        'secondary': '#e3f6f5',
        'tertiary': '#bae8e8',
      },
      fontFamily: {
        // We will inject a premium font like modern geometric sans when installing font.
        sans: ['Inter', 'sans-serif'], 
      }
    },
  },
  plugins: [],
}
