<template>
    <div class="editskin" v-loading="loading">
        <!-- 分享设置 -->
        <el-form label-width="120px">
            <div class="jfk-fieldset">
                <div class="jfk-fieldset__hd">
                    <div class="jfk-fieldset__title">分享设置</div>
                </div>
            </div>
            <el-row :gutter="20">
                <el-col :span="10">
                    <el-form-item label="页面标题">
                        <el-input v-model.trim="share_setting.page_title"></el-input>
                    </el-form-item>
                    <el-form-item label="页面描述">
                        <el-input v-model.trim="share_setting.page_desc"></el-input>
                    </el-form-item>
                    <el-form-item label="分享图标">
                        <el-upload class="avatar-uploader shareicon" :data="{'csrf_token': csrf_token}"
                        action="/index.php/iapi/v1/hotel/Uploadftp/upload_img" :show-file-list="false" :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload">
                            <img v-if="share_setting.share_icon" :src="share_setting.share_icon" class="avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                        <p style="width: 150px;" class="el-upload__tip">建议尺寸100*100</p>
                    </el-form-item>
                </el-col>
                <el-col :span="14" style="text-align: right">
                    <el-button type="primary" @click="handleShowDemo('share')">示例</el-button>
                </el-col>
            </el-row>
            <!-- 首页样式设置 -->
            <template v-if="skin_name == 'default2'">
                <div class="jfk-fieldset">
                    <div class="jfk-fieldset__hd">
                        <div class="jfk-fieldset__title">首页样式</div>
                    </div>
                </div>
                <el-form-item label="首页样式">
                    <el-radio-group v-model="home_setting.home_disp">
                        <el-row type="flex" justify="start" :gutter="80">
                            <el-col :span="9">
                                <div class="homestyle">
                                    <img :src="pageType.ori.image" />
                                    <el-radio class="radio" label="ori">简约</el-radio>
                                </div>
                            </el-col>
                            <el-col :span="9">
                                <div class="homestyle">
                                    <img :src="pageType.new.image" />
                                    <el-radio class="radio" label="new">标准</el-radio>
                                </div>
                            </el-col>
                        </el-row>
                    </el-radio-group>
                </el-form-item>
            </template>
            <!-- 页面logo -->
            <template v-if="skin_name == 'default2' && home_setting.home_disp == 'new'">
                <div class="jfk-fieldset">
                    <div class="jfk-fieldset__hd">
                        <div class="jfk-fieldset__title">页面logo</div>
                    </div>
                </div>
                <el-row :gutter="20">
                    <el-col :span="10">
                        <el-form-item label="Logo">
                            <el-upload class="avatar-uploader shareicon " :data="{'csrf_token': csrf_token}" action="/index.php/iapi/v1/hotel/Uploadftp/upload_img" :show-file-list="false" :on-success="handleLogoSuccess" :before-upload="beforeAvatarUpload">
                                <img v-if="home_setting.logo" :src="home_setting.logo" class="avatar">
                                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                            </el-upload>
                            <p style="width: 150px;" class="el-upload__tip">建议尺寸20*20</p>
                        </el-form-item>
                    </el-col>
                </el-row>
            </template>
            <!-- 首页轮播图 -->
            <div class="jfk-fieldset">
                <div class="jfk-fieldset__hd">
                    <div class="jfk-fieldset__title">首页轮播图</div>
                </div>
            </div>
            <el-row :gutter="20">
                <el-col :span="16">
                    <template v-for="(item, idx) in carouselFigure">
                        <div class="swiperItem">
                            <el-row :gutter="20" type="flex" align="middle">
                                <el-col>
                                    <el-form-item label="添加图片">
                                        <el-upload class="avatar-uploader" 
                                        :data="{'csrf_token': csrf_token}" 
                                        action="/index.php/iapi/v1/hotel/Uploadftp/upload_img" :show-file-list="false" :on-success="handleCarouselSuccess" :before-upload="beforeCarouselUpload">
                                            <img v-if="item.image_url" :src="item.image_url" class="avatar">
                                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                            <el-button size="small" type="text" @click="handleIdx(idx)" class="uploadbutton"></el-button>
                                        </el-upload>
                                        <p class="el-upload__tip">建议尺寸638*319</p>
                                    </el-form-item>
                                    <el-form-item label="添加链接">
                                        <el-input v-model.trim="item.link"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col class="swiper-action" v-if="carouselFigure[0].image_url">
                                    <el-tooltip class="item" effect="light" content="向上移动顺序" placement="top-start">
                                        <i class="jfkfont icon-up-arrow" @click="changePositionUp(idx)" v-if="idx !== 0"></i>
                                    </el-tooltip>
                                    <el-tooltip class="item" effect="light" content="向下移动顺序" placement="top-start">
                                        <i class="jfkfont icon-down-arrow" @click="changePositionDown(idx)" v-if="idx !== carouselFigure.length - 1"></i>
                                    </el-tooltip>
                                    <el-tooltip class="item" effect="light" content="删除" placement="top-start">
                                        <i class="jfkfont icon-icon_close" @click="deleteCarousel(idx, item.id)"></i>
                                    </el-tooltip>
                                </el-col>
                            </el-row>
                        </div>
                    </template>
                    <div class="add">
                        <el-button @click="addCarousel"><i class="el-icon-plus "></i></el-button>
                    </div>
                </el-col>
                <el-col :span="8" style="text-align: right">
                    <el-button type="primary" @click="handleShowDemo('roast')">示例</el-button>
                </el-col>
            </el-row>
            <!-- 字体大小 -->
            <template v-if="skin_name == 'default2'">
                <div class="jfk-fieldset">
                    <div class="jfk-fieldset__hd">
                        <div class="jfk-fieldset__title">设置字体大小和颜色</div>
                    </div>
                </div>
                <el-row :gutter="20">
                    <el-col :span="10">
                        <el-form-item label="文字按钮颜色" style="text-align: left">
                            <div class="block">
                                <el-color-picker v-model="font_setting.font_color"></el-color-picker>
                            </div>
                        </el-form-item>
                        <el-form-item label="选择字体大小" style="text-align: left">
                            <el-select v-model="font_setting.font_size" placeholder="请选择">
                                <el-option v-for="(item, key) in options" :key="item.value" :label="item.label" :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="14" style="text-align: right">
                        <el-button type="primary" @click="handleShowDemo('color')">示例</el-button>
                    </el-col>
                </el-row>
            </template>
            <!-- 底部菜单 -->
            <template v-if="home_setting.home_disp == 'new' || skin_name !== 'default2'">
                <div class="jfk-fieldset">
                    <div class="jfk-fieldset__hd">
                        <div class="jfk-fieldset__title">底部菜单</div>
                    </div>
                </div>
                <el-row :gutter="20">
                    <el-col :span="20" style="text-align: left;">
                        <el-row style="max-width: 700px;">
                            <el-form-item label="选择菜单">
                                <el-select style="width:28%" placeholder="请选择" v-model="home_setting.menu['1'].code">
                                    <el-option v-for="(item, key) in menuOptions" :key="item.value" :label="item.label" :value="item.value">
                                    </el-option>
                                </el-select>
                                <el-select style="width:28%" placeholder="请选择" v-model="home_setting.menu['2'].code">
                                    <el-option v-for="(item, key) in menuOptions" :key="item.value" :label="item.label" :value="item.value">
                                    </el-option>
                                </el-select>
                                <el-select style="width:28%" placeholder="请选择" v-model="home_setting.menu['3'].code">
                                    <el-option v-for="(item, key) in menuOptions" :key="item.value" :label="item.label" :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-row>
                        <el-row style="max-width: 700px;">
                            <el-form-item label="填写菜单描述" class="menudesc">
                                <el-input class='menudesc' :maxlength=8 v-model.trim="home_setting.menu['1'].desc" placeholder="填写描述，最多8个字" style="width:28%"></el-input>
                                <el-input class='menudesc' :maxlength=8 v-model.trim="home_setting.menu['2'].desc" placeholder="填写描述，最多8个字" style="width:28%"></el-input>
                                <el-input class='menudesc' :maxlength=8 v-model.trim="home_setting.menu['3'].desc" placeholder="填写描述，最多8个字" style="width:28%"></el-input>
                            </el-form-item>
                        </el-row>
                    </el-col>
                    <el-col :span="4" style="text-align: right">
                        <el-button type="primary" @click="handleShowDemo('menu')">示例</el-button>
                    </el-col>
                </el-row>
            </template>
            <el-row type="flex" justify="center">
                <el-button type="primary" class="jfk-button--large el-button--large" size="large" @click="submitForm()" :loading="submiting">保存</el-button>
            </el-row>
        </el-form>
        <!-- 弹窗     -->
        <div tabindex="-1" class=" demoPop el-message-box__wrapper" style="z-index: 2003;" v-if="showDemoPop">
            <div class="el-message-box">
                <div class="el-message-box__header">
                    <div class="el-message-box__title">示例图</div>
                    <button type="button" aria-label="Close" class="el-message-box__headerbtn" @click="handleClose()"><i class="el-message-box__close el-icon-close"></i></button>
                </div>
                <div class="el-message-box__content">
                    <div class="el-message-box__message" style="margin-left: 0px;">
                        <img :src="demonameimg" class="demoimg" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// postSkinSaveSetting
import { getSkinSetting, postSkinDelFocus, postSkinSaveSetting } from '@/service/booking/http'
// import { formatUrlParams } from '@/utils/utils'
export default {
  name: 'editSkin',
  beforeCreate () {
  },
  data () {
    return {
      loading: true,
      submiting: false,
      options: [{
        value: '11',
        label: '11px'
      }, {
        value: '12',
        label: '12px'
      }, {
        value: '13',
        label: '13px'
      }, {
        value: '14',
        label: '14px'
      }, {
        value: '15',
        label: '15px'
      }, {
        value: '16',
        label: '16px'
      }],
      menuOptions: [{
        value: 'always',
        label: '常驻酒店'
      }, {
        value: 'collect',
        label: '我的收藏'
      }, {
        value: 'order',
        label: '我的订单'
      }],
      carouselFigure: [],
      canAddCarousel: true,
      uploadingIdx: 0,
      share_setting: {
        id: '',
        page_title: '',
        page_desc: '',
        share_icon: ''
      },
      font_setting: {
        font_color: '',
        font_size: ''
      },
      home_setting: {
        id: '',
        home_disp: '',
        logo: '',
        menu: {
          '1': {},
          '2': {},
          '3': {}
        }
      },
      pageType: {
        'new': {},
        'ori': {}
      },
      showDemoPop: false,
      demonameimg: '',
      skin_name: '',
      demonamemap: {},
      csrf_token: ''
    }
  },
  created () {
    this.skin_name = this.$route.query.skinName
    let params = {
      skin_name: this.skin_name
    }
    getSkinSetting(params).then((res) => {
      this.loading = false
      const {font = {}, home_setting, roast = [], share = {}, demonamemap = {}} = res.web_data
      const { menu = {}, img } = home_setting.param_value
      this.csrf_token = res.web_data.csrf_token
      this.home_setting.id = home_setting.id
      this.home_setting.home_disp = home_setting.param_value.home_disp
      this.home_setting.logo = img
      this.home_setting.menu['1'] = menu['1']
      this.home_setting.menu['2'] = menu['2']
      this.home_setting.menu['3'] = menu['3']
      this.share_setting.id = share.id
      this.share_setting.page_title = share.param_value.page_title
      this.share_setting.page_desc = share.param_value.page_desc
      this.share_setting.share_icon = share.param_value.share_icon
      this.font_setting.font_color = font.theme_color
      this.font_setting.font_size = font.fontx
      this.pageType.new = res.web_data.page_type.new
      this.pageType.ori = res.web_data.page_type.ori
      this.demonamemap = demonamemap
      this.carouselFigure = roast
      if (!this.carouselFigure.length) {
        this.carouselFigure.push({'id': 0, 'link': '', 'image_url': '', 'sort': 0})
        this.canAddCarousel = false
      }
    })
  },
  methods: {
    handleClose () {
      this.showDemoPop = false
    },
    handleShowDemo (type) {
      let skinName = this.skin_name
      let defaultType = this.home_setting.home_disp
      if (type === 'share' || type === 'color') {
        this.demonameimg = this.demonamemap[type]
      } else if (skinName === 'highclass' || skinName === 'bigger') {
        this.demonameimg = this.demonamemap[type][skinName]
      } else {
        this.demonameimg = this.demonamemap[type][defaultType]
      }
      this.showDemoPop = true
    },
    // 改变轮播图的顺序sort n n-1 ...1
    changeRoastSort () {
      const roastArr = this.carouselFigure
      let raostLength = roastArr.length
      if (raostLength) {
        if (!roastArr[raostLength - 1].image_url) {
          raostLength = roastArr.length - 1
        }
        roastArr.forEach((item, idx) => {
          roastArr[idx].sort = raostLength - idx
        })
        this.carouselFigure = roastArr
      }
    },
    handleIdx (idx) {
      this.uploadingIdx = idx
    },
    handleNoneRoast () {
      this.carouselFigure.push({'id': 0, 'link': '', 'image_url': '', 'sort': 0})
      this.canAddCarousel = false
    },
    deleteCarousel (idx, id) {
      if (id === 0) {
        if (this.carouselFigure.length > 1) {
          if (idx === this.carouselFigure.length - 1) {
            this.canAddCarousel = true
          }
          this.carouselFigure.splice(idx, 1)
        } else {
          this.carouselFigure[idx].image_url = ''
          this.canAddCarousel = false
        }
      } else {
        this.loading = true
        let params = {
          id: id,
          csrf_token: this.csrf_token
        }
        postSkinDelFocus(params).then((res) => {
          this.loading = false
          if (idx === this.carouselFigure.length - 1) {
            this.canAddCarousel = true
          }
          this.carouselFigure.splice(idx, 1)
          if (!this.carouselFigure.length) {
            this.handleNoneRoast()
          }
        }).catch(() => {
          this.loading = false
        })
      }
    },
    changePositionUp (idx) {
      const roastArr = this.carouselFigure
      if (!roastArr[idx].image_url) {
        this.$alert('请先添加图片', '温馨提示', {})
      } else {
        roastArr.splice(idx - 1, 1, ...roastArr.splice(idx, 1, roastArr[idx - 1]))
        this.carouselFigure = roastArr
      }
    },
    changePositionDown (idx) {
      const roastArr = this.carouselFigure
      if (!roastArr[idx + 1].image_url) {
        this.$alert('请先添加图片', '温馨提示', {})
      } else {
        roastArr.splice(idx + 1, 1, ...roastArr.splice(idx, 1, roastArr[idx + 1]))
        this.carouselFigure = roastArr
      }
    },
    addCarousel () {
      if (this.canAddCarousel && this.carouselFigure[this.carouselFigure.length - 1].image_url) {
        this.handleNoneRoast()
      }
    },
    handleCarouselSuccess (res, file, fileList) {
      if (res.status === 1000) {
        this.carouselFigure[this.uploadingIdx].image_url = res.web_data.path
        if (this.uploadingIdx === this.carouselFigure.length - 1) {
          this.canAddCarousel = true
        }
      } else {
        this.$alert(res.web_data.error, res.msg, {})
      }
    },
    handleLogoSuccess (res, file) {
      if (res.status === 1000) {
        this.home_setting.logo = res.web_data.path
      } else {
        this.$alert(res.web_data.error, res.msg, {})
      }
    },
    handleAvatarSuccess (res, file) {
      if (res.status === 1000) {
        this.share_setting.share_icon = res.web_data.path
      } else {
        this.$alert(res.web_data.error, res.msg, {})
      }
    },
    beforeCarouselUpload (file) {
      const isJPG = file.type === 'image/jpeg' || file.type === 'image/png'
      const isLt2M = file.size / 1024 / 1024 < 1
      if (!isJPG) {
        this.$message.error('上传图片只能是JPG和PNG格式!')
      }
      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 1MB!')
      }
      return isJPG && isLt2M
    },
    beforeAvatarUpload (file) {
      const isJPG = file.type === 'image/jpeg' || file.type === 'image/png'
      const isLt2M = file.size / 1024 / 1024 < 0.5
      if (!isJPG) {
        this.$message.error('上传图片只能是JPG和PNG格式!')
      }
      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 500kb!')
      }
      return isJPG && isLt2M
    },
    submitForm () {
      if (!this.canAddCarousel) {
        this.carouselFigure.splice(this.carouselFigure.length - 1, 1)
      }
      const menuSetting = this.home_setting.menu
      if (menuSetting['1'].code === menuSetting['2'].code || menuSetting['1'].code === menuSetting['3'].code || menuSetting['2'].code === menuSetting['3'].code) {
        this.$alert('底部菜单不能重复选择', '温馨提示', {})
      } else {
        this.changeRoastSort()
        this.submiting = true
        let params = {
          share_setting: this.share_setting,
          roasting_setting: this.carouselFigure,
          font_setting: this.font_setting,
          home_setting: this.home_setting,
          csrf_token: this.csrf_token
        }
        postSkinSaveSetting(params).then((res) => {
          this.submiting = false
          this.$alert('保存成功', '温馨提示', {})
          this.canAddCarousel = true
          if (!this.carouselFigure.length) {
            this.handleNoneRoast()
          }
        }).catch(() => {
          this.submiting = false
        })
      }
    }
  },
  watch: {
  },
  mounted () {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style >
  .menudesc label{
    margin-top: 10px;
  }
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #20a0ff;
  }

  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .shareicon .avatar-uploader-icon{
    width: 150px;
    height: 150px;
    line-height: 150px;    
  }
  .shareicon {
    width: 150px;
    height: 150px;    
  }
  .shareicon .el-upload{
    width: 100%;
    height: 100%;
  }
  .shareicon   .avatar{
    width: 100%;
    height: 100%;
    display: block;
  }
  .swiperItem,.add{
    max-width: 710px;
    min-width: 650px;
  }
.swiperItem .avatar-uploader{
  height: 178px;
  width: 356px;
}
  .swiperItem{
    padding-top: 22px;
    border: 1px dashed #d9d9d9;
  }
  .swiperItem .el-upload{
    width: 100%;
    height: 100%;
  }
  .swiperItem  .avatar {
    width: 100%;
    height: 100%;
    display: block;
  }

  .homestyle{
    text-align: center;
    max-width: 300px;
  }
  .homestyle img{
    width: 100%;
    display: block;
    margin: 0 auto 10px ;
  }
  .el-col{
    text-align: center;
  }
  .tip{
    font-size: 12px;
    color: #666;
  }
  /* .el-form-item{
    width: 60%;
  } */
  .jfk-fieldset{
    padding-top: 15px;
    padding-bottom: 15px;
  }
  .demoimg{
    width: 90%;
  }
  .swiperItem{
    /* border-bottom: 1px dotted red; */
    margin-bottom: 30px;
  }
  .swiper-action i{
    cursor: pointer;
    margin-right: 8px;
    font-size: 18px;
    color: #AC9456;
  }
.swiper-action i.icon-icon_close{
    color: #ff4949;
}
.add button{
    width: 100%;
}
.add button i{
    color: #8c939d;
}
.uploadbutton{
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  background-color: transparent;
}
.menudesc{
  margin-top: 10px;
}
.demoPop{
  background-color: rgba(0,0,0,0.5);
}
.demoPop .el-message-box__title{
  text-align: center;
}
.demoPop .el-message-box__btns{
  text-align: center;
}
.demoPop img{
  width: 65%;
  display: block;
  margin: 0 auto;
}
</style>
