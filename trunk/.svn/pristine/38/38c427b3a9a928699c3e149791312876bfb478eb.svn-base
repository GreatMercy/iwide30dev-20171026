<template>
  <div class="jfk-pages jfk-pages__package-products">
    <div class="jfk-ta-r jfk-mb-20">
      <el-button type="primary" class="jfk-button-tag-a" size="small">
        <a :href="links.add" class="goods_add" target="_blank">新增商品</a>
      </el-button>
    </div>
    <el-table
      ref="goodsInfoTable"
      :data="goods"
      class="jfk-table--no-border"
      tooltip-effect="dark"
      style="width: 100%"
      v-loading="loading"
      row-key="goods_id">
      <el-table-column
        label="编号"
        width="65px"
        align="center"
        prop="goods_id">
      </el-table-column>
      <el-table-column
        prop="goods_type"
        label="商品类型">
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
        label="库存">
        <template scope="scope">
          {{scope.row.stock + scope.row.unit}}
        </template>
      </el-table-column>
      <el-table-column
        width="110px"
        align="center"
        label="商城状态">
        <template scope="scope">
          {{scope.row.soma_status}}
        </template>
      </el-table-column>
      <el-table-column
        align="center"
        width="65px"
        label="状态">
        <template scope="scope">
          {{scope.row.status === '1' ? '有效' : '无效'}}
        </template>
      </el-table-column>
      <el-table-column
        label="有效期">
        <template scope="scope">
          {{scope.row.valid_date + '至' + scope.row.unvalid_date}}
        </template>
      </el-table-column>
      <el-table-column
        align="center"
        width="65px"
        label="操作">
        <template scope="scope">
          <i class="el-icon-edit jfk-color--primary" @click="handleChangeGoods(scope.row.goods_id)"></i>
        </template>
      </el-table-column>
    </el-table>
    <el-row class="jfk-mt-20 jfk-mb-20">
      <el-col :span="2" class="jfk-fz-12 jfk-color--base-gray jfk-lh--32">共{{count}}条</el-col>
      <el-col :span="22" class="jfk-ta-r">
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
    <el-dialog
      title="编辑商品"
      class="jfk-dialog__title--center jfk-dialog__has-message"
      :before-close="handleCloseDialogGoods"
      :visible.sync="dialogGoods">
      <div class="dialog__tip">
        <div v-show="showGoodEditingError">
          <el-alert :title="goodEditingError" type="error" show-icon :closable="false"></el-alert>
        </div>
      </div>
      <el-form
        label-width="100px"
        ref="goodEditForm"
        :rules="rules"
        :model="goodEditing">
        <el-form-item
          label="商品名称">
          <el-input v-model="goodEditing.name" disabled/>
        </el-form-item>
        <el-form-item
          label="订房优惠价"
          prop="price">
          <el-input v-model.trim="goodEditing.price" placeholder="如：房+门票组合，则填写组合中的门票单价">
            <template solt="append">元</template>
          </el-input>
        </el-form-item>
        <el-form-item
          label="单位"
          prop="unit">
          <el-input v-model.trim="goodEditing.unit"></el-input>
        </el-form-item>
        <el-form-item
          prop="sort"
          label="排序">
          <el-input v-model="goodEditing.sort"></el-input>
        </el-form-item>
        <el-form-item
          label="简短描述"
          prop="short_intro">
          <el-input type="textarea" v-model="goodEditing.short_intro"></el-input>
        </el-form-item>
        <el-form-item
          label="状态"
          prop="status">
          <el-radio label="1" v-model="goodEditing.status">有效</el-radio>
          <el-radio label="2" v-model="goodEditing.status">无效</el-radio>
        </el-form-item>
        <el-form-item class="jfk-ta-c">
          <el-button type="primary" @click="handleSaveGoodEdit" :loading="posting">{{saveGoodButtonText}}</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>
<script>
  import { mapState, mapActions, mapMutations } from 'vuex'
  import { GET_HOTEL_GOODS_ACTION } from '@/service/booking/types'
  import { UPDATE_CSRF_ITEMS } from '@/service/common/types'
  import { stringIsValidMoney } from '@/utils/utils'
  import { postHotelGoodsInfo } from '@/service/booking/http'
  const diffKeys = ['price', 'unit', 'sort', 'short_intro', 'status']
  const checkGoodInfoHasChange = function (goods, sourceGoods) {
    let result = {
      changed: false
    }
    diffKeys.forEach(function (key) {
      if (goods[key] !== sourceGoods[key]) {
        result.changed = true
      }
      if (key === 'price') {
        result.price = goods[key]
      } else {
        result[key] = goods[key]
      }
    })
    return result
  }
  export default {
    data () {
      const checkPriceIsValid = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('请填写订房优惠价'))
        } else if (!stringIsValidMoney(value)) {
          return callback(new Error('请填写合法的金额'))
        }
        return callback()
      }
      return {
        rules: {
          unit: [
            { required: true, trigger: 'blur', message: '请填写单位' }
          ],
          price: [
            { required: true, trigger: 'blur', validator: checkPriceIsValid }
          ],
          status: [
            { required: true, trigger: 'change', message: '请选择状态' }
          ],
          sort: [
            { trigger: 'blur', message: '排序必须是一个非负整数', pattern: /^\d+$/ }
          ]
        },
        posting: false,
        goodEditing: {},
        size: 20,
        page: 1,
        dialogGoods: false,
        goodEditingError: ''
      }
    },
    created () {
      // this.loadInstance = this.$loading()
      this[GET_HOTEL_GOODS_ACTION]({
        page: this.page,
        size: this.size,
        status: 'all'
      })
    },
    computed: {
      ...mapState([
        'count',
        'goodItems',
        'goodIds',
        'links',
        'csrf_token',
        'csrf_value',
        'loading'
      ]),
      showGoodEditingError () {
        return this.goodEditingError && true || false
      },
      goods () {
        let goodDatas = []
        if (this.goodIds.length) {
          let start = (this.page - 1) * this.size
          let end = this.page * this.size
          while (start < end) {
            let goodId = this.goodIds[start]
            if (goodId) {
              goodDatas.push(this.goodItems[goodId])
            }
            start++
          }
        }
        return goodDatas
      },
      saveGoodButtonText () {
        return this.posting ? '保存中' : '保存'
      }
    },
    methods: {
      ...mapActions([
        GET_HOTEL_GOODS_ACTION
      ]),
      ...mapMutations([
        UPDATE_CSRF_ITEMS
      ]),
      handleChangeGoods (id) {
        this.goodEditing = Object.assign({}, this.goodItems[id])
        this.goodEditingError = ''
        this.dialogGoods = true
      },
      handleSaveGoodEdit () {
        this.$refs.goodEditForm.validate((valid) => {
          if (valid) {
            let goodId = this.goodEditing.goods_id
            let sourceGoods = this.goodItems[goodId]
            let data = checkGoodInfoHasChange(this.goodEditing, sourceGoods)
            if (data.changed) {
              delete data.changed
              data.goods_id = goodId
              data[this.csrf_token] = this.csrf_value
              this.posting = true
              let that = this
              postHotelGoodsInfo(data, {REJECTERRORCONFIG: {serveError: true}}).then(function (res) {
                that[UPDATE_CSRF_ITEMS]({
                  csrf_token: res.web_data.csrf_token,
                  csrf_value: res.web_data.csrf_value
                })
                that.goodEditingError = ''
                that.goodItems[goodId] = that.goodEditing
                that.dialogGoods = false
                that.posting = false
              }).catch(function (err) {
                that.goodEditingError = err.msg
                that.posting = false
              })
            } else {
              this.dialogGoods = false
            }
          }
        })
      },
      handleGoodInfosCurrentChange (page) {
        let start = this.size * (page - 1)
        let hasCacheData = this.goodIds[start]
        if (!hasCacheData) {
          this[GET_HOTEL_GOODS_ACTION]({
            page: this.page,
            size: this.size,
            status: 'all'
          })
        }
        this.page = page
      },
      handleCloseDialogGoods (done) {
        if (this.posting) {
          return false
        } else {
          done()
        }
      }
    }
  }
</script>
