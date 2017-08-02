<template>
  <div class="post-wrap">
    <el-tabs v-model="activeName" @tab-click="handleClick">
      <el-tab-pane label="全部" name="0">
        <div>
          <jfk-list :type="'0'"></jfk-list>
        </div>
      </el-tab-pane>
      <el-tab-pane label="未发货" name="1">
        <div>
          <jfk-list :type="'1'"></jfk-list>
        </div>
      </el-tab-pane>
      <el-tab-pane label="已发货" name="2">
        <div>
          <jfk-list :type="'2'"></jfk-list>
        </div>
      </el-tab-pane>
    </el-tabs>
    <jfk-dialog :dialogFormVisible="express_dialog_visible"></jfk-dialog>
  </div>
</template>
<script>
  import jfkList from './module/list.vue'
  import jfkDialog from './module/dialog'
  import { mapActions, mapMutations, mapGetters } from 'vuex'
  export default {
    components: {
      jfkList,
      jfkDialog
    },
    computed: {
      ...mapGetters(['express_dialog_visible'])
    },
    data () {
      return {
        activeName: '0'
      }
    },
    created () {
      this.UPDATE_TABLE_LOADING(true)
      this.GET_EXPRESS_ORDER_LIST(true)
    },
    methods: {
      ...mapActions([
        'GET_EXPRESS_ORDER_LIST',
        'GET_EXPRESS_PROVIDERS'
      ]),
      ...mapMutations([
        'UPDATE_EXPRESS_STATUS',
        'UPDATE_EXPRESS_TABS',
        'UPDATE_TABLE_LOADING'
      ]),
      handleClick (tab, event) {
        this.UPDATE_EXPRESS_TABS(this.activeName)
        this.UPDATE_TABLE_LOADING(true)
        this.GET_EXPRESS_ORDER_LIST(false)
      }
    }
  }
</script>
<style lang="postcss" scoped>

  .post-wrap {
    padding: 30px;
    margin: 0;
    background: #ffffff;
    .jfk-container {
      padding: 15px 20px;
    }

  }
</style>
