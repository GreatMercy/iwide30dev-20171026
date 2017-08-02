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

<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/datepicker/css/bootstrap-datepicker.min.css">
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
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
a{color:#92a0ae;}

.border_1{border:1px solid #d7e0f1;}
.f_r{float:right;}
.p_0_20{padding:0 20px;}
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
#coupons_table_length{display:none;}

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

</style>
<?php
  // var_dump($data_set, $column_set);exit;
?>
<div class="fixed_box bg_fff">
  <div class="tile">订单修改确认</div>
  <div class="f_b_con">确认要将当前订单状态修改为“入住”状态？</div>
  <div class="h_btn_list clearfix" style="">
    <div class="actives confirms">确认</div>
    <div class="cancel f_r">取消</div>
  </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;">
            <div class="banner bg_fff p_0_20">商品数据</div>
            <div class="contents">
              <form action="<?php echo Soma_const_url::inst()->get_url('*/*/*' ); ?>" class="form" method='get' id="this_form" >
                <div class="head_cont contents_list bg_fff">
                  <div class="j_head clearfix">
                    <div class="f_r f_r_con">
                      <div>
                        <span>统计时间</span>
                        <span class="t_time"><input name="s_date" type="text" id="datepicker" class="datepicker moba" value="<?php echo $s_date; ?>"></span>
                        <font>至</font>
                        <span class="t_time"><input name="e_date" type="text" id="datepicker2" class="datepicker moba" value="<?php echo $e_date; ?>"></span>
                      </div>
                      <div id="search_btn" class="color_A4C4ED">筛选</div>
                    </div>
                  </div>
                </div>
              </form>
            <div class="box-body">
                <table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;">
                    <thead class="bg_f8f9fb form_thead">
                        <tr class="bg_f8f9fb form_title">
                        <?php foreach($column_set as $col): ?>
                          <th><?php echo $col['title']; ?></th>
                        <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
                      <?php foreach($data_set as $row): ?>
                        <tr class="form_con">
                        <?php foreach($row as $ceil): ?>
                          <td><?php echo $ceil; ?></td>
                        <?php endforeach; ?>
                        </tr>
                      <?php endforeach; ?>
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

$('#search_btn').click(function(){
  $('#this_form').submit();
});

$(function(){
var buttons=$('')
$('#coupons_table').DataTable({
        "aLengthMenu": [10,50,100,200],
        "iDisplayLength": 10,
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
$("#data-grid_length").children().append('&nbsp;&nbsp;&nbsp;').append( buttons );
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
