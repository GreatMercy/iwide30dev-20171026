let proxyResFn = function (proxyRes, req, res, data) {
  proxyRes.headers['Content-Type'] = 'application/json'
}
let advs = JSON.stringify(require('@/mock/advs.mock'))
let products = JSON.stringify(require('@/mock/products.mock'))
let api = {
  '/index.php/api/v1/mall/advs/get_list': {
    toProxy: false,
    target: 'http://www.baidu.com',
    onProxyRes: function (proxyRes, req, res) {
      console.log(arguments)
      return proxyResFn(proxyRes, req, res, advs)
    },
    onError: function (err, req, res) {
      debugger
      console.log(err)
      res.writeHead(200, {
        'Content-Type': 'application/json'
      })
      res.end(advs)
    }
  },
  '/api/products': {
    toProxy: false,
    target: 'http://www.baidu.com',
    onProxyRes: function (proxyRes, req, res) {
      proxyResFn(proxyRes, req, res, products)
    },
    onError: function (err, req, res) {
      console.log(err)
      res.writeHead(200, {
        'Content-Type': 'application/json'
      })
      res.end(products)
    }
  }
}

module.exports = api
