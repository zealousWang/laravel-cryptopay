const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/wincashpay.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/wincashpay.css');

mix.js(__dirname + '/Resources/assets/js/wincashpay.transaction.js', 'js/wincashpay.transaction.js')
    .js(__dirname + '/Resources/assets/js/wincashpay.transaction.vue.js', 'js/wincashpay.transaction.vue.js')
    .sass( __dirname + '/Resources/assets/sass/wincashpay.transaction.scss', 'css/wincashpay.transaction.css');

if (mix.inProduction()) {
    mix.version();
}
