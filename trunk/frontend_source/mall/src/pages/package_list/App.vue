<template>
  <div class="jfk-pages jfk-pages__package-list">
    <div class="jfk-pages__theme"></div>

    <ul class="package-list" v-if="packageList.length > 0"
        v-infinite-scroll="loadMore"
        infinite-scroll-disabled="disableLoadPackage"
        infinite-scroll-distance="0">
      <li class="package-list__item" v-for="(item, index) in packageList" :key="index">
        <div class="jfk-package-info jfk-pl-30 jfk-pr-30">
          <div class="jfk-package-info__content">
            <div class="jfk-package-info__base-info">
              <div class="jfk-package-info__base-info--left">
                <div class="jfk-package-info__base-info--title jfk-flex is-align-middle is-justify-center">
                  <i class="jfk-font  icon-font_zh_li_1_qkbys"></i>
                </div>
              </div>
              <div class="jfk-package-info__base-info--right">
                <div class="jfk-package-info__base-info--content">
                  <p class="name font-size--32" v-text="item.name"></p>
                  <p class="validity font-size--24" v-text="'有效期至' + item.end_time"></p>
                  <p class="number font-size--24">剩余<span v-text="item.stock" class="color-golden"></span>份</p>
                  <button class="jfk-button jfk-button--primary is-plain font-size--30"
                          @click="generateGiftPackage(item.gift_id)">
                    <span>生成礼包</span>
                  </button>
                </div>
              </div>
            </div>
            <ul class="jfk-package-info__more-info" v-if="item && item.child_product_info"
                v-for="(value, index) in item.child_product_info" :key="index">
              <li class="jfk-flex" v-if="index <= 10">
                <span class="jfk-ta-l font-size--28" v-text="value.name"></span>
                <span class="jfk-ta-r font-size--28" v-text="value.num"></span>
              </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>

    <div class="package-list__loading font-size--24 jfk-ta-c" :class="{'package-list__show': disableLoadPackage}">
      <span class="jfk-loading__triple-bounce color-golden font-size--24">
        <i class="jfk-loading__triple-bounce-item"></i>
        <i class="jfk-loading__triple-bounce-item"></i>
        <i class="jfk-loading__triple-bounce-item"></i>
      </span>
    </div>


    <jfk-popup v-model="verificationVisible" ref="popupService" class="jfk-popup__service" :showCloseButton="true">
      <div class="popup-box">
        <div class="title font-size--30 font-color-white jfk-ta-c">服务说明</div>

        <div class="package-form">

          <form class="jfk-form font-size--28">

            <div class="form-item">
              <label>
                <span class="form-item__label  font-color-extra-light-gray">登记信息</span>
                <div class="form-item__body">
                  <input type="text" class="font-color-white" placeholder="房间号/预订号" v-model="form.reservationInfo">
                  <div class="form-item__status is-error" v-show="validResult.reservationInfo.show"
                       @click="handleHiddenError('reservationInfo')">
                    <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                    <span class="form-item__status-tip">
                      <i class="form-item__status-cont" v-text="validResult.reservationInfo.message"></i>
                  </span>
                  </div>
                </div>
              </label>
            </div>

            <div class="form-item">
              <label>
                <span class="form-item__label  font-color-extra-light-gray">
                  <i>数</i><span
                  class="form-item__label--word-4"></span><i>量</i></span>
                <div class="form-item__body">
                  <input type="text" class="font-color-white" placeholder="购买数量" v-model="form.number">

                  <div class="form-item__status is-error" v-show="validResult.number.show"
                       @click="handleHiddenError('number')">
                    <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                    <span class="form-item__status-tip">
                      <i class="form-item__status-cont" v-text="validResult.number.message"></i>
                   </span>
                  </div>

                </div>
              </label>
            </div>

            <div class="form-item">
              <label>
                <span class="form-item__label  font-color-extra-light-gray">
                  <i>其</i><span
                  class="form-item__label--word-4"></span><i>他</i>
                </span>
                <div class="form-item__body">
                  <input type="text" class="font-color-white" placeholder="" v-model="form.other">
                </div>
              </label>
            </div>


            <div class="form-item">
              <label>
                <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">创建人</span>
                <div class="form-item__body">
                  <p class="font-color-white" v-text="salerName"></p>
                </div>
              </label>
            </div>

          </form>
        </div>


        <div class="btn">
          <button class="jfk-button jfk-button--primary is-special jfk-button--free font-size--32"
                  @click="getCode">
            <span>生成领取二维码</span>
          </button>
        </div>

      </div>
    </jfk-popup>

    <jfk-support v-once></jfk-support>

  </div>
</template>

<script>
  import validator from 'jfk-ui/lib/validator.js'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  const params = formatUrlParams.default(location.href)
  import { getGiftPackageList, postGenerateGift } from '@/service/http'
  export default {
    components: {},
    computed: {},
    methods: {
      // 点击生成二维码
      getCode () {
        let rules = this.rules
        let passed = true
        for (let i in rules) {
          let r = validator(this.getFormItemVal(i), rules[i])
          this.validResult = Object.assign({}, this.validResult, {
            [i]: {
              ...r,
              show: !r.passed
            }
          })
          if (!r.passed) {
            passed = false
          }
        }
        if (passed) {
          this.toast = this.$jfkToast({
            duration: -1,
            iconClass: 'jfk-loading__snake',
            isLoading: true
          })
          let parameter = {
            'gift_id': this.giftId || '',
            'inter_id': params['inter_id'] || '',
            'saler_id': params['saler_id'] || '',
            'saler_name': params['saler_name'] || '',
            'gift_num': this.form.number || '',
            'record_info': this.form.reservationInfo || '',
            'orther_remark': this.form.other || ''
          }
          postGenerateGift(parameter).then((res) => {
            if (process.env.NODE_ENV === 'development') {
              const urlParams = formatUrlParams.default(res['web_data']['page_resource']['link']['gift_detail'])
              window.location.href = `/scan_receive?inter_id=${urlParams['inter_id']}&gift_detail_id=${urlParams['gift_detail_id']}&request_token=${urlParams['request_token']}`
            } else {
              window.location.href = res['web_data']['page_resource']['link']['gift_detail']
            }
            this.toast.close()
          }).catch(() => {
            this.toast.close()
          })
        }
      },
      getFormItemVal (key) {
        switch (key) {
          case 'reservationInfo':
            return this.form.reservationInfo
          case 'number':
            return this.form.number
          case 'other':
            return this.form.other
          default:
            return ''
        }
      },
      handleHiddenError (type) {
        this.validResult = Object.assign({}, this.validResult, {
          [type]: {
            show: false
          }
        })
      },
      // 点击生成礼包
      generateGiftPackage (id) {
        // 重置数据
        this.form.reservationInfo = ''
        this.form.number = '1'
        this.form.other = ''
        this.giftId = id
        this.salerName = params['saler_name'] || ''
        this.validResult.reservationInfo.show = false
        this.validResult.number.show = false
        this.validResult.other.show = false
        this.verificationVisible = true
      },
      // 获取数据
      getData () {
        const removeLoading = () => {
          try {
            this.toast.close()
            this.disableLoadPackage = false
            this.page += 1
          } catch (e) {
            console.log(e)
          }
        }
        getGiftPackageList({
          'saler_id': params['saler_id'] || '',
          'inter_id': params['inter_id'] || '',
          'page': this.page
        }).then((res) => {
          if (res['web_data'].length === 0) {
            this.more = false
          }
          for (let i = 0; i < res['web_data'].length; i++) {
            this.packageList.push(res['web_data'][i])
          }
          this.$nextTick(() => {
            removeLoading()
          })
        }).catch(() => {
          removeLoading()
        })
      },
      // 加载更多
      loadMore () {
        if (this.more) {
          this.disableLoadPackage = true
          this.getData()
        }
      }
    },
    created () {
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
      this.$pageNamespace(params)
      this.getData()
    },
    data () {
      return {
        verificationVisible: false,
        packageList: [],
        giftId: '',
        disableLoadPackage: false,
        salerName: '',
        more: true,
        page: 1,
        form: {
          reservationInfo: '',
          number: '1',
          other: ''
        },
        rules: {
          reservationInfo: [{
            required: true, message: '请输入登记信息'
          }],
          number: [{
            required: true, message: '请输入数量'
          }, {
            type: 'integer', message: '请输入正确的数量'
          }]
        },
        validResult: {
          reservationInfo: {
            passed: false,
            message: ''
          },
          number: {
            passed: false,
            message: ''
          },
          other: {
            passed: true,
            message: ''
          }
        }
      }
    }
  }
</script>
