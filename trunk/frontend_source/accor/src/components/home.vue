<template>
  <div class="page_home">
    <div class="topbanner">
      <swiper :options="swiperOption" >
          <swiper-slide >
            <a>
              <img src="../assets/swiper_banner.jpg"></img>
            </a>
          </swiper-slide>
          <swiper-slide >
            <a>
              <img src="../assets/swiper_banner.jpg"></img>
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
          <swiper-slide >
            <router-link to="/list?city=beijing">
              <img src="../assets/beijing.jpg"></img>
              <p class="tab"><i></i>北京<span>Beijing</span></p>
            </router-link>
          </swiper-slide>
          <swiper-slide >
            <router-link to="/list?city=shanghai">
              <img src="../assets/shanghai.jpg"></img>
              <p class="tab"><i></i>上海<span>Shanghai</span></p>
            </router-link>
          </swiper-slide>   
          <swiper-slide >
            <router-link to="/list?city=guangzhou">
              <img src="../assets/guangzhou.jpg"></img>
              <p class="tab"><i></i>广州<span>Guangzhou</span></p>
            </router-link>
          </swiper-slide> 
          <swiper-slide >
            <router-link to="/list?city=nanjing">
              <img src="../assets/nanjing.jpg"></img>
              <p class="tab"><i></i>南京<span>Nanjing</span></p>
            </router-link>
          </swiper-slide> 
          <swiper-slide >
            <router-link to="/list?city=xian">
              <img src="../assets/xian.jpg"></img>
              <p class="tab"><i></i>西安<span>Xian</span></p>
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
      <a>
        <img src="../assets/food.jpg"></img>
      </a>
      <a>
        <img src="../assets/gift.jpg"></img>
      </a>
      <a>
        <img src="../assets/spa.jpg"></img>
      </a>            
    </div>
    <h2 class="subtitle">我们的品牌</h2>
    <div class="brand">
      <swiper :options="swiperOption3" >
          <swiper-slide >
            <a>
              <img src="../assets/mercure.png"></img>
            </a>
          </swiper-slide>
          <swiper-slide >
            <a>
              <img src="../assets/ibis.png"></img>
            </a>
          </swiper-slide>
          <swiper-slide >
            <a>
              <img src="../assets/meiju.png"></img>
            </a>
          </swiper-slide> 
          <swiper-slide >
            <a>
              <img src="../assets/novotel.png"></img>
            </a>
          </swiper-slide>           
          <div class="swiper-button-prev " slot="button-prev"></div>
          <div class="swiper-button-next" slot="button-next"></div>                             
      </swiper>   

    </div>
    <h2 class="subtitle">精选必看</h2>
    <div class="bestSelect">
      <img src="../assets/bestBanner.jpg" class="bigbanner"></img>
      <div class="twoimg">
        <a>
          <img src="../assets/join.jpg"></img>
        </a>
        <a>
          <img src="../assets/downloadapp.jpg"></img>
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
      banners: [ 'http://7n.cdn.iwide.cn/public/uploads/201702/qf271337095540.jpg', 'http://7n.cdn.iwide.cn/public/uploads/201702/qf271337095540.jpg', 'http://7n.cdn.iwide.cn/public/uploads/201702/qf271337095540.jpg' ],
      bestPlace: ['http://7n.cdn.iwide.cn/public/uploads/201702/qf271337095540.jpg', 'http://7n.cdn.iwide.cn/public/uploads/201702/qf271337095540.jpg', 'http://7n.cdn.iwide.cn/public/uploads/201702/qf271337095540.jpg', 'http://7n.cdn.iwide.cn/public/uploads/201702/qf271337095540.jpg'],
      productGalleryIndex: 1,
      swiperOption: {
        autoplay: 5000,
        initialSlide: 1,
        loop: true,
        productGalleryIndex: 1,
        onSlideChangeEnd: swiper => {
          this.productGalleryIndex = swiper.realIndex + 1
        }
      },
      swiperOption2: {
        productGalleryIndex: 1,
        spaceBetween: 10,
        slidesPerView: 1.5,
        onSlideChangeEnd: swiper => {
          this.productGalleryIndex = swiper.realIndex + 1
        }
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
