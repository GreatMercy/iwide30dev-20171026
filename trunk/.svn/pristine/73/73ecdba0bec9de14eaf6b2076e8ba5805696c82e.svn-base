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
<script src="http://test008.iwide.cn/public/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script><link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/new/huang.css">
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
.input_checkbox >div >input{display:none;}
.input_checkbox >div label,.input_checkbox >div >input+label{font-weight:normal;text-indent:50px;background:url(http://test008.iwide.cn/public/js/img/bg.png) no-repeat center left;background-size:15%;width:110px;height:30px;line-height:30px;}
.input_checkbox >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/bg2.png) no-repeat center left;background-size:15%;}
#coupons_table_wrapper >.row:first-child{background:#fff;padding:10px;}
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
