<template>
  <div class="jfk-pages jfk-pages__gift-list" :class="theme">
    <div class="jfk-pages__theme" v-if="!theme">
      <div class="jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
    </div>
    <template v-if="theme">
      <gift-bg :wish="wish" v-if="wish"></gift-bg>
      <div class="gift-list-wrap" ref="list">

        <ul class="gift-list jfk-pl-30 jfk-pr-30" v-if="giftList.length > 0">
          <li class="gift-list-item jfk-flex is-align-middle" v-for="(item, key) in giftList">
            <div class="gift-list-item__header">
              <img :src="item.openid_headimg" v-if="item.openid_headimg">
            </div>
            <div class="gift-list-item__info">
              <p class="font-size--28 gift-list-item__name" v-html="item.openid_nickname"></p>
              <p class="font-size--24 gift-list-item__date" v-html="item.get_time"></p>
            </div>
            <div class="gift-list-item__number font-size--34 jfk-ta-r" v-html=" '收到'+ item.get_qty + '份'"></div>
          </li>
        </ul>
      </div>


      <div class="gift-state jfk-ta-c">

        <!-- 判断是否可以继续赠送 -->

        <!-- 可以继续赠送-->
        <template v-if="continueGive === 1">
          <a class="font-size--32 gift-state-send gift-state-arrow" href="javascript:void(0)"
             @click="continueGivePresent">继续赠送</a>
          <p class="font-size--24 gift-state-number" v-html="'已领取' +'' + received + '/' + total">已领取 4/10</p>
        </template>

        <!-- 不可以继续赠送 -->
        <template v-else-if="continueGive === 2">

          <!-- 领取超时 -->
          <template v-if="status === 4">
            <a class="font-size--32 gift-state-receive gift-state-arrow" @click="returnPresent">查看退回的礼物</a>
            <p class="font-size--24 gift-state-number" v-html="'已领取' +'' + received + '/' + total">已领取 4/10</p>
          </template>

          <!-- 礼物打包中、可以赠送、已经有第一位领取 -->
          <template v-else>
            <!-- 判断 是否 已经领取完成 -->

            <!-- 领取完成 -->
            <template v-if="received === total">
              <a class="font-size--32 gift-state-finish" href="javascript:void(0)">手慢了，礼物已被领完</a>
            </template>

            <!-- 尚未领取完成 -->
            <template v-else>
              <p class="font-size--24 gift-state-number" v-html="'已领取' +'' + received + '/' + total">已领取 4/10</p>
            </template>

          </template>


        </template>


      </div>
    </template>

  </div>
</template>
<script>
  import giftBg from '@/components/gift_themes/gift_background'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  const params = formatUrlParams.default(location.href)
  import { getPresentsList, postPresentsReturnJump } from '@/service/http'
  import BScroll from 'better-scroll'
  export default {
    name: 'giftList',
    methods: {
      // 初始化better-scroll
      initScroll () {
        this.$nextTick(() => {
          this.scroll = new BScroll(this.$refs.list, {
            bounce: false
          })
        })
      },
      // 点击继续赠送礼物
      continueGivePresent () {
        this.$jfkConfirm('继续赠送给不同朋友，礼物将送给先打开的好友').then(() => {
        }).catch(() => {
          // 出现微信分享，出现微信分享弹窗
        })
      },
      // 查看回退的礼物
      returnPresent () {
        postPresentsReturnJump({
          'gid': params['gid'] || ''
        }).then((res) => {
          window.location.href = res['web_data']['redirect_url']
        })
      }
    },
    created () {
      const requestParams = {
        'gid': params['gid'] || '',
        'openid': 'o9Vbtw1W0ke-eb0g6kE4SD1eh6qU'
      }
      getPresentsList(requestParams).then((res) => {
        const result = res['web_data']
        this.giftList = result['users']
        this.theme = `gift-theme_${result['theme_keyword']}`
        this.continueGive = parseInt(result['can_repeat'])
        this.status = parseInt(result['gift_status'])
        this.total = parseInt(result['total'])
        this.received = parseInt(result['get_count'])
        this.wish = result['message']
        if (this.giftList.length > 3) {
          this.initScroll()
        }
      })
    },
    components: {
      giftBg
    },
    data () {
      return {
        // 选择了哪个主题
        theme: '',
        // 祝福语
        wish: '身体健康',
        // 礼物列表
        giftList: [],
        // better-scroll
        scroll: null,
        // 是否允许继续赠送
        continueGive: '',
        // 赠送状态
        status: '',
        // 礼物的总数
        total: '',
        // 已领取
        received: ''
      }
    }
  }
</script>
