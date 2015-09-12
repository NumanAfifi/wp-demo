var gulp = require('gulp'),
    browserSync = require('browser-sync'),
    reload = browserSync.reload,
    mainBowerFiles = require('main-bower-files');

// Static Server + watching css/html files
gulp.task('serve', ['watch'], function() {
  browserSync.init()
});

gulp.task('watch', function() {
  gulp.watch("style.css", function(event) {
    gulp.src(event.path, {read: false})
      .pipe(browserSync.stream());
  });

  gulp.watch("**/*.php", browserSync.reload());
});

gulp.task('package', function() {
  gulp.src(mainBowerFiles())
  .pipe(gulp.dest("packages"))
});

gulp.task('default', ['serve']);