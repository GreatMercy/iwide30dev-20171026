<!-- DataTables -->
<link rel="stylesheet"
  href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->

<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/datepicker/css/bootstrap-datepicker.min.css">
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/new/huang.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
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
#coupons_table_wrapper .row:nth-of-type(2){overflow-x:auto;}
#coupons_table_wrapper .row:nth-of-type(2) > div{width:1820px;}
</style>
<div class="modal fade" id="setModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">显示设置</h4>
      </div>
      <div class="modal-body">
        <div id='cfg_items'>
        <form action="" id="setting_form" method="post" accept-charset="utf-8">
          <div class="checkbox"><label><input type="checkbox" name="hotel_name" disabled="" checked="">酒店名</label></div>
          <div class="checkbox"><label><input type="checkbox" name="total_order_count" disabled="" checked="">主订单总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="balance_pay_order_count">储值支付订单总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="weixin_pay_order_count" checked="">微信支付订单总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="daofu_pay_order_count" checked="">到店支付订单总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="bp_order_count" checked="">积分支付订单总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="coupon_used_order_count">使用优惠券订单总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="total_room_night" disabled="" checked="">间夜数量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="balance_pay_room_night">储值支付间夜总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="weixin_pay_room_night" checked="">微信支付间夜总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="daofu_pay_room_night" checked="">到店支付间夜总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="bp_pay_room_night" checked="">积分支付间夜总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="coupon_used_room_night">使用优惠券间夜总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="balance_pay_order_money">储值支付总额</label></div>
          <div class="checkbox"><label><input type="checkbox" name="weixin_pay_order_money">微信支付总额</label></div>
          <div class="checkbox"><label><input type="checkbox" name="daofu_pay_order_money">到店支付总额</label></div>
          <div class="checkbox"><label><input type="checkbox" name="total_order_money" disabled="" checked="">销售总额</label></div>
          <div class="checkbox"><label><input type="checkbox" name="total_coupon_used_money" checked="">使用优惠券总额</label></div>
          <div class="checkbox"><label><input type="checkbox" name="total_bonus_amount" checked="">使用积分总量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="total_money_sort" checked="">销售额排名</label></div>
          <div class="checkbox"><label><input type="checkbox" name="sub_order_count" checked="">子订单总量</label></div>
        </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="set_btn_save">保存</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="fixed_box bg_fff w_330">
  <div class="tile"></div>
  <div class="f_b_con">
    退款确认:订单12346579确认退款后自动将订单实际支付退还给用户且不可撤回！
  </div>
  <div class="h_btn_list clearfix" style="">
    <div class="actives confirms">保存</div>
    <div class="cancel f_r">取消</div>
  </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1340px;" >
            <div class="banner bg_fff p_0_20">
               各店订单数据
            </div>
            <div class="contents">
        <div class="head_cont contents_list bg_fff">
          <div class="j_head">
            <div class="w_307 ">
              <span>订单酒店</span>
              <span class="input-group w_200 select_input" style="position:relative;display:inline-flex;" id="drowdown">
                <input placeholder="选择或输入关键字" type="text" style="color:#92a0ae;" class="form-control w_200 moba" id="search_hotel" >
                <ul class="drow_list silde_layer">
                      <li value="">碧桂园凤凰大酒店</li>
                      <li value="">北京金茂万丽酒店</li>
                      <li value="">上海街町酒店</li>
                      <li value="">深圳威尼斯酒店</li>
                      <li value="">街町酒店广州测试店</li>
                      <li value="">广州金房卡大酒店</li>
                </ul>
              </span>
            </div>
          </div>
          <div class="j_head">
            <div class="510">
              <span>入住时间</span>
              <span class="t_time"><input name="start_t" type="text" id="datepicker" class="moba" value=""></span>
                <font>至</font>
                <span class="t_time"><input name="end_t" type="text" id="datepicker2" class="moba" value=""></span>
            </div>
            <div class="510">
              <span>离店时间</span>
              <span class="t_time"><input name="start_t1" type="text" id="datepicker3" class="moba" value=""></span>
                <font>至</font>
                <span class="t_time"><input name="end_t1" type="text" id="datepicker4" class="moba" value=""></span>
            </div>
            <div class="510">
              <span>下单时间</span>
              <span class="t_time"><input name="start_t2" type="text" id="datepicker5" class="moba" value=""></span>
                <font>00:00 至</font>
                <span class="t_time"><input name="end_t3" type="text" id="datepicker6" class="moba" value="">23:59</span>
            </div>
            
          </div>
          <div  class="h_btn_list" style="">
            <div class="actives">筛选</div>
            <div class="" id="grid-btn-set" data-toggle="modal" data-target="#setModal">设置</div>
            <div>批量导出</div>
          </div>
        </div>
        <div class="box-body" style="width:100%;">
          <div style="">
            <table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;color:#7e8e9f;font-size:14px;">
              <thead class="bg_f8f9fb form_thead">
                <tr class="bg_f8f9fb form_title">
                  <th>酒店名</th>
                  <th>主订单总量</th>
                  <th>微信支付订单总量</th>
                  <th>到店支付订单总量</th>
                  <th>积分支付订单总量</th>
                  <th>间夜数量</th>
                  <th>微信支付间夜总量</th>
                  <th>到店支付间夜总量</th>
                  <th>积分支付间夜总量</th>
                  <th>销售总额</th>
                  <th>使用优惠券总额</th>
                  <th>使用积分总量</th>
                  <th>销售额排名</th>
                  <th>子订单总量</th>
                </tr>
              </thead>
              <tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
                <tr class="form_con">
                  <td>信息驿站酒店(演示)</td>
                  <td>165</td>
                  <td>16</td>
                  <td>142</td>
                  <td></td>
                  <td>87</td>
                  <td>26</td>
                  <td>238</td>
                  <td class="order_number">17</td>
                  <td>5120.12</td>
                  <td  class="order_number">0</td>
                  <td>42</td>
                  <td  class="order_number">1</td>
                  <td  class="order_number">213</td>
                </tr>
              </tbody>
            </table>
          </div>
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
  laydate({
     elem: '#datepicker3'
  })
  laydate({
     elem: '#datepicker4'
  })
  laydate({
     elem: '#datepicker5'
  })
  laydate({
     elem: '#datepicker6'
  })
}();
</script>
<script>
$(function(){
  $('.drow_list li').click(function(){
        $('#search_hotel').val($(this).text());
        $(this).addClass('cur').siblings().removeClass('cur');
  });
  $('.select_input input').bind('input propertychange',function(){
    var _this = $(this).parent().find('li');
    var val = $(this).val();
    if(val==''){
      _this.show();
    }else{
      _this.each(function(){
        if($(this).html().indexOf(val)>=0){
          $(this).show()
        }else{
          $(this).hide();
        }
      });
    }
  });

// $('#grid-btn-set').click(function(){
// $('#setModal').on('show.bs.modal', function (event) {
// //    modal.find('.modal-body input').val(recipient)
//   var str = '<input type="hidden" name="<?php echo $this->security->get_csrf_token_name ();?>" value="<?php echo $this->security->get_csrf_hash ();?>" style="display:none;">';
//   $.getJSON('<?php echo site_url("hotel/hotel_report/get_cofigs?ctyp=ORDERS_BY_ROOMNIGHT")?>',function(data){
//     $.each(data,function(k,v){
//       str += '<div class="checkbox"><label><input type="checkbox" name="' + k + '"';
//       if(v.must == 1){
//         str += ' disabled checked ';
//       }else if(v.choose == 1){
//         str += ' checked ';
//       }
//       str += '>' + v.name + '</label></div>';
//     });
//     $('#setting_form').html(str);
//   });

// })});
  $('#coupons_table').DataTable({
        "aLengthMenu": [8,50,100,200],
      "iDisplayLength": 8,
      "bProcessing": true,
      "paging": true,
      "lengthChange": true,
      "ordering": false,
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
  var This;
  $('.adjustment').click(function(){
    This=$(this);
    if(This.html()=='退款'){
        $('.fixed_box').show();
        var str=This.parents('tr').find('.order_number').html();
        $('.f_b_con').html('退款确认:订单'+str+'确认退款后自动将订单实际支付退还给用户且不可撤回！');
    }
    
  })

  $('.confirms').click(function(){
    $('.fixed_box').hide();
    This.html('已退款');
    This.removeClass('color_F99E12').addClass('color_9b9b9b');
  })
  $('.cancel').click(function(){
    $('.fixed_box').hide();
  })


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
