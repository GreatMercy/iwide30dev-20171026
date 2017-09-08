<template>
  <div class="jfk-pages jfk-pages__scan-receive">

    <div class="jfk-pages__theme"></div>
    <div class="jfk-pl-30 jfk-pr-30 qrcode-wrap">

      <div class="scan-receive__container">
        <div
          class="scan-receive__qrcode jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"
          :style="size"
        >
        </div>

        <div class="scan-receive__way font-size--24 jfk-ta-c">
          <span>使用方式</span><i>（请在5分钟完成扫码，超时未领取请重新生成）</i>
        </div>

        <div class="scan-receive__btn">
          <button class="jfk-button jfk-button--primary is-plain jfk-button--free font-size--32" @click="generate">
            <span>重新生成</span>
          </button>
        </div>
      </div>
    </div>


    <div class="scan-receive__notice">
      <clause :title="'注意事项'" :list="notice"></clause>
    </div>

    <div class="scan-receive__package">
      <clause :title="'礼包内容'"></clause>
      <pack></pack>
    </div>

  </div>
</template>

<script>
  import clause from '@/components/clause/main'
  import pack from '@/components/package/main'
  export default {
    components: {
      clause,
      pack
    },
    computed: {
      size () {
        return {
          'width': (window.innerWidth * (443 / 750)) + 'px',
          'height': (window.innerWidth * (443 / 750)) + 'px'
        }
      }
    },
    methods: {
      generate () {
      }
    },
    created () {
    },
    data () {
      return {
        notice: ['该商品有效期至2017年8月29日', '请在规定时间内使用', '礼包原价233元', '仅供住店客人使用，使用时请出示劵码']
      }
    }
  }
</script>
