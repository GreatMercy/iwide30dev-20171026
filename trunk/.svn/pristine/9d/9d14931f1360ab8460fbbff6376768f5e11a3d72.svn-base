<template>
  <div class="jfk-pages jfk-pages__order-center">

    <div class="jfk-pages__theme"></div>

    <!-- tab 切换-->
    <ul class="order-center-tab jfk-flex is-align-middle">
      <li class="order-center-tab__item font-size--32 jfk-ta-c"
          v-for="(item, index) in tabsItems.list"
          :class="{'order-center-tab__active' : tabsItems.selected === item.menu_type}"
          @click="changeTab(item.menu_type)">
        <i class="jfk-d-ib jfk-font icon-user_icon_Polite_nor" v-if="item.icon"></i>
        <span v-html="item.text"></span>
      </li>
    </ul>
    <!-- tab 切换-->

    <!-- 加载数据 -->
    <ul class="order-list jfk-pr-30 jfk-pl-30"
        :infinite-scroll-disabled="disableLoadList"
        :infinite-scroll-distance="0"
        v-infinite-scroll="loadMore">

      <li v-for="(item, index) in orderList" :key="index">
        <template v-if="tabsItems.selected !== 4">
          <!--订单-->
          <a :href="item.order_detail_link || 'javascript:void(0)'">
            <div class="jfk-flex is-align-middle order-list__order-info">
              <div class="font-size--28 order-list__order-id" v-html="'订单号：' + item.order_id"></div>

              <!--订单状态-->
              <div class="font-size--30 jfk-ta-r order-list__status"
                   v-if="item.consume_status === '21' || item.consume_status === '22'" v-text="'购买成功'"></div>
              <div class="font-size--30 jfk-ta-r order-list__status" v-else-if="item.consume_status === '23'"
                   v-text="'已完成'"></div>
              <div class="font-size--30 jfk-ta-r order-list__status" v-else-if="item.refund_status === '33'"
                   v-text="'已退款'"></div>
              <!--订单状态-->

            </div>

            <div class="order-list__info jfk-flex">
              <div v-if="item.package[0].face_img" v-lazy:background-image="item.package[0].face_img"
                   class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image">
              </div>

              <div class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image" v-else></div>

              <div class="order-list__base-info">
                <p class="order-list__name font-size--38" v-text="item.item_name"></p>
                <p class="order-list__number font-size--24" v-html="'<span>数量</span>' + item.row_qty"></p>
              </div>
            </div>

          </a>

          <!--购买成功-->
          <div v-if="item.consume_status === '21' || item.consume_status === '22'" class="order-list__button jfk-ta-r">
            <button class="jfk-button jfk-button--primary  font-size--30"
                    @click="locationHref(item.order_detail_link)">
              <span class="jfk-button__text">
                <i class="jfk-font jfk-button__text-item icon-font_zh_li_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_ji_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_cha_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_kan_qkbys"></i>
              </span>
            </button>
          </div>

          <!--已完成-->
          <div v-else-if="item.consume_status === '23'" class="order-list__button jfk-ta-r">
            <button class="jfk-button font-size--24 jfk-button--primary order-list__delete"
                    @click="orderDelete(item.order_id,index)">
              <span class="jfk-button__text">
                <i class="jfk-font jfk-button__text-item icon-font_zh_shan_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_chu_qkbys"></i>
              </span>
            </button>
            <button class="jfk-button jfk-button--primary  font-size--30 is-plain">
              <span class="jfk-button__text">
                <i class="jfk-font jfk-button__text-item icon-font_zh_zai__qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_ci_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_gou_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_mai_qkbys"></i>
              </span>
            </button>
          </div>

          <!--已经退款-->
          <div class="order-list__button jfk-ta-r" v-else-if="item.refund_status === '33'">
            <button class="jfk-button jfk-button--primary  font-size--30 is-plain">
              <span class="jfk-button__text">
                <i class="jfk-font jfk-button__text-item icon-font_zh_zai__qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_ci_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_gou_qkbys"></i>
                <i class="jfk-font jfk-button__text-item icon-font_zh_mai_qkbys"></i>
              </span>
            </button>
          </div>
        </template>


        <!--礼物-->
        <template v-else>
          <a :href="'javascript:void(0)'">
            <div class="jfk-flex is-align-middle order-list__order-info">
              <div class="font-size--28 order-list__order-id" v-html="'赠送编号：' + item.gift_id"></div>
              <div class="font-size--30 jfk-ta-r order-list__status"><i class="jfk-font icon-user_icon_Polite_nor"></i>
                <span>收礼成功</span>
              </div>
            </div>

            <div class="order-list__info jfk-flex">
              <div v-if="item.face_img" v-lazy:background-image="item.face_img"
                   class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image">
              </div>
              <div class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image" v-else></div>
              <div class="order-list__base-info">
                <p class="order-list__name font-size--38" v-text="item.name"></p>
                <p class="order-list__number font-size--24" v-html="'<span>数量</span>' + item.per_give"></p>
              </div>
            </div>
          </a>

          <div v-if="item.consume_status === 1 " class="order-list__button jfk-ta-r">

            <button class="jfk-button font-size--24 jfk-button--primary order-list__delete">
                  <span class="jfk-button__text">
                    <i class="jfk-font jfk-button__text-item icon-font_zh_shan_qkbys"></i>
                    <i class="jfk-font jfk-button__text-item icon-font_zh_chu_qkbys"></i>
                  </span>
            </button>

            <button class="jfk-button jfk-button--primary  font-size--30 is-plain">
                  <span class="jfk-button__text">
                    <i class="jfk-font jfk-button__text-item icon-font_zh_cha_qkbys"></i>
                    <i class="jfk-font jfk-button__text-item icon-font_zh_kan_qkbys"></i>
                    <i class="jfk-font jfk-button__text-item icon-font_zh_xiang_qkbys"></i>
                    <i class="jfk-font jfk-button__text-item icon-font_zh_qing_qkbys"></i>
                  </span>
            </button>

          </div>

          <div v-else-if="item.consume_status === 2" class="order-list__button jfk-ta-r">
            <button class="jfk-button jfk-button--primary  font-size--30 is-plain">
                  <span class="jfk-button__text">
                    <i class="jfk-font jfk-button__text-item icon-font_zh_li_qkbys"></i>
                    <i class="jfk-font jfk-button__text-item icon-font_zh_ji_qkbys"></i>
                    <i class="jfk-font jfk-button__text-item icon-font_zh_cha_qkbys"></i>
                    <i class="jfk-font jfk-button__text-item icon-font_zh_kan_qkbys"></i>
                  </span>
            </button>
          </div>


        </template>
      </li>

    </ul>


  </div>

</template>

<script>
  import { getOrderList, getOrderCenterGiftList, getOrderDelete } from '@/service/http'
  export default {
    methods: {
      // 切换分类
      changeTab (item) {
        this.tabsItems['selected'] = item // 选中的选项
        this.operation = 'tab'
        this.orderList = []
        this.getOrderData()
      },
      // 加载更多
      loadMore () {
        this.disableLoadList = true
        this.getOrderData()
      },
      // 设置新的数据
      setData (res) {
        const current = this.cacheData[this.tabsItems.selected]
        this.operation = 'touch'
        // 如果当前为礼物
        if (current['type'] === 4) {
          current['more'] = false
          current['data'] = res['web_data']['gift_info']
        } else {
          if (res['web_data']['products'].length === 0) {
            current['more'] = false
          } else {
            const link = res['web_data']['page_resource']['link']
            for (let i = 0; i < res['web_data']['products'].length; i++) {
              // 设置订单详情的链接
              let that = res['web_data']['products'][i]
              that['order_detail_link'] = link['detail'] + that['order_id']
              console.log(that)
              current['data'].push(res['web_data']['products'][i])
            }
          }
        }

        this.orderList = current['data']
        console.log(this.orderList)
        // 增加页数
        this.$nextTick(() => {
          if (current['more']) {
            current['current'] += 1 // 页数增加
            console.log(current['current'])
          }
        })
      },
      // 得到需要渲染的数据
      getRenderData () {
        const current = this.cacheData[this.tabsItems.selected]
        this.disableLoadList = current['more']
        // 如果没有更多了，停止加载数据
        if (current['more'] === false) {
          return false
        }
        // 判断是否选择了礼物
        if (parseInt(current['type']) === 4) {
          getOrderCenterGiftList().then((res) => {
            this.setData(res)
          })
        } else {
          // 请求订单列表
          getOrderList({
            page: current['current'],
            page_size: current['pageSize'],
            type: current['type']
          }).then((res) => {
            this.setData(res)
          })
        }
      },
      // 获取请求的数据
      getOrderData () {
        // 判断当前用户执行了哪个操作
        const current = this.cacheData[this.tabsItems.selected]
        if (this.operation === 'touch') {
          this.getRenderData()
        } else if (this.operation === 'tab') {
          this.disableLoadList = false
          this.operation = 'touch'
          if (current['more']) {
            if (current['data'].length === 0) {
              this.getRenderData()
            } else {
              this.orderList = current['data']
            }
          } else {
            this.orderList = current['data']
          }
        }
      },
      // 页面跳转
      locationHref (href) {
        window.location.href = href
      },
      // 删除订单
      orderDelete (id, index) {
        this.$jfkConfirm('是否确定删除?').then(action => {
          if (action === 'confirm') {
            getOrderDelete({oid: id}).then(() => {
              this.orderList.splice(index, 1)
            })
          }
        }).catch(() => {
        })
      }
    },
    data () {
      return {
        operation: 'touch',
        // tab 列表
        tabsItems: {
          selected: 1, // 当前选中的id
          list: [{
            'text': '全部',
            'menu_type': 1
          }, {
            'text': '待使用',
            'menu_type': 2
          }, {
            'text': '已完成',
            'menu_type': 3
          }, {
            'text': '礼物',
            'menu_type': 4,
            'icon': true
          }]
        },
        disableLoadList: false,
        orderList: [],
        cacheData: {
          '1': {
            type: 1, // 订单类型
            data: [], // 数据
            more: true, // 是否有更多数据
            pageSize: 10, // 每页多少条
            current: 1 // 当前页码
          },
          '2': {
            type: 2, // 订单类型
            data: [], // 数据
            more: true, // 是否有更多数据
            pageSize: 10, // 每页多少条
            current: 1 // 当前页码
          },
          '3': {
            type: 3, // 订单类型
            data: [], // 数据
            more: true, // 是否有更多数据
            pageSize: 10, // 每页多少条
            current: 1 // 当前页码
          },
          '4': {
            type: 4, // 订单类型
            data: [], // 数据
            more: true, // 是否有更多数据
            pageSize: 10, // 每页多少条
            current: 1 // 当前页码
          }
        }
      }
    }
  }
</script>
