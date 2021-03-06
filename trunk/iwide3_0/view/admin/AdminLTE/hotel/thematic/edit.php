<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/new/new.css">
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
<style>
.w_450{width:450px !important;border:1px solid #d7e0f1;}
.dropdown-toggle{border:0px;}
.uploadify-button {background-size:100% 100%;}
.hiddenimgs{font-size:0px;height:0px;width:0px;padding:0px;margin:0px;line-height:0px;position:absolute;top:0px;left:0px;}
.input_checkbox >div >input+label{font-weight:normal;text-indent:20px;background:url(/public/js/img/bg.png) no-repeat center left;background-size:17px;width:auto;height:30px;min-width:90px;line-height:30px;margin-right:15px;}
.input_checkbox >div >input:checked+label{background:url(/public/js/img/bg2.png) no-repeat center left;background-size:17px;}
</style>
<div class="over_x">
    <div class="content-wrapper" style="min-width: 1050px; min-height: 775px;">
        <div class="banner bg_fff p_0_20"><?php echo $breadcrumb_html; ?></div>
        <div class="contents">
            <?php echo form_open( EA_const_url::inst()->get_url('*/*/edit_post'), array('class'=>'form-horizontal','id'=>'edit_form') ); ?>
                <input type="hidden" name="tid" value="<?php if(isset($row['id'])) echo $row['id'];?>" >
                <div class="contents_list bg_fff">
                    <div class="con_left"><span class="block bg_3f51b5"></span>活动基本信息</div>
                    <div class="con_right">
                        <div class="hottel_name clearfix">
                            <div class="required">活动名称</div>
                            <div class="input_txt block_list"><input class="w_450" required name="act_name" value="<?php if(isset($row['act_name'])) echo $row['act_name'];?>" placeholder="请填写活动名称"></input></div>
                        </div>
                        
                        <div class="hottel_name clearfix">
                            <div class="required">活动规则</div>
                            <div class="input_txt block_list"><textarea required class="w_450" name="act_intro" placeholder="请填写活动规则" style="width:320px;height:150px;"><?php if(isset($row['act_intro'])) echo $row['act_intro'];?></textarea></div>
                        </div>
                        <div class="hottel_name ">
                            <div class="required">活动时间</div>
                            <div class="input_txt"><span class="t_time"><input required name="start_time" type="text" id="datepicker" class="datepicker moba" value="<?php if(isset($row['start_time'])) echo $row['start_time'];?>"></span>
                            <font>至</font>
                            <span class="t_time"><input required name="end_time" type="text" id="datepicker2" class="datepicker moba" value="<?php if(isset($row['end_time'])) echo $row['end_time'];?>"></span></div>
                        </div>
                        <div class="jingwei clearfix img_upload">
                            <div class="required">广告背景图</div>
                            <div class="file_img_list" style="height:auto;position:relative;">
                            <input required class="form-control hiddenimgs" name="intro_img" id="el_intro_img" value="<?php if(isset($row['intro_img'])) echo $row['intro_img']; else echo 'http://7n.cdn.iwide.cn/public/hotel/public/images/thematic.jpg' ?>">
                                <div><div class="add_img_box" style="float:left;width:640px;height:160px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:640px;height:160px;overflow:hidden;" src="<?php if(isset($row['intro_img'])) echo $row['intro_img']; else echo 'http://7n.cdn.iwide.cn/public/hotel/public/images/thematic.jpg' ?>"/><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont">&#xe635;</i></div></div><div class="add_img_box" style="float:left;width:77px;height:77px;position:relative;margin-right:20px;"><div style="border-radius:50%;overflow:hidden;"></div></div></div>
                                <div class="clearfix">
                                    <div id="file"></div>
                                </div>
                            </div><br>
                        </div>
                        <div class="hottel_name clearfix">
                            <div class="">排序</div>
                            <div class="input_txt block_list"><input class="w_450" name="sort" value="<?php if(isset($row['sort'])) echo $row['sort'];?>" placeholder="数值越大，排序越前"></input></div>
                        </div>
                    </div>
                </div>
                
                <div class="contents_list bg_fff">
                    <div class="con_left"><span class="block bg_ff503f"></span>日历控制</div>
                    <div class="con_right">
                        <div class="hottel_name ">
                            <div class="required">提前预定天数</div>
                            <div class="input_txt"><input class="" style="width:80px;"  min="0"  type="number" name="pre_days" value="<?php if(isset($row['pre_days']) && $row['pre_days']!=0) echo $row['pre_days'];?>" />天</div>
                        </div>
                        <div class="hottel_name ">
                            <div class="required">连住几天</div>
                            <div class="input_txt"><input class="" style="width:80px;"  min="1"  type="number" name="min_days" value="<?php if(isset($row['min_days']) && $row['min_days']!=0) echo $row['min_days'];?>" />天</div>
                        <button id="get_codes" type="button">筛选价格代码</button>
                        </div>
                        
                    </div>
                </div>

                <div class="contents_list bg_fff">
                    <div class="con_left"><span class="block bg_ff503f"></span>适用范围</div>
                    <div class="con_right">
                    <div class="hotel_star clearfix">
                        <div class="required">价格代码</div>
                        <div class="hotel_star clearfix" id="codes" style="width:920px;">
                            <div class="input_checkbox" id="some_code" style="display:flex;flex-wrap:wrap;">
                                
                            </div>
                        </div>
                        </div>
                      <div class="hotel_star clearfix">
                          <div class="required">适用门店</div>
                            <button style="display:none;" id="get_hotelids" type="button" >获取门店</button>
                          <div class="hotel_star clearfix" id="hotelids" style="width:920px;">
                                <div class="input_checkbox" id="some_hotel" style="display:flex;flex-wrap:wrap;">
                                    
                                </div>
                            </div>
                      </div>
                    </div>
                </div>
                <div class="bg_fff" style="padding:15px;text-align:center;">
                    <button type="submit" class="fom_btn" style="display:none;">保存</button>
                </div>
            </form>
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

<!--
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
-->
<script src="<?php echo base_url(FD_PUBLIC) ?>/uploadify_html5/jquery.uploadify.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datatables/layDate.js"></script>
<script>
;!function(){
  laydate({
     elem: '#datepicker',
     format: 'YYYY-MM-DD hh:mm:ss',
     istime: true
  })
  laydate({
     elem: '#datepicker2',
     format: 'YYYY-MM-DD hh:mm:ss',
     istime: true
  })
}();
</script>
<script type="text/javascript">
    var submitting = false;
        code_arr = <?php if(isset($row['price_codes'])) echo json_encode($row['price_codes']); else echo '[]';?>;
        hotelid_arr = <?php if(isset($row['hotelids'])) echo json_encode($row['hotelids']); else echo '[]';?>;
    function get_hotelids () {
        $('#some_hotel').html('');
        if(submitting){
            return;
        }
        submitting = true;
        var codes =[]; 
        $('input[name="code_arr[]"]:checked').each(function(){ 
            codes.push($(this).val()); 
        });
        $.getJSON('<?php echo site_url('hotel/thematic/ajax_hotel_filter')?>',{'codes':codes},function(datas){
            var _html = '';
            var flag_c = false;
            for (var i = datas.data.length - 1; i >= 0; i--) {
                _html +='<div><input type="checkbox" id="'+datas.data[i]['hotel_id']+'" name="hotel_arr[]" value="'+datas.data[i]['hotel_id']+'" ';
                if($.inArray(datas.data[i]['hotel_id'], hotelid_arr)!= -1 ){
                    _html +=' checked ';
                    flag_c = true;
                }
                _html += '/><label for="'+datas.data[i]['hotel_id']+'" >'+datas.data[i]['name']+'</label></div>';
                
            };
            if(datas.data.length == 0){
                _html = '没有符合的门店！';
            }
            $('#some_hotel').html(_html);
            $('#get_hotelids').hide();
            $('#some_hotel >div').click(function(){
                var hotelids =[]; 
                $('input[name="hotel_arr[]"]:checked').each(function(){ 
                    hotelids.push($(this).val()); 
                });
                if(hotelids.length>0){
                    $('.fom_btn').show();
                }else{
                    $('.fom_btn').hide();
                }
            });
            submitting = false;
            if(flag_c){
                $('.fom_btn').show();
            }
        },'json');
    }
    function get_codes (init) {
        $('#some_code').html('');
        if(submitting){
            return;
        }
        submitting = true;
        var pre_days = $('input[name=pre_days]').val();
        var min_days = $('input[name=min_days]').val();
        if((pre_days==''||pre_days==0) && (min_days==0 || min_days=='')){
            alert('日历控制至少填写一项');
            submitting = false;
            return;
        }
        if(pre_days<0 || min_days<0){
            alert('天数必须大于0');
            submitting = false;
            return;
        }
        $.getJSON('<?php echo site_url('hotel/thematic/ajax_pricecode_filter')?>',{'pre_days':pre_days,'min_days':min_days},function(datas){

            var _html = '';
            var flag = false;
            for (var i = datas.data.length - 1; i >= 0; i--) {
                _html +='<div><input type="checkbox" id="code'+datas.data[i]['price_code']+'" name="code_arr[]" value="'+datas.data[i]['price_code']+'" ';
                if($.inArray(datas.data[i]['price_code'], code_arr) != -1 ){
                    _html +=' checked ';
                    flag = true;
                }
                _html += '/><label for="code'+datas.data[i]['price_code']+'" >'+datas.data[i]['price_name']+'</label></div>';
                
            };
            if(datas.data.length == 0){
                _html = '没有符合的价格代码！';
            }
            $('#some_code').html(_html);
            $('#get_codes').hide();
            if(flag){
                $('#get_hotelids').show();
            }
            $('#some_code >div').click(function(){
                var codes =[]; 
                $('input[name="code_arr[]"]:checked').each(function(){ 
                    codes.push($(this).val()); 
                });
                if(codes.length>0){
                    $('#get_hotelids').show();
                }else{
                    $('#get_hotelids').hide();
                }
                $('#some_hotel').html('');
                $('.fom_btn').hide();
            });
            submitting = false;
            if(init && flag){
                get_hotelids ();
            }
        },'json');
    }
    
    <?php $timestamp = time();?>
    $(function() {
        <?php if(isset($row)){?>
        get_codes(true);
        <?php }?>
        $('#get_hotelids').click(function() {
            get_hotelids();
        });
        $('#get_codes').click(function() {
            get_codes();
        });
         $('input[name=pre_days],input[name=min_days]').bind("input propertychange change",function(){
            $('#get_codes').show();
            $('#some_code').html('');
            $('#some_hotel').html('');
            $('.fom_btn').hide();
        });
        $('#file').uploadify({
            'formData'     : {
                '<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>',
                'timestamp' : '<?php echo $timestamp;?>',
                'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
            },
            'swf'      : '<?php echo base_url(FD_PUBLIC) ?>/uploadify/uploadify.swf',
            //'uploader' : '<?php echo site_url("basic/upload/hotel_upload") ?>',
            'uploader' : '<?php echo site_url('basic/uploadftp/do_upload') ?>',
            'fileObjName': 'imgFile',
            'buttonImage':"<?php echo base_url(FD_PUBLIC) ?>/js/img/add_bg.jpg",
            'fileTypeExts':'*.jpg;*.jpeg;*.gif;*.png',//文件类型
            'height':160,
            'width':640,
            'fileSizeLimit':'200', //限制文件大小
            'onUploadSuccess' : function(file, data, response) {
                var res = $.parseJSON(data);
                $('#el_intro_img').val(res.url);
                $('.add_img_box').remove();
                 $(".file_img_list").prepend($('<div><div class="add_img_box" style="float:left;width:640px;height:160px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:640px;height:160px;overflow:hidden;" src="'+res.url+'"/><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont">&#xe635;</i></div></div><div class="add_img_box" style="float:left;width:77px;height:77px;position:relative;margin-right:20px;"><div style="border-radius:50%;overflow:hidden;"></div></div></div>'));
                 $('#file').hide();
                $('.add_img_box').delegate('.img_close','click',function(){
                    $('#file').show();
                    $(this).parent().parent().remove();
                    $("#el_intro_img").val('');
                })
                
            }
        });
        $('.add_img_box').delegate('.img_close','click',function(){
            $('#file').show();
            $(this).parent().parent().remove();
            $("#el_intro_img").val('');
        })
            $('#file').hide();
    });
</script>

</body>
</html>
