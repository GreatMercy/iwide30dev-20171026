<template>
  <div class="jfk-pages jfk-pages__package-list">
    <div class="jfk-pages__theme"></div>

    <ul class="package-list">
      <li class="package-list__item">
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
                  <p class="name font-size--32">小狮子王A礼包</p>
                  <p class="validity font-size--24">有效期至2017年8月29日</p>
                  <p class="number font-size--24">剩余<span>100</span>份</p>
                  <button class="jfk-button jfk-button--primary is-plain font-size--30">
                    <span>生成礼包</span>
                  </button>
                </div>
              </div>
            </div>

            <ul class="jfk-package-info__more-info">
              <li class="jfk-flex">
                <span class="jfk-ta-l font-size--28">自助餐</span>
                <span class="jfk-ta-r font-size--28">1份</span>
              </li>
              <li class="jfk-flex">
                <span class="jfk-ta-l font-size--28">儿童乐园门票</span>
                <span class="jfk-ta-r font-size--28">1份</span>
              </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>


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
                  <p class="font-color-white">创建人</p>
                </div>
              </label>
            </div>

          </form>
        </div>


        <div class="btn">
          <button class="jfk-button jfk-button--primary is-plain jfk-button--free font-size--32"
                  @click="getCode">
              <span class="jfk-button__text">
                <i class="jfk-font jfk-button__text-item icon-font_zh_sheng_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_cheng_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_ling_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_qu_qkbys1"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_er_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_wei_qkbys1"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_ma_qkbys"></i>
              </span>
          </button>
        </div>

      </div>
    </jfk-popup>


  </div>
</template>

<script>
  import validator from 'jfk-ui/lib/validator.js'
  export default {
    components: {},
    computed: {},
    methods: {
      getCode () {
        // console.log('111')
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
          console.log('hahah')
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
      }
    },
    created () {
    },
    data () {
      return {
        verificationVisible: true,
        form: {
          reservationInfo: '',
          number: '',
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
