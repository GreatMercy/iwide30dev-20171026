<template>
  <div>

    <div class="jfk-pages jfk-pages__post" v-if="!addressShow">
      <div class="jfk-pages__theme"></div>
      <div class="invoice-add-address jfk-pl-30 jfk-pr-30" v-if="!product.address_show" @click="addAddress">
        <div class="invoice-add-address__content jfk-flex is-align-middle font-size--28">
          <i class="jfk-d-ib"></i><span>新增收货地址</span>
        </div>
      </div>

      <div class="invoice-address jfk-pl-30 jfk-pr-30" @click="selectAddress" v-else>
        <div class="invoice-address__content">
          <ul>
            <li class="jfk-flex font-size--24 is-align-middle">
              <div class="invoice-address__title invoice-address__word">收件人</div>
              <div class="invoice-address__item-content font-size--28">
                <i v-text="product.user_name"></i>
                <small class="font-size--28" v-text="product.phone"></small>
              </div>
            </li>

            <li class="jfk-flex font-size--24 is-align-middle">
              <div class="invoice-address__title">收件地址</div>
              <div class="invoice-address__item-content font-size--28" v-text="product.address"></div>
            </li>
          </ul>
          <span class="jfk-font icon-user_icon_jump_normal font-size--24"></span>
          <div class="invoice-address__line"></div>
        </div>
      </div>


      <div class="post-info jfk-pl-30 jfk-pr-30">
        <div class="post-info__name">
          <i class="post-info__name--mask"></i>
          <span class="font-size--38" v-text="product.name"></span>
        </div>
        <div class="post-info__hotel font-size--24" v-text="product.provider"></div>
        <div class="post-info__number font-size--24">共拥有<span v-text="product.count"></span>份</div>
      </div>


      <div class="jfk-pl-30 jfk-pr-30">
        <div class="post-number is-align-middle jfk-flex">
          <div class="post-number__title font-size--28">邮寄数量</div>
          <div class="font-size--32 post-number__content jfk-ta-r">
            <jfk-input-number v-model="count" :min="min" :max="max" class="jfk-d-ib"></jfk-input-number>
          </div>
        </div>
      </div>

      <!--
      <div class="post-explain jfk-pl-30 jfk-pr-30">
        <div class="post-explain__title is-align-middle jfk-flex">
          <i class="jfk-font icon-msg_icon_prompt_default font-size--28"></i>
          <span class="font-size--24">说明</span>
        </div>

        <ul class="post-explain__content">
          <li class="font-size--24">邮费：10元</li>
          <li class="font-size--24">邮费说明：每件收取5元邮费</li>
        </ul>
      </div> -->

      <div class="post-btn">
        <button class="jfk-button jfk-button--primary is-plain font-size--30 jfk-button--free"
                :class="{'is-disabled': !product.arid}"
                @click="deliver">
          <span>立即发货</span>
        </button>
      </div>

      <jfk-support v-once></jfk-support>

    </div>

    <div class="page-address" v-if="addressShow">
      <div class="jfk-pages__theme"></div>
      <jfk-address :address.sync="address" :addressId="product.arid" @pick-address="handlePickedAddress"
                   :show-address-list="showAddressList">
      </jfk-address>
    </div>

  </div>

</template>

<script>
  import { getExpressIndex, posExpressCommit, getExpressAddress } from '@/service/http'
  import jfkAddress from '@/components/address/main'
  import { showFullLayer } from '@/utils/utils'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    components: {
      jfkAddress
    },
    computed: {},
    beforeCreate () {
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
    },
    methods: {
      deliver () {
        // 判断是否能够点击
        if (this.product.arid) {
          this.toast = this.$jfkToast({
            duration: -1,
            iconClass: 'jfk-loading__snake',
            isLoading: true
          })
          let postParams = {
            'aiid': this.aiid || '',
            'num': this.count || 1,
            'arid': this.product.arid,
            'product_id': this.product.product_id
          }
          console.log(postParams)
          posExpressCommit(postParams).then((res) => {
            const url = res['web_data']['detail_url']
            if (process.env.NODE_ENV === 'development') {
              let urlParams = formatUrlParams.default(url)
              window.location.href = `/logistics_detail?id=${urlParams.id}&bsn=${urlParams.bsn}&spid=${urlParams.spid}`
            } else {
              window.location.href = url
            }
            this.toast.close()
          }).catch(() => {
            this.toast.close()
          })
        }
      },
      addAddress () {
        const cb = () => {
          this.addressShow = false
        }
        showFullLayer(null, '', location.href, cb)
        this.addressShow = true
      },
      getAddress (id) {
        let result = null
        if (this.address && this.address.length > 0) {
          for (let i = 0; i < this.address.length; i++) {
            if (this.address[i]['address_id'] === id) {
              result = this.address[i]
            }
          }
        }
        return result
      },
      setProduct (result) {
        if (result !== null) {
          this.product['phone'] = result['phone']
          this.product['address'] = result['province_name'] + result['city_name'] + result['region_name'] + result['address']
          this.product['user_name'] = result['contact']
          this.product['address_show'] = true
        }
      },
      handlePickedAddress (aid) {
        const result = this.getAddress(aid)
        this.setProduct(result)
        this.product.arid = aid
        history.back(-1)
      },
      selectAddress () {
        const showAddress = () => {
          const cb = () => {
            this.addressShow = false
          }
          showFullLayer(null, '', location.href, cb)
          this.addressShow = true
          this.toast.close()
        }
        if (this.address && this.address.length > 0) {
          showAddress()
          return false
        }
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        getExpressAddress().then((res) => {
          this.address = res['web_data']
          showAddress()
        })
      }
    },
    created () {
      this.showAddressList = Date.now()
      getExpressIndex({
        'oid': params['oid'] || '',
        'gid': params['gid'] || ''
      }).then((res) => {
        this.toast.close()
        const content = res['web_data']
        this.max = parseInt(content['count'])
        this.product = {
          'count': content['count'],
          'product_id': content['product']['product_id'],
          'name': content['product']['name'],
          'provider': `由${content['wechat_name']}提供`,
          'address': content['address'],
          'arid': content['arid'],
          'user_name': content['contact'],
          'phone': content['phone']
        }
        this.aiid = content['aiid']
        // 判断进来的时候是否存在地址
        if (content && content['address'] && content['arid']) {
          this.product['address_show'] = true
          this.$store.commit('updateAddressId', this.product['arid'])
        } else {
          this.product['address_show'] = false
        }
      }).catch(() => {
        this.toast.close()
      })
    },
    data () {
      return {
        count: 1,
        min: 1,
        max: 1,
        aiid: '',
        product: {},
        addressLayerVisible: false,
        address: [],
        showAddressList: 0,
        addressShow: false
      }
    }
  }
</script>
