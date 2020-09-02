const gulp = require("gulp");
const connect = require("gulp-connect");
const sass = require("gulp-sass");
const sourcemaps = require("gulp-sourcemaps");
const plumber = require("gulp-plumber");
const babel = require('gulp-babel');
const uglify = require('gulp-uglify');

gulp.task("html", done => {
    gulp.src("src/*.html")
        .pipe(gulp.dest("dist"))
        .pipe(connect.reload());
    done();
});

gulp.task("html2", done => {
    gulp.src("src/html/*.html")
        .pipe(gulp.dest("dist/html"))
        .pipe(connect.reload());
    done();
});

gulp.task("sass", done => {
    gulp.src("src/sass/*.scss")
        .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(sass({
            "outputStyle": "compressed"
        }))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest("dist/css"))
        .pipe(connect.reload());
    done();
});

gulp.task("js", done => {
    gulp.src("src/js/*.js")
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(uglify())
        .pipe(gulp.dest("dist/js"))
        .pipe(connect.reload());
    done()
})

gulp.task("static", done => {
    gulp.src("src/static/*.*")
        .pipe(gulp.dest("dist/static"))
        .pipe(connect.reload());
    done();
});

gulp.task("lib", done => {
    gulp.src("src/lib/*.*")
        .pipe(gulp.dest("dist/lib"))
        .pipe(connect.reload());
    done();
});

gulp.task("server", done => {

    connect.server({
        root: "dist",
        livereload: true
    })

    done();
});

gulp.task("watch", done => {

    gulp.watch("src/*.html", gulp.series("html"));
    gulp.watch("src/html/*.html", gulp.series("html2"));
    gulp.watch("src/sass/*.scss", gulp.series("sass"));
    gulp.watch("src/js/*.js", gulp.series("js"));
    gulp.watch("src/static/*.*", gulp.series("static"));
    gulp.watch("src/lib/*.*", gulp.series("lib"));

    done();
});

gulp.task("build", gulp.parallel("html", "html2", "sass", "js", "static", "lib"));

gulp.task("default", gulp.series("build", "watch", "server"));