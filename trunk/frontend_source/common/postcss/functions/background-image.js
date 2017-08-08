const assetMaps = {
  common: '../../assets/image',
  theme: '../../../assets/image'
}
module.exports = function ($name, $type = 'common') {
  return 'url(' + (assetMaps[$type] || $type) + $name + ')';
}