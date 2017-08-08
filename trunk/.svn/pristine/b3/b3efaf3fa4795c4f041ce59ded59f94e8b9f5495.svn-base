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

<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/datepicker/css/bootstrap-datepicker.min.css">
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
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
.bg_f8f9fb{background:#f8f9fb;}
.bg_fe6464{background:#fe6464;}
.bg_eee{background:#EEEEEE}
.color_72afd2{color:#72afd2;}
.color_ff9900{color:#ff9900;}
.color_F99E12{color:#F99E12;}
a{color:#92a0ae;}
.relative{position:relative;}
.absolute{position:absolute;}

.border_1{border:1px solid #d7e0f1;}
.f_r{float:right;}
.f_l{float:left;}
.p_0_20{padding:0 20px;}
.w_90{width:90px;}
.w_200{width:200px;}
.p_r_30{padding-right:30px;}
.m_t_10{margin-top:10px;}
.p_0_30_0_10{padding:0 30px 0 10px;}
.b_b_1{border-bottom:1px solid #d7e0f1;}
.b_t_1{border-top:1px solid #d7e0f1;}
.p_t_10{padding-top:10px;}
.p_b_10{padding-bottom:10px;}



.input_checkbox >div >input{display:none;}
.input_checkbox >div label,.input_checkbox >div >input+label{font-weight:normal;text-indent:50px;background:url(http://test008.iwide.cn/public/js/img/bg.png) no-repeat center left;background-size:15%;width:110px;height:30px;line-height:30px;}
.input_checkbox >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/bg2.png) no-repeat center left;background-size:15%;}
.banner{height:50px;width:100%;line-height:50px;border-bottom:1px solid #d7e0f1;padding-right:0px;}
.banner > span{padding:0px 5px;margin-left:5px;border-radius:3px;font-size:11px;}
.news{position:relative;cursor:pointer;background:#fe8f00;height:100%;padding:0px 12px;color:#fff;}
.news_radius{padding:0 2px;border-radius:3px;background:#fff;color:#fe8f00;text-align:center;font-size:8px;margin-left:8px;}
.display_flex{display:flex;display:-webkit-flex;display:box;display:-webkit-box;justify-content:top;align-items:center;-webkit-align-items:center;}
.display_flex >th,.display_flex >td,.display_flex >div{-webkit-flex:1;flex:1;-webkit-box-flex:1;box-flex:1;cursor:pointer;}
.j_toshow{width:320px;min-height:100%;position:absolute;top:50px;right:-330px;box-shadow:-5px 0px 15px rgba(0,0,0,0.1);-webkit-box-shadow:-5px 0px 15px rgba(0,0,0,0.1);z-index:9999;}
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

.contents{padding:20px 0 20px 20px;}
.contents_list{display:table;width:100%;border-bottom:1px solid #d7e0f1;margin-bottom:10px;}
.head_cont{padding:20px 0 20px 10px;}
.head_cont >div{margin-bottom:10px;cursor:pointer;}
.head_cont >div:last-child{margin-bottom:0px;}
.j_head >div{display:inline-block;}
.j_head >div:nth-of-type(1){width:307px;}
.j_head >div:nth-of-type(2){width:432px;}
.j_head >div:nth-of-type(3){width:255px;}
.j_head >div >span:nth-of-type(1){display:inline-block;width:60px;text-align:center;}
.h_btn_list .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;}
.h_btn_list> div{display:inline-block;width:100px;border:1px solid #d7e0f1;text-align:center;padding:6px 0px;border-radius:5px;margin-right:8px;}
.h_btn_list> div:last-child{margin-right:0px;}
.classification{height:30px;line-height:30px;border-top:1px solid #d7e0f1;border-right:1px solid #d7e0f1;border-left:1px solid #d7e0f1;width:300px;}
.classification >div{text-align:center;height:30px;border-right:1px solid #d7e0f1;}
.classification >div:last-child{border-right:none;}
.classification .add_active{background:#ecf0f5;border-bottom:1px solid #ecf0f5;}
.fomr_term{height:30px;line-height:30px;}
.classification >div,.all_open_order{cursor:pointer;}
.all_open_order{margin-right:10px;margin-top:5px;}
.template >div{text-align:center;}
.template_img{float:left;width:50px;height:50px;overflow:hidden;vertical-align:middle;margin-right:2%;}
.template_span{display:inline-block;margin-top:2px;}
.template_btn{padding:1px 8px;border-radius:3px;}
.form_con,.form_title{height:30px;line-height:30px;}
.form_con >td,.form_title >th{text-align:center;font-weight:normal;}
.form_con >td:nth-of-type(1) >img{display:inline-block;width:48px;height:48px;border-radius:50%;border:1px solid #d7e0f1;overflow:hidden;}
.form_thead >tr,.containers >tr{padding:8px 0;}
.form_title >th:nth-of-type(2),.form_con >td:nth-of-type(2){flex:1.5;}
.form_title >th:nth-of-type(7),.form_con >td:nth-of-type(7){flex:2.9;}
.form_title >th:nth-of-type(6),.form_con >td:nth-of-type(6){flex:2.9;}
.containers >tr:nth-child(even){background:#F8F8F8 !important;}
.containers >tr:nth-child(odd){background:#fff !important;}
.form_con >td{padding-right:20px !important;}
.box-body{padding:0px;overflow:hidden;}
#coupons_table_length{display:none;}

.drow_list{display:none;position:absolute;width:100%;top:100%;left:0;background:#fff;border:1px solid #e4e4e4;padding:0;overflow:auto;z-index:999}
.drow_list li{height:35px;padding-left:15px;line-height:35px;list-style:none; cursor:pointer}
.drow_list li:hover{background:#f1f1f1}
.drow_list li.cur{background:#ff9900;color:#fff}
#drowdown:hover .drow_list{display:block}
#selects_membeb{display:inline-block;width:auto;vertical-align:middle;margin-right:25px;}
#coupons_table_wrapper >.row:first-child{background:#fff;padding:10px;}
.fixed_box{position:fixed;top:30%;left:48%;z-index:9999;border:1px solid #d7e0f1;border-radius:5px;padding:1% 2%;display:none;}
.tile{font-size:15px;text-align:center;margin-bottom:4%;}
.f_b_con{font-size:13px;margin-bottom:8%;}
.f_b_con span:first-child{display:inline-block;width:80px;text-align:right;margin-right:5px;}
.pointer,.delivery,.confirms,.cancel{cursor:pointer;}
.pagination{margin-top:0px;margin-bottom:0px;}
.btn_list_r span{margin-right:10px;}
.btn_list_r span:last-child{margin-right:0px;}
.f_b_con i{right:8px;top:1px;font-style:normal;}
.all_btn::after{content:"" !important;}
label{margin-bottom: 0px;font-weight:normal;}
</style>
<div class="fixed_box bg_fff">
  <div class="tile"></div>
  <div class="f_b_con" style="text-align:center;">
    审核通过了个0会员。
  </div>
  <div class="h_btn_list clearfix" style="">
    <div class="actives confirms">确定</div>
    <div class="cancel f_r">取消</div>
  </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1480px;" >
            <div class="banner bg_fff p_0_20">
                <div class="f_r news"><i class="iconfont" style="font-size:22px;vertical-align:middle;margin-right:5px;">&#xe623;</i>消息<span class="news_radius bg_ff0000">8</span></div>
                业主/员工
            </div>
            <div class="contents">
                <div class="box-body" style="margin-top: 18px;">
                  <table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;">
                    <thead class="bg_f8f9fb form_thead">
                      <tr class="bg_f8f9fb form_title">
                        <th class="all_btn"><span style="margin-right:35px;">全选</span>会员ID</th>
                        <th>酒店ID</th>
                        <th>昵称</th>
                        <th>会员名称</th>
                        <th>性别</th>
                        <th>会员卡编号</th>
                        <th>手机号</th>
                        <th>会员等级</th>
                        <th>积分</th>
                        <th>储值</th>
                        <th>是否冻结</th>
                        <th>是否登录</th>
                        <th>业主/员工</th>
                        <th>公司名称</th>
                        <th>员工号</th>
                        <th>注册时间</th>
                        <th>是否审核</th>
                      </tr>
                    </thead>
                    <tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
                      <tr class=" form_con">
                        <td class="input_checkbox">
                            <div class="btn_input">
                              <input type="checkbox" id="wf" name="" value="星期一">
                              <label for="wf">2123132</label>
                            </div>
                        </td>
                        <td>323232</td>
                        <td>我是谁</td>
                        <td>粉丝会员</td>
                        <td>男</td>
                        <td>JKF90987986890789</td>
                        <td>135426325633</td>
                        <td class="balance_t">黑卡会员</td>
                        <td class="integral_t">0</td>
                        <td>20</td>
                        <td>否</td>
                        <td>是</td>
                        <td>黄小妹</td>
                        <td>碧桂园</td>
                        <td>12035</td>
                        <td>
                            <span>2017-02-0</span><br>
                            <span>14:00:00</span>
                        </td>
                        <td class="color_F99E12 to_examine">审核中</td>
                      </tr>
                      <tr class=" form_con">
                        <td class="input_checkbox">
                            <div class="btn_input">
                              <input type="checkbox" id="wff" name="" value="星期二">
                              <label for="wff">2123132</label>
                            </div>
                        </td>
                        <td>323232</td>
                        <td>我是谁</td>
                        <td>粉丝会员</td>
                        <td>男</td>
                        <td>JKF90987986890789</td>
                        <td>135426325633</td>
                        <td class="balance_t">黑卡会员</td>
                        <td class="integral_t">0</td>
                        <td>20</td>
                        <td>否</td>
                        <td>是</td>
                        <td>黄小妹</td>
                        <td>碧桂园</td>
                        <td>12035</td>
                        <td>
                            <span>2017-02-0</span><br>
                            <span>14:00:00</span>
                        </td>
                        <td class="color_F99E12 to_examine">审核中</td>
                      </tr>
                      <tr class=" form_con">
                        <td class="input_checkbox">
                            <div class="btn_input">
                              <input type="checkbox" id="ff" name="" value="星期三">
                              <label for="ff">2123132</label>
                            </div>
                        </td>
                        <td>323232</td>
                        <td>我是谁</td>
                        <td>粉丝会员</td>
                        <td>男</td>
                        <td>JKF90987986890789</td>
                        <td>135426325633</td>
                        <td class="balance_t">黑卡会员</td>
                        <td class="integral_t">0</td>
                        <td>20</td>
                        <td>否</td>
                        <td>是</td>
                        <td>黄小妹</td>
                        <td>碧桂园</td>
                        <td>12035</td>
                        <td>
                            <span>2017-02-0</span><br>
                            <span>14:00:00</span>
                        </td>
                        <td class="color_F99E12 to_examine">审核中</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
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
  var odiv=$('<div class="h_btn_list" style=""><div class="actives" id="subbtn">通过</div><div class="" id="subbtn2">不通过</div></div>');
  $('#coupons_table').DataTable({
        "aLengthMenu": [8,50,100,200],
        "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0 ] }],
      "iDisplayLength": 8,
      "bProcessing": true,
      "paging": true,
      "lengthChange": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "searching": true,
      "language": {
        "sSearch": "搜索",
        "lengthMenu": "每页显示 _MENU_ 条记录",
        "zeroRecords": "找不到任何记录. ",
        "info": "",
        //"info": "当前显示第_PAGE_ / _PAGES_页，记录从 _START_ 到 _END_ ，共 _TOTAL_ 条",
        "infoEmpty": "",
        "infoFiltered": "(从 _MAX_ 条记录中过滤)",
        "paginate": {
          "sNext": "下一页",
          "sPrevious": "上一页",
        }
      }
  });
  $("#coupons_table_length").parent().append( odiv );

  $(".all_btn").click(function(){
    if($('.btn_input >input:checked').val()){
      $('.btn_input >input').prop('checked','false');
    }else{
      $('.btn_input >input').prop('checked','ture');
    }
  })
  $('.row').delegate('#subbtn','click',function(){
    if($('.btn_input >input:checked').val()){
      $('.fixed_box').show();
      $('.f_b_con').html('审核通过了个'+$('.btn_input >input:checked').length+'会员。');
      var This_txt=$('.btn_input >input:checked').parents('.form_con');
      det_btn(This_txt,'color_72afd2','通过');
    }
  });
  $('.row').delegate('#subbtn2','click',function(){
    if($('.btn_input >input:checked').val()){
      $('.fixed_box').show();
      $('.f_b_con').html('审核不通过了个'+$('.btn_input >input:checked').length+'会员。');
      var This_txt=$('.btn_input >input:checked').parents('.form_con');
      det_btn(This_txt,'color_ff9900','不通过')
    }
  });
  function det_btn(obj,colo,txt){
    $('.confirms').click(function(){
          check_to_tx(obj,colo,txt)
          $('.fixed_box').hide();
      });
      $('.cancel').click(function(){
          $('.fixed_box').hide();
      })
  }
  function check_to_tx(obj,colo,txt){
      obj.find('input').remove();
      obj.find('.to_examine').html(txt);
      obj.find('.to_examine').removeClass('color_F99E12');
      obj.find('.to_examine').addClass('color_ff9900');
      obj.find('label').css({backgroundImage: 'url()'});

  }
  $('.classification >div').click(function(){
    $(this).addClass('add_active').siblings().removeClass('add_active');
  })
  $('.news').click(function(){
      $('.j_toshow').animate({"right":"0px"},800);
  });
  $('.close_btn').click(function(){
      $('.j_toshow').animate({"right":"-330px"},800);
  });
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
</script>
</body>
</html>
