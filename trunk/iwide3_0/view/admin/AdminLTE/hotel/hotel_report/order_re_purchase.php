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
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/new/huang.css">
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/highcharts.js"></script>
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
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1240px;" >
            <div class="banner bg_fff p_0_20">
               酒店复购率统计 
            </div>
            <div class="contents">
        <div class="head_cont contents_list bg_fff">
          <div class="j_head">
            <div class="w_307 ">
              <span>酒店</span>
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
            <div class="510">
              <span style="width:105px;">
                <select id='time_type' name='time_type' class="form-control input-sm">
                    <option value="1">下单时间</option>
                    <option value="2">入住时间</option>
                    <option value="3">离店时间</option>
                  </select>
              </span>
              <span class="t_time"><input name="month_start" type="text" id="datepicker" class="moba" value=""></span>
                <font> 至</font>
                <span class="t_time"><input name="month_end" type="text" id="datepicker2" class="moba" value=""></span>
            </div>
          </div>
          <div  class="h_btn_list" style="">
            <div class="actives" id="grid-btn-search">筛选</div>
            <div id="export" type="button"/>导出</div>
          </div>
        </div>
<!--         <div class="box-body" style="">
          <div style="">
            <table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;">
              <thead class="bg_f8f9fb form_thead">
                <tr class="bg_f8f9fb form_title">
                  <th>公众号</th>
                  <th>主单号</th>
                  <th>pms单号</th>
                  <th>下单时间</th>
                  <th>订房人</th>
                  <th>酒店</th>
                  <th>房型</th>
                  <th>入住日期</th>
                  <th>离店日期</th>
                  <th>间夜</th>
                  <th>下单价格</th>
                  <th>用券金额</th>
                  <th>实际价格</th>
                  <th>状态</th>
                  <th>操作离店时间</th>
                </tr>
              </thead>
              <tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
                <tr class="form_con">
                  <td>a452233816</td>
                  <td>xw148775431012668</td>
                  <td></td>
                  <td>
                      <span>2016.10.10</span><br>
                      <span>16:00:00</span>
                  </td>
                  <td>测试浩</td>
                  <td>信息驿站酒店(演示)</td>
                  <td>行政大床房</td>
                  <td>2016.10.10</td>
                  <td>2016.10.10</td>
                  <td class="order_number">2</td>
                  <td>100.00</td>
                  <td>0.00</td>
                  <td>100.00</td>
                  <td  class="order_number">已离店</td>
                  <td>
                    <span>2016.10.10</span><br>
                    <span>16:00:00</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div> -->
        <div class="bg_fff">
          <div id="purchase-total"></div>
                <!-- end-->
          <table id="data-grid" class="table table-bordered table-striped table-condensed">
            <thead>
                <tr role="row">
                  <th width="10%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="2" colspan="1" aria-label="年份: activate to sort column ascending" style="text-align: center;">年份</th>
                  <th width="10%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="2" colspan="1" aria-label="月份: activate to sort column ascending" style="text-align: center;">月份</th>
                  <th width="40%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="5" aria-label="" style="text-align: center;">
                   累计用户数
                  </th>
                  <th width="40%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="5" aria-label="" style="text-align: center;">
                  累计订单数</th>
                </tr>
                <tr role="row">
                  <th width="8%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="1" aria-label="总用户数: activate to sort column ascending" style="text-align: center;">累计总用户数</th>
                  <th width="8%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="1" aria-label="购买二次: activate to sort column ascending" style="text-align: center;">购买二次<br>累计数量/复购率</th>
                  <th width="8%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="1" aria-label="购买三次: activate to sort column ascending" style="text-align: center;">购买三次<br>累计数量/复购率</th>
                  <th width="8%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="1" aria-label="购买五次: activate to sort column ascending" style="text-align: center;">购买五次<br>累计数量/复购率</th>
                  <th width="8%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="1" aria-label="购买十次: activate to sort column ascending" style="text-align: center;">购买十次<br>累计数量/复购率</th>
                  <th width="8%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="1" aria-label="总订单数: activate to sort column ascending" style="text-align: center;">累计总订单数</th>
                  <th width="8%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="1" aria-label="二次订单: activate to sort column ascending" style="text-align: center;">二次订单<br>累计数量/复购率</th>
                  <th width="8%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="1" aria-label="三次订单: activate to sort column ascending" style="text-align: center;">三次订单<br>累计数量/复购率</th>
                  <th width="8%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="1" aria-label="五次订单: activate to sort column ascending" style="text-align: center;">五次订单<br>累计数量/复购率</th>
                  <th width="8%" class="sorting" tabindex="0" aria-controls="data-grid" rowspan="1" colspan="1" aria-label="十次订单: activate to sort column ascending" style="text-align: center;">十次订单<br>累计数量/复购率</th>
                </tr>
            <tfoot></tfoot>
            <tbody id="res" style="text-align: center;">
            
            </tbody>
          </table>
        </div>
      </div>
        </div>
    </div>
    <div class="loading" style="position:fixed; top:45%; text-align:center; z-index:9999999; width:100%;display: none;">
      <span style="padding:10px 20px; border:1px solid #e4e4e4; background:#fff;">数据正在加载..</span>
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
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/layDate.js"></script>
<!--日历调用结束-->
<script>
;!function(){
  laydate({
     elem: '#datepicker',
     format: 'YYYY-MM'
  })
  laydate({
     elem: '#datepicker2',
     format: 'YYYY-MM'
  })
}();
</script>
<script>

var search_index=0;
var hid='';
function quick_search() {
  var hk=$('#qhs').val();
  if(hk){
    $('#search_tip').html('');
    options=$('#hotel option');
    search_index=0;
    $.each(options,function(i,n){
      $(n).css('color','#555');
      $(n).removeAttr('be_search');
      if(n.innerHTML.indexOf(hk)>-1){
        search_index++;
        $(n).css('color','red');
        $(n).attr('be_search',search_index);
        if(search_index==1){
          n.selected=true;
          hid=n.value;
          //h_jump(n.value);
        }
      }
    });
    if(search_index==0){
      $('#search_tip').html('无结果');
    }
  }
}; 
function go_hotel(direction){
  selected_option=$('#hotel').find('option:selected');
  selected_option=selected_option[0];
  now_index=$(selected_option).attr('be_search');
  if(now_index){
    search_index=now_index;
  }
  if(search_index){
    if(direction=='next'){
      search_index++;
    }else{
      search_index--;
    }
  }
  if(search_index){
    option=$('#hotel>option[be_search="'+search_index+'"]');
    if(option[0]!=undefined){
      option=option[0];
      option.selected=true;
      hid=option.value;
    }
  }
}


var buttons = $('<div class="btn-group"></div>');

var grid_sort= [[ , "" ]];

<?php /* 有更多的按钮，URL在此定义，与上面button顺序匹配 */ ?>
var url_extra= [
//'http://iwide.cn/',
];

$(".form_datetime").datepicker({
  format: 'yyyymm', 
  startDate:new Date(2013,12,01),
  endDate:'+1',//结束时间，在这时间之后都不可选
  weekStart: 1, 
  autoclose: true,
  startView: 2, 
  maxViewMode: 1,
  minViewMode:1,
  forceParse: false, 
  language: 'zh-CN',
});
$('#set_btn_save').click(function(){
  $.post('<?php echo site_url("hotel/hotel_report/save_cofigs?ctyp=ORDERS_BY_ROOMNIGHT")?>',$("#setting_form").serialize(),function(data){
    if(data == 'success'){
      window.location.reload();
    }else{
      alert('保存失败');
    }
  });
});
$(document).ready(function() {
$('#export').click(function(){
  var hotel_id = $('#hotel').val();
  var time_type = $('#time_type').val();
  var month_start = $("input[name='month_start']").val().replace(/-/g,"");
  var month_end = $("input[name='month_end']").val().replace(/-/g,"");
  if(!hotel_id || hotel_id=='undefined'){
    hotel_id = '';
  }
  if(!month_start || !month_end){
    alert('请选择日期');
    return false;
  }
  if(month_start>=month_end){
    alert('结束月份要大于开始月份');
    return false;
  }
  $('.loading').show();
  location.href='<?php echo site_url("hotel/hotel_report/ext_re_purchase").'?'?>'+'hotel_id='+hotel_id+'&time_type='+time_type+'&month_start='+month_start+'&month_end='+month_end;
  $('.loading').hide();
});
$('#grid-btn-search').click(function(){
  var hotel_id = $('#hotel').val();
  var time_type = $('#time_type').val();
  var month_start = $("input[name='month_start']").val().replace(/-/g,"");
  var month_end = $("input[name='month_end']").val().replace(/-/g,"");
  if(!month_start || !month_end){
    alert('请选择日期');
    return false;
  }
  if(month_start>=month_end){
    alert('结束月份要大于开始月份');
    return false;
  }
  $('.loading').show();
  $.get('<?php echo site_url("hotel/hotel_report/ajax_get_re_purchase")?>',
    {
      'hotel_id':hotel_id,
      'time_type':time_type,
      'month_start':month_start,
      'month_end':month_end
    },function(data){
      // console.log(data);
      $('.loading').hide();
      data = JSON.parse(data);
      var categories = [];//横坐标
      var usercounts = [];//用户数
      var two = [];//二次复购率
      var three = [];//三次复购率
      var five = [];//五次复购率
      var ten = [];//十次复购率
      var html = '';//表格信息

      for(x in data){
        categories.push(data[x]['date']);
        usercounts.push(parseInt(data[x]['user_count']));
        two.push(data[x]['u2']);
        three.push(data[x]['u3']);
        five.push(data[x]['u5']);
        ten.push(data[x]['u10']);
        html +='<tr><td>'+data[x]['date'].substr(0,4)+'</td>';//年份
        html +='<td>'+data[x]['date'].substr(4,2)+'</td>';//月份
        html +='<td>'+parseInt(data[x]['user_count'])+'</td>';//用户数
        html +='<td>'+data[x]['count2']+"&nbsp;&nbsp;|&nbsp;&nbsp;"+data[x]['u2']+'%'+'</td>';
        html +='<td>'+data[x]['count3']+"&nbsp;&nbsp;|&nbsp;&nbsp;"+data[x]['u3']+'%'+'</td>';
        html +='<td>'+data[x]['count5']+"&nbsp;&nbsp;|&nbsp;&nbsp;"+data[x]['u5']+'%'+'</td>';
        html +='<td>'+data[x]['count10']+"&nbsp;&nbsp;|&nbsp;&nbsp;"+data[x]['u10']+'%'+'</td>';
        html +='<td>'+parseInt(data[x]['order_count'])+'</td>';//订单数
        html +='<td>'+data[x]['allcount2']+"&nbsp;&nbsp;|&nbsp;&nbsp;"+data[x]['o2']+'%'+'</td>';
        html +='<td>'+data[x]['allcount3']+"&nbsp;&nbsp;|&nbsp;&nbsp;"+data[x]['o3']+'%'+'</td>';
        html +='<td>'+data[x]['allcount5']+"&nbsp;&nbsp;|&nbsp;&nbsp;"+data[x]['o5']+'%'+'</td>';
        html +='<td>'+data[x]['allcount10']+"&nbsp;&nbsp;|&nbsp;&nbsp;"+data[x]['o10']+'%'+'</td></tr>';
      }
      $('#res').html(html);
      // console.log(usercounts);
      // console.log(two);
      // console.log(three);
      // console.log(five);
      // console.log(ten);
      $('#purchase-total').highcharts({ //订单总额
          chart: {
                      zoomType: 'xy'
                  },
                  title: {
                      text: '酒店复购率统计 '
                  },
                  subtitle: {
                      text: '用户复购率=单位时间内：购买两次及以上的用户数/有购买行为的总用户数<br>订单复购率=单位时间内：第二次及以上购买的订单个数/总订单数'
                  },
                  xAxis: [{
                      categories: categories,
                      crosshair: true
                  }],
                  yAxis: [{ // Primary yAxis
                      labels: {
                          format: '{value}人',
                          style: {
                              color: Highcharts.getOptions().colors[2]
                          }
                      },
                      allowDecimals:false,
                      title: {
                          text: '用户数',
                          style: {
                              color: Highcharts.getOptions().colors[2]
                          }
                      },
                      opposite: true
                  }, { // Secondary yAxis
                      gridLineWidth: 0,
                      title: {
                          text: '复购率',
                          style: {
                              color: Highcharts.getOptions().colors[0]
                          }
                      },
                      labels: {
                          format: '{value} %',
                          style: {
                              color: Highcharts.getOptions().colors[0]
                          }
                      }
                  }],
                  tooltip: {
                      shared: true
                  },
                  legend: {
                      layout: 'vertical',
                      align: 'left',
                      x: 80,
                      verticalAlign: 'top',
                      y: 55,
                      floating: true,
                      backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                  },
                  series: [{
                      name: '用户数',
                      type: 'column',
                      yAxis: 0,
                      data: usercounts,
                      tooltip: {
                          valueSuffix: ' 人'
                      }
                  },{
                      name: '二次复购率',
                      type: 'spline',
                      yAxis: 1,
                      data: two,
                      tooltip: {
                          valueSuffix: ' %'
                    }
                  },{
                      name: '三次复购率',
                      type: 'spline',
                      yAxis: 1,
                      data: three,
                      tooltip: {
                          valueSuffix: ' %'
                    }
                  },{
                      name: '五次复购率',
                      type: 'spline',
                      yAxis: 1,
                      data: five,
                      tooltip: {
                          valueSuffix: ' %'
                    }
                  },{
                      name: '十次复购率',
                      type: 'spline',
                      yAxis: 1,
                      data: ten,
                      tooltip: {
                          valueSuffix: ' %'
                      }
                  }]
      });

  });
});
});
</script>
</body>
</html>
