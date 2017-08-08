<template>
  <div class="jfk-pages jfk-pages__gift-list" :class="theme">
    <div class="jfk-pages__theme" v-if="!theme">
      <div class="jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
    </div>

    <template v-if="theme">

      <gift-bg :wish="wish" v-if="wish"></gift-bg>

      <template>
        <gift-list :list="giftList"></gift-list>
      </template>

    </template>

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

  </div>
</template>
<script>
  import giftBg from '@/components/gift/gift_background'
  import giftList from '@/components/gift/gift_list'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  const params = formatUrlParams.default(location.href)
  import { getPresentsReceivedList, postPresentsReturnJump } from '@/service/http'
  export default {
    components: {
      giftList,
      giftBg
    },
    data () {
      return {
        // 选择了哪个主题
        theme: '',
        // 礼物列表
        giftList: [],
        // 祝福语
        wish: '',
        // 总数
        total: '',
        // 已领取
        received: '',
        // 状态
        status: '',
        // 是否允许继续赠送
        continueGive: ''
      }
    },
    methods: {
      // 点击继续赠送礼物
      continueGivePresent () {
        this.$jfkConfirm('继续赠送给不同朋友，礼物将送给先打开的好友').then(() => {
        }).catch(() => {
          const wx = window.wx
          if (wx) {
            wx.showMenuItems({
              menuList: ['menuItem:share:appMessage', 'menuItem:share:timeline']
            })
          }
          this.$jfkToast('出现微分享弹窗，以后统一处理')
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
        'gid': params['gid'] || ''
      }
      getPresentsReceivedList(requestParams).then((res) => {
        const result = res['web_data']
        this.giftList = result['users']
        this.theme = `gift-theme_${result['theme_keyword']}`
        this.continueGive = parseInt(result['can_repeat'])
        this.status = parseInt(result['gift_status'])
        this.total = parseInt(result['total'])
        this.received = parseInt(result['get_count'])
        this.wish = result['message']
      })
    }
  }
</script>
