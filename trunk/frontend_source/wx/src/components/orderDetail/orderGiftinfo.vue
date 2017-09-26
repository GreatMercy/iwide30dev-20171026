<template>
    <div class="order__gift__info jfk-clearfix">
        <div v-if="giftinfo.imgUrl" class="jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image productimg" v-lazy:background-image="giftinfo.imgUrl"></div>
        <div v-else class="jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image jfk-image__lazy--preload"></div>
        <!-- <img  :src="giftinfo.imgUrl" class="productimg"/> -->
        <div class="content jfk-pl-30 ">
            <h2 class="font-size--34">{{giftinfo.title}}</h2>
            <p class="font-size--24 validate" v-if="giftinfo.showValidate">有效期 {{giftinfo.validate}}</p>
            <div class="price_box color-golden-price"><span class="jfk-price  font-size--38"><i class="jfk-font-number jfk-price__currency">￥</i><i class="jfk-font-number jfk-price__number">{{giftinfo.price}}</i></span><span class="number font-size--24">{{giftinfo.number}}份</span></div>
        </div>
    </div>
</template>
<script>
export default{
  name: 'orderGiftinfo',
  props: ['giftinfo']
}
</script>
