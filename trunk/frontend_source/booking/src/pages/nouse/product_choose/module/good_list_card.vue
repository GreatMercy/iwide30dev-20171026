<template>
  <li>
    <a :href="detailUrl" class="item-cont">
      <div class="product-box">
        <div class="jfk-price-tag jfk-price-tag--small font-size--26" :class="'jfk-price-tag--theme-' + product.tag" v-once v-if="product.tag > 0 && priceTagText">
          <!-- <div class="jfk-price-tag__mask"></div> -->
<!--           <div class="jfk-price-tag__words is-justify-space-between" v-html="priceTagText"></div> -->
        </div>
        <div class="product-image">
          <div v-if="product.face_img" class="jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image" v-lazy:background-image="product.face_img"></div>
          <div v-else class="jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image jfk-image__lazy--preload"></div>
        </div>
        <div class="product-info jfk-flex is-align-middle">
          <div class="product-info-cont">
            <h3 class="product-title font-size--32 font-color-dark-white" v-once>{{product.name}}</h3>
            <div class="product-price" v-if="product.price_market">
              <span class="jfk-price product-price-package color-golden font-size--54" v-html="pricePackage" v-once></span>
              <span class="jfk-price__original product-price-market font-size--24 font-color-light-gray" v-once>{{priceMarket}}</span>
            </div>
            <p class="font-size--24 product-number font-color-light-gray" v-html="productNumber"></p>
          </div>
        </div>
      </div>
    </a>
  </li>
</template>
<script>
  import listMixin from './listMixin'
  export default {
    name: 'good-list-card',
    mixins: [listMixin]
  }
</script>

