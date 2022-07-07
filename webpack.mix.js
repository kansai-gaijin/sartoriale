let mix = require("laravel-mix");

mix.postCss(`src/app.css`, `build/css/style.css`, [require("tailwindcss")]);
mix.js(`src/app.js`, `build/js/app.js`);
mix.browserSync({
  proxy: "http://kg-srt.com/",
  files: [`./**/*.php`, `./**/*.js`, `./**/*.css`],
});
