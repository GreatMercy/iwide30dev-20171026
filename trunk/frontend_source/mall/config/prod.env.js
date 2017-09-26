let result = {
  NODE_ENV: '"production"'
}
if (process.env.npm_config_interid === 'accor') {
  result.INTER_ID = '"accor"'
} else if (process.env.npm_config_interid === 'gift') {
  result.INTER_ID = '"gift"'
}
module.exports = result
