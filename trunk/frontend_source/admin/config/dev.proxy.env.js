module.exports = {
  '/index.php/api/v1': {
    target: 'http://test008.iwide.cn',
    changeOrigin: true,
    secure: false
  },
  '/index.php/iapi/v1': {
    target: 'http://test008.iwide.cn',
    // target: 'http://30.iwide.cn',
    changeOrigin: true,
    secure: false
  },
  '/index.php/iwidepay/IwidepayApi': {
    target: 'http://30.iwide.cn',
    changeOrigin: true,
    secure: false
  },
  '/index.php/membervip': {
    target: 'http://test008.iwide.cn',
    changeOrigin: true,
    secure: false
  },
  '/index.php/basic': {
    target: 'http://test008.iwide.cn',
    changeOrigin: true,
    secure: false
  }
}
