<template>
  <div class="jfk-pages__modules jfk-pages__modules-goods">
    <div class="jfk-mb-20 jfk-ta-r">
      <el-button type="info" size="small" :plain="true" class="jfk-button-tag-a">
        <a :href="links.add" class="goods_add" target="_blank"><i class="el-icon-plus"></i>&nbsp;新增商品</a></el-button>
      <el-button type="primary" size="small" @click="handleSyncGood">同步商品</el-button>
    </div>
    <div v-loading="loading">
      <el-table
        ref="goodsInfoTable"
        :data="goods"
        class="jfk-table--no-border"
        tooltip-effect="dark"
        style="width: 100%"
        row-key="goods_id"
        @selection-change="handleSelectionGoodsChange">
        <el-table-column
          type="selection"
          label="选择"
          prop="goods_id"
          :selectable="goodsInfoSelectable"
          reserve-selection
          width="55">
        </el-table-column>
        <el-table-column
          show-overflow-tooltip
          prop="name"
          label="商品名称">
        </el-table-column>
        <el-table-column
          prop="price_package"
          label="商城价">
        </el-table-column>
        <el-table-column
          prop="price"
          label="订房优惠价">
        </el-table-column>
        <el-table-column
          label="销售方式">
          <template scope="scope">
            {{goodInfoSaleWay === 1 ? '包价' : '自由组合'}}
          </template>
        </el-table-column>
        <el-table-column
          label="库存">
          <template scope="scope">
            {{scope.row.stock}}
            <el-button size="mini" type="danger" v-show="showStockTip(scope.row)">加库存</el-button>
          </template>
        </el-table-column>
        <el-table-column
          label="数量">
          <template scope="scope">
            <el-select size="small" :disabled="disabledChangeGoodMaxNum(scope.row.goods_id)" v-model="scope.row.good_max_num" @change="handleChangeGoodMaxNum(scope.row.goods_id, $event)">
              <el-option
                v-for="item in 10"
                :key="item"
                :label="item"
                :value="item">
              </el-option>
            </el-select>
          </template>
        </el-table-column>
      </el-table>
      <el-row class="jfk-mt-20 jfk-mb-20">
        <el-col :span="12" class="jfk-fz-12 jfk-color--base-gray jfk-lh--32">共{{count}}个商品，已选择{{goodInfoItemsNumber}}个商品
        <span class="jfk-color--warning" v-show="goodInfoItemsNumber >= goodItemsMaxSelectionCount">
          （最多选择{{goodItemsMaxSelectionCount}}个商品，请删除后再添加其余商品）
        </span></el-col>
        <el-col :span="12" class="jfk-ta-r">
          <el-pagination
            class="jfk-d-ib"
            v-show="count > size"
            @current-change="handleGoodInfosCurrentChange"
            :current-page.sync="page"
            :page-size="size"
            :total="count"
            layout="prev, pager, next, jumper">
          </el-pagination>
        </el-col>
      </el-row>
    </div>
    <el-row type="flex" justify="center">
      <el-button @click.native.prevent="handlePrevStep" size="large" class="jfk-button--middle">上一步</el-button>
      <el-button @click.native.prevent="handleNextStep" size="large" class="jfk-button--middle" type="primary">下一步</el-button>
    </el-row>
  </div>
</template>
<script>
  import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'
  import { GET_HOTEL_GOODS_ACTION, CODE_INFO, UPDATE_PRICE_STEP, CLEAN_HOTEL_GOODS, UPDATE_HOTEL_NUM } from '@/service/booking/types'
  import routerConfig from '../router/config'
  const hardCodeSelection = function (val, ctx) {
    let selection = ctx.$refs.goodsInfoTable.store.states.selection
    val.forEach(function (good) {
      if (ctx.goodInfoItems.items[good.goods_id] && selection.indexOf(good) === -1) {
        selection.push(good)
      }
    })
  }
  export default {
    data () {
      return {
        page: 1,
        size: 10,
        goodItemsMaxSelectionCount: 10,
        // 是否对当前页进行硬编码selection
        pageHasHardCodeSelection: {}
      }
    },
    methods: {
      ...mapActions('goods', [
        GET_HOTEL_GOODS_ACTION
      ]),
      ...mapMutations('goods', [
        CLEAN_HOTEL_GOODS
      ]),
      ...mapMutations([
        UPDATE_PRICE_STEP
      ]),
      ...mapMutations('form', [
        CODE_INFO,
        UPDATE_HOTEL_NUM
      ]),
      handleChangeGoodMaxNum (goodId, value) {
        this[UPDATE_HOTEL_NUM]({
          gs_id: goodId,
          num: value
        })
      },
      handleSelectionGoodsChange (checkedSelection) {
        console.log(checkedSelection)
        // 提交到form中
        let items = {}
        checkedSelection.forEach(function (selection) {
          items[selection.goods_id] = {
            gs_id: selection.goods_id,
            num: selection.good_max_num
          }
        })
        this[CODE_INFO]({goods_info: {
          items: items
        }})
      },
      handleGoodInfosCurrentChange (page) {
        // 判断是不需要走缓存
        let start = this.size * (page - 1)
        let hasCacheData = this.goodIds[start]
        if (!hasCacheData) {
          this[GET_HOTEL_GOODS_ACTION]({
            page: this.page,
            size: this.size
          })
        }
        this.page = page
      },
      goodsInfoSelectable (row, index) {
        if (this.goodInfoItemsNumber >= this.goodItemsMaxSelectionCount) {
          if (this.goodInfoItems.items[row.goods_id]) {
            return true
          }
          return false
        }
        return true
      },
      handleNextStep () {
        if (this.goodInfoItemsNumber === 0) {
          this.$alert('开启套餐属性必须关联商品', {
            title: '温馨提示',
            type: 'error'
          })
        } else if (this.goodInfoItemsNumber > this.goodItemsMaxSelectionCount) {
          this.$alert('套餐最多关联' + this.goodItemsMaxSelectionCount + '个商品，请删除多余商品再进行下一步', {
            title: '温馨提示',
            type: 'error'
          })
        } else {
          this[UPDATE_PRICE_STEP]({
            increment: true
          })
        }
      },
      handlePrevStep () {
        this[UPDATE_PRICE_STEP]({
          increment: false
        })
      },
      handleSyncGood () {
        // 同步商品，清空缓存并从首页开始添加
        this[CLEAN_HOTEL_GOODS]()
        this.page = 1
        this.pageHasHardCodeSelection = {}
        this[GET_HOTEL_GOODS_ACTION]({
          page: this.page,
          size: this.size
        })
      },
      disabledChangeGoodMaxNum (goodId) {
        if (this.goodInfoItems.items[goodId]) {
          return false
        }
        return true
      },
      showStockTip (good) {
        if (this.goodInfoItems.items[good.goods_id] && good.stock < good.good_max_num) {
          return true
        }
        return false
      }
    },
    computed: {
      ...mapState('form', [
        'goodInfoSaleWay',
        'isPackages',
        'goodInfoItems'
      ]),
      ...mapState('goods', [
        'goodIds',
        'goodItems',
        'count',
        'links',
        'loading'
      ]),
      ...mapGetters('form', [
        'goodInfoItemsNumber'
      ]),
      goods () {
        let goodDatas = []
        if (this.goodIds.length) {
          let start = (this.page - 1) * this.size
          let end = this.page * this.size
          while (start < end) {
            let goodId = this.goodIds[start]
            if (goodId) {
              let checkedGood = this.goodInfoItems.items[goodId]
              let _goodItem = this.goodItems[goodId]
              if (_goodItem.good_max_num === undefined) {
                _goodItem.good_max_num = checkedGood && checkedGood.num || 1
              }
              goodDatas.push(_goodItem)
            }
            start++
          }
        }

        return goodDatas
      }
    },
    watch: {
      goods (val) {
        if (val.length && !this.pageHasHardCodeSelection[this.page]) {
          hardCodeSelection(val, this)
          this.pageHasHardCodeSelection[this.page] = true
        }
      }
    },
    beforeRouteEnter (to, from, next) {
      next(vm => {
        if (vm.isPackages !== '1') {
          return next({
            path: routerConfig[0].path
          })
        }
        if (!vm.goodIds[0]) {
          // 先判断是否有缓存
          vm[GET_HOTEL_GOODS_ACTION]({
            page: vm.page,
            size: vm.size
          })
        } else {
          // 如果走缓存，需要刚进入页面就开始硬编码是否选中
          if (vm.goods && vm.goods.length) {
            hardCodeSelection(vm.goods, vm)
            vm.pageHasHardCodeSelection[vm.page] = true
          }
        }
      })
    }
  }
</script>
