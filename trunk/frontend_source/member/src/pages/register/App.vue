<template>
  <div class="gradient_bg padding_bottom_30">
	<section>
		<div class="flex between padding_45 font_12 padding_0_15">
			<div class="margin_right_30 relative padding_left_35">
				<div class="line_left absolute top_65"><img class="line_height65" src="../../styles/postcss/image/line_03.png" alt=""></div>
				<div>
					<div class="font_30 jfk-font txt_show4 main_color1">马上注册</div>
					<div class="margin_top_20 center relative color_888">可获得注册大礼包，享受更多会员优惠</div>
				</div>
			</div>
		</div>
		<form class="form_list font_14 jfk-form" ref="form">
      <div class="white_bg padding_0_15">
  			<div v-for="(value,key) in configList" v-if="value.show === 1" :data="value.show" class="flex form_item bd_bottom padding_tb_15">
  				<div class="margin_right_22 width_75">
  					<div class="flex between">
  						<div class="margin_right_22 flex between" v-html="value.namehtml"></div>
  					</div>
          </div>
			    <div v-if="key === 'sex'" class="flex_1 bg_arrow form-item">
            <select class="font_15 color1 position_x form-item" :name="key">
              <option value="1" name="1">男</option>
              <option value="2" name="2">女</option>
              <option value="3" name="3">-</option>
            </select>
            <div class="form-item__status is-error" v-show="value.passed" @click="handleHiddenError(key)">
              <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
              <span class="form-item__status-tip">
                <i class="form-item__status-cont">{{value.message}}</i>
                <i class="form-item__status-trigger">重新输入</i>
              </span>
            </div>
          </div>
          <div v-else-if="key === 'birthday'" class="flex_1 bg_arrow form-item">
            <input class="font_14 color1" type="date" :name="key"  style="height: 20px;">
              <div class="form-item__status is-error" v-show="value.passed" @click="handleHiddenError(key)">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                  <i class="form-item__status-cont">{{value.message}}</i>
                  <i class="form-item__status-trigger">重新输入</i>
                </span>
              </div>
          </div>
          <div v-else class="flex_1 color1 form-item">
            <div class="form-item__body">
              <input class="font_14 color1" @keyup="setRemove($event)" :type="value.type" :name="key" :placeholder="value.note" @focus="handleHiddenError(key)">
              <div class="form-item__status is-error" v-show="value.passed" @click="handleHiddenError(key)">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                  <i class="form-item__status-cont">{{value.message}}</i>
                  <i class="form-item__status-trigger">重新输入</i>
                </span>
              </div>
            </div>
          </div>
          <div v-if="key === 'phonesms'" @click="smsSend" class="relative verification" :class="{verification_active:sms}">{{smsTitle}}</div>
  			</div>
      </div>
			<div class="margin_top_75 font_17 padding_0_15">
				<div class="block width_85 center btn_height entry_btn auto jfk-font gray_btn register" @click="submit()">注&ensp;册</div>
			</div>
			<div class="center margin_top_30 font_12 color3">已有账号？<span class="mar_l10"><a class="main_color1" :href="links.login">马上登录</a></span><em class="color3 mar_l10 jfk-font xx-small">&#xe61c;</em></a>
			</div>
		</form>
	</section>
  <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
import { JfkMessageBox } from 'jfk-ui'
import { getRegInfo, postReg, getSendsms } from '@/service/http'
export default {
  data () {
    return {
      configList: [],
      links: [],
      sms: true,
      smsTitle: '获取验证码',
      smsTime: 60,
      time: ''
    }
  },
  created () {
    getRegInfo().then((res) => {
      this.configList = res.web_data.login_config
      this.recombination()
      this.links = res.web_data.page_resource.links
    })
  },
  methods: {
    recombination () {
      for (let item in this.configList) {
        if (this.configList[item]['show'] === 1) {
          let nameArr = ''
          for (let i = 0; i < this.configList[item]['name'].length; i++) {
            nameArr += '<span class="block">' + this.configList[item]['name'][i] + '</span>'
          }
          this.configList[item]['namehtml'] = nameArr
        }
      }
    },
    submit () {
      let result = this.$refs.form
      let setDate = {}
      let setBol = true

      for (let item in this.configList) {
        if (this.configList[item].show === 0) {
          continue
        }
        if (result[[item]].value === '') {
          let thatMsg = this.configList[item]['name'] + '不能为空'
          this.configList[item] = Object.assign({}, this.configList[item], {'passed': true, 'message': thatMsg})
          setBol = false
          continue
        }
        if (this.configList[item].check === 1) {
          let str = '/' + this.configList[item].regular + '/'
          /* eslint-disable */let reg = eval(str)
          if (!reg.test(result[[item]].value)) {
            let thatMsg = '请输入正确的' + this.configList[item]['name'] 
            this.configList[item] = Object.assign({}, this.configList[item], {'passed': true, 'message': thatMsg})
            setBol = false
            continue
          }
        }
        if (result['password'].value.length < 6) {
          this.configList['password'] = Object.assign({}, this.configList['password'], {'passed': true, 'message': '登录密码不能少于6位'})
          setBol = false
          continue
        }
        setDate[[item]] = result[[item]].value 
      }

      if (setBol) {
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        postReg(setDate).then((res) => {
          this.toast.close()
          if (res.status === 1000) {
            JfkMessageBox.alert('注册成功', '', {
              iconType: 'success'
            }).then((res) => {
              window.location.href = this.links.login
            })
          } else {
            JfkMessageBox.alert(res.msg, '', {
              iconType: 'error'
            })
          }
        })
      }
    },
    smsSend () {
      if (this.sms) {
        let str = '/' + this.configList['phone'].regular + '/'
        let result = this.$refs.form
        /* eslint-disable */let reg = eval(str)
        if (!reg.test(result[['phone']].value)) {
          result['phone'].value = ''
          result['phone'].placeholder = '请输入正确的' + this.configList['phone'].name
          result['phone'].setAttribute('class', 'bg_ico_sigh')
        } else {
          let that = this
          let data = {
            phone: result['phone'].value,
            phonesms: result['phonesms'].value,
            smstype: 0
          }
          getSendsms(data).then((res) => {
            if (res.status === 1000) {
              JfkMessageBox.alert('短信已发送,请注意查收', '', {
                iconType: 'success'
              })
            } else {
              JfkMessageBox.alert(res.msg, '', {
                iconType: 'error'
              })
            }
          })
          that.time = setInterval(function() {
            that.checkSms()
          },1000)
        }
      }
    },
    checkSms () {
      if (this.smsTime === 0 ) {
        clearInterval(this.time)
        this.sms = true
        this.smsTitle = '获取验证码'
        this.smsTime = 60
      } else {
        this.sms = false
        this.smsTime--
        this.smsTitle = this.smsTime + '秒后再获取'
      }
    },
    setRemove (even) {
      even.target.className = ''
    },
    handleHiddenError (item) {
      this.configList[[item]].passed = false
      this.configList[[item]].message = ''
    }
  }
}
</script>
