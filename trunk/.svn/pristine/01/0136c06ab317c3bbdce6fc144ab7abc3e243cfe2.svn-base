<template>
  <div class="jfk-pages jfk-pages__comment">
    <div class="jfk-pages__theme"></div>
    <div class="choose_prt_top">
      <p class="choose_prt_top_item1 font-size--30">
        高级大床房
      </p>
      <p class="choose_prt_top_item2 font-size--24 grayColorbf">
        组合已选房型高级大床房购买更优惠
      </p>
      <p class="choose_prt_top_item3 font-size--24 grayColorbf">
        <span>lalaalalllala</span>
        <span>lalaalalllala</span>
        <span>lalaalalllala</span>
      </p>

    </div>
    
    <!-- 评分容器 -->
    <div class="star_container">
      <div class="star_title">
        酒店评分
      </div>
      <div class="star_list">
        <p class="star_list_item">
          <span class="star_list_item_name">
            卫&nbsp;&nbsp;&nbsp;生
          </span>
          <jfk-rater v-model="value" :font-size="24" :margin="20" :disabled="false" :value="value"></jfk-rater>
        </p>
        <p class="star_list_item">
          <span class="star_list_item_name">
            设&nbsp;&nbsp;&nbsp;施
          </span>
          <jfk-rater :margin="20" v-model="value" :disabled="false" :value="value"></jfk-rater>
        </p>
        <p class="star_list_item">
          <span class="star_list_item_name">
            网&nbsp;&nbsp;&nbsp;络
          </span>
          <jfk-rater :margin="20" v-model="value" :disabled="false" :value="value"></jfk-rater>
        </p>
        <p class="star_list_item">
          <span class="star_list_item_name">
            服&nbsp;&nbsp;&nbsp;务
          </span>
          <jfk-rater :margin="20" v-model="value" :disabled="false" :value="value"></jfk-rater>
        </p>
      </div>
    </div>

    <div class="trip_type jfk-pl-30 jfk-pr-30 font-size--30">
      <p class="title">出游类型</p>
      <ul>
        <li>商务出差</li>
        <li>商务出差</li>
        <li>商务出差</li>
        <li>商务出差</li>
        <li>商务出差</li>
        <li>商务出差</li>
      </ul>
    </div>
    <div class="comment_input jfk-pl-30 jfk-pr-30">
        <p class="title">发表评价</p>
        <textarea name="comment_content" id="comment_content" :placeholder="placeholderVal" class="font-size--30"></textarea>
        <span class="word_num">
          <span class="real_num">0</span>/200
        </span>
    </div>
    <div class="upload_file jfk-pl-30 jfk-pr-30">
      <ul>
         <li>
          <span class="add_container">
            <i class="booking_icon_font font-size--28 icon-booking_icon_addpictures_normal"></i>
            <span class="word">添加图片</span>
            <input type="file" class="file_input">
            <span class="img_con">
              <img src="https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/w%3D268%3Bg%3D0/sign=a15086bc31adcbef01347900949449e0/aec379310a55b3199a363d0d43a98226cefc17fe.jpg" alt="">
              <i class="booking_icon_font font-size--34 icon-mall_icon_orderDetail_delete"></i>
            </span>
          </span>          
        </li>
        <li>
          <span class="add_container">
            <i class="booking_icon_font font-size--28 icon-booking_icon_addpictures_normal"></i>
            <span class="word">添加图片</span>
            <input type="file" class="file_input">
            <span class="img_con" v-show="false">
              <img src="https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/w%3D268%3Bg%3D0/sign=a15086bc31adcbef01347900949449e0/aec379310a55b3199a363d0d43a98226cefc17fe.jpg" alt="">
              <i class="booking_icon_font font-size--34 icon-mall_icon_orderDetail_delete"></i>
            </span>
          </span>          
        </li>
      </ul>
      <div class="submit_comment">
       <p>
          <i class="booking_icon_font font-size--34 icon-font_zh_li_qkbys"></i>
          <i class="booking_icon_font font-size--34 icon-font_zh_ji_qkbys"></i>
          <i class="booking_icon_font font-size--34 icon-font_zh_ping_qkbys"></i>
          <i class="booking_icon_font font-size--34 icon-font_zh_jia_qkbys"></i>
       </p>
      </div>
    </div>
    <p class="color-golden" v-show="isLoadProduct">正在加载商品</p>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
import { getPackageLists } from '@/service/http'
let layouts = ['card', 'pic']
export default {
  name: 'app',
  components: {
  },
  beforeCreate () {
    let params = formatUrlParams(location.href)
    let layout = 'card'
    if (params.layout !== undefined) {
      layout = layouts[params.layout] || layouts[0]
    }
    this.layout = layout
  },
  data () {
    let that = this
    return {
      placeholderVal: '亲~ 住的舒服吗？服务满意吗？ \n留个脚印吧~',
      advs: [],
      products: [],
      disableLoadProduct: false,
      isLoadProduct: false,
      categories: [],
      tabbarItems: [],
      page: 1,
      fcid: '-1',
      detailUrlPrefix: 'javascript:;',
      showAdsCat: 1,
      curCategoryIndex: 0,
      pageSize: 20,
      tabSwiperOptions: {
        autoplay: 0,
        slidesPerView: 'auto',
        slideToClickedSlide: true,
        notNextTick: true,
        onTap: function (swiper) {
          let idx = swiper.clickedIndex
          if (idx !== that.curCategoryIndex) {
            that.curCategoryIndex = idx
            try {
              let cid = swiper.clickedSlide.dataset.cid
              if (cid) {
                that.fcid = cid
                that.disableLoadProduct = false
                that.page = 1
                that.loadPackages(true)
              }
            } catch (e) {
              console.log(e)
            }
          }
        }
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
        const { advs, categories, products, page_resource } = res.web_data
        /* eslint camelcase: 0 */
        const { page = 1, size = 20, count = 0, link = {} } = page_resource
        if (resetProducts) {
          that.products = products
        } else {
          that.products = that.products.concat(products)
        }
        if (that.showAdsCat === 1) {
          that.detailUrlPrefix = link.detail
          that.showAdsCat = 2
          that.advs = advs
          that.categories = [{cat_id: '-1', cat_name: '全部商品'}].concat(categories)
          that.tabbarItems = [{
            link: link.home,
            text: '首页',
            icon: 'icon-mall_icon_home'
          }, {
            link: link.order,
            text: '订单',
            icon: 'icon-user_icon_Onlineboo'
          }, {
            link: link.center,
            text: '我的',
            icon: 'icon-mall_icon_home_user'
          }]
        }
        that.disableLoadProduct = page * size >= count
        if (!that.disableLoadProduct) {
          that.page = +page + 1
        }
      }).catch(function (e) {
        that.isLoadProduct = false
        console.log(e)
      })
    },
    loadMore () {
      this.disableLoadProduct = true
      this.loadPackages()
    }
  }
}
</script>
