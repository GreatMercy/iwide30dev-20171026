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


</style>
<!-- <div class="modal fade" id="setModal">
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
    </div>
  </div>
</div> -->
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
               订单状态查询(非统计) 
            </div>
            <div class="contents">
        <div class="head_cont contents_list bg_fff">
          <div class="j_head">
            <div class="w_307">
              <span>酒店名称</span>
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
            <div class="w_307" >
                <span>订单号</span>
                <span><input class="w_200" type="text" /></span>
            </div>
            <div class="w_307" >
                <span>房型名称</span>
                <span><input class="w_200" type="text" /></span>
            </div>
            <div class="w_307" >
                <span>入住人姓名</span>
                <span><input class="w_200" type="text" /></span>
            </div>
            <div class="w_307" >
                <span>手机号码</span>
                <span><input class="w_200" type="text" /></span>
            </div>
          </div>

        <div class="j_head">
            <div class="510">
              <span style="width:90px;">
                <select class="w_90" name="paystatus">
                    <option value="-1">下单时间</option>
                    <option value="0">入住时间</option>
                    <option value="1">离店时间</option>
                    <option value="2">在店时间</option>
                </select>
              </span>
              <span class="t_time"><input name="start_t" type="text" id="datepicker" class="moba" value=""></span>
                <font>至</font>
                <span class="t_time"><input name="end_t" type="text" id="datepicker2" class="moba" value=""></span>
            </div>
        </div>
        <div class="j_head">
            <div class="w_255">
                <span>支付方式</span>
                <span>
                    <select class="w_90" name="paystatus">
                        <option value="">所有</option>
                        <option value="balance">储值支付</option>
                        <option value="bonus">积分支付</option>
                        <option value="daofu">到店支付</option>
                        <option value="lakala">拉卡拉支付</option>
                        <option value="lakala_y">拉卡拉支付(银行卡)</option>
                        <option value="package">套票预订</option>
                        <option value="point">积分支付</option>
                        <option value="unionpay">银联支付</option>
                        <option value="weifutong">威富通支付</option>
                        <option value="weixin">微信支付</option>  
                    </select>
                </span>
            </div>
            <div class="w_255">
                <span>支付状态</span>
                <span>
                    <select class="w_90" name="pay_status">
                      <option value="">所有</option>
                      <option value="0">门店支付</option>
                      <option value="1">已支付</option> 
                    </select>
                </span>
            </div>
            <div class="w_255">
                <span>订单状态</span>
                <span>
                    <select class="w_90" name="status">
                      <option value="">所有</option>
                      <option value="0">待确认</option>
                      <option value="1">已确认</option>
                      <option value="10">下单失败</option>
                      <option value="11">系统取消</option>
                      <option value="2">已入住</option>
                      <option value="3">已离店</option>
                      <option value="4">用户取消</option>
                      <option value="5">酒店取消</option>
                      <option value="6">酒店删除</option>
                      <option value="7">异常</option>
                      <option value="8">未到</option>
                      <option value="9">未支付</option>  
                    </select>
                </span>
            </div>
        </div>
          <div  class="h_btn_list" style="">
            <div class="actives">筛选</div>
            <div>批量导出</div>
          </div>
        </div>
        <div class="box-body" style="width:100%;overflow-x:auto;">
          <div style="width:1680px;">
            <table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;">
              <thead class="bg_f8f9fb form_thead">
                <tr class="bg_f8f9fb form_title">
                  <th>ID</th>
                  <th>入住人</th>
                  <th>电话</th>
                  <th>房间数</th>
                  <th>原价</th>
                  <th>总价</th>
                  <th>订单号</th>
                  <th>PMS订单号</th>
                  <th>支付方式</th>
                  <th>支付状态</th>
                  <th>酒店名</th>
                  <th>房型</th>
                  <th>入住时间</th>
                  <th>离店时间</th>
                  <th>状态</th>
                  <th>下单时间</th>
                  <th>优惠券金额</th>
                  <th>优惠券张数</th>
                </tr>
              </thead>
              <tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
                <tr class="form_con">
                  <td>1228565</td>
                  <td>黄二小</td>
                  <td>13801222220</td>
                  <td>1</td>
                  <td>0.01</td>
                  <td>0.01</td>
                  <td>dY148821174057716</td>
                  <td></td>
                  <td>套票预订</td>
                  <td>已支付</td>
                  <td>信息驿站酒店(演示)</td>
                  <td>高级大床房</td>
                  <td>2016.10.10</td>
                  <td>2016.10.10</td>
                  <td>已确认</td>
                  <td>
                      <span>2016.10.10</span><br>
                      <span>16:00:00</span>
                  </td>
                  <td>0.00</td>
                  <td>1</td>
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
