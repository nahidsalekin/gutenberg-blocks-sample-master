import { build } from 'esbuild';
import { sassPlugin } from 'esbuild-sass-plugin';
import postcss from 'postcss'
import autoprefixer from 'autoprefixer';
import imageInline from 'esbuild-plugin-inline-image';
import pkg from 'esbuild-plugin-external-global';
const { externalGlobalPlugin } = pkg

build({
    entryPoints: [
        './src/js/block.js',
        './src/styles/index.scss'
    ],
    outdir: './dist',
    bundle: true,
    watch: {
        onRebuild(error, result) {
            if (error) console.error('watch build failed:', error)
            else console.log('watch build succeeded:', result)
        },
    },
    loader: {
        ".js": "jsx",
    },
    sourcemap: false,
    plugins: [imageInline(), sassPlugin({
        async transform(source) {
            const { css } = await postcss([autoprefixer]).process(source, { from: undefined });
            return css;
        },
    }), externalGlobalPlugin({
        'react': 'window.React',
        'react-dom': 'window.ReactDOM',
    })],
}).then(() => console.log("⚡ Build complete! ⚡"))
    .catch(() => process.exit(1));