const purgecss = require('@fullhuman/postcss-purgecss')({
    content: [
      './src/**/*.js',
      './src/**/*.jsx',
      './src/**/*.html',
      './src/**/*.php',
    ],
    // Specify other PurgeCSS options here
  });
  
  module.exports = {
    plugins: [
    //   require('tailwindcss'),
      purgecss,
      // Other PostCSS plugins
    ]
  };