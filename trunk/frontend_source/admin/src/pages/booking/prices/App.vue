<template>
  <div v-loading="loading">
    <el-steps class="jfk-steps--bg-gray jfk-steps" :active="step" finish-status="success" align-center center :key="steps.length">
      <el-step v-for="item in steps" :title="item.meta.title" :key="item.path"></el-step>
    </el-steps>
    <div class="jfk-pages jfk-pages__price">
      <transition name="fade">
        <router-view class="view"></router-view>
      </transition>
    </div>
  </div>
</template>
<script>
  import routesConfig from './router/config'
  import { mapActions, mapState } from 'vuex'
  import { GET_PRICE_INFO } from '@/service/booking/types'
  import { formatUrlParams } from '@/utils/utils'
  let steps = routesConfig.concat()
  let goodItems = steps.splice(1, 1)[0]
  export default {
    data () {
      return {
        steps: steps,
        step: 0
      }
    },
    created () {
      let args = {
        pcode: this.pcode
      }
      if (process.env.NODE_ENV === 'development') {
        args.inter_id = this.interId
      }
      this[GET_PRICE_INFO](args)
    },
    beforeCreate () {
      let params = formatUrlParams(location.search)
      if (params.pcode) {
        this.pcode = params.pcode
      }
      if (params.inter_id) {
        this.interId = params.inter_id
      }
    },
    methods: {
      ...mapActions([
        GET_PRICE_INFO
      ])
    },
    computed: {
      ...mapState('form', [
        'isPackages'
      ]),
      ...mapState([
        'increment',
        'loading'
      ]),
      stepWidth () {
        return 1 / this.steps.length * 100 + '%'
      }
    },
    watch: {
      'isPackages': function (val) {
        if (val === '1') {
          this.steps.splice(1, 0, goodItems)
        } else {
          this.steps.splice(1, 1)
        }
      },
      '$route': function (to, from) {
        let newStep = to.meta.step
        let oldStep = from.meta.step
        if (newStep && oldStep) {
          this.step = Math.max(this.step + (newStep > oldStep ? 1 : -1), 0)
        }
      },
      'increment': function (val) {
        // 下一步
        if (val > 0) {
          this.$router.push(this.steps[this.step + 1].path)
        } else {
          this.$router.go(-1)
        }
      }
    }
  }
</script>
<style lang="postcss" scoped>
  .el-steps{
    width: 50%;
    padding: 20px 25% 15px 25%;
    box-sizing: content-box;
  }
  .jfk-pages__price{
    margin-top: 0;
    padding-top: 25px
  }
</style>
