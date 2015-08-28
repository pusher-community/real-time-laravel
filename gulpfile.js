var gulp = require('gulp');
var ghPages = require('gulp-gh-pages');
var run = require('gulp-run');
var gitbook = require('gitbook');

var Book = gitbook.Book;

var book = new Book('./src', {
  config: {
    output: './dist'
  }
});

gulp.task('default', function() {
  console.log('Make sure you have "gitbook-cli" installed globally.\n' +
              'Then run "gitbook serve src"');
});

gulp.task('deploy', function() {
  return gulp.src('./dist/**/*')
    .pipe(ghPages());  
});

gulp.task('gitbook-install', function(){
    return book.config.load().then(function() {
        return book.plugins.install();
    });
});

gulp.task('gitbook-generate', ['gitbook-install'], function(){
    return book.parse().then(function() {
        return book.generate('website');
    });
});
