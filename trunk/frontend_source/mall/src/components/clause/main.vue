<template>
  <div>
    <div class="jfk-clause jfk-ta-c jfk-pl-30 jfk-pr-30">
      <div class="jfk-clause__title font-size--28">
        <span v-text="title"></span>
      </div>
    </div>
    <ul class="jfk-clause__list" v-for="(item, index) in list" :key="index" v-if="!onlyShowTitle">
      <li class="font-size--24" v-text="item"></li>
    </ul>
  </div>
</template>

<script>
  export default {
    props: {
      title: {
        type: String,
        default: ''
      },
      list: {
        type: Array,
        default: function () {
          return []
        }
      },
      onlyShowTitle: {
        type: Boolean,
        default: false
      }
    }
  }
</script>
