<template>
  <div class="jfk-pages page_menu">
    <el-row :gutter="20" type="flex" align="middle">
      <el-col :span="12" >
        <el-tree
          :data="menuData"
          :props="defaultProps"
          show-checkbox
          node-key="id"
          default-expand-all
          :expand-on-click-node="false"
          :render-content="renderContent"
          style="padding:22px;">
        </el-tree>
      </el-col>
      <el-col :span="12" style="border:1px solid rgb(209, 219, 229);padding:22px;" >
        <el-form label-width="90px">
          <el-form-item label="菜单名称">
            <el-input></el-input>
          </el-form-item>
          <el-form-item label="菜单类型">
            <el-input></el-input>
          </el-form-item>    
          <el-form-item label="链接地址">
            <el-input></el-input>
          </el-form-item>
          <el-form-item label="适用公众号">
            <el-button type="text">获取我管理的所有公众号</el-button>
            <p>碧桂园酒店集团</p>
            <div>
              <div>
                <el-checkbox v-model="checked">全选</el-checkbox>
              </div>
              <el-row :gutter="20">
                <el-col :span="8">
                  <el-checkbox v-model="checked">南京金陵酒店</el-checkbox>
                </el-col>
                <el-col :span="8">
                  <el-checkbox v-model="checked">南京金陵酒店</el-checkbox>
                </el-col>
                <el-col :span="8">
                  <el-checkbox v-model="checked">南京金陵酒店</el-checkbox>
                </el-col>
                <el-col :span="8">
                  <el-checkbox v-model="checked">南京金陵酒店</el-checkbox>
                </el-col>
                <el-col :span="8">
                  <el-checkbox v-model="checked">南京金陵酒店</el-checkbox>
                </el-col>
              </el-row>
              <p>注：将重新设置所选酒店的公众号菜单</p>
              <div style="padding-left: 30px;">
                <el-checkbox v-model="checked">锁定(锁定后只能由多号管理员角色修改此菜单)</el-checkbox>
              </div>
            </div>
          </el-form-item>
        </el-form>
        <div style="text-align: center">
          <el-button>保存</el-button>
        </div>

      </el-col>
    </el-row>
    <el-row :gutter="20" style="margin-top: 22px;">
      <el-col :span="12" style="text-align: center">
        <el-button>新增一级菜单</el-button>
        <el-button type="primary">生成菜单</el-button>
      </el-col>
    </el-row>


  </div>
</template>

<script>
  let id = 1000
  export default {
    data () {
      return {
        menuData: [{
          id: 1,
          label: '一级 1',
          children: [{
            id: 4,
            label: '二级 1-1'
          }]
        }, {
          id: 2,
          label: '一级 2',
          children: [{
            id: 5,
            label: '二级 2-1'
          }, {
            id: 6,
            label: '二级 2-2'
          }]
        }, {
          id: 3,
          label: '一级 3',
          children: [{
            id: 7,
            label: '二级 3-1'
          }, {
            id: 8,
            label: '二级 3-2'
          }]
        }],
        defaultProps: {
          children: 'children',
          label: 'label'
        }
      }
    },
    created () {
    },
    methods: {
      append (store, data) {
        store.append({ id: id++, label: 'testtest', children: [] }, data)
      },
      remove (store, data) {
        store.remove(data)
      },
      renderContent (h, { node, data, store }) {
        return (
          <span>
            <span>
              <span>{node.label}</span>
            </span>
            <span style="float: right; margin-right: 20px">
              <i class="el-icon-edit"></i>
              <i class="el-icon-close" on-click={ () => this.remove(store, data) }></i>
            </span>
          </span>)
      }
    }
  }
                // <i class="jfkfont icon-yidong"></i>
                // <el-button size="mini" on-click={ () => this.append(store, data) }>Append</el-button>
</script>
<style  >
.page_menu .el-tree .el-checkbox{
  display: none;
}
</style>
