Alfred Development - installation and process:
1. Install Laravel [or clone alfred-development-platform.git --> SOON]
2. Create folder Alfred (in the project root) and specific folder structure, see below:
./cms-backend/
    Alfred/
        Core/ (clone the alfred-core.git repository here) [submodule in alfred-development-platform.git SOON]
        Modules/
            (here create folders for specific alfred modules if needed)
            Shop/ (clone the alfred-shop.git repository here)

            alfred-spa-config.js (empty file for now)
3. Edit composer.json in the project root folder and attach the alfred-core and other modules (optionally).
4. Run `php artisan alfred:install-dev` (under the hood it will install Alfred SPA [`npm install` and `npm run prod`] from cms-backend/Alfred/Core and will compile assets to the ./cms-backend/public/alfred-assets)


Project development using Alfred (for end-developers who will use Alfred to create some project):
1. Install blank Laravel
2. Run `composer require alfred-core`
3. Run `php artisan alfred:install`. Under the hood it will create following folder structure:
./cms-backend/
    Alfred
        Core/
            config/
                theme.php
            resources/
                js/
                    field-types
                        some-extra-field-type-for-this-project/
                            index.js
                        index.js
                    app.js [import app.js z vendora]
                views
                    ...
            webpack.mix.js [symlink to ../../vendor/studiosidekicks/alfred-core/webpack.mix.js]
            package.json [symlink to ../../vendor/studiosidekicks/alfred-core/package.json]
        Modules
            alfred-spa-config.js


Once the folder structure is created, it will also run `npm install` and `npm run prod` within the ./cms-backend/Alfred/core location - it will compile assets to the ./cms-backend/public/alfred-assets