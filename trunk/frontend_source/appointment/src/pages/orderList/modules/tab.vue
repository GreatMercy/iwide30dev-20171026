<template>
  <div>
    <div class="order-tab dp-f">
      <a href="javascript:void(0)" class="dp-b flex-1 pr ta-c f32" v-for="item in list" v-html="item.text" :id="item.id"
         :class="{'active': item.id === activeId}" @click="selectTab(item.id)"></a>
    </div>

    <order :orderList="orderList" :orderLength="orderLength"></order>
  </div>
</template>

<script>
  import order from './order'
  import { getQueryString } from '@/common/js/browser'
  export default {
    data () {
      return {
        list: [{
          'id': 0,
          'text': '全部订单'
        }, {
          'id': 2,
          'text': '已消费'
        }, {
          'id': 1,
          'text': '待消费'
        }],
        activeId: ''
      }
    },
    components: {
      order
    },
    computed: {
      orderList () {
        return this.$store.getters.currentOrderList || {}
      },
      orderLength () {
        if (typeof this.$store.getters.currentOrderList.list === 'undefined') {
          return 0
        } else {
          return this.$store.getters.currentOrderList.list.length || 0
        }
      }
    },
    methods: {
      selectTab (id) {
        this.activeId = id
        this.$store.commit('updateActiveId', parseInt(id))
        this.$store.dispatch('getOrderList', {
          'type': id,
          'operation': 'tab'
        })
      }
    },
    mounted () {
      let currentId = getQueryString('current_id')
      if (this.activeId === '' && !!currentId === false) {
        this.activedId = this.list[0].id
      }
      if (currentId) {
        this.activedId = parseInt(currentId)
      }
      this.selectTab(this.activedId)
    }
  }
</script>

<style scoped lang="scss">
  @import "../../../common/scss/include";

  .order-tab {
    padding: px2rem(44) 4% 0;
    margin-bottom: px2rem(54);

    a {
      color: $gray;
      border-right: 1px solid $borderColor;

      &:last-child {
        border-right: none;
      }

      &.active {
        color: $white;
        &:after {
          position: absolute;
          content: '';
          width: 100%;
          height: px2rem(15);
          background: url(../img/active.png) center center no-repeat;
          background-size: contain;
          bottom: - px2rem(30);
          left: 0;
        }
      }

    }
  }

</style>
