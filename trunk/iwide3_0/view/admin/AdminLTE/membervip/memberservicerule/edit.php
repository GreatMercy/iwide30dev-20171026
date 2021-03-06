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
#coupons_table_wrapper >.row:first-child{background:#fff;padding:10px;}
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
        <div class="content-wrapper" style="min-width:1230px;" >
            <div class="banner bg_fff p_0_20">
                优惠规则
            </div>
            <div class="contents">
                <div class="box-body" style="margin-top: 18px;">
                  <table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;">
                    <thead class="bg_f8f9fb form_thead">
                      <tr class="bg_f8f9fb form_title">
                        <th>规则ID</th>
                        <th>规则名称</th>
                        <th>领取渠道</th>
                        <th>领取次数</th>
                        <th>礼包名称</th>
                        <th>礼包说明</th>
                        <th>礼包类型</th>
                        <th>礼包库存</th>
                        <th>创建时间</th>
                        <th>规则状态</th>
                        <th>操作</th>
                      </tr>
                    </thead>
                    <tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
                      <tr class=" form_con">
                        <td>131244</td>
                        <td>测试默认领取</td>
                        <td>完善资料领取</td>
                        <td>234</td>
                        <td>新春抢新折上折</td>
                        <td>折扣券说明</td>
                        <td>折扣券</td>
                        <td>250</td>
                        <td>
                            <span>2017-02-0</span><br>
                            <span>14:00:00</span>
                        </td>
                        <td class="color_ff9900">已激活</td>
                        <td class="color_F99E12"><a href="javascript:;">编辑</a></td>
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
  var odiv=$('<div class="h_btn_list" style=""><div class="actives pointer" id="subbtn">新增规则</div></div>');
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
