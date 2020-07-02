const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('src/Resources/assets/prod').mergeManifest();

mix.js(__dirname + '/src/Resources/assets/js/app.js', 'js/wincashpay.js')
    .sass( __dirname + '/src/Resources/assets/sass/app.scss', 'css/wincashpay.css');

mix.js(__dirname + '/src/Resources/assets/js/wincashpay.transaction.js', 'js/wincashpay.transaction.js')
    .js(__dirname + '/src/Resources/assets/js/wincashpay.transaction.vue.js', 'js/wincashpay.transaction.vue.js')
    .sass( __dirname + '/src/Resources/assets/sass/wincashpay.transaction.scss', 'css/wincashpay.transaction.css');

if (mix.inProduction()) {
    mix.version();
}
