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
#coupons_table_length{display:block;}
#coupons_table_wrapper .row:first-child{background:#fff;padding:10px;}
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
          <div class="checkbox"><label><input type="checkbox" name="o_orderid" checked="">主单号</label></div>
          <div class="checkbox"><label><input type="checkbox" name="sub_orderid">子单号</label></div>
          <div class="checkbox"><label><input type="checkbox" name="web_orderid" checked="">pms单号</label></div>
          <div class="checkbox"><label><input type="checkbox" name="webs_orderid">pms子单号</label></div>
          <div class="checkbox"><label><input type="checkbox" name="order_time" checked="">下单时间</label></div>
          <div class="checkbox"><label><input type="checkbox" name="member_no">会员号</label></div>
          <div class="checkbox"><label><input type="checkbox" name="in_name" disabled="" checked="">订房人</label></div>
          <div class="checkbox"><label><input type="checkbox" name="in_tel">手机</label></div>
          <div class="checkbox"><label><input type="checkbox" name="in_hotel_name" disabled="" checked="">酒店</label></div>
          <div class="checkbox"><label><input type="checkbox" name="roomname" checked="">房型</label></div>
          <div class="checkbox"><label><input type="checkbox" name="price_code_name">价格代码</label></div>
          <div class="checkbox"><label><input type="checkbox" name="istart" disabled="" checked="">入住日期</label></div>
          <div class="checkbox"><label><input type="checkbox" name="iend" disabled="" checked="">离店日期</label></div>
          <div class="checkbox"><label><input type="checkbox" name="room_night" checked="">间夜</label></div>
          <div class="checkbox"><label><input type="checkbox" name="ori_price">下单价格</label></div>
          <div class="checkbox"><label><input type="checkbox" name="coupon_amount">用券金额</label></div>
          <div class="checkbox"><label><input type="checkbox" name="point_amount">积分使用量</label></div>
          <div class="checkbox"><label><input type="checkbox" name="balance_amount">储值支付金额</label></div>
          <div class="checkbox"><label><input type="checkbox" name="paytype">支付方式</label></div>
          <div class="checkbox"><label><input type="checkbox" name="iprice" checked="">实际价格</label></div>
          <div class="checkbox"><label><input type="checkbox" name="item_status" disabled="" checked="">状态</label></div>
          <div class="checkbox"><label><input type="checkbox" name="leavetime" checked="">操作离店时间</label></div>
          <div class="checkbox"><label><input type="checkbox" name="mt_pms_orderid">本地pms订单号</label></div>
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
               酒店子订单数据 
            </div>
            <div class="contents">
        <div class="head_cont contents_list bg_fff">
          <div class="j_head">
            <div class="w_307" >
                <span>公众号</span>
                <span><input class="w_200" type="text" /></span>
            </div>
          </div>
          <div class="j_head">
              <div class="510">
                <span>支付时间</span>
                <span class="t_time"><input name="start_t" type="text" id="datepicker" class="moba" value=""></span>
                  <font>至</font>
                  <span class="t_time"><input name="end_t" type="text" id="datepicker2" class="moba" value=""></span>
              </div>
          </div>
          <div  class="h_btn_list" style="">
            <div class="actives">筛选</div>
            <div>批量导出</div>
          </div>
        </div>
        <div class="box-body" style="width:100%;overflow-x:auto;">
          <div style="width:1680px;">
            <table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;margin-top:0px !important;">
              <thead class="bg_f8f9fb form_thead">
                <tr class="bg_f8f9fb form_title">
                  <th>订单编号</th>
                  <th>公众号ID</th>
                  <th>公众号名称</th>
                  <th>酒店名称</th>
                  <th>结算方式</th>
                  <th>下间时间</th>
                  <th>支付时间</th>
                  <th>小计总额</th>
                  <th>实际总额</th>
                  <th>实付总额</th>
                  <th>退款状态</th>
                  <th>消费状态</th>
                  <th>赠送状态</th>
                  <th>购买商品名称</th>
                  <th>购买人</th>
                  <th>状态</th>
                </tr>
              </thead>
              <tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
                <tr class="form_con">
                  <td>xw148775431012668</td>
                  <td>a452233816</td>
                  <td>啊啊啊啊啊啊</td>
                  <td>广州金房卡大酒店</td>
                  <td>不知道</td>
                  <td>
                      <span>2016.10.10</span><br>
                      <span>16:00:00</span>
                  </td>
                  <td>
                      <span>2016.10.10</span><br>
                      <span>16:00:00</span>
                  </td>
                  <td>2500</td>
                  <td>50000</td>
                  <td>4000</td>
                  <td>不知道</td>
                  <td>不知道</td>
                  <td class="order_number">不知道</td>
                  <td>青花瓶</td>
                  <td  class="order_number">黄二</td>
                  <td>不知道</td>
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
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "searching": false,
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
