import { fontawesomeSubset } from "fontawesome-subset";
import * as fs from "node:fs";
import sass from "sass";
import { minify } from "csso";

// icons used
const icons = {
  solid: [
    "address-card",
    "arrow-right-from-bracket",
    "arrow-right-to-bracket",
    "bars",
    "blog",
    "chalkboard-user",
    "copyright",
    "file-pen",
    "house",
    "lightbulb",
    "minus",
    "moon",
    "pen-to-square",
    "plus",
    "square-rss",
    "sun",
  ],
  brands: ["github"],
};

// generate webfont
// https://github.com/omacranger/fontawesome-subset
const outDir = "./resources";
fontawesomeSubset(icons, `${outDir}/webfonts/`);

// update SASS files and compile SASS
let iconsCode = [];
let brandsIconsCode = [];
for (let key of Object.keys(icons)) {
  let code = key == "brands" ? brandsIconsCode : iconsCode;
  for (let i of icons[key]) {
    code.push(`${i}: $fa-var-${i}`);
  }
}

// update vars
// wrap old vars file
const fontawesomePath = "./node_modules/@fortawesome/fontawesome-free/scss";
const oldVars = `${fontawesomePath}/_variables.scss`;
const newVars = `${fontawesomePath}/_fa_variables.scss`;
if (!fs.existsSync(newVars)) {
  // first run
  fs.copyFileSync(oldVars, newVars);
}
// wraper for vars file
fs.writeFileSync(
  oldVars,
  `
@import 'fa_variables';

$fa-icons: (
  ${iconsCode.map((i) => `${i},\n`).join("")}
);

$fa-brand-icons: (
  ${brandsIconsCode.map((i) => `${i},\n`).join("")}
);
  `
);

// SASS
// main compilation file
const mainFile = `${fontawesomePath}/main.scss`;
let mainCode = `@import 'functions';
@import 'variables';
@import 'mixins';
@import 'core';
@import 'fixed-width';
@import 'screen-reader';
@import 'icons';`;
for (let key of Object.keys(icons)) {
  mainCode += `\n@import "${key}";`;
}
fs.writeFileSync(mainFile, mainCode);
// compile SASS
const result = sass.renderSync({ file: mainFile });

// minify
const minCss = minify(new TextDecoder("utf-8").decode(result.css));
fs.writeFileSync(`${outDir}/css/fontawesome.css`, minCss.css, {comments: false});
