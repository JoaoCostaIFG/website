import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/prism.css",
        "resources/css/workshop.css",

        "resources/js/app.js",
        "resources/js/prism.js",
        "resources/ts/editor.ts",
        "resources/ts/blogimg.ts",
      ],
      refresh: true,
    }),
  ],
});
