<template>
  <div class="gradient_bg form-top">
  <section class="padding_0_15">
    <form class="form_list font_14 jfk-form" ref="form">
      <div v-for="(value,key) in configList" v-if="value.show === 1" :data="value.show" class="flex form_item bd_bottom padding_18">
        <div class="margin_right_22 width_75">
          <div class="flex between">
            <div class="margin_right_22 flex between" v-html="value.namehtml"></div>
          </div>
        </div>
        <div class="flex_1 font_15 form-item">
           <div class="form-item__body">
             <input @keyup="setRemove($event)" :type="value.type" :name="key" :placeholder="value.note">
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
      <div class="margin_top_35 font_17">
        <a class="block width_85 center btn_height auto jfk-font entry_btn reset" @click="submit()">&#xe608;&ensp;&#xe60a;</a>
      </div>
    </form>
  </section>
  <JfkSupport v-once></JfkSupport>
</div>
</template>
<script>
import { JfkMessageBox } from 'jfk-ui'
import { getResetpswInfo, postResetpswSave, getSendsms } from '@/service/http'
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
    getResetpswInfo().then((res) => {
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
          let thatMsg = '不能为空'
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
        setDate[[item]] = result[[item]].value 
      }

      if (setBol) {
        postResetpswSave(setDate).then((res) => {
          if (res.status === 1000) {
            JfkMessageBox.alert(res.msg, '', {
              iconType: 'success'
            }).then(() => {
              window.location.href = res.web_data.page_resource.links.next
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
            smstype: 4
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

