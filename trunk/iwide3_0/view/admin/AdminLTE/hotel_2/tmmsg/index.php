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
  src: url('http://test008.iwide.cn/public/newfont/iconfont.eot');
  src: url('http://test008.iwide.cn/public/newfont/iconfont.eot?#iefix') format('embedded-opentype'),
  url('http://test008.iwide.cn/public/newfont/iconfont.woff') format('woff'),
  url('http://test008.iwide.cn/public/newfont/iconfont.ttf') format('truetype'),
  url('http://test008.iwide.cn/public/newfont/iconfont.svg#iconfont') format('svg');
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
.bg_f8f9fb{background:#f8f9fb;}
.bg_fe6464{background:#fe6464;}
.bg_eee{background:#EEEEEE}
.color_72afd2{color:#72afd2;}
.color_ff9900{color:#ff9900;}
.color_F99E12{color:#F99E12;}
.color_2d87e2{color:#2d87e2;}
.relative{position:relative;}
.absolute{position:absolute;}
a{color:#92a0ae;}

.border_1{border:1px solid #d7e0f1;}
.b_b_1{border-bottom:1px solid #d7e0f1;}
.b_r_1{border-right:1px solid #d7e0f1;}
.f_r{float:right;}
.p_0_20{padding:0 20px;}
.w_90{width:90px;}
.w_200{width:200px;}
.w_220{width:220px;}
.p_r_30{padding-right:30px;}
.m_t_10{margin-top:10px;}
.p_0_30_0_10{padding:0 30px 0 10px;}
.b_b_1{border-bottom:1px solid #d7e0f1;}
.b_t_1{border-top:1px solid #d7e0f1;}
.p_t_10{padding-top:10px;}
.p_b_10{padding-bottom:10px;}
.p_10_27{padding:10px 27px;}

.banner{height:50px;width:100%;line-height:50px;border-bottom:1px solid #d7e0f1;padding-right:0px;}
.banner > span{padding:0px 5px;margin-left:5px;border-radius:3px;font-size:11px;}
.news{position:relative;cursor:pointer;background:#fe8f00;height:100%;padding:0px 12px;color:#fff;}
.news_radius{padding:0 2px;border-radius:3px;background:#fff;color:#fe8f00;text-align:center;font-size:8px;margin-left:8px;}
.display_flex{display:flex;display:-webkit-flex;display:box;display:-webkit-box;justify-content:top;align-items:center;-webkit-align-items:center;}
.display_flex >th,.display_flex >td,.display_flex >div{-webkit-flex:1;flex:1;-webkit-box-flex:1;box-flex:1;cursor:pointer;}
.j_toshow{width:320px;min-height:100%;position:absolute;top:50px;right:-330px;box-shadow:-5px 0px 15px rgba(0,0,0,0.1);-webkit-box-shadow:-5px 0px 15px rgba(0,0,0,0.1);z-index:555;}
.toshow_con{padding:12px;}
.t_con_list{margin-bottom:12px;height:170px;}
.close_btn{cursor:pointer;}
.toshow_con_titl{background:#f0f3f6;font-size:13px;padding:10px;border-bottom:1px solid #d7e0f1;}
.toshow_con_list{padding:10px;font-size:11px;height:114px;overflow:hidden;}
.toshow_con_list >a{display:block;margin-bottom:5px;}
.toshow_con_list >a:last-child{margin-bottom:0px;}
.toshow_titl_txt{position:relative;}
.radius_txt{position:absolute;top:0px;left:105%;border-radius:3px;text-align:center;padding:0px 3px;font-size:12px;}
select,input,.moba{height:30px;line-height:30px;border:1px solid #d7e0f1;text-indent:3px;}

.contents{padding:10px 0px 20px 20px;}
.contents_list{display:table;width:100%;margin-bottom:10px;}
.head_cont{padding:14px 16px 14px 16px;}
.head_cont >div{margin-bottom:10px;cursor:pointer;}
.head_cont >div:last-child{margin-bottom:0px;}
.head_cont .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;}
.h_btn_list> a{display:inline-block;width:118px;border:1px solid #d7e0f1;text-align:center;padding:4px 0px;border-radius:5px;margin-right:8px;}
.h_btn_list> a:last-child{margin-right:0px;}
.j_head >div{display:inline-block;}
.form_con,.form_title,.h_30{height:30px;line-height:30px;}
.search_btn{top:-5px;right:0px;padding:0 10px;}
.news_con{}
.row_con,.n_title{display:table;width:100%;}
.row_con >div,.n_title >div{display:table-cell;}
.n_title >div{width:33.33%;}
.n_title >div:nth-of-type(2){text-align:center;}
.n_title >div:nth-of-type(3){text-align:right;}
.n_title >div:nth-of-type(3) a{margin-right:15px;}
.row_con{border-bottom:1px solid #d7e0f1;}
.row_con:last-child{border-bottom:0px solid #d7e0f1;}
.row_con >div{width:50%;border-right:1px solid #d7e0f1;padding:10px 27px;}
.row_con >div:last-child{border-right:0px solid #d7e0f1;}


.h_btn_lists .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;}
.h_btn_lists> div{display:inline-block;width:100px;border:1px solid #d7e0f1;text-align:center;padding:6px 0px;border-radius:5px;margin-right:8px;}
.h_btn_lists> div:last-child{margin-right:0px;}
.fixed_box{position:fixed;top:36%;left:48%;z-index:9999;border:1px solid #d7e0f1;border-radius:5px;padding:1% 2%;display:none;}
.tile{font-size:15px;text-align:center;margin-bottom:4%;}
.f_b_con{font-size:13px;text-align:center;margin-bottom:8%;width:260px;}
.new_mb,.n_title >div:nth-of-type(3) a,.cancel,.confirms{cursor:pointer;}
</style>
<div class="fixed_box bg_fff">
    <div class="tile">模板消息确认</div>
    <div class="f_b_con">确认要将当前模板消息删除吗？</div>
    <div class="h_btn_lists clearfix" style="">
        <div class="actives confirms">确认</div>
        <div class="cancel f_r">取消</div>
    </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;">
          <div class="banner bg_fff p_0_20">
              <div class="f_r news"><i class="iconfont" style="font-size:22px;vertical-align:middle;margin-right:5px;">&#xe623;</i>消息<span class="news_radius bg_ff0000">8</span></div>
              酒店订房/模板消息
          </div>
          <div class="contents">
              <div class="head_cont contents_list bg_fff border_1">
                <div class="j_head">
                  <div  class="h_btn_list" style="">
                    <a class="actives new_mb" href="http://test008.iwide.cn/index.php/hotel_2/tmmsg/edit?tid=hotel_order_cancel">新建模板消息</a>
                  </div>
                  <div class="f_r">
                    <span class="relative">
                      <input class="w_220" type="text" placeholder="输入关键字搜索"/>
                      <span class="absolute h_30 search_btn"><i class="iconfont">&#xe6d0;</i></span>
                    </span>
                  </div>
                </div>
              </div>
              <!-- <div class="border_1 bg_fff refresh" style="text-align:center;padding:50px 0px;">还没有模版消息,点击请刷新</div>  --><!-- 没有消息时显示 -->
              <div class="news_list">
                <div class="news_con border_1 m_t_10">
                  <div class="n_title bg_f8f9fb p_10_27 b_b_1">
                    <div>序号：1</div>
                    <div>创建时间：2016.09.19  16:07:08</div>
                    <div>
                      <a class="color_2d87e2" href="http://test008.iwide.cn/index.php/hotel_2/tmmsg/edit?tid=hotel_order_cancel">编辑</a>
                      <a class="close_btn">删除</a>
                    </div>
                  </div>
                  <div class="bg_fff con_lsit">
                    <div class="row_con">
                      <div>模版名称：酒店订单已确认</div>
                      <div>模版ID：UEcUk1iJ9OmFVdzwACrlBplyk_tmVo_nbVTQGvllhhs</div>
                    </div>
                    <div class="row_con">
                      <div>引流页面：我的订单</div>
                      <div>状态：有效</div>
                    </div>
                  </div>
                </div>
                <div class="news_con border_1 m_t_10">
                  <div class="n_title bg_f8f9fb p_10_27 b_b_1">
                    <div>序号：2</div>
                    <div>创建时间：2016.09.19  16:07:08</div>
                    <div>
                      <a class="color_2d87e2" href="http://test008.iwide.cn/index.php/hotel_2/tmmsg/edit?tid=hotel_order_cancel">编辑</a>
                      <a class="close_btn">删除</a>
                    </div>
                  </div>
                  <div class="bg_fff con_lsit">
                    <div class="row_con">
                      <div>模版名称：酒店订单已确认</div>
                      <div>模版ID：UEcUk1iJ9OmFVdzwACrlBplyk_tmVo_nbVTQGvllhhs</div>
                    </div>
                    <div class="row_con">
                      <div>引流页面：我的订单</div>
                      <div>状态：有效</div>
                    </div>
                  </div>
                </div>
                <div class="news_con border_1 m_t_10">
                  <div class="n_title bg_f8f9fb p_10_27 b_b_1">
                    <div>序号：3</div>
                    <div>创建时间：2016.09.19  16:07:08</div>
                    <div>
                      <a class="color_2d87e2" href="http://test008.iwide.cn/index.php/hotel_2/tmmsg/edit?tid=hotel_order_cancel">编辑</a>
                      <a class="close_btn">删除</a>
                    </div>
                  </div>
                  <div class="bg_fff con_lsit">
                    <div class="row_con">
                      <div>模版名称：酒店订单已确认</div>
                      <div>模版ID：UEcUk1iJ9OmFVdzwACrlBplyk_tmVo_nbVTQGvllhhs</div>
                    </div>
                    <div class="row_con">
                      <div>引流页面：我的订单</div>
                      <div>状态：有效</div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
    </div>



    <div class="j_toshow bg_fff">
        <div class="banner bg_fff p_0_20">消息中心（8未读）<i class="iconfont f_r close_btn" style="font-size:24px;">&#xe635;</i></div>
        <div class="toshow_con">
            <div class="border_1 t_con_list">
                <div class="toshow_con_titl">
                    <a class="f_r mores" href="">更多</a>
                    <span class="toshow_titl_txt">订单消息<div class="radius_txt bg_ff0000 color_fff">6</div></span>
                </div>
                <div class="toshow_con_list">
                    <a href="">[待确认]您有一条新的订房订单需要确认哦！</a>
                    <a href="">[待确认]您有一条新的订房订单需要确认哦！</a>
                    <a href="">[待确认]您有一条新的订房订单需要确认哦！</a>
                    <a href="">[待确认]您有一条新的订房订单需要确认哦！</a>
                    <a href="">[待确认]您有一条新的订房订单需要确认哦！</a>
                </div>
            </div>
            <div class="border_1 t_con_list">
                <div class="toshow_con_titl">
                    <a class="f_r mores" href="">更多</a>
                    <span class="toshow_titl_txt">用户评价<div class="radius_txt bg_ff0000 color_fff">1</div></span>
                </div>
                <div class="toshow_con_list">
                    <a href="">[买家评价]还好吧，挺干净的，也挺安静。</a>
                </div>
            </div>
            <div class="border_1 t_con_list">
                <div class="toshow_con_titl">
                    <a class="f_r mores" href="">更多</a>
                    <span class="toshow_titl_txt">全员分销<div class="radius_txt bg_ff0000 color_fff">2</div></span>
                </div>
                <div class="toshow_con_list">
                    <a href="">[待审核]有新申请分销员等待您审核哦！</a>
                    <a href="">[待审核]有新申请分销员等待您审核哦！</a>
                </div>
            </div>
            <div class="border_1 t_con_list">
                <div class="toshow_con_titl">
                    <a class="f_r mores" href="">更多</a>
                    <span class="toshow_titl_txt">社群客<div class="radius_txt bg_ff0000 color_fff">2</div></span>
                </div>
                <div class="toshow_con_list">
                    <a href="">[待审核]有新申请分销员等待您审核哦！</a>
                    <a href="">[待审核]有新申请分销员等待您审核哦！</a>
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
  $('.close_btn').click(function(){
      var _this=$(this);
          $('.fixed_box').fadeIn();
          $('.confirms').click(function(){
              $('.fixed_box').fadeOut();
              _this.parents(".news_con").remove();
          });
  });
  $('.cancel').click(function(){
      $('.fixed_box').fadeOut();
  });
  // $('#coupons_table').DataTable({
  //       "aLengthMenu": [8,50,100,200],
  //     "iDisplayLength": 8,
  //     "bProcessing": true,
  //     "paging": true,
  //     "lengthChange": true,
  //     "ordering": true,
  //     "info": true,
  //     "autoWidth": false,
  //     "searching": false,
  //     "language": {
  //       "sSearch": "搜索",
  //       "lengthMenu": "每页显示 _MENU_ 条记录",
  //       "zeroRecords": "找不到任何记录. ",
  //       "info": "",
  //       //"info": "当前显示第_PAGE_ / _PAGES_页，记录从 _START_ 到 _END_ ，共 _TOTAL_ 条",
  //       "infoEmpty": "",
  //       "infoFiltered": "(从 _MAX_ 条记录中过滤)",
  //       "paginate": {
  //         "sNext": "下一页",
  //         "sPrevious": "上一页",
  //       }
  //     }
  // });
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
