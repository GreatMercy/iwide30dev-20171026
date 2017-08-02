import InfiniteScroll from './src/main'
import Vue from 'vue'
InfiniteScroll.name = 'InfiniteScroll'
InfiniteScroll.install = function (Vue) {
  Vue.directive(InfiniteScroll.name, InfiniteScroll)
}
export default InfiniteScroll
