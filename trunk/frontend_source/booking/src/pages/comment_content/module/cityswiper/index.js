import JfkRecommendation from './src/main'

/* istanbul ignore next */
JfkRecommendation.install = function (Vue) {
  Vue.component(JfkRecommendation.name, JfkRecommendation)
}

export default JfkRecommendation
