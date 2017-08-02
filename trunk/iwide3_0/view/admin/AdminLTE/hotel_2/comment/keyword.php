<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/plugins/datatables/dataTables.bootstrap.css">
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header"><h1>评论设置</h1></section>
<!-- Main content -->
<section class="content">
<div class="row">

    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header with-border"><i class="fa fa-pencil-square-o"></i><h3 class="box-title">操作记录</h3></div>
            <div class="box-body">
<!--                <div class="form-group col-xs-12">
                  <label>评论机制</label>
                  <div class="radio"><label><input type="radio" disabled name="1" <?php /*if(!isset($type) || $type==0)echo "checked";*/?>> 五分制（默认）</label></div>
                  <div class="radio"><label><input type="radio" disabled name="1" <?php /*if(isset($type) && $type==1)echo "checked";*/?> > 百分制</label></div>
                </div>-->
                <div class="form-group col-xs-6">
                  <label>抓取关键词</label>
                  <div class="col-sm-10 input-group">
                    <input type="text" class="form-control" id="keyword"> 
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" id="addbtn">添加</button>
                    </span>
                  </div>
                </div>
                <div class="form-group col-xs-12">
                	<div class="col-xs-4" style="padding:0">
                        <label>当前关键词</label>
                        <table class="table table-bordered table-striped" id="keyword_list" style="text-align:center">
                            <?php if($list){foreach($list as $arr){ ?>
                            <tr>
                                <td><?php echo $arr['keyword'];?></td>
                                <td><button type="button" value="<?php echo $arr['keyword_id'];?>" class="btn btn-danger btn-xs">删除</button></td>
                            </tr>
                            <?php }}?>
                        </table>
                    </div>
               </div>
<!--            	<div class="form-group col-xs-12" style="padding:10px 20px; font-size:10px">
                	<p class="text-red">温馨提示</p>
                	<p class="text-muted">评论机制选择：五分制/百分制</p>
                    <p class="text-muted">五分制：用户总分数  / 用户个数 = 总平均分</p>
                    <p class="text-muted">百分制：（平均分/ 满分）*100% = 评分率</p>
                </div>-->
<!--                <div class="form-group col-xs-2">
                    <button type="button" class="btn btn-block btn-info">保存</button>
                </div>-->
            </div>
        </div>
    </div>


    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header with-border"><i class="fa fa-pencil-square-o"></i><h3 class="box-title">操作记录</h3></div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tr><th>序号</th><th>账号</th><th>操作描述</th><th>IP地址</th><th>时间</th></tr>
<!--                    <tr>
                    <td>1</td><td>limengqun</td><td>修改了规则：评论机制：五分制抓取关键词：增加“网络信号好”</td>
                    <td>192.168.1.1</td><td>2016-04-10 00:07</td>
                    </tr>-->
                    <?php if(isset($logs)){ foreach($logs as $arr){?>
                        <tr>
                            <td><?php echo $arr['log_id'];?></td>
                            <td><?php echo json_decode($arr['admin'])->nm;?></td>
                            <td><?php echo $log_des[$arr['log_type']]."‘".$arr['key_data']."’";?></td>
                            <td><?php echo $arr['ip'];?></td>
                            <td><?php echo $arr['record_time'];?></td>
                        </tr>
                    <?php }}?>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.row -->
</section><!-- /.content -->

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
<script>
$('#addbtn').click(function(){
	var html = '';
	var val  = $('#keyword').val();
	if(val!=''){
        $.get('<?php echo site_url('hotel/Comment/keyword_post')?>',{
            keyword:val
        },function(data){
            console.log(data);
            if(data){
                html +='<tr><td>'+val+'</td><td><button type="button" class="btn btn-danger btn-xs">删除</button></td></tr>';
                $('#keyword_list').append(html);
            }else{
                alert('关键词已存在');return;
            }
        },'json');
	}
})
$('.table').on('click','.btn',function(){
    $.get('<?php echo site_url('hotel/Comment/del_keyword')?>',{
        keyword_id:$(this).attr('value')
    },function(data){

    },'json');
    $(this).parents('tr').remove();
});
</script>
</body>
</html>
