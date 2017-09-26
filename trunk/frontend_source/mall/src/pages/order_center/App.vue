<template>
  <div class="jfk-pages jfk-pages__order-center">

    <div class="jfk-pages__theme"></div>

    <!-- tab 切换-->
    <div class="tabs">
      <ul class="order-center-tab jfk-flex is-align-middle jfk-pl-30 jfk-pr-30">
        <li class="order-center-tab__item font-size--32 jfk-ta-c"
            v-for="(item, index) in tabsItems.list"
            :class="{'order-center-tab__active' : tabsItems.selected === item.menu_type, 'color-golden': tabsItems.selected === item.menu_type}"
            @click="changeTab(item.menu_type)">
          <i class="jfk-d-ib jfk-font icon-user_icon_Polite_nor" v-if="item.icon"></i><span v-html="item.text"></span>
        </li>
      </ul>
      <div class="mask"></div>
    </div>
    <!-- tab 切换-->

    <!-- 加载数据 -->
    <ul class="order-list jfk-pr-30 jfk-pl-30"
        :infinite-scroll-disabled="disableLoadList"
        :infinite-scroll-distance="0"
        v-infinite-scroll="loadMore">

      <li v-for="(item, index) in orderList" :key="index">
        <template v-if="tabsItems.selected !== 4">
          <!--订单-->

          <!--已过期 开始-->
          <template v-if="item.package[0].expiration_status === '1'">
            <a :href="item.order_detail_link || 'javascript:void(0)'" class="order-list__disabled">
              <div class="jfk-flex is-align-middle order-list__order-info">
                <div class="font-size--28 order-list__order-id" v-html="'订单号：' + item.order_id"></div>
                <div class="font-size--30 jfk-ta-r order-list__status color-golden">已过期</div>
              </div>

              <div class="order-list__info jfk-flex">
                <div v-if="item.package[0].face_img" v-lazy:background-image="item.package[0].face_img"
                     class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image">
                </div>

                <div class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image"
                     v-else></div>

                <div class="order-list__base-info">
                  <p class="order-list__name font-size--38" v-text="item.item_name"></p>
                  <p class="order-list__number font-size--24" v-html="'<span>数量</span>' + item.row_qty"></p>
                </div>
              </div>
            </a>

            <div class="order-list__button jfk-ta-r">
              <button class="jfk-button font-size--24 jfk-button--primary order-list__delete"
                      @click="orderDelete(item.order_id,index)">
              <span>
                删除
              </span>
              </button>
              <button class="jfk-button jfk-button--primary  font-size--30 is-plain"
                      @click="locationHref(item.order_product_link)">
              <span>
                再次购买
              </span>
              </button>
            </div>

          </template>
          <!--已过期 结束-->

          <!--已退款 开始-->
          <template v-else-if="item.refund_status === '33'">
            <a :href="item.order_detail_link || 'javascript:void(0)'"
               :class="{'order-list__disabled': item.refund_info_status === 3 || item.refund_info_status === '3'}">
              <div class="jfk-flex is-align-middle order-list__order-info">
                <div class="font-size--28 order-list__order-id" v-html="'订单号：' + item.order_id"></div>
                <div class="font-size--30 jfk-ta-r order-list__status color-golden" v-if="item.refund_info_status === 1 || item.refund_info_status === '1'">退款中</div>
                <div class="font-size--30 jfk-ta-r order-list__status color-golden" v-else-if="item.refund_info_status === 2 || item.refund_info_status === '2'">退款中</div>
                <div class="font-size--30 jfk-ta-r order-list__status color-golden" v-else-if="item.refund_info_status === 3 || item.refund_info_status === '3'">已退款</div>
                <div class="font-size--30 jfk-ta-r order-list__status color-golden" v-else-if="item.refund_info_status === 6 || item.refund_info_status === '6'">退款中</div>
              </div>

              <div class="order-list__info jfk-flex">
                <div v-if="item.package[0].face_img" v-lazy:background-image="item.package[0].face_img"
                     class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image">
                </div>

                <div class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image"
                     v-else></div>

                <div class="order-list__base-info">
                  <p class="order-list__name font-size--38" v-text="item.item_name"></p>
                  <p class="order-list__number font-size--24" v-html="'<span>数量</span>' + item.row_qty"></p>
                </div>
              </div>
            </a>

            <div class="order-list__button jfk-ta-r">
              <button class="jfk-button jfk-button--primary  font-size--30 is-plain"
                      @click="locationHref(item.order_product_link)">
              <span>
                再次购买
              </span>
              </button>
            </div>

          </template>
          <!--已退款 结束-->

          <!--购买成功 开始-->
          <template v-else-if="item.consume_status === '21' || item.consume_status === '22'">
            <a :href="item.order_detail_link || 'javascript:void(0)'">
              <div class="jfk-flex is-align-middle order-list__order-info">
                <div class="font-size--28 order-list__order-id" v-html="'订单号：' + item.order_id"></div>
                <div class="font-size--30 jfk-ta-r order-list__status color-golden">购买成功</div>
              </div>

              <div class="order-list__info jfk-flex">
                <div v-if="item.package[0].face_img" v-lazy:background-image="item.package[0].face_img"
                     class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image">
                </div>

                <div class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image"
                     v-else></div>

                <div class="order-list__base-info">
                  <p class="order-list__name font-size--38" v-text="item.item_name"></p>
                  <p class="order-list__number font-size--24" v-html="'<span>数量</span>' + item.row_qty"></p>
                </div>
              </div>
            </a>
            <div class="order-list__button jfk-ta-r">

              <!--根据卷码显示按钮-->
              <template v-if="item.code && item.code.use_num && item.code.use_num > 0">
                <!-- 如果卷码还有可以使用 -->
                <button class="jfk-button jfk-button--primary  font-size--30"
                        @click="locationHref(item.order_detail_link)">
                    <span>
                      立即使用
                    </span>
                </button>
              </template>

              <template v-else>
                <!-- 如果卷码已全部使用完 -->
                <button class="jfk-button jfk-button--primary  font-size--30"
                        @click="locationHref(item.order_detail_link)">
                    <span>
                      立即查看
                    </span>
                </button>
              </template>
            </div>
          </template>

          <!--购买成功 结束-->

          <!--已完成 开始-->
          <template v-else-if="item.consume_status === '23'">
            <a :href="item.order_detail_link || 'javascript:void(0)'" class="order-list__disabled">
              <div class="jfk-flex is-align-middle order-list__order-info">
                <div class="font-size--28 order-list__order-id" v-html="'订单号：' + item.order_id"></div>
                <div class="font-size--30 jfk-ta-r order-list__status color-golden">已完成</div>
              </div>

              <div class="order-list__info jfk-flex">
                <div v-if="item.package[0].face_img" v-lazy:background-image="item.package[0].face_img"
                     class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image">
                </div>

                <div class="order-list__goods-img jfk-image__lazy--3-3 jfk-image__lazy--background-image"
                     v-else></div>

                <div class="order-list__base-info">
                  <p class="order-list__name font-size--38" v-text="item.item_name"></p>
                  <p class="order-list__number font-size--24" v-html="'<span>数量</span>' + item.row_qty"></p>
                </div>
              </div>
            </a>

            <div class="order-list__button jfk-ta-r">
              <button class="jfk-button font-size--24 jfk-button--primary order-list__delete"
                      @click="orderDelete(item.order_id,index)">
              <span>
                删除
              </span>
              </button>
              <button class="jfk-button jfk-button--primary  font-size--30 is-plain"
                      @click="locationHref(item.order_product_link)">
              <span>
               再次购买
              </span>
              </button>
            </div>

          </template>
          <!--已完成 结束-->

        </template>


        <!--礼物-->
        <template v-else>
          <a :href="item.detail_url || 'javascript:void(0)'">
            <div class="jfk-flex is-align-middle order-list__order-info">
              <div class="font-size--28 order-list__order-id" v-html="'赠送编号：' + item.gift_id"></div>
              <div class="font-size--30 jfk-ta-r order-list__status color-golden"><i
                class="jfk-font icon-user_icon_Polite_nor"></i><span>收礼成功</span>
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
            <button class="jfk-button jfk-button--primary  font-size--30 is-plain"
                    @click="locationHref(item.detail_url)">
                  <span>
                    立即查看
                  </span>
            </button>
          </div>

          <div v-else-if="item.consume_status === 2" class="order-list__button jfk-ta-r">

            <button class="jfk-button font-size--24 jfk-button--primary order-list__delete"
                    @click="giftDelete(item.gift_id, index)">
                  <span>
                   删除
                  </span>
            </button>

            <button class="jfk-button jfk-button--primary  font-size--30 is-plain"
                    @click="locationHref(item.detail_url)">
                  <span>
                   立即查看
                  </span>
            </button>
          </div>
        </template>
      </li>
    </ul>

    <div class="order-list__loading font-size--24 jfk-ta-c" v-if="loading">
      <span class="jfk-loading__triple-bounce color-golden font-size--24">
        <i class="jfk-loading__triple-bounce-item"></i>
        <i class="jfk-loading__triple-bounce-item"></i>
        <i class="jfk-loading__triple-bounce-item"></i>
      </span>
    </div>

    <jfk-support v-if="orderList.length > 0"></jfk-support>

    <template v-if="loading === false && orderList.length === 0">
      <div class="jfk-ta-c order-center__null">
        <div class="order-center__null-content">
          <div class="jfk-font icon-blankpage_icon_noorder_bg"></div>
          <p class="jfk-ta-c font-size--28">暂无相关订单~</p>
        </div>
      </div>
    </template>

  </div>

</template>

<script>
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  let params = formatUrlParams(location.href)
  import { getOrderList, getPresentsMineList, deleteOrder, deletePresentsGiftOrder } from '@/service/http'
  export default {
    computed: {
      debug () {
        return process.env.NODE_ENV === 'development'
      }
    },
    beforeCreate () {
      this.$pageNamespace(params)
    },
    methods: {
      // 切换分类
      changeTab (item) {
        window.document.documentElement.scrollTop = window.document.body.scrollTop = 0
        this.tabsItems['selected'] = item // 选中的选项
        this.operation = 'tab'
        this.disableLoadList = false
        this.orderList = []
        this.getOrderData()
      },
      // 加载更多
      loadMore () {
        this.disableLoadList = false
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
          this.disableLoadList = false
        } else {
          if (res['web_data']['products'].length === 0) {
            current['more'] = false
            this.disableLoadList = false
            this.loading = false
          } else {
            this.disableLoadList = false
            const link = res['web_data']['page_resource']['link']
            for (let i = 0; i < res['web_data']['products'].length; i++) {
              let that = res['web_data']['products'][i]
              // 设置订单详情的链接
              that['order_detail_link'] = this.debug ? `orderDetail?oid=${that['order_id']}` : link['detail'] + that['order_id']
              // 设置再次购买链接
              that['order_product_link'] = this.debug ? `detail?pid=${that['package'][0]['product_id']}` : link['product_link'] + that['package'][0]['product_id']
              // 防止重复插入
              let repeat = false
              for (let j = 0; j < current['data'].length; j++) {
                if (current['data'][j]['order_id'] === res['web_data']['products'][i]['order_id']) {
                  repeat = true
                }
              }
              if (repeat === false) {
                current['data'].push(res['web_data']['products'][i])
              }
              if (that && that.code && that.code.use_num) {
                that.code.use_num = parseInt(that.code.use_num)
              }
            }
          }
        }
        this.orderList = current['data']
        // 增加页数
        this.$nextTick(() => {
          this.disableLoadList = false
          if (current['more']) {
            current['current'] = current['current'] + 1 // 页数增加
          }
        })
      },
      // 得到需要渲染的数据
      getRenderData () {
        const current = this.cacheData[this.tabsItems.selected]
        this.disableLoadList = false
        this.loading = false
        // 如果没有更多了，停止加载数据
        if (current['more'] === false) {
          return false
        }
        // 判断是否选择了礼物
        if (parseInt(current['type']) === 4) {
          this.loading = true
          getPresentsMineList().then((res) => {
            this.setData(res)
            this.loading = false
          }).catch(() => {
            this.loading = false
          })
        } else {
          clearTimeout(this.timer)
          this.timer = setTimeout(() => {
            let parameter = {
              page: current['current'],
              page_size: current['pageSize'],
              type: current['type']
            }
            this.loading = true
            // 请求订单列表
            getOrderList(parameter).then((res) => {
              this.setData(res)
              this.loading = false
            }).catch(() => {
              this.loading = false
            })
          }, 200)
        }
      },
      // 获取请求的数据
      getOrderData () {
        // 判断当前用户执行了哪个操作
        const current = this.cacheData[this.tabsItems.selected]
        if (this.operation === 'touch') {
          this.disableLoadList = false
          this.getRenderData()
        } else if (this.operation === 'tab') {
          this.disableLoadList = false
          this.$nextTick(() => {
            this.operation = 'touch'
          })
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
            this.toast = this.$jfkToast({
              duration: -1,
              iconClass: 'jfk-loading__snake',
              isLoading: true
            })
            deleteOrder(id).then(() => {
              this.disableLoadList = false
              this.orderList.splice(index, 1)
              this.cacheData[this.tabsItems['selected']]['data'] = this.orderList
              this.toast.close()
              this.$jfkToast('删除成功')
              if (this.cacheData[this.tabsItems['selected']]['data'].length === 0) {
                this.loadMore()
              }
            }).catch(() => {
              this.toast.close()
            })
          }
        }).catch(() => {
        })
      },
      // 删除礼物
      giftDelete (id, index) {
        this.$jfkConfirm('是否确定删除?').then(action => {
          if (action === 'confirm') {
            this.toast = this.$jfkToast({
              duration: -1,
              iconClass: 'jfk-loading__snake',
              isLoading: true
            })
            deletePresentsGiftOrder(id).then((res) => {
              this.disableLoadList = false
              this.orderList.splice(index, 1)
              this.cacheData[this.tabsItems['selected']]['data'] = this.orderList
              this.toast.close()
              this.$jfkToast('删除成功')
            }).catch(() => {
              this.toast.close()
            })
          }
        }).catch(() => {
        })
      }
    },
    data () {
      return {
        operation: 'touch',
        timer: null,
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
        loading: false,
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
