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
</head>
<style>
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
.classification_n{height:50px;line-height:50px;margin-bottom:18px;}
.classification_n >div{width:98px;display:inline-block;text-align:center;height:50px;}
.classification_n .add_active{border-bottom:3px solid #ff9900;}
.fomr_term{height:30px;line-height:30px;}
.classification_n >div,.all_open_order{cursor:pointer;}
.template >div{text-align:center;}
.template >div:nth-of-type(2){width:250px;text-align:left;padding-left:10px;}
.template_img{float:left;width:60px;height:60px;overflow:hidden;vertical-align:middle;margin-right:2%;}
.template_span{display:block;line-height:1.3 !important;overflow:hidden;text-overflow:ellipsis;display:-webkit-box; -webkit-box-orient:vertical;-webkit-line-clamp:2; }
.template_btn{padding:1px 8px;border-radius:3px;}
.temp_con{border-bottom:1px solid #d7e0f1;}
.temp_con:last-child{border-bottom:none;}
.temp_con >div >span{line-height:1.7;}
.room{width:52px;display:inline-block;}
.con_list > div:nth-child(odd){background:#fafcfb;}
.con_list{display:none;}
.frames_c{padding:2px 8px;margin-right:10px;border-radius:3px;}
.t_money{font-size:13px;}

</style>

<?php
  $filter = $this->input->get(null, true);
  $base_page = array('page_num' => 1, 'page_size' => 5);
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
            <div class="banner bg_fff p_0_20">拼团活动</div>
            <div class="contents">
              <?php $status = isset($filter['filter']['status']) ? $filter['filter']['status'] : -1; ?>
              <div class="p_r_30 classification_n b_b_1 bg_fff">
                <div <?php if($status == Soma_base::STATUS_TRUE): ?> class="add_active" <?php endif; ?>><a href="<?php echo Soma_const_url::inst()->get_url('*/*/*', $base_page) . '&filter[status]=' . Soma_base::STATUS_TRUE; ?>">有效拼团</a></div>
                <div <?php if($status == Soma_base::STATUS_FALSE): ?> class="add_active" <?php endif; ?>><a href="<?php echo Soma_const_url::inst()->get_url('*/*/*', $base_page) . '&filter[status]=' . Soma_base::STATUS_FALSE; ?>">无效拼团</a></div>
                <div <?php if($status == -1): ?> class="add_active" <?php endif; ?>><a href="<?php echo Soma_const_url::inst()->get_url('*/*/*', $base_page); ?>">全部拼团</a></div>
              </div>
              <form class="form" method='get' id="this_form" >
             <!--    <div class="head_cont contents_list bg_fff">
                  <div class="j_head clearfix">
                    <div  class="h_btn_list" style="">
                      <div class="actives" id='add_act_btn'>新增拼团</div>
                    </div>
                    <div class="f_r f_r_con">
                      <div>
                        <input type="text" placeholder="搜索">
                      </div>
                    </div>
                  </div>
                </div> -->

                <div class="head_cont contents_list bg_fff">
                  <div class="j_head">
                        <div>
                            <span>活动编号</span>
                            <span><input class="w_200" type="text"></span>
                        </div>
                        <div>
                            <span>商品名称</span>
                            <span><input class="w_200" type="text"></span>
                        </div>
                        
                        <div>
                          <span>申请时间</span>
                          <span class="t_time"><input name="start" type="text" id="datepicker" class="datepicker moba" value="<?php echo isset($filter['start']) ? $filter['start'] : ''; ?>"></span>
                          <font>至</font>
                          <span class="t_time"><input name="end" type="text" id="datepicker2" class="datepicker moba" value="<?php echo isset($filter['end']) ? $filter['end'] : ''; ?>"></span>
                        </div>
                       <!--  <div>
                            <span>配送商</span>
                            <span><input class="w_200" type="text"></span>
                        </div> -->
                  </div>
                  <div class="h_btn_list" style="">
                      <div id="search_btn" class="pointer actives">筛选</div>
                      <div class="" id='add_act_btn'>新增拼团</div>
                  </div>
                </div>
              </form>
              <div class="" style="font-size:13px;">
                <div class="bg_f8f9fb table fomr_term template">
                  <div>活动编号</div>
                  <div>商品&价格</div>
                  <div>活动名称</div>
                  <div>开始时间</div>
                  <div>结束时间</div>
                  <div>操作</div>
                </div>
              </div>
              <div class="border_1 bg_fff">
                <?php foreach ($result['data'] as $row): ?>

                <?php
                  $a_info = $row['new_info'];
                  $p_info = $a_info['product_info'];
                ?>

                <div class="table temp_con template p_t_10 p_b_10">
                  <div>
                    <span><?php echo $a_info['act_id']; ?></span><br>
                    <span></span>
                  </div>
                  <div class="clearfix">
                    <img class="template_img" src="<?php echo $p_info['face_img']; ?>">
                    <span class="template_span"><?php echo $p_info['name']; ?></span>
                    <p class="t_money" style="margin-top:4px;"><span class="frames_c bg_ff9900 color_fff"><?php echo ($a_info['status'] == Soma_base::STATUS_TRUE) ? '有效': '无效'; ?></span><font class="color_FFAF28">¥<?php echo $a_info['group_price']; ?></font></p>
                  </div>
                  <div>
                    <span><?php echo $a_info['act_name']; ?></span><br>
                    <span></span>
                  </div>
                  <div>
                    <?php $s_time_arr = explode(' ', $a_info['start_time'])?>
                    <span><?php echo $s_time_arr[0]; ?></span><br>
                    <span> <?php echo $s_time_arr[1]; ?></span>
                  </div>
                  <div>
                    <?php $e_time_arr = explode(' ', $a_info['end_time'])?>
                    <span><?php echo $e_time_arr[0]; ?></span><br>
                    <span> <?php echo $e_time_arr[1]; ?></span>
                  </div>
                  <div>
                    <a class="color_B3CEF0" href="<?php echo Soma_const_url::inst()->get_url('*/*/edit', array('ids' => $row['new_info']['act_id'])); ?>">编辑</a><br>
                    <span></span>
                  </div>
                </div>
                <?php endforeach; ?>
                <!--
                <div class="table temp_con template p_t_10 p_b_10">
                  <div>
                    <span>689123456</span><br>
                    <span></span>
                  </div>
                  <div class="clearfix">
                    <img class="template_img" src="http://file.iwide.cn/public/uploads/201512/yibohotel_304-3.jpg">
                    <span class="template_span">400g新疆原生态枸杞无华肥无农药无添加 农药无添加农药无添加农药无添加农药无添加</span>
                    <p class="t_money" style="margin-top:4px;"><span class="frames_c bg_7e8e9f color_fff">无效</span><font class="color_FFAF28">¥46.00</font></p>
                  </div>
                  <div>
                    <span>艰注册制艰注</span><br>
                    <span></span>
                  </div>
                  <div>
                    <span>2046.06.06 12:00:12</span><br>
                    <span></span>
                  </div>
                  <div>
                    <span>2046.06.06 12:00:12</span><br>
                    <span></span>
                  </div>
                  <div>
                    <a class="color_B3CEF0">编辑</a><br>
                    <span></span>
                  </div>
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
  var bool=true;
  var obj=null;
    $('.drow_list li').click(function(){
        $('#search_hotel').val($(this).text());
        $('#search_hotel_h').val($(this).val());
        $(this).addClass('cur').siblings().removeClass('cur');
    });
  $('.classification_n >div').click(function(){
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

$('#add_act_btn').click(function(){
  window.location.href = "<?php echo Soma_const_url::inst()->get_url('*/*/add'); ?>";
});


</script>
</body>
</html>
