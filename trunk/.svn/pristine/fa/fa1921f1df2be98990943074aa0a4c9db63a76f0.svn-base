<?php include 'header.php'?>
<style>
.img{margin-right:10px;width:80px; max-width:80px; min-width:80px}
</style>
<header style="padding-top:37px">
	<div class="headfixed webkitbox center pad3 bg_fff bd_bottom">
    	<a href="<?php echo site_url('hotel/hotel/myorder').'?id='.$inter_id.'&hl=0'?>" class="<?php if($handled===0){?>color_main<?php }?>">代付款订单</a>
    	<a href="<?php echo site_url('hotel/hotel/myorder').'?id='.$inter_id?>" class="bd_left <?php if($handled===null){?>color_main<?php }?>">所有订单</a>
    </div>
</header>
<?php if(!empty($orders)){foreach($orders as $o){?>
<div class="martop">
    <div class="webkitbox justify h24 pad3 bg_fff bd">
        <div>订单编号：21212121212121</div>
        <div class="color_main"><?php echo $o['status_des'];?></div>
    </div>
    <a href="" class="webkitbox h24 pad3">
    	<div class="img">
        	<div class="squareimg"><img src="<?php echo base_url('public\hotel\public\images\egimg/eg01.png')?>"></div>
        </div>
        <div class="color_888">
            <div class="h36 color_000"><?php if(isset($o['first_detail']['roomname'])){echo $o['first_detail']['roomname'];}?></div>
            <div>成人票（平日价）  数量：1 张</div>
            <div>时间：<?php echo date('Y.m.d',strtotime($o['startdate']));?></div>
            <div>地址： <?php echo '';?> </div>
        </div>
    </a>
    <div class="webkitbox center h28 bg_fff bd">
        <div class="pad10 color_888">取消订单</div>
        <a href="" class="bd_left color_main" style="padding:4px;">立即支付<div class="color_999 h20" timeout="9000"></div></a>
    </div>
    <div class="webkitbox center h28 bg_fff bd">
	<?php if($o['status']==3){ ?><a href="to_comment?id=<?php echo $inter_id;?>&oid=<?php echo $o['id'];?>" class="pad10 bd_left color_888">立即评价</a><?php }?>
        <a href="" class="pad10 bd_left color_888">再来一单</a>
    </div>
</div>
<?php }}?>
</body>
<script>
$(function(){
	$('[timeout]').each(function() {
		if($(this).attr('timeout')=='')return;
		try{
			var $this = $(this);
			var time=parseInt( $this.attr('timeout')); //剩余秒数
			if(isNaN(time))return;
			var tmp=window.setInterval(function(){
				var theTime = parseInt(time--);// 秒
				if(time<=0){
					$this.html('支付超时');
					window.clearInterval(tmp);
					return;
				}
				var theTime1 = 0;// 分
				var theTime2 = 0;// 小时
				if(theTime > 60) {
					theTime1 = parseInt(theTime/60);
					theTime = parseInt(theTime%60);
					if(theTime1 > 60) {
						theTime2 = parseInt(theTime1/60);
						theTime1 = parseInt(theTime1%60);
					}
				}
				var result = parseInt(theTime);
				if(theTime1 > 0) {
				result = parseInt(theTime1)+":"+result;
				}
				if(theTime2 > 0) {
				result = parseInt(theTime2)+":"+result;
				}
				$this.html('支付倒计时 '+ result);
			},1000);
		}catch(e){
			$.MsgBox.Alert(e);
		}
    });
})
</script>
</html>
