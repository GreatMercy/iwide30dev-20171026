<template>
  <div class="jfk-pages jfk-pages__record">
    <div class="jfk-pages__theme is-default"></div>
    <div class="jfk-pages__body">
    <div class="user font-size--30">
      <div v-show="userAvatar" class="avatar">
        <img :src="userAvatar"/>
      </div>
      <div v-show="!userAvatar" class="avatar is-default">
      </div>
      <div class="name font-color-white">{{useName}}</div>
    </div>
    <div class="times font-size--30 font-color-extra-light-gray jfk-ml-30 jfk-mr-30">
      <span class="throw-times">投掷<i class="color-golden font-size--48">{{throwTimes}}</i>次</span>
      <span class="prize-times">中奖<i class="color-golden font-size--48">{{prizeTimes}}</i>次</span>
    </div>
    <div class="record-box">
      <div class="title font-size--32 font-color-extra-light-gray jfk-ta-c">今日战绩</div>
      <div class="record-cont jfk-font--30 jfk-pl-30 jfk-pr-30">
        <ul class="record-list" v-if="prizeData.length">
          <li
            class="record-list__item jfk-clearfix"
            v-for="(item, index) in prizeData"
            :key="index">
            <div class="order font-size--60 jfk-fl-l" :class="{'color-golden': index < 3, 'font-color-white': index > 2}">{{item.ranking}}</div>
            <div class="prize font-color-extra-light-gray jfk-fl-l">{{item.prize_name}}</div>
            <div class="prize-number jfk-fl-l font-color-extra-light-gray">中：<i class="color-golden">{{item.prize_count}}</i></div>
            <div class="prize-btns jfk-fl-r" @click="handleReceivePrize(item)">
              <span class="btn">
                <button class="jfk-button jfk-button--free jfk-button--primary is-plain" :disabled="!item.is_available">可领</button>
              </span>
              <span class="num color-golden">{{item.received_num}}/{{item.receive_limit_num}}</span>
            </div>
          </li>
        </ul>
        <div class="empty font-color-light-gray jfk-ta-c font-size--24" v-else>
          今日暂未进行游戏
        </div>
      </div>
    </div>
    </div>
    <pancake-tabbar :selected="tabbarSelected"></pancake-tabbar>
  </div>
</template>
<script>
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { getPancakeGameMyPrize } from '@/service/http'
  import pancakeTabbar from '@/components/tabbar'
  export default {
    name: 'pancake-record',
    components: {
      pancakeTabbar
    },
    beforeCreate () {
      let urlParams = formatUrlParams(location.href)
      this.actNum = urlParams.act_num
    },
    created () {
      let vm = this
      getPancakeGameMyPrize({
        act_num: this.actNum
      }).then(function (res) {
        const { my_prize_times: prizeTimes, my_throw_times: throwTimes, my_wx_nickname: useName, my_wx_headimgurl: userAvatar, list } = res.web_data
        vm.prizeTimes = prizeTimes
        vm.throwTimes = throwTimes
        vm.useName = useName
        vm.userAvatar = userAvatar
        vm.prizeData = list
      })
    },
    data () {
      return {
        tabbarSelected: 2,
        prizeData: [],
        useName: '',
        userAvatar: '',
        throwTimes: '0',
        prizeTimes: 0
      }
    },
    methods: {
      handleReceivePrize (obj) {
        if (obj.is_available) {
          if (process.env.NODE_ENV === 'development') {
            location.href = '/coupon?prize_type=' + obj.prize_type
          }
        }
      }
    }
  }
</script>
