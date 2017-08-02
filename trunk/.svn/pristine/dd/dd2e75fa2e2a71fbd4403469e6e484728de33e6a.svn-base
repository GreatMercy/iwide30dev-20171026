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
.bg_7e8e9f{background:#7e8e9f;}
.bg_eee{background:#EEEEEE}
.color_72afd2{color:#72afd2;}
.color_ff9900{color:#ff9900 !important;}
.color_F99E12{color:#F99E12;}
a{color:#92a0ae;}
.border_none{border:none !important;}

.border_1{border:1px solid #d7e0f1;}
.f_r{float:right;}
.p_0_20{padding:0 20px;}
.w_90{width:90px;}
.w_200{width:200px;}
.p_r_30{padding-right:30px;}
.m_t_10{margin-top:10px;}
.m_r_10{margin-right:10px;}
.p_0_30_0_10{padding:0 30px 0 10px;}
.b_b_1{border-bottom:1px solid #d7e0f1;}
.b_t_1{border-top:1px solid #d7e0f1;}
.p_t_10{padding-top:10px;}
.p_b_10{padding-bottom:10px;}
.w_88{display:inline-block;width:88px;}
.t_r{text-align:right;}
.m_b_8{margin-bottom:8%;}
.m_b_4{margin-bottom:4%;}

.banner{height:50px;width:100%;line-height:50px;border-bottom:1px solid #d7e0f1;padding-right:0px;}
.banner > span{padding:0px 5px;margin-left:5px;border-radius:3px;font-size:11px;}
.news{position:relative;cursor:pointer;background:#fe8f00;height:100%;padding:0px 12px;color:#fff;}
.news_radius{padding:0 2px;border-radius:3px;background:#fff;color:#fe8f00;text-align:center;font-size:8px;margin-left:8px;}
.display_flex{display:flex;display:-webkit-flex;justify-content:top;align-items:center;-webkit-align-items:center;}
.display_flex >th,.display_flex >td,.display_flex >div{-webkit-flex:1;flex:1;cursor:pointer;}
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
textarea,select,input,.moba{height:30px;line-height:30px;border:1px solid #d7e0f1;text-indent:3px;}
.display_table{display:table;width:100%;}
.display_table >div{vertical-align:middle;display:table-cell;width:23%;}
.contents{padding:10px 0px 20px 20px;}
.order_details{padding:1% 0 3% 3%;}
.order_details>div{float:left;margin-right:5%;}
.order_details>div:last-child{margin-right:0%;}
.order_d_l{width:325px;}
.order_l_con > div{margin-bottom:7px;}
.order_l_con > div >span:first-child{display:inline-block;width:80px;text-align:right;margin-right:6%;}
.order_r_con .d_t_con >.redius{position:relative;}
.order_r_con .d_t_con >.redius:after{position:absolute;content:"";width:30px;height:1px;background:#d7e0f1;top:50%;right:74px;}
.order_r_con .d_t_con:first-child >.redius:after{content:"";width:0px;height:0px;}
.order_r_con >.active{color:#ff9900;}
.order_r_con >.active >p:nth-of-type(2){color:#999;}
.order_r_con >.active >.redius{background:#ff9900;}
.order_r_con >.active >.redius:after{background:#ff9900;}
.order_r_con{text-align:center;margin-bottom:40px;}
.states{margin-bottom:18px;}
.h_btn_list> div{display:inline-block;width:100px;text-align:center;padding:6px 0px;border-radius:5px;margin-right:8px;cursor:pointer;}
.h_btn_list> div:last-child{margin-right:0px;}
.h_btn_list{margin-bottom:33px;}
.order_d_r{border-left:1px solid #d7e0f1;padding-left:13px;}
.redius{width:26px;color:#fff;height:26px;border-radius:50%;text-align:center;line-height:26px;background:#ededed;margin:5px auto;}
.d_t_con{margin-right:2.5%;}
.d_t_con:last-child{margin-right:0;}
.d_t_con >p{margin-bottom:5px}
.remarks{margin-bottom:52px;}

.h_btn_lists .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;}
.h_btn_lists> div{display:inline-block;width:100px;border:1px solid #d7e0f1;text-align:center;padding:6px 0px;border-radius:5px;margin-right:8px;}
.h_btn_lists> div:last-child{margin-right:0px;}

.fixed_box{position:fixed;top:36%;left:48%;z-index:9999;border:1px solid #d7e0f1;border-radius:5px;padding:1% 2%;display:none;}
.tile{font-size:15px;text-align:center;margin-bottom:4%;}
.f_b_con{font-size:13px;text-align:center;margin-bottom:8%;}
.confirms,.cancel{cursor:pointer;}
.modify_btn{padding-top:2%;width:325px;margin-left:3%;}
.modify_btn >div{border:1px solid #92a0ae;padding:3px 10px;border-radius:5px;margin-right:0px;width:50px;}
.informations{width:1100px;padding:2% 0 2% 3%;}
.informations >div{width:210px;float:left;}
.informations >div span:nth-of-type(2){color:#252525;}
.disabled_input{background:#fff;border:0px;}
.modify_b2,.modify_b{cursor:pointer;}
.modify_b2{display:none;}
</style>

<div class="fixed_box bg_fff">
    <div class="tile">订单修改确认</div>
    <div class="f_b_con">确认要将当前订单状态修改为“入住”状态？</div>
    <div class="h_btn_lists clearfix" style="">
        <div class="actives confirms">确认</div>
        <div class="cancel f_r">取消</div>
    </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;" >
            <div class="banner bg_fff p_0_20">
                <div class="f_r news"><i class="iconfont" style="font-size:22px;vertical-align:middle;margin-right:5px;">&#xe623;</i>消息<span class="news_radius bg_ff0000">8</span></div>
                酒店订房/订单详情
            </div>
            <div class="contents">
            	<div class="bg_fff m_b_4 border_1">
            		<div class="modify_btn clearfix">
                        <div class="f_r modify_b">修改</div>
                        <div class="f_r modify_b2">保全</div>
                    </div>
            		<div class="order_details clearfix">
            			<div class="order_d_l">
            				<div class="order_l_con m_b_8">
            					<div>
            						<span>订单号</span>
            						<span>1245323615237</span>
            					</div>
            					<div>
            						<span>下单时间</span>
            						<span>2016.12.12  16:00:00</span>
            					</div>
            					<div>
            						<span>支付状态</span>
            						<span class="color_ff9900">微信支付--未支付</span>
            					</div>
            					<div>
            						<span>实付金额</span>
            						<span><input type="text" value="698" disabled class="disabled_input" /></span>
            					</div>
            					<div>
            						<span>优惠券金额</span>
            						<span>30</span>
            					</div>
            					<div>
            						<span>积分数量</span>
            						<span>600</span>
            					</div>
            				</div>

            				<div class="order_l_con">
            					<div>
            						<span>入住酒店</span>
            						<span>金房卡大酒店广州岗顶店</span>
            					</div>
            					<div>
            						<span>入住房型</span>
            						<span>行政大床房</span>
            					</div>
            					<div>
            						<span>入住人</span>
            						<span>鸡爷</span>
            					</div>
            					<div>
            						<span>联系方式</span>
            						<span>18819188379</span>
            					</div>
            					<div>
            						<span>入住日期</span>
            						<span><input class="datepicker moba disabled_input" disabled id="datepicker" type="text" value="2016-11-22"  /></span>
            					</div>
            					<div>
            						<span>离店日期</span>
            						<span><input class="datepicker moba disabled_input" disabled id="datepicker2" type="text" value="2016-11-24"  /></span>
            					</div>
            					<div>
            						<span>房间数</span>
            						<span>5</span>
            					</div>
            				</div>
            			</div>
            			<div class="order_d_r">
            				<div class="display_table order_r_con">
            					<div class="d_t_con active">
            						<div class="redius">1</div>
            						<p>用户下单</p>
            						<p>2016.12.12  16:00:00</p>
            					</div>
            					<div class="d_t_con">
            						<div class="redius">2</div>
            						<p class="hotel_state">酒店确认</p>
            						<p>2016.12.12  16:00:00</p>
            					</div>
            					<div class="d_t_con">
            						<div class="redius">3</div>
            						<p>用户入住</p>
            						<p>&nbsp;</p>
            					</div>
            					<div class="d_t_con">
            						<div class="redius">4</div>
            						<p>用户离店</p>
            						<p>&nbsp;</p>
            					</div>
            				</div>
                            <div style="padding-left:27px;">
                				<div class="states"><span class="m_r_10 w_88">
                                    <i class="iconfont color_ff9900" style="margin-right:4px;">&#xe64d;</i>订单状态:</span>
                                    <span class="state_con">待确认</span>
                                </div>
                				<div  class="h_btn_list even_btn" style="">
                                    <div class="actives bg_ff9900 color_fff border_none template_btn_1">待确认</div>
                                    <div class="actives bg_ff9900 color_fff border_none template_btn" style="display: none;">入住</div>
    								<div class="bg_7e8e9f color_fff border_none template_btn2">取消订单</div>
    							</div>
                				<div class="remarks"><span class="m_r_10 w_88"><i class="iconfont color_ff9900"  style="margin-right:4px;">&#xe64d;</i>用户备注:</span>我要无烟房</div>
                                <div class="remarks clearfix">
                                    <span class="m_r_10 w_88" style="float:left;">前台备注:</span>
                                    <textarea style="width:300px;height:120px;"></textarea>
                                </div>
                				<div>
                					<p>温馨提醒:</p>
                					<p>a.如果无法接单,请及时与买家联系并说明情况后进行退款</p>
                				</div>
                            </div>
            			</div>
            		</div>
            	</div>
            	<div class="bg_fff border_1">
            		<div class="clearfix order_l_con informations">
                        <div>
                            <span>会员ID:</span>
                            <span>18819188370</span>
                        </div>   
                        <div>
                            <span>性别:</span>
                            <span>男</span>
                        </div>
                        <div>
                            <span>年龄段:</span>
                            <span>90后</span>
                        </div> 
                        <div>
                            <span>会员等级:</span>
                            <span>黑钻会员</span>
                        </div> 
                        <div>
                            <span>客户关系:</span>
                            <span>活跃用户</span>
                        </div>  
                        <div>
                            <span>注册时间:</span>
                            <span>2016.01.06</span>
                        </div>   
                        <div>
                            <span>账户余额:</span>
                            <span>755</span>
                        </div>
                        <div>
                            <span>账户积分:</span>
                            <span>7000</span>
                        </div> 
                        <div>
                            <span>优惠券:</span>
                            <span>43</span>
                        </div> 
                        <div>
                            <span>消费订单:</span>
                            <span  class="color_ff9900">6</span>
                        </div> 
                        <div>
                            <span>消费总额:</span>
                            <span>103287</span>
                        </div>   
                        <div>
                            <span>消费能力:</span>
                            <span>300-400</span>
                        </div>
                        <div>
                            <span>常在地点:</span>
                            <span>广州</span>
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
    function toTimes(){
        var time=new Date();
        var year=time.getFullYear();
        var mon=time.getMonth()+1;
        var data=time.getDate();
        var hours=time.getHours();
        var minutes=time.getMinutes();
        var Seconds=time.getSeconds();
        return toZo(year)+"."+toZo(mon)+"."+toZo(data)+"&nbsp;"+toZo(hours)+":"+toZo(minutes)+":"+toZo(Seconds);
    }
    function toZo(str){
        var str=str.toString()
        if(str.length<2){
            return '0'+str;
        }else{
            return str;
        }
    }
    var bool=true;
    var btn_s=$("<div class='actives bg_ff9900 color_fff border_none template_btn3'>离店</div>");
    $('.template_btn_1').click(function(){
        if(bool){
            var _this=$(this);
            bool=false;
            $('.fixed_box').fadeIn();
            $('.f_b_con').html('确认要将当前订单状态修改为“酒店确认”状态？');
            $('.confirms').click(function(){
                faout();
                _this.parent().parent().find('.state_con').html('已入住');
                _this.parent().parent().find('.template_btn').show();
                $('.d_t_con:nth-of-type(2)').addClass('active');
                $('.d_t_con:nth-of-type(2) >p:nth-of-type(2)').html(toTimes());
                _this.remove();
            });
        }
    });
    $('.template_btn').click(function(){
        if(bool){
            bool=false;
            $('.fixed_box').fadeIn();
            $('.f_b_con').html('确认要将当前订单状态修改为“入住”状态？');
            $('.confirms').click(function(){
                faout();
                $('.template_btn').remove();
                $('.state_con').html('已入住');
                $('.template_btn2').remove();
                $('.d_t_con:nth-of-type(3)').addClass('active');
                $('.d_t_con:nth-of-type(3) >p:nth-of-type(2)').html(toTimes());
                $('.even_btn').append(btn_s);
            });
        }
    });
    $('.template_btn2').click(function(){
        if(bool){
            bool=false;
            $('.fixed_box').fadeIn();
            $('.f_b_con').html('确认要将当前订单状态修改为“取消订单”？');
            $('.confirms').click(function(){
                faout();
                $('.state_con').html('酒店取消');
                $('.template_btn2,.template_btn,.template_btn_1').remove();
                $('.d_t_con:nth-of-type(2) >p:nth-of-type(2)').html(toTimes());
                $('.hotel_state').html('酒店取消');
            });
        }
    });
    $('.even_btn').delegate('.template_btn3','click',function(){
        if(bool){
            bool=false;
            $('.fixed_box').fadeIn();
            $('.f_b_con').html('确认要将当前订单状态修改为“离店”状态？');
            $('.confirms').click(function(){
                faout();
                $('.template_btn3').remove();
                $('.state_con').html('已离店');
                $('.d_t_con:nth-of-type(4)').addClass('active');
                $('.d_t_con:nth-of-type(4) >p:nth-of-type(2)').html(toTimes());
            });
        }
    })
    $('.cancel').click(function(){
        bool=true;
        $('.fixed_box').fadeOut();
    });
    function faout(){
        bool=true;
        $('.fixed_box').fadeOut();
    }
    $('.modify_b').click(function(){
        $('.modify_b').hide();
        $('.modify_b2').show();
        $('input').removeAttr('disabled');
        $('input').removeClass('disabled_input');
    })
    $('.modify_b2').click(function(){
        $('.modify_b').show();
        $('.modify_b2').hide();
        $('.order_l_con input').attr('disabled','disabled');
        $('.order_l_con input').addClass('disabled_input');
    })
	$('.classification >div').click(function(){
		$(this).addClass('add_active').siblings().removeClass('add_active');
	})
	$('.news').click(function(){
    	$('.j_toshow').animate({"right":"0px"},800);
	});
	$('.close_btn').click(function(){
	    $('.j_toshow').animate({"right":"-330px"},800);
	});
})
</script>
</body>
</html>
