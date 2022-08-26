import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/fontawesome.css",
        "resources/css/print.css",
        "resources/css/prism.css",
        "resources/css/workshop.css",

        "resources/js/app.js",
        "resources/js/prism.js",
      ],
      refresh: true,
    }),
  ],
});
