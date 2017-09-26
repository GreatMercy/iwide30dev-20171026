<template>
  <div>
    <div class="gift-list-wrap" ref="list" v-if="list.length > 0">
      <ul class="gift-list jfk-pl-30 jfk-pr-30">

        <li class="gift-list-item jfk-flex is-align-middle" v-for="(item, key) in list">
          <div class="gift-list-item__header">
            <img :src="item.openid_headimg" v-if="item.openid_headimg">
          </div>
          <div class="gift-list-item__info">
            <p class="font-size--28 gift-list-item__name" v-html="item.openid_nickname"></p>
            <p class="font-size--24 gift-list-item__date" v-html="item.get_time"></p>
          </div>
          <div class="gift-list-item__number font-size--34 jfk-ta-r" v-html=" '收到'+ item.get_qty + '份'"
               v-if="item.get_qty"></div>
        </li>

      </ul>

    </div>

    <div class="gift-list__no-data" v-else>
      <div class="gift-list__icon jfk-ta-c">
        <div class="jfk-font icon-user_icon_Polite_nor"></div>
      </div>

      <template v-if="status === 4">
        <p class="font-size--28 jfk-ta-c gift-list__text">领取超时</p>
        <p class="font-size--28 jfk-ta-c gift-list__text">礼物已被自动退回</p>
      </template>

      <template v-else>
        <p class="font-size--28 jfk-ta-c gift-list__text">礼物暂无人领取</p>
        <p class="font-size--28 jfk-ta-c gift-list__text">超过24小时将自动退回</p>
      </template>

    </div>

  </div>

</template>

<script>
  import BScroll from 'better-scroll'
  export default {
    name: 'giftList',
    props: {
      list: {
        type: Array
      },
      status: {
        type: Number,
        default: 1
      }
    },
    data () {
      return {
        scroll: null
      }
    },
    created () {
      this.initScroll()
    },
    methods: {
      initScroll () {
        this.$nextTick(() => {
          try {
            this.scroll = new BScroll(this.$refs.list, {
              bounce: false
            })
          } catch (e) {
          }
        })
      }
    }
  }
</script>
