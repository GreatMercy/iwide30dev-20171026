<template>
  <div class="gradient_bg padding_30 padding_0_15">
    <div class="layer_bg radius_3 padding_20 padding_0_15 overflow mar_b30" v-if="dataList.page_resource.public">
      <img :src="dataList.page_resource.public.logo" class="card_logo">
      <p class="card_name">{{dataList.page_resource.public.name}}</p>
    </div>
    <div class="between font_12">
        <div class="margin_right_30 relative padding_left_35">
          <div class="line_left absolute"><img src="../../assets/image/line_03.png" alt=""></div>
        </div>
        <p class="padding_0_20 padding_18 color_fff font_19">{{dataList.card_info.title}}</p>
        <p class="padding_0_20">{{dataList.card_info.notice}}</p>
      </div>
      <div class="mar_t60 mar_b20" v-if="dataList.card_info.is_online === '2' || dataList.card_info.is_online === '3'">
        <p class="mar_b30"><span class="color2 mar_r20 h24">线下使用方式</span><span class="color3 h24">(请选择以下任意一种方式使用)</span></p>
        <div class="clearfix layer_bg pad_tb40 pad_lr40 border_radius mar_b30">
            <p class="h28">方式一 :&nbsp;&nbsp;商家输入核销码</p>
            <div class="bd_bottom mar_t80 pad_b20">
                <input v-model="write" id="writeoffcode" class="color1 h30 w80" type="text" placeholder="请商家输入核销码">
            </div>
            <div class="center pad_t80">
                <a @click="writeUse" class="button mar_b40 spacing h34">提&nbsp;交</a>
            </div>
        </div>
        <div class="clearfix layer_bg pad_tb40 pad_lr40 border_radius">
            <p class="h28">方式二 :&nbsp;&nbsp;向商家出示二维码/卷码</p>
            <div class="erweima_img center margin_top_20 mar_b20">
                <img :src="['/index.php/membervip/center/qrcodecon?margin=0&data=' + dataList.card_info.consume_code]" alt="">
            </div>
            <p class="color1 center h34 spacing">{{dataList.card_info.coupon_code}}</p>
        </div>
      </div>
      <div class="mar_t40 bd_bottom pad_t40 pad_b80">
        <p>
          <span class="h26 width_75 inblock">使用方式</span>
          <span class="h30 color1">{{dataList.card_info.use_way}}</span>
        </p>
        <p class="mar_t20">
          <span class="h26 width_75 inblock">券&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码</span>
          <span class="h30 color1">{{dataList.card_info.coupon_code}}</span>
        </p>
        <p class="mar_t20">
          <span class="h26 width_75 inblock">使用期限</span>
          <span class="h30 color1">{{dataList.card_info.expire_time_quantum}}</span>
        </p>
      </div>
      <div class="webkitbox webkittop color3 mar_t60 mar_b40">
          <div class="iconfont h28 mar_r10">&#xe642;</div>
          <div>
              <div class="color2 h28 mar_b30">预定说明</div>
              <div class="h26" v-html="dataList.card_info.description" style="line-height:25px;"></div>
          </div>
      </div>
      <div  v-if="dataList.card_info.is_online === '2' || dataList.card_info.is_online === '3'">
         <a v-if="dataList.card_info.is_given_by_friend === 't' && dataList.card_info.is_giving === 'f' " class="block center padding_15 auto iconfont entry_btn" style="width:80%;" @click="share = true">赠送优惠券</a>
      </div>
      <div class="center mar_t80" v-if="dataList.card_info.is_online === '1' ">
        <a v-if="dataList.card_info.is_given_by_friend === 't' && dataList.card_info.is_giving === 'f' " class="padding_15 inblock iconfont entry_btn color1" style="width:45%;border: 0.5px solid #c0c0c0;" @click="share = true">赠送优惠券</a>
        <a v-if="dataList.card_info.is_giving === 'f' || dataList.card_info.card_type === '3'" class="padding_15 inblock iconfont entry_btn color1" style="width:45%;background-color: #b2945e;" @click="couponUse()">立即使用</a>
      </div>
      <div class="whole_eject" v-show="share" @click="share = false">
        <div class="txt_r">
          <img class="card_share_logo" src="../../assets/image/share_jian.png" alt="">
        </div>
        <div class="card_share_word pad_r40 font_19">
            <p class="mar_b40 color1">请<span class="main_color1">点击右上角</span>功能操作，<br>将优惠券转发给好友。</p>
            <p class="color3">好友超过24小时未领取则优惠券自动返还，您可再次转赠</p>
        </div>
      </div>
  </div>
</template>
<script>
import { getCardDetail, postDepositcardPasswduseoff } from '@/service/http'
import { formatUrlParams } from '@/utils/utils'
export default {
  data () {
    return {
      dataList: [],
      share: false,
      write: ''
    }
  },
  created () {
    let params = formatUrlParams(location.search)
    let setdata = {'member_card_id': params.member_card_id}
    getCardDetail(setdata).then((res) => {
      this.dataList = res.web_data
      // this.dataList.card_info.is_online = '1'
    })
  },
  methods: {
    writeUse () {
      let r = confirm('确定使用 ？')
      if (r) {
        let data = {
          member_card_id: this.dataList.card_info.member_card_id,
          passwd: this.write
        }
        postDepositcardPasswduseoff(data).then((res) => {
          if (res.status === 1) {
            window.location.href = '/card.html'
          } else {
            alert(res.msg)
          }
        })
      }
    }
  }
}
</script>
