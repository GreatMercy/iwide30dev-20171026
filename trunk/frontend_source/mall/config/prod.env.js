let result = {
  NODE_ENV: '"production"'
}
if (process.env.npm_config_interid === 'accor') {
  result.INTER_ID = '"accor"'
}
module.exports = result
