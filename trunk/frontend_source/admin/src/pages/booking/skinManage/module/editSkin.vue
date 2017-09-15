<template>
   <div class="editskin">
    <el-form ref="infoForm"  label-width="120px">
      <div class="jfk-fieldset">
        <div class="jfk-fieldset__hd">
          <div class="jfk-fieldset__title">分享设置</div>
        </div>
      <el-form-item label="页面标题">
          <el-input ></el-input>
      </el-form-item>
      <el-form-item label="页面描述">
          <el-input ></el-input>
      </el-form-item>
      <el-form-item label="分享图标">
        <el-upload
          action="https://jsonplaceholder.typicode.com/posts/"
          list-type="picture-card"
          :on-preview="handlePictureCardPreview"
          :on-remove="handleRemove">
          <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog v-model="dialogVisible" size="tiny">
          <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
      </el-form-item>
      </div>
      <el-row type="flex" justify="center">
        <el-button type="primary"  class="jfk-button--large" size="large">下一步</el-button>
      </el-row>
    </el-form>
   </div>
</template>
<script>
export default {
  name: 'editSkin',
  data () {
    return {
      msg: 'hah',
      dialogImageUrl: '',
      dialogVisible: false
    }
  },
  methods: {
    handleRemove (file, fileList) {
      console.log(file, fileList)
    },
    handlePictureCardPreview (file) {
      this.dialogImageUrl = file.url
      this.dialogVisible = true
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style >

</style>
