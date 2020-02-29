const webpack = require('webpack');
const mix = require('laravel-mix');
const alfredSpaRoot = process.cwd();

/*
|--------------------------------------------------------------------------
| Mix Asset Management
|--------------------------------------------------------------------------
|
| Mix provides a clean, fluent API for defining some Webpack build steps
| for your Laravel application. By default, we are compiling the Sass
| file for the application as well as bundling up all the JS files.
|
*/

mix
  .setPublicPath('../../public/alfred-assets/')
  .webpackConfig({
    resolve: {
      alias: {
        Hehe: path.resolve(__dirname, './resources/'),
        AlfredSpa: process.cwd()
      }
    },
    output: {
      publicPath: '/alfred-assets/',
    },
    plugins: [
      new webpack.DefinePlugin({ "process.env.ALFRED_SPA_ROOT": JSON.stringify(alfredSpaRoot) }),
    ]
  })
  .setResourceRoot('alfred-assets/')
  .js('resources/js/main.js', 'js')
  .extract()
  /*.sass('resources/sass/app.scss', 'public/css')*/
  .browserSync('http://alfred2-project.local/cms')
  .options({
    watchOptions: {
      ignored: /node_modules/
    },
    processCssUrls: false
  });

