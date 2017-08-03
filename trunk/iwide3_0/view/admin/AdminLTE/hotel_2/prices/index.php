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
a{color:#92a0ae;}

.border_1{border:1px solid #d7e0f1;}
.f_r{float:right;}
.p_0_20{padding:0 20px;}
.w_90{width:90px;}
.w_80{width:80px;}
.w_200{width:200px;}
.p_r_30{padding-right:30px;}
.m_t_10{margin-top:10px;}
.p_0_30_0_10{padding:0 30px 0 10px;}
.b_b_1{border-bottom:1px solid #d7e0f1;}
.b_t_1{border-top:1px solid #d7e0f1;}
.p_t_10{padding-top:10px;}
.p_b_10{padding-bottom:10px;}

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
.contents_list{display:table;width:100%;border-bottom:1px solid #d7e0f1;margin-bottom:10px;}
.head_cont{padding:20px 0 20px 10px;}
.head_cont >div{margin-bottom:10px;cursor:pointer;}
.head_cont >div:last-child{margin-bottom:0px;}
.j_head >div{display:inline-block;}
.j_head >div:nth-of-type(1){width:307px;}
.j_head >div:nth-of-type(2){width:307px;}
.j_head >div:nth-of-type(3){width:255px;}
.j_head >div >span:nth-of-type(1){display:inline-block;width:60px;text-align:center;}
.head_cont .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;}
.h_btn_list> div{display:inline-block;width:100px;border:1px solid #d7e0f1;text-align:center;padding:6px 0px;border-radius:5px;margin-right:8px;}
.h_btn_list> div:last-child{margin-right:0px;}
.classification{height:30px;line-height:30px;border-top:1px solid #d7e0f1;border-right:1px solid #d7e0f1;border-left:1px solid #d7e0f1;width:300px;}
.classification >div{text-align:center;height:30px;border-right:1px solid #d7e0f1;}
.classification >div:last-child{border-right:none;}
.classification .add_active{background:#ecf0f5;border-bottom:1px solid #ecf0f5;}
.fomr_term{height:30px;line-height:30px;}
.classification >div,.all_open_order{cursor:pointer;}
.all_open_order{margin-right:10px;margin-top:5px;}
.template >div{text-align:center;}
.template_img{float:left;width:50px;height:50px;overflow:hidden;vertical-align:middle;margin-right:2%;}
.template_span{display:inline-block;margin-top:2px;}
.template_btn{padding:1px 8px;border-radius:3px;}
.form_con,.form_title{height:30px;line-height:30px;}
.form_con >td,.form_title >th{text-align:center;font-weight:normal;}
.form_thead >tr,.containers >tr{padding:8px 0;}
.form_title >th:nth-of-type(2),.form_con >td:nth-of-type(2){flex:1.5;}
.form_title >th:nth-of-type(7),.form_con >td:nth-of-type(7){flex:2.9;}
.form_title >th:nth-of-type(6),.form_con >td:nth-of-type(6){flex:2.9;}
.containers >tr:nth-child(even){background:#F8F8F8 !important;}
.containers >tr:nth-child(odd){background:#fff !important;}
.form_con >td{padding-right:20px !important;}
.box-body{padding:0px;overflow:hidden;}
#coupons_table_length{display:none;}

.drow_list{display:none;position:absolute;width:100%;top:100%;left:0;background:#fff;border:1px solid #e4e4e4;padding:0;overflow:auto;z-index:999}
.drow_list li{height:35px;padding-left:15px;line-height:35px;list-style:none; cursor:pointer}
.drow_list li:hover{background:#f1f1f1}
.drow_list li.cur{background:#ff9900;color:#fff}
#drowdown:hover .drow_list{display:block}
</style>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;" >
            <div class="banner bg_fff p_0_20">
                <div class="f_r news"><i class="iconfont" style="font-size:22px;vertical-align:middle;margin-right:5px;">&#xe623;</i>消息<span class="news_radius bg_ff0000">8</span></div>
                酒店订房/价格代码管理
            </div>
		    <div class="contents">
		        <div class="head_cont contents_list bg_fff">
		          <div class="j_head">
		            <div>
		                <span>所属酒店</span>
		                <span class="input-group w_200" style="position:relative;display:inline-flex;" id="drowdown">
	                        <input placeholder="选择或输入关键字" type="text" style="color:#92a0ae;" class="form-control w_200 moba" id="search_hotel" >
	                        <ul class="drow_list">
	                            <li value="">碧桂园凤凰大酒店</li>
	                            <li value="">北京金茂万丽酒店</li>
	                            <li value="">上海街町酒店</li>
	                            <li value="">深圳威尼斯酒店</li>
	                            <li value="">街町酒店广州测试店</li>
	                            <li value="">广州金房卡大酒店</li>
	                        </ul>
	                    </span>
		            </div>
		            <div>
		              <span>房型名称</span>
		              <select class="w_200">
		                <option>酒店名称</option>
		                <option>酒店1</option>
		                <option>酒店2</option>
		                <option>酒店3</option>
		              </select>
		            </div>
		            <div>
		              <span>关键字</span>
		              <span><input type="text" placeholder="输入关键字搜索"/></span>
		            </div>
		          </div>
		          <div  class="h_btn_list" style="">
		            <div class="actives">筛选</div>
		          </div>
		        </div>
		        <div class="contents_list" style="font-size:13px;">
		          <div class="classification display_flex bg_fff">
		            <div class="add_active">有效房价</div>
		            <div>无效房价</div>
		            <div>所有房价</div>
		          </div>
		        </div>
		        <div class="box-body">
		         <table id="coupons_table" class="table-striped table-condensed dataTable no-footer" style="width:100%;">
		            <thead class="bg_f8f9fb form_thead">
		              <tr class="bg_f8f9fb form_title">
		                <th>房型</th>
		                <th>价格代码</th>
		                <th>默认房价</th>
		                <th>默认房量</th>
		                <th>关联价格代码</th>
		                <th>修改时间</th>
		                <th>状态</th>
		                <th>操作</th>
		              </tr>
		            </thead>
		            <tbody class="containers dataTables_wrapper form-inline dt-bootstrap">
		              <tr class=" form_con">
		                <td width="120px">行政大床房</td>
		                <td>基础价格</td>
		                <td><input class="w_80" type="text"/></td>
		                <td><input class="w_80" type="text"/></td>
		                <td></td>
		                <td>2016.10.10 16:00:00</td>
		                <td>
			              <select class="w_80">
			                <option>可用</option>
			                <option>不可用</option>
			                <option>隐藏</option>
			              </select>
			            </td>
		                <td>
		                	<a class="bg_ff9900 color_fff template_btn" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a>
							<span class="bg_fe6464 color_fff template_btn">保存</span>
		                </td>
		              </tr>
		              <tr class="form_con">
		                <td width="120px">行政大床房</td>
		                <td>首住优惠</td>
		                <td><input class="w_80" type="text"/></td>
		                <td><input class="w_80" type="text"/></td>
		                <td>协议价A(基础价减20元)</td>
		                <td>2016.10.10 16:00:00</td>
		                <td>可用</td>
		                <td>
		                	<a class="bg_ff9900 color_fff template_btn" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a>
							<span class="bg_fe6464 color_fff template_btn">保存</span>
		                </td>
		              </tr>
		              <tr class=" form_con">
		                <td width="120px">行政大床房</td>
		                <td>连住优惠</td>
		                <td><input class="w_80" type="text"/></td>
		                <td><input class="w_80" type="text"/></td>
		                <td>
		                </td>
		                <td>2016.10.10 16:00:00</td>
		                <td>不可用</td>
		                <td>
		                	<a class="bg_ff9900 color_fff template_btn" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a>
							<span class="bg_fe6464 color_fff template_btn">保存</span>
		                </td>
		              </tr>
		              <tr class=" form_con">
		                <td width="120px">行政大床房</td>
		                <td>协议价A</td>
		                <td><input class="w_80" type="text"/></td>
		                <td><input class="w_80" type="text"/></td>
		                <td>基础价(乘以0.7)</td>
		                <td>2016.10.10 16:00:00</td>
		                <td>隐藏</td>
		                <td>
		                	<a class="bg_ff9900 color_fff template_btn" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a>
							<span class="bg_fe6464 color_fff template_btn">保存</span>
		                </td>
		              </tr>


		              <tr class=" form_con">
		                <td width="120px">行政房</td>
		                <td>基础价格</td>
		                <td><input class="w_80" type="text"/></td>
		                <td><input class="w_80" type="text"/></td>
		                <td></td>
		                <td>2016.10.10 16:00:00</td>
		                <td>
			              <select class="w_80">
			                <option>可用</option>
			                <option>不可用</option>
			                <option>隐藏</option>
			              </select>
			            </td>
		                <td>
		                	<a class="bg_ff9900 color_fff template_btn" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a>
							<span class="bg_fe6464 color_fff template_btn">保存</span>
		                </td>
		              </tr>
		              <tr class="form_con">
		                <td width="120px">行政房</td>
		                <td>首住优惠</td>
		                <td><input class="w_80" type="text"/></td>
		                <td><input class="w_80" type="text"/></td>
		                <td>协议价A(基础价减20元)</td>
		                <td>2016.10.10 16:00:00</td>
		                <td>可用</td>
		                <td>
		                	<a class="bg_ff9900 color_fff template_btn" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a>
							<span class="bg_fe6464 color_fff template_btn">保存</span>
		                </td>
		              </tr>
		              <tr class=" form_con">
		                <td width="120px">行政房</td>
		                <td>连住优惠</td>
		                <td><input class="w_80" type="text"/></td>
		                <td><input class="w_80" type="text"/></td>
		                <td>
		                </td>
		                <td>2016.10.10 16:00:00</td>
		                <td>不可用</td>
		                <td>
		                	<a class="bg_ff9900 color_fff template_btn" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a>
							<span class="bg_fe6464 color_fff template_btn">保存</span>
		                </td>
		              </tr>
		              <tr class=" form_con">
		                <td width="120px">行政房</td>
		                <td>协议价A</td>
		                <td><input class="w_80" type="text"/></td>
		                <td><input class="w_80" type="text"/></td>
		                <td>基础价(乘以0.7)</td>
		                <td>2016.10.10 16:00:00</td>
		                <td>隐藏</td>
		                <td>
		                	<a class="bg_ff9900 color_fff template_btn" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a>
							<span class="bg_fe6464 color_fff template_btn">保存</span>
		                </td>
		              </tr>


		              <tr class=" form_con">
		                <td width="120px">测试房</td>
		                <td>基础价格</td>
		                <td><input class="w_80" type="text"/></td>
		                <td><input class="w_80" type="text"/></td>
		                <td></td>
		                <td>2016.10.10 16:00:00</td>
		                <td>
			              <select class="w_80">
			                <option>可用</option>
			                <option>不可用</option>
			                <option>隐藏</option>
			              </select>
			            </td>
		                <td>
		                	<a class="bg_ff9900 color_fff template_btn" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a>
							<span class="bg_fe6464 color_fff template_btn">保存</span>
		                </td>
		              </tr>
		              <tr class="form_con">
		                <td width="120px">测试房</td>
		                <td>首住优惠</td>
		                <td><input class="w_80" type="text"/></td>
		                <td><input class="w_80" type="text"/></td>
		                <td>协议价A(基础价减20元)</td>
		                <td>2016.10.10 16:00:00</td>
		                <td>可用</td>
		                <td>
		                	<a class="bg_ff9900 color_fff template_btn" href="http://test008.iwide.cn/index.php/hotel/hotels/add">编辑</a>
							<span class="bg_fe6464 color_fff template_btn">保存</span>
		                </td>
		              </tr>
		            </tbody>
		          </table>
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
  // $('#coupons_table').DataTable({
  //       "aLengthMenu": [10,50,100,200],
  //     "iDisplayLength": 10,
  //     "bProcessing": true,
  //     "paging": true,
  //     "lengthChange": true,
  //     "ordering": false,
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

  //行全拼start
  rowspans();
  function rowspans(){
  	  var arr1=[];
	  var josn={};
	  if($('.form_con').length>0){
		  for(var i=0;i<$('.form_con').length;i++){
		  	if(i==0){
		  		josn.roomName=$('.form_con').eq(i).find('td:first-child').html();
		  		josn.starNumber=i;
		  	}
			if(i==$('.form_con').length-1||josn.roomName!=$('.form_con').eq(i).find('td:first-child').html()){
				if(i!=$('.form_con').length-1){
					josn.endNumber=i-1;
				}else{
					josn.endNumber=i;
				}
				arr1.push(josn);
				josn={};
				if(i!=$('.form_con').length-1){
					josn.roomName=$('.form_con').eq(i).find('td:first-child').html();
					josn.starNumber=i;
				}
				
			}
		  };
	  }
	  $('.form_con td:first-child').remove();
	  for(var i=0;i<arr1.length;i++){
	  	$('.form_con').eq(arr1[i].starNumber).prepend('<td class="moba" rowspan="'+(arr1[i].endNumber+1-arr1[i].starNumber)+'">'+arr1[i].roomName+'</td>');
	  }
  }
  
 //行全拼end

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