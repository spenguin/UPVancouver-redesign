var path = require('path');
var webpack = require('webpack');

module.exports = {
  entry: './js/react/build/Test/index.js',
  output: { path: './js/dist', filename: 'test.js' },
  module: {
    loaders: [
      {
        test: /.jsx?$/,
        loader: 'babel-loader',
        exclude: /node_modules/,
        query: {
          presets: ['es2015', 'react']
        }
      }
    ]
  },
};
