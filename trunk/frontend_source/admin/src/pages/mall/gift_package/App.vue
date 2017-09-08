<template>
  <div class="gift-package__wrap">
    <el-form ref="form" :model="form" label-width="80px">
      <el-form-item label="活动名称">
        <el-row>
          <el-col :span="24">
            <span>礼包配送</span>
          </el-col>
        </el-row>
      </el-form-item>

      <el-form-item label="派送时间">
        <el-row>
          <el-col :span="24" class="gift-package__picker">
            <el-date-picker
              type="date"
              size="small"
              v-model="form.startTime"
              placeholder="请选择开始时间">
            </el-date-picker>
            <el-date-picker
              v-model="form.endTime"
              type="date"
              size="small"
              placeholder="请选择结束时间">
            </el-date-picker>
          </el-col>
        </el-row>
      </el-form-item>

      <el-form-item label="派送商品">
        <el-row>
          <el-col :span="24">
            <el-button @click="dialogTableVisible = true" size="small">派送商品</el-button>
          </el-col>
        </el-row>
      </el-form-item>

    </el-form>

    <el-row class="gift-package__table" v-if="giftPackageList.length > 0">
      <el-table :data="tableData">
        <el-table-column prop="date" label="所属分类" width="180" align="center"></el-table-column>

        <el-table-column prop="name" label="商品名称" width="180" align="center"></el-table-column>

        <el-table-column prop="address" label="库存" width="180" align="center"></el-table-column>
      </el-table>
    </el-row>

    <el-row class="jfk-ta-c">
      <el-button type="primary" @click="onSubmit">保存</el-button>
    </el-row>


    <el-dialog title="添加商品" :visible.sync="dialogTableVisible">
      <el-row class="gift-package__search">
        <el-col :span="18">
          <el-input v-model="search" placeholder="请输入商品名称" size="small" icon="search"></el-input>
        </el-col>
        <el-col :span="2" :offset="1">
          <el-button type="primary" size="small">搜索</el-button>
        </el-col>
      </el-row>
      <el-table :data="tableData">
        <el-table-column prop="date" label="分类" width="180" align="center"></el-table-column>

        <el-table-column prop="name" label="商品名称" align="center"></el-table-column>
      </el-table>

      <el-row class="jfk-ta-c gift-package__btn">
        <el-button type="primary">确定</el-button>
      </el-row>
    </el-dialog>


  </div>
</template>
<script>
  import { getGiftPackagesList } from '@/service/mall/http'
  export default {
    components: {},
    computed: {},
    data () {
      return {
        form: {
          startTime: '',
          endTime: ''
        },
        loading: false,
        dialogTableVisible: false,
        search: '',
        giftPackageList: [],
        tableData: [{
          date: '2016-05-02',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1518 弄'
        }, {
          date: '2016-05-04',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1517 弄'
        }, {
          date: '2016-05-01',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1519 弄'
        }, {
          date: '2016-05-03',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1516 弄'
        }]
      }
    },
    created () {
      getGiftPackagesList().then((res) => {
        console.log(res)
      }).catch(() => {
      })
    },
    methods: {
      onSubmit () {
      }
    }
  }
</script>
<style lang="postcss" scoped>

  .gift-package {
    &__wrap {
      padding: 30px;
    }
    &__picker {
      .el-date-editor {
        float: left;
        margin-right: 20px;
      }
    }
    &__table {
      margin: 20px 0;
      width: 540px;
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
  }
</style>
