<template>
  <div class="page_brand">
    <div class="banner">
      <img :src="'./static/img/brandbanner/'+brandData.banner" />
    </div>
    <div class="brandintro">
      <img :src="'./static/img/swiperbrandlogo/'+brandData.logo" />
      <p>{{brandData.des}}</p>
    </div>
    <div class="suspend">
      <h2 >{{brandData.brandname}}推荐酒店</h2>
      <img src="../assets/linegap.png" class="linegap"/>
      <div class="item" v-for="(item,idx) in brandHotel" >
        <a :href="linkPrefix + item.tkid + '&brandname=' + item.brandname">
          <div :style="{'background-image': 'url(./static/img/hotelbanner/'+item.hotelbanner+')'}" class="hotelbanner"></div>
          <div class="hotelinfo">
            <h3>{{item.hotel}}</h3>
            <div class="position"><i></i><span>{{item.place}}</span></div>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import brand from '@/accorfile/brand.json'
import accor from '@/accorfile/accor.json'
import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
export default {
  name: 'brand',
  data () {
    return {
      msg: 'haha',
      brand: brand,
      accor: accor,
      brandData: {},
      brandHotel: []
    }
  },
  beforeCreate () {
    document.body.scrollTop = 0
    this.params = formatUrlParams(window.location.hash)
    console.log(window.location)
    this.linkPrefix = 'http://jx.jinfangka.com/index.php/soma/package/index/?id=a502245149&catid=&tkid='
    if (process.env.NODE_ENV === 'development') {
      this.linkPrefix = 'http://' + location.hostname + ':8080?id=a502245149&catid=&tkid='
    }
    document.scrollTop
  },
  created () {
    this.brand.forEach((item) => {
      if (item.brand === this.params.brand) {
        this.brandData = item
      }
    })
    this.handleAccordata(this.params)
  },
  methods: {
    handleAccordata () {
      const data = this.accor
      let result = []
      let map = {}
      for (let i in data) {
        let item = data[i]
        if (!map[item.brand]) {
          result.push({
            brand: item.brand,
            data: [item],
            brandname: item.brandname
          })
          map[item.brand] = item
        } else {
          for (let j in result) {
            let itemj = result[j]
            if (itemj.brand === item.brand) {
              itemj.data.push(item)
              break
            }
          }
        }
      }
      if (this.params) {
        result.forEach((item, idx) => {
          if (this.params.brand === item.brandname) {
            this.brandHotel = item.data
            return
          }
        })
      }
      console.log(this.brandHotel)
      // console.log(this.params)
    }
  },
  computed: {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style >

</style>

