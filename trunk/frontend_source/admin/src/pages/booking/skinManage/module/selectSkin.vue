<template>
  <div class="selectskin">
    <el-row>
      <el-col :span="24"><h3 class="selectSkin">当前使用的皮肤</h3></el-col>
    </el-row>
    <el-row :gutter="20" type="flex" align="bottom">
      <el-col :span="8">
        <div class="demo">
          <h3>默认版</h3>
          <img src="../../../../assets/image/white.jpg" />
        </div>
      </el-col>
      <el-col :span="6">
        <div class="qrcode">
          <img src="../../../../assets/image/code.png" />
          <p>微信扫描二维码，直接查看效果</p>
          <router-link to="editSkin">
            <el-button type="primary" class="btn">皮肤编辑</el-button>
          </router-link>

        </div>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="24"><h3 class="selectSkin">可选皮肤</h3></el-col>
    </el-row>
    <el-row :gutter="20">
      <el-col :span="8">
        <div class="demo">
          <h3>高端黑</h3>
          <img src="../../../../assets/image/black.jpg" />
          <el-button type="primary" class="btn">应 用</el-button>          
        </div>
      </el-col>
      <el-col :span="8">
        <div class="demo">
          <h3>高端白</h3>
          <img src="../../../../assets/image/white.jpg" />
          <el-button type="primary" class="btn">应 用</el-button>             
        </div>
      </el-col>          
    </el-row>
  </div>
</template>

<script>
export default {
  name: 'selectSkin',
  data () {
    return {
      msg: 'hah'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style >
    .selectSkin{
        font-size: 16px;
        color: #AC9456;
        margin-top: 50px;
        margin-bottom: 20px;
        line-height: 16px;
        border-left: 2px solid #AC9456;
        padding-left: 10px;
        font-weight: normal;
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
        width: 80%;
        display: block;
        margin-left: auto;
        margin-right: auto;
        box-shadow: 4px 5px 20px 5px rgba(0,0,0,0.1);
        border-radius: 4px;
    }
    .btn{
        width: 88px;
        margin-top: 20px;
    }
    .qrcode{
        text-align: center;
    }
    .qrcode img{
        width: 80%;
    }
</style>

