<template>
  <div class="page_list">
    <div class="main">
      <div class="leftmenu">
        <ul class="list">
    
          <li class="active">北京</li>
          <li>北京</li>
          <li >北京</li>
        </ul>
      </div>
      <div class="rightcontent">
        <ul>
          <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲索菲特大饭店特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>
          <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>
          <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>  
          <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li> 
                    <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>           <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>           <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>           <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>           <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>           <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>           <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>           <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>           <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>           <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>           <li>
            <img src="../assets/hotelimg.jpg"></img>
            <div class="hotelinfo">
              <h3>北京万达索菲特大饭店</h3>
              <p>天安门／王府井<a>进入商城</a></p>
            </div>
          </li>                             
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import accor from '@/accorfile/accor.json'
console.log(accor)
export default {
  name: 'list',
  data () {
    return {
      msg: 'haha',
      accor: accor
    }
  },
  created () {
  },
  computed: {
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
            brand: item.brand
          })
          map[item.city] = item
        } else {
          for (let j in result) {
            let itemj = result[j]
            if (itemj.city === item.city) {
            }
          }
        }
      }
      return result
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
html,body{
    height: 100%;
    overflow-y: auto;
}
#app{
  height: 100%;
}
</style>
