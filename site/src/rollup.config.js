import { nodeResolve } from "@rollup/plugin-node-resolve";
import { terser } from "rollup-plugin-terser";
import typescript from "@rollup/plugin-typescript";

export default {
  input: "js_src/editor.ts",
  output: {
    file: "dist/bundle.js",
    format: "esm",
    sourcemap: true,
  },
  plugins: [typescript(), nodeResolve(), terser()],
  inlineDynamicImports: true,
  preserveEntrySignatures: false,
};
