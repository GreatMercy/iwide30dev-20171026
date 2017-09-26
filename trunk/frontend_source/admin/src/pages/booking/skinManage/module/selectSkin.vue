<template >
  <div class="selectskin" v-loading="loading">
    <el-row>
      <el-col :span="24"><h3 class="selectSkin" >当前使用的皮肤</h3></el-col>
    </el-row>
    <el-row :gutter="20" type="flex" align="bottom">
      <el-col :span="6">
        <div class="demo">
          <h3>{{currentSkin.skin_title}}</h3>
          <img :src="currentSkin.intro_img" />
        </div>
      </el-col>
      <el-col :span="6">
        <div class="qrcode">
          <img :src="code" />
          <p>微信扫描二维码，直接查看效果</p>
          <router-link  :to="{path:'editSkin',query: {'skinName': currentSkin.skin_name}}">
            <el-button type="primary" class="btn" >皮肤编辑</el-button>
          </router-link>

        </div>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="24"><h3 class="selectSkin">可选皮肤</h3></el-col>
    </el-row>
    <el-row :gutter="20">
      <el-col :span="6" v-for="(item, idx) in moreSkins">
        <div class="demo">
          <h3>{{item.skin_title}}</h3>
          <img :src="item.intro_img" />
          <el-button type="primary" class="btn" @click="selectskin(item)">应 用</el-button>
        </div>
      </el-col>
    </el-row>
  </div>
</template>
<script>
// import Vue from 'vue'
import { getSkinIndex, postSaveSkin } from '@/service/booking/http'
export default {
  name: 'selectSkin',
  beforeCreate () {
    getSkinIndex().then((res) => {
      this.loading = false
      this.code = res.web_data.code
      this.currentSkin = res.web_data.selected_skin
      this.moreSkins = res.web_data.hotel_skins
      this.csrf_token = res.web_data.csrf_token
    })
  },
  data () {
    return {
      currentSkin: {},
      moreSkins: [],
      code: '',
      loading: true,
      csrf_token: ''
    }
  },
  created () {
  },
  methods: {
    selectskin (skin) {
      let params = {
        skin_name: skin.skin_name,
        skin_id: skin.skin_id,
        id: this.currentSkin.id,
        csrf_token: this.csrf_token
      }
      postSaveSkin(params).then((res) => {
        window.history.go(0)
      })
    }
  },
  destroyed () {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .selectSkin{
        font-size: 16px;
        color: #AC9456;
        margin-top: 50px;
        margin-bottom: 20px;
        line-height: 16px;
        border-left: 2px solid #AC9456;
        padding-left: 10px;
        font-weight: normal;
        text-align: left!important;
    }
    .demo{
        text-align: center;
    }
    .demo h3{
        font-size: 14px;
        line-height: 30px;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        color: #333;
        margin-bottom: 10px;
    }
    .demo img{
        width:65%;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .btn{
        width: 88px;
        margin-top: 20px;
    }
    .qrcode{
        text-align: center;
    }
    .qrcode img{
        width: 65%;
    }
</style>

