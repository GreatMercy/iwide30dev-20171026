<!-- DataTables -->
<link rel="stylesheet"
    href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
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
    <div class="wrapper">

<?php
/* 顶部导航 */
echo $block_top;
?>

<?php
/* 左栏菜单 */
echo $block_left;
?>
<!-- Content Wrapper. Contains page content -->
<!--杰 2016-8-31 start-->
<style>
.titile{}
.titile >h2{display:inline-block;}
.see{float:right;margin-top:30px;}
.containers{background:#f2f2f2;padding:20px;box-sizing:border-box;-webkit-box-sizing:border-box;}
.contai_h2{margin-bottom:10px;}
.contai_h2 font{color:#ff9900;margin-left:8px;}
.contai_h2 span{margin-right:20px;}
.contai_h2 span:last-child{margin-right:0;}
.contai_h2 >h2{margin-top:0px;margin-bottom:10px;font-size:25px;}
.sm_box{line-height:1.5;margin-top:2px;}
.journalism >a{display:block;line-height:1.5;color:#000;}
.journalism >a:hover{color:rgba(191,18,174,1.00);}
.wait_matter >h1{display:inline-block;margin-right:40px;}
.wait_matter >a{margin:0 20px;}
.wait_matter >a:first-child{margin-left:0px;}
.title{color:#fd9b08;font-size:16px;margin-left:15px;}
.title >font{font-size:13px;}
.ticket{background:#fff;padding:10px 15px 10px 20px;box-sizing:border-box;-webkit-box-sizing:border-box;margin-bottom:22px;margin-top:12px;}
.con_left,.con_right{display:inline-block;}
.con_left{width:57%;}
.mode,.money{float:right;color:#fd325a;}
.night,.mode,.money{margin-top:10px;display:inline-block;}
.con_right{float:right;}
.p_m_0{padding:0px;margin:5px 0;}
.times{float:left;margin-right:38px;}
.times >p{margin:0px;}
.con_l_t >p{margin:0px;}
.m_width{min-width:630px;max-width:920px;}
.btn_list{text-align:center;margin-top:20px;}
.btn_list >a{border:1px solid #e4e4e4;padding:5px 15px;margin-right:18px;color:#000;}
.btn_list >a:hover{border:1px solid #9328C1;color:rgba(66,64,64,1.00);background:#f2f2f2;}
.btn_list >a:last-child{margin-right:0px;}
.isolatioin{margin:0 10px;}
.none_txt{text-align:center;font-size:20px;color:#666;margin:20px 0;}
.thim_list{width:70px;display:inline-block;margin-right:3%;}
.notice_link {color:#3c8dbc; }
</style>
<div class="content-wrapper" style="background:#fff;">
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box-body" style="margin-left:16px;">
                <div class="form-group m_width">

                    <?php if(isset($notice_model)): ?>
                        <div class="containers" style="padding: 0;font-size: 18px;">
                            <div class="pull-left" style="background:#fff;padding-right: 4px;">
                                <i class="fa fa-bullhorn" style="font-size: 26px;"></i>
                            </div>
                            <span style="padding-left: 10px;">
                                <a class="notice_link" href="<?php echo EA_const_url::inst()->get_url("privilege/notice/detail?ids=" . $notice_model->id) ?>"><?php echo $notice_model->title; ?></a>
                            </span>
                            <div class="pull-right" style="margin-right: 5px;">
                                <a class="notice_link" href="<?php echo EA_const_url::inst()->get_url("privilege/notice/grid") ?>">更多</a>
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="titile">
                        <h2 style="margin-right:18px;" >今日概览</h2>
                        <font><?php echo date('Y.m.d')?></font>
                        <font><?php $weekarray=array("日","一","二","三","四","五","六");echo "星期".$weekarray[date("w")];?></font>
                    </div>
                    <div class="containers">
                        <div class="contai_h2">
                            <h2>订房</h2>
                            <div class="sm_box">
                                <span>今日订单:<font><?php echo $t_order_num;?></font>个</span>
                                <span>今日入住:<font><?php echo $t_checkin_num;?></font>个</span>
                            </div>
                        </div>
                        <!--<div class="contai_h2">
                            <h2>商城</h2>
                            <div class="sm_box">
                                <span>今日订单:<font>4</font>个</span>
                            </div>
                        </div>
                        <div class="contai_h2">
                            <h2>会员</h2>
                            <div class="sm_box">
                                <span>今日新会员:<font>4</font>个</span>
                            </div>
                        </div>-->
                    </div>
                </div>
                <!--<div class="form-group col-xs-6">
                    <div class="titile">
                        <a class="see">查看更多</a>
                        <h2>系统公告</h2>
                    </div>
                    <div class="containers journalism">
                        <a href="#">【新功能上线】 社群客功能已上线</a>
                        <a href="#">【新功能上线】 秒杀功能已线</a>
                        <a href="#">【系统通知】 优惠券功能已修复</a>
                    </div>
                </div>-->
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
            <div class="box-body">
                <div class="form-group col-xs-12 wait_matter">
                    <h1 class="">待处理事项</h1>
                    <!--<div class="wait_matter" style="display:inline-block;">
                        <a href="#">全部</a>
                        <a href="<?php echo site_url('hotel/orders/index');?>">订房订单确认</a>
                        <a href="#">社群客审核</a>
                        <a href="#">商城订单处理</a>
                    </div>-->
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body" style="padding:0 26px;">
                <div class="containers m_width">
                    <div class="boxs">
                        <div class="title">订房订单确认<font id="ocnum">(<?php echo $order_comfirm_num;?>)</font></div>
                        <?php if(!empty($order_confirm_two)){
                        foreach ($order_confirm_two as $ko => $vo) {?>
                        <div class="ticket">
                            <div class="con_left">
                                <div class="con_l_t">
                                    <font class="money"><?php echo $vo['price'];?>元</font>
                                    <p><?php echo $vo['hname'];?></p>
                                    <p><?php echo $vo['roomname'];?>--<?php echo $vo['price_name'];?>--<?php echo $vo['count'];?>间</p>
                                </div>
                                <hr class="p_m_0">
                                <div>
                                    <font class="mode"><?php echo $vo['paytype'];?></font>
                                    <div class="times">
                                        <p><?php echo $vo['startdate'];?></p>
                                        <p><?php echo $vo['enddate'];?></p>
                                    </div>
                                    <span class="night"><?php echo $vo['days'];?>晚</span>
                                </div>
                            </div>
                            <div class="con_right" style="width:30%;">
                                <div><span class="thim_list">下单日期:</span><?php echo $vo['order_time'];?></div>
                                <div><span class="thim_list">订单号:</span><?php echo $vo['orderid'];?></div>
                                <div class="btn_list">
                                    <a href="<?php echo site_url('hotel/orders/edit').'?orderid='.$vo['orderid'].'&h='.$vo['hotel_id'];?>">订单详情</a>
                                    <a class="confirm" href="javascript:;" data-id="<?php echo $vo['orderid'];?>" >立即确认</a>
                                </div>
                            </div>
                        </div>
                        <?php }}else{?>
                        <!--没有时显示以下div-->
                        <div class="none_txt">暂时没有需要处理的订单！！！</div>
                        <?php }?>
                    </div>
                   <!-- <div class="boxs">
                        <div class="title">社群客审核<font>(2)</font></div>
                        <div class="ticket">
                            <div class="con_left">
                                <div class="con_l_t">
                                    <font class="money">200元</font>
                                    <p>金房卡大酒店</p>
                                    <p>高级大床房--微信价</p>
                                </div>
                                <hr class="p_m_0">
                                <div>
                                    <p>2016-08-19<font class="isolatioin">至</font>2017-08-18</p>
                                </div>
                            </div>
                            <div class="con_right">
                                <div>申请日期:2016年08月19日 22:43:00</div>
                                <div class="btn_list">
                                    <a>查看详情</a>
                                    <a class="confirm" href="javascript:;">审核通过</a>
                                </div>
                            </div>
                        </div>
                        没有时显示以下div-->
                        <!--<div class="none_txt">没有要审核的社群客！！！</div>
                    </div>-->
                    <!--没有时显示以下div-->
                    <!--<div class="none_txt">没有要处理的事项！！！</div>-->
                </div>
            </div>
        </div>
      </div>
    </section>
</div>

<!--杰 2016-8-31 end-->
<!-- ./wrapper -->

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
<script>
/*杰 2016-8-31 start*/
$(function(){
    $('body').on('click','.confirm',function(){
        var str = '';
        var oid = $(this).attr('data-id');
        var This = $(this);
        $.ajax({
            url:"<?php echo site_url('hotel/orders/update_order_status').'?oid=';?>"+oid+'&status=1',
            type:'GET',
            success:function(data){
                if(data==1){
                    alert('确认成功');
                    This.parents('.ticket').fadeOut();
                    setTimeout(function(){
                        This.parents('.ticket').remove();
                    },1200);
                    $.ajax({
                        url:"<?php echo site_url('hotel/orders/getNumRoom');?>",
                        type:'GET',
                        success:function(td){
                            tdata = eval('('+td+')');
                            if(tdata.order_comfirm_num!=''){
                                $('#ocnum').text('('+tdata.order_comfirm_num+')');
                            }
                            if(tdata[0]!=''){
                                str += '<div class="ticket"><div class="con_left"><div class="con_l_t">';
                                str +=
                                            '<font class="money">'+tdata[0].price+'元</font>\
                                            <p>'+tdata[0].hname+'</p>\
                                            <p>'+tdata[0].roomname+'--'+tdata[0].price_name+'</p>\
                                        </div>\
                                        <hr class="p_m_0">\
                                        <div>\
                                            <font class="mode">'+tdata[0].paytype+'</font>\
                                            <div class="times">\
                                                <p>'+tdata[0].startdate+'</p>\
                                                <p>'+tdata[0].enddate+'</p>\
                                            </div>\
                                            <span class="night">'+tdata[0].days+'晚</span>\
                                        </div>\
                                    </div>\
                                    <div class="con_right" style="width:30%;">\
                                        <div><span class="thim_list">下单日期:</span>'+tdata[0].order_time+'</div>\
                                        <div><span class="thim_list">订单号:</span>'+tdata[0].orderid+'</div>\
                                        <div class="btn_list">\
                                            <a href="<?php echo site_url('hotel/orders/edit');?>?ids='+tdata[0].id+'&h='+tdata[0].hotel_id+'">订单详情</a><a class="confirm" href="javascript:;" data-id="'+tdata[0].orderid+'" >立即确认</a>';
                                str += '   </div>\
                                            </div>\
                                        </div>';
                            }
                            if($('.ticket')){
                                $('.ticket:first').after(str);
                            }else{
                                $('.title:first').after(str);
                            }
                        },
                        error:function(){
                            alert('请求失败，请稍后再试！');
                        }
                    });
                    if($(".ticket").length == 0){
                        $('.title').after('<div class="none_txt">没有要确认的订房订单！！！</div>');
                    }
                }else{
                    alert('确认失败');
                }
            },
            error:function(){
                alert('确认失败');
            }
        });
    })
})

/*杰 2016-8-31 end*/
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
</script>
</body>
</html>