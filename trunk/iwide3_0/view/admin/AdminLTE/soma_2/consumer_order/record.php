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
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/new/huang.css">

<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/datepicker/css/bootstrap-datepicker.min.css">
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
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
.table{display:table;margin-bottom:0px;}
.table >div{display: table-cell;width:137px;}
.contents{padding:10px 0px 85px 20px;}
.contents_list{display:table;width:100%;border:1px solid #d7e0f1;margin-bottom:10px;}
.head_cont{padding:20px 0 20px 10px;}
.head_cont >div{margin-bottom:10px;cursor:pointer;}
.head_cont >div:last-child{margin-bottom:0px;}
.h_btn_list .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;}
.h_btn_list> div{display:inline-block;width:100px;border:1px solid #d7e0f1;text-align:center;padding:6px 0px;border-radius:5px;margin-right:8px;}
.h_btn_list> div:last-child{margin-right:0px;}
.f_r_con >div,.j_head >div{display:inline-block;}
.f_r_con >div{margin-right:10px;}
.form_con,.form_title{height:30px;line-height:30px;}
.form_con >td,.form_title >th{text-align:center;font-weight:normal;}
.box-body{padding:0px;overflow:hidden;}
.containers >tr:nth-child(even){background:#F8F8F8 !important;}
.containers >tr:nth-child(odd){background:#fff !important;}
#coupons_table_wrapper .row:nth-of-type(1){background:#fff;padding:5px 5px 0 5px;}
#coupons_table{margin-top:0px !important;}

.drow_list{display:none;position:absolute;width:100%;top:100%;left:0;background:#fff;border:1px solid #e4e4e4;padding:0;overflow:auto;z-index:999}
.drow_list li{height:35px;padding-left:15px;line-height:35px;list-style:none; cursor:pointer}
.drow_list li:hover{background:#f1f1f1}
.drow_list li.cur{background:#ff9900;color:#fff}
#drowdown:hover .drow_list{display:block}
.fixed_box{position:fixed;top:36%;left:48%;z-index:9999;border:1px solid #d7e0f1;border-radius:5px;padding:1% 2%;display:none;}
.tile{font-size:15px;text-align:center;margin-bottom:4%;}
.f_b_con{font-size:13px;text-align:center;margin-bottom:8%;}
.confirms,.cancel{cursor:pointer;}
.pagination{margin-top:0px;margin-bottom:0px;}
</style>
<div class="fixed_box bg_fff">
  <div class="tile">修改备注</div>
  <div class="f_b_con">
    <input class="order_number" name="remark" type="text" placeholder="请输入备注" style="width:250px;" />
    <input id="ItemId" name="iid" type="hidden" value="" style="width:250px;" />
  </div>
  <div class="h_btn_list clearfix" style="">
    <div class="actives confirms">确认</div>
    <div class="cancel f_r">取消</div>
  </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;">
            <div class="banner bg_fff p_0_20">核销记录</div>
            <div class="contents">
              <form class="form" method='get' id="this_form" >
                <div class="head_cont contents_list bg_fff">
                  <div class="j_head">
                  <!--   <div>
                      <span>酒店名称</span>
                      <span class="input-group w_200 select_input" style="position:relative;display:inline-flex;" id="drowdown">
                        <input placeholder="选择或输入关键字" type="text" style="color:#92a0ae;" class="form-control w_200 moba" id="search_hotel">
                        <ul class="drow_list silde_layer">
                              <li value="">碧桂园凤凰大酒店</li>
                              <li value="">北京金茂万丽酒店</li>
                              <li value="">上海街町酒店</li>
                              <li value="">深圳威尼斯酒店</li>
                              <li value="">街町酒店广州测试店</li>
                              <li value="">广州金房卡大酒店</li>
                        </ul>
                      </span>
                    </div> -->
                    <div>
                      <span>酒店名称</span>
                      <span>
                        <select  class="w_200" name="hotel_id" id="hotelId">
                          <?php if($hotelIds):?>
                            <option value="">所有酒店</option>
                            <?php foreach($hotelIds as $k=>$v):?>
                              <option value="<?php echo $k;?>" <?php if($hotel_id&&$hotel_id==$k)echo 'selected="selected"';?>><?php echo $v['name'];?></option>
                            <?php endforeach;?>
                          <?php endif;?>
                        </select>
                      </span>
                    </div>
                    <div>
                      <span>核销日期</span>
                      <span class="t_time"><input name="start_time" type="text" id="datepicker" class="datepicker moba" value="<?php if($start_time){echo $start_time;}?>"></span>
                      <font>至</font>
                      <span class="t_time"><input name="end_time" type="text" id="datepicker2" class="datepicker moba" value="<?php if($start_time){echo $end_time;}?>"></span>
                    </div>
                    <div>
                        <span>核销账号</span>
                        <span><input name="consumer" type="text" id="consumerName" class="datepicker moba w_200" value="<?php if($consumer){echo $consumer;}?>"></span>
                    </div>
                    <div>
                        <span>核销商品</span>
                        <span><input class="w_200" type="text"></span>
                    </div>
                    <div>
                        <span>备注</span>
                        <span><input class="w_200" type="text"></span>
                    </div>
                    <div>
                        <span>核销券码</span>
                        <span><input class="w_200" type="text"></span>
                    </div>
                  </div>
                  <div class="h_btn_list" style="">
                    <div class="actives" id="exportSearch">筛选</div>
                      <div class="" id='exportList'>导出</div>
                  </div>
                </div>
               <!--  <div class="head_cont contents_list bg_fff">
                  <div class="j_head clearfix">
                    <div  class="h_btn_list" style="">
                      <div class="actives" id='exportList'>导出</div>
                    </div>
                    <div class="f_r f_r_con">
                      <div>
                          <select  class="w_200" name="hotel_id" id="hotelId">
                            <?php if($hotelIds):?>
                              <option value="">所有酒店</option>
                              <?php foreach($hotelIds as $k=>$v):?>
                                <option value="<?php echo $k;?>" <?php if($hotel_id&&$hotel_id==$k)echo 'selected="selected"';?>><?php echo $v['name'];?></option>
                              <?php endforeach;?>
                            <?php endif;?>
                          </select>
                      </div>
                      <div>
                        <span>核销日期</span>
                        <span class="t_time"><input name="start_time" type="text" id="datepicker" class="datepicker moba" value="<?php if($start_time){echo $start_time;}?>"></span>
                        <font>至</font>
                        <span class="t_time"><input name="end_time" type="text" id="datepicker2" class="datepicker moba" value="<?php if($start_time){echo $end_time;}?>"></span>
                      </div>
                      <div>
                        <span>核销账号</span>
                        <input name="consumer" type="text" id="consumerName" class="datepicker moba" value="<?php if($consumer){echo $consumer;}?>">
                      </div>
                      <div class="color_A4C4ED" id="exportSearch">筛选</div>
                    </div>
                  </div>
                </div> -->
              </form>
            <div class="box-body">
                <table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;">
                    <thead class="bg_f8f9fb form_thead">
                        <tr class="bg_f8f9fb form_title">
                            <th>核销编号</th>
                            <th>核销券码</th>
                            <th>酒店名称</th>
                            <th>核销商品</th>
                            <th>核销价格</th>
                            <th>实付金额</th>
                            <th>订单编号</th>
                            <th>核销时间</th>
                            <th>核销方式</th>
                            <th>核销账号</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
                      <?php if($export_data): ?>
                      <?php foreach($export_data as $k=>$v): ?>
                        <tr class="form_con">
                            <td><?php echo $v['consumer_id'];?></td>
                            <td><?php echo $v['consumer_code'];?></td>
                            <td><?php echo $v['hotel_name'];?></td>
                            <td><?php echo $v['name'];?></td>
                            <td><?php echo $v['price_package'];?></td>
                            <td><?php echo $v['grand_total'];?></td>
                            <td><?php echo $v['order_id'];?></td>
                            <td><?php echo $v['consumer_time'];?></td>
                            <td><?php echo $v['consumer_method'];?></td>
                            <td><?php echo $v['consumer'];?></td>
                            <td class="remarks"><?php echo $v['remark'];?></td>
                            <td><a class="color_72afd2 modify" iid="<?php echo $v['item_id'];?>" remark_val="<?php echo $v['remark'];?>" href="javascript:;">修改备注</a></td>
                        </tr>
                        <?php endforeach;?>
                        <?php endif;?>
                        <!-- <tr class="form_con">
                            <td>167</td>
                            <td>dhsjd128</td>
                            <td>dures</td>
                            <td>020</td>
                            <td>1523</td>
                            <td>20</td>
                            <td>12</td>
                            <td>2945a</td>
                            <td>456</td>
                            <td class="remarks">改地址</td>
                            <td><a class="color_72afd2 modify" href="javascript:;">修改备注</a></td>
                        </tr>
                        <tr class="form_con">
                            <td>12367</td>
                            <td>dhsjd128</td>
                            <td>dures</td>
                            <td>020</td>
                            <td>1523</td>
                            <td>167</td>
                            <td>12</td>
                            <td>2945a</td>
                            <td>456</td>
                            <td class="remarks">改地址</td>
                            <td><a class="color_72afd2 modify" href="javascript:;">修改备注</a></td>
                        </tr>
                        <tr class="form_con">
                            <td>5667</td>
                            <td>dhsjd128</td>
                            <td>dures</td>
                            <td>020</td>
                            <td>1523</td>
                            <td>20</td>
                            <td>12</td>
                            <td>2945a</td>
                            <td>456</td>
                            <td class="remarks">改地址</td>
                            <td><a class="color_72afd2 modify" href="javascript:;">修改备注</a></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
              <div class="pages">
                <div id="Pagination">
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
<!--日历调用开始-->
<!-- <script src="<?php echo base_url(FD_PUBLIC);?>/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC).'/'.$tpl;?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC).'/'.$tpl;?>/plugins/datatables/dataTables.bootstrap.min.js"></script> -->
<script src="<?php echo base_url(FD_PUBLIC).'/'.$tpl;?>/plugins/datatables/layDate.js"></script>
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
  var $this;
  $('.modify').click(function(){
    var iid = $(this).attr('iid');
    var remark_val = $(this).attr('remark_val');
    $('#ItemId').val(iid);
    $('.order_number').val(remark_val);
    $this=$(this);
    $('.fixed_box').show();
  })
  $('.confirms').click(function(){
      if($('.order_number').val()!=''){
        var str=$('.order_number').val();
        var iid=$('#ItemId').val();
        $this.parent().parent().find('.remarks').html(str);
        $('.fixed_box').hide();
        $('.order_number').val('');
        $.ajax({
          url: "<?php echo Soma_const_url::inst()->get_url('soma_2/consumer_order/remark_post'); ?>",
          data: {remark:str,iid:iid,ajax:<?php echo Soma_base::STATUS_TRUE;?>,'<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>'},
          type: "post",
          success:function(msg){
            window.location.reload();
          }
        });
      }else{
        alert('请填写备注内容');
      }
  })
  $('.cancel').click(function(){
      $('.fixed_box').hide();
  })
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
// $("#data-grid_length").children().append('&nbsp;&nbsp;&nbsp;').append( buttons );
$("#data-grid_length").children().append('&nbsp;&nbsp;&nbsp;').append();
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

  //搜索
  $("#exportSearch").click(function(){
    var url = '<?php echo current_url();?>';
    var go_url= '?batch=export&start=' + $("#datepicker").val()+'&end=' + $("#datepicker2").val() +'&hotel_id=' + $('#hotelId').val()+'&consumer=' + $('#consumerName').val();
    window.location= url+ go_url;
  });

  // 导出
  $("#exportList").click(function(){
    var url = '<?php echo Soma_const_url::inst()->get_url('soma_2/consumer_order/export_list');?>';
    var go_url= '?start_time=' + $("#datepicker").val()+'&end_time=' + $("#datepicker2").val() + '&hotel_id=' + $("#el_consumer_type").val() +'&hotel_id=' + $('#hotelId').val()+'&consumer=' + $('#consumerName').val();
    window.location= url+ go_url;
  });

})
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
function slidesub(id){
  chose="[name='"+'weborder'+id+"']";
  if($(chose).css("display")=='table-row'){
    $(chose).css("display",'none');
  }
  else{
    $(chose).css("display",'table-row');
  }
}
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
<!--改变订单状态-->
function change_status(obj){
  var sid = $(obj).attr('sid');
  var orderid = $(obj).attr('oid');
  var item_id = '';
  if($(obj).attr('iid')){
    item_id = $(obj).attr('iid')
  }
  if(orderid){
    $.get('<?php echo site_url('hotel_2/orders/update_order_status');?>',{
      oid:orderid,
      status:sid,
      item_id:item_id
    },function(data){
      $('.fixed_box').fadeOut();
      if(data==1){
        alert('修改成功');
        location.reload();
      }else{
        alert('修改失败');
      }
    });
  }
}
</script>
</body>
</html>
