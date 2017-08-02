<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes" >
<meta name="apple-touch-fullscreen" c ontent="yes">
<meta name="format-detection" content="telephone=no,email=no">
<meta name="ML-Config" content="fullscreen=yes,preventMove=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=320,user-scalable=0">
<title>我的预约</title>
    <?php echo referurl('css','service.css',1,$media_path) ?>
    <?php echo referurl('css','global.css',1,$media_path) ?>
    <?php echo referurl('js','jquery.js',1,$media_path) ?>
    <?php echo referurl('js','ui_control.js',1,$media_path) ?>
    <?php echo referurl('js','alert.js',1,$media_path) ?>
    <?php echo referurl('js','timepicker.js',1,$media_path) ?>
    <?php include 'wxheader.php'?>
</head>
<body>
<div class="pageloading"></div>
<page class="page">
	<header>
    	<div class="center padding bg_fff h26 offer_title">
            <?php
                $status_name = array('预约成功','您已用餐','预约已取消');
                echo $status_name[$book_op_status];
            ?>
        </div>
    </header>
    <section class="scroll flexgrow h26">
    	<div class="bg_fff pad10 martop linkblock" onclick="window.location.href='<?php echo site_url('/appointment/booking/offer_show?id='.$this->inter_id.'&dining_room_id=').$dining_room_id?>'">
            <?php echo $shop_name;?>
        </div>
    	<div class="bg_fff pad10 bd_top h22 color_999">
        	<div>就餐时间：<?php echo $book_datetime;?></div>
        	<div>就餐人数：<?php echo $book_number;?>人</div>
        	<div>预约信息：<?php echo $book_name.'    '.$book_phone;?> </div>
        </div>
    	<div class="flex bg_fff pad10 martop bd_top linkblock" onclick="tonavigate(<?php echo $hotel['latitude'];?>,<?php echo $hotel['longitude'];?>,'<?php echo $hotel['name'];?>','<?php echo $shop_address;?>')">
        	<div class="shrink">地址：</div>
            <div><?php echo $shop_address;?></div>
        </div>
    </section>
    <footer>
    	<div class="flex center">
            <?php
            if ($book_op_status != 0)
            {
            ?>
                <a class="pad10 bg_main flexgrow "
                   href="<?php echo site_url('/appointment/booking/offer_show?id='.$this->inter_id.'&dining_room_id='.$dining_room_id)?>">再次预约</a>

            <?php
            }else{
            ?>
                <button class="pad10 flexgrow bg_ddd cancel_btn" style="cursor: pointer">取消预约</button>
                <a class="pad10 bg_main flexgrow again_btn" style="display: none;"
                   href="<?php echo site_url('/appointment/booking/offer_show?id='.$this->inter_id.'&dining_room_id='.$dining_room_id)?>">再次预约</a>
            <?php
            }
            ?>
        </div>
    </footer>
</page>
<script>
    var order_id = "<?php echo $order_id?>";
    function cancel_order(order_id,obj)
    {
        $.ajax({
            dataType:'json',
            type:'post',
            data:
            {
                'order_id':order_id,
                '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            url:'<?php echo site_url('appointment/booking/cancel_order')?>',
            beforeSend: function()
            {
                obj.attr("disabled", true);
            },
            success:function(rs)
            {
                if (rs.status == 1)
                {
                    $.MsgBox.Alert('取消成功',function()
                    {
                        $('.cancel_btn').hide(200);
                        $('.again_btn').show(200);
                    });
                    $('#mb_btn_no').remove();
                    $('.offer_title').html('预约已取消');
                }
                else
                {
                    $.MsgBox.Alert(rs.msg);
                }
                obj.removeAttr('disabled');
            }
        })
    }//end

    $(".cancel_btn").bind("click",function()
    {
        var obj = $(this);
        cancel_order(order_id,obj);
    });

</script>
</body>
</html>
