/**
 * Created by Nurbek Nurjanov on 2/4/19.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */

module.exports = {
    context: __dirname,
    devtool: "source-map",
    entry: "./main.js",
    output: {
        path: __dirname + "/../frontend/web/dist",
        publicPath: '../frontend/web/dist/',
        /*path: __dirname + "/dist",
        publicPath: 'dist/',*/
        filename: "build.js"
    },
    mode:'development',
    module: {
        rules: [
            {
                test: /\.vue/,
                use: [
                    { loader: "vue-loader" },
                ]
            },
            {
                test: /\.css$/,
                use: [
                    { loader: "style-loader" },
                    { loader: "css-loader" },


                    /*{ loader: "style-loader/url" },
                    { loader: "file-loader" }*/
                ]
            },
            /*{
                test: /\.less$/,
                use: [
                    'style-loader',
                    'css-loader',
                    'less-loader'
                ],
            },*/
            {
                test: /\.less$/,
                use: [{
                    loader: 'style-loader'
                }, {
                    loader: 'css-loader', options: {
                        sourceMap: true
                    }
                }, {
                    loader: 'less-loader', options: {
                        sourceMap: true
                    }
                }]
            },
            {
                test: /\.scss$/,
                use: [
                    "style-loader", // creates style nodes from JS strings
                    "css-loader", // translates CSS into CommonJS
                    "sass-loader" // compiles Sass to CSS, using Node Sass by default
                ]
            },
            {
                test: /\.png$/,
                use: [
                    "url-loader", // creates style nodes from JS strings
                ]
            }
        ]
    },
    devServer: {
        /*historyApiFallback: true,
        noInfo: true*/
        inline:true,
        port: 10000
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.js'
        }
    },
}