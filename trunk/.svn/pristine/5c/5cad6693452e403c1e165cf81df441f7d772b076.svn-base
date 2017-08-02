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
.d_i_block{display:inline-block;}

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
.display_flex{display:flex;display:-webkit-flex;display:box;display:-webkit-box;justify-content:top;align-items:center;-webkit-align-items:center;}
.display_flex >div{-webkit-flex:1;flex:1;-webkit-box-flex:1;box-flex:1;cursor:pointer;}
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
.j_head >div >span:nth-of-type(1){display:inline-block;width:60px;text-align:center;}
.head_cont .actives{background:#ff9900;color:#fff;border:1px solid #ff9900 !important;margin-left:2%;}
.screen,.h_btn_list> div{display:inline-block;width:100px;border:1px solid #d7e0f1;text-align:center;padding:4px 0px;border-radius:5px;margin-right:8px;}
.classification{height:30px;line-height:30px;border-top:1px solid #d7e0f1;border-right:1px solid #d7e0f1;border-left:1px solid #d7e0f1;width:300px;}
.classification >div{text-align:center;height:30px;border-right:1px solid #d7e0f1;}
.classification >div:last-child{border-right:none;}
.classification .add_active{background:#ecf0f5;border-bottom:1px solid #ecf0f5;}
.fomr_term{height:30px;line-height:30px;}

.hotel_star >div:nth-of-type(2) >div,.hotel_star >div{display:inline-block;}
.hotel_star >div:nth-of-type(1){margin-right:28px;}
.input_radio >div{margin-right:10px;}
td >input{display:none;}
td >input+label{font-weight:normal;text-indent:25px;background:url(http://test008.iwide.cn/public/js/img/radio1.png) no-repeat center left;background-size:15%;width:110px;height:30px;line-height:30px;}
td >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/radio2.png) no-repeat center left;background-size:15%;}


.input_radio >div >input{display:none;}
.input_radio >div >input+label{font-weight:normal;text-indent:25px;background:url(http://test008.iwide.cn/public/js/img/bg.png) no-repeat center left;background-size:15%;width:110px;height:30px;line-height:30px;}
.input_radio >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/bg2.png) no-repeat center left;background-size:15%;}

.classification >div,.all_open_order{cursor:pointer;}
.all_open_order{margin-right:10px;margin-top:5px;}
.template >div{text-align:center;}
.template_img{float:left;width:50px;height:50px;overflow:hidden;vertical-align:middle;margin-right:2%;}
.template_span{display:inline-block;margin-top:2px;}
.template_btn{padding:1px 8px;border-radius:3px;}
.form_con >td{padding-right:20px !important;}
.box-body{padding:0px;overflow:hidden;}
#coupons_table_length{display:none;}
.drow_list{ display:none; position:absolute;width:100%; top:100%; left:0; background:#fff; border:1px solid #e4e4e4; padding:0; max-height:300px; overflow:auto; z-index:999}
.drow_list li{ height:35px; padding-left:15px; line-height:35px; list-style:none; cursor:pointer}
.drow_list li:hover{ background:#f1f1f1}
.drow_list li.cur{background:#ff9900; color:#fff}
#drowdown:hover .drow_list{display:block}
tbody td,thead th{text-align:center;padding:5px 0;border:1px solid #d7e0f1;}
tbody td p,thead th p{margin-bottom:3px;}
thead th{font-weight:normal;}
tbody tr td:first-child{width:150px;}

tbody tr td[status=close]{background:#f8f9fb;}
tbody td p:last-child,thead th p:last-child{margin-bottom:0px;}
.bg_f8f9fb{background:#f8f9fb;}
.f_w_n{font-weight:normal;}
.border_1{border:1px solid #d7e0f1;}
.relative{position:relative;}
.absolute{position:absolute;}
.rotate_180{transform:rotate(-180deg);}
.arrow{transition:0.2s;}
.d_none{display:none;}
td,.main_menu{cursor:pointer;}


.layer{background:rgba(0,0,0,0.2); width:100%; height:100%; position:fixed; top:0; left:0; z-index:9999;display:none}
.layer >div >*{ padding:8px 12px 0 12px;}
.layer *{ vertical-align:middle}
.layer input{margin-top:0}
.layer >div{background:#fff; position:absolute; top:20%; width:550px; left:30%;border-radius:10px; padding-bottom:12px; overflow:hidden}
.layer h4{background:#00c0ef; color:#fff; margin-top:0; padding-bottom:12px;}
.layer label{padding-right:12px; font-weight:normal;}
.layer tt{display:block; font-weight:bold}
.layer .form-control{display:inline-block;/* width:450px*/}
.close_layer{float:right; cursor:pointer}
.pageloading{position:fixed; top:45%; left:50%; padding:8px 15px;line-height:50px; color:#fff; background:rgba(0,0,0,0.5); border-radius:10px; text-align:center; z-index:9999999;}
</style>
<div class="layer" id="edit_status">
    <div>
        <h4><em class="close_layer">&times;</em><span class="layertitle">修改</span></h4>
        <div ftai><tt>房态</tt><select class="form-control"><option value="1">关</option><option value="2">开</option></select></div>
        <div mass><tt>开始日期</tt><input name="startdate" type="text" date-format="yyyy-mm-dd" class="form-control dateselect"></div>
        <div mass><tt>结束日期</tt><input name="enddate" type="text" date-format="yyyy-mm-dd" class="form-control dateselect"></div>
        <div mass><tt>按星期修改</tt>
            <label><input name="week" type="checkbox" week="1"> 周一</label>
            <label><input name="week" type="checkbox" week="2"> 周三</label>
            <label><input name="week" type="checkbox" week="3"> 周二</label>
            <label><input name="week" type="checkbox" week="4"> 周四</label>
            <label><input name="week" type="checkbox" week="5"> 周五</label>
            <label><input name="week" type="checkbox" week="6"> 周六</label>
            <label><input name="week" type="checkbox" week="0"> 周日</label>
        </div>
        <div yuan><tt>房价</tt><input type="text" class="form-control"></div>
        <div kucun><tt>库存</tt><input type="text" class="form-control"></div>
        <div><button type="button" class="btn btn-block btn-info" id="preservation" >保存</button></div>
    </div>
</div>
<div style="color:#92a0ae;">
    <div class="over_x">
        <div class="content-wrapper" style="min-width:1130px;" >
            <div class="banner bg_fff p_0_20">
                <div class="f_r news"><i class="iconfont" style="font-size:22px;vertical-align:middle;margin-right:5px;">&#xe623;</i>消息<span class="news_radius bg_ff0000">8</span></div>
                价格管理/价格日历
            </div>
            <div class="contents">
                <div class="head_cont contents_list bg_fff">
                    <div class="j_head">
                        <div>
                            <span>酒店名称</span>
                            <span class="input-group w_200" style="position:relative;display:inline-flex;" id="drowdown">
                                <input placeholder="选择或输入关键字" type="text" style="color:#92a0ae;" class="form-control w_200 moba" id="search_hotel">
                                <ul class="drow_list">
                                    <li value="">碧桂园凤凰大酒店</li>
                                    <li value="">北京金茂万丽酒店</li>
                                    <li value="">上海街町酒店</li>
                                    <li value="">深圳威尼斯酒店</li>
                                    <li value="">街町酒店广州测试店</li>
                                    <li value="">广州金房卡大酒店</li>
                                </ul>
                            </span>
                            <span class="actives screen" id="search">筛选</span>
                        </div>
                    </div>
                    <div class="hotel_star clearfix">
                        <div class="">房型筛选</div>
                        <div class="input_txt input_radio">
                            <div>
                                <input type="checkbox" id="wf" name="" value="Wi-Fi"/>
                                <label for="wf">行政大床房</label>
                            </div>
                            <div>
                                <input type="checkbox" id="con_room" name="" value="会议室"/>
                                <label for="con_room">高级大床房</label>
                            </div>
                            <div>
                                <input type="checkbox" id="shuttle" name="" value="专车接送"/>
                                <label for="shuttle">无床房</label>
                            </div>
                        </div>
                    </div>
                    <div class="hotel_star clearfix">
                        <div class="">代码筛选</div>
                        <div class="input_txt input_radio">
                            <div>
                                <input type="checkbox" id="baseprice" name="" value="Wi-Fi"/>
                                <label for="baseprice">基础价格</label>
                            </div>
                            <div>
                                <input type="checkbox" id="first_offers" name="" value="会议室"/>
                                <label for="first_offers">首住优惠</label>
                            </div>
                            <div>
                                <input type="checkbox" id="evenlive" name="" value="专车接送"/>
                                <label for="evenlive">连住优惠</label>
                            </div>
                            <div>
                                <input type="checkbox" id="agreement_1" name="" value="专车接送"/>
                                <label for="agreement_1">协议价A</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="bg_fff head_cont" style="padding-right:15px;">
                    <div class="f_r" style="">
                       <button type="button" class="btn btn-info" id="before">&lt;前15天</button>
                       <input type="button" id="startdate" class="btn btn-default dateselect" value="<?php echo $yestoday;?>" style="height:34px;">
                       <button type="button" class="btn btn-info" id="after">后15天&gt;</button>
                    </div>
                    <span class="actives screen" style="margin-left:0%;">批量导出</span>
                </div>
                <div class="box-body">
                   <!--  <table class="calendar_price" border="1" bordercolor="#e4e4e4" style="width:100%;">
                    
                    </table> -->
                    <table class="border_1" style="width:100%;border-collapse:collapse;">
                        <thead class="bg_f8f9fb">
                            <tr>
                                <th>房型</th>
                                <th>
                                    <p>11-02</p>
                                    <p>周三</p>
                                </th>
                                <th>
                                    <p>11-03</p>
                                    <p>周四</p>
                                </th>
                                <th>
                                    <p>11-04</p>
                                    <p>周五</p>
                                </th>
                                <th>
                                    <p>11-05</p>
                                    <p>周六</p>
                                </th>
                                <th>
                                    <p>11-06</p>
                                    <p>周日</p>
                                </th>
                                <th>
                                    <p>11-07</p>
                                    <p>周一</p>
                                </th>
                                <th>
                                    <p>11-08</p>
                                    <p>周二</p>
                                </th>
                                <th>
                                    <p>11-09</p>
                                    <p>周三</p>
                                </th>
                                <th>
                                    <p>11-10</p>
                                    <p>周四</p>
                                </th>
                                <th>
                                    <p>11-11</p>
                                    <p>周五</p>
                                </th>
                                <th>
                                    <p>11-12</p>
                                    <p>周六</p>
                                </th>
                                <th>
                                    <p>11-13</p>
                                    <p>周日</p>
                                </th>
                                <th>
                                    <p>11-14</p>
                                    <p>周一</p>
                                </th>
                                <th>
                                    <p>11-15</p>
                                    <p>周二</p>
                                </th>
                                <th>
                                    <p>11-16</p>
                                    <p>周三</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg_fff">
                            <tr>
                                <td class="relative main_menu roomtype">行政大床房 <i class="iconfont arrow absolute rotate_180">&#xe61c;</i></td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                            </tr>
                            <tr class="d_none sub_menu" >
                                <td class="roomtype">
                                    <input type="radio" id="xz" name="12">
                                    <label for="xz">基础价格</label>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan >¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td>
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                            </tr>
                            <tr class="d_none sub_menu" >
                                <td class="bg_fff roomtype">
                                    <input type="radio" id="sw" name="12">
                                    <label for="sw">首住优惠</label>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="relative main_menu roomtype">高级大床房 <i class="iconfont arrow absolute rotate_180">&#xe61c;</i></td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p kucun>10</p>
                                </td>
                            </tr>
                            <tr class="d_none sub_menu" >
                                <td class="roomtype">
                                    <input type="radio" id="xz1" name="12">
                                    <label for="xz1">基础价格</label>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan >¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td>
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="able">
                                    <p ftai val="1">开</p>
                                    <p yuan>¥699</p>
                                    <p kucun>10</p>
                                </td>
                            </tr>
                            <tr class="d_none sub_menu" >
                                <td class="bg_fff roomtype">
                                    <input type="radio" id="sw1" name="12">
                                    <label for="sw1">首住优惠</label>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
                                </td>
                                <td status="close">
                                    <p ftai val="2">关</p>
                                    <p yuan>¥499</p>
                                    <p kucun>10</p>
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
       elem: '#startdate'
    })
}();
</script>
<script>
$(function(){
    var str='';
    $('.main_menu').click(function(){
        $(this).find('.arrow').toggleClass("rotate_180");
        var _index=$(this).parent().index()
        for(var i=0;i<12;i++){
            if($(this).parent().siblings().eq(_index+i).hasClass('sub_menu')){
                $(this).parent().siblings().eq(_index+i).slideToggle();
            }else{
                return false;
            }
        }
    });
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
<script>
    var Dom,hotel ;  // 触发弹层的元素;
    var allroom = [];
    var allprice= [];
    function fillcheckbox(dom,array){
        $(dom).html('');
        for(var i=0;i<array.length;i++){
            var html ='<label><input type="checkbox" name="'+array[i].name+'" value="'+array[i].val+'"> '+array[i].text+'</label>';
            $(dom).append(html);
        }
    }
    function getMyDay(date){
        var week; 
        if(date.getDay()==0) week="周日"
        if(date.getDay()==1) week="周一"
        if(date.getDay()==2) week="周二" 
        if(date.getDay()==3) week="周三"
        if(date.getDay()==4) week="周四"
        if(date.getDay()==5) week="周五"
        if(date.getDay()==6) week="周六"
        return week;
    }
    //初始化价格代码
    function initprice(){
        //酒店
        var tmproom = [];
        var tmpprice= [];
        hotel = $('#search_hotel').val();
        var roomcheck = new Array();
        $('input[name=setroomtype]:checked').each(function(){
            roomcheck.push($(this).val());
        });
        var pricecheck = new Array();
        $('input[name=setpricetype]:checked').each(function(){
            pricecheck.push($(this).val());
        });
        if( typeof(hotel) =='undefined'){
            alert('请选择酒店');return false;
        }
        //日期

        showtips();
        var begindate = $('#startdate').val();
        $.getJSON('<?php echo site_url('hotel/room_status/get_price_codes')?>',{'hotel':hotel,'begindate':begindate},function(datas){
            html = '<tr><th></th><th>日期</th>';
            for (var i in datas['date']) {
                html += '<th><div>' + datas['date'][i]['date'] + '</div><div>' + datas['date'][i]['week'] + '</div></th>';
            }
            html += '</tr>';
            var obj = {};
            for (var i in datas['codes']) {
                
                if( JSON.stringify(tmproom).indexOf(datas['codes'][i]['roomname'])<0){
                    obj = {};
                    obj['val']=i;
                    obj['name']='setroomtype';
                    obj['text']=datas['codes'][i]['roomname'];
                    tmproom.push(obj); 
                }
                if( roomcheck.length ==0 || $.inArray(i, roomcheck) != -1 ){
                    var style = 'style="display: table-row;"';
                }else{
                    var style = 'style="display: none;"';
                }

                html += '<tr setroomtype="'+i+'"'+ style +'><td class="roomtype">' + datas['codes'][i]['roomname'] + '</td><td><div>房态</div><div>库存</div></td>';
                for (var j in datas['date']) {

                    var nums = datas['codes'][i]['date_arr'][datas['date'][j]['date']]['nums'];
                    if(datas['codes'][i]['date_arr'][datas['date'][j]['date']]['ftai'] == '-1'){
                        html += '<td status="close" date="'+datas['date'][j]['date']+'"><div kucun>'+ nums +'</div><div ftai val="1">关</div></td>';
                    }else if(datas['codes'][i]['date_arr'][datas['date'][j]['date']]['ftai'] == '-2'){
                        html += '<td status="able" date="'+datas['date'][j]['date']+'"><div kucun>'+ nums +'</div><div ftai val="1">开</div></td>';
                    }else{
                        html += '<td status="close" date="'+datas['date'][j]['date']+'"><div kucun>'+ nums +'</div><div ftai val="1"></div></td>';
                    }
                }
                html += '</tr>';
                var sta = 'able';
                for (var j in datas['codes'][i]['codes']) {
                    if(  JSON.stringify(tmpprice).indexOf(datas['codes'][i]['codes'][j]['name'])<0){
                        obj = {};
                        obj['val']=j;
                        obj['name']='setpricetype';
                        obj['text']=datas['codes'][i]['codes'][j]['name'];
                        tmpprice.push(obj); 
                    }
                    if((roomcheck.length ==0 || $.inArray(i, roomcheck) != -1) && (pricecheck.length ==0 || $.inArray(j, pricecheck) != -1)){
                        var style = 'style="display: table-row;"';
                    }else{
                        var style = 'style="display: none;"';
                    }

                    html += '<tr setpricetype="'+ i +'"'+style+'><td class="pricetype" code="'+j+'" status="able">'+ datas['codes'][i]['codes'][j]['name']+'</td><td><div>房价</div><div>库存</div></td>';
                    for (var k in datas['date']) {
                        var price = datas['codes'][i]['codes'][j]['date_arr'][datas['date'][k]['date']]['price'];
                        var nums = datas['codes'][i]['codes'][j]['date_arr'][datas['date'][k]['date']]['nums'];
                        if ( price=='')price='-';
                        if ( nums == '')nums='-';
                        if ( price == '-' && nums == '-' ) sta = 'null';
                        else sta = 'able';
                        html += '<td status="'+sta+'" date="'+datas['date'][k]['date']+'"><div yuan>'+ price +'</div><div kucun>' + nums + '</div></td>';
                    }
                    html += '</tr>';
                }

            }

            if ( tmproom.toString()!=allroom.toString()){
                allroom = tmproom;
                fillcheckbox('.room',allroom);
            }
            if ( tmpprice.toString()!=allprice.toString()){
                allprice = tmpprice;
                fillcheckbox('.price',allprice);
            }
            $('.calendar_price').html(html);
            //绑定事件start
            $('td[status]').click(function(){
                if($(this).attr('status')=='disable')return false;
                Dom=$(this);
                $('#edit_status div[mass]').hide();
                if( Dom.parents('tr').find('td').hasClass('main_menu')){
                    console.log(Dom.parents('tr').find('main_menu'));
                    $('#edit_status div[ftai]').show();
                    $('#edit_status div[yuan]').hide();
                }else{
                    $('#edit_status div[ftai]').show();
                    $('#edit_status div[yuan]').show();
                }
                showlayer();
                        
                $('#preservation').click(function(){
                    save();
                })

            })
            $('.pricetype').click(function(){
                $('#edit_status div[ftai]').hide()
                $('#edit_status div[mass]').show();
            })
            $('.close_layer').click(function(){
                $('#edit_status').hide();
            });
            
            rmtips();
            //绑定事件end
        });
    }
    //初始化日历
    function inittable(){
        var startdate = $('#startdate').val();
        var timestamp = Date.parse(new Date(startdate + " 00:00:00")) + 24*60*60*1000*15;
        var newDate = new Date();
        newDate.setTime(timestamp);
        var enddate = newDate.getFullYear() + '-' + PrefixInteger((newDate.getMonth()+1),2) + '-' + PrefixInteger(newDate.getDate(),2);

    }
    $('.drow_list li').click(function(){
        $('#search_hotel').val($(this).text());
        $(this).addClass('cur').siblings().removeClass('cur');
    });
    $('td[status]').click(function(){
        if($(this).attr('status')=='disable')return false;
        Dom=$(this);
        $('#edit_status div[mass]').hide();
        if(  Dom.parents('tr').find('td').hasClass('main_menu')){
            $('#edit_status div[ftai]').show();
            $('#edit_status div[yuan]').hide();
        }else{
            $('#edit_status div[ftai]').show();
            $('#edit_status div[yuan]').show();
        }
        showlayer();
        $('#preservation').click(function(){
            save();
        })
    })
    $('.pricetype').click(function(){
        $('#edit_status div[ftai]').hide();
        $('#edit_status div[mass]').show();
    })
    $('.close_layer').click(function(){
        $('#edit_status').hide();
    })
    $('#startdate').change(function(){
        // alert('你选择了' +$(this).val());
        initprice()
    })
    function PrefixInteger(num, n) {
        return (Array(n).join(0) + num).slice(-n);
    }
    $('#before').click(function(){
        var now = $('#startdate').val() + " 00:00:00";
        var timestamp = Date.parse(new Date(now)) - 24*60*60*1000*15;
        var newDate = new Date();
        newDate.setTime(timestamp);
        $('#startdate').val(newDate.getFullYear() + '-' + PrefixInteger((newDate.getMonth()+1),2) + '-' + PrefixInteger(newDate.getDate(),2));
        initprice();
    })
    $('#after').click(function(){
        var now = $('#startdate').val() + " 00:00:00";
        var timestamp = Date.parse(new Date(now)) + 24*60*60*1000*15;
        var newDate = new Date();
        newDate.setTime(timestamp);
        $('#startdate').val(newDate.getFullYear() + '-' + PrefixInteger((newDate.getMonth()+1),2) + '-' + PrefixInteger(newDate.getDate(),2));
        initprice()
    })
    $('#search').click(function(){
        initprice();
    })
    function show_hide(dom,bool){
        if (bool) $(dom).show();
        else $(dom).hide();
    }
    function forprice( allprice,val ){
        for(var i=0; i<$('input[name=setpricetype]').length;i++){
            var dom =$('input[name=setpricetype]').eq(i);
            var attr = dom.attr('name');
            var _val = dom.val();
            var checked = dom.get(0).checked;
            if(checked||allprice){
                $('td[code='+_val+']').each(function(index, element) {
                    if($(this).parent().attr('setpricetype')==val)
                        $(this).parent().show();
                });
            }
        }
    }
    function forroom (allroom,allprice){
        for(var i=0; i<$('input[name=setroomtype]').length;i++){
            var dom = $('input[name=setroomtype]').eq(i);
            var attr = dom.attr('name');
            var val = dom.val();
            var checked = dom.get(0).checked;
            if(allroom) checked = allroom;
            show_hide('tr['+attr+'='+val+']',checked);
            if(checked){    
                forprice(allprice,val);
            }
        }
    }
    $('.checkbox').click(function(e){
        if(e.target.tagName!="INPUT")
        return;
        var bool =false;
        $('input[name=setroomtype]').each(function(){ if( $(this).get(0).checked) bool=true;});
        $('input[name=setpricetype]').each(function(){ if( $(this).get(0).checked) bool=true;});
        if(!bool){
            show_hide('tr[setroomtype]',true);
            show_hide('tr[setpricetype]',true);
        }else{
            show_hide('tr[setroomtype]',false);
            show_hide('tr[setpricetype]',false);
            var allroom =true;
            $('input[name=setroomtype]').each(function(){if( $(this).get(0).checked)allroom=false; });
            var allprice=true;
            $('input[name=setpricetype]').each(function(){if( $(this).get(0).checked)allprice=false; });
            forroom (allroom,allprice);
        }
    });
    function resetlayer(){  //重置弹层;
        $('#edit_status input').val('');
        $('#edit_status div[ftai] select').val(1);
        $('#edit_status input[type=checkbox]').each(function() {
            $(this).get(0).checked=true;
        });
    }
    function showlayer(){ //显示弹层;
        var kucun =Dom.find('p[kucun]').html();
        var ftai  =Dom.find('p[ftai]').html();
        var yuan  =Dom.find('p[yuan]').html();
        if(ftai!=undefined&&ftai!='-'){
            ftai='房态(当前:'+ftai+')';
            $('#edit_status div[ftai] select').val(Dom.find('p[ftai]').attr('val'));
        } else ftai='房态';
        if(kucun!=undefined&&kucun!='-'){
            $('#edit_status p[kucun] input').val(kucun);
            kucun='库存(当前:'+kucun+')';
        } else kucun='库存';
        if(yuan!=undefined&&yuan!='-'){
            $('#edit_status p[yuan] input').val(yuan);
             yuan='房价(当前:'+yuan+')';
        }
        else yuan='房价';

        $('#edit_status div[kucun] tt').html(kucun);
        $('#edit_status div[yuan] tt').html(yuan);
        $('#edit_status div[ftai] tt').html(ftai);
        $('#edit_status').show();
        /*修改标题*/
        var tmp = '修改';
        var a = Dom.parents('tr').attr('setroomtype');
        var b = Dom.parents('tr').attr('setpricetype');
        var c = Dom.index();
        tmp+=$('tr th').eq(c).text()?' - '+$('tr th').eq(c).text() +' - ':' - ';
        tmp+=Dom.parents('tr').find('.roomtype').text();
        tmp+=b?' - '+Dom.parents('tr').find('.pricetype').html():' - 所有价格代码';
        $('.layertitle').html(tmp);
        /*end*/
    }
    function save(){
        var kucun,yuan,ftai,ftaival;
        kucun = $('#edit_status div[kucun] input').val();
        yuan  = $('#edit_status div[yuan] input').val();
        ftai  = $('#edit_status div[ftai] option:selected').text();

        function add_yuan(yuan){
            if(yuan[0]!='¥'){
                return '¥'+yuan
            } 
        }
        Dom.find('p[kucun]').text(kucun);
        Dom.find('p[yuan]').text(add_yuan(yuan));
        Dom.find('p[ftai]').text(ftai);
        ftaival  = $('#edit_status div[ftai] option:selected').val();
        if(ftaival==1)Dom.attr('status','able');
        if(ftaival==2&&!Dom.hasClass('pricetype'))Dom.attr('status','close');
        if(kucun=='')kucun='-';
        if(yuan =='')yuan ='-';
        if(kucun==yuan)Dom.attr('status','null');
        
        var room_id = Dom.parents('tr').attr('setpricetype');
        var price_code = Dom.parents('tr').find('.pricetype').attr('code');
        // if(Dom.parents('tr').attr('setroomtype')!=undefined){  /*触发元素为:房型*/
        //     date = Dom.attr('date');
        //     type = ftaival;
        //     room_id = Dom.parents('tr').attr('setroomtype');
        //     $.getJSON('<?php echo site_url('hotel/room_status/save_calendar_ftai')?>',{'hotel_id':hotel,'room_id':room_id,'date':date,'type':ftaival,'room_num':kucun},function(datas){
        //         if(datas.code == 0){
        //             initprice();
        //             showtips('已保存',true);
        //         }else{
        //             showtips(datas.msg,true);
        //         }
        //     });
        // }
        // else if(Dom.hasClass('pricetype')){  /*触发元素为:价格代码*/ 
        //     var startdate = $('input[name=startdate]').val();
        //     var enddate = $('input[name=enddate]').val();
        //     var weekarray = new Array();
        //     $('input[name=week]:checked').each(function(){
        //         weekarray.push($(this).attr('week'));
        //     });
        //     $.getJSON('<?php echo site_url('hotel/room_status/save_calendar_price')?>',{'startdate':startdate,'enddate':enddate,'weekarray':weekarray,'hotel_id':hotel,'room_id':room_id,'price_code':price_code,'price':yuan,'room_num':kucun},function(datas){
        //         if(datas.code == 0){
        //             initprice();
        //             showtips('已保存',true);
        //         }else{
        //             showtips(datas.msg,true);
        //         }
        //     });
        // }
        // else{  /*触发元素为:单个单元格*/
        //     daybox = new Array();
        //     daybox[0] = Dom.attr('date');
        //     $.getJSON('<?php echo site_url('hotel/room_status/save_calendar_price')?>',{'daybox':daybox,'hotel_id':hotel,'room_id':room_id,'price_code':price_code,'price':yuan,'room_num':kucun},function(datas){
        //         if(datas.code == 0){
        //             initprice();
        //             showtips('已保存',true);
        //         }else{
        //             showtips(datas.msg,true);
        //         }
        //     });
        // }

        if(ftai=='关'){
            Dom.attr("status","close");
        }else{
            Dom.attr("status","able");
        }
        $('#edit_status').hide();
    }
    function showtips(str,autoclose){
        rmtips();
        if(str==undefined||str=='')str='正在加载中...';
        $('body').append('<div class="pageloading">'+str+'</div>');
        if(autoclose!=undefined&&autoclose==true)
            window.setTimeout(rmtips,700);
    }
    function rmtips(){
        $('.pageloading').remove();
    }
    initprice();
</script>
</body>
</html>
