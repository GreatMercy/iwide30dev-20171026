<template>
  <div class="jfk-address jfk-form font-size--28">
    <div class="jfk-address__add jfk-pl-30 jfk-pr-30" v-show="showAdd">
      <form class="jfk-address-form">
        <div class="form-item">
          <label>
            <span class="form-item__label form-item__label--word-3 font-color-extra-light-gray">收件人</span>
            <div class="form-item__body">
              <input type="text" class="font-color-white" v-model="addressPicked.contact" placeholder="请输入收件人"/>
              <div class="form-item__status is-error" v-show="validResult.contact.show"
                   @click="handleHiddenError('contact')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                    <i class="form-item__status-cont">{{validResult.contact.message}}</i>
                    <i class="form-item__status-trigger">重新输入</i>
                  </span>
              </div>
            </div>
          </label>
        </div>
        <div class="form-item">
          <label>
            <span class="form-item__label font-color-extra-light-gray">收件电话</span>
            <div class="form-item__body">
              <input type="text"
                     v-model="addressPicked.phone" class="font-color-white" placeholder="请输入收件人手机号码"/>
              <div class="form-item__status is-error" v-show="validResult.phone.show"
                   @click="handleHiddenError('phone')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                    <i class="form-item__status-cont">{{validResult.phone.message}}</i>
                    <i class="form-item__status-trigger">重新输入</i>
                  </span>
              </div>
            </div>
          </label>
        </div>
        <div class="form-item form-item__select">
          <span class="form-item__label  font-color-extra-light-gray">收件地址</span>
          <div class="form-item__body" @click="handleShowAddressSelect">
            <p class="tip font-color-light-gray" v-show="!addressPickedDetail">请选择收件区域</p>
            <p class="tip font-color-white" v-show="addressPickedDetail">{{addressPickedDetail}}</p>
            <div class="form-item__status is-error" v-show="validResult.area.show" @click="handleHiddenError('area')">
              <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
              <span class="form-item__status-tip">
                <i class="form-item__status-cont">{{validResult.area.message}}</i>
                <i class="form-item__status-trigger">重新输入</i>
              </span>
            </div>
          </div>
          <span class="form-item__foot"><i class="jfk-font icon-user_icon_jump_normal font-color-extra-light-gray"></i></span>
        </div>
        <div class="form-item">
          <label>
            <span class="form-item__label font-color-extra-light-gray">详细地址</span>
            <div class="form-item__body">
              <input type="text"
                     v-model="addressPicked.address" class="font-color-white" placeholder="如街道、楼层等"/>
              <div class="form-item__status is-error" v-show="validResult.address.show"
                   @click="handleHiddenError('address')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                  <i class="form-item__status-cont">{{validResult.address.message}}</i>
                  <i class="form-item__status-trigger">重新输入</i>
                </span>
              </div>
            </div>
          </label>
        </div>
      </form>
      <div class="jfk-address__add-control">
        <a href="javascript:;" class="jfk-button--free jfk-button jfk-button--primary is-plain"
           @click="handleSaveAddress">保存</a>
      </div>
    </div>
    <div class="jfk-address__list jfk-pl-30 jfk-pr-30" v-show="!showAdd">
      <ul class="jfk-address__list-box" :style="{'max-height': maxHeight}">
        <li
          v-for="item in addressItems"
          :key="item.address_id"
          class="jfk-address__list-item jfk-pt-30">
          <div class="jfk-radio jfk-radio--shape-rect color-golden">
            <label class="jfk-radio__label">
              <input type="radio"
                     :checked="item.address_id === aid"
                     v-model="aid"
                     :value="item.address_id"/>
              <div class="jfk-radio__text" @click="handlePickAddress(item.address_id)">
                <div class="jfk-address__list-item-cont jfk-flex is-align-middle">
                  <div class="address-item-box">
                    <div class="address-item-cont font-color-white">
                      <span class="contact">{{item.contact}}</span>
                      <span class="phone">{{item.phone}}</span>
                    </div>
                    <div class="address-item-cont font-color-extra-light-gray">
                      {{(item.provice_name || '') + (item.city_name || '') + (item.region_name || '') + (item.address || '')}}
                    </div>
                  </div>
                  <div class="address-item-edit jfk-flex is-align-middle is-justify-center"
                       @click.prevent.stop="handleEditAddress(item.address_id)"><i
                    class="edit-icon jfk-font icon-mall_icon_edit color-golden"></i></div>
                </div>
              </div>
              <span class="jfk-radio__icon"><i
                class="jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"></i></span>
            </label>
          </div>
        </li>
      </ul>
      <div class="jfk-address__list-control">
        <a href="javascript:;" @click="handleAddAddress"
           class="jfk-button jfk-button--primary jfk-button-higher jfk-button--free"><i
          class="jfk-address__list-icon jfk-d-ib">+</i><i class="jfk-d-ib">新增收货地址</i></a>
      </div>
    </div>
    <div v-show="loading">正在加载</div>
    <jfk-popup class="jfk-actionsheet jfk-actionsheet__address" :closeOnClickModal="false" position="bottom"
               v-model="actionsheetVisible">
      <address-select :ids="addressRegionIds" @address-data-loaded="handleAddressLoaded"
                      @address-picked="handleAddressPicked"></address-select>
    </jfk-popup>
  </div>
</template>
<script>
  /* eslint-disable camelcase */
  import { postExpressSave } from '@/service/http'
  import validator from 'jfk-ui/lib/validator.js'
  const defaultAddressProps = {
    province: '',
    city: '',
    region: '',
    contact: '',
    phone: '',
    address: ''
  }
  export default {
    name: 'jfk-address',
    components: {
      'address-select': () => import('./list.vue')
    },
    data () {
      const areaValidator = () => {
        return this.addressPicked.province
      }
      return {
        aid: '-1',
        eaid: '-1',
        isEditing: false,
        loading: false,
        actionsheetVisible: false,
        addressDataLoaded: false,
        addressPicked: {},
        addressRegionIds: [],
        rules: {
          contact: [{required: true, message: '收件人为空'}, {max: 10, length: true, message: '收件人必须在10个字符内'}],
          phone: [{required: true, message: '收件电话为空'}, {type: 'phone', message: '手机号码错误'}],
          area: [{validator: areaValidator, message: '收件地址为空'}],
          address: [{required: true, message: '详细地址为空'}]
        },
        validResult: {
          contact: {
            passed: false,
            message: ''
          },
          phone: {
            passed: false,
            message: ''
          },
          area: {
            passed: false,
            message: ''
          },
          address: {
            passed: false,
            message: ''
          }
        }
      }
    },
    beforeCreate () {
      this.maxHeight = (window.innerHeight - 50 - 15) + 'px'
    },
    created () {
      this.aid = this.addressId
      if (!this.address.length) {
        this.isEditing = true
      }
    },
    computed: {
      showAdd () {
        if (!this.addressDataLoaded) {
          this.loading = true
        }
        if (!this.address.length) {
          return true
        }
        if (this.isEditing) {
          return true
        }
        return false
      },
      addressPickedDetail () {
        const {province_name = '', city_name = '', region_name = ''} = this.addressPicked
        return province_name + city_name + region_name
      },
      addressItems: {
        get () {
          return this.address
        },
        set (val) {
          this.$emit('update:address', val)
        }
      }
    },
    watch: {
      isEditing (val) {
        if (val) {
          let result = Object.assign({}, defaultAddressProps)
          const {eaid, address} = this
          if (eaid !== '-1' && address.length) {
            let d = address.filter(function (dd) {
              return dd.address_id === eaid
            })
            result = Object.assign(result, d[0])
          }
          this.addressPicked = result
        }
      },
      addressId (val) {
        this.aid = val
      },
      showAddressList (val) {
        // history.back(-1)后需要由外面强制显示列表
        if (val && this.addressItems.length) {
          this.eaid = '-1'
          this.isEditing = false
        }
      }
    },
    methods: {
      handleEditAddress (aid) {
        this.isEditing = true
        this.eaid = aid
      },
      checkForm () {
        let d = this.addressPicked
        let rules = this.rules
        let that = this
        let passed = true
        for (let i in rules) {
          let r = validator(d[i], rules[i])
          that.validResult = Object.assign({}, that.validResult, {
            [i]: {
              ...r,
              show: !r.passed
            }
          })
          if (!r.passed) {
            passed = false
          }
        }
        return passed
      },
      handleSaveAddress () {
        let passed = this.checkForm()
        if (!passed) {
          return
        }
        let that = this
        let address = this.addressPicked
        let addressItems = this.addressItems
        let aid = address.address_id
        let data = Object.assign({}, address)
        let toast = this.$jfkToast({
          isLoading: true,
          duration: -1,
          iconClass: 'jfk-loading__snake',
          zIndex: 100000
        })
        postExpressSave(data, {
          REJECTERRORCONFIG: {
            serveError: true
          }
        }).then(function (res) {
          toast.close()
          that.eaid = '-1'
          that.isEditing = false
          address.address_id = res.web_data.address_id
          if (!aid) {
            addressItems.unshift(address)
          } else {
            let index = -1
            let len = addressItems.length
            let i = 0
            while (i < len) {
              if (addressItems[i].address_id === aid) {
                index = i
                break
              }
              i++
            }
            addressItems.splice(index, 1, address)
          }
          that.$emit('pick-address', res.web_data.address_id)
        }).catch(function (err) {
          if (err.status === 1001 && err.web_data.error) {
            let error = err.web_data.error
            let result = {}
            for (let i in error) {
              result[i] = {
                message: error[i],
                passed: false,
                show: true
              }
            }
            that.validResult = Object.assign({}, that.validResult, result)
          }
          toast.close()
        })
      },
      handlePickAddress (aid) {
        this.$emit('pick-address', aid)
      },
      handleAddAddress () {
        this.eaid = '-1'
        this.isEditing = true
      },
      handleAddressLoaded () {
        this.loading = false
        this.addressDataLoaded = true
      },
      handleAddressPicked (type, data) {
        this.actionsheetVisible = false
        this.addressPicked = Object.assign({}, this.addressPicked, {
          province: data[0].region_id,
          province_name: data[0].region_name,
          city: data[1].region_id,
          city_name: data[1].region_name,
          region: data[2] && data[2].region_id,
          region_name: data[2] && data[2].region_name
        })
      },
      handleShowAddressSelect () {
        let d = this.addressPicked
        this.addressRegionIds = [d.province, d.city, d.region]
        this.actionsheetVisible = true
      },
      handleHiddenError (type) {
        this.validResult = Object.assign({}, this.validResult, {
          [type]: {
            show: false
          }
        })
      }
    },
    props: {
      address: {
        type: Array,
        required: true,
        default: function () {
          return []
        }
      },
      addressId: String,
      showAddressList: Number
    }
  }
</script>
