<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
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
    <!-- 新版本后台 jie_h -->
    <link rel='stylesheet' href='<?php echo base_url(FD_PUBLIC) ?>/css/jie_h.css'>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="padding_20 color_333 font_12">
            <form>
                <div class="bg_fff padding_t_30" style="padding-bottom:40px;">
                    <div class="j_item margin_bottom_30">
                        <div class="flex row_line center padding_right_30 font_14 color_bfbfbf margin_bottom_25">
                            <div class=" width_100 text_right margin_right_15">预约优惠</div>
                        </div>
                        <div class="j_tiem_conter">
                            <div class="flex between margin_bottom_25">
                                <div class="flex_1 ">
                                    <div class="flex">
                                        <div class="width_100 text_right margin_right_15">所属店铺</div>
                                        <div><input class="width_300 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /></div>
                                    </div>
                                </div>
                                <div class="flex_1 flex">
                                    <div class="flex">
                                        <div class="width_100 text_right margin_right_15">商品名称</div>
                                        <div><input class="width_300 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex between margin_bottom_25">
                                <div class="flex_1">
                                    <div class="flex">
                                        <div class="width_100 text_right margin_right_15">消费时段</div>
                                        <div>
                                            <input class="none" type="checkbox" id="morning" checked />
                                            <label class="margin_right_35" for="morning">
                                                <span class="diycheckbox sub"></span>
                                                <span>上午</span>
                                            </label>
                                            <input class="none" type="checkbox" id="afternoon" />
                                            <label class="margin_right_35" for="afternoon">
                                                <span class="diycheckbox sub"></span>
                                                <span>下午</span>
                                            </label>
                                            <input class="none" type="checkbox" id="night" />
                                            <label class="margin_right_35" for="night">
                                                <span class="diycheckbox sub"></span>
                                                <span>晚上</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex_1">
                                    <div class="flex">
                                        <div class="width_100 text_right margin_right_15">展位推荐</div>
                                        <div>
                                            <input class="none" type="radio" id="yes" name="radio_1" checked />
                                            <label class="margin_right_35" for="yes">
                                                <span class="diyradio"><tt></tt></span>
                                                <span>是</span>
                                            </label>
                                            <input class="none" type="radio" id="no" name="radio_1" />
                                            <label for="no">
                                                <span class="diyradio"><tt></tt></span>
                                                <span>否</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex between margin_bottom_25">
                                <div class="flex_1">
                                    <div class="flex">
                                        <div class="width_100 text_right margin_right_15">商品分组</div>
                                        <div>
                                            <div class="flex ">
                                                <select class="min_width_152 radius_3 border_eee_1 height_30">
                                                    <option>下拉选择</option>
                                                    <option>下拉选择1</option>
                                                    <option>下拉选择2</option>
                                                </select>
                                                <!-- <div class="margin_right_15"><img src="13213.jpg"></div>
                                                <div class="flex padding_0_8 height_30 font_14 color_b69b69 radius_3 border_eee_1 bg_f6f6f6">+ 新建分组</div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="j_item margin_bottom_30">
                        <div class="flex row_line center padding_right_30 font_14 color_bfbfbf margin_bottom_25">
                            <div class=" width_100 text_right margin_right_15">库存／规格</div>
                        </div>
                        <div class="j_tiem_conter">
                            <div class="flex between margin_bottom_25">
                                <div class="flex_1">
                                    <div class="flex">
                                        <div class="width_100 text_right margin_right_15">商品规格</div>
                                        <div>
                                            <div class="aa_norms pointer flex padding_0_8 height_30 font_14 color_b69b69 radius_3 border_eee_1 bg_f6f6f6">+ 添加规格</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex wrap norms_list specifications_con">
                                <div class="width_50">
                                    <div class="flex margin_bottom_25 specifications">
                                        <div class="width_100 text_right margin_right_15">规格1:</div>
                                        <div class="">
                                            <span>规格名</span>
                                            <input class="width_130 radius_3 border_eee_1 height_30 text_indent_3" required type="text" />
                                            <i class="iconfonts cursor none font_16 margin_left_15">&#xe60b;</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="width_100 text_right margin_right_15">商品编码</div>
                                <div><input class="width_300 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /></div>
                            </div>
                        </div>
                    </div>
                    <div class="j_item margin_bottom_30">
                        <div class="flex row_line center padding_right_30 font_14 color_bfbfbf margin_bottom_25">
                            <div class="width_100 text_right margin_right_15">价格日历</div>
                        </div>
                        <div class="j_tiem_conter">
                            <div class="flex between margin_bottom_25">
                                <div class="flex_1">
                                    <div class="flex">
                                        <div class="width_100 text_right margin_right_15">价格日历</div>
                                        <div class="batch_setting pointer flex padding_0_8 height_30 font_14 color_b69b69 radius_3 border_eee_1 bg_f6f6f6">批量设置</div>
                                    </div>
                                </div>
                            </div>
                            <div class="padding_left_50 padding_right_30">
                                <div class="">
                                    <table class="date_select" style="width:100%;"  border="1" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th colspan="7">
                                                    <i class="d_last iconfonts radius_50 border_bfbfbf_1 cursor">&#xe68b;</i>
                                                    <span class="font_14 date_txt">2017  2月</span>
                                                    <i class="d_next iconfonts radius_50 border_bfbfbf_1 cursor">&#xe65b;</i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg_f8fafc">
                                                <td>SUN 日</td>
                                                <td>MON 一</td>
                                                <td>TUE 二</td>
                                                <td>WED 三</td>
                                                <td>THU 四</td>
                                                <td>FRI 五</td>
                                                <td>SAT 六</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="j_item margin_bottom_30">
                        <div class="flex row_line center padding_right_30 font_14 color_bfbfbf margin_bottom_25">
                            <div class=" width_100 text_right margin_right_15">商品信息</div>
                        </div>
                        <div class="j_tiem_conter">
                            <div class="flex between margin_bottom_25">
                                <div class="flex_1">
                                    <div class="flex">
                                        <div class="width_100 text_right margin_right_15">提前预约优惠</div>
                                        <div>
                                            <input class="none" type="radio" id="yes1" name="radio_2" checked />
                                            <label class="margin_right_35" for="yes1">
                                                <span class="diyradio"><tt></tt></span>
                                                <span>是</span>
                                            </label>
                                            <input class="none" type="radio" id="no1" name="radio_2" />
                                            <label for="no1">
                                                <span class="diyradio"><tt></tt></span>
                                                <span>否</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="j_item margin_bottom_30">
                        <div class="flex row_line center padding_right_30 font_14 color_bfbfbf margin_bottom_25">
                            <div class=" width_100 text_right margin_right_15">商品信息</div>
                        </div>
                        <div class="j_tiem_conter padding_right_30">
                            <div class="flex between margin_bottom_25">
                                <div class="flex_1">
                                    <div class="flex start">
                                        <div class="width_100 text_right margin_right_15">商品主图</div>
                                        <div class="">
                                            <div class="flex">
                                                <div class="add_img margin_right_15"></div>
                                                <span class="color_bfbfbf">缩略图建议在640 x 640像素</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex between margin_bottom_25">
                                <div class="flex_1">
                                    <div class="flex start">
                                        <div class="width_100 text_right margin_right_15">商品详情</div>
                                        <div class="flex_1 height_260 "><textarea class="w_h_100 border_eee_1 padding_10" placeholder="请在这里输入正文"></textarea></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="j_item margin_bottom_30">
                        <div class="flex row_line center padding_right_30 font_14 color_bfbfbf margin_bottom_25">
                            <div class=" width_100 text_right margin_right_15">其它</div>
                        </div>
                        <div class="j_tiem_conter">
                            <div class="flex between margin_bottom_25">
                                <div class="flex_1">
                                    <div class="flex">
                                        <div class="width_100 text_right margin_right_15">开售时间</div>
                                        <div>
                                            <input class="none" type="radio" id="yes2" name="radio_3" checked />
                                            <label class="margin_right_35" for="yes2">
                                                <span class="diyradio"><tt></tt></span>
                                                <span>立即开售</span>
                                            </label>
                                            <input class="time_selects_btn none" type="radio" id="timing" name="radio_3" />
                                            <label class="margin_right_35" for="timing">
                                                <span class="diyradio"><tt></tt></span>
                                                <span>定时售卖</span>
                                                <div class="time_selects none" >
                                                    <span>
                                                        <select class="width_130 radius_3 border_eee_1 height_30">
                                                            <option>下拉选择1</option>
                                                            <option>下拉选择2</option>
                                                            <option>下拉选择3</option>
                                                        </select>
                                                    </span>-
                                                    <span>
                                                        <select class="width_130 radius_3 border_eee_1 height_30">
                                                            <option>下拉选择1</option>
                                                            <option>下拉选择2</option>
                                                            <option>下拉选择3</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </label>
                                            <input class="none" type="radio" id="no2" name="radio_3" />
                                            <label for="no2">
                                                <span class="diyradio"><tt></tt></span>
                                                <span>不开售</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="margin_40_0">
                        <div class="padding_10_0 radius_3 font_weight font_16 color_fff bg_b69b69 width_300 center margin_auto">保存商品</div>
                    </div>
                </div>
            </form>
        </section>
    </div><!-- /.content-wrapper -->
    <div class="p_fixed color_333 none">
        <div class="flex w_h_100">
            <div class="batch_setting_con elastic_con_1 bg_fff radius_3 padding_t_20 padding_b_40 relative none">
                    <div class="absolute close_btn"><i class="iconfonts font_16">&#xe60a;</i></div>
                    <div class="ela_title font_16 center margin_bottom_45 font_weight">批量设置价格日历</div>
                    <div class="padding_r_80">
                        <div class="flex between margin_bottom_25">
                            <div class="flex_1">
                                <span class="width_130 text_right inline_block margin_right_10">起始日期</span>
                                <span><input class="radius_3 border_eee_1 height_30 text_indent_3" type="text" /></span>
                            </div>
                            <div class="flex_1">
                                <span class="width_130 text_right inline_block margin_right_10">截止日期</span>
                                <span><input class="radius_3 border_eee_1 height_30 text_indent_3" type="text" /></span>
                            </div>
                        </div>
                        <div class="flex margin_bottom_25">
                            <div class="width_130 text_right margin_right_15">执行周期</div>
                            <div class="flex_1">
                                <div class="flex between">
                                    <input class="none" type="checkbox" id="all_week" />
                                    <label class="" for="all_week">
                                        <span class="diycheckbox sub"></span>
                                        <span>全部</span>
                                    </label>
                                    <input class="none" type="checkbox" id="week_1" />
                                    <label class="" for="week_1">
                                        <span class="diycheckbox sub"></span>
                                        <span>周一</span>
                                    </label>
                                    <input class="none" type="checkbox" id="week_2" />
                                    <label class="" for="week_2">
                                        <span class="diycheckbox sub"></span>
                                        <span>周二</span>
                                    </label>
                                    <input class="none" type="checkbox" id="week_3" />
                                    <label class="" for="week_3">
                                        <span class="diycheckbox sub"></span>
                                        <span>周三</span>
                                    </label>
                                    <input class="none" type="checkbox" id="week_4" />
                                    <label class="" for="week_4">
                                        <span class="diycheckbox sub"></span>
                                        <span>周四</span>
                                    </label>
                                    <input class="none" type="checkbox" id="week_5" />
                                    <label class="" for="week_5">
                                        <span class="diycheckbox sub"></span>
                                        <span>周五</span>
                                    </label>
                                    <input class="none" type="checkbox" id="week_6" />
                                    <label class="" for="week_6">
                                        <span class="diycheckbox sub"></span>
                                        <span>周六</span>
                                    </label>
                                    <input class="none" type="checkbox" id="week_7" />
                                    <label class="" for="week_7">
                                        <span class="diycheckbox sub"></span>
                                        <span>周日</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex margin_bottom_25 start">
                            <div class="width_130 text_right margin_right_15" style="padding-top:7px;">规格库存</div>
                            <div class="flex_1">
                                <div class="flex between margin_bottom_10">
                                    <div>成人席位 <input class="width_100 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /> 元／份</div>
                                    <div>库存 <input class="width_100 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /> 份</div>
                                </div>
                                <div class="flex between">
                                    <div>儿童席位 <input class="width_100 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /> 元／份</div>
                                    <div>库存 <input class="width_100 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /> 份</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="margin_40_0">
                        <div class="batch_setting_btn padding_10_0 radius_3 font_weight font_16 color_fff bg_b69b69 width_300 center margin_auto">保存</div>
                    </div>
            </div>
            <div class="one_settings elastic_con_1 bg_fff radius_3 padding_t_20 padding_b_40 relative none">
                <form>
                    <div class="absolute close_btn"><i class="iconfonts font_16">&#xe60a;</i></div>
                    <div class="ela_title font_16 center margin_bottom_45 font_weight">设置价格</div>
                    <div class="padding_r_80">
                        <div class="flex between margin_bottom_25">
                            <div class="">
                                <span class="width_130 text_right inline_block margin_right_15">设置日期</span>
                                <span><input class="radius_3 border_eee_1 height_30 text_indent_3" required type="text" /></span>
                            </div>
                        </div>
                        <div class="flex margin_bottom_25 start">
                            <div class="width_130 text_right margin_right_15" style="padding-top:7px;">规格库存s</div>
                            <div class="flex_1">
                                <div class="flex between margin_bottom_10">
                                    <div>成人席位 <input class="width_100 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /> 元／份</div>
                                    <div>库存 <input class="width_100 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /> 份</div>
                                </div>
                                <div class="flex between">
                                    <div>儿童席位 <input class="width_100 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /> 元／份</div>
                                    <div>库存 <input class="width_100 radius_3 border_eee_1 height_30 text_indent_3" required type="text" /> 份</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="margin_40_0">
                        <div class="one_setting_btn padding_10_0 radius_3 font_weight font_16 color_fff bg_b69b69 width_300 center margin_auto">保存</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php
/* Footer Block @see footer.php */
require_once VIEWPATH. $tpl .DS .'privilege'. DS. 'footer.php';
?>
<?php
/* Right Block @see right.php */
require_once VIEWPATH. $tpl .DS .'privilege'. DS. 'right.php';
?>
</div><!-- ./wrapper -->
<?php
/* Right Block @see right.php */
require_once VIEWPATH. $tpl .DS .'privilege'. DS. 'commonjs.php';
?>
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/ckeditor/ckeditor.js"></script>
<!--kindEditor-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/kindeditor/plugins/code/prettify.css" />
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/kindeditor/kindeditor.js"></script>
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/kindeditor/plugins/code/prettify.js"></script>
<!--kindEditor-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datetimepicker/bootstrap-datetimepicker.css">
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<!--
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
-->

</body>
<script src="<?php echo base_url(FD_PUBLIC) ?>/uploadify_html5/jquery.uploadify.js"></script>
<script>
$(function(){
    var json1={
            'data':'2017/5',
            'month':[
                {'time':'2017-4-25','money':'¥892','stock':'123','psp_sid':'162'},
                {'time':'2017-4-26','money':'¥682','stock':'0','psp_sid':'162'},
                {'time':'2017-4-27','money':'682','stock':'123','psp_sid':'162'},
                {'time':'2017-4-28','money':'¥682','stock':'123','psp_sid':'162'},
                {'time':'2017-4-29','money':'¥6452','stock':'0','psp_sid':'162'},
                {'time':'2017-4-30','money':'¥132','stock':'123','psp_sid':'162'},
                {'time':'2017-4-31','money':'¥132','stock':'123','psp_sid':'162'}
            ]
        };
    //添加规格。。。
    var norms_number=1;
    $('.aa_norms').click(function(){

        norms_number++;
        var str='<div class="width_50"><div class="flex margin_bottom_25 specifications"><div class="width_100 text_right margin_right_15">规格'+norms_number+':</div><div class=""><span>规格名</span><input class="width_130 radius_3 border_eee_1 height_30 text_indent_3" name="'+norms_number+'" type="text" required /><i class="iconfonts cursor none font_16 margin_left_15">&#xe60b;</i></div></div></div>';
        $('.norms_list').append(str)
    })
    $('.specifications_con').on('click','i',function(){
        $(this).parents('.width_50').remove();
    })
    // 日历操作。。。
    $('.close_btn').click(function(){
        $('.batch_setting_con,.one_settings').fadeOut();
        $('.p_fixed').fadeOut();
    })
    $('.batch_setting').click(function(){
        $('.batch_setting_con').show();
        $('.p_fixed').fadeIn();
    });
    $('.one_setting_btn,.batch_setting_btn').click(function(){
        $('.batch_setting_con,.one_settings').fadeOut();
        $('.p_fixed').fadeOut();
    })
    $('.date_select').on('click','.one_setting',function(){
        if(!$(this).hasClass('color_bfbfbf')){
            $('.one_settings').show();
            $('.p_fixed').fadeIn();
        }
    })
    $('.d_last').click(function(){
        cleat_date();
        var date_titl=$('.date_txt').html().split("  ");
        var mm=parseInt(date_titl[1])-1;
        if(mm<1){
            mm=12;
            date_titl[0]=parseInt(date_titl[0])-1;
        }
        new_date(date_titl[0],mm);
    })
    $('.d_next').click(function(){
        cleat_date();
        var date_titl=$('.date_txt').html().split("  ");
        var mm=parseInt(date_titl[1])+1;
        if(mm>12){
            mm=1;
            date_titl[0]=parseInt(date_titl[0])+1;
        }
        new_date(date_titl[0],mm);
    })
    // 日历插件
    new_date();
    function new_date(y,m){
        var new_date=new Date();
        var y=y||new_date.getFullYear();
        var m=m||new_date.getMonth()+1;
        $('.date_txt').html(y+'  '+m+'月');
        var set_date=new Date(y,m-1);
        var weeks=set_date.getDay();    //星期几
        var datas=new Date(y,m,0).getDate();    //当月有几天
        var nmber=weeks+datas<35?nmber=5:nmber=6;
        for(var i=0;i<nmber;i++){
            var otr=$('<tr></tr>');
            for(var j=0;j<7;j++){
                var otd=$('<td  class="one_setting"></td>').append($('<p class="date_nmber"></p>')).append($('<p class="date_pice">&nbsp</p>'));
                otr.append(otd);
            }
            $('.date_select tbody').append(otr);
       }
       var otd=$('.date_select .date_nmber');
       switch(weeks){
            case 0:
                for(var i=0;i<datas;i++){
                    otd.eq(i).html(i+1);
                }
            break;
            case 1:
                for(var i=0;i<datas;i++){
                    otd.eq(i+1).html(i+1);
                }
            break;
            case 2:
                for(var i=0;i<datas;i++){
                    otd.eq(i+2).html(i+1);
                }
            break;
            case 3:
                for(var i=0;i<datas;i++){
                    otd.eq(i+3).html(i+1);
                }
            break;
            case 4:
                for(var i=0;i<datas;i++){
                    otd.eq(i+4).html(i+1);
                }
            break;
            case 5:
                for(var i=0;i<datas;i++){
                    otd.eq(i+5).html(i+1);
                }
            break;
            case 6:
                for(var i=0;i<datas;i++){
                    otd.eq(i+6).html(i+1);
                }
            break;
       }
        if(json1.data!=''||json1.data.length!=0){   //判断库存。。。
            for(var b=0;b<json1.month.length;b++){
                var indezs=parseInt(json1.month[b].time.split('-')[2])-1+weeks;
                var stock=parseInt(json1.month[b].stock);
                if(stock<=0){
                    $('.date_pice').eq(indezs).parents('td').addClass('color_bfbfbf');
                }
                $('.date_pice').eq(indezs).html(json1.month[b].money);
                $('.date_pice').eq(indezs).parents('td').attr('psp_sid',json1.month[b].psp_sid);
            }
        }
        var yy=new_date.getFullYear();
        var mm=new_date.getMonth()+1;
        var dd=new_date.getDate();
        var date_arr=json1.data.split('/');
         if(''+yy+toZoo(mm)>''+date_arr[0]+toZoo(date_arr[1])){
             $('.date_pice').parents('td').addClass('color_bfbfbf');
         }
         if(''+yy+toZoo(mm)==''+date_arr[0]+toZoo(date_arr[1])){
            for(var i=weeks;i<dd+weeks-1;i++){
                $('.date_pice').eq(i).parents('td').addClass('color_bfbfbf');
            }
         }
    }
})
function toZoo(str){  //补零
    return str<10?'0'+str:str;
}
function cleat_date(){  //清日历
    $('.date_select tbody tr').not(":first").remove();
}
</script>
</html>
