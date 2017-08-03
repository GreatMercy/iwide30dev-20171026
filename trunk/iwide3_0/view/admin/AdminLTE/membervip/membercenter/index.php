<!-- DataTables -->
<link rel="stylesheet"
  href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/images/laydate.css">
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/images/laydate12.css">
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
  src: url('<?php echo base_url(FD_PUBLIC);?>/newfont/iconfont.eot');
  src: url('<?php echo base_url(FD_PUBLIC);?>/newfont/iconfont.eot?#iefix') format('embedded-opentype'),
  url('<?php echo base_url(FD_PUBLIC);?>/newfont/iconfont.woff') format('woff'),
  url('<?php echo base_url(FD_PUBLIC);?>/newfont/iconfont.ttf') format('truetype'),
  url('<?php echo base_url(FD_PUBLIC);?>/newfont/iconfont.svg#iconfont') format('svg');
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
.color_A4C4ED{color:#A4C4ED;}
.color_E9858A{color:#E9858A;}
.color_B3CEF0{color:#B3CEF0;}
.color_FFAF28{color:#FFAF28;}
.color_E6757A{color:#E6757A;}
.color_C9DCF4{color:#C9DCF4;}
.color_F5C9CB{color:#F5C9CB;}
.color_FAEA9A4{color:#AEA9A4}
a{color:#92a0ae;}

td,th,.border_1{border:1px solid #d7e0f1;}
.f_r{float:right;}
.p_0_20{padding:0 20px;}
.p_20{padding:20px;}
.w_90{width:90px;}
.w_130{width:130px;}
.w_200{width:200px;}
.p_r_30{padding-right:30px;}
.m_t_10{margin-top:10px;}
.p_0_30_0_10{padding:0 30px 0 10px;}
.b_b_1{border-bottom:1px solid #d7e0f1;}
.b_t_1{border-top:1px solid #d7e0f1;}
.p_t_10{padding-top:10px;}
.p_b_10{padding-bottom:10px;}
.absolute{position:absolute;}
.relative{position:relative;}
.t_4{top:4px;}
.r_3{right:3px;}


.containers >div:nth-child(odd){background:#F8F8F8 !important;}
.containers >div:nth-child(even){background:#fff !important;}
.input_txt{height:30px;line-height:30px;}
.input_txt >input{height:30px;line-height:30px;border:1px solid #d7e0f1;width:450px;text-indent:3px;}
.input_txt >select{height:30px;line-height:30px;display:inline-block;border:1px solid #d7e0f1;background:#fff;margin-right:20px;padding:0 8px;}
.input_radio >div{margin-right:28px;display:inline-block;}
.input_radio >div >input{display:none;}
.input_radio >div >input+label{font-weight:normal;text-indent:25px;background:url(http://test008.iwide.cn/public/js/img/radio1.png) no-repeat center left;background-size:13%;width:155px;height:30px;line-height:30px;}
.input_radio >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/radio2.png) no-repeat center left;background-size:13%;}
.table{display:table;margin-bottom:0px;}
.table >div{display: table-cell;width:137px;}
.contents{padding:10px 20px 85px 20px;}
.contents_list{display:table;width:100%;border:1px solid #d7e0f1;margin-bottom:10px;}
.head_cont{padding:20px 0 20px 10px;}
.head_cont >div{margin-bottom:10px;cursor:pointer;}
.head_cont >div:last-child{margin-bottom:0px;}
.h_btn_list .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;}
.h_btn_list> div{display:inline-block;width:100px;border:1px solid #d7e0f1;text-align:center;padding:6px 0px;border-radius:5px;margin-right:8px;}
.h_btn_list> div:last-child{margin-right:0px;}
.f_r_con >div,.j_head >div{display:inline-block;}
.f_r_con >div{margin-right:10px;}
.classification{height:50px;line-height:50px;margin-bottom:18px;}
.classification >div{width:98px;display:inline-block;text-align:center;height:50px;}
.classification .add_active{border-bottom:3px solid #ff9900;}
.fomr_term{height:30px;line-height:30px;}
.classification >div,.all_open_order{cursor:pointer;}
.template >div{text-align:center;}
.template_img{float:left;width:60px;height:60px;overflow:hidden;vertical-align:middle;margin-right:2%;}
.template_span{display:block;line-height:1.3 !important;overflow:hidden;text-overflow:ellipsis;display:-webkit-box; -webkit-box-orient:vertical;-webkit-line-clamp:2; }
.template_btn{padding:1px 8px;border-radius:3px;}
.temp_con{border-bottom:1px solid #d7e0f1;}
.temp_con:last-child{border-bottom:none;}
.temp_con >div >span{line-height:1.7;}
.room{width:52px;display:inline-block;}
.con_list > div:nth-child(odd){background:#fafcfb;}
.con_list{display:none;}
.frames_c{padding:2px 8px;margin-right:10px;border-radius:3px;}
.t_money{font-size:13px;}

.drow_list{display:none;position:absolute;width:100%;top:100%;left:0;background:#fff;border:1px solid #e4e4e4;padding:0;overflow:auto;z-index:999}
.drow_list li{height:35px;padding-left:15px;line-height:35px;list-style:none; cursor:pointer}
.drow_list li:hover{background:#f1f1f1}
.drow_list li.cur{background:#ff9900;color:#fff}
#drowdown:hover .drow_list{display:block}
.fixed_box{position:fixed;top:36%;left:48%;z-index:9999;border:1px solid #d7e0f1;border-radius:5px;padding:1% 2%;display:none;}
.tile{font-size:15px;text-align:center;margin-bottom:4%;}
.f_b_con{font-size:13px;text-align:center;margin-bottom:8%;}
.pointer,.delivery,.confirms,.cancel{cursor:pointer;}
.pagination{margin-top:0px;margin-bottom:0px;}
.btn_list_r span{margin-right:10px;}
.btn_list_r span:last-child{margin-right:0px;}
select,input{width:280px;}

.pages {
  float: right;
  margin: 20px 0;
}
.pages #Pagination {
  float: left;
  overflow: hidden;
}
.pages #Pagination .pagination {
  height: 40px;
  text-align: right;
  font-family: \u5b8b\u4f53,Arial;
}
.pages #Pagination .pagination a,
.pages #Pagination .pagination span {
  float: left;
  display: inline;
  padding: 11px 13px;
  border: 1px solid #e6e6e6;
  border-right: none;
  background: #f6f6f6;
  color: #666666;
  font-family: \u5b8b\u4f53,Arial;
  font-size: 14px;
  cursor: pointer;
}
.pages #Pagination .pagination .current {
  background: #ffac59;
  color: #fff;
}
.pages #Pagination .pagination .prev,
.pages #Pagination .pagination .next {
  float: left;
  padding: 11px 13px;
  border: 1px solid #e6e6e6;
  background: #f6f6f6;
  color: #666666;
  cursor: pointer;
}
.pages #Pagination .pagination .prev i,
.pages #Pagination .pagination .next i {
  display: inline-block;
  width: 4px;
  height: 11px;
  margin-right: 5px;
  background: url(icon.fw.png) no-repeat;
}
.pages #Pagination .pagination .prev {
  border-right: none;
}
.pages #Pagination .pagination .prev i {
  background-position: -144px -1px;
  *background-position: -144px -4px;
}
.pages #Pagination .pagination .next i {
  background-position: -156px -1px;
  *background-position: -156px -4px;
}
.pages #Pagination .pagination .pagination-break {
  padding: 11px 5px;
  border: none;
  border-left: 1px solid #e6e6e6;
  background: none;
  cursor: default;
}
.nav-icon{width: 74px;height: 90px;display: inline-block;border: 5px solid #ffffff;}.nav-box{margin: 8px;}
.nav-icon:hover{border: 5px solid #ddd;}
.nav-icon p.icon-box{width: 100%;  height: 73%;background-position:center center;background-repeat: no-repeat; background-size: 100% 100%; margin: 0; cursor: pointer;}
.nav-icon p.ui_icon1{background-image: url("/public/AdminLTE/media/member/icon/icon1.png");}
.nav-icon p.ui_icon2{background-image: url("/public/AdminLTE/media/member/icon/icon2.png");}
.nav-icon p.ui_icon3{background-image: url("/public/AdminLTE/media/member/icon/icon3.png");}
.nav-icon p.ui_icon4{background-image: url("/public/AdminLTE/media/member/icon/icon4.png");}
.nav-icon p.ui_icon5{background-image: url("/public/AdminLTE/media/member/icon/icon5.png");}
.nav-icon p.ui_icon6{background-image: url("/public/AdminLTE/media/member/icon/icon6.png");}
.nav-icon p.ui_icon7{background-image: url("/public/AdminLTE/media/member/icon/icon7.png");}
.nav-icon p.ui_icon8{background-image: url("/public/AdminLTE/media/member/icon/icon8.png");}
.nav-icon p.ui_icon9{background-image: url("/public/AdminLTE/media/member/icon/icon9.png");}
.nav-icon p.ui_icon10{background-image: url("/public/AdminLTE/media/member/icon/icon10.png");}
.nav-icon p.ui_icon11{background-image: url("/public/AdminLTE/media/member/icon/icon11.png");}
.nav-icon p.ui_icon12{background-image: url("/public/AdminLTE/media/member/icon/icon12.png");}
.nav-icon p.ui_icon13{background-image: url("/public/AdminLTE/media/member/icon/icon13.png");}
.nav-icon p.ui_icon14{background-image: url("/public/AdminLTE/media/member/icon/icon14.png");}
.nav-icon p.ui_icon15{background-image: url("/public/AdminLTE/media/member/icon/icon15.png");}
.nav-icon p.ui_icon16{background-image: url("/public/AdminLTE/media/member/icon/icon16.png");}
.nav-icon p.ui_icon17{background-image: url("/public/AdminLTE/media/member/icon/icon17.png");}
.nav-icon p.ui_icon18{background-image: url("/public/AdminLTE/media/member/icon/icon17.png");}
.nav-icon p.ui_icon19{background-image: url("/public/AdminLTE/media/member/icon/icon18.png");}
.nav-icon p.text{text-align: center;margin: 0;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;}
.containers table{width:100%;}
#display_img{line-height:90px;float:left;}
td,th{padding:10px;}
td > div >div{display:inline-block;}
.btn_e_d span{margin-right:30px;}
</style>
<div class="fixed_box bg_fff">
  <div class="tile"></div>
  <div class="f_b_con">
    你是否要删除这条信息 ？
  </div>
  <div class="f_b_con">
    <span></span>
    <span></span>
  </div>
  <div class="h_btn_list clearfix" style="">
    <div class="actives confirms">确认</div>
    <div class="cancel f_r">取消</div>
  </div>
</div>
<div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModal2Label">选择导航图片</h4>
                </div>
                <div class="modal-body">
                    <div class="nav-box nav-icon select-icon" data-icon="icon1">
                        <p class="icon-box ui_icon1"></p>
                        <p class="text">我的身份</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon2">
                        <p class="icon-box ui_icon2"></p>
                        <p class="text">酒店订单</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon3">
                        <p class="icon-box ui_icon3"></p>
                        <p class="text">商城订单</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon4">
                        <p class="icon-box ui_icon4"></p>
                        <p class="text">在线预订</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon5">
                        <p class="icon-box ui_icon5"></p>
                        <p class="text">我的收藏</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon6">
                        <p class="icon-box ui_icon6"></p>
                        <p class="text">我的地址</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon7">
                        <p class="icon-box ui_icon7"></p>
                        <p class="text">全员营销</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon8">
                        <p class="icon-box ui_icon8"></p>
                        <p class="text">社群客</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon9" title="关于金房卡">
                        <p class="icon-box ui_icon9"></p>
                        <p class="text">关于金房卡</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon37">
                        <p class="icon-box ui_icon37"></p>
                        <p class="text">我的权益</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon11">
                        <p class="icon-box ui_icon11"></p>
                        <p class="text">我的余额</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon12">
                        <p class="icon-box ui_icon12"></p>
                        <p class="text">记录</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon13">
                        <p class="icon-box ui_icon13"></p>
                        <p class="text">绑定</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon14">
                        <p class="icon-box ui_icon14"></p>
                        <p class="text">充值</p>
                    </div>
                    <div class="nav-box nav-icon select-icon" data-icon="icon15">
                        <p class="icon-box ui_icon15"></p>
                        <p class="text">购卡</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;">
            <div class="banner bg_fff p_0_20">会员中心</div>
            <div class="contents">
              <form class="form" method='get' id="this_form" >
                <div class="head_cont contents_list bg_fff">
                  <div class="j_head clearfix">
                    <div  class="h_btn_list" style="">
                      <div class="actives" id='subbtn'>新增模块</div>
                    </div>
                    <div class="f_r f_r_con">
                        <div>
                            <input type="text" placeholder="搜索">
                        </div>
                    </div>
                  </div>
                </div>
              </form>
              <div class="containers">
                <table class="m_t_10 bg_fff">
                    <thead>
                        <tr>
                            <td colspan="2">
                                <div class="f_r btn_e_d">
                                    <span class="color_C9DCF4 b_edit pointer">编辑</span>
                                    <span class="color_F5C9CB b_del pointer">删除</span>
                                </div>
                                <div>序号：1</div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div>
                                    <div>分组序号:</div>
                                    <div>
                                        <select disabled="disabled">
                                            <option>分组序号</option>
                                            <option>分组序号2</option>
                                            <option>分组序号3</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div>模块名称:</div>
                                    <div class="relative"><input type="" placeholder="10" value="10" disabled="disabled"></div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div>
                                    <div>模块链接:</div>
                                    <div class="relative"><input type="" placeholder="20" value="" disabled="disabled"></div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div id="display_img">图标样式:</div>
                                    <div class="relative">
                                        <div class="nav-icon rewrte select-nav">
                                            <input type="hidden" name="icon[]" value="ui_icon1">
                                            <p data-toggle="modal" data-target="" class="rewrte-icon icon-box" id="">暂无</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="m_t_10 bg_fff">
                    <thead>
                        <tr>
                            <td colspan="2">
                                <div class="f_r btn_e_d">
                                    <span class="color_C9DCF4 b_edit pointer">编辑</span>
                                    <span class="color_F5C9CB b_del pointer">删除</span>
                                </div>
                                <div>序号：1</div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div>
                                    <div>分组序号:</div>
                                    <div>
                                        <select disabled="disabled">
                                            <option>分组序号</option>
                                            <option>分组序号2</option>
                                            <option>分组序号3</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div>模块名称:</div>
                                    <div class="relative"><input type="" placeholder="10" value="10" disabled="disabled"></div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div>
                                    <div>模块链接:</div>
                                    <div class="relative"><input type="" placeholder="20" value="" disabled="disabled"></div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div id="display_img">图标样式:</div>
                                    <div class="relative">
                                        <div class="nav-icon rewrte select-nav">
                                            <input type="hidden" name="icon[]" value="ui_icon1">
                                            <p data-toggle="modal" data-target="" class="rewrte-icon icon-box" id="">暂无</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="m_t_10 bg_fff">
                    <thead>
                        <tr>
                            <td colspan="2">
                                <div class="f_r btn_e_d">
                                    <span class="color_C9DCF4 b_edit pointer">编辑</span>
                                    <span class="color_F5C9CB b_del pointer">删除</span>
                                </div>
                                <div>序号：1</div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div>
                                    <div>分组序号:</div>
                                    <div>
                                        <select disabled="disabled">
                                            <option>分组序号</option>
                                            <option>分组序号2</option>
                                            <option>分组序号3</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div>模块名称:</div>
                                    <div class="relative"><input type="" placeholder="10" value="10" disabled="disabled"></div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div>
                                    <div>模块链接:</div>
                                    <div class="relative"><input type="" placeholder="20" value="" disabled="disabled"></div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div id="display_img">图标样式:</div>
                                    <div class="relative">
                                        <div class="nav-icon rewrte select-nav">
                                            <input type="hidden" name="icon[]" value="ui_icon1">
                                            <p data-toggle="modal" data-target="" class="rewrte-icon icon-box" id="">暂无</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
<!-- <script src="<?php echo base_url(FD_PUBLIC);?>/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC).'/'.$tpl;?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC).'/'.$tpl;?>/plugins/datatables/dataTables.bootstrap.min.js"></script> -->
<script src="<?php echo base_url(FD_PUBLIC).'/'.$tpl;?>/plugins/datatables/layDate.js"></script>
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
<!--日历调用结束-->
<script>
$(function(){
  var This;
   var obj=null;
    $(document).on('click','.select-nav',function (e) {
        e.stopPropagation();
        obj = $(this);
    });
  $(document).on('click','.select-icon',function (e) {
        e.stopPropagation();
        var icon = $(this).data('icon');
        obj.find('p.icon-box').attr('class','rewrte-icon icon-box ui_'+icon).html('');
        obj.find("input[type='hidden']").val('ui_'+icon);
        $('button.close').click();
    });
  $('.b_edit').click(function(){
    if($(this).html()=='编辑'){
        $(this).html('保存')
        $('table input').removeAttr('disabled');
        $('table select').removeAttr('disabled');
        $(this).parents('table').find('.rewrte-icon').attr('data-target','#myModal2');
    }else{
        $(this).html('编辑')
        $(this).parents('table').find('.rewrte-icon').removeAttr('data-target','');
        $('table input').attr("disabled","disabled");
        $('table select').attr("disabled","disabled");
    }
    
  })

  $('.b_del').click(function(){
    This=$(this);
    $('.fixed_box').show();
  })
  $('.confirms').click(function(){
    This.parents('table').remove();
    $('.fixed_box').hide();
  })
  $('.cancel').click(function(){
    $('.fixed_box').hide();
  })
  var bool=true;
  var obj=null;
    $('.drow_list li').click(function(){
        $('#search_hotel').val($(this).text());
        $('#search_hotel_h').val($(this).val());
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
</script>
</body>
</html>