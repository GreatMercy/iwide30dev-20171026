// https://github.com/michael-ciniawsky/postcss-load-config
let atRulesVariables = require('postcss-at-rules-variables')
let atImport = require('postcss-import')
let scss = require('postcss-scss')
let customProperties = require('postcss-custom-properties')
let path = require('path')
module.exports = (ctx) => {
  return {
    'syntax': 'postcss-scss',
    'plugins': {
      'postcss-import': {},
      'postcss-at-rules-variables': {},
      'postcss-custom-media': {},
      'postcss-mixins': {
        mixinsDir: path.join(__dirname, './common/postcss/mixin_functions')
      },
      'postcss-each': {
        plugins: {
          afterEach: [
            atRulesVariables
          ],
          beforeEach: [
            customProperties
          ]
        }
      },
      'postcss-for': {},
      'postcss-conditionals': {},
      'postcss-at-rules-variables': {},
      'postcss-media-minmax': {},
      'postcss-nested-props': {},
      'postcss-nesting': {},
      'postcss-nested': {},
      'postcss-atroot': {},
      'postcss-extend': {},
      'postcss-css-variables': {},
      'postcss-functions': {
        glob: path.join(__dirname, './common/postcss/functions', '*.js')
      },
      'postcss-color-function': {},
      'postcss-calc': {},
      'postcss-inline-svg':{},
      // to edit target browsers: use 'browserlist' field in package.json
      'autoprefixer': {}
    }
  }
}