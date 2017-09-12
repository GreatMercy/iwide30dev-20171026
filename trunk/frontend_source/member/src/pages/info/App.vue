<template>
  <div class="gradient_bg form-top">
    <section >
      <form class="form_list font_14 jfk-form" ref="form">
        <div class="white_bg padding_0_15">
          <div class="form_item bd_bottom padding_18" v-for="(value,key) in configList"  v-if="value.show === 1" :data="value.show">
            <div class="flex">
              <div class="margin_right_22 width_120 flex between" v-html="value.namehtml"></div>
              <div v-if="key === 'sex'" class="flex_1 bg_arrow">
                <select class="font_15 color1 position_x form-item" :value="value.value" :name="key" :disabled="view">
                  <option value="1" name="1">男</option>
                  <option value="2" name="2">女</option>
                  <option value="3" name="3">-</option>
                </select>
              </div>
              <div v-else-if="key === 'birthday'" class="flex_1 bg_arrow form-item">
                <input class="font_14 color1" type="date" :name="key" :disabled="view"  :value="value.value" style="height: 20px;">
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
                  <input class="font_14 color1"  :disabled="view" @keyup="setRemove($event)" :value="value.value" :type="value.type" :name="key" placeholder="-">
                  <div class="form-item__status is-error" v-show="value.passed" @click="handleHiddenError(key)">
                    <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                    <span class="form-item__status-tip">
                      <i class="form-item__status-cont">{{value.message}}</i>
                      <i class="form-item__status-trigger">重新输入</i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="margin_top_75 font_17" v-show="configList.length !== 0">
          <a class="block width_85 center btn_height auto jfk-font entry_btn font_spacing_1 preservation" @click="submit" v-show="!view">{{saveText}}</a>
          <a class="block width_85 center btn_height auto jfk-font entry_btn font_spacing_1" @click="perfectinfoInfo" v-show="view">{{postText}}</a>
        </div>
        <div class="center margin_top_30" v-if="centerInfo.value === 'login' && view === true">
          <div class="font_14" @click="outLogin"><span class="main_color1">退出登录</span></div>
        </div>
      </form>
    </section>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<style>
  
</style>
<script>
import { getMemberInfo, getPerfectinfoInfo, postPerfectinfoSave, outLogin } from '@/service/http'
import { JfkMessageBox } from 'jfk-ui'
export default {
  data () {
    return {
      configList: [],
      centerInfo: [],
      links: [],
      view: true,
      change: true,
      save: true
    }
  },
  created () {
    this.getInfo()
  },
  methods: {
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
        setDate[[item]] = result[[item]].value 
      }

      if (setBol) {
        this.save = false
        this.binddata(setDate)
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        postPerfectinfoSave(setDate).then((res) => {
          this.toast.close()
          this.save = true
          if (res.status === 1000) {
            JfkMessageBox.alert('保存成功', '', {
              iconType: 'success'
            })
            this.view = true
          } else {
            JfkMessageBox.alert(res.msg, '', {
              iconType: 'error'
            })
            this.view = false
          }
        })
      }
    },
    binddata (value) {
      for (let item in value) {
        this.configList[[item]].value = value[item]
      }
    },
    recombination () {
      // 重组数据
      for (let item in this.configList) {
        if (this.configList[item]['show'] === 1) {
          let nameArr = ''
          for (let i = 0; i < this.configList[item]['name'].length; i++) {
            nameArr += '<span class="block">' + this.configList[item]['name'][i] + '</span>'
          }
          this.configList[item]['namehtml'] = nameArr
          switch (item) {
            case 'name':
              if (this.centerInfo.name !== '微信用户') {
                this.configList[item].value = this.centerInfo.name
              }
              break
            case 'phone':
              this.configList[item].value = this.centerInfo.cellphone
              break
            case 'email':
              this.configList[item].value = this.centerInfo.email
              break
            case 'sex':
              this.configList[item].value = this.centerInfo.sex
              break
            case 'birthday':
              this.configList[item].value = this.centerInfo.birth_date !== '' ? this.centerInfo.birth_date : ''
              break
            case 'idno':
              this.configList[item].value = this.centerInfo.id_card_no
              break
          }
        }
      }
    },
    getInfo () {
      if (this.save) {
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        getMemberInfo().then((res) => {
          this.configList = res.web_data.modify_config
          this.centerInfo = res.web_data.centerinfo
          this.recombination()
          this.links = res.web_data.page_resource.links
          this.view = true
          this.toast.close()
        })
      }
    },
    perfectinfoInfo () {
      if (this.change) {
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        this.change = false
        getPerfectinfoInfo().then((res) => {
          this.configList = res.web_data.modify_config
          this.centerInfo = res.web_data.centerinfo
          this.recombination()
          this.view = false
          this.change = true
          this.toast.close()
        })
      }
    },
    setRemove (event) {
      event.target.className = ''
    },
    outLogin () {
      outLogin().then((res) => {
        if (res.status === 1000) {
          window.location.href = res.web_data.page_resource.links.login
        } else {
          JfkMessageBox.alert(res.msg, '', {
            iconType: 'error'
          })
        }
      })
    },
    handleHiddenError (item) {
      this.configList[[item]].passed = false
      this.configList[[item]].message = ''
    }
  },
  computed: {
    postText () {
      return `${this.change ? '修改资料' : '请稍后...'}`
    },
    saveText () {
      return `${this.save ? '保存' : '保存中...'}`
    }
  }
}
</script>
