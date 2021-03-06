<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/html5shiv.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/js/respond.min.js"></script>
<![endif]-->
<!--<link rel="stylesheet" href="--><?php //echo base_url(FD_PUBLIC) ?><!--/soma/killsec/css/AdminLTE.css">-->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/soma/killsec/css/jedate.css">
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/soma/killsec/css/style.css">
<!--<script src="--><?php //echo base_url(FD_PUBLIC) ?><!--/soma/killsec/js/jQuery-2.1.4.min.js"></script>-->
<script src="<?php echo base_url(FD_PUBLIC) ?>/soma/killsec/js/jquery.jedate.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/soma/killsec/js/index.js"></script>

<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC) ?>/soma/killsec/css/AdminLTE.css">
<script src="<?php echo base_url(FD_PUBLIC) ?>/soma/killsec/js/moment.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC) ?>/soma/killsec/js/edit.js"></script>

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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content">


<!--秒杀后台 新建秒杀-->
<div class="kill-edit" style="margin-top:50px;">

<!--提示 -->
<div class="error clearfix" id="errorBox">
    <div class="icon fl"></div>
    <div class="fl f28" id="errorMsg">请至少预留10分钟启动活动</div>
    <div class="fr close" id="errorClose"></div>
</div>
<?php echo $this->session->show_put_msg(); ?>
<?php $pk= $model->table_primary_key(); ?>
<!--提示 -->


<div class="kill-edit-container">
<?php
echo form_open( Soma_const_url::inst()->get_url('*/*/edit_post2'), array('class'=>'form-horizontal','enctype'=>'multipart/form-data'), array($pk=>$model->m_get($pk) ) ); ?>
<div class="main-title">
    <h1 class="f28"><?php echo ( $this->input->get('ids') ) ? '编辑': '新增'; ?>秒杀</h1>
    <div class="line"></div>
</div>

<div class="kill-content">
<ul>

<li class="clearfix">
     <div class="fl part">
        <div class="fl sub-title f24"><span class="required">*</span>秒杀类型</div>
        <div class="fl item f24 clearfix">
            <div class="radio-wrap">
                <input type="radio" value="1" name="activity_name" checked href="<?php echo Soma_const_url::inst()->get_url("*/*/add"); ?>" class="homebuying-activity_name <?php echo ( $this->input->get('ids') ) ? 'is--disabled': ''; ?>">
                <span>限流模式</span>
            </div>

            <div class="radio-wrap">
                <input type="radio" value="2" name="activity_name" href="<?php echo Soma_const_url::inst()->get_url("*/activity_flashsale/add"); ?>" class="homebuying-activity_name <?php echo ( $this->input->get('ids') ) ? 'is--disabled': ''; ?>">
                <span>不限制流模式</span>
            </div>
        </div>
    </div>
</li>    

<li class="clearfix">
     <div class="fl part">
        <div class="fl sub-title f24">类型说明</div>
        <div class="fl item f24 clearfix">
            这是类型说明
        </div>
    </div>
</li>  

<li class="clearfix">
    <div class="fl part">
        <div class="fl sub-title f24 ">公众号</div>
        <div class="fl item f24"><?php echo $public['name'];?></div>
    </div>
    <div class="fl part">
        <div class="fl sub-title f24 "><span class="required">*</span>活动名称</div>
        <div class="fl item f24">
            <input type="text" class="input f24 w200" placeholder="请输入活动名称" id="activeName" value="<?php echo ( isset($killSecInfo) && !empty($killSecInfo)) ? $killSecInfo['act_name'] :''; ?>" name="act_name" maxlength="30">
        </div>
    </div>
</li>


<li class="clearfix">
    <div class="fl part">
        <div class="fl sub-title f24">关键字描述</div>
        <div class="fl item f24">
            <input type="text" class="input f24 w200" placeholder="请输入活动描述" id="keyWord" value="<?php echo ( isset($killSecInfo) && !empty($killSecInfo)) ? $killSecInfo['keyword'] :''; ?>" name="keyword" maxlength="50">
        </div>
    </div>

    <div class="fl part">
        <div class="fl sub-title f24 "><span class="required">*</span>展示时间</div>
        <div class="fl item f24">
            <input type="text" placeholder="请选择" class="formdate w340" id="showTime" value="<?php echo ( isset($killSecInfo) && !empty($killSecInfo)) ? $killSecInfo['start_time'] :''; ?>" name="start_time">
        </div>
    </div>
</li>

<li class="clearfix">
    <div class="fl part">
        <div class="fl sub-title f24"><span class="required">*</span>活动时间</div>
        <div class="fl item f24 clearfix">
            <div class="radio-wrap">
                <input type="radio" value="<?php echo $model::SCHEDULE_TYPE_FIX;?>" name="schedule_type"  <?php  if(!isset($killSecInfo) || $killSecInfo['schedule_type'] == $model::SCHEDULE_TYPE_FIX  ) echo ' checked';?>>
                <span>固定时间</span>
            </div>

            <div class="radio-wrap">
                <input type="radio" value="<?php echo $model::SCHEDULE_TYPE_CYC;?>" name="schedule_type" <?php  if( isset($killSecInfo) && !empty($killSecInfo['schedule_type']) && $killSecInfo['schedule_type'] == $model::SCHEDULE_TYPE_CYC ) echo ' checked';?>>按周期循环
            </div>
        </div>
    </div>
</li>

<!--周期循环-->
<li class="clearfix" id="selectTime">
    <div class="fl">
        <div class="fl sub-title"></div>
        <div class="fl item f24 clearfix">
            <div class="fl sub-title f24 second-title">开始日期</div>
            <div class="fl item f24">
                <input type="text" placeholder="选择日期"  <?php if(( isset($killSecInfo) && !empty($killSecInfo) && $killSecInfo['schedule_type'] == $model::SCHEDULE_TYPE_CYC )) { ?> value="<?php echo date("Y-m-d",strtotime($killSecInfo['cycle_stime'])); ?>"  <?php } ?> class="formdate start-time" id="startTime" name="cycle_stime">
            </div>
        </div>

        <div class="fl item f24 clearfix">
            <div class="fl sub-title f24 second-title">结束日期</div>
            <div class="fl item f24">
                <input type="text" placeholder="选择日期"  <?php if(( isset($killSecInfo) && !empty($killSecInfo) && $killSecInfo['schedule_type'] == $model::SCHEDULE_TYPE_CYC )) { ?> value="<?php echo date("Y-m-d",strtotime($killSecInfo['cycle_etime'])); ?>"  <?php } ?> class="formdate start-time" id="endTime" name="cycle_etime">
            </div>
        </div>

    </div>
</li>

<li class="clearfix" id="week">
    <div class="fl">
        <div class="fl sub-title"></div>
        <div class="fl item f24 clearfix">
            <div class="fl sub-title f24 second-title">该时间段</div>
            <div class="fl item f24 clearfix">

                <?php
                $schedule_html= '';
                if(isset($killSecInfo['schedule']) && !empty($killSecInfo['schedule']))        {
                    $schedule = explode(',',$killSecInfo['schedule'] );
                    $schedule = is_array($schedule) ? $schedule : array();
                }else{
                    $schedule = array();
                }


                $week_arr= array( 1=>'一', 2=>'二', 3=>'三', 4=>'四', 5=>'五', 6=>'六', 7=>'日', );
                for($i=1; $i<=7; $i++){
                    $schedule_html.= "<div class='week'><input type='checkbox'name='schedule[]' value='{$i}' class='week-checkbox' ";
                    if(in_array($i, $schedule)) $schedule_html.= " checked='checked' ";
                    $schedule_html.= "> <span> 周{$week_arr[$i]} </span></div>";

                }
                echo $schedule_html;
                ?>

            </div>
        </div>

    </div>
</li>
<!--end 周期循环-->

<li class="clearfix">
    <div class="fl part">
        <div class="fl sub-title"></div>
        <div class="fl item f24 clearfix">
            <div class="fl sub-title f24 second-title">启动时间</div>
            <div class="fl item f24">
                <input type="text" placeholder="请选择" <?php if(( isset($killSecInfo) && !empty($killSecInfo) && $killSecInfo['schedule_type'] == $model::SCHEDULE_TYPE_CYC)) { ?> value="<?php echo date("H:i:s",strtotime($killSecInfo['killsec_time'])); ?>"  <?php } ?> class="formdate start-time" id="startUpTime" >
                <input type="text" placeholder="请选择" <?php if(( isset($killSecInfo) && !empty($killSecInfo) && $killSecInfo['schedule_type'] == $model::SCHEDULE_TYPE_FIX)) { ?> value="<?php echo $killSecInfo['killsec_time']; ?>"  <?php } ?> class="formdate start-time" id="fixedStartUpTime" >
                <input type="hidden" name="killsec_time" <?php if(( isset($killSecInfo) && !empty($killSecInfo))) { ?> value="<?php echo date("H:i",strtotime($killSecInfo['killsec_time'])); ?>" <?php } ?> id="startTimeValue"/>
            </div>
        </div>

        <div class="fl item f24 clearfix">
            <div class="fl sub-title f24 second-title">持续时间</div>
            <div class="fl item f24">
                <input type="text" class="input f24 w200" placeholder="1-72小时之内" id="duration" value=" <?php if(( isset($killSecInfo) && !empty($killSecInfo))) { echo ( ( strtotime($killSecInfo['end_time']) - strtotime($killSecInfo['killsec_time']) )/ 3600);}?>" name="end_time" id="endTimeOne">
            </div>
            <div class="fl f24" id="unit">小时</div>
        </div>

    </div>
</li>



<li class="clearfix">
    <div class="fl part">
        <div class="fl sub-title f24"><span class="required">*</span>限制方式</div>
        <div class="fl item f24 clearfix">
            <div class="radio-wrap">
                <input type="radio" value="1" name="limit" checked>
                <span>限制库存</span>
            </div>

<!--            <div class="radio-wrap">-->
<!--                <input type="radio" value="2" name="limit">限制名额-->
<!--            </div>-->
        </div>
    </div>
</li>

<li class="clearfix" id="limitStore">
    <div class="fl part">
        <div class="fl sub-title"></div>
        <div class="fl item f24 clearfix">
            <div class="fl sub-title f24 second-title">秒杀总库存</div>
            <div class="fl item f24">
                <input type="text" class="input f24 w200" placeholder="数量" id="storeTotal" <?php if(( isset($killSecInfo) && !empty($killSecInfo))) { ?> value="<?php echo $killSecInfo['killsec_count']; ?>"  <?php } ?> name="killsec_count" >
            </div>
            <div class="unit fl f24">份，每人限购</div>
            <div class="fl item f24">
                <input type="text" class="input f24 w200" placeholder="数量" id="homebuying" <?php if(( isset($killSecInfo) && !empty($killSecInfo))) { ?> value="<?php echo $killSecInfo['killsec_permax']; ?>"  <?php } ?> name="killsec_permax">
            </div>
            <div class="unit fl f24">份</div>
        </div>
    </div>
</li>

<li id="storeTips">
    <div class="fl sub-title"></div>
    <div class="tips f24 fl">注：用户在限购次数内，可以继续购买</div>
</li>

<!--第二期-->
<li class="clearfix" id="limitPeopleNumber">
    <div class="fl part">
        <div class="fl sub-title"></div>
        <div class="fl item f24 clearfix">
            <div class="fl sub-title f24 second-title limit-title">限制</div>
            <div class="fl item f24">
                <input type="text" class="input f24 w200" placeholder="数量" id="peopleNumber" >
            </div>
            <div class="unit fl f24">人购买一次，限购</div>
            <div class="fl item f24">
                <input type="text" class="input f24 w200" placeholder="数量" id="limitNumber">
            </div>
            <div class="unit fl f24">份</div>
        </div>
    </div>
</li>

<li id="peopleNumberTips">
    <div class="fl sub-title"></div>
    <div class="tips f24 fl">注：每人只有一个购买机会，购买过后，不能重复购买</div>
</li>


<li class="clearfix">
    <div class="fl part">
        <div class="fl sub-title f24"><span class="required">*</span>选择商品</div>
        <div class="item fl">


            <select class="select fl" id="goodsList"  name="product_id">
                <option value="">请选择商品</option>
                <?php foreach($fields_config['product_id']['select'] as $k => $v){ ?>
                    <option  value="<?php echo $k;?>" <?php if( isset($killSecInfo) && $k == $killSecInfo['product_id']) echo " selected "; ?>> <?php echo $v;?> </option>
                <?php } ?>
            </select>

        </div>
    </div>
</li>

<li class="clearfix" id="goodsInfo">
    <div class="fl">
        <div class="fl sub-title f24"></div>
        <div class="item fl goods">
            <div class="fl f24 mr-30">库存</div>
            <div class="fl f24 mr-60" id="currentStore"><?php if( isset($killSecInfo) &&!empty($killSecInfo['product_id'])  && isset($product_info[$killSecInfo['product_id']])) echo $product_info[$killSecInfo['product_id']]['stock'];?></div>
            <div class="fl f24 mr-30">微信价</div>
            <div class="fl f24 mr-60" id="weChatPrice"><?php if( isset($killSecInfo) &&!empty($killSecInfo['product_id'])  && isset($product_info[$killSecInfo['product_id']])) echo $product_info[$killSecInfo['product_id']]['price_package'];?></div>
            <div class="fl f24 mr-30">秒杀价</div>
            <div class="fl f24"><input type="text" class="input f24 w200" id="killPrice" <?php if(( isset($killSecInfo) && !empty($killSecInfo))) { ?> value="<?php echo $killSecInfo['killsec_price']; ?>"  <?php } ?> name="killsec_price"></div>
        </div>
    </div>
</li>

<li class="clearfix">
    <div class="fl part">
        <div class="fl sub-title f24"><span class="required">*</span>其他</div>
        <div class="fl item f24 clearfix">

            <div class="radio-wrap">
                <input type="checkbox" value="1" class="kill-other" <?php if(( !isset($killSecInfo) ||  $killSecInfo['is_stock'] == 1)) { ?> checked  <?php } ?> name="is_stock">
                <!--  <span>显示库存／名额</span> -->
                <span>显示库存</span>
            </div>

            <div class="radio-wrap" style="display: none">
                <input type="checkbox" value="1" class="kill-other"checked name="is_subscribe">
                <span>订阅通知</span>
            </div>

        </div>
    </div>
</li>

</ul>

<div class="save">
    <a href="<?php echo Soma_const_url::inst()->get_url('*/*/index');?>" class="f32" id="cancelSave">取 消</a>
    <a href="javascript:void(0)" class="f32 active" id="killSave">保 存</a>
</div>

</div>
<?php echo form_close() ?>
</div>

<div class="kill-layer" style="display: none" id="saveLayer">
    <div class="layer-content">
        <div class="close"></div>
        <p class="title f32">提 示</p>
        <div class="tips-content f28">
            <p class="f28">活动启动前10分钟，可编辑内容，</p>
            <p class="f28">之后将不能修改秒杀内容</p>
        </div>
        <a href="javascript:void(0)" class="btn f32">确 定</a>
    </div>
</div>

<script>
    var productInfoArr = <?php echo json_encode($product_info);?>;
</script>

</div>
<!--秒杀后台 新建秒杀-->

</section>
</div><!-- /.content-wrapper -->
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

<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- page script -->
</body>
</html>
