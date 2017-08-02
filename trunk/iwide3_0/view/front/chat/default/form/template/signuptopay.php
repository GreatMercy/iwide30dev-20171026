<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes" >
<meta name="apple-touch-fullscreen" content="yes">
<meta name="format-detection" content="telephone=no,email=no">
<meta name="ML-Config" content="fullscreen=yes,preventMove=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<script src="/public/chat/public/scripts/viewport.js"></script>
<script src="/public/chat/public/scripts/jquery.js"></script>
<script src="/public/chat/public/scripts/jquery.touchwipe.min.js"></script>
<script src="/public/chat/public/scripts/commonform.js?v=1"></script>
<script src="/public/chat/public/scripts/myjs.js"></script>
<link href="/public/chat/public/style/global.css" rel="stylesheet">
<link href="/public/chat/public/style/animate.css?v=1" rel="stylesheet">
<link href="/public/chat/public/style/page.css?v=2" rel="stylesheet">
<link href="/public/chat/public/style/mycss.css" rel="stylesheet">
<title></title>
<meta name="description" content="" />
<script type="text/javascript">			
function phptojs(s){
    if(s){return s.replace(/\\x{(.*?)}/g, '\\u$1');}
}		
			
function inputcheck(){
    var err = 0;times = 0;
	getcoupon();
	if( $('#_coupon').attr('class')=='iserror' ){alert('邀请码不正确！');return false;}
    $('input').each(function(){
	    key = $(this).attr('key')?$(this).attr('key'):'';
		tip = $(this).attr('tip')?$(this).attr('tip'):'';
		ept = $(this).attr('ept')?$(this).attr('ept'):'';
		value = $(this).val();
		times += 1;
		if(value==''){
		    if(parseInt(ept)==1){
			    alert(tip+',不能为空.');
				err +=1;
				return false;
			}
		}
		else {
		    if(key){
				var re = eval('/'+phptojs(key)+'/i');
				if(!re.test(value)){
					alert(tip);
					err +=1;
					$(this).focus();
					return false;
				}
			}
		}
	});
	if(err==0){return true;}
	return false;
}
</script>
</head>
<style>
body,html{overflow:auto;-webkit-overflow-scrolling:touch;}
.ac_title{margin-bottom:6%}
.ac_title b{ font-size:1rem;}
.ac_list{ display: block;}
.ac_list ul{ width:90%;}
.ac_list ul li{ text-align:justify; font-size:0.6rem; font-weight:normal !important;}
a.btn{position:absolute; top:3%; right:4%; width:5em}
a.btn span{padding:0.3em 0; font-size:0.55rem;}
</style>
<body>

<div class="share_bg content center">
	<a href="/index.php/chat/fapi/signuptopay_order?iad=<?php echo $data['id'];?>" class="btn"><span>我的订单</span></a>
    <form id="form1" name="form1" onSubmit="return inputcheck();" method="post" target="_top" action="" style="height:100%;">
    <div class="for" style="min-height:88.8%">
			<div class="ac_title"><b>我要报名</b></div>
			<?php foreach($input as $v){ 
			    if($v['isempty']==1 && $v['isshow']==1){
			?>
			<input type="text" placeholder="<?php echo $v['iname'];?>" key="<?php echo $v['fieldmatch'];?>" tip="<?php echo $v['errinfo'];?>" ept="<?php echo $v['isempty'];?>" name="id<?php echo $v['id'];?>">
			<?php }} ?>
            <div class="ac_intro">
            	<div class="ac_title"><b>活动入场券</b></div>
                <div class="price"><img src="/public/chat/public/img/price.png" style="margin-top:0.3rem"/><b><?php echo $data['price'];?></b> 元/位</div>
                <div class="ac_list"><em class="cicle"></em> <ul><li>截止报名：2016.12.25 17:00</li></ul></div>
                <div class="ac_list"><em class="cicle"></em> <ul><li>活动时间：2016.1.1 09:30-12:30</li></ul></div>
                <div class="ac_list"><em class="cicle"></em> <ul><li>活动地点：相门城墙文化休闲广场</li></ul></div>
            </div>
            <div class="btn invoice mar_top" style="width:10em"><span><b>选填输入项</b></span>
              
            </div>
            <div class="hid">
			    <?php foreach($input as $v){ 
					if($v['isempty']==0 && $v['isshow']==1){
				?>
                <input type="text" placeholder="<?php echo $v['iname'];?>" key="<?php echo $v['fieldmatch'];?>" tip="<?php echo $v['errinfo'];?>" ept="<?php echo $v['isempty'];?>" name="id<?php echo $v['id'];?>">
				<?php }} ?>
            </div>
        
    </div><input name="submit" type="hidden" value="1" /><?php if(isset($csrf)){echo '<input type="hidden" name="'.$csrf['name'].'" value="'.$csrf['hash'].'" />';}?>
	<div class="floor"><input class="s_btn" type="button" name="submit1" value="确认支付"></div>
	</form>
	
	<?php
	$REQUEST_SCHEME = isset($_SERVER['REQUEST_SCHEME'])?$_SERVER['REQUEST_SCHEME']:"http";
	$HTTPHOST = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:"";
		$domain = $REQUEST_SCHEME.'://'.$HTTPHOST;
	?>
	<form id="dopay1" name="dopay1" method="post" target="_top" action="/index.php/wxpay/chat_pay?id=<?php echo $this->inter_id;?>" style="display:none">
	  <input name="body" type="text" value="" />
	  <input name="success_url" type="text" value="" />
	  <input name="fail_url" type="text" value="" />
	  <input name="out_trade_no" type="text" value="" />
	  <input name="__pa_openid" type="text" value="" />
	  <input name="total_fee" type="text" value="" />
	  <input name="notify_url" type="text" value="" />
	</form>
</div>

<script>
(function($){  
	$.fn.serializeJson=function(){  
		var serializeObj={};  
		var array=this.serializeArray();  
		var str=this.serialize();  
		$(array).each(function(){  
			if(serializeObj[this.name]){  
				if($.isArray(serializeObj[this.name])){  
					serializeObj[this.name].push(this.value);  
				}else{  
					serializeObj[this.name]=[serializeObj[this.name],this.value];  
				}  
			}else{  
				serializeObj[this.name]=this.value;   
			}  
		});  
		return serializeObj;  
	};  
})(jQuery);  

var domain='<?php echo $domain;?>';

var nowprice = parseFloat($('.price b').html());

function getcoupon(){
	if($('#_coupon').val()==''){
	    $('.price b').html(nowprice);$('#showoldprice').hide();
		$('#_coupon').removeClass('isright').removeClass('iserror');	
	}
	else {
		$.get('/index.php/chat/api/iscoupon',{sid:'<?php echo $data['id'];?>',coupon:$('#_coupon').val()},function(d){
			if(d.code==1){
			    var redprice = parseFloat(d.pricerole);
				var retprive = (parseInt(nowprice*100)-parseInt(redprice*100))/100;
			    $('.price b').html(retprive);
				$('#showoldprice').show();
				$('#_coupon').addClass('isright').removeClass('iserror');	
			}
			else {
			    $('.price b').html(nowprice);$('#showoldprice').hide();
				$('#_coupon').addClass('iserror').removeClass('isright');
				return false;
			}
		},'json');
	}
}

$('#_coupon').blur(function(){
	getcoupon();
})
$('.s_btn').click(function(){
    if(inputcheck()){
	    var qfforminput = $('#form1 input').serializeJson();
		$.post('/index.php/chat/fapi?iad=<?php echo $data['id'];?>&id=<?php echo $this->inter_id;?>',qfforminput,function(d){
			if(d){
				$.get('/index.php/chat/api/csrf',{},function(c){
					$('#dopay1').append('<input name="'+c.csrf.name+'" type="text" value="'+c.csrf.hash+'" />');
					$('#dopay1 input[name=body]').val(d.body1);
					$('#dopay1 input[name=success_url]').val(domain+'/index.php/chat/fapi/addresult?iad='+d.infoid+'&id=<?php echo $this->inter_id;?>&ret=success');
					$('#dopay1 input[name=fail_url]').val(domain+'/index.php/chat/fapi/repay?id=<?php echo $this->inter_id;?>&iad='+d.infoid);
					$('#dopay1 input[name=out_trade_no]').val(d.infoid);
					$('#dopay1 input[name=__pa_openid]').val(d.openid);
					$('#dopay1 input[name=total_fee]').val(parseFloat(d.price)*100);
					$('#dopay1 input[name=notify_url]').val(domain+'/index.php/chat/api/notify');
					$('#dopay1').submit();
				},'json');
			}
		},'json');
	}
});

var retfail = '<?php echo $retfail;?>';
if(retfail){alert('支付失败，请重新提交订单');location.href='/index.php/chat/fapi?iad=<?php echo $data['id'];?>&id=<?php echo $this->inter_id;?>';}
</script>
<iframe src="/index.php/chat/fapi/syncard?iad=<?php echo $data['id'];?>&id=<?php echo $this->inter_id;?>" style="display:none"></iframe>
</body>
</html>