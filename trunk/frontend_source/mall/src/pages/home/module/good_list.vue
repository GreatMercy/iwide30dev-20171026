<template>
  <div class="good-layout" :class="goodLayoutClass">
    <section class="good-lists" v-for="(good, sort) in goods">
      <header class="good-lists__head">
        <h3 class="good-lists__head-title font-size--34">
          <div class="title-text">
            <template v-if="sort === 'killsec'">
              <i class="jfk-font icon-font_zh_xian_1_fzdbs"></i>
              <i class="jfk-font icon-font_zh_shi_fzdbs"></i>
              <i class="jfk-font icon-font_zh_miao_fzdbs"></i>
              <i class="jfk-font icon-font_zh_sha_2_fzdbs"></i>
            </template>
            <template v-else-if="sort === 'groupon'">
              <i class="jfk-font icon-font_zh_tuan_1_fzdbs"></i>
              <i class="jfk-font icon-font_zh_gou_fzdbs"></i>
              <i class="jfk-font icon-font_zh_zhuan_fzdbs"></i>
              <i class="jfk-font icon-font_zh_chang_2_fzdbs"></i>
            </template>
            <template v-else-if="sort === 'ordinary'">
              <i class="jfk-font icon-font_zh_re_1_fzdbs"></i>
              <i class="jfk-font icon-font_zh_mai_2_fzdbs"></i>
            </template>
          </div>
        </h3>
        <div v-if="sort === 'killsec'" class="good-lists__head-tip">
          <killsec-time :start="good.start_time" :end="good.end_time" :start-time-node-reminder="[60000]" @on-start-time-node-reminder="killsecStartTimeNodereminderHandler" @on-finish="killsecEndHandler" @on-start="killsecStartHandler" @has-start="killsecHasStartHandler" class="tip-content font-color-light-silver font-size--34"></killsec-time>
        </div>
        <div v-else-if="sort === 'groupon'" class="good-lists__head-tip">
          <p class="tip-content font-color-light-silver"><span>满</span><span class="tip-number font-size--65 jfk-font-number">{{good.price}}</span><span>减</span><span class="tip-number jfk-font-number font-size--65">{{good.discount}}</span></p>
        </div>
      </header>
      <div class="good-lists__body">
        <template v-if="layout === 'card'">
          <ul class="jfk-pl-30 jfk-pr-30">
            <good-list-card class="good-lists__item" :type="sort" v-for="item in good.items" :item="item" :key="item.product_id" :lgtTenMinutes="lgtTenMinutes" :startedKillsec="startedKillsec"></good-list-card>
          </ul>
        </template>
        <template v-else>
          <ul>
          <good-list-image class="good-lists__item" :type="sort" v-for="item in good.items" :item="item" :key="item.product_id" :lgtTenMinutes="lgtTenMinutes" :startedKillsec="startedKillsec"></good-list-image>
          </ul>
        </template>
      </div>
    </section>
  </div>
</template>
<script>
  import GoodListCard from './good_list_card'
  import GoodListImage from './good_list_image'
  import KillsecTime from './killsec_time'
  export default {
    name: 'good-list',
    created () {
      console.log(this.goods)
    },
    data () {
      return {
        lgtTenMinutes: false, // 秒杀提示十分钟时显示订阅提醒
        startedKillsec: false
      }
    },
    components: {
      GoodListCard,
      GoodListImage,
      KillsecTime
    },
    computed: {
      goodLayoutClass () {
        return 'good-layout--' + this.layout
      }
    },
    methods: {
      killsecEndHandler () {},
      killsecStartHandler () {
        this.startedKillsec = true
      },
      killsecHasStartHandler () {
        this.startedKillsec = true
      },
      killsecStartTimeNodereminderHandler (time) {
        this.lgtTenMinutes = true
      }
    },
    props: {
      goods: {
        type: Object,
        required: true
      },
      layout: {
        type: String,
        required: true,
        default: 'card'
      }
    }
  }
</script>
