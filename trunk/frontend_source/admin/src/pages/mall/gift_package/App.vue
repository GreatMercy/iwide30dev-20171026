<template>
  <div class="gift-package__wrap" v-loading.fullscreen.lock="loading" :element-loading-text="text">
    <el-form :model="form" :rules="rules" ref="form" label-width="80px">

      <el-form-item label="活动名称">
        <el-row>
          <el-col :span="24">
            <span>礼包派送</span>
          </el-col>
        </el-row>
      </el-form-item>

      <el-form-item label="派送时间" required>
        <el-row>
          <el-col :span="5" class="gift-package__picker">
            <el-form-item prop="startTime">
              <el-date-picker
                type="date"
                size="small"
                v-model="form.startTime"
                prop="startTime"
                @change="changeStartTime"
                placeholder="请选择开始时间">
              </el-date-picker>
            </el-form-item>
          </el-col>

          <el-col :span="5" class="gift-package__picker">
            <el-form-item prop="endTime">
              <el-date-picker
                v-model="form.endTime"
                prop="endTime"
                type="date"
                size="small"
                @change="changeEndTime"
                placeholder="请选择结束时间">
              </el-date-picker>
            </el-form-item>
          </el-col>
        </el-row>
        <input type="hidden">
      </el-form-item>

      <el-form-item label="派送商品" required>
        <el-row>
          <el-col :span="24">
            <el-button @click="delivery" size="small">添加商品</el-button>
          </el-col>
        </el-row>
      </el-form-item>

    </el-form>

    <el-row class="gift-package__table">
      <el-table
        :class="{'jfk-table--no-border': giftTableClass['jfk-table--no-border']}"
        :data="giftPackage.list"
        v-loading.body="giftListLoading">
        <el-table-column prop="cat_name" label="所属分类" align="center"></el-table-column>

        <el-table-column prop="name" label="商品名称" align="center"></el-table-column>

        <el-table-column prop="stock" label="库存" align="center"></el-table-column>

        <el-table-column label="操作" show-overflow-tooltip align="center" width="130px">
          <template scope="scope">
            <el-button @click="deleteProduct(scope.row)" size="small">删除</el-button>
          </template>
        </el-table-column>
      </el-table>

      <el-pagination
        v-if="giftPackage.list.length > 0"
        @current-change="handleCurrentChange"
        :current-page.sync="giftPackage.page"
        :page-size="giftPackage.page_size"
        layout="total, prev, pager, next"
        :total="giftPackage.total">
      </el-pagination>

    </el-row>

    <el-dialog title="添加商品" :visible.sync="dialogTableVisible" :size="'large'">
      <el-row class="gift-package__search">
        <el-col :span="18">
          <el-input v-model="search" placeholder="请输入商品名称" size="small" icon="search"></el-input>
        </el-col>
        <el-col :span="2" :offset="1">
          <el-button type="primary" size="small" @click="searchProduct">搜索</el-button>
        </el-col>
      </el-row>

      <el-row class="gift-package__products">
        <el-table
          :class="{'jfk-table--no-border': productTableClass['jfk-table--no-border']}"
          :data="giftProductList" ref="multipleTable"
          height="400"
          @selection-change="handleSelectionChange"
          v-loading.body="productLoading">
          <el-table-column type="selection" width="55" align="center"></el-table-column>
          <el-table-column prop="cat_name" label="分类" width="180" align="center"></el-table-column>
          <el-table-column prop="name" label="商品名称" align="center"></el-table-column>
        </el-table>
      </el-row>


      <el-row class="jfk-ta-c gift-package__btn">
        <el-button type="primary" @click="choiceProduct" :loading="btnLoading">确定</el-button>
      </el-row>
    </el-dialog>

  </div>
</template>
<script>
  import { getGiftPackagesList, getGiftProductList, postGiftProduct, postDeleteGiftProduct } from '@/service/mall/http'
  import moment from 'moment'
  export default {
    components: {},
    computed: {
      giftTableClass () {
        return {
          'jfk-table--no-border': this.giftPackage.list.length > 1
        }
      },
      productTableClass () {
        return {
          'jfk-table--no-border': this.giftProductList.length > 1
        }
      }
    },
    data () {
      const validateEndDate = (rule, value, callback) => {
        if (this.form.startTime !== '' && value !== '') {
          if (moment(this.form.startTime).valueOf() > moment(value).valueOf()) {
            callback(new Error('结束时间不小于开始时间'))
          } else {
            callback()
          }
        } else {
          callback()
        }
      }
      const validateStartDate = (rule, value, callback) => {
        if (this.form.startTime !== '' && value !== '') {
          if (moment(this.form.startTime).valueOf() > moment(this.form.endTime).valueOf()) {
            callback(new Error('开始时间不大于结束时间'))
          } else {
            callback()
          }
        } else {
          callback()
        }
      }
      return {
        rules: {
          endTime: [
            {required: true, message: '请选择结束时间', trigger: 'change'},
            {validator: validateEndDate, trigger: 'change'}
          ],
          startTime: [
            {required: true, message: '请选择开始时间', trigger: 'change'},
            {validator: validateStartDate, trigger: 'change'}
          ]
        },
        form: {
          startTime: '',
          endTime: ''
        },
        loading: false,
        dialogTableVisible: false,
        productLoading: false,
        giftListLoading: false,
        search: '',
        csrf: {},
        // 配送的商品列表
        giftProductList: [],
        // 礼包列表
        giftPackage: {
          list: [], // 数据
          page: 1, // 页面
          total: 0, // 总条数
          page_size: 10 // 总页数
        },
        // 多选的结果
        multipleSelection: [],
        btnLoading: false,
        text: '正在加载数据'
      }
    },
    created () {
      this.getGiftPackageList().then((res) => {
        this.form.endTime = res['end_time']
        this.form.startTime = res['start_time']
      })
    },
    methods: {
      getGiftPackageList () {
        this.giftListLoading = true
        return getGiftPackagesList({
          page: this.giftPackage.page
        }).then((res) => {
          const content = res['web_data']
          this.giftPackage['list'] = content['items']
          this.giftPackage['total'] = content['page_resource']['count']
          this.giftPackage['page_size'] = content['page_resource']['size']
          this.csrf = content['csrf']
          this.giftListLoading = false
          return res['web_data']
        }).catch(() => {
          this.giftListLoading = false
        })
      },
      handleCurrentChange () {
        this.getGiftPackageList()
      },
      delivery () {
        this.$refs['form'].validate((valid) => {
          if (valid) {
            this.text = '正在加载数据'
            this.loading = true
            this.search = ''
            getGiftProductList().then((res) => {
              this.giftProductList = res['web_data']
              this.loading = false
              this.dialogTableVisible = true
            }).catch(() => {
              this.loading = false
              this.dialogTableVisible = false
            })
          }
        })
      },
      handleSelectionChange (val) {
        this.multipleSelection = val
      },
      // 选择开始时间
      changeStartTime (value) {
        this.form.startTime = value
      },
      // 选中商品
      choiceProduct () {
        this.btnLoading = true
        let result = []
        this.multipleSelection.forEach((item) => {
          result.push(item['product_id'])
        })
        let parameter = {
          'start_time': this.form['startTime'] || '',
          'end_time': this.form['endTime'] || '',
          'product_id': result.join(',')
        }
        if (JSON.stringify(this.csrf) !== '{}') {
          parameter[this.csrf['csrf_token']] = this.csrf['csrf_value']
        }
        postGiftProduct(parameter).then((res) => {
          this.dialogTableVisible = false
          this.btnLoading = false
          this.giftPackage.page = 1
          this.getGiftPackageList()
        }).catch(() => {
          this.btnLoading = false
        })
      },
      // 选择结束时间
      changeEndTime (value) {
        this.form.endTime = value
      },
      // 搜索商品
      searchProduct () {
        this.productLoading = true
        getGiftProductList({
          'name': this.search || ''
        }).then((res) => {
          this.giftProductList = res['web_data']
          this.productLoading = false
        }).catch(() => {
          this.productLoading = false
        })
      },
      // 删除商品
      deleteProduct (item) {
        this.text = '正在删除商品'
        this.loading = true
        let parameter = {
          'product_id': item['product_id']
        }
        if (JSON.stringify(this.csrf) !== '{}') {
          parameter[this.csrf['csrf_token']] = this.csrf['csrf_value']
        }
        postDeleteGiftProduct(parameter).then(() => {
          this.loading = false
          this.giftPackage.page = 1
          this.getGiftPackageList()
        }).catch(() => {
          this.loading = false
        })
      }
    }
  }
</script>
<style lang="postcss" scoped>
  .gift-package {
    &__wrap {
      background-color: #ffffff;
      padding: 30px;
    }
    &__picker {
      margin-right: 20px;
      .el-date-editor {
        width: 100%;
        float: left;
      }
    }
    &__table {
      margin: 20px 0;
      .el-pagination {
        margin-top: 20px;
        text-align: center;
      }
    }
    &__search {
      margin-bottom: 20px;
    }
    &__btn {
      margin-top: 20px;
      button {
        width: 200px;
      }
    }
    &__products {
      max-height: 400px;
      overflow-y: scroll;
    }
  }
</style>
