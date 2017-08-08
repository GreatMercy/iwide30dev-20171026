<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<script src="http://mp.iwide.cn/public/AdminLTE/plugins/colorpickersliders/tinycolor.min.js"></script>
<link rel="stylesheet" href="http://mp.iwide.cn/public/AdminLTE/plugins/colorpickersliders/bootstrap.colorpickersliders.min.css">
<script src="http://mp.iwide.cn/public/AdminLTE/plugins/colorpickersliders/bootstrap.colorpickersliders.min.js"></script>
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
.over_x{width:100%;overflow-x:auto;}
.border_1{border:1px solid #d7e0f1;}
.relative{position:relative;}
.absolute{position:absolute;}
.bg_fff{background:#fff;}
.bg_3f51b5{background:#3f51b5;}
.bg_ff503f{background:#ff503f;}
.bg_4caf50{background:#4caf50;}
.w_450{width:450px;}
.clearfix:after{content: "" ;display:block;height:0;clear:both;visibility:hidden;}
.display_none{display:none !important;}
.d_n{display:none;}
.m_b_20{margin-bottom:20px;}
.float_left{float:left;}
.content-wrapper{color:#7e8e9f;}
.p_0_20{padding:0 20px;}
textarea{border:1px solid #d7e0f1;}
.banner{height:50px;width:100%;line-height:50px;border-bottom:1px solid #d7e0f1;}
.contents{padding:10px 20px 20px 20px;}
.contents_list{display:table;width:100%;border:1px solid #d7e0f1;margin-bottom:10px;}
.hotel_star >div:nth-of-type(2) >div,.con_right >div >div{display:inline-block;}
.con_left{width:150px;text-align:center;border-right:1px solid #d7e0f1;display:table-cell;vertical-align:middle;}
.con_right{padding:20px 0 20px 0px;}
.con_right>div{margin-bottom:12px;}
.con_right >div >div:nth-of-type(1){width:115px;height:30px;line-height:30px;text-align:right;margin-right:10px;}
.input_txt{height:30px;line-height:30px;}
.input_txt >input{height:30px;line-height:30px;border:1px solid #d7e0f1;width:450px;text-indent:3px;}
.input_txt >select{height:30px;line-height:30px;display:inline-block;border:1px solid #d7e0f1;background:#fff;margin-right:20px;padding:0 8px;}
.input_radio >div{margin-right:10px;}
.block{display:inline-block;height:18px;width:4px;vertical-align: middle;margin-right:5px;}
.introduce{width:450px;height:150px;margin-left:4px;resize:vertical;}
.add_img{width:77px;height:77px;background:url(http://test008.iwide.cn/public/js/img/214598012363739107.png) no-repeat;background-size:100%;}
.page_url{display:none;}
.deletes{color:#689525;left:680px;cursor:pointer;}


.input_checkbox >div:nth-of-type(1){margin-right:35px;}
.input_checkbox >div >input{display:none;}
.input_checkbox >div >input+label{font-weight:normal;text-indent:25px;background:url(http://test008.iwide.cn/public/js/img/bg.png) no-repeat center left;background-size:15%;width:110px;height:30px;line-height:30px;}
.input_checkbox >div >input:checked+label{background:url(http://test008.iwide.cn/public/js/img/bg2.png) no-repeat center left;background-size:15%;}

.fom_btn{background:#ff9900;color:#fff;outline:none;border:0px;padding:6px 25px;border-radius:3px;margin:auto;display:inline-block;margin-right:6%;}
.fom_btn:last-child{margin-right:0%;}
.actives{color:#000;background:#fff;border:1px solid #d7e0f1;}
.add_img_box:hover > .img_close{display:block !important;cursor:pointer;}
.c_block{top:7px;width:16px;height:16px;left:5px;}
</style>
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
<div class="over_x">
    <div class="content-wrapper" style="min-width:1050px;">
        <div class="banner bg_fff p_0_20">自定义样式</div>
        <div class="contents">
            <from>
                <div class="contents_list bg_fff">
                    <div class="con_left"><span class="block bg_3f51b5"></span>基本配置</div>
                    <div class="con_right relative">
                        <div class="jingwei">
                            <div class="">主体颜色</div>
                            <div class="input_txt relative"><input  id="theme_color" class="c_block form-control cp-preventtouchkeyboardonshow"   type="text" placeholder="" /></div>
                            <script>
                                $("#theme_color").ColorPickerSliders({color:"#ff7200",size: "sm", placement: "bottom", hsvpanel: true, previewformat:"hex"});
                            </script>
                        </div>
                        <div class="jingwei">
                            <div class="">字体大小</div>
                            <div class="input_txt relative"><input type="text" placeholder="" /><span class="absolute" style="right:10px">px</span></div>
                        </div>
                        <div class="hotel_star clearfix">
                            <div class="float_left">默认设置</div>
                            <div class="input_txt input_checkbox" style="padding-left:4px;">
                                <div>
                                    <input type="checkbox" id="wf" name="" value="Wi-Fi">
                                    <label for="wf">使用默认颜色</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="con_room" name="" value="会议室">
                                    <label for="con_room">使用默认字体</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </from>
            <div class="bg_fff border_1 btns_list" style="padding:15px;text-align:center;">
                <button class="fom_btn">保存</button>
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
</body>
</html>
<script src="<?php echo base_url(FD_PUBLIC) ?>/uploadify/jquery.uploadify.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/areaData.js"></script>
<script type="text/javascript">
    <?php $timestamp = time();?>
    $(function(){
        $('#el_intro_img').parent().append('<input type="file" value="上传图片" id="upfiles">');
        $('#upfiles').uploadify({
            'formData'     : {
                '<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>',
                'timestamp' : '<?php echo $timestamp;?>',
                'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
            },
            'swf'      : '<?php echo base_url(FD_PUBLIC) ?>/uploadify/uploadify.swf',
            //'uploader' : '<?php echo site_url("basic/upload/hotel_upload") ?>',
            'uploader' : '<?php echo site_url('basic/uploadftp/do_upload') ?>',
            'file_post_name': 'imgFile',
            'onUploadSuccess' : function(file, data, response) {
                var res = $.parseJSON(data);
                $('#el_intro_img').val(res.url);
            }
        });
        


            
    });
</script>