module.exports = function ($name, $base = '../../assets/image') {
  console.log(arguments)
  return 'url(' + $base + $name + ')';
}