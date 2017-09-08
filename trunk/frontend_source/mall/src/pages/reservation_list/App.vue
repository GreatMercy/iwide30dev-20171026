<template>
  <div class="jfk-pages jfk-pages__reservation-list">
    <div class="jfk-pages__theme"></div>

    <div class="reservation-search jfk-pl-30 jfk-pr-30 jfk-flex is-align-middle">
      <span class="reservation-search__icon jfk-font icon-blankpage_icon_nosearch_bg">
      </span>
      <input type="text" class="reservation-search__input font-size--38"
             placeholder="输入酒店和房型"
             v-model="searchValue"
             @keyup="search"
      >
      <span class="reservation-search__close jfk-font icon-mall_icon_booking_cancel" @click="deleteAll"
            v-if="searchLength">
      </span>
    </div>

    <ul class="reservation-list jfk-pl-30 jfk-pr-30" v-if="list.length > 0">
      <li v-for="(item, index) in list">
        <a class="jfk-pl-30 jfk-pr-30" :href="item.link + codeId">
          <div v-lazy:background-image="item.room_cover"
               class="reservation-list__image jfk-image__lazy--3-3 jfk-image__lazy--background-image"
               v-if="item.room_cover">
          </div>

          <div
            class="reservation-list__image jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"
            v-else>
          </div>

          <div class="reservation-list__name font-size-38" v-text="item.room_name"></div>
          <div class="jfk-flex reservation-list__info">

            <div class="reservation-list__left">
              <p class="reservation-list__hotel font-size--30" v-text="item.name"></p>
              <p class="reservation-list__location">
                <i class="jfk-font icon-icon_location"></i><span class="font-size--24" v-text="item.address"></span>
              </p>
            </div>

            <div class="reservation-list__right">
              <button class="jfk-button jfk-button--primary is-plain font-size--30 product-button">
                <span>
                  现在订房
                </span>
              </button>
            </div>

          </div>
          <div class="reservation-list__mask"></div>
        </a>
      </li>
    </ul>

    <template v-else>

      <template v-if="operation === 'page' && list.length === 0">
        <div class="jfk-ta-c reservation-no-data">
          <div class="jfk-font icon-blankpage_icon_nohotel_bg"></div>
          <p class="jfk-ta-c font-size--28">暂无商品~</p>
        </div>
      </template>

      <template v-else-if="operation === 'search' && list.length === 0">
        <div class="jfk-ta-c reservation-no-data">
          <div class="jfk-font icon-blankpage_icon_nosearch_bg"></div>
          <p class="jfk-ta-c font-size--28">无搜索结果~</p>
        </div>
      </template>

    </template>

    <div class="reservation-loading" v-if="loadingList">
      <div class="font-size--24 jfk-ta-c">
        <span class="jfk-loading__triple-bounce color-golden font-size--24">
          <i class="jfk-loading__triple-bounce-item"></i>
          <i class="jfk-loading__triple-bounce-item"></i>
          <i class="jfk-loading__triple-bounce-item"></i>
        </span>
      </div>
    </div>

    <jfk-support v-once></jfk-support>

  </div>
</template>
<script>
  import { getHotelList } from '@/service/http'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    computed: {
      searchLength () {
        return String(this.searchValue).trim().length
      }
    },
    created () {
      this.searchValue = ''
      this.getData('page')
      this.codeId = params['code_id'] || ''
    },
    methods: {
      getData (operation) {
        this.loadingList = true
        clearTimeout(this.throttle)
        this.list = []
        this.throttle = setTimeout(() => {
          getHotelList({
            'oid': params['oid'] || '',
            'aiid': params['aiid'] || '',
            'search': this.searchValue || ''
          }).then((res) => {
            if (operation === 'page') {
              this.allList = this.list = res['web_data']['room_list']
              this.canLoad = false
            } else {
              this.list = res['web_data']['room_list']
            }
            if (process.env.NODE_ENV === 'development') {
              const changeLink = (item) => {
                let urlParams = formatUrlParams.default(item['link'])
                item['link'] = `/reservation?id=${urlParams.id}&bsn=${urlParams.bsn}&cdid=${urlParams.cdid}&hid=${urlParams.hid}&oid=${urlParams.oid}&rmid=${urlParams.rmid}&aiid=${urlParams.aiid}&cdid=${urlParams.cdid}&code_id=`
              }

              for (let i = 0; i < this.list.length; i++) {
                changeLink(this.list[i])
              }
            }
            this.loadingList = false
            this.operation = operation
          }).catch(() => {
            this.loadingList = false
          })
        }, 500)
      },
      search () {
        // 如果一进来的时候没有数据，搜索直接无效
        if (this.searchLength === 0) {
          if (this.canLoad) {
            this.getData('page')
          } else {
            this.list = this.allList
            this.loadingList = false
          }
        } else {
          this.operation = ''
          this.getData('search')
        }
      },
      deleteAll () {
        this.searchValue = ''
        this.search()
      }
    },
    data () {
      return {
        searchValue: '',
        loadingList: false,
        codeId: '',
        list: [],
        allList: [],
        operation: '',
        throttle: null,
        canLoad: true
      }
    }
  }
</script>

<style>
</style>
