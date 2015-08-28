var gulp = require('gulp');
var ghPages = require('gulp-gh-pages');
var Book = require('gitbook').Book;

gulp.task('deploy', function() {
  return gulp.src('./dist/**/*')
    .pipe(ghPages());  
});

gulp.task('gitbook-install', function(){
    var book = new Book('.', {
      config: {
        output: './dist'
      }
    });
    return book.config.load().then(function() {
        return book.plugins.install();
    });
});

gulp.task('gitbook-generate', ['gitbook-install'], function(){
    var book = new Book('.', {
      config: {
        output: './dist'
      }
    });
    return book.parse().then(function() {
        return book.generate('website');
    });
});
