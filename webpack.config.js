'use strict'
const path = require('path');
const webpack = require('webpack');
const autoprefixer = require('autoprefixer');
const ManifestPlugin = require('webpack-manifest-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const HtmlWebpackInlineSourcePlugin = require('html-webpack-inline-source-plugin');
const {VueLoaderPlugin} = require('vue-loader');
//const EntrypointAssetsPlugin = require('entrypoint-assets-webpack-plugin');

module.exports = (env) => {
    const config = {
        entry: {
            app: path.join(__dirname, 'assets/entrypoints/app.entry.js'),
            delta: path.join(__dirname, 'assets/entrypoints/delta.entry.js'),
            ag_simple: path.join(__dirname, 'assets/entrypoints/ag_simple.entry.js'),
            ag_tree: path.join(__dirname, 'assets/entrypoints/ag_tree.entry.js'),
            handson_tree: path.join(__dirname, 'assets/entrypoints/handson_tree.entry.js'),
            live_video: path.join(__dirname, 'assets/entrypoints/live.video.entry.js'),
            login: path.join(__dirname, 'assets/entrypoints/login.entry.js'),
            status: path.join(__dirname, 'assets/entrypoints/status.entry.js'),
            mail_acl: path.join(__dirname, 'assets/entrypoints/mail.acl.entry.js'),
            mail_domain: path.join(__dirname, 'assets/entrypoints/mail.domain.entry.js'),
            mail_search: path.join(__dirname, 'assets/entrypoints/mail.search.entry.js'),
            project: path.join(__dirname, 'assets/entrypoints/reestr.project.entry.js'),
            contr_agent: path.join(__dirname, 'assets/entrypoints/reestr.contr_agent.entry.js'),
        },
        node: {
            fs: 'empty'
        },
        output: {
            filename: (env === 'dev') ? '[name].js' : '[name]-[chunkhash].js',
            publicPath: 'build/',
            path: path.resolve(__dirname, 'public/build'),
        },
        performance: {hints: false},
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    options: {
                        loaders: {
                            "scss": [
                                "vue-style-loader",
                                "css-loader",
                                {
                                    loader: 'postcss-loader',
                                    options: {
                                        plugins: [
                                            autoprefixer({
                                                overrideBrowserslist: ['ie >= 11', 'last 4 version']
                                            })
                                        ],
                                        sourceMap: true
                                    }
                                },
                                "sass-loader",
                            ],
                            "sass": [
                                "vue-style-loader",
                                "css-loader",
                                {
                                    loader: 'postcss-loader',
                                    options: {
                                        plugins: [
                                            autoprefixer({
                                                overrideBrowserslist: ['ie >= 11', 'last 4 version']
                                            })
                                        ],
                                        sourceMap: true
                                    }
                                },
                                "sass-loader?indentedSyntax"
                            ]
                        }
                    }
                }, {
                    test: /\.css$/,
                    use: [
                        'vue-style-loader',
                        'style-loader',
                        'css-loader',
                        {
                            loader: 'postcss-loader',
                            options: {
                                plugins: [
                                    autoprefixer({
                                        overrideBrowserslist: ['ie >=11', 'last 4 version']
                                    })
                                ],
                                sourceMap: true
                            }
                        },
                    ],
                }, {
                    test: /\.scss$/,
                    use: [
                        {loader: "vue-style-loader"},
                        {loader: "css-loader"},
                        {
                            loader: 'postcss-loader',
                            options: {
                                plugins: [
                                    autoprefixer({
                                        overrideBrowserslist: ['ie >= 11', 'last 4 version']
                                    })
                                ],
                                sourceMap: true
                            }
                        },
                        {
                            loader: "sass-loader",
                            options: {
                                includePaths: [
                                    path.join(__dirname, 'node_modules/element-ui/packages/theme-chalk/src')
                                ]
                            }
                        },
                    ],
                }, {
                    test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                    use: [{
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: 'fonts/',
                            publicPath: '/build/fonts/'
                        }
                    }]
                }, {
                    test: /\.(jpg|jpeg|png|svg)$/,
                    use: [{
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: 'images/',
                            publicPath: '/build/images/'
                        }
                    }]
                }, {
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            babelrc: true,
                        }
                    }
                }
            ]
        },
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm.js', // 'vue/dist/vue.common.js' для webpack 1
                'jquery': path.join(__dirname, 'node_modules/jquery/dist/jquery'),
                // 'jquery-ui': 'jquery-ui'
                //'jquery': path.join(__dirname, '/node_modules/jquery/dist/jquery.min.js'),
            },
            extensions: [
                ".js",
                ".vue"
            ]
        },
        plugins: [
            new VueLoaderPlugin(),
            new ManifestPlugin({
                publicPath: 'build/',
                basePath: 'build/'
            }),
            new CleanWebpackPlugin(['build'], {
                root: path.resolve(__dirname, 'public'),
                watch: true,
                exclude: ['fonts']
            }),
            new webpack.DefinePlugin({
                'process.env': {
                    'NODE_ENV': JSON.stringify(process.env.NODE_ENV)
                }
            }),
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'Promise': 'es6-promise', // Thanks Aaron (https://gist.github.com/Couto/b29676dd1ab8714a818f#gistcomment-1584602)
                'fetch': 'imports?this=>global!exports?global.fetch!whatwg-fetch'
            }),
            new HtmlWebpackPlugin({
                inlineSource: '.(js|css)$' // embed all javascript and css inline
            }),
            new HtmlWebpackInlineSourcePlugin(),
        ],
        optimization: {
            minimize: (env === 'dev') ? false : true,
        }
    };

    return config;
};
