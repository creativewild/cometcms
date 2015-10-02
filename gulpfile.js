var elixir = require('laravel-elixir');

elixir(function (mix) {
    mix
        .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap')
        .copy('node_modules/bootstrap-sass/assets/stylesheets', 'resources/assets/sass/admin/bootstrap')
        .copy('node_modules/chart.js/Chart.min.js', 'public/js/admin/lib')
        .sass(['admin/app-admin.scss'], 'public/css/admin/main.css')

        // Global admin dependencies
        .scripts([
            'jquery/dist/jquery.js',
            'moment/moment.js',
            'jquery-validation/dist/jquery.validate.js',
            'bootstrap-sass/assets/javascripts/bootstrap.js'
        ], 'public/js/admin/dependencies.js', 'node_modules')

        // Global admin scripts
        .scripts([
            'admin.js'
        ], 'public/js/admin/main.js')

        // Admin modules
        .browserify('matches.js', 'public/js/admin/modules/matches.js', 'resources/assets/js/modules')
        .browserify('games.js', 'public/js/admin/modules/games.js', 'resources/assets/js/modules')
        .browserify('teams.js', 'public/js/admin/modules/teams.js', 'resources/assets/js/modules')
        .browserify('dashboard.js', 'public/js/admin/modules/dashboard.js', 'resources/assets/js/modules');
});