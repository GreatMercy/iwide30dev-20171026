<template>
  <div class="gradient_bg form-top">
	<section>
		<form class="form_list font_14 jfk-form" ref=form>
      <div class="white_bg padding_0_15">
  			<div  v-for="(value,key) in configList" v-if="value.show === 1" :data="value.show" class="flex form_item bd_bottom padding_tb_15">
  				<div class="margin_right_22 width_75">
  					<div class="flex between">
              <div class="margin_right_22 flex between" v-html="value.namehtml"></div>
            </div>
  				</div>
  				<div class="flex_1 font_14 form-item">
            <div class="form-item__body">
              <input @keyup="setRemove($event)" :type="value.type" :name="key" :placeholder="value.note" maxlength="20"  @focus="handleHiddenError(key)">
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
			<div class="pad_top40 font_17">
				<a class="block width_85 center btn_height auto jfk-font entry_btn land_btn" @click="submit()">登&ensp;录</a>
			</div>
      <div class="overflow">
  			<div class="center margin_top_30 font_12 float" style="margin-left: 7%;"><a :href="link.reg" class="main_color1">马上注册</a><em class="jfk-font xx-small color_707070">&#xe61c;</em>
  			</div>
        <div class="center margin_top_30 font_12 floatr" style="margin-right: 7%;"><a :href="link.resetpassword" class="main_color1">忘记密码?</a>
        </div>
      </div>
		</form>
		<div class="flex layer_bg padding_14 radius_3 margin_top_58 margin_bottom_40 centers padding_0_23">
			<div class="margin_right_23"><em class="jfk-font main_color1 txt_show6 fontw40">&#xe62a;</em></div>
			<div class="font_12 color1">注册可获得注册<font class="main_color1">大礼包</font>,享受更多<font class="main_color1">会员优惠</font>!</div>
		</div>
	</section>
  <JfkSupport v-once></JfkSupport>
</div>
</template>
<script>
import { JfkMessageBox } from 'jfk-ui'
import { getLoginInfo, postLogin, getSendsms } from '@/service/http'
export default {
  data () {
    return {
      configList: [],
      link: [],
      sms: true,
      smsTitle: '获取验证码',
      smsTime: 60,
      time: ''
    }
  },
  created () {
    getLoginInfo().then((res) => {
      this.configList = res.web_data.login_config
      this.recombination()
      this.link = res.web_data.page_resource.links
    })
  },
  methods: {
    recombination () {
      for (let item in this.configList) {
        if (this.configList[item]['show'] === 1) {
          this.configList[item]['passed'] = false
          this.configList[item]['message'] = ''
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
        postLogin(setDate).then((res) => {
          this.toast.close()
          if (res.status === 1000) {
            window.location.href = res.web_data.page_resource.links.next
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
            smstype: 2
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
