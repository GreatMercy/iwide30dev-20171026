import InfiniteScroll from './src/main'
InfiniteScroll.name = 'InfiniteScroll'
InfiniteScroll.install = function (Vue) {
  Vue.directive(InfiniteScroll.name, InfiniteScroll)
}
export default InfiniteScroll
