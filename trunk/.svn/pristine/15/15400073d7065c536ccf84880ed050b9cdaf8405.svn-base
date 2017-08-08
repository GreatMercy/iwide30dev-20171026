<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/new/new.css">
<style>

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
    <div class="banner bg_fff p_0_20">添加／编辑集团轮播图</div>
    <div class="contents">
      <from>
        <div class="contents_list bg_fff">
          <div class="con_left"><span class="block bg_ff503f"></span>添加图片</div>
          <div class="con_right">
            <div class="hotel_star">
              <div class="">图片来源</div>
              <div class="input_txt input_radio">
                <div>
                  <input type="radio" id="star_5" name="1" value="5星/豪华">
                  <label for="star_5">本地上传</label>
                </div>
                <div>
                  <input type="radio" id="star_4" name="1" value="4星/豪华">
                  <label for="star_4">网络图片</label>
                  <span class="in_url input_txt" style="display:none;"><input type="text" placeholder="url" /></span>
                </div>
              </div>
            </div>
            <div class="jingwei carousel clearfix" style="display:none;">
              <div class="float_left">轮播图片</div>
              <div class="input_txt file_img_list" style="padding-left:4px;">
                <label id="file" class="add_img"><input class="display_none file_img" type="file" /></label>
              </div>
            </div>
            <!-- 如果是编辑集团轮播图 以下两下拉不显示
                如果是编辑酒店轮播图 以下显示第一个下拉
                如果是编辑房型轮播图 以下两下拉都显示
             -->
            <div class="jingwei">
              <div class="">关联酒店</div>
              <div class="input_txt">
                <select style="width:450px;">
                  <option>酒店12</option>
                  <option>酒店1212</option>
                  <option>酒店1212</option>
                  <option>酒店1234基本原理56</option>
                  <option>酒店12劳而无功12</option>
                  <option>酒店123456</option>
                </select>
              </div>
            </div>
            <div class="jingwei">
              <div class="">关联房型</div>
              <div class="input_txt">
                <select style="width:450px;">
                  <option>豪华大床房</option>
                  <option>行政双人房</option>
                  <option>行政房</option>
                </select>
              </div>
            </div>
            <div class="address">
              <div class="">图片描述</div>
              <div class="input_txt"><input type="text" /></div>
            </div>
            <div class="jingwei">
              <div class="">图片排序</div>
              <div class="input_txt"><input type="text" /></div>
            </div>
          </div>
        </div>
        <div class="bg_fff center" style="padding:15px;">
          <button class="fom_btn">保存代码</button>
        </div>
      </from>
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
  $(function() {
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
    //图片上传排版start
     $("#file >input").change(function(e){
             var file = this.files[0];
             var imageType = /image.*/;
             if(file.type.match(imageType)){
                 var reader = new FileReader();
                 reader.onload=function(){
                    $(".file_img_list").prepend($('<div class="add_img_box" style="float:left;width:77px;height:77px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:77px;height:77px;overflow:hidden;" src="'+reader.result+'"/><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont">&#xe635;</i></div></div>'));
              $('.add_img_box').delegate('.img_close','click',function(){
            $(this).parent().remove();
            $("#file >input").val('');
          })
                 }
                reader.readAsDataURL(file);
            }
        });

    //图片上传排版end
    $('.input_radio >div >input').change(function(){
      console.log($('.input_radio >div:nth-of-type(1) >input:checked').val());
      if($('.input_radio >div:nth-of-type(1) >input:checked').val()){
        $('.carousel').show();
      }else{
        $('.carousel').hide();
      }
      if($('.input_radio >div:nth-of-type(2) >input:checked').val()){
        $('.in_url').show();
      }else{
        $('.in_url').hide();
      }
    })
  });
</script>