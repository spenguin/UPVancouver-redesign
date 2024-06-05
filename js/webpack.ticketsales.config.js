var path = require('path');
var webpack = require('webpack');

module.exports = {
    entry: './js/react/build/TicketSales/index.js',
    output: { path: __dirname + '/dist', filename: 'ticketsales.js' },
    module: {
        rules: [
            {
                test: /.jsx?$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
                options: {
                    presets: ["@babel/preset-env", '@babel/preset-react']
                }
            },
            {
                test: /\.css$/,
                use: [
                  "style-loader",
                  {
                    loader: "css-loader",
                    options: {
                      importLoaders: 1,
                      modules: true,
                    },
                  },
                ],
                include: /\.module\.css$/,
              },
              {
                test: /\.css$/,
                use: ["style-loader", "css-loader"],
                exclude: /\.module\.css$/,
              },
        ]
    },
};