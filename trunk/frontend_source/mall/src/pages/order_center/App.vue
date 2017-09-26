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
        :infinite-scroll-disabled="loading"
        :infinite-scroll-distance="60"
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
                <div class="font-size--30 jfk-ta-r order-list__status color-golden"
                     v-if="item.refund_info_status === 1 || item.refund_info_status === '1'"><span>退款中</span>
                </div>
                <div class="font-size--30 jfk-ta-r order-list__status color-golden"
                     v-else-if="item.refund_info_status === 2 || item.refund_info_status === '2'"><span>退款中</span>
                </div>
                <div class="font-size--30 jfk-ta-r order-list__status color-golden"
                     v-else-if="item.refund_info_status === 3 || item.refund_info_status === '3'"><span>已退款</span>

                </div>
                <div class="font-size--30 jfk-ta-r order-list__status color-golden"
                     v-else-if="item.refund_info_status === 6 || item.refund_info_status === '6'"><span>退款中</span>
                </div>
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
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
      this.$pageNamespace(params)
    },
    created () {
      const orderType = parseInt(params['order_type'])
      if (orderType) {
        this.tabsItems['selected'] = orderType
      }
    },
    methods: {
      // 切换分类
      changeTab (item) {
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        this.more = true
        // 回到顶部
        window.document.documentElement.scrollTop = window.document.body.scrollTop = 0
        this.tabsItems['selected'] = item // 选中的选项
        this.orderList = []
        this.page = 1
        this.loading = false
        this.getOrderData()
      },
      // 加载更多
      loadMore () {
        if (this.more) {
          this.loading = true
          this.getOrderData()
        } else {
          this.loading = false
        }
      },
      removeLoading () {
        try {
          this.toast.close()
        } catch (e) {
        }
      },
      // 获取数据
      getOrderData () {
        if (this.tabsItems['selected'] === 4) {
          getPresentsMineList().then((res) => {
            this.removeLoading()
            this.orderList = res['web_data']['gift_info']
            this.more = false
            console.log(this.more)
          })
        } else {
          let parameter = {
            page: this.page,
            page_size: this.pageSize,
            type: this.tabsItems['selected']
          }
          getOrderList(parameter).then((res) => {
            this.removeLoading()
            let current = this.orderList
            const link = res['web_data']['page_resource']['link']
            if (res['web_data']['products'].length === 0) {
              this.more = false
            }
            for (let i = 0; i < res['web_data']['products'].length; i++) {
              let that = res['web_data']['products'][i]
              // 设置订单详情的链接
              that['order_detail_link'] = this.debug ? `orderDetail?oid=${that['order_id']}` : link['detail'] + that['order_id']
              // 设置再次购买链接
              that['order_product_link'] = this.debug ? `detail?pid=${that['package'][0]['product_id']}` : link['product_link'] + that['package'][0]['product_id']
              if (that && that.code && that.code.use_num) {
                that.code.use_num = parseInt(that.code.use_num)
              }
              let repeat = false
              for (let j = 0; j < this.orderList.length; j++) {
                if (this.orderList[j]['order_id'] === res['web_data']['products'][i]['order_id']) {
                  repeat = true
                }
              }
              if (repeat === false) {
                current.push(res['web_data']['products'][i])
              }
            }
            this.loading = false
            this.$nextTick(() => {
              this.page++
            })
          })
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
              this.loading = false
              this.orderList.splice(index, 1)
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
              this.loading = false
              this.orderList.splice(index, 1)
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
        orderList: [],
        loading: false,
        page: 1,
        pageSize: 20,
        maxPage: 0,
        more: true
      }
    }
  }
</script>
