const esbuild = require("esbuild")
// const { sassPlugin } = require("esbuild-sass-plugin");
// const postcss = require('postcss');
// const autoprefixer = require('autoprefixer');
// const inlineImage = require("esbuild-plugin-inline-image");

esbuild.build({
    entryPoints: [
        './block.js'
    ],
    outdir: './dist',
    //minify: true,
    bundle: true,
    loader: {
        ".js": "jsx",
    },
    // plugins: [inlineImage(), sassPlugin({
    //     async transform(source) {
    //         const { css } = await postcss([autoprefixer]).process(source, { from: undefined });
    //         return css;
    //     },
    // })],
}).then(() => console.log("⚡ Build complete! ⚡"))
    .catch(() => process.exit(1));