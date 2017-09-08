<template>
  <div class="jfk-pages jfk-pages__send-gift">
    <div class="jfk-pages__theme "></div>
    <div class="title jfk-ta-c font-size--30">赠送内容</div>
    <div class="jfk-pl-30 jfk-pr-30">

      <div class="goods-info  jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image">
        <a href="javascript:void(0)">

          <img v-if="giftInfo.face_img" :src="giftInfo.face_img">

          <div class="goods-info-mask"></div>

          <div class="goods-info-content">

            <div class="goods-info-desc jfk-flex is-align-middle">

              <div class="font-size--30 goods-info-desc__packname" v-if="giftInfo.name" v-html="giftInfo.name"></div>

              <div class="goods-info-desc__price jfk-ta-r" v-if="giftInfo.residue === 1 || giftInfo.residue === 1">
                <span class="jfk-price font-size--54">
                  <i class="jfk-font-number jfk-price__currency">￥</i>
                  <i class="jfk-font-number jfk-price__number" v-html="giftInfo.price_package"></i>
                </span>
                <span class="font-size--24 jfk-d-ib goods-info-desc__price-number">1份</span>
              </div>

              <div class="goods-info-desc__goods_number jfk-ta-r" v-if="giftInfo.residue > 1">
                <span class="goods-info-desc__title font-size--24">送出</span>
                <span class="goods-info-desc__number font-size--24"
                      v-if="giftInfo.send_out_number >=0 "
                      v-html="giftInfo.send_out_number + '份'"></span>
                <span class="goods-info-desc__line jfk-d-ib"></span>
                <span class="goods-info-desc__title font-size--24">剩余</span>
                <span class="goods-info-desc__number font-size--24" v-if="giftInfo.qty"
                      v-html="giftInfo.qty + '份'"></span>
              </div>

            </div>
          </div>
        </a>
      </div>

      <ul class="gift-info">

        <li class="gift-info__item jfk-flex is-align-middle" v-if="giftInfo.residue > 1">
          <div class="gift-info-title font-size--28">收礼人数</div>
          <div class="gift-info-content jfk-ta-r">
            <div class="gift-info-content__number-input jfk-d-ib font-size--32">
              <jfk-input-number :min="1" :value="giftsPersonNumber" v-model.number="giftsPersonNumber"
                                :max="giftsPersonMax"></jfk-input-number>
            </div>
            <div class="gift-info-content__unit font-size--32 jfk-d-ib">人</div>
          </div>
        </li>

        <li class="gift-info__item jfk-flex is-align-middle" v-if="giftInfo.residue > 1">
          <div class="gift-info-title font-size--28">每人收到</div>
          <div class="gift-info-content jfk-ta-r">

            <div class="gift-info-content__number-input jfk-d-ib font-size--32">
              <jfk-input-number :min="1" :value="giftsAverageNumber" :max="giftsAverageMax"
                                v-model.number="giftsAverageNumber"></jfk-input-number>
            </div>

            <div class="gift-info-content__unit font-size--32 jfk-d-ib">份</div>
          </div>
        </li>

        <li class="gift-info__item jfk-flex is-align-middle" @click="choiceTheme">
          <div class="gift-info-title font-size--28">礼包主题</div>
          <div class="gift-info-theme">
            <span v-if="giftCurrentTheme.id" v-html="giftCurrentTheme.name" class="font-size--30"></span>
            <i class="jfk-d-ib jfk-font icon-user_icon_jump_normal"></i>
          </div>
        </li>

        <li class="gift-info__item jfk-flex is-align-middle">
          <input type="text" class="gift-info-wish font-size--30" placeholder="请输入您对祝福语" v-model="wish">
        </li>

      </ul>

      <div class="button-box">
        <button class="jfk-button jfk-button--default jfk-button--primary is-special" @click="give">确定赠送</button>
      </div>

      <a :href="giftInfo.order_list_url || 'javascript:void(0)'" class="jfk-ta-c font-size--28 gift-put-order" v-if="giftInfo.order_list_url">
        暂不处理，放至订单中心<i class="jfk-d-ib jfk-font icon-user_icon_jump_normal"></i>
      </a>

    </div>

    <jfk-support v-once></jfk-support>

  </div>
</template>
<script>
  import { JfkMessageBox } from 'jfk-ui'
  import { mapActions, mapGetters } from 'vuex'
  import { postPresentsSendOut } from '@/service/http'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    components: {},
    beforeCreate () {
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
    },
    created () {
      this.getGiftInfo().then(() => {
        this.toast.close()
        this.setMax(this.giftsPersonNumber, this.giftsAverageNumber)
      }).catch(() => {
        this.toast.close()
      })
    },
    computed: {
      ...mapGetters([
        'giftInfo',
        'giftCurrentTheme'
      ])
    },
    data () {
      return {
        // 祝福语
        wish: '送您一份礼物',
        giftsPersonNumber: 1, // 收礼的人数
        giftsPersonMax: 1, // 收礼的人数最大数值
        giftsAverageNumber: 1, // 每人多少盒
        giftsAverageMax: 1 // 每人多少盒的最大值
      }
    },
    watch: {
      giftsPersonNumber (val) {
        if (val) {
          this.setMax(this.giftsPersonNumber, this.giftsAverageNumber)
        }
      },
      giftsAverageNumber (val) {
        if (val) {
          this.setMax(this.giftsPersonNumber, this.giftsAverageNumber)
        }
      }
    },
    methods: {
      ...mapActions([
        'getGiftInfo'
      ]),
      setMax (personNumber, averageNumber) {
        this.giftsPersonMax = parseInt(this.giftInfo['residue'] / averageNumber)
        this.giftsAverageMax = parseInt(this.giftInfo['residue'] / personNumber)
      },
      // 选择主题
      choiceTheme () {
        this.$router.push({path: '/themes'})
      },
      // 确定赠送
      give () {
        // 判断是否选择主题
        if (String(this.giftCurrentTheme['id']).trim().length === 0) {
          this.$jfkToast('请选择礼包主题')
          return false
        }
        // 判断是否输入祝福语
        if (this.wish.length === 0) {
          this.$jfkToast('请输入您对祝福语')
          return false
        }
        // 提示的文案
        let msg = ''
        // 确认赠送提交参数
        let parameter = {
          // 祝福语
          'msg': this.wish,
          // 主题的id
          'tid': this.giftCurrentTheme['id'],
          // 收礼人数
          'count_give': this.giftsPersonNumber,
          // 发出礼盒数，每人多少盒
          'per_give': this.giftsAverageNumber,
          'aiids': [
            {
              'aiid': params['aiid'] || '',
              'qty': this.giftsPersonNumber * this.giftsAverageNumber
            }
          ]
        }
        // 确定赠送
        if (this.giftInfo['residue'] > 1) {
          msg = `${this.giftInfo['residue']}份礼物将被${this.giftsPersonNumber}人领取，每人${this.giftsAverageNumber}份，超过24未领取将退回`
        } else if (this.giftInfo['residue'] === 0 || this.giftInfo['residue'] === 1) {
          msg = `1份礼物将被1人领取，超过24未领取将退回`
        }
        // 确认提交
        JfkMessageBox({
          message: msg,
          showConfirmButton: true,
          showCancelButton: true,
          confirmButtonText: '确定',
          cancelButtonText: '重新填写'
        }).then((res) => {
          if (res === 'confirm') {
            this.toast = this.$jfkToast({
              duration: -1,
              iconClass: 'jfk-loading__snake',
              isLoading: true
            })
            const wx = window.wx
            postPresentsSendOut(parameter).then((res) => {
              const content = res['web_data']['wx_config']
              const wxConfig = {
                title: content['title'],
                link: content['link'],
                imgUrl: content['img_url'],
                success: function () {
                  location.href = content['redirect_url']
                },
                cancel: function () {
                }
              }
              if (wx) {
                wx.onMenuShareTimeline(wxConfig)
                wx.onMenuShareAppMessage(wxConfig)
                wx.showMenuItems({
                  menuList: content['js_menu_show']
                })
              }
              this.$jfkShare()
              this.toast.close()
            }).catch(() => {
              this.toast.close()
            })
          }
        })
      }
    }
  }
</script>
