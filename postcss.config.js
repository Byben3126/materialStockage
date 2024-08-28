/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors')
export default {
  content: [
    "./index.html","./src/**/*.{js,ts,jsx,tsx}", 
    "./node_modules/flowbite/**/*.js", 
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./templates/*.html.twig"
  ],
  theme: {
    colors: {
        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"},
        // you can either spread `colors` to apply all the colors
        ...colors,
        // or add them one by one and name whatever you want
        amber: colors.amber,
        emerald: colors.emerald,
    },
    extend: {},
  },
  plugins: [],
}

