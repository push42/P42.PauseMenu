
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
  "./html/*.{html,js,php}",
  "./html/**/*.{html,js,php}",
  "./html/components/*.{html,js,php}",
  "./html/components/**.{html,js,php}",
  "./html/components/**/*.{html,js,php}",
],
theme: {
  extend: {
    backdropFilter: {
      'none': 'none',
      'blur': 'blur(10px)',
    },
    container: {
      center: true,
      padding: '1rem', // or whatever padding you prefer
      screens: {
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1536px',
        '3xl': '1696px', // your custom breakpoint
        '4xl': '2196px',
      },
  },
},
},
plugins: [
  require('tailwindcss-filters'),
],
};