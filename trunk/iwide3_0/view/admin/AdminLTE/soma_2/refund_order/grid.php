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
.color_E9858A{color:#E9858A;}
.color_B3CEF0{color:#B3CEF0;}
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
.classification{height:50px;line-height:50px;margin-bottom:18px;}
.classification >div{width:98px;display:inline-block;text-align:center;height:50px;}
.classification .add_active{border-bottom:3px solid #ff9900;}
.fomr_term{height:30px;line-height:30px;}
.classification >div,.all_open_order{cursor:pointer;}
.template >div{text-align:center;}
.template >div:nth-of-type(1){width:250px;text-align:left;padding-left:10px;}
.template_img{float:left;width:50px;height:50px;overflow:hidden;vertical-align:middle;margin-right:2%;}
.template_span{display:inline-block;margin-top:2px;}
.template_btn{padding:1px 8px;border-radius:3px;}
.temp_con >div >span{line-height:1.7;}
.room{width:52px;display:inline-block;}
.con_list > div:nth-child(odd){background:#fafcfb;}
.con_list{display:none;}

.drow_list{display:none;position:absolute;width:100%;top:100%;left:0;background:#fff;border:1px solid #e4e4e4;padding:0;overflow:auto;z-index:999}
.drow_list li{height:35px;padding-left:15px;line-height:35px;list-style:none; cursor:pointer}
.drow_list li:hover{background:#f1f1f1}
.drow_list li.cur{background:#ff9900;color:#fff}
#drowdown:hover .drow_list{display:block}
.fixed_box{position:fixed;top:36%;left:48%;z-index:9999;border:1px solid #d7e0f1;border-radius:5px;padding:1% 2%;display:none;}
.tile{font-size:15px;text-align:center;margin-bottom:4%;}
.f_b_con{font-size:13px;text-align:center;margin-bottom:8%;}
.pointer,.delivery,.confirms,.cancel{cursor:pointer;}
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
  $filter = $this->input->get(null, true);
  $base_page = array('page_num' => 1, 'page_size' => 5);
  $s_label = $model->get_status_label();
  // var_dump($filter);
?>

<div class="fixed_box bg_fff">
  <div class="tile">发票邮寄</div>
  <div class="f_b_con">
    <span>快递公司</span>
    <span>
      <select class="w_200 express">
        <option value="顺风快递">顺风快递</option>
        <option value="优速快寄">优速快寄</option>
      </select>
    </span>
  </div>
  <div class="f_b_con">
    <span>快递单号</span>
    <span><input class="w_200 order_number" type="text" value=""></span>
  </div>
  <div class="h_btn_list clearfix" style="">
    <div class="actives confirms">确认</div>
    <div class="cancel f_r">取消</div>
  </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;">
            <div class="banner bg_fff p_0_20">退款管理</div>
            <div class="contents">
              <div class="p_r_30 classification b_b_1 bg_fff">
                <div class="add_active"><a href="">已申请</a></div>
                <div class=""><a href="">已审核</a></div>
                <div class=""><a href="">已退款</a></div>
                <div class=""><a href="">取消</a></div>
                <div class=""><a href="">全部</a></div>
              </div>
              <form class="form" method='get' id="this_form" >
                <div class="head_cont contents_list bg_fff">
                  <div class="j_head clearfix">
                    <div  class="h_btn_list" style="">
                      <div class="actives" id='subbtn'>导出</div>
                    </div>
                    <div class="f_r f_r_con">
                      <div>
                        <input type="text" placeholder="搜索">
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <div class="" style="font-size:13px;">
                <div class="bg_f8f9fb table fomr_term template">
                  <div>酒店&商品</div>
                  <div>原始&实付金额</div>
                  <div>所属业务</div>
                  <div>退款理由</div>
                  <div>申请时间</div>
                  <div>退款状态</div>
                  <div>操作</div>
                </div> 
              </div>
              <?php foreach($result['data'] as $row): ?>
                <?php 
                  $refund = $row['new_info'];
                  $order = $refund['order_info'];
                ?>
              <div class="border_1 m_t_10 bg_fff">
                <div class="bg_f8f9fb fomr_term p_0_30_0_10 b_b_1">
                  <a href="<?php echo Soma_const_url::inst()->get_url('*/*/edit', array('ids' => $refund['refund_id'])); ?>" class="f_r color_F99E12">退款申请详情</a>
                  <div>订单号：<?php echo $refund['order_id']; ?></div>
                </div>
                <div class="table temp_con template p_t_10 p_b_10">
                  <div class="clearfix">
                    <img class="template_img" src="<?php echo $order['items'][0]['face_img']; ?>">
                    <span class="template_span"><?php echo $order['hotel_name']; ?></span><br>
                    <span><?php echo $order['items'][0]['name']; ?></span>
                  </div>
                  <div>
                    <span><?php echo $order['subtotal']; ?></span><br>
                    <span><?php echo $order['grand_total']; ?></span>
                  </div>
                  <div>
                    <span><?php if($refund['business'] == 'package'): ?> 套票 <?php endif; ?></span><br>
                    <span></span>
                  </div>
                  <div>
                    <span><?php echo $refund['refund_cause']; ?></span><br>
                    <span></span>
                  </div>
                  <div>
                    <?php $r_time_arr = explode(' ', $refund['create_time']); ?>
                    <span><?php echo $r_time_arr[0]; ?></span><br>
                    <span><?php echo $r_time_arr[1]; ?></span>
                  </div>
                  <div>
                    <?php $s_label = $model->get_status_label(); ?>
                    <span class="refuse_con"><?php echo isset($s_label[$refund['status']]) ? $s_label[$refund['status']] : '未知状态'; ?></span><br>
                    <span class="color_ff9900 delivery"></span>
                  </div>
                  <div class="f_times">
                    <span class="color_B3CEF0 pointer agre_and_r">同意并退款</span><br>
                    <span class="color_B3CEF0 pointer agre" style="margin-right:20px;">仅同意</span>
                    <span class="color_E9858A pointer refuse">拒绝</span>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
              <!--
              <div class="border_1 m_t_10 bg_fff">
                <div class="bg_f8f9fb fomr_term p_0_30_0_10 b_b_1">
                  <a href="" class="f_r color_F99E12">订单详情</a>
                  <div>订单号：1000068808</div>
                </div>
                <div class="table temp_con template p_t_10 p_b_10">
                  <div class="clearfix">
                    <img class="template_img" src="http://file.iwide.cn/public/uploads/201512/yibohotel_304-3.jpg">
                    <span class="template_span">信息驿站集团大酒店</span><br>
                    <span>杭州西溪花间堂客房通用券</span>
                  </div>
                  <div>
                    <span>689.00</span><br>
                    <span>288.52</span>
                  </div>
                  <div>
                    <span>套票</span><br>
                    <span></span>
                  </div>
                  <div>
                    <span>没时间消费</span><br>
                    <span></span>
                  </div>
                  <div>
                    <span>2016.09.02</span><br>
                    <span>16:12:02</span>
                  </div>
                  <div>
                    <span>已退款</span><br>
                    <span class="color_ff9900 delivery"></span>
                  </div>
                  <div class="f_times">
                    <span class="color_B3CEF0 pointer">--</span><br>
                    <span class="color_B3CEF0 pointer" style="margin-right:20px;"></span>
                    <span class="color_E9858A pointer"></span>
                  </div>
                </div>
                -->
                <!-- 分页代码开始 -->
                
                <div class="pages">
                <div id="Pagination">
                  <div class="pagination">
                    <?php
                      // 每页显示5条数据
                      $page_size = $base_page['page_size'];
                      // 总页数
                      $total_page = ceil($result['total'] / $page_size);
                      // 当前页，从get参数获取
                      $current_page = isset($filter['page_num']) ? intval($filter['page_num']) : $base_page['page_num'];
                      if($current_page <= 0) { $current_page = $base_page['page_num']; }

                      // 当前链接
                      $params = $filter;
                      unset($params['page_num']);
                      unset($params['page_size']);
                      unset($params['filter']);

                      if(isset($filter['filter'])
                        && is_array($filter['filter'])) {
                        foreach ($filter['filter'] as $k => $v) {
                          $key = 'filter[' . $k . ']';
                          $params[$key] = $v;
                        }
                      }

                      $current_url = Soma_const_url::inst()->get_url('*/*/*', $params);
                      if(strpos($current_url, "?") === false) {
                        $current_url .= '?';
                      } else {
                        $current_url .= '&';
                      }

                      // 第一页链接
                      $first_page = $current_url . 'page_num=' . 1 . '&page_size=' . $page_size;

                      $pre_page = $pre_two_page = $nxt_page = $nxt_two_page = null;
                      // 上两页链接
                      if(($current_page - 1) > 1) {
                        $pre_two_page = $current_url . 'page_num=' . ($current_page - 2) . '&page_size=' . $page_size;
                      }
                      // 上一页链接
                      if($current_page > 1) {
                        $pre_page = $current_url . 'page_num=' . ($current_page - 1) . '&page_size=' . $page_size;
                      }
                      // 下一页链接
                      if($current_page < $total_page) {
                        $nxt_page = $current_url . 'page_num=' . ($current_page + 1) . '&page_size=' . $page_size;
                      }
                      // 下两页页链接
                      if(($current_page + 1) < $total_page) {
                        $nxt_two_page = $current_url . 'page_num=' . ($current_page + 2) . '&page_size=' . $page_size;
                      }
                      // 最后一页链接
                      $last_page = $current_url . 'page_num=' . $total_page . '&page_size=' . $page_size;

                    ?>
                    
                    <?php if($current_page > 1): ?>
                      <a href="<?php echo $pre_page; ?>">&lt;</a>
                    <?php endif; ?>
                    <?php if($current_page > 3): ?>
                      <a href="<?php echo $first_page; ?>">1</a>
                      <a>...</a>
                    <?php endif; ?>
                    <?php if($pre_two_page != null): ?>
                      <a href="<?php echo $pre_two_page; ?>"><?php echo intval($current_page - 2); ?></a>
                    <?php endif; ?>
                    <?php if($pre_page != null): ?>
                      <a href="<?php echo $pre_page; ?>"><?php echo intval($current_page - 1); ?></a>
                    <?php endif; ?>
                    <a class="number current" href="#"><?php echo intval($current_page); ?></a>
                    <?php if($nxt_page != null): ?>
                      <a href="<?php echo $nxt_page; ?>"><?php echo intval($current_page + 1); ?></a>
                    <?php endif; ?>
                    <?php if($nxt_two_page != null): ?>
                      <a href="<?php echo $nxt_two_page; ?>"><?php echo intval($current_page + 2); ?></a>
                    <?php endif; ?>
                    <?php if(($current_page + 2) < $total_page): ?>
                      <a>...</a>
                      <a href="<?php echo $last_page; ?>"><?php echo intval($total_page); ?></a>
                    <?php endif; ?>
                    <?php if($current_page < $total_page): ?>
                      <a href="<?php echo $nxt_page; ?>">&gt;</a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- 分页代码结束 -->
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
<!--日历调用结束-->
<script>
$(function(){
  $('.agre_and_r').click(function(){
      $('.refuse_con').html('已退款');
      hide_text()
  })
  $('.agre').click(function(){
      $('.refuse_con').html('已审核');
      hide_text()
  })
  $('.refuse').click(function(){
      $('.refuse_con').html('取消');
      hide_text()
  })
  function hide_text(){
    $('.agre_and_r').html('--');
    $('.agre').html('');
    $('.refuse').html('');
  }
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
</script>
</body>
</html>
