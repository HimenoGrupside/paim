/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,scss,css,js,jsx,ts,tsx}",
    "./wordpress/themes/custom-theme/**/*.{php,css,js}",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  darkMode: 'class',//OS の設定に基づいてダークモードを適用したい場合は 'media' を指定
}

