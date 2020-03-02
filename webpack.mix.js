const webpack = require('webpack');
const mix = require('laravel-mix');
const dotenv = require('dotenv');
const alfredSpaRoot = process.cwd();

const envConfig = dotenv.config({path: __dirname+'/../../.env'}).parsed;
const alfredSpaBaseUrl = `${envConfig.APP_URL}/cms`;
const alfredAPIBaseUrl = `${envConfig.APP_URL}/api/v1`;
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
        AlfredSpa: process.cwd(),
        vue$: 'vue/dist/vue.esm.js',
        '@': path.join(__dirname, '/resources/js'),
      },
      extensions: [
        '.js',
        '.jsx'
      ],
      modules: [
        path.resolve(__dirname, 'node_modules/'),
        path.resolve(__dirname, 'resources/')
      ]
    },
    output: {
      publicPath: '/alfred-assets/',
    },
    plugins: [
      new webpack.DefinePlugin({
        "process.env.ALFRED_SPA_ROOT": JSON.stringify(alfredSpaRoot),
        "process.env.ALFRED_API_BASE_URL": JSON.stringify(alfredAPIBaseUrl)
      }),
    ]
  })
  .setResourceRoot('alfred-assets/')
  .js('resources/js/app.js', 'js')
  .extract()
  .sass('resources/sass/app.scss', 'css/app.css', {
    implementation: require('node-sass'),
  })
  .browserSync(alfredSpaBaseUrl)
  .options({
    watchOptions: {
      ignored: /node_modules/
    }
  });
