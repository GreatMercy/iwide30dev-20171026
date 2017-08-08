<!-- DataTables -->
<link rel="stylesheet"
  href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/images/laydate.css">
<link rel="stylesheet" href="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/images/laydate12.css">
</head>
<style>
.weborder {
  background: #FFFFFF !important;
  display: none;
}

.morder {
  background: #FAFAFA !important;
}

.a_like {
  cursor: pointer;
  color: #72afd2;
}

.page {
  text-align: right;
  font-family: Verdana, Arial, Helvetica, sans-serif;
  font-size: 2em;
}

.page a {
  padding: 10px;
}

.current {
  color: #000000;
}
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="modal fade" id="setModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">显示设置</h4>
      </div>
      <div class="modal-body">
        <div id='cfg_items'>
        <?php echo form_open('distribute/distri_report/save_cofigs','id="setting_form"')?>
          
        </form></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="set_btn_save">保存</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="wrapper">

<?php
/* 顶部导航 */
echo $block_top;
?>

<?php
/* 左栏菜单 */
echo $block_left;
?>
<style>
@font-face {
  font-family: 'iconfont';
  src: url('http://test008.iwide.cn/public/newfont/iconfont.eot');
  src: url('http://test008.iwide.cn/public/newfont/iconfont.eot?#iefix') format('embedded-opentype'),
  url('http://test008.iwide.cn/public/newfont/iconfont.woff') format('woff'),
  url('http://test008.iwide.cn/public/newfont/iconfont.ttf') format('truetype'),
  url('http://test008.iwide.cn/public/newfont/iconfont.svg#iconfont') format('svg');
}
.iconfont{
  font-family:"iconfont" !important;
  font-size:16px;font-style:normal;
  -webkit-font-smoothing: antialiased;
  -webkit-text-stroke-width: 0.2px;
  -moz-osx-font-smoothing: grayscale;
}
.over_x{width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-webkit-overflow-scrolling:touch;overflow-scrolling:touch;}
.clearfix:after{content:"" ;display:block;height:0;clear:both;visibility:hidden;}
.bg_fff{background:#fff;}
.color_fff{color:#fff;}
.bg_ff0000{background:#ff0000;}
.bg_f8f9fb{background:#f8f9fb;}
.bg_ff9900{background:#ff9900;}
.bg_e8eaee{background:#e8eaee;}
.bg_fe6464{background:#fe6464;}
.color_72afd2{color:#72afd2;}
.color_ff9900{color:#ff9900;}
.color_F99E12{color:#F99E12;}
.color_d4d7db{color:#d4d7db;}
.color_2d87e2{color:#2d87e2;}
a{color:#92a0ae;}

.border_1{border:1px solid #d7e0f1;}
.f_r{float:right;}
.p_0_20{padding:0 20px;}
.w_90{width:90px;}
.w_200{width:200px;}
.p_r_30{padding-right:30px;}
.m_t_10{margin-top:10px;}
.m_b_10{margin-bottom:10px;}
.p_0_30_0_10{padding:0 30px 0 10px;}
.b_b_1{border-bottom:1px solid #d7e0f1;}
.b_t_1{border-top:1px solid #d7e0f1;}
.p_t_10{padding-top:10px;}
.p_b_10{padding-bottom:10px;}
.p_l_10{padding-left:10px;}
.p_t_20{padding-top:20px;}
.p_b_20{padding-bottom:20px;}

.banner{height:50px;width:100%;line-height:50px;border-bottom:1px solid #d7e0f1;padding-right:0px;}
.banner > span{padding:0px 5px;margin-left:5px;border-radius:3px;font-size:11px;}
.news{position:relative;cursor:pointer;background:#fe8f00;height:100%;padding:0px 12px;color:#fff;}
.news_radius{padding:0 2px;border-radius:3px;background:#fff;color:#fe8f00;text-align:center;font-size:8px;margin-left:8px;}
.display_flex{display:flex;display:-webkit-flex;justify-content:top;align-items:center;-webkit-align-items:center;}
.display_flex >div{-webkit-flex:1;flex:1;;cursor:pointer;}
.j_toshow{width:320px;min-height:100%;position:absolute;top:50px;right:-330px;box-shadow:-5px 0px 15px rgba(0,0,0,0.1);-webkit-box-shadow:-5px 0px 15px rgba(0,0,0,0.1);}
.toshow_con{padding:12px;}
.t_con_list{margin-bottom:12px;height:170px;}
.close_btn{cursor:pointer;}
.toshow_con_titl{background:#f0f3f6;font-size:13px;padding:10px;border-bottom:1px solid #d7e0f1;}
.toshow_con_list{padding:10px;font-size:11px;height:114px;overflow:hidden;}
.toshow_con_list >a{display:block;margin-bottom:5px;}
.toshow_con_list >a:last-child{margin-bottom:0px;}
.toshow_titl_txt{position:relative;}
.radius_txt{position:absolute;top:0px;left:105%;border-radius:3px;text-align:center;padding:0px 3px;font-size:12px;}
select,input,.moba{height:30px;line-height:30px;border:1px solid #d7e0f1;text-indent:3px;}

.contents{padding:10px 0px 20px 20px;}
.contents_list{display:table;width:100%;border:1px solid #d7e0f1;margin-bottom:10px;}
.head_cont{padding:20px 0 20px 10px;}
.head_cont >div{margin-bottom:10px;cursor:pointer;}
.head_cont >div:last-child{margin-bottom:0px;}
.h_btn_list .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;}
.h_btn_list> div{display:inline-block;width:100px;border:1px solid #d7e0f1;text-align:center;padding:6px 0px;border-radius:5px;margin-right:8px;}
.h_btn_list> div:last-child{margin-right:0px;}
.j_head >div{display:inline-block;}
.j_head >div:nth-of-type(1){width:307px;}
.j_head >div:nth-of-type(2){width:255px;}
.j_head >div:nth-of-type(3){width:526px;}
.j_head >div >span:nth-of-type(1){display:inline-block;width:60px;text-align:center;}
.title,.classification{height:30px;line-height:30px;}
.classification >div{width:70px;display:inline-block;text-align:center;height:30px;}
.classification .add_active{border-bottom:3px solid #ff9900;}
.fomr_term{height:30px;line-height:30px;}
.classification >div,.all_open_order{cursor:pointer;}
.template >div{text-align:center;}
.template >div:nth-of-type(1){-webkit-flex:3.7;flex:3.7;text-align:left;padding-left:10px;}
.template >div:nth-of-type(2){-webkit-flex:1.2;flex:1.2;}
.template >div:nth-of-type(7){-webkit-flex:1.3;flex:1.3;}
.template_img{float:left;width:50px;height:50px;overflow:hidden;vertical-align:middle;margin-right:2%;}
.template_span{display:inline-block;margin-top:2px;}
.template_btn{padding:1px 8px;border-radius:3px;}
.temp_con >div >span{line-height:1.7;}
.room{width:52px;display:inline-block;}
.con_list > div:nth-child(odd){background:#fafcfb;}
.con_list{display:none;}

.drow_list{display:none;position:absolute;width:100%;top:100%;left:0;background:#fff;border:1px solid #e4e4e4;padding:0;overflow:auto;z-index:999}
.drow_list li{height:35px;padding-left:15px;line-height:35px;list-style:none; cursor:pointer}
.drow_list li:hover{background:#f1f1f1}
.drow_list li.cur{background:#ff9900;color:#fff}
#drowdown:hover .drow_list{display:block}
.fixed_box{position:fixed;top:36%;left:48%;z-index:9999;border:1px solid #d7e0f1;border-radius:5px;padding:1%;display:none;}

.display_table >div:nth-of-type(1) >img,.comment_btn,.reply_btn,.confirms,.cancel{cursor:pointer;}
.main{padding-left:10px;}
.display_table{display:table;border-collapse:collapse;width:100%;}
.display_table >div{display:table-cell;text-align:center;}
.display_table >div:nth-of-type(1){width:20%;text-align:left;}
.display_table >div:nth-of-type(2){width:12%;}
.display_table >div:nth-of-type(3){width:18%;}
.display_table >div:nth-of-type(4){width:16%;}
.display_table >div:nth-of-type(5){width:7%;}
.display_table >div:nth-of-type(6){width:16%;}
.display_table >div:nth-of-type(7){width:8%;}
.main_con > div{line-height:1.8;}
.display_table >div:nth-of-type(1) img{width:24px;height:24px;overflow:hidden;margin:auto;}
.score >div span:nth-of-type(1){margin-right:8px;}
.confirms,.cancel{width:70px !important;padding:3px 0 !important;}
.comment{display:none;}
.sign_number{margin-top:3px;}
</style>
<div class="fixed_box bg_fff">
  <textarea class="border_1 textarea_con" style="width:356px;height:142px;"></textarea>
  <div class="h_btn_list clearfix">
    <span class="f_r color_d4d7db sign_number">您还可以输入300字</span>
    <div class="actives confirms">确认</div>
    <div class="cancel">取消</div>
  </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;">
            <div class="banner bg_fff p_0_20">
                <div class="f_r news"><i class="iconfont" style="font-size:22px;vertical-align:middle;margin-right:5px;">&#xe623;</i>消息<span class="news_radius bg_ff0000">8</span></div>
                评论管理
            </div>
            <div class="contents">
        <div class="head_cont contents_list bg_fff">
          <div class="j_head">  
            <div>
              <span>酒店名称</span>
              <span class="input-group w_200" style="position:relative;display:inline-flex;" id="drowdown">
                <input placeholder="选择或输入关键字" type="text" style="color:#92a0ae;" class="form-control w_200 moba" id="search_hotel" >
                <ul class="drow_list">
                      <li value="">碧桂园凤凰大酒店</li>
                      <li value="">北京金茂万丽酒店</li>
                      <li value="">上海街町酒店</li>
                      <li value="">深圳威尼斯酒店</li>
                      <li value="">街町酒店广州测试店</li>
                      <li value="">广州金房卡大酒店</li>
                </ul>
              </span>
            </div>
            <div>
              <span>房型名称</span>
              <span>
                <select class="w_90">
                    <option value="1">房型名称</option>
                    <option value="2">房型名称1</option>
                    <option value="3">房型名称2</option>
                </select>
              </span>
            </div>
            <div>
              <span>时间筛选</span>
              <span class="t_time"><input name="start_t" type="text" id="datepicker" class="datepicker moba" value=""></span>
                            <font>至</font>
                            <span class="t_time"><input name="end_t" type="text" id="datepicker2" class="datepicker moba" value=""></span>
            </div>
          </div>
          <div class="j_head">
            <div>
              <span>关键字</span>
              <span><input type="text" placeholder="输入关键字搜索"/></span>
            </div>
            <div>
              <span>订单号</span>
              <span><input type="text" placeholder="输入关键字搜索"/></span>
            </div>
            <div>
              <span>时间筛选</span>
              <span>
                <select class="w_90" name="paystatus">
                  <option value="-1">总评分</option>
                  <option value="0">不矢量</option>
                  <option value="1">不知道</option>
                </select>
              </span>
              <span>
                <select name="orderstatus" class="w_90">
                  <option value="">全部评分</option>
                  <option value="0">10</option>
                  <option value="0">9</option>
                  <option value="1">8</option>
                  <option value="2">7</option>
                  <option value="2">6</option>
                  <option value="3">5</option>
                  <option value="4">4</option>
                  <option value="5">3</option>
                  <option value="11">2</option>
                  <option value="11">1</option>
                  <option value="11">0</option>
                </select>
              </span>
            </div>
          </div>
          <div class="h_btn_list" style="">
            <div class="actives">筛选</div>
            <div>条件重置</div>
          </div>
        </div>
        <div class="contents_list bg_fff" style="font-size:13px;">
          <div class="p_r_30 classification b_b_1">
            <div class="add_active">全部</div>
            <div>好评</div>
            <div>中评</div>
            <div>差评</div>
          </div>
          <div class="main bg_f8f9fb">
            <div class="title display_table">
              <div>评价内容</div>
              <div>评分</div>
              <div>商品信息</div>
              <div>订单号</div>
              <div>用户</div>
              <div>评论时间</div>
              <div>操作</div>
            </div>
          </div>
        </div>
        <div class="border_1 b_box m_b_10">
          <div class="main bg_fff  p_t_20 p_b_20 ">
            <div class="main_con display_table">
              <div>
                <p>还行吧。巴拉巴拉吧啦。还行吧。巴拉巴拉吧啦。</p>
                <p>
                  <img src="http://test008.iwide.cn/public/AdminLTE/dist/img/iwide_logo.png" class="img_circle" />
                  <img src="http://test008.iwide.cn/public/AdminLTE/dist/img/iwide_logo.png" class="img_circle" />
                  <img src="http://test008.iwide.cn/public/AdminLTE/dist/img/iwide_logo.png" class="img_circle" />
                  <img src="http://test008.iwide.cn/public/AdminLTE/dist/img/iwide_logo.png" class="img_circle" />
                  <img src="http://test008.iwide.cn/public/AdminLTE/dist/img/iwide_logo.png" class="img_circle" />
                  <img src="http://test008.iwide.cn/public/AdminLTE/dist/img/iwide_logo.png" class="img_circle" />
                </p>
              </div>
              <div class="score">
                <div>总评分:4.5</div>
                <div>
                  <span>服务:4.0 </span>
                  <span>网络:4.5</span>
                </div>
                <div>
                  <span>卫生:5.0</span>
                  <span>设施:4.5</span>
                </div>
              </div>
              <div>
                <div>金房卡大酒店广州岗顶店</div>
                <div>行政大床房</div>
              </div>
              <div class="color_ff9900">ek13829312132</div>
              <div>廖大雄</div>
              <div>
                <div>2016.07.08</div>
                <div>17:08:09</div>
              </div>
              <div class="">
                <div class="reply_btn color_2d87e2">回复</div>
                <div class="comment_btn color_2d87e2">显示该评论</div>
              </div>
            </div>
          </div>
          <div class="bg_f8f9fb p_l_10 p_b_10 p_t_10 comment b_t_1"></div>
        </div>
        <div class="border_1 b_box m_b_10">
          <div class="main bg_fff  p_t_20 p_b_20 ">
            <div class="main_con display_table">
              <div>
                <p>还行吧。巴拉巴拉吧啦。还行吧。巴拉巴拉吧啦。</p>
                <p>
                  <img src="http://test008.iwide.cn/public/AdminLTE/dist/img/iwide_logo.png" class="img_circle" style="width:24px;height:24px;" />
                  <img src="http://ihotels.iwide.cn/public/hotel/uploads/a429262687/img/top1.jpg" class="img_circle" style="width:24px;height:24px;" />
                  <img src="http://ihotels.iwide.cn/public/hotel/uploads/a429262687/img/15.jpg" class="img_circle" style="width:24px;height:24px;" />
                  <img src="http://test008.iwide.cn/public/AdminLTE/dist/img/iwide_logo.png" class="img_circle" style="width:24px;height:24px;" />
                  <img src="http://test008.iwide.cn/public/AdminLTE/dist/img/iwide_logo.png" class="img_circle" style="width:24px;height:24px;" />
                  <img src="http://test008.iwide.cn/public/AdminLTE/dist/img/iwide_logo.png" class="img_circle" style="width:24px;height:24px;" />
                </p>
              </div>
              <div class="score">
                <div>总评分:4.5</div>
                <div>
                  <span>服务:4.0 </span>
                  <span>网络:4.5</span>
                </div>
                <div>
                  <span>卫生:5.0</span>
                  <span>设施:4.5</span>
                </div>
              </div>
              <div>
                <div>金房卡大酒店广州岗顶店</div>
                <div>行政大床房</div>
              </div>
              <div class="color_ff9900">ek13829312132</div>
              <div>廖大雄</div>
              <div>
                <div>2016.07.08</div>
                <div>17:08:09</div>
              </div>
              <div class="">
                <div class="reply_btn color_2d87e2">回复</div>
                <div class="comment_btn color_2d87e2">显示该评论</div>
              </div>
            </div>
          </div>
          <div class="bg_f8f9fb p_l_10 p_b_10 p_t_10 comment b_t_1"></div>
        </div>
    </div>


    <div class="j_toshow bg_fff">
        <div class="banner bg_fff p_0_20">消息中心（8未读）<i class="iconfont f_r close_btn" style="font-size:24px;">&#xe635;</i></div>
        <div class="toshow_con">
            <div class="border_1 t_con_list">
                <div class="toshow_con_titl">
                    <a class="f_r mores" href="">更多</a>
                    <span class="toshow_titl_txt">订单消息<div class="radius_txt bg_ff0000 color_fff">6</div></span>
                </div>
                <div class="toshow_con_list">
                    <a href="">[待确认]您有一条新的订房订单需要确认哦！</a>
                    <a href="">[待确认]您有一条新的订房订单需要确认哦！</a>
                    <a href="">[待确认]您有一条新的订房订单需要确认哦！</a>
                    <a href="">[待确认]您有一条新的订房订单需要确认哦！</a>
                    <a href="">[待确认]您有一条新的订房订单需要确认哦！</a>
                </div>
            </div>
            <div class="border_1 t_con_list">
                <div class="toshow_con_titl">
                    <a class="f_r mores" href="">更多</a>
                    <span class="toshow_titl_txt">用户评价<div class="radius_txt bg_ff0000 color_fff">1</div></span>
                </div>
                <div class="toshow_con_list">
                    <a href="">[买家评价]还好吧，挺干净的，也挺安静。</a>
                </div>
            </div>
            <div class="border_1 t_con_list">
                <div class="toshow_con_titl">
                    <a class="f_r mores" href="">更多</a>
                    <span class="toshow_titl_txt">全员分销<div class="radius_txt bg_ff0000 color_fff">2</div></span>
                </div>
                <div class="toshow_con_list">
                    <a href="">[待审核]有新申请分销员等待您审核哦！</a>
                    <a href="">[待审核]有新申请分销员等待您审核哦！</a>
                </div>
            </div>
            <div class="border_1 t_con_list">
                <div class="toshow_con_titl">
                    <a class="f_r mores" href="">更多</a>
                    <span class="toshow_titl_txt">社群客<div class="radius_txt bg_ff0000 color_fff">2</div></span>
                </div>
                <div class="toshow_con_list">
                    <a href="">[待审核]有新申请分销员等待您审核哦！</a>
                    <a href="">[待审核]有新申请分销员等待您审核哦！</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/* Footer Block @see footer.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'footer.php';
?>

<?php
/* Right Block @see right.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'right.php';
?>



<?php
/* Right Block @see right.php */
require_once VIEWPATH . $tpl . DS . 'privilege' . DS . 'commonjs.php';
?>
<!--日历调用开始-->
<!-- <script src="http://30.iwide.cn/public/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="http://30.iwide.cn/public/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="http://30.iwide.cn/public/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script> -->
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/layDate.js"></script>
<!--日历调用结束-->
<script>
;!function(){
  laydate({
     elem: '#datepicker'
  })
  laydate({
     elem: '#datepicker2'
  })
}();
</script>
<script>
$(function(){
  $('.display_table >div:nth-of-type(1) >img').click(function(){
    var src=$(this).attr('src');
    var imgs=$('<img id="img_b" src="'+src+'" style="width:400px;height:auto;overflow:hidden;margin:auto;position:absolute;top:35%;left:50%;"/>');
    $('.over_x').append(imgs);
  })
  $('.over_x').delegate('#img_b','click',function(){
    $(this).remove();
  })
  var boole=true;
  var arr=['显示该评论','隐藏该评论'];
  $('.comment_btn').click(function(){     //显示评论
    if($(this).parents('.b_box').find('.comment').html()!=''){
      $(this).parents('.b_box').find('.comment').slideToggle();
      if(boole){
        $(this).html(arr[1]);
      }else{
        $(this).html(arr[0]);
      }
      boole=!boole;
    }
  });
  $('.textarea_con').keyup(function(){  //监测输入字数
    var numb=300-$('.textarea_con').val().length;
        $('.sign_number').html('您还可以输入'+numb+'字');
  });
  $('.reply_btn').click(function(){   //添加评论和刷新弹窗。。。
    if($(this).hasClass('color_2d87e2')){
        var _this=$(this);
        $('.textarea_con').val('');
        $('.sign_number').html('您还可以输入300字');
        $('.fixed_box').fadeIn();

        $('.confirms').click(function(){
          if($('.textarea_con').val()!=''){
            $('.fixed_box').fadeOut();
            _this.parents('.b_box').find('.comment').html('已回复：'+$('.textarea_con').val());
            _this.removeClass('color_2d87e2');
          }
        })
        $('.cancel').click(function(){
          $('.fixed_box').fadeOut();
        });
    }
  });
    $('.drow_list li').click(function(){
        $('#search_hotel').val($(this).text());
        $(this).addClass('cur').siblings().removeClass('cur');
    });
  $('.classification >div').click(function(){
    $(this).addClass('add_active').siblings().removeClass('add_active');
  })
  $('.open_order').click(function(){
    $(this).parent().parent().next().slideToggle();
  })
  $('.all_open_order').click(function(){
    $('.con_list').slideToggle();
  })
  $('.news').click(function(){
      $('.j_toshow').animate({"right":"0px"},800);
  });
  $('.close_btn').click(function(){
      $('.j_toshow').animate({"right":"-330px"},800);
  });
  <!--日历调用-->
  // $('.datepicker').datepicker({
  //  dateFormat: "yymmdd"
  // });
  var tips=$('#tips');
  $('.btn_o').click(function(){
    //console.log( decodeURIComponent($(".form").serialize(),true));
    start=$('.t_time').find('input[name="start_t"]').val().replace(/-/g,'');
    end=$('.t_time').find('input[name="end_t"]').val().replace(/-/g,'');
    if(start!=''&&start!=undefined){
      if(isNaN(start)){
        tips.html('开始日期错误');
        setout(tips);
        return false;
      }
      if(end!=''&&end!=undefined){
        if(isNaN(end)||end<start){
          tips.html('结束日期错误或大于开始日期');
          setout(tips);
          return false;
        }
      }
    }
  })
})
<!--杰 2016/8/30-->
function setout(obj){
  setTimeout(function(){
    obj.fadeOut();  
  },2000) 
}
var orderid='';
function show_detail(obj){
  $('#status_detail').html('');
  $('#myModalLabel').html('单号：');
  var temp='';
  orderid='';
  $.get('<?php echo site_url('hotel/orders/order_status')?>',{
    oid:$(obj).attr('oid'),
    hotel:$(obj).attr('h')
  },function(data){
    orderid=data.order.orderid;
    if(data.after!=''){
      temp+='<select id="after_status">';
      $.each(data.after,function(i,n){
        if(i!=4)
          temp+='<option value="'+i+'">'+n+'</option>';   
      });
      temp+='</select>';
    }else{
      temp+=data.order.status_des;
      orderid='';
    }
    $('#status_detail').html(temp);
    $('#myModalLabel').append(data.order.orderid);
  },'json');
}
function change_status(){
  if(orderid){
    $.get('<?php echo site_url('hotel/orders/update_order_status');?>',{
      oid:orderid,
      status:$('#after_status').val()
    },function(data){
      if(data==1){
        alert('修改成功');
        location.reload();
      }else{
        alert('修改失败');
      }
    });
  }
  $('#myModal').modal('hide');
}
function slidesub(id){
  chose="[name='"+'weborder'+id+"']";
  if($(chose).css("display")=='table-row'){
    $(chose).css("display",'none');
  }
  else{
    $(chose).css("display",'table-row');
  }
}
<!--yu 2016/09/19-->
$('#grid-btn-set').click(function(){
  var str = '<input type="hidden" name="<?php echo $this->security->get_csrf_token_name ();?>" value="<?php echo $this->security->get_csrf_hash ();?>" style="display:none;">';
  $.getJSON('<?php echo site_url("hotel/orders/get_cofigs?ctyp=ORDERS_STATUS_HOTEL")?>',function(data){
    $.each(data,function(k,v){
      str += '<div class="checkbox"><label><input type="checkbox" name="' + k + '"';
      if(v.must == 1){
        str += ' disabled checked ';
      }else if(v.choose == 1){
        str += ' checked ';
      }
      str += '>' + v.name + '</label></div>';
    });
    $('#setting_form').html(str);
  });

});
$('#set_btn_save').click(function(){
  $.post('<?php echo site_url("hotel/orders/save_cofigs?ctyp=ORDERS_STATUS_HOTEL")?>',$("#setting_form").serialize(),function(data){
    if(data == 'success'){
      window.location.reload();
    }else{
      alert('保存失败');
    }
  });
});
</script>
</body>
</html>
