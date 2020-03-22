const webpack = require('webpack');
const mix = require('laravel-mix');
const dotenv = require('dotenv');

const envDockerConfig = dotenv.config({path: __dirname+'/../../../.env'}).parsed;
const envBackendConfig = dotenv.config({path: __dirname+'/../../.env'}).parsed;

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

Mix.listen('configReady', config => {
  const scssRule = config.module.rules.find(r => r.test.toString() === /\.scss$/.toString());
  const scssOptions = scssRule.loaders.find(l => l.loader === 'sass-loader').options;
  scssOptions.prependData = '@import "./resources/sass/app.scss";';

  const sassRule = config.module.rules.find(r => r.test.toString() === /\.sass$/.toString());
  const sassOptions = sassRule.loaders.find(l => l.loader === 'sass-loader').options;
  sassOptions.prependData = '@import "./resources/sass/app.scss";';
})

mix
  .setPublicPath('../../public/alfred-assets/')
  .webpackConfig({
    resolve: {
      alias: {
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
        "process.env.ALFRED_API_BASE_URL": JSON.stringify('/api/v1')
      }),
    ]
  })
  .setResourceRoot('alfred-assets/')
  .js('resources/js/app.js', 'js')
  .extract()
  .sass('resources/sass/app.scss', 'css/app.css', {
    implementation: require('sass'),
    sassOptions: {
      fiber: require('fibers'),
      indentedSyntax: true // optional
    },
  })
  .browserSync({
    proxy: envDockerConfig && envDockerConfig.PROJECT_NAME ? `${envDockerConfig.PROJECT_NAME}_backend:${envDockerConfig.BACKEND_PORT}` : envBackendConfig.APP_URL,
    open: false
  })
  .options({
    watchOptions: {
      ignored: /node_modules/
    }
  });