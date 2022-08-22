import { fontawesomeSubset } from "fontawesome-subset";
import * as fs from "node:fs";
import * as sass from "node-sass";
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
fontawesomeSubset(icons, "resources/webfonts/");

// update SASS files and compile SASS
let iconsCode = [];
for (let key of Object.keys(icons)) {
  for (let i of icons[key]) {
    iconsCode.push(`${i}: $fa-var-${i}`);
  }
}
const outFile = "node_modules/@fortawesome/fontawesome-free/scss/_icons.scss";
fs.writeFile(
  outFile,
  `
$icons: (
  ${iconsCode.map((i) => `${i},\n`).join("")}
);

@each $name, $icon in $icons {
  .#{$fa-css-prefix}-#{$name}::before { content: unquote("\\"#{ $icon }\\""); }
}
`,
  function (err) {
    if (err) return console.log(err);
    console.log(`Wrote SASS to ${outFile}`);
  }
);

const cssFile = "./resources/css/fontawesome.css";
sass.render(
  {
    file: "./node_modules/@fortawesome/fontawesome-free/scss/fontawesome.scss",
    outFile: cssFile,
  },
  function (err, result) {
    if (err) return console.log(err);
    // minify CSS
    const minCss = minify(new TextDecoder("utf-8").decode(result.css));
    fs.writeFile(cssFile, minCss.css, function (err) {
      if (err) return console.log(err);
    });
  }
);
