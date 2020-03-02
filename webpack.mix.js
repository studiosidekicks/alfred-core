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
    /*module: {
      rules: [
        {
          test: /\.s(c|a)ss$/,
          use: [
            'vue-style-loader',
            'css-loader',
            {
              loader: 'sass-loader',
              // Requires sass-loader@^7.0.0
              options: {
                implementation: require('sass'),
                fiber: require('fibers'),
                indentedSyntax: true // optional
              },
              // Requires sass-loader@^8.0.0
              options: {
                implementation: require('sass'),
                sassOptions: {
                  fiber: require('fibers'),
                  indentedSyntax: true // optional
                },
              },
            },
          ],
        }
      ]
    },*/
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
        "process.env.ALFRED_SPA_ROOT": JSON.stringify(alfredSpaRoot),
        "process.env.ALFRED_API_BASE_URL": JSON.stringify(alfredAPIBaseUrl)
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
    proxy: alfredSpaBaseUrl,
    open: false
  })
  .options({
    watchOptions: {
      ignored: /node_modules/
    }
  });
