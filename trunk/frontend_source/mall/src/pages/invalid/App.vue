<template>
  <div class="jfk-pages jfk-pages__invalid">
    <div class="jfk-pages__theme"></div>
    <div class="invalid_content">
      <div class="invalid_icon"><i class="jfk-font icon-mall_icon_remove"></i></div>
      <p>很遗憾，商品已下架~</p></div>
     <div class="recommendation jfk-pl-30" v-if="recommendations.length">
      <p class="font-size--24 font-color-light-gray tip">其他用户还看了</p>
    <div class="recommendations-list">
       <jfk-recommendation :items="recommendations" :linkPrefix="detailUrl" :emptyLink="indexUrl"></jfk-recommendation> 
    </div>
    </div> 
  </div>
</template>
<script>
  import { getPackageRecommendation } from '@/service/http'
  export default {
    name: 'invalid',
    data () {
      return {
        recommendations: []
      }
    },
    created () {
      let that = this
      // 推荐商品无分页，page_size设置大一些，一页全部请求完毕
      getPackageRecommendation({
        page: 1,
        page_size: 100
      }).then(function (res) {
        const { products, page_resource } = res.web_data
        that.recommendations = products
        let { detail, home } = page_resource.link
        if (process.env.NODE_ENV === 'development') {
          detail = '/detail?pid='
          home = '/'
        }
        that.detailUrl = detail
        that.indexUrl = home
      })
    }
  }
</script>
