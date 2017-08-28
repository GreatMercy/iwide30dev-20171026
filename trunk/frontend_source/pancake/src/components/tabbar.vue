<template>
  <div class="pancake-tabbar">
    <div class="tabbar-list jfk-flex is-justify-space-between jfk-ta-c is-align-middle">
      <a
        class="tabbar-item"
        v-for="(item, index) in items"
        :key="index"
        :href="item.link"
        :class="{'is-selected color-golden': index === selected, 'font-color-white': index !== selected}">
        <div class="tabbar-item__cont">
          <i class="tabbar-item__icon jfk-font font-size--36" :class="item.icon"></i>
          <p class="tabbar-item__label font-size--20">{{item.text}}</p>
        </div>
      </a>
    </div>
  </div>
</template>
<script>
  let jfkConfig = window.jfkConfig
  if (process.env.NODE_ENV === 'development') {
    jfkConfig = {
      indexUrl: '/index',
      rankingUrl: '/rank',
      recordUrl: '/record'
    }
  }
  export default {
    name: 'pancake-tabbar',
    data () {
      return {
        items: [
          {
            text: '博饼首页',
            icon: 'icon-bottom_icon_home_normal',
            link: jfkConfig.indexUrl
          },
          {
            text: '群友排行榜',
            icon: 'icon-bottom_icon_ranking_normal',
            link: jfkConfig.rankingUrl
          },
          {
            text: '个人战绩',
            icon: 'icon-bottom_icon_record_normal',
            link: jfkConfig.recordUrl
          }
        ]
      }
    },
    props: {
      selected: {
        type: Number,
        required: true,
        default: 0
      }
    }
  }
</script>
