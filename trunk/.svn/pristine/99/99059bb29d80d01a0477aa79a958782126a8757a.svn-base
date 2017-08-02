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
.bg_e8eaee{background:#e8eaee;}
.bg_fe6464{background:#fe6464;}
.color_72afd2{color:#72afd2;}
.color_ff9900{color:#ff9900;}
.color_F99E12{color:#F99E12;}
a{color:#92a0ae;}

.border_1{border:1px solid #d7e0f1;}
.f_r{float:right;}
.p_0_20{padding:0 20px;}
.w_90{width:90px;}
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
.display_flex{display:flex;display:-webkit-flex;justify-content:top;align-items:center;-webkit-align-items:center;}
.display_flex >div{-webkit-flex:1;flex:1;cursor:pointer;}
.j_toshow{width:320px;min-height:100%;position:absolute;top:50px;right:-330px;box-shadow:-5px 0px 15px rgba(0,0,0,0.1);-webkit-box-shadow:-5px 0px 15px rgba(0,0,0,0.1);}
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
.contents_list{display:table;width:100%;border:1px solid #d7e0f1;margin-bottom:10px;}
.head_cont{padding:20px 0 20px 10px;}
.head_cont >div{margin-bottom:10px;cursor:pointer;}
.head_cont >div:last-child{margin-bottom:0px;}
.head_cont .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;}
.h_btn_list> div{display:inline-block;width:100px;border:1px solid #d7e0f1;text-align:center;padding:6px 0px;border-radius:5px;margin-right:8px;}
.h_btn_list> divlast-child{margin-right:0px;}
.j_head >div{display:inline-block;}
.j_head >div:nth-of-type(1){width:307px;}
.j_head >div:nth-of-type(2){width:526px;}
.j_head >div:nth-of-type(3){width:255px;}
.j_head >div >span:nth-of-type(1){display:inline-block;width:60px;text-align:center;}
.classification{height:30px;line-height:30px;}
.classification >div{width:70px;display:inline-block;text-align:center;height:30px;}
.classification .add_active{border-bottom:3px solid #ff9900;}
.fomr_term{height:30px;line-height:30px;}
.classification >div,.all_open_order{cursor:pointer;}
.template >div{text-align:center;}
.template >div:nth-of-type(1){-webkit-flex:3.7;flex:3.7;text-align:left;padding-left:10px;}
.template >div:nth-of-type(2){-webkit-flex:1.2;flex:1.2;}
.template >div:nth-of-type(7){-webkit-flex:1.3;flex:1.3;}
.template_img{float:left;width:50px;height:50px;overflow:hidden;vertical-align:middle;margin-right:2%;}
.template_span{display:inline-block;margin-top:2px;}
.template_btn{padding:1px 8px;border-radius:3px;}
.temp_con >div >span{line-height:1.7;}
.room{width:52px;display:inline-block;}
.con_list > div:nth-child(odd){background:#fafcfb;}
.con_list{display:none;}
</style>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;">
            <div class="banner bg_fff p_0_20">
                <div class="f_r news"><i class="iconfont" style="font-size:22px;vertical-align:middle;margin-right:5px;">&#xe623;</i>消息<span class="news_radius bg_ff0000">8</span></div>
                订单管理
            </div>
            <div class="contents">
				<div class="head_cont contents_list bg_fff">
					<div class="j_head">
						<div>
							<span>酒店名称</span>
							<select class="w_200">
								<option>酒店名称</option>
								<option>酒店1</option>
								<option>酒店2</option>
								<option>酒店3</option>
							</select>
						</div>
						<div>
							<span>时间筛选</span>
							<select class="w_90">
								<option value="1">下单时间</option>
                            	<option value="2">入住时间</option>
                            	<option value="3">离店时间</option>
							</select>
							<span class="t_time"><input name="start_t" type="text" id="datepicker" class="datepicker moba" value=""></span>
                            <font>至</font>
                            <span class="t_time"><input name="end_t" type="text" id="datepicker2" class="datepicker moba" value=""></span>
						</div>
						<div>
							<span>关键字</span>
							<span><input type="text" placeholder="输入关键字搜索"/></span>
						</div>
					</div>
					<div class="j_head">
						<div>
							<span>支付方式</span>
							<span>
								<select  class="w_200" name="paytype">
                                	<option value="-1">全部</option>
                                	<option value="1">微信支付</option>
                                	<option value="2">到店支付</option>
                                	<option value="3">积分支付</option>
                                	<option value="4">储值支付</option>
                                </select>
							</span>
						</div>
						<div>
							<span>支付状态</span>
							<span>
								<select class="w_90" name="paystatus">
                                	<option value="-1">全部</option>
                                	<option value="0">未支付</option>
                                	<option value="1">已支付</option>
                                </select>
							</span>
						</div>
						<div>
							<span>订单状态</span>
							<span>
								<select name="orderstatus">
                                	<option value="-1">全部</option>
                                	<option value="0">待确认</option>
                                	<option value="1">待入住</option>
                                	<option value="2">待离店</option>
                                	<option value="3">已离店</option>
                                	<option value="4">用户取消</option>
                                	<option value="5">酒店取消</option>
                                	<option value="11">系统取消</option>
                                </select>
							</span>
						</div>
					</div>
					<div  class="h_btn_list" style="">
						<div class="actives">筛选</div>
						<div>批量导出</div>
						<div>显示设置</div>
					</div>
				</div>
				<div class="contents_list bg_fff" style="font-size:13px;">
					<div class="p_r_30 classification b_b_1">
						<span class="f_r all_open_order">展开订单</span>
						<div class="add_active">待确认</div>
						<div>今日入住</div>
						<div>今日订单</div>
						<div>所有订单</div>
					</div>
					<div class="bg_f8f9fb display_flex fomr_term template">
						<div>酒店&房型</div>
						<div>实付金额&房数</div>
						<div>券&积分</div>
						<div>客户信息</div>
						<div>下单时间</div>
						<div>支付状态</div>
						<div>订单状态</div>
						<div>操作</div>
					</div>
				</div>
				<div class="border_1 m_t_10 bg_fff">
					<div class="bg_f8f9fb fomr_term p_0_30_0_10 b_b_1">
						<a href="" class="f_r color_F99E12">订单详情</a>
						<div>订单号：631273617671647141254724612631</div>
					</div>
					<div class="display_flex temp_con template p_t_10 p_b_10">
						<div class="clearfix">
							<img class="template_img" src="http://test008.iwide.cn/public/js/img/bg03.jpg">
							<span class="template_span">金房卡大酒店广州岗顶店-行政大床房</span><br>
							<span>入离：2016.10.27-2016.10.30</span>
						</div>
						<div>
							<span>698.00</span><br>
							<span>1间房</span>
						</div>
						<div>
							<span>30.00</span><br>
							<span>600</span>
						</div>
						<div>
							<span>廖大雄</span><br>
							<span>18819188370</span>
						</div>
						<div>
							<span>2016.10.30</span><br>
							<span>10:56:19</span>
						</div>
						<div>
							<span>微信支付</span><br>
							<span class="color_ff9900">未支付</span>
						</div>
						<div>
							<span>等待确认</span><br>
							<span class="bg_ff9900 color_fff template_btn">确认</span>
							<span class="bg_fe6464 color_fff template_btn">拒绝</span>
						</div>
						<div>
							<span class="color_72afd2">打印订单</span><br>
							<span>&nbsp;</span>
						</div>
					</div>
				</div>
				<div class="border_1 m_t_10 bg_fff">
					<div class="bg_f8f9fb fomr_term p_0_30_0_10 b_b_1">
						<a href="" class="f_r color_F99E12">订单详情</a>
						<div>订单号：631273617671647141254724612631</div>
					</div>
					<div class="display_flex temp_con template p_t_10 p_b_10">
						<div class="clearfix">
							<img class="template_img" src="http://test008.iwide.cn/public/js/img/bg03.jpg">
							<span class="template_span">金房卡大酒店广州岗顶店-行政大床房</span><br>
							<span>入离：2016.10.27-2016.10.30</span>
						</div>
						<div>
							<span>698.00</span><br>
							<span>1间房</span>
						</div>
						<div>
							<span>30.00</span><br>
							<span>600</span>
						</div>
						<div>
							<span>廖大雄</span><br>
							<span>18819188370</span>
						</div>
						<div>
							<span>2016.10.30</span><br>
							<span>10:56:19</span>
						</div>
						<div>
							<span>微信支付</span><br>
							<span class="color_ff9900">未支付</span>
						</div>
						<div>
							<span>等待确认</span><br>
							<span class="bg_e8eaee color_fff template_btn">确认</span>
						</div>
						<div>
							<span class="color_72afd2">打印订单</span><br>
							<span class="color_72afd2 open_order">展开订单</span>
						</div>
					</div>
					<div class="con_list">
						<div  class="display_flex temp_con template p_t_10 p_b_10 b_t_1">
							<div class="clearfix">
								<span class="room">房间1</span>
								<span>金房卡大酒店广州岗顶店-行政大床房</span>
							</div>
							<div>
								<span>698.00</span>
							</div>
							<div>
								<span>30.00</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span class="border_1 template_btn">入住</span>
								<span class="border_1 template_btn">未到</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
						</div>
						<div  class="display_flex temp_con template p_t_10 p_b_10 b_t_1">
							<div class="clearfix">
								<span class="room">房间1</span>
								<span>金房卡大酒店广州岗顶店-行政大床房</span>
							</div>
							<div>
								<span>698.00</span>
							</div>
							<div>
								<span>30.00</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span class="border_1 template_btn">入住</span>
								<span class="border_1 template_btn">未到</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
						</div>
						<div  class="display_flex temp_con template p_t_10 p_b_10 b_t_1">
							<div class="clearfix">
								<span class="room">房间1</span>
								<span>金房卡大酒店广州岗顶店-行政大床房</span>
							</div>
							<div>
								<span>698.00</span>
							</div>
							<div>
								<span>30.00</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span class="border_1 template_btn">入住</span>
								<span class="border_1 template_btn">未到</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
						</div>
						<div  class="display_flex temp_con template p_t_10 p_b_10 b_t_1">
							<div class="clearfix">
								<span class="room">房间1</span>
								<span>金房卡大酒店广州岗顶店-行政大床房</span>
							</div>
							<div>
								<span>698.00</span>
							</div>
							<div>
								<span>30.00</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span class="border_1 template_btn">入住</span>
								<span class="border_1 template_btn">未到</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
						</div>
						<div  class="display_flex temp_con template p_t_10 p_b_10 b_t_1">
							<div class="clearfix">
								<span class="room">房间1</span>
								<span>金房卡大酒店广州岗顶店-行政大床房</span>
							</div>
							<div>
								<span>698.00</span>
							</div>
							<div>
								<span>30.00</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span>&nbsp;</span>
							</div>
							<div>
								<span class="border_1 template_btn">入住</span>
								<span class="border_1 template_btn">未到</span>
							</div>
							<div>
								<span>&nbsp;</span>
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
        <!--<div>    	
        	<div class="content-header"> 
                    <ul class="nav nav-tabs nav_radio">
                        <?php foreach($show_status as $k=>$show) {?>
                        <li<?php if($istatus==$k){ ?> class="actives"<?php }?>>
                        	<a href="<?php echo site_url('hotel/orders/index').'?s='.$k; ?>" ><?php echo $show['des']; ?>
                            	<font>(<?php echo $show['count'];?>)</font>
                                <span class="prompt_txt"><?php echo $show['rmk'];?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <form class="form" method='get' action='<?php echo $search_url;?>'>
                    <input type="hidden" name="s" value="<?php echo $istatus;?>" />
                    	<div class="box-body">
                        	<div class="list_o">
                            	<span>酒店:</span>
                                <span>
                                	<select name="hotel">
                                    	<option value="-1">全部酒店</option>
                                    	<?php foreach ($allhotels as $kh => $vh) {?>
                                    	<option value="<?php echo $vh['hotel_id'];?>" <?php if($vh['hotel_id']==$hotel) echo 'selected';?>><?php echo $vh['name'];?></option>
                                    	<?php }?>
                                    </select>
                                </span>
                                <span><input name="hotel_name" type="text" placeholder="请输入酒店名称" value="<?php echo $hotel_name;?>" /></span>
                            </div>
                        	<div class="list_o">
                            	<span>日期:</span>
                                <span>
                                	<select name="timetype">
                                	<?php foreach ($time_type as $kt => $vt) {?>
                                    	<option value="<?php echo $kt;?>" <?php if($kt==$timetype) echo 'selected';?>><?php echo $vt;?></option>
                                   	<?php }?>
                                    </select>
                                </span>
                                <span class="t_time"><input name="start_t" type="text" data-date-format="yyyy-mm-dd" class="c_time datepicker" value="<?php echo $start_t;?>"></span>
                                <font>至</font>
                                <span class="t_time"><input name="end_t" type="text" data-date-format="yyyy-mm-dd" class="c_time datepicker" value="<?php echo $end_t;?>"></span>
                            </div>
                        	<div class="list_o">
                            	<span>关键词:</span>
                                <span class="number"><input name="number" class="n_i_number" type="text" placeholder="入住人姓名/手机号/订单号/备注" value="<?php echo $number;?>" /></span>
                            </div>
                        	<div class="list_o di_in_block" style="margin-left:0px;">
                            	<span>支付方式:</span>
                                <span>
                                	<select name="paytype">
                                    	<option value="-1">全部</option>
                                    <?php foreach ($pay_type as $kp => $vp) {?>
                                    	<option value="<?php echo $kp;?>" <?php if($kp==$paytype) echo 'selected';?>><?php echo $vp;?></option>
                                    <?php }?>
                                    </select>
                                </span>
                            </div>
                            <div class="list_o di_in_block">
                            	<span>支付状态:</span>
                                <span>
                                	<select name="paystatus">
                                    	<option value="-1">全部</option>
                                    <?php foreach ($pay_status as $ks => $vs) {?>
                                    	<option value="<?php echo $ks;?>" <?php if($ks==$paystatus) echo 'selected';?>><?php echo $vs;?></option>
                                    <?php }?>
                                    </select>
                                </span>
                            </div>
                        	<div class="list_o di_in_block">
                            	<span>订单状态:</span>
                                <span>
                                	<select name="orderstatus">
                                    	<option value="-1">全部</option>
                                    	<?php foreach ($order_status as $ko => $vo) {?>
                                    	<option value="<?php echo $ko;?>" <?php if($ko==$orderstatus) echo 'selected';?>><?php echo $vo;?></option>
                                    	<?php }?>
                                    </select>
                                </span>
                            </div>
                            <div class="list_o"><input class="btn_o" name="searchbtn" type="submit" value="搜索" /><font id="tips" style="color:red;"></font>
                            </div>
                            <div class="list_o">
                            <input class="btn_o" name="setbtn" type="button" value="显示设置" id="grid-btn-set" data-toggle="modal" data-target="#setModal"/>
                            </div>
                        </div>
                    </form>
                </div>
			<section class="content">
				<a href="javascript:void(0);" onclick='$(".weborder").show();'>展开</a>
				<a href="javascript:void(0);" onclick='$(".weborder").hide();'>收起</a>
				<div class="row" style="box-sizing:border-box;-webkit-box-sizing:border-box;">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-body">
								<table id="data-grid"
									class="table table-bordered table-striped table-condensed dataTable">
									<thead>
										<tr>
             <?php foreach ($fields_config as $k=> $v):?>
             <th <?php if(isset($v['grid_width'])) echo 'width="'. $v['grid_width']. '"'; ?>>
             <?php echo $v['label'];?></th>
             <?php endforeach; ?><th colspan=2>操作</th>
										</tr>
									</thead>
                    <?php if(!empty($list)){ foreach($list as $lt){ ?>
                    <tr onclick="slidesub('<?php echo $lt['id'];?>')"
										class="morder">
                    <?php foreach ($fields_config as $k=> $v):?>
             <td><?php echo $lt[$k];?></td>
             <?php endforeach; ?><td>
            <?php if(empty($lt['no_status'])){?>  
            <span class='a_like' data-toggle="modal" data-target="#orderModal" onclick="show_detail(this)" oid='<?php echo $lt['orderid'];?>' h='<?php echo $lt['hotel_id'];?>'>状态</span>
             <?php }else {?><span>----&nbsp;</span><?php }?>
             <a href="<?php echo site_url('hotel/orders/edit').'?ids='.$lt['id'].'&h='.$lt['hotel_id'];?>">修改</a>
             <a href="<?php echo site_url('hotel/orders/edit').'?ids='.$lt['id'].'&h='.$lt['hotel_id'].'&print=1';?>">打印</a>
             </td>
             </tr>
             <?php if(!empty($lt['order_details'])){ foreach($lt['order_details'] as $od){?>
             <tr name="weborder<?php echo $lt['id'];?>" class="weborder">
	             <?php foreach($item_fields_config as $ik=>$i){?>
	             <td><?php echo isset($od[$ik])?$od[$ik]:'';?></td>
	             <?php }?>
	              <td>
	              <?php if(empty($lt['no_item_status'])&&empty($od['no_item_status'])){?>
	              <a href="<?php echo site_url('hotel/orders/item_edit').'?oid='.$lt['orderid'].'&h='.$lt['hotel_id'].'&item='.$od['id'];?>">状态</a>
	              <a href="<?php echo site_url('hotel/orders/item_edite').'?oid='.$lt['orderid'].'&h='.$lt['hotel_id'].'&item='.$od['id'];?>">修改</a>
	             <?php }else {?><span>-</span><?php }?>
	             </td>
			 </tr>
             	<?php }}?>
             <?php }}?>
                  </table>
							</div>
						</div>
					</div>
			</section>
			<div class="box-footer ">
				<div class="page"><?php echo $pagination;?></div>
			</div>
		</div> -->
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
<!-- <script src="http://30.iwide.cn/public/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="http://30.iwide.cn/public/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="http://30.iwide.cn/public/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script> -->
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
	$('.classification >div').click(function(){
		$(this).addClass('add_active').siblings().removeClass('add_active');
	})
	$('.open_order').click(function(){
		$(this).parent().parent().next().slideToggle();
	})
	$('.all_open_order').click(function(){
		$('.con_list').slideToggle();
	})
	$('.news').click(function(){
    	$('.j_toshow').animate({"right":"0px"},800);
	});
	$('.close_btn').click(function(){
	    $('.j_toshow').animate({"right":"-330px"},800);
	});
	<!--日历调用-->
	// $('.datepicker').datepicker({
	// 	dateFormat: "yymmdd"
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
function slidesub(id){
	chose="[name='"+'weborder'+id+"']";
	if($(chose).css("display")=='table-row'){
		$(chose).css("display",'none');
	}
	else{
		$(chose).css("display",'table-row');
	}
}
<!--yu 2016/09/19-->
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
</script>
</body>
</html>