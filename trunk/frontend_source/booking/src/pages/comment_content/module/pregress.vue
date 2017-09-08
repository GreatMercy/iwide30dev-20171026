<template>
  <div class="pregress_list">
    <div class="pregress_item font-size--24">
      <span v-if="comment_config.clean_score" class="name">{{comment_config.clean_score}}</span>
      <span v-else>卫生</span>
      <div class="pregress">
        <span class="bar" :style="{width: allWidth.clean}"></span>
      </div>
      <span class="grayColor80">{{score.comment_score}}</span>
    </div>
    <div class="pregress_item font-size--24">
      <span v-if="comment_config.facilities_score" class="name">{{comment_config.facilities_score}}</span>
      <span v-else class="name">设施</span>
      <div class="pregress">
        <span class="bar" :style="{width: allWidth.facilities}"></span>
      </div>
      <span class="grayColor80">{{score.facilities_score}}</span>
    </div>
    <div class="pregress_item font-size--24">
      <span v-if="comment_config.service_score" class="name">{{comment_config.service_score}}</span>
      <span v-else class="name">服务</span>
      <div class="pregress">
        <span class="bar" :style="{width: allWidth.service}"></span>
      </div>
      <span class="grayColor80">{{score.service_score}}</span>
    </div>
    <div class="pregress_item font-size--24">
      <span v-if="comment_config.net_score" class="name">{{comment_config.net_score}}</span>
      <span v-else class="name">网络</span>
      <div class="pregress">
        <span class="bar" :style="{width: allWidth.net}"></span>
      </div>
      <span class="grayColor80">{{score.net_score}}</span>
    </div>
  </div>

</template>
<script>
  export default {
    name: 'pregress',
    props: ['comment_config', 'score', 'allWidth']
  }
</script>
