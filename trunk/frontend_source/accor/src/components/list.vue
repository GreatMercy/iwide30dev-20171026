<template>
  <div class="page_list" :style="{height: maxHeight }">
    <div class="main">
      <div class="leftmenu">
        <ul class="list" >
          <li :class="{active: idx == currentIdx}" v-for="(item, idx) in listData" @click="handleCity(idx)">{{item.city}}</li>
        </ul>
      </div>
      <div class="rightcontent">
        <ul>
          <li v-for="(item,idx) in listData[currentIdx].data">
            <a :href="linkPrefix + item.tkid + '&brandname=' + item.brandname">
              <img :src="'./static/img/small/'+item.image" />
              <div class="hotelinfo">
                <h3>{{item.hotel}}</h3>
                <p><span>{{item.place}}</span><i class="tomall">进入商城</i></p>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
import accor from '@/accorfile/accor.json'
import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
const mainCity = ['beijing', 'shanghai', 'guangzhou', 'nanjing', 'xian']
// console.log(accor)
export default {
  name: 'list',
  data () {
    return {
      msg: 'haha',
      accor: accor,
      listData: [],
      currentIdx: 0
    }
  },
  beforeCreate () {
    this.maxHeight = document.documentElement.clientHeight + 'px'
    this.params = formatUrlParams(window.location.hash)
    this.linkPrefix = 'http://jx.jinfangka.com/index.php/soma/package/index/?id=a502245149&catid=&tkid='
    if (process.env.NODE_ENV === 'development') {
      this.linkPrefix = 'http://' + location.hostname + ':8080?id=a502245149&catid=&tkid='
    }
  },
  created () {
    this.handleAccordata()
  },
  methods: {
    handleAccordata () {
      const data = this.accor
      let result = []
      let map = {}
      for (let i in data) {
        let item = data[i]
        if (!map[item.city]) {
          result.push({
            city: item.city,
            hotel: item.hotel,
            brand: item.brand,
            cityname: item.cityname,
            data: [item]
          })
          map[item.city] = item
        } else {
          for (let j in result) {
            let itemj = result[j]
            if (itemj.city === item.city) {
              itemj.data.push(item)
              break
            }
          }
        }
      }
      let maincityData = []
      result.forEach((item, idx) => {
        mainCity.forEach((itemcity, index) => {
          if (item.cityname.toLowerCase() === itemcity) {
            maincityData.push(item)
            result.splice(idx, 1)
          }
        })
      })
      result = maincityData.concat(result)
      this.listData = result
      if (this.params) {
        maincityData.forEach((item, idx) => {
          if (this.params.city.toLowerCase() === item.cityname) {
            this.currentIdx = idx
            return
          }
        })
      }
    },
    handleCity (idx) {
      this.currentIdx = idx
    }
  },
  computed: {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style >

</style>
