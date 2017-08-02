<template>
  <li class="good-lists__item-card">
    <a :href="detail" class="item-cont">
      <div class="goods-box">
        <div class="goods-image">
          <div class="jfk-image__lazy goods-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image" v-lazy:background-image="item.face_img">
          </div>
        </div>
        <div class="goods-info jfk-flex is-align-middle">
          <div class="goods-info-cont">
            <h3 class="goods-title font-size--32 font-color-dark-white" v-once>{{item.name}}</h3>
            <div class="goods-price jfk-price color-golden font-size--54">
              <i class="jfk-font-number jfk-price__currency">￥</i>
              <i class="jfk-font-number jfk-price__number">{{price}}</i>
            </div>
            <p v-if="goodNumInfo" class="font-size--24 goods-number font-color-light-gray" v-html="goodNumInfo"></p>
            <JfkButton :type="type === 'killsec' ? 'primary' : 'default'" @click.native="clickHandler" @click="clickHandler" class="font-size--30 goods-button" font="qkbys">{{buttonText}}</JfkButton>
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
    mixins: [listMixin],
    created () {
    },
    computed: {
      goodNumInfo () {
        if (this.type === 'killsec') {
          let count = this.startedKillsec ? this.info.killsec_permax - this.info.killsec_count : this.info.killsec_permax
          return '剩余' + count + '&nbsp;|&nbsp;限' + this.info.killsec_permax
        }
        if (this.type === 'groupon') {
          return '已售' + this.item.sales_cnt
        }
        return false
      }
    }
  }
</script>

