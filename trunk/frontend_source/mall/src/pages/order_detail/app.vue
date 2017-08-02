<template>
  <div class="jfk-pages jfk-pages__orderDetail">
    <div class="jfk-pages__theme"></div>
    <div class="orderDetail__state jfk-pl-30 jfk-pr-30 ">
      <div class="orderDetail__state__main">
        <img src="../../assets/image/goldlight.png" class="goldlight">
        <div class="orderDetail__state__type color-golden">
          <i class="jfk-font icon-font_zh_yi_qkbys"></i>
          <i class="jfk-font icon-font_zh_zhi_qkbys"></i>
          <i class="jfk-font icon-font_zh_fu_qkbys"></i>.</div>
        <div class="orderDetail__state__tip font-size--24">期待你的使用~</div>
      </div>
    </div>
    <div class="orderDetail__gift">
      <div class="orderDetail__gift__info jfk-clearfix">
        <img src="../../assets/image/goods_icon.png" class="productimg"/>
        <div class="content jfk-pl-30 ">
          <h2 class="font-size--34">四季酒店预售礼包</h2>
          <div class="price_box"><span class="jfk-price  font-size--34"><i class="jfk-font-number jfk-price__currency">￥</i><i class="jfk-font-number jfk-price__number">678</i></span><span class="number font-size--24">1份</span></div>
        </div>
      </div>
      <div class="orderDetail__gift__btn"><button class="jfk-button  jfk-button--primary is-plain jfk-button--free ">放入自己卡包</button></div>
      
    </div>
    <div class="orderDetail_giftcontent jfk-pl-30 jfk-pr-30">
      <div class="giftcontent_title font-size--28 jfk-ta-c">礼包内容</div>
      <div class="giftcontent_fortune">
        <div class="forturn__name"></div>
        <div class="forturn__value"></div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'orderDetails',
    components: {
    },
    data () {
      return {
      }
    },
    created () {
    },
    methods: {
    }
  }
</script>
