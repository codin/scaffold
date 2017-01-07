var gulp        = require('gulp');
var boilerplate = require('gulp-boilerplate')(gulp);

// Styles task
gulp.task('styles', boilerplate.styles({
    src: 'src/styles/**/*.scss',
    public: 'public/assets/css',
}));

// Scripts task
gulp.task('scripts', boilerplate.scripts({
    src: 'src/js/**/*.js',
    filename: 'main.min.js',
    public: 'public/assets/js',
}));

// Images task
gulp.task('images', boilerplate.images({
    src: 'src/img/**/*',
    public: 'public/assets/img',
}));

// Clean task
gulp.task('clean', boilerplate.clean({
    paths: [
        'public/assets/css',
        'public/assets/js',
        'public/assets/img'
    ],
}));

// Clear task
gulp.task('clear', boilerplate.clear());

// Watch task
gulp.task('watch', boilerplate.watch({
    tasks: [
        {path: 'src/styles/**/*.scss', tasks: ['styles']},
        {path: 'src/js/**/*.js', tasks: ['scripts']},
        {path: 'src/img/**/*', tasks: ['images']}
    ]
}));

// Default task
gulp.task('default', boilerplate.standard());

// Production task
gulp.task('production', ['clean'], boilerplate.production());