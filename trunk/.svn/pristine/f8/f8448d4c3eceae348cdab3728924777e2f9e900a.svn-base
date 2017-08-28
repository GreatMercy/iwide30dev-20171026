<template>
  <div v-loading="loading">
    <el-steps class="jfk-steps--bg-gray jfk-steps" :active="step" finish-status="success" align-center center :key="steps.length">
      <el-step
        v-for="item in steps"
        :title="item.meta.title"
        :key="item.path">
      </el-step>
    </el-steps>
    <div class="jfk-pages jfk-pages__pancake-info">
      <transition name="fade">
        <router-view class="view"></router-view>
      </transition>
    </div>
  </div>
</template>
<script>
</script>
