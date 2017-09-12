<template>
  <div class="page_home">
    <div class="topbanner">
      <swiper :options="swiperOption" >
          <swiper-slide v-for="(item,idx) in swiperBanner">
            <a href="javascript:;">
              <img :src="'./static/img/'+ item" />
            </a>
          </swiper-slide>         
      </swiper>
      <div class="swiper-pagination swiper-pagination-fraction">
        <span class="swiper-pagination-current ">{{productGalleryIndex}}</span> / <span class="swiper-pagination-total">2</span>
      </div>      
    </div>
    <h2 class="subtitle">精选目的地</h2>
    <div class="bestPlace">
      <swiper :options="swiperOption2" >
          <swiper-slide v-for="(item,idx) in bestPlace">
            <router-link :to="'/list?city='+item.city">
              <img :src="'./static/img/hotplace/'+item.img" />
              <p class="tab"><i></i>{{item.cityname}}<span>{{item.city}}</span></p>
            </router-link>
          </swiper-slide>                                       
          <swiper-slide class="seemore">
            <router-link to="/list">
                <img src="../assets/seemore.jpg"></img>
            </router-link>
          </swiper-slide>
      </swiper>
    </div>
    <div class="ads">
      <a v-for="(item,idx) in ads" :href="item.link">
        <img :src="'./static/img/'+item.img" />
      </a>            
    </div>
    <h2 class="subtitle">我们的品牌</h2>
    <div class="brand">
      <swiper :options="swiperOption3" >
          <swiper-slide >
            <router-link to="/brand?brand=raffles">
              <img src="../assets/raffles.png"></img>
            </router-link>
          </swiper-slide>         
          <swiper-slide >
            <router-link to="/brand?brand=fairmont">
              <img src="../assets/fairmont.png"></img>
            </router-link>
          </swiper-slide>
          <swiper-slide >
            <router-link to="/brand?brand=sofitel">
              <img src="../assets/sofitel.png"></img>
            </router-link>
          </swiper-slide>
          <swiper-slide >
            <router-link to="/brand?brand=pullman">
              <img src="../assets/pullman.png"></img>
            </router-link>
          </swiper-slide>
          <swiper-slide >
            <router-link to="/brand?brand=swissotel">
              <img src="../assets/swisshotel.png"></img>
            </router-link>
          </swiper-slide>
          <swiper-slide >
            <router-link to="/brand?brand=grand_mercure">
              <img src="../assets/mercure.png"></img>
            </router-link>
          </swiper-slide>
          <swiper-slide >
            <router-link to="/brand?brand=novotel">
              <img src="../assets/novotel.png"></img>
            </router-link>
          </swiper-slide>                                                      
          <swiper-slide >
            <router-link to="/brand?brand=mercure">
              <img src="../assets/meiju.png"></img>
            </router-link>
          </swiper-slide>                         
          <div class="swiper-button-prev " slot="button-prev"></div>
          <div class="swiper-button-next" slot="button-next"></div>                             
      </swiper>   

    </div>
    <h2 class="subtitle">雅高精选</h2>
    <div class="bestSelect" >
      <img :src="'./static/img/'+item" class="bigbanner" v-for="(item,idx) in bestbanner"/>
      <div class="twoimg">
        <a v-for="(item,idx) in twoimg" :href="item.href">
          <img :src="'./static/img/'+item.image" />
        </a>      
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import VueAwesomeSwiper from 'vue-awesome-swiper'
Vue.use(VueAwesomeSwiper)
export default {
  name: 'home',
  data () {
    return {
      msg: 'haha',
      swiperBanner: ['swiperbanner1.jpg', 'swiperbanner2.jpg'],
      bestPlace: [
        {'img': 'beijing.jpg', 'city': 'Beijing', 'cityname': '北京'},
        {'img': 'shanghai.jpg', 'city': 'Shanghai', 'cityname': '上海'},
        {'img': 'guangzhou.jpg', 'city': 'Guangzhou', 'cityname': '广州'},
        {'img': 'nanjing.jpg', 'city': 'Nanjing', 'cityname': '南京'},
        {'img': 'xian.jpg', 'city': 'Xian', 'cityname': '西安'}
      ],
      // twoimg: ['join.jpg', 'downloadapp.jpg'],
      twoimg: [{
        'image': 'join.jpg',
        'href': 'https://s-leclub.accorhotels.com/enrollment-light-form-loyalty1.action'
      }, {
        'image': 'downloadapp.jpg',
        'href': 'http://a.app.qq.com/o/simple.jsp?pkgname=com.accor.appli.hybrid'
      }],
      // ads: ['food.jpg', 'gift.jpg', 'spa.jpg'],
      ads: [{'img': 'food.jpg', 'link': 'http://jx.jinfangka.com/index.php/soma/package/index/?id=a502245149&tkid=429&catid='}, {'img': 'gift.jpg', 'link': 'http://jx.jinfangka.com/index.php/soma/package/index/?id=a502245149&tkid=429&catid='}, {'img': 'spa.jpg', 'link': 'http://jx.jinfangka.com/index.php/soma/package/index/?id=a502245149&tkid=429&catid='}],
      productGalleryIndex: 0,
      swiperOption: {
        autoplay: 3000,
        initialSlide: 0,
        loop: true,
        productGalleryIndex: 0,
        onSlideChangeStart: swiper => {
          this.productGalleryIndex = swiper.realIndex + 1
        }
      },
      bestbanner: ['bestBanner.jpg'],
      swiperOption2: {
        productGalleryIndex: 1,
        spaceBetween: 10,
        slidesPerView: 1.5
      },
      swiperOption3: {
        prevButton: '.brand .swiper-button-prev ',
        nextButton: '.brand .swiper-button-next',
        productGalleryIndex: 1,
        slidesPerView: 3,
        onSlideChangeEnd: swiper => {
          this.productGalleryIndex = swiper.realIndex + 1
        }
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style >

</style>
