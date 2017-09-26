<template>
  <div class="jfk-pages jfk-pages__soma-package" v-loading="pageLoading">
    <el-tabs v-model="searchParams.status" @tab-click="handleTabClick">
      <el-tab-pane
        v-for="(val, key) in tabs"
        :key="key"
        :label="val"
        :name="key">
      </el-tab-pane>
    </el-tabs>
    <el-row :gutter="20" class="jfk-mb-20">
      <el-col :span="6">
        <el-select size="small" filterable v-model="cat" class="jfk-select--width-auto">
          <el-option
            v-for="(val, key) in category"
            :key="key"
            :label="val"
            :value="key">
          </el-option>
        </el-select>
      </el-col>
      <el-col :span="6">
        <el-input v-model="word" placeholder="商品名称" size="small"></el-input>
      </el-col>
      <el-col :span="3">
        <el-button type="primary" size="small" @click="handleSearchButtonClick">搜&nbsp;&nbsp;索</el-button>
      </el-col>
      <el-col :span="3" :offset="6" class="jfk-ta-r">
        <el-button type="info" size="small" icon="plus" :plain="true" class="jfk-button-tag-a">
          <a :href="links.add" class="goods_add">新增商品</a>
        </el-button>
      </el-col>
    </el-row>
    <div v-loading="tableLoading">
      <el-table
        @header-click="handlePackageTableHeaderClick"
        ref="packageTable"
        :data="packages"
        class="jfk-table--wrap-header jfk-table__packages"
        :class="packageTableClass"
        tooltip-effect="dark"
        style="width: 100%">
        <el-table-column
          :render-header="packageTableRenderHeader"
          header-align="center"
          label-class-name="sortid"
          prop="sortid"
          align="center">
          <template scope="scope">
            <p>{{scope.row.product_id}}</p>
            <p>{{scope.row.cat_id}}</p>
          </template>
        </el-table-column>
        <el-table-column
          align="center"
          prop="goods_type"
          label="商品类型">
        </el-table-column>
        <el-table-column
        align="center"
          label="封面图">
          <template scope="scope">
            <div class="package-image" v-if="scope.row.face_img">
              <div class="package-image-box" @dblclick="handleImageClick(scope.row)">
                <img  :src="scope.row.face_img" alt="scope.row.name"/>
              </div>
            </div>
          </template>
        </el-table-column>
        <el-table-column
          min-width="150px"
          prop="sortprice"
          label-class-name="sortprice"
          :render-header="packageTableRenderHeader"
          header-align="center">
          <template scope="scope">
            <p>{{scope.row.name}}</p>
            <p>￥{{scope.row.price_package}}</p>
          </template>
        </el-table-column>
        <el-table-column
          width="95px"
          align="center"
          label-class-name="sortstock"
          :render-header="packageTableRenderHeader"
          prop="stock">
        </el-table-column>
        <el-table-column
          header-align="left"
          align="center"
          width="95px"
          label="首页是否显示"
          prop="is_hide">
        </el-table-column>
        <el-table-column
          label-class-name="sortdate"
          :render-header="packageTableRenderHeader"
          prop="validity_date">
        </el-table-column>
        <el-table-column
          width="105px"
          align="center"
          label-class-name="sort"
          prop="sort"
          :render-header="packageTableRenderHeader">
        </el-table-column>
        <el-table-column
          label="状态"
          align="center"
          prop="status">
        </el-table-column>
        <el-table-column
          align="center"
          width="65px"
          label="操作">
          <template scope="scope">
            <a class="el-icon-edit jfk-color--primary" :href="links.edit + scope.row.product_id"></a>
          </template>
        </el-table-column>
      </el-table>
      <el-row class="jfk-mt-20 jfk-mb-20">
        <el-col :span="2" class="jfk-fz-12 jfk-color--base-gray jfk-lh--32">共{{count}}条</el-col>
        <el-col :span="22" class="jfk-ta-r">
          <el-pagination
            class="jfk-d-ib"
            v-show="count > size"
            @current-change="handlePackagesCurrentChange"
            :current-page.sync="searchParams.page"
            :page-size="size"
            :total="count"
            layout="prev, pager, next, jumper">
          </el-pagination>
        </el-col>
      </el-row>
    </div>

    <el-dialog
      size="large"
      title="封面图"
      class="jfk-dialog__title--center jfk-dialog--width-auto"
      :visible.sync="dialogPackage.visible">
      <div class="jfk-ta-c">
        <img class="jfk-d-b" :style="{'max-width': '100%'}" :src="dialogPackage.img"/>
        <p class="jfk-mt-20">{{dialogPackage.name}}</p>
      </div>
    </el-dialog>
  </div>
</template>
<script>
  import { getPackageListDatas } from '@/service/mall/http'
  const createLabelHtml = function (index) {
    switch (index) {
      case 0:
        return 'ID<br/>分类'
      case 3:
        return '商品名称<br/>价格'
      case 4:
        return '库存'
      case 6:
        return '创建时间'
      case 7:
        return '优先级'
    }
    return
  }
  const defaultSortOptAndPage = {
    sortid: '',
    sortprice: '',
    sortstock: '',
    sortdate: '',
    sort: '',
    page: 1
  }
  const defaultSearchOpt = {
    word: '',
    cat: '0'
  }
  // 排序label到排序值的映射
  const sortLabelMaps = {
    sortid: 'sortid',
    sortprice: 'sortprice',
    stock: 'sortstock',
    'validity_date': 'sortdate',
    sort: 'sort'
  }
  export default {
    name: 'package',
    data () {
      return {
        tabs: {},
        links: {},
        category: {},
        packages: [],
        count: 0,
        size: 20,
        word: '', // 点击搜索后合并到searchArgs中
        cat: '0', // 点击搜索后合并到searchArgs中
        dialogPackage: {
          visible: false,
          img: '',
          name: ''
        },
        pageLoading: true,
        tableLoading: false,
        searchParams: {
          cat: '0',
          word: '',
          page: 1,
          sortid: '',
          sortprice: '',
          sortstock: '',
          sortdate: '',
          sort: '',
          status: 0
        }
      }
    },
    created () {
      let that = this
      getPackageListDatas().then(function (data) {
        that.pageLoading = false
        const { nav, category, links, count, size } = data.web_data.page_resource
        that.tabs = Object.assign({}, nav)
        that.category = Object.assign({}, category)
        that.links = Object.assign({}, links)
        that.packages = data.web_data.items
        that.count = count
        that.size = size
      })
    },
    computed: {
      packageTableClass () {
        return {
          'is-sortid-asc': this.searchParams.sortid === 'asc',
          'is-sortid-desc': this.searchParams.sortid === 'desc',
          'is-sortprice-asc': this.searchParams.sortprice === 'asc',
          'is-sortprice-desc': this.searchParams.sortprice === 'desc',
          'is-sortstock-asc': this.searchParams.sortstock === 'asc',
          'is-sortstock-desc': this.searchParams.sortstock === 'desc',
          'is-sortdate-asc': this.searchParams.sortdate === 'asc',
          'is-sortdate-desc': this.searchParams.sortdate === 'desc',
          'is-sort-asc': this.searchParams.sort === 'asc',
          'is-sort-desc': this.searchParams.sort === 'desc',
          'jfk-table--no-border ': this.packages.length > 1
        }
      }
    },
    methods: {
      // 重置搜索条件
      resetSearchParams (isOnlySort) {
        this.searchParams = Object.assign({}, this.searchParams, defaultSortOptAndPage, isOnlySort ? null : defaultSearchOpt)
      },
      // 重置搜索条件
      resetSearchArgs () {
        this.word = ''
        this.cat = '0'
      },
      changeSort (key, val) {
        let v
        if (val !== undefined) {
          v = val
        } else {
          if (this.searchParams[key] === 'asc') {
            v = 'desc'
          } else if (this.searchParams[key] === 'desc') {
            v = ''
          } else {
            v = 'asc'
          }
        }
        this.searchParams = Object.assign({}, this.searchParams, defaultSortOptAndPage, {
          [key]: v
        })
      },
      // 获取套餐产品信息
      getPackageLists (isTabTrigger) {
        let that = this
        getPackageListDatas(that.searchParams).then(function (data) {
          if (isTabTrigger) {
            that.pageLoading = false
          } else {
            that.tableLoading = false
          }
          that.count = data.web_data.page_resource.count
          that.packages = data.web_data.items
        })
      },
      handleTabClick (tab, event) {
        this.resetSearchParams()
        this.resetSearchArgs()
        this.searchParams.status = tab.name
        this.tableLoading = true
        this.getPackageLists()
      },
      handleSearchButtonClick () {
        this.resetSearchParams(true)
        this.searchParams.word = this.word
        this.searchParams.cat = this.cat
        this.tableLoading = true
        this.getPackageLists()
      },
      handlePackagesCurrentChange (page) {
        this.searchParams.page = page
        this.tableLoading = true
        this.getPackageLists()
      },
      handlePackageTableHeaderClick ({ property }, event) {
        let sortVal
        try {
          if (event.target.classList.contains('descending')) {
            sortVal = 'desc'
          }
          if (event.target.classList.contains('ascending')) {
            sortVal = 'asc'
          }
        } catch (e) {
          console.log(e)
        }
        let sortKey = sortLabelMaps[property]
        if (sortKey && sortVal !== this.searchParams[sortKey]) {
          this.changeSort(sortKey, sortVal)
          if (this.searchParams.page === 1 && this.packages.length > 2) {
            this.tableLoading = true
            this.getPackageLists()
          }
        }
      },
      handleImageClick (p) {
        this.dialogPackage.visible = true
        this.dialogPackage.img = p.face_img
        this.dialogPackage.name = p.name
      },
      packageTableRenderHeader (h, options) {
        const html = createLabelHtml(options.$index)
        if (html) {
          return h('div', {domProps: {
            innerHTML: '<span class="jfk-table__header-label">' + html + '</span><span class="caret-wrapper"><i class="sort-caret ascending"></i><i class="sort-caret descending"></i></span>'
          }})
        }
      }
    }
  }
</script>
<style lang="postcss" scoped>
  .package-image{
    margin: 5px;
    width: 100%;
    height: 0;
    overflow: hidden;
    padding-bottom: 53.3333%;
    position: relative;
  }
  .package-image-box{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    bottom: 0;
  }
  .package-image-box img{
    width: 100%;
    height: 100%;
  }
  .el-icon-edit{
    text-decoration: none;
  }
</style>
<style lang="postcss">
  @import '../../../styles/element-variables.css';
  .jfk-table__packages{
    @each $key in sortid, sortprice, sortstock, sortdate, sort {
      &.is-$(key)-asc {
        .$(key) {
          .ascending {
            border-bottom-color: var(--color-extra-light-black);
          }
        }
      }
      &.is-$(key)-desc {
        .$(key) {
          .descending {
            border-top-color: var(--color-extra-light-black);
          }
        }
      }
    }
  }
</style>
