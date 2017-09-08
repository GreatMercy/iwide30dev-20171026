<template>
  <div class="page_home">
    <div class="topbanner">
      <swiper :options="swiperOption" >
          <swiper-slide v-for="item in banners">
            <a>
              <img :src="'./static/img/'+item" />
            </a>
          </swiper-slide>
      </swiper>
      <div class="swiper-pagination swiper-pagination-fraction">
        <span class="swiper-pagination-current ">{{productGalleryIndex}}</span> / <span class="swiper-pagination-total">{{banners.length}}</span>
      </div>      
    </div>
    <h2 class="subtitle">精选目的地</h2>
    <div class="bestPlace">
      <swiper :options="swiperOption2" >
          <swiper-slide v-for="item in bestPlace">
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
      <a v-for="item in ads">
        <img :src="'./static/img/'+item" />
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
    <h2 class="subtitle">精选必看</h2>
    <div class="bestSelect" >
      <img :src="'./static/img/'+item" class="bigbanner" v-for="item in bestbanner"/>
      <div class="twoimg">
        <a v-for="item in twoimg">
          <img :src="'./static/img/'+item" />
        </a>      
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'home',
  data () {
    return {
      msg: 'haha',
      banners: [ 'swiper_banner.jpg', 'swiper_banner.jpg' ],
      bestPlace: [
        {'img': 'beijing.jpg', 'city': 'Beijing', 'cityname': '北京'},
        {'img': 'shanghai.jpg', 'city': 'Shanghai', 'cityname': '上海'},
        {'img': 'guangzhou.jpg', 'city': 'Guangzhou', 'cityname': '广州'},
        {'img': 'nanjing.jpg', 'city': 'Nanjing', 'cityname': '南京'},
        {'img': 'xian.jpg', 'city': 'Xian', 'cityname': '西安'}
      ],
      twoimg: ['join.jpg', 'downloadapp.jpg'],
      ads: ['food.jpg', 'gift.jpg', 'spa.jpg'],
      productGalleryIndex: 0,
      swiperOption: {
        autoplay: 3000,
        initialSlide: 0,
        loop: true,
        productGalleryIndex: 0,
        onSlideChangeEnd: swiper => {
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
