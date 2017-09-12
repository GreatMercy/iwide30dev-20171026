<template>
  <div class="rewardList">
      <div class="filter-menu-box" :class="{showgraybg: showSelectlist}" @click="handleFilter()">
        <div class="filter-menu Ltac font-size--26"  :class="{'color_main': showSelectlist}" >
        {{sortMsg[sort]}}
          <i class="iconfont icon-home_icon_Jump_norma arrow" :class="{'color_main': showSelectlist}" ></i>
        </div>
          <div class="selectlist " v-if="showSelectlist">
            <div class="item font-size--26" :class="{'color_main': sort == idx}" v-for="(item, idx) in sortMsg" @click.stop="handleSelectbtn(idx)" >{{item}}<span class="selectBtn " :class="{'bg_main': sort == idx}" ><i class="iconfont icon-duigou" v-if="sort == idx"></i></span></div>
          </div>     
      </div>
      <div class="list-box" v-infinite-scroll="loadMore" infinite-scroll-distance="10" infinite-scroll-disabled="disableLoadProduct">
        <div class="item" v-for="item in goodsData">
          <div class="goods-info">
            <a :href="item.detail">
              <img :src="item.face_img" />
              <div class="intro">
                <h3 class="font-size--26">{{item.name}}</h3>
                <p class="saleinfo font-size--24">已售<span class="num">{{item.sales_cnt}}</span><span class="price">{{pricetag[item.tag] ? pricetag[item.tag] : '惊喜价'}}：￥{{item.price_package}}</span> </p>
              </div>
            </a>
          </div>
          <div class="buy-info font-size--26">
            <div class="rewardNum">奖励金额<span v-if="item.reward_type == 2">{{rewardpercentFunc(item.reward_percent)}}</span><span v-if="item.reward_type == 2">({{item.reward_money}})</span><span v-else>{{item.reward_money}}</span></div>
            <div class="buybtn bg_main" @click="handleQrcode(item.detail, item.name)" ><i class="iconfont icon-mall_icon_pay_focus"></i><span>面对面购买</span></div>
          </div>
        </div> 
        <p class="products-list__loading color_main" v-show="!showFullLoading && isLoadProduct" >
          <span class="jfk-loading__triple-bounce color-golden font-size--24">
            <i class="jfk-loading__triple-bounce-item"></i>
            <i class="jfk-loading__triple-bounce-item"></i>
            <i class="jfk-loading__triple-bounce-item"></i>
          </span>
        </p>                     
      </div>
      <!-- 弹窗 -->
      <div class="popWindow" v-if="showPopWindow">
        <div class="mainbox">
            <div class="cardmain">
              <div class="close" @click="handleClick()">
                <i class="iconfont icon-icon_close " ></i>
              </div>
              <h2 class="font-size--30">{{popHotelname}}</h2>
              <img src="../assets/images/codetitle.png" class="codetitle"/>
              <div style="min-height: 277px;margin-top: 0px;">
                <!-- <img :src="popQrcode" class="codeimg"/> -->
                <qriously :value="popQrcode" :size="255" />
              </div>
            </div>
        </div>
      </div>
      <!-- 无内容 -->
    <div class="none " v-if="noGoods">
      <div class="main" v-if="shownogoodsContent">
        <i class="iconfont icon-mall_icon_reward font-size--120"></i>
        <p class="tip1 font-size--28">暂无奖励商品</p>
        <p class="tip2 font-size--24">点击生成二维码，客人扫码购买后<br>
也将记录您的推荐信息</p>
          <div class="buybtn bg_main font-size--28"  @click="handleQrcode(attachQrcode)">生成二维码</div>
      </div>
    </div>  
  </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
Vue.use(axios)
const priceTag = {
  '1': '专属价',
  '2': '秒杀价',
  '3': '拼团价',
  '4': '满减价',
  '5': '组合价',
  '6': '储值价',
  '7': '积分价'
}
export default {
  name: 'rewardList',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      page: 1,
      sort: 1,
      sortMsg: {
        '1': '销量从高到低',
        '2': '奖励从高到低'
      },
      showSelectlist: false,
      goodsData: [],
      showPopWindow: false,
      popQrcode: '',
      disableLoadProduct: false,
      showFullLoading: true,
      isLoadProduct: false,
      noGoods: false,
      popHotelname: '',
      mainColor: '',
      pricetag: priceTag,
      attachQrcode: '',
      shownogoodsContent: true,
      rewardpercentFunc: function (val) {
        let value = String(val * 10000 / 100)
        return value.substring(0, value.indexOf('.') + 3) + '%'
      }
    }
  },
  beforeCreate () {
    this.toast = this.$jfkToast({
      duration: -1,
      iconClass: 'jfk-loading__snake',
      isLoading: true
    })
  },
  created () {
  },
  methods: {
    loadMore () {
      this.disableLoadProduct = true
      this.loadPages()
    },
    loadPages (resetProducts) {
      this.isLoadProduct = true
      let params = {
        page: this.page,
        sort: this.sort
      }
      if (process.env.NODE_ENV === 'development') {
        params.id = 'a450089706'
        params.openid = 'o9VbtwzF1rt_bNF2XOBPIHr9-tuw'
      }
      axios.get('/index.php/iapi/soma/package/distribute_products', {params}).then((res) => {
        this.isLoadProduct = false
        this.toast.close()
        const { page_resource = {}, product_info, attach } = res.data.web_data
        /* eslint camelcase: 0 */
        const { count, page, size } = page_resource
        if (res.data.status === 1000) {
          if (resetProducts) {
            this.goodsData = product_info
          } else {
            this.goodsData = this.goodsData.concat(product_info)
          }
          if (!this.goodsData.length) {
            this.noGoods = true
            this.attachQrcode = attach.index
          }
          this.showFullLoading = false
        }
        this.disableLoadProduct = page * size >= count
        if (!this.disableLoadProduct) {
          this.page = +page + 1
        }
      }).catch((err) => {
        alert(err)
      })
    },
    handleFilter () {
      if (!this.showSelectlist) {
        this.showSelectlist = true
      } else if (this.showSelectlist) {
        this.showSelectlist = false
      }
    },
    handleSelectbtn (idx) {
      if (parseInt(idx) !== parseInt(this.sort)) {
        this.sort = idx
        this.disableLoadProduct = true
        this.goodsData = []
        this.page = 1
        this.showSelectlist = false
        this.loadPages(true)
      }
    },
    handleQrcode (productDetail, hotelname) {
      // axios.get('/index.php/iapi/soma/package/distribute_qrcode', {params}).then((res) => {
      //   this.popQrcode = res.data
      // }).catch((err) => {
      //   console.log(err, 'cuowu')
      // })
      this.popQrcode = productDetail
      this.popHotelname = hotelname
      this.showPopWindow = true
      if (this.noGoods) {
        this.shownogoodsContent = false
      }
    },
    handleClick () {
      if (this.noGoods) {
        this.shownogoodsContent = true
      }
      this.showPopWindow = false
    }
  },
  mounted () {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
/* .color_main{
  color: #ff9900;
}
.bg_main{
  background-color: #ff9900;
} */

</style>
