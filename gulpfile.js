var gulp        = require('gulp');
var sass        = require('gulp-sass');
 
// Sass task, will run when any SCSS files change & BrowserSync
// will auto-update browsers
gulp.task('sass', function () {
    return gulp.src('sass/*.scss')
        .pipe(sass())
        .pipe(gulp.dest('./'))
});
 
// Default task to be run with `gulp`
gulp.task('default', ['sass'], function () {
    gulp.watch("sass/**/*.scss", ['sass']);
});