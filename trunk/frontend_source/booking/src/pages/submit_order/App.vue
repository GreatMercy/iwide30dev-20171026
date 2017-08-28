<template>
  <div class="jfk-pages jfk-pages__submitOrder">
    <div class="jfk-pages__theme"></div>
    <div class="submit_order_top">
      <div class="submit_order_top_title">
          <span class="word font-size--28">登陆后享受 <span class="font-size--36">更低优惠</span></span>
          <span class="if goldColor">
            <i class="booking_icon_font font-size--34 icon-font_zh_li_qkbys"></i><i class="booking_icon_font font-size--34 icon-font_zh_ji_qkbys"></i><i class="booking_icon_font font-size--34 icon-font_zh_deng_qkbys"></i><i class="booking_icon_font font-size--34 icon-font_zh_lu_qkbys"></i><i class="booking_icon_font font-size--28 icon-booking_icon_right_normal"></i>
          </span>
      </div>
      <p class="hotel_name font-size--38">金房卡大酒店</p>

      <p class="stay_time grayColor80 font-size--24">
        <span class="in">入住 <span class="date">03/32</span></span>
        <span class="left">离店 <span class="date">03/32</span></span>
        <span class="time">共1晚</span>
      </p> 

      <p class="room_del font-size--24">大床房</p>
      <p class="room_other font-size--24">温泉门票+双人自助餐</p>
    </div>

    <!-- 房间数等 -->
     <div class="order-info jfk-pl-30 jfk-pr-30">
      <form class="jfk-form font-size--28">
        <div class="form-item">
          <span class="form-item__label font-color-extra-light-gray form-item__label--word-3">房间数</span>
          <div class="form-item__body jfk-ta-r">
            <div class="count jfk-d-ib font-size--32">
              <jfk-input-number v-model="count" :min="min" :max="max"></jfk-input-number>
            </div>
            <span class="font-color-extra-light-gray">间</span>
          </div>
        </div>
        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">入住人</span>
            <div class="form-item__body">
              <input type="text" class="font-color-white" v-model="customerInfo.name" placeholder="请输入入住人姓名" />
              <div class="form-item__status is-error" v-show="validResult.name.show" @click="handleHiddenError('name')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                  <i class="form-item__status-cont">{{validResult.name.message}}</i>
                  <i class="form-item__status-trigger">重新输入</i>
                </span>
              </div>
            </div>
          </label>
        </div>
        <div class="form-item">
          <span class="form-item__label  font-color-extra-light-gray">联系方式</span>
          <div class="form-item__body">
            <input type="text" class="font-color-white" v-model="customerInfo.phone" placeholder="请输入入住人手机" />
              <div class="form-item__status is-error" v-show="validResult.phone.show" @click="handleHiddenError('phone')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                  <i class="form-item__status-cont">{{validResult.phone.message}}</i>
                  <i class="form-item__status-trigger">重新输入</i>
                </span>
              </div>
          </div>
        </div>
         <!-- 优惠券 -->
      <div class="pay_for">
        <div class="pay_for_item font-size--24">
          <span class="counp goldColor font-size--34">
          优惠券
          <i class="booking_icon_font font-size--24 icon-booking_icon_dropdown_normal"></i>
          </span>
          <br>
          <span class="counpon">
            新用户专享优惠券
            <br>
            ¥100
          </span>
        </div>
        <div class="pay_for_item font-size--24">
          <span class="counp goldColor font-size--34">积分抵用</span>
          <br>
          <span class="counpon">
            已用1000积分
            <br>
            抵用¥100
          </span>
        </div>
      </div>
      <div class="form-item">
        <span class="form-item__label  font-color-extra-light-gray">备&nbsp;&nbsp;&nbsp;&nbsp;注</span>
        <div class="form-item__body">
          <input type="text" class="font-color-white" v-model="customerInfo.phone" placeholder="无" />
            <div class="form-item__status is-error" v-show="validResult.phone.show" @click="handleHiddenError('phone')">
              <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
              <span class="form-item__status-tip">
                <i class="form-item__status-cont">{{validResult.phone.message}}</i>
                <i class="form-item__status-trigger">重新输入</i>
              </span>
            </div>
        </div>
      </div>
      </form>
    </div>
    <!-- 支付方式 -->
    <div class="pay_type">
      <div class="pay_type_item active">
        <input type="radio" name="1">
        <p class="font-size--28">
          <i class="booking_icon_font font-size--40 icon-user_icon_wxpay_n-"></i><br>
          微信支付
        </p>
      </div>
      <div class="pay_type_item">
        <input type="radio" name="1">
        <p class="font-size--28">
          <i class="booking_icon_font font-size--40 icon-user_icon_wxpay_n-"></i><br>
          到店支付
        </p>
      </div>
      <div class="pay_type_item">
        <input type="radio" name="1">
        <p class="font-size--28">
          <i class="booking_icon_font font-size--40 icon-user_icon_wxpay_n-"></i><br>
          余额支付
        </p>
      </div>
    </div>
    <div class="booking_desc font-size--24 jfk-pl-30 jfk-pr-30">
      <p class="title">
        <i class="booking_icon_font font-size--30 icon-msg_icon_prompt_default"></i>
        预定说明
      </p>
      <p class="desc">
        我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅我好帅
      </p>
    </div>
    <!-- 底部栏 -->
    <footer class="footer jfk-clearfix">
      <div class="order-detail jfk-fl-l">
          <span class="price color-golden">
            <i class="price__currency font-size--24"><span class="money_icon">¥</span></i>
            <i class="price__number font-size--48">111</i>
          </span>
          <span class="detail font-size--24 font-color-extra-light-gray showDetailIcon">
            明细
          </span>
        </div>
        <div class="control jfk-fl-l">
          <button href="javascript:;" class="jfk-button font-size--34 jfk-button--higher jfk-button--free jfk-button--primary">
            <span class="jfk-button__text">
              <i class="booking_icon_font jfk-button__text-item icon-font_zh_li_qkbys"></i> 
              <i class="booking_icon_font jfk-button__text-item icon-font_zh_ji_qkbys"></i> 
              <i class="jfk-font jfk-button__text-item icon-font_zh_zh_qkbys"></i> 
              <i class="jfk-font jfk-button__text-item icon-font_zh_fu_qkbys"></i>
            </span>
          </button>
        </div>
    </footer>
    <!-- 遮罩层 -->
    <div class="order_detail" v-show="false">
      <div class="order_detail_content">
        <div class="room_cost jfk-pl-30 jfk-pr-30 font-size--26 grayColor80">
          <p class="title font-size--28 font-color-dark-white">
            <span class="left">房费</span>
            <span class="right goldColor font-size--30"><span class="money_icon">¥</span>200</span>
          </p>
          <p class="room_cost_item">
            <span class="left">0414（1晚）</span>
            <span class="right">333</span>
          </p>
          <p class="room_cost_item">
            <span class="left">0414（1晚）</span>
            <span class="right">333</span>
          </p>
          <p class="room_cost_item">
            <span class="left">0414（1晚）</span>
            <span class="right">333</span>
          </p>
        </div>
        <div class="room_cost jfk-pl-30 jfk-pr-30 font-size--26 grayColor80">
          <p class="title font-size--28 font-color-dark-white">
            <span class="left">房费</span>
            <span class="right goldColor font-size--30"><span class="money_icon">¥</span>200</span>
          </p>
          <p class="room_cost_item">
            <span class="left">早餐X3</span>
            <span class="right">333</span>
          </p>
          <p class="room_cost_item">
            <span class="left">早餐X3</span>
            <span class="right">333</span>
          </p>
          <p class="room_cost_item">
            <span class="left">早餐X3</span>
            <span class="right">333</span>
          </p>
        </div>
        <div class="use_coupon font-size--28 jfk-pl-30 jfk-pr-30">
          <p class="use_coupon_item">
            <span class="left">使用积分</span>
            <span class="right goldColor font-size--30">0积分</span>
          </p>
          <p class="use_coupon_item">
            <span class="left">支付优惠</span>
            <span class="right goldColor font-size--30"><span class="money_icon">¥</span>30</span>
          </p>
          <p class="use_coupon_item">
            <span class="left">优惠券</span>
            <span class="right goldColor font-size--30"><span class="money_icon">¥</span>30</span>
          </p>
        </div>
      </div>
    </div>

    <!-- 使用优惠券 -->
    <div class="choose_coupon font-size--28">
      <div class="choose_coupon_top jfk-pl-30 jfk-pr-30">
        <p class="title font-size--24 grayColor80">温馨提示</p>
        <p class="choose_coupon_item">
          1、每个间夜仅可使用1张优惠劵
        </p> 
        <p class="choose_coupon_item">
          2、优惠劵不找零，不兑换，使用后不可取消，请谨慎使用
        </p>
        <span class="click_open font-size--24 goldColor">
          展开全文
        <span>
            <i class="booking_icon_font font-size--24 icon-booking_icon_right_normal"></i>
          </span>
        </span>
      </div>
      <div class="coupon_num font-size--28 grayColor80 jfk-pl-30 jfk-pr-30">
        <span class="font-size--40 goldColor">1</span>
        <span class="sliver">/</span> 14可用
      </div>
      <div class="coupon_list jfk-pl-30 jfk-pr-30">
        <div class="coupon_list_item">
          <div class="price">
            <span class="jfk-price product-price-package color-golden">
              <i class="jfk-font-number jfk-price__currency font-size--28 icon_money">￥</i>
              <i class="jfk-font-number icon_num jfk-price__number">100</i>
            </span>
          </div>
          <div class="coupon_desc">
            <p class="name font-size--32">新用户专享优惠券</p>
            <p class="desc font-size--24 grayColorbf">新用户专享优惠券</p>
            <p class="date font-size--24 grayColor80">2017.02.02至2017.12.30</p>
            <!-- <input type="radio" name="coupon" class="right_status"> -->
            <span class="right_status font-size--24 grayColorbf">不可用</span>
          </div>
        </div>
      </div>
      <div class="btn_submit font-size--32">
        确   认
      </div>
      

    </div>

    <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
  import { getPackageLists } from '@/service/http'
  export default {
    watch: {},
    components: {
    },
    beforeCreate () {
    },
    created () {
//    加载swiper
      this.loadPackages()
    },
    data () {
      return {
        // 用户信息
        customerInfo: {
          name: '',
          phone: ''
        },
        validResult: {
          name: {
            passed: false,
            message: ''
          },
          phone: {
            passed: false,
            message: ''
          },
          area: {
            passed: false,
            message: ''
          }
        },
        advs: [
          {
            'adv_id': '20',
            'cat_id': '',
            'hotel_id': '180',
            'inter_id': 'a450089706',
            'link': 'http://',
            'logo': 'http://30.iwide.cn:821/public/media/a450089706/adv/logo/20160613171158.jpg',
            'name': '五一出游，应该去的地方',
            'name_en': '',
            'product_id': '0',
            'sort': '3',
            'status': '1',
            'type': '1'
          }
        ],
        isLoadProduct: false,
        categories: [],
        tabbarItems: [],
        page: 1,
        fcid: '-1',
        showAdsCat: 1,
        curCategoryIndex: 0,
        pageSize: 20,
        bannerSwiperOptions: {
          autoplay: 3000,
          lazyLoading: false,
          lazyLoadingInPrevNext: true,
          lazyPreloaderClass: 'jfk-image__lazy--preload',
          pagination: '.swiper-pagination',
          paginationType: 'fraction'
        }
      }
    },
    methods: {
      loadPackages (resetProducts) {
        let that = this
        let args = {
          page: that.page,
          show_ads_cat: that.showAdsCat,
          page_size: that.pageSize
        }
        if (that.fcid > 0) {
          args.fcid = that.fcid
        }
        that.isLoadProduct = true
        getPackageLists(args).then(function (res) {
          that.isLoadProduct = false
          const {advs} = res.web_data
          /* eslint camelcase: 0 */
          if (that.showAdsCat === 1) {
            that.showAdsCat = 2
            that.advs = advs
          }
        }).catch(function (e) {
          that.isLoadProduct = false
          console.log(e)
        })
      }
    }
  }
</script>
