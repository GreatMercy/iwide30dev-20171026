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
.color_main{color:#ff9900;}

a{color:#92a0ae;}
.relative{position:relative;}
.absolute{position:absolute;}
.center{text-align:center;}
.flex{display:flex;align-items:center;}
.h24{font-size:24px;font-family:arial;}

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

.contents{padding:20px 20px 20px;}
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
#notify_center_num >i.pointer,.delivery,.confirms,.cancel{cursor:pointer;}
.pagination{margin-top:0px;margin-bottom:0px;}
.btn_list_r span{margin-right:10px;}
.btn_list_r span:last-child{margin-right:0px;}
.f_b_con i{right:8px;top:1px;font-style:normal;}
</style>
<div class="fixed_box bg_fff">
  <div class="tile">积分余额调整</div>
  <div class="f_b_con">
    <span>会员ID：</span>
    <span>1234567898</span>
  </div>
  <div class="f_b_con">
    <span>会员卡号：</span>
    <span>jkf12365789</span>
  </div>
  <div class="f_b_con">
    <span>会员姓名：</span>
    <span>王二小</span>
  </div>
  <div class="f_b_con">
    <span>余额调整：</span>
    <span class="relative"><input class="balance" type="text" placeholder="" /><i class="absolute">元</i></span>
  </div>
  <div class="f_b_con">
    <span>积分调整：</span>
    <span class="relative"><input class="integral" type="text" placeholder="积分"  /><i class="absolute">积分</i></span>
  </div>
  <div class="f_b_con clearfix">
    <span class="f_l">调整备注：</span>
    <span><textarea></textarea></span>
  </div>
  <div class="h_btn_list clearfix" style="">
    <div class="actives confirms">保存</div>
    <div class="cancel f_r">取消</div>
  </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1450px;" >
            <div class="banner bg_fff p_0_20">领取情况</div>
            <div class="contents">
                <div class="flex bd bg_fff center" style="justify-content:space-between;padding:8px 20px;">
                    <div>
                        <div class="color_main h24">203520</div>
                        <div class="color_999">总领取数量</div>
                    </div>
                    <div>
                        <div class="color_main h24">123459</div>
                        <div class="color_999">已使用数量</div>
                    </div>
                    <div>
                        <div class="color_main h24">123456</div>
                        <div class="color_999">已过期数量</div>
                    </div>
                    <div>
                        <div class="color_main h24">1234568</div>
                        <div class="color_999">已核销数量</div>
                    </div>
                    <div>
                        <div class="color_main h24">78653</div>
                        <div class="color_999">分享已转赠数量</div>
                    </div>
                </div>
                <div class="box-body" style="margin-top: 18px;">
                  <table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;">
                    <thead class="bg_f8f9fb form_thead">
                      <tr class="bg_f8f9fb form_title">
                        <th>会员ID</th>
                        <th>会员卡号</th>
                        <th>会员昵称</th>
                        <th>会员名称</th>
                        <th>卡券名称</th>
                        <th>领取来源</th>
                        <th>领取时间</th>
                        <th>失效时间</th>
                        <th>是否过期</th>
                        <th>优惠券状态</th>
                        <th>使用场景</th>
                        <th>使用时间</th>
                        <th>核销场景</th>
                        <th>核销时间</th>
                        <th>使用范围</th>
                        <th>使用/核销备注</th>
                      </tr>
                    </thead>
                    <tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
                      <tr class=" form_con">
                        <td>131244</td>
                        <td>1234564</td>
                        <td>小李</td>
                        <td>微信会员</td>
                        <td>没什么哦</td>
                        <td>赠送来</td>
                        <td>
                            <span>2017-02-0</span><br>
                            <span>14:00:00</span>
                        </td>
                        <td>
                            <span>2017-02-0</span><br>
                            <span>14:00:00</span>
                        </td>
                        <td class="balance_t">否</td>
                        <td class="integral_t">可用</td>
                        <td>什么字段</td>
                        <td>
                            <span>2017-02-0</span><br>
                            <span>14:00:00</span>
                        </td>
                        <td>什么字段</td>
                        <td>
                            <span>2017-02-0</span><br>
                            <span>14:00:00</span>
                        </td>
                        <td>不知道</td>
                        <td>12346我我</td>
                      </tr>
                    </tbody>
                  </table>
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
</div>
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

  //   var This;
  // $('.adjustment').click(function(){
  //   This=$(this);
  //   $('.fixed_box').show();
  // })

  // $('.confirms').click(function(){
  //   if($('.balance').val()!=0||$('.balance').val()!=''){
  //      var numbers=Number(This.parents('.form_con').find('.balance_t').html())+Number($('.balance').val());
  //      This.parents('.form_con').find('.balance_t').html(numbers);
  //   }
  //   if($('.integral').val()!=0||$('.integral').val()!=''){
  //      var numbers=Number(This.parents('.form_con').find('.integral_t').html())+Number($('.integral').val());
  //      This.parents('.form_con').find('.integral_t').html(numbers);
  //   }
  //   $('.fixed_box').hide();
  //   $('.balance,.integral').val('');
  // })
  // $('.cancel').click(function(){
  //   $('.fixed_box').hide();
  // })
  $('.drow_list li').click(function(){
        $('#search_hotel').val($(this).text());
        $(this).addClass('cur').siblings().removeClass('cur');
    });
  var odiv=$('<div class="h_btn_list" style=""><div class="actives" id="subbtn">导出</div></div>');
  $('#coupons_table').DataTable({
        "aLengthMenu": [8,50,100,200],
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
