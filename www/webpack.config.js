const webpack = require("webpack");

const useVersioning = true;
const usePolling = true;

const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const CleanTerminalPlugin = require('clean-terminal-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const {WebpackManifestPlugin} = require('webpack-manifest-plugin');

let config = {
    watchOptions: {
        aggregateTimeout: 200,
        poll: (usePolling ? 1000 : false),
        ignored: /node_modules/
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                use: ["babel-loader"]
            },

            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader
                    },
                    {
                        loader: "css-loader",
                        options: {
                            url: false
                        }
                    },
                    {
                        loader: "sass-loader",
                        options: {
                            implementation: require("sass")
                        }
                    }
                ]
            }
        ]
    },
    resolve: {
        extensions: ["*", ".js", ".jsx"]
    },
    stats: {
        moduleAssets: false,
    },
    mode: "development"
};

let phalconSkeleteonConfig = Object.assign({}, config, {
    name: "phalconSkeleteon",
    entry: {
        app: "./src/phalcon-skeleton/js/app.js"
    },
    output: {
        path: __dirname + "/public/assets/phalcon-skeleton",
        publicPath: "/assets/phalcon-skeleton/",
        filename: useVersioning ? "[name].[hash].min.js" : "[name].min.js"
    },
    plugins: [
        new CleanTerminalPlugin({
            beforeCompile: false,
            skipFirstRun: true
        }),
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: useVersioning ? "[name].[hash].min.css" : "[name].min.css"
        }),
        new WebpackManifestPlugin({
            writeToFileEmit: true,
            basePath: 'assets/phalcon-skeleton/',
        })
    ]
});

module.exports = [phalconSkeleteonConfig];
