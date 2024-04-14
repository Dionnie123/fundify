import yargs from "yargs";
import cleanCss from "gulp-clean-css";
import gulpif from "gulp-if";
import postcss from "gulp-postcss";
import sourcemaps from "gulp-sourcemaps";
import autoprefixer from "autoprefixer";
import { src, dest, watch, series, parallel } from "gulp";
import imagemin from "gulp-imagemin";
import webpack from "webpack-stream";
import named from "vinyl-named";
import del from "del";
import browserSync from "browser-sync";
import zip from "gulp-zip";
import info from "./package.json";
import wpPot from "gulp-wp-pot";

const PRODUCTION = yargs.argv.prod;
const server = browserSync.create();
var sass = require("gulp-sass")(require("sass"));

var paths = {
  rename: {
    src: [],
  },
  watch: {
    sass: "assets/scss/**/*.scss",
    js: "assets/js/**/*.js",
    php: "**/*.php",
  },
  styles: {
    src: ["assets/scss/bundle.scss", "assets/scss/admin.scss"],
    dest: "dist/assets/css",
  },
  scripts: {
    src: "assets/js/**/*.js",
    dest: "dist/assets/js",
  },
  images: {
    src: "assets/images/**/*.{jpg,jpeg,png,svg,gif}",
    dest: "dist/assets/images",
  },
  other: {
    src: [
      "assets/**/*",
      "!assets/{images,js,scss}",
      "!assets/{images,js,scss}/**/*",
    ],
    dest: "dist/assets",
  },

  package: {
    src: [
      "**/*",
      "!.vscode",
      "!node_modules{,/**}",
      "!packaged{,/**}",
      "!src{,/**}",
      "!.babelrc",
      "!.gitignore",
      "!gulpfile.babel.js",
      "!package.json",
      "!package-lock.json",
    ],
    dest: "packaged",
  },
};

export const pot = () => {
  return src("**/*.php")
    .pipe(
      wpPot({
        domain: info.name,
        package: info.name,
      })
    )
    .pipe(dest(`languages/${info.name}.pot`));
};

export const styles = () => {
  return src(paths.styles.src)
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(sass().on("error", sass.logError))
    .pipe(gulpif(PRODUCTION, postcss([autoprefixer])))
    .pipe(gulpif(PRODUCTION, cleanCss({ compatibility: "ie8" })))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(dest(paths.styles.dest))
    .pipe(server.stream());
};

export const scripts = () => {
  return src(paths.scripts.src)
    .pipe(named())
    .pipe(
      webpack({
        module: {
          rules: [
            {
              test: /\.js$/,
              use: {
                loader: "babel-loader",
                options: {
                  presets: ["@babel/preset-env"], //or ['babel-preset-env']
                },
              },
            },
          ],
        },
        mode: PRODUCTION ? "production" : "development",
        devtool: !PRODUCTION ? "inline-source-map" : false,
        output: {
          filename: "[name].js",
        },
        externals: {
          jquery: "jQuery",
        },
      })
    )
    .pipe(dest(paths.scripts.dest));
};

export const images = () => {
  return src(paths.images.src)
    .pipe(gulpif(PRODUCTION, imagemin()))
    .pipe(dest(paths.images.dest));
};

export const watchChanges = () => {
  watch(paths.watch.sass, styles);
  watch(paths.watch.js, series(scripts, reload));
  watch(paths.watch.php, reload);
  watch(paths.images.src, series(images, reload));
  watch(paths.other.src, series(copy, reload));
};

export const copy = () => {
  return src(paths.other.src).pipe(dest(paths.other.dest));
};

export const clean = () => {
  return del(["dist", "bundled", "languages"]);
};

export const compress = () => {
  return src([
    "**/*",
    "!node_modules{,/**}",
    "!bundled{,/**}",
    "!src{,/**}",
    "!.babelrc",
    "!.gitignore",
    "!gulpfile.babel.js",
    "!package.json",
    "!package-lock.json",
  ])
    .pipe(zip(`${info.name}.zip`))
    .pipe(dest(paths.package.dest));
};

export const serve = (done) => {
  server.init({
    proxy: "http://provider.test/",
  });
  done();
};
export const reload = (done) => {
  server.reload();
  done();
};

export const dev = series(
  clean,
  parallel(styles, scripts, images, copy),
  serve,
  watchChanges
);
export const build = series(
  clean,
  parallel(styles, scripts, images, copy),
  pot
);

export const bundle = series(build, compress);

export default dev;
