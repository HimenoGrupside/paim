import { defineConfig } from "vite";
import { resolve, relative, extname } from "path";
import { globSync } from "glob";
import { fileURLToPath } from "node:url";
import { ViteEjsPlugin } from "vite-plugin-ejs";

const root = resolve(__dirname, "src");

// WordPress用ビルドのinput設定。WordPress用にはhtmlファイルは不要なため、scssとtsのみをビルド対象にする
const inputsForWordPress = {
  style: resolve(root, "assets/style/style.scss"),
  // 動的にファイルを取得する @see https://rollupjs.org/configuration-options/#input
  ...Object.fromEntries(
    globSync("src/assets/js/*.ts").map((file) => [
      relative(
        "src/assets/js",
        file.slice(0, file.length - extname(file).length),
      ),
      fileURLToPath(new URL(file, import.meta.url)),
    ]),
  ),
};

// 静的開発用のinput設定。静的資材用にはhtmlファイルを経由してscss,tsなどをビルドする
const inputsForStatic = {
  style: resolve(root, "assets/style/style.scss"),
  ...Object.fromEntries(
    globSync("src/**/*.html").map((file) => [
      relative("src", file.slice(0, file.length - extname(file).length)),
      fileURLToPath(new URL(file, import.meta.url)),
    ]),
  ),
};

export default defineConfig(({ mode }) => ({
  root,
  base: "./",
  plugins: [
    ViteEjsPlugin(),
  ],
  server: {
    port: 5173,
    origin: mode == "wp" ? undefined : "http://localhost:5173",
    open: true, // 開発サーバー起動時にブラウザを自動で開く
  },
  build: {
    outDir:
      mode === "wp"
        ? resolve(__dirname, "wordpress/themes/paim/")
        : resolve(__dirname, "dist"),
    rollupOptions: {
      input: mode === "wp" ? inputsForWordPress : inputsForStatic,
      output: {
        entryFileNames: "assets/js/[name].js",
        chunkFileNames: "assets/js/[name].js",
        assetFileNames: (assetsInfo) => {
          if (assetsInfo.name === "style.css") {
            return "assets/style/[name].[ext]";
          } else {
            return "assets/src/[name].[ext]";
          }
        },
      },
    },
  },
}));
