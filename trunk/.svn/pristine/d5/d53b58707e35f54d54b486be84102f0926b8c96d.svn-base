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
<style>
@font-face {
  font-family: 'iconfont';
  src: url('<?php echo base_url(FD_PUBLIC) ?>/newfont/iconfont.eot');
  src: url('<?php echo base_url(FD_PUBLIC) ?>/newfont/iconfont.eot?#iefix') format('embedded-opentype'),
  url('<?php echo base_url(FD_PUBLIC) ?>/newfont/iconfont.woff') format('woff'),
  url('<?php echo base_url(FD_PUBLIC) ?>/newfont/iconfont.ttf') format('truetype'),
  url('<?php echo base_url(FD_PUBLIC) ?>/newfont/iconfont.svg#iconfont') format('svg');
}
.iconfont{
  font-family:"iconfont" !important;
  font-size:16px;font-style:normal;
  -webkit-font-smoothing: antialiased;
  -webkit-text-stroke-width: 0.2px;
  -moz-osx-font-smoothing: grayscale;
}
.over_x{width:100%;overflow-x:auto;}
.w_450{width:450px !important;border:1px solid #d7e0f1;}
.bg_fff{background:#fff;}
.bg_3f51b5{background:#3f51b5;}
.bg_ff503f{background:#ff503f;}
.bg_4caf50{background:#4caf50;}
.clearfix:after{content: "" ;display:block;height:0;clear:both;visibility:hidden;}
.display_none{display:none !important;}
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
.con_right >div >div:nth-of-type(1){width:115px;height:30px;line-height:30px;text-align:center;}
.input_txt{height:30px;line-height:30px;}
.input_txt >input{height:30px;line-height:30px;border:1px solid #d7e0f1;width:450px;text-indent:3px;}
.input_txt >select{height:30px;line-height:30px;display:inline-block;border:1px solid #d7e0f1;background:#fff;margin-right:20px;padding:0 8px;}
.input_radio >div{margin-right:28px;}
.input_radio >div >input{display:none;}
.input_radio >div >input+label{font-weight:normal;text-indent:25px;background:url(<?php echo base_url(FD_PUBLIC) ?>/js/img/radio1.png) no-repeat center left;background-size:13%;width:155px;height:30px;line-height:30px;}
.input_radio >div >input:checked+label{background:url(<?php echo base_url(FD_PUBLIC) ?>/js/img/radio2.png) no-repeat center left;background-size:13%;}
.block{display:inline-block;height:18px;width:4px;vertical-align: middle;margin-right:5px;}
.introduce{width:450px;height:150px;margin-left:4px;resize:vertical;}
.add_img{width:77px;height:77px;background:url(<?php echo base_url(FD_PUBLIC) ?>/js/img/214598012363739107.png) no-repeat;background-size:100%;margin-right:20px;float:left;}

.input_checkbox >div >input{display:none;}
.input_checkbox >div >input+label{font-weight:normal;text-indent:25px;background:url(<?php echo base_url(FD_PUBLIC) ?>/js/img/bg.png) no-repeat center left;background-size:15%;width:110px;height:30px;line-height:30px;}
.input_checkbox >div >input:checked+label{background:url(<?php echo base_url(FD_PUBLIC) ?>/js/img/bg2.png) no-repeat center left;background-size:15%;}

.fom_btn{background:#ff9900;color:#fff;outline:none;border:0px;padding:6px 25px;border-radius:3px;margin:auto;display:block;}
.add_img_box:hover > .img_close{display:block !important;cursor:pointer;}
#file >input{text-indent:-9999px; height:80px;line-height:60px;width:80px;background-image:url("<?php echo base_url(FD_PUBLIC) ?>/js/img/upload.png");}
.f_l{float:left;}
.block_list{margin-left:4px;}
.block_list>div{margin-bottom:10px;}
.block_list>div:last-chlid{margin-bottom:0px;}
.clearfix:after{content:" ";display:block;clear:both;height:0;}
.btn_number+label{width:70px !important;background-size:30% !important;}
.btn_number:checked+label{background-size:30% !important;}
.btn_number+label+div{display:none}
.btn_number:checked+label+div{display:inline-block;}
.w_450 .dropdown-toggle{background:#fff;border:0px;}
</style>

<?php
    // 生成csrf表单数据
    $token_name = $this->security->get_csrf_token_name();
    $token = $this->security->get_csrf_hash();
    $pk= $model->table_primary_key();
?>

<div class="over_x">
    <div class="content-wrapper" style="min-width: 1050px; min-height: 775px;">
        <div class="banner bg_fff p_0_20">编辑拼团活动or新增拼团活动</div>
        <div class="contents">
            <form action="<?php echo Soma_const_url::inst()->get_url('*/*/edit_post'); ?>" method="post">
                <input type="hidden" name="<?php echo $pk; ?>" value="<?php echo $model->m_get($pk); ?>" style="display:none;">
                <input type="hidden" name="<?php echo $token_name; ?>" value="<?php echo $token; ?>" style="display:none;">
                <input type="hidden" name="act_type" value="<?php if($model->m_get('act_type') != '') { echo $model->m_get('act_type'); } else { echo $model::ACT_TYPE_GROUPON; } ?>" style="display:none;">
                <div class="contents_list bg_fff">
                    <div class="con_left"><span class="block bg_3f51b5"></span>基本信息</div>
                    <div class="con_right">
                        <div class="hottel_name ">
                            <div class="">公众号</div>
                            <div class="input_txt">
                                <select id="inter_ids" class="selectpicker  w_450" data-live-search="true" name="inter_id">
                                    <?php foreach($fields_config['inter_id']['select'] as $k => $v): ?>
                                        <option value="<?php echo $k; ?>" <?php if($k == $model->m_get('inter_id')):?> select="selected" <?php endif; ?> ><?php echo $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <span>当前账号关联多公众号才能显示</span>
                        </div>
                        <!-- <div class="hottel_name ">
                            <div class="">公众号</div>
                            <div class="input_txt"><input type="text" name="cat_name" value=""></div><span>当前账号关联多公众号才能显示</span>
                        </div> -->
                        <div class="hottel_name ">
                            <div class="">酒店</div>
                            <div class="input_txt">
                                <select id="hotel_ids" class="selectpicker w_450" data-live-search="true" name="hotel_id">
                                    <?php foreach ($fields_config['hotel_id']['select'] as $k => $v): ?>
                                        <option value="<?php echo $k; ?>" <?php if($k == $model->m_get('hotel_id')):?> select="selected" <?php endif; ?> ><?php echo $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <span>当前账号关联多公众号才能显示</span>
                        </div>
                    </div>
                </div>
                <link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/bootstrap-select/bootstrap-select.min.css">
                <script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/bootstrap-select/bootstrap-select.min.js"></script>
                <script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/bootstrap-select/i18n/defaults-zh_CN.min.js"></script>
                <div class="contents_list bg_fff">
                    <div class="con_left"><span class="block bg_ff503f"></span>活动信息</div>
                    <div class="con_right">
                        <div class="hottel_name ">
                            <div class="">活动名称</div>
                            <div class="input_txt"><input type="text" name="act_name" value="<?php echo $model->m_get('act_name'); ?>"></div>
                        </div>
                        <div class="hottel_name ">
                            <div class="">活动商品</div>
                            <div class="input_txt">
                                <select id="product_ids" class="selectpicker w_450" data-live-search="true" name="product_id">
                                    <?php foreach ($fields_config['product_id']['select'] as $k => $v): ?>
                                        <option value="<?php echo $k; ?>" <?php if($k == $model->m_get('product_id')):?> select="selected" <?php endif; ?> ><?php echo $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="hottel_name ">
                            <div class="">拼团价</div>
                            <div class="input_txt"><input type="text" name="group_price" value="<?php echo $model->m_get('group_price'); ?>"></div>
                        </div><!-- 
                        <div class="hottel_name">
                            <div class="">价格</div>
                            <div class="input_txt"><input type="text" style="width:200px" name="cat_name" value=""><input type="text" style="width:200px;margin-left: 50px;" name="cat_name" value="" placeholder="原价：999"></div>
                        </div> -->
                        <div class="hottel_name ">
                            <div class="">拼团人数</div>
                            <div class="input_txt"><input type="number" name="group_count" value="<?php echo $model->m_get('group_count'); ?>" placeholder="一般拼团人数不超100人 特别热门活动可以适应调高"></div>
                        </div>
                        <div class="hottel_name ">
                            <div class="">拼团天数</div>
                            <div class="input_txt"><input type="number" name="group_deadline" step="1" min="1" max="7" value="<?php echo $model->m_get('group_deadline'); ?>">份</div>
                        </div>

                        <div class="jingwei clearfix img_upload">
                            <div class="float_left">缩略图</div>
                            <input id="banner_url_p" type="text" name="banner_url_p" value="<?php echo $model->m_get('banner_url'); ?>" style="display: none;">
                            <div class="file_img_list">
                                <div class="clearfix">
                                    <div id="file" <?php if($model->m_get('banner_url') && $model->m_get('banner_url') != ''): ?> style="display: none;" <?php endif; ?>><input type="file" placeholder="" /></div>
                                </div><br/>
                                <div><span>1.最多售出数量=购买人数*限购数量。   </span><span>2.缩略图建议尺寸640*640像素</span></div>
                                <?php if($model->m_get('banner_url') && $model->m_get('banner_url') != ''): ?>
                                    <div><div class="add_img_box" style="float:left;width:77px;height:77px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:77px;height:77px;overflow:hidden;" src="<?php echo $model->m_get('banner_url'); ?>"/><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont">&#xe635;</i></div></div><div class="add_img_box" style="float:left;width:77px;height:77px;position:relative;margin-right:20px;"><div style="border-radius:50%;overflow:hidden;"><img style="width:77px;height:77px;overflow:hidden;" src="<?php echo $model->m_get('banner_url'); ?>"/></div></div></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
<!-- 
                <div class="contents_list bg_fff">
                    <div class="con_left"><span class="block bg_ff503f"></span>商品详情</div>
                    <div class="con_right">
                        <div class="hottel_name ">
                            <div class="f_l">商品内容</div>
                            <div class="block_list">
                                <div class="input_txt"><input type="text" style="width:200px" name="cat_name" value="" placeholder="内容"><input type="number" style="width:200px;margin-left: 50px;" name="cat_name" value="" placeholder="数量"></div>
                                <div class="input_txt"><input type="text" style="width:200px" name="cat_name" value="" placeholder="内容"><input type="number" style="width:200px;margin-left: 50px;" name="cat_name" value="" placeholder="数量"></div>
                                <div class="input_txt"><input type="text" style="width:200px" name="cat_name" value="" placeholder="内容"><input type="number" style="width:200px;margin-left: 50px;" name="cat_name" value="" placeholder="数量"></div>
                            </div>
                        </div>
                        <div class="hottel_name clearfix">
                            <div class="f_l">订购须知</div>
                            <div class="input_txt block_list"><textarea class="" name="" id="" placeholder="" style="width:796px;height:230px;" ></textarea></div>
                        </div>
                        <div class="hottel_name clearfix">
                            <div class="f_l">图文详情</div>
                            <div class="input_txt block_list"><textarea class="form-control" name="img_detail" id="el_order_notice" placeholder="订购须知" style="display: none;"></textarea></div>
                        </div>
                    </div>
                </div> -->

                <div class="contents_list bg_fff">
                    <div class="con_left"><span class="block bg_ff503f"></span>商品属性</div>
                    <div class="con_right">
                        
                        <link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datetimepicker/bootstrap-datetimepicker.css">
                        <script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
                        <script src="<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
                        <div class="hottel_name ">
                            <div class="">开始时间</div>
                            <div class="input_txt"><input class="form-control" type="text" name="start_time" id="el_start_time" value="<?php echo $model->m_get('start_time'); ?>"></div>
                        </div>

                        <script type="text/javascript">
                        $("#el_start_time").datetimepicker({
                            format:"yyyy-mm-dd hh:ii:ss", language: "zh-CN",clearBtn: false,todayBtn: false,orientation: "auto left",
                        });
                        </script>
                        <div class="hottel_name ">
                            <div class="">结束时间</div>
                            <div class="input_txt"><input class="form-control" type="text" name="end_time" id="el_end_time" value="<?php echo $model->m_get('end_time'); ?>"></div>
                        </div>
                        <script type="text/javascript">
                        $("#el_end_time").datetimepicker({
                            format:"yyyy-mm-dd hh:ii:ss", language: "zh-CN",clearBtn: false,todayBtn: false,orientation: "auto left",
                        });
                        </script>
                    </div>
                </div>
                <div class="contents_list bg_fff">
                    <div class="con_left"><span class="block bg_4caf50"></span>其他</div>
                    <div class="con_right">
                        <div class="jingwei">
                            <div class="">活动状态</div>
                            <div class="input_txt">
                                <select style="width:450px;" name="status">
                                    <option value="<?php echo Soma_base::STATUS_TRUE; ?>" <?php if($model->m_get('status') == Soma_base::STATUS_TRUE): ?> selected <?php endif; ?>>有效</option>
                                    <option value="<?php echo Soma_base::STATUS_FALSE; ?>" <?php if($model->m_get('status') == Soma_base::STATUS_FALSE): ?> selected <?php endif; ?>>无效</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg_fff" style="padding:15px;">
                    <button class="fom_btn">保存活动</button>
                </div>
            </form>
        </div>
    </div>
</div>
  <!-- <div class="content-wrapper">
    <section class="content-header">
      <h1><?php echo isset($breadcrumb_array['action'])? $breadcrumb_array['action']: ''; ?>132456
        <small></small>
      </h1>
      <ol class="breadcrumb"><?php echo $breadcrumb_html; ?></ol>
    </section>
    <section class="content">

<?php echo $this->session->show_put_msg(); ?>
<?php $pk= $model->table_primary_key(); ?>
<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo ( $this->input->post($pk) ) ? '编辑': '新增'; ?>信息</h3>
	</div>
    
    <div class="tabbable " id="top_tabs">
        <ul class="nav nav-tabs">
            <li id="top_tabs_1" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-list-alt"></i> 基本信息 </a></li>
            <?php if($model->m_get($pk) && !$update_order_attr): ?>
            <li id="top_tabs_2"><a href="#tab2" data-toggle="tab"><i class="fa fa-image"></i> 产品相册 </a></li>
            <li id="top_tabs_3"><a href="#tab3" data-toggle="tab"><i class="fa fa-link"></i> 关联分类 </a></li>
            <li id="top_tabs_4"><a href="#tab4" data-toggle="tab"><i class="fa fa-link"></i> 关联皮肤 </a></li>
            <?php endif; ?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
        	<?php 
            $url = Soma_const_url::inst()->get_url('*/*/edit_post');
            if($update_order_attr) { $url = Soma_const_url::inst()->get_url('*/*/update_post'); }
        	echo form_open( $url, array('class'=>'form-horizontal','enctype'=>'multipart/form-data'), array($pk=>$model->m_get($pk) ) ); ?>
        		<div class="box-body">
                    <?php foreach ($fields_config as $k=>$v): ?>
                        
                        <?php if($k == 'price_package'): ?>
                            <div class="form-group  has-feedback">
                                <label id="label_price_package" for="el_price_package" class="col-sm-2 control-label">微信价</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                       <div class="input-group-addon">￥</div>
                                       <input type="price" class="form-control" name="price_package" id="el_price_package" placeholder="微信价" value="<?php echo $model->m_get($k) ? $model->m_get($k) : $v['form_default']; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>

        				<?php 
                        if($check_data==FALSE) echo EA_block_admin::inst()->render_from_element($k, $v, $model); 
                        else echo EA_block_admin::inst()->render_from_element($k, $v, $model, FALSE); 
                        ?>

                        <?php endif; ?>
        			<?php endforeach; ?>
                    <?php if(!$update_order_attr && $compose): ?>
                        <?php foreach ($compose as $kk => $vv): ?>
                            <div class="form-group ">
                                <label for="el_order_notice" class="col-sm-2 control-label">商品内容</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control " name="compose[<?php echo $kk; ?>][content]" id="el_compose_content_<?php echo $kk; ?>" placeholder="内容" value="<?php echo $vv['content']; ?>">
                                </div>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control " name="compose[<?php echo $kk; ?>][num]" id="el_compose_num_<?php echo $kk; ?>" placeholder="数量" value="<?php echo $vv['num']; ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
        		</div>
		<div class="box-footer ">
            <div class="col-sm-4 col-sm-offset-4">
                <button type="reset" class="btn btn-default">清除</button>
                <button type="submit" class="btn btn-info pull-right">保存</button>
            </div>
		</div>
	<?php echo form_close() ?>
</div>        <?php if($model->m_get($pk)): ?>
                    <div class="tab-pane" id="tab2">
                        <div class="box-body">
                    <?php echo form_open( Soma_const_url::inst()->get_url('*/*/edit_focus'), array('class'=>'form-horizontal','enctype'=>'multipart/form-data' ), array($pk=>$model->m_get($pk), 'inter_id' =>$model->m_get('inter_id') ) ); ?>
                            <br/>
                            <div class="form-group ">
                                <label for="el_gallery" class="col-sm-2 control-label">上传图片</label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control " name="gallery" id="el_gallery" value="">
                                    <span class="input-group-addon">图片大小必须< 1MB</span>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="el_gry_intro" class="col-sm-2 control-label">图片描述</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control " name="gry_intro" id="el_gry_intro" value="">
                                </div>
                            </div>
                            <br/>

        <?php if( count($gallery)>0 ): ?>
                            <div id="myCarousel" class="carousel slide col-sm-8 col-sm-offset-2 ">
                                <ol class="carousel-indicators">
                                <?php $k=0; foreach($gallery as $v): ?>
                                    <li data-target="#myCarousel" data-slide-to="<?php echo $k ?>" class="<?php echo ($k==0)? 'active': '';?> "></li>
                                <?php $k++; endforeach; ?>
                                </ol>
                                <div class="carousel-inner">
                                <?php $k=0; foreach($gallery as $v): ?>
                                    <div class="item <?php echo ($k==0)? 'active': '';?>">
                                        <img src="<?php echo $v['gry_url'] ?>" />
                                        <div class="carousel-caption"><p><?php echo $v['gry_intro'] ?></p></div>
                                    </div>
                                <?php $k++; endforeach; ?>
                                </div>
                                <a class="carousel-control left" href="#myCarousel" data-slide="prev"><i class="fa fa-chevron-left"></i>&nbsp;</a>
                                <a class="carousel-control right" href="#myCarousel" data-slide="next"><i class="fa fa-chevron-right"></i>&nbsp;</a>
                            </div>
                            <div class="carousel slide col-sm-2">
                                <?php $k=1; foreach($gallery as $v): ?>
                                    <div class="checkbox"><input type="checkbox" name="del_gallery[]" value="<?php echo $v['gry_id'] ?>" /> 删除第<?php echo $k ?>张？</div>
                                <?php $k++; endforeach; ?>
                                <br/><br/><button type="submit" class="btn btn-info" >保存</button>
                            </div>
        <?php else: ?>
                        <div class="box-footer ">
                            <div class="col-sm-4 col-sm-offset-4">
                                <button type="submit" class="btn btn-info pull-right">保存</button>
                            </div>
                        </div>
        <?php endif; ?>

            <?php echo form_close() ?>
                        </div>
                       
                    </div>
            <?php endif; ?>

        </section>
      </div> -->
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

<!--
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
-->
<script src="<?php echo base_url(FD_PUBLIC) ?>/uploadify/jquery.uploadify.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/areaData.js"></script>
<script type="text/javascript">
        $(function() {
            // $('#coupon_ids').change(function(){
            //     $('#coupon_val').val($(this).val());
            //     //str=$('#coupon_val').val();
            //     console.log($(this).val());
            //     // console.log(str);
            // });
            $('#inter_ids').selectpicker({
                'selectedText': 'cat'
            });
            var inter_id = "<?php echo $model->m_get('inter_id'); ?>";
            if(inter_id!=""){
                $('#inter_ids').selectpicker('val', inter_id);
            }
            $('#hotel_ids').selectpicker({
                'selectedText': 'cat'
            });
            var hotel_id = "<?php echo $model->m_get('hotel_id'); ?>";
            if(hotel_id!=""){
                $('#hotel_ids').selectpicker('val', hotel_id);
            }
            $('#product_ids').selectpicker({
                'selectedText': 'cat'
            });
            var act_pid = "<?php echo $model->m_get('product_id'); ?>";
            if(act_pid!=""){
                $('#product_ids').selectpicker('val', act_pid);
            }
        // $('#el_intro_img').parent().append('<input type="file" value="上传图片" id="upfiles">');
        // $('#file').uploadify({
        //     'formData'     : {
        //         'csrf_token':'353b2b847342c768ab7812c1c11992c6',
        //         'timestamp' : '1486105747',
        //         'token'     : 'd13a9d560f123d5c1cc8cd117a951065'
        //     },
        //     'swf'      : '<?php echo base_url(FD_PUBLIC) ?>/uploadify/uploadify.swf',
        //     //'uploader' : 'http://test008.iwide.cn/index.php/basic/upload/hotel_upload',
        //     'uploader' : 'http://test008.iwide.cn/index.php/basic/uploadftp/do_upload',
        //     'file_post_name': 'imgFile',
        //     'buttonImage':"<?php echo base_url(FD_PUBLIC) ?>/js/img/upload.png",
        //     'height':80,
        //     'width':80,
        //     'onUploadSuccess' : function(file, data, response) {
        //         var res = $.parseJSON(data);
        //         $('#star_4').val(res.url);
        //         $('.add_img_box').remove();
        //         $(".file_img_list").append($('<div"><div class="add_img_box" style="float:left;width:77px;height:77px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:77px;height:77px;overflow:hidden;" src="'+res.url+'"/><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont">&#xe635;</i></div></div><div class="add_img_box" style="float:left;width:77px;height:77px;position:relative;margin-right:20px;"><div style="border-radius:50%;overflow:hidden;"><img style="width:77px;height:77px;overflow:hidden;" src="'+res.url+'"/></div></div></div>'));
        //     },
        // });

         //图片上传排版start
         $("#file >input").change(function(e){
             var file = this.files[0];
             var formData = new FormData();
             formData.append('imgFile', file);
             var imageType = /image.*/;
             if(file.type.match(imageType)){
                 $.ajax({
                    type: "post",
                    url: '<?php echo site_url("basic/uploadftp/do_upload") ?>',
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (data) {
                        if(data){

                            // 写入地址到某个表单输入框
                            var res = $.parseJSON(data);
                            $('#banner_url_p').val(res.url);

                             var reader = new FileReader();
                             reader.onload=function(){
                                $(".file_img_list").append($('<div"><div class="add_img_box" style="float:left;width:77px;height:77px;border:1px solid #d7e0f1;position:relative;margin-right:20px;"><img style="width:77px;height:77px;overflow:hidden;" src="'+reader.result+'"/><div class="img_close" style="position:absolute;right:-11px;top:-9px;width:20px;height:20px;background:rgba(0,0,0,0.5);border-radius:50%;text-align:center;color:#fff;line-height:19px;display:none;"><i class="iconfont">&#xe635;</i></div></div><div class="add_img_box" style="float:left;width:77px;height:77px;position:relative;margin-right:20px;"><div style="border-radius:50%;overflow:hidden;"><img style="width:77px;height:77px;overflow:hidden;" src="'+reader.result+'"/></div></div></div>'));
                                $('#file').hide();
                                $('.add_img_box').delegate('.img_close','click',function(){
                                    $(this).parent().parent().remove();
                                    $('#file').show();
                                    $("#file >input").val('');
                                })
                             } 
                             reader.readAsDataURL(file);
                        }
                }});
            }
        });

         $('.add_img_box').delegate('.img_close','click',function(){
            $(this).parent().parent().remove();
            $('#file').show();
            $("#file >input").val('');
        })
        //图片上传排版end
    });
</script>
<script>
$(function () {
    var commonItems = [
        'undo', 'redo', '|','cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat',  '|',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '/', 'image', 'multiimage',
        'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink'
    ];

    KindEditor.ready(function(K) {
        //订购须知
        // var editor1 = K.create('textarea[name="order_notice"]', {
        //     cssPath : '<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/kindeditor/plugins/code/prettify.css',
        //     uploadJson : 'http://mp.iwide.cn/index.php/basic/upload/kind_do_upload?t=images&p=inter_id|soma|product_package|order_notice&token=test',
        //     fileManagerJson : '<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/kindeditor/php/file_manager_json.php',
        //     allowFileManager : true,
        //     resizeType : 1,
        //     items : commonItems,
        //     afterCreate : function() {
        //         setTimeout(function(){
        //             $('.ke-container').css('width','');
        //         },1)
        //     }
        // });

        //图文详情
        var editor2 = K.create('textarea[name="img_detail"]', {
            cssPath : '<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/kindeditor/plugins/code/prettify.css',
            uploadJson : 'http://mp.iwide.cn/index.php/basic/upload/kind_do_upload?t=images&p=inter_id|soma|product_package|img_detail&token=test',
            fileManagerJson : '<?php echo base_url(FD_PUBLIC) ?>/AdminLTE/plugins/kindeditor/php/file_manager_json.php',
            allowFileManager : true,
            resizeType : 1,
            items : commonItems,
            afterCreate : function() {
                setTimeout(function(){
                    $('.ke-container').css('width','');
                    $('.ke-edit').height(300);
                    $('.ke-edit-iframe').height(300);
                },1)
            }
        });
        prettyPrint();
    });

});


</script>
</body>
</html>
