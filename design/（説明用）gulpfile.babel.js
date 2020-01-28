import gulp from 'gulp';
import notify from 'gulp-notify';
import plumber from 'gulp-plumber';
import webpackConfig from './webpack.config.js';
import webpack from 'webpack-stream';
import browserSync from 'browser-sync';

// jsやCSSを１つにまとめる
gulp.task('build', function(){
  // jsファイルを取得
  gulp.src('src/js/app.js')
    .pipe(plumber({
      errorHandler: notify.onError("Error: <%= error.message %>")
    }))
    .pipe(webpack(webpackConfig))
    .pipe(gulp.dest('dist/js/'));
});


// 画面を監視し、更新があればリロードする
gulp.task('browser-sync', function() {
  browserSync.init({
    server: {
      baseDir: "./", // 対象ディレクトリ
      index: "index.html" //indexファイル名
    }
  });
});
gulp.task('bs-reload', function () {
  browserSync.reload();
});

// ファイルの監視
gulp.task('default', ['build', 'browser-sync'], function(){
  gulp.watch('./src/*/*.js', ['build']);
  gulp.watch("./*.html", ['bs-reload']);
  gulp.watch("./dist/*/*.+(js|css)", ['bs-reload']);
});
