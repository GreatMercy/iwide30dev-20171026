<template>
  <div class="jfk-pages jfk-pages__gift-package">
    <div class="jfk-pages__theme"></div>

    <pack></pack>

    <div class="package-box">
      <clause :title="'领取信息'" :list="info"></clause>
    </div>


    <div class="package-box">
      <clause :title="'注意事项'" :list="notice"></clause>
    </div>


    <div class="package-btn">
      <button class="jfk-button jfk-button--primary is-plain jfk-button--free font-size--32" @click="receive">
        <span class="jfk-button__text">
          <i class="jfk-font jfk-button__text-item icon-font_zh_li_qkbys"></i>
          <i class="jfk-font jfk-button__text-item icon-font_zh_ji_qkbys"></i>
          <i class="jfk-font jfk-button__text-item icon-font_zh_ling_qkbys"></i>
          <i class="jfk-font jfk-button__text-item icon-font_zh_qu_qkbys1"></i>
        </span>
      </button>
    </div>

  </div>
</template>

<script>
  import clause from '@/components/clause/main'
  import pack from '@/components/package/main'
  import { JfkMessageBox } from 'jfk-ui'
  export default {
    components: {
      clause,
      pack
    },
    computed: {},
    created () {
    },
    methods: {
      changeStatus () {
        // this.status = !this.status
      },
      receive () {
        JfkMessageBox({
          showClose: true,
          showCloseButton: true,
          title: '',
          message: '领取失败，货存不足',
          showConfirmButton: true,
          showCancelButton: false,
          confirmButtonText: '确定',
          iconClass: 'jfk-font icon-user_icon_fail_norma'
        }).then(() => {
        })
      }
    },
    data () {
      return {
        status: true,
        info: ['登记信息：1102房', '其他：无'],
        notice: ['该商品有效期至2017年8月29日', '请在规定时间内使用', '礼包原价233元', '仅供住店客人使用，使用时请出示劵码']
      }
    }
  }
</script>
