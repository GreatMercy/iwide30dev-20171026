<template>
  <div class="jfk-pages jfk-pages__rank">
    <div class="jfk-pages__theme is-default"></div>
    <div class="jfk-pages__body">
      <div class="user">
        <span v-show="userAvatar" class="avatar">
          <img :src="userAvatar"/>
        </span>
        <span v-show="!userAvatar" class="avatar is-default">
        </span>
        <span class="name font-color-white font-size--28">{{useName}}</span>
      </div>
      <div class="cup jfk-pl-30 jfk-pr-30">
        <div class="icon"></div>
        <div class="tip font-size--36 font-color-white">
          <template v-if="myRanking">
            今日第<i class="color-golden font-size--60">{{myRanking}}</i>名
          </template>
          <template v-else>
            未进行游戏
          </template>
        </div>
      </div>
      <div class="rank-box jfk-pl-30 jfk-pr-30">
        <div class="rank-tabs">
          <ul class="rank-tabs__head font-size--32">
            <li href="javascript:;" class="rank-tabs__head-item is-prize" :class="{'is-selected font-color-white': tabKey === 'prize', 'font-color-extra-light-gray': tabKey !== 'prize'}"><span @click="handleChangeRankType('prize')">今日奖项排行榜</span></li>
            <li href="javascript:;" class="rank-tabs__head-item is-times" :class="{'font-color-extra-light-gray': tabKey !== 'times', 'is-selected font-color-white': tabKey === 'times'}"><span @click="handleChangeRankType('times')">今日次数排行榜</span></li>
          </ul>
          <div class="rank-tabs__body">
            <div class="rank-tabs__body-item" :class="{'is-prize': tabKey === 'prize', 'is-times': tabKey === 'times'}">
              <ul class="rank-list is-prize font-size--30"
                v-infinite-scroll="loadMore"
                infinite-scroll-disabled="disabledLoadData"
                :infinite-scroll-immediate-check="false"
                infinite-scroll-distance="60">
                <template v-if="tabKey === 'prize'">
                  <li
                    v-for="(item, index) in listData"
                    :key="item.openid"
                    :class="{'is-selected': index === prizeSelectedIndex}"
                    class="rank-list__item">
                    <div class="rank-list__item-title">
                      <div class="left">
                        <span class="order font-size--60" :class="{'color-golden': index < 3, 'font-color-white': index > 2}">{{item.ranking}}</span>
                        <span class="avatar" v-if="item.wx_headimgurl">
                          <img :src="item.wx_headimgurl"/>
                        </span>
                        <span class="avatar is-default" v-else></span>
                      </div>
                      <div class="name font-color-extra-light-gray">{{item.wx_nickname}}</div>
                      <div class="prize"  @click="handleSelectedPrize(index)">
                        <i class="color-golden">{{item.prize_name}}</i>
                        <i class="arrow"></i>
                      </div>
                    </div>
                    <div class="rank-list__item-dices">
                      <span
                        class="rank-list__dice"
                        v-for="(val, key) in item.throw_num.split(',')"
                        :class="'rank-list__dice-' + val"
                        :key="key">
                      </span>
                    </div>
                  </li>
                </template>
                <template v-else>
                  <li
                    v-for="(item, index) in listData"
                    :key="item.openid"
                    class="rank-list__item">
                    <div class="rank-list__item-title">
                      <div class="left">
                        <span class="order font-size--60" :class="{'color-golden': index < 3, 'font-color-white': index > 2}">{{item.ranking}}</span>
                        <span class="avatar" v-if="item.wx_headimgurl">
                          <img :src="item.wx_headimgurl"/>
                        </span>
                        <span class="avatar is-default" v-else></span>
                      </div>
                      <div class="name font-color-extra-light-gray">{{item.wx_nickname}}</div>
                      <div class="right">
                        <span class="color-golden">已掷{{item.throw_times}}</span>
                        <span class="thumbup" @click="handleThumbup(index, item)">
                          <i class="jfk-font icon-booking_icon_collect color-golden" v-if="item.is_thumbup"></i>
                          <i class="jfk-font icon-booking_icon_collect1 font-color-white" v-else></i>
                          <i class="times color-golden">{{item.thumbup_times}}</i>
                        </span>
                      </div>
                    </div>
                  </li>
                </template>
              </ul>
              <p class="rank-list__loading" v-show="isLoading">
                <span class="jfk-loading__triple-bounce color-golden font-size--24">
                  <i class="jfk-loading__triple-bounce-item"></i>
                  <i class="jfk-loading__triple-bounce-item"></i>
                  <i class="jfk-loading__triple-bounce-item"></i>
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>
      <jfk-support v-once></jfk-support>
    </div>
    <pancake-tabbar :selected="tabbarSelected"></pancake-tabbar>
  </div>
</template>
<script>
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import pancakeTabbar from '@/components/tabbar'
  import { getPancakeGamePrizeRanking, getPancakeGameTimesRanking, getPancakeGameThumbup } from '@/service/http'
  export default {
    name: 'pancake-rank',
    components: {
      pancakeTabbar
    },
    data () {
      return {
        useName: '',
        userAvatar: '',
        myRanking: 1,
        tabKey: 'prize',
        listData: [],
        disabledLoadData: false,
        isLoading: false,
        dataPage: 1,
        prizeSelectedIndex: -1,
        pageSize: 20,
        tabbarSelected: 1,
        resetPage: false
      }
    },
    beforeCreate () {
      let urlParams = formatUrlParams(location.href)
      this.actNum = urlParams.act_num
    },
    methods: {
      loadData () {
        let vm = this
        vm.isLoading = true
        let method = vm.tabKey === 'prize' ? getPancakeGamePrizeRanking : getPancakeGameTimesRanking
        method({
          act_num: this.actNum,
          page: vm.dataPage,
          size: vm.pageSize
        }).then(function (res) {
          const { my_ranking: myRanking, my_wx_headimgurl: userAvatar, my_wx_nickname: useName, list, page_resource: pageResource } = res.web_data
          const { page, size, count } = pageResource
          vm.isLoading = false
          vm.myRanking = myRanking
          vm.userAvatar = userAvatar
          vm.useName = useName
          if (vm.resetPage) {
            vm.listData = list
            vm.resetPage = false
          } else {
            vm.listData = vm.listData.concat(list)
          }
          vm.disabledLoadData = page * size >= +count
          if (!vm.disabledLoadData) {
            vm.dataPage = +page + 1
          }
        }).catch(function (err) {
          vm.isLoading = false
          console.log(err)
        })
      },
      loadMore () {
        this.disabledLoadData = true
        this.loadData()
      },
      handleSelectedPrize (index) {
        this.prizeSelectedIndex = index === this.prizeSelectedIndex ? -1 : index
      },
      handleChangeRankType (type) {
        if (type === this.tabKey) {
          return
        }
        this.tabKey = type
      },
      handleThumbup (index, item) {
        let vm = this
        if (!item.is_thumbup) {
          getPancakeGameThumbup({
            act_num: this.actNum,
            thumbup_openid: item.openid
          }).then(function () {
            vm.listData = vm.listData.map(function (obj, idx) {
              if (index === idx) {
                return Object.assign({}, obj, {
                  'is_thumbup': true,
                  'thumbup_times': +obj.thumbup_times + 1
                })
              } else {
                return obj
              }
            })
          })
        }
      }
    },
    watch: {
      tabKey (val) {
        this.disabledLoadData = false
        this.dataPage = 1
        this.resetPage = true
        this.listData = []
      }
    }
  }
</script>
