<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" ></script>
<title>分销中心</title>
</head>
<style>
.pullhaibao{display:none; background:#000;}
.pullhaibao >div{position:relative;overflow:auto;height:100%; font-size:0}
.pullhaibao .haibao_user,.pullhaibao .haibao_erweima,.pullhaibao .bg_erweima,.saveimg{position:absolute}
.pullhaibao .haibao_user{ left:0;top:46.5%; width:94%; padding:0 3%;}
.pullhaibao .haibao_user > p{width:2rem; height:2rem; float:left; margin-right:3%; background:#fff; font-size:0}
.pullhaibao .haibao_user > p img,.pullhaibao >div> img{ min-height:100%}
.pullhaibao .haibao_user div{ background:#026eb3; height:1.5rem; padding-top:0.5rem}
.pullhaibao .haibao_erweima{top:92%;left:0; text-align:center; width:100%;}
.pullhaibao .haibao_erweima img{width:46.875%;}
.pullhaibao .bg_erweima{width:100%; height:100%; opacity:0;left:0; bottom:0;}
.saveimg{padding:2% 4%; color:#fff; background:rgba(0,0,0,0.5); z-index:9999; right:3%; bottom:3%; opacity:0.9}
</style>
<body>
<div class="head">
	<a href="<?php echo site_url('distribute/dis_v1/incomes')?>?id=<?php echo $inter_id?>" class="income">
    	<div><span>总收益</span><span><?php echo $total_amount?></span></div>
    	<div><span>今日收益</span><span><?php echo $today_amount?></span></div>
    	<div><span>昨日收益</span><span><?php echo $yestoday_amount?></span></div>
    </a>
	<div class="padding overflow">
        <div class="user_img"><img src="<?php echo $saler_details['headimgurl'];?>" /></div>	
        <div class="user_name"><?php echo $saler_details['name']?><span class="h3">&nbsp;No.<?php echo $saler_details['id']?></span></div>
        <div class="viplv_black"><?php echo $saler_details['hotel_name']?></div>
    </div>
</div>
<div class="ui_btn_list ui_border">
	<a href="<?php echo site_url('distribute/dis_v1/incomes')?>?id=<?php echo $inter_id?>" class="item">
    	<em class="ui_ico ui_ico4"></em>
    	<tt>我的收益(<?php echo $total_amount?>)</tt>
    </a>
	<a href="<?php echo site_url('distribute/dis_v1/my_fans')?>?id=<?php echo $inter_id?>" class="item">
    	<em class="ui_ico ui_ico5"></em>
    	<tt>我的粉丝(<?php echo $saler_details['fans_count']?>)</tt>
    	<!-- <span class="new">+1</span> -->
    </a>
</div>

<div class="ui_btn_list ui_border">
	<a href="<?php echo site_url('distribute/dis_v1/ranking')?>?id=<?php echo $inter_id?>" class="item">
    	<em class="ui_ico ui_ico8"></em>
    	<tt>琅琊榜</tt>
    </a>
</div>
<div class="ui_btn_list ui_border">
	<a class="item my_erwen" >
    	<em class="ui_ico ui_ico6"></em>
    	<tt>我的二维码</tt>
    </a>
    <?php if($inter_id == 'a452223043' || $inter_id == 'a445223616' || $inter_id == 'a449675133' || $inter_id == 'a450939254' || $inter_id == 'a457946152'|| $inter_id == 'a463105262'|| $inter_id == 'a464177542' ) :?>
	<a class="item _haibao">
    	<em class="ui_ico ui_ico6"></em>
    	<tt>生成二维码海报 </tt>
    </a>
    <?php endif;?>
    <?php if($inter_id == 'a421641095' || $inter_id == 'a460705829' || $inter_id == 'a463803935' || $inter_id == 'a445223616' || $inter_id == 'a459234737' || $inter_id == 'a441624001'):?>
	<a class="item my_erwen_mall" >
    	<em class="ui_ico ui_ico6"></em>
    	<tt>粽子分销二维码</tt>
    </a><?php endif;?>
</div>
<div class="ui_btn_list ui_border">
	<a href="<?php echo site_url('distribute/dis_v1/msgs')?>?id=<?php echo $inter_id?>" class="item">
    	<em class="ui_ico ui_ico7"></em>
    	<tt>我的消息</tt>
    	<?php if($new_msg_count > 0):?>
    	<span class="ui_red">有<?php echo $new_msg_count;?>条新消息</span>
    	<?php endif;?>
    </a>
</div>
<div class="pull pullerwei my_code" style="display:none" onClick="toclose()">
	<div class="box">
        <div class="bg_fff">
            <div class="pullclose h1 ui_gray">&times;</div>
            <div class="ui_gray h1 padding" style="padding-bottom:1%"><?php echo $publics['name']?></div>
            <div class="h padding">扫码关注&nbsp;&nbsp;优惠多多</div>
        </div>
   		<div class="border_hr"></div>
        <div class="bg_fff er_log">
            <img src="<?php echo $saler_details['url'];?>" />
            <p><?php echo $saler_details['name']?>&nbsp;No.<?php echo $saler_details['id']?></p>
        	<p class="ui_gray h1" style="padding:2rem;">便捷入住&nbsp;&nbsp;管家服务</p>
        </div>
    </div>
</div>
<?php if($inter_id == 'a421641095' || $inter_id == 'a460705829' || $inter_id == 'a463803935' || $inter_id == 'a445223616' || $inter_id == 'a459234737' || $inter_id == 'a441624001'):?>
<div class="pull pullerwei mall_code" style="display:none" onClick="toclose()">
	<div class="box">
        <div class="bg_fff">
            <div class="pullclose h1 ui_gray">&times;</div>
            <div class="ui_gray h1 padding" style="padding-bottom:1%"><?php echo $publics['name']?></div>
            <div class="h padding">扫码关注&nbsp;&nbsp;优惠多多<</div>
        </div>
   		<div class="border_hr"></div>
        <div class="bg_fff er_log">
            <img src="<?php echo $mall_qrcode;?>" />
        	<p><?php echo $saler_details['name']?>&nbsp;No.<?php echo $saler_details['id']?></p>
        	<p class="ui_gray h1" style="padding:2rem;">便捷入住&nbsp;&nbsp;管家服务</p>
        </div>
    </div>
</div>
<?php endif;?>
<div class="pull pullhaibao">
	<div>
        <img src="" >
    	<canvas id="canvas"></canvas>
    </div>
</div>
</body>
</html>
<script>
function getPixelRatio(context) {
	var backingStore = context.backingStorePixelRatio ||
	context.webkitBackingStorePixelRatio ||
	context.mozBackingStorePixelRatio ||
	context.msBackingStorePixelRatio ||
	context.oBackingStorePixelRatio ||
	context.backingStorePixelRatio || 1;
	
	return (window.devicePixelRatio || 1) / backingStore;
}
var _time,_tmpurl,a,b;
var bgimg=new Image;
var userimg=new Image;
var erweima=new Image;
var getbase64url ="<?php echo site_url('distribute/dis_v1/file2base64')?>?id=<?php echo $inter_id?>";
var getimgeurl="<?php echo site_url('distribute/dis_v1/base64_2file')?>?id=<?php echo $inter_id?>";
bgimg.src="";
userimg.src="";
erweima.src="";
<?php if($this->input->get('id') == 'a452223043' || $this->input->get('id') == 'a450939254'):?>
bgimg.src="<?php echo base_url('public/distribute/default/images/a450939254.jpg')?>";
<?php endif;?>
<?php if($this->input->get('id') == 'a445223616'):?>
bgimg.src="<?php echo base_url('public/distribute/default/images/a445223616.jpg')?>";
<?php endif;?>
<?php if($this->input->get('id') == 'a449675133'):?>
bgimg.src="<?php echo base_url('public/distribute/default/images/a449675133.jpg')?>";
<?php endif;?>
<?php if($this->input->get('id') == 'a463105262'):?>
bgimg.src="<?php echo base_url('public/distribute/default/images/a463105262.jpg')?>";
<?php endif;?>
<?php if($this->input->get('id') == 'a464177542'):?>
bgimg.src="<?php echo base_url('public/distribute/default/images/a464177542.jpg')?>";
<?php endif;?>
<?php if($this->input->get('id') == 'a457946152'):?>
//getbase64url= "http://credit.iwide.cn/index.php/distribute/no_auth/file2base64?id=<?php echo $inter_id?>";
//getimgeurl  = "http://credit.iwide.cn/index.php/distribute/no_auth/base64_2file?id=<?php echo $inter_id?>";
bgimg.src="<?php echo base_url('public/distribute/default/images/a457946152.jpg')?>";
<?php endif;?>
$(function(){
	var canvas=$('#canvas').get(0);
	var isdown=false;
	var isfirst=true;
	var _count=0;
	var _rate = 640/1008;
	var _w=$(window).width();
	var _h=_w/_rate;
	if ( _h <$(window).height()) _h=$(window).height();
	var _r =1.4;// getPixelRatio(canvas.getContext("2d"));
	_w=_w*_r;
	_h=_h*_r;
	//用户图片宽,坐标;
	var u_w=_w*120/640; 
	var u_x=_w*30/640;
	var u_y=_h*470/1008;
	//二维码宽高;
	var e_w=_w*150/640;
	var e_x=_w*240/640;
	var e_y=_h*245/1008;
	//方形宽;
	var r_w=_w*460/640;
	var r_x=_w*150/640;
	//文字坐标;
	var t_s= parseInt($("body").css('font-size'))*_r;
	var t_x=_w*170/640;
	var t_y=_h*465/1008+(u_w+t_s)/2;
	$('.my_erwen').click(function(){
		toshow($('.my_code'));
		reset_time('我的二维码海报');
	});
	<?php if($inter_id == 'a421641095' || $inter_id == 'a460705829' || $inter_id == 'a463803935'):?>
	$('.my_erwen_mall').click(function(){
		toshow($('.mall_code'));
		reset_time('我的二维码海报');
	});
	<?php endif;?>
	$('.pullclose').click(toclose);
	
	$('._haibao').on('click',function(){
		if ( isdown) return;
		if(bgimg.src==''){ isdown=true; alert('暂未添加此功能');return false;}
		if(isfirst){
		<?php if($this->input->get('id') != 'a457946152'):?>
			$.get(getbase64url,{'url':'<?php echo $saler_details['headimgurl'];?>'},function(data){
				userimg.src="data:image/jpeg;base64,"+data;
				a='complete';
			},'text'); 
		<?php endif; ?>
		<?php if($this->input->get('id') == 'a457946152'):?>
			a='complete';
		<?php endif;?>
			$.get(getbase64url,{'url':'<?php echo $saler_details['url'];?>'},function(data){
				erweima.src="data:image/jpeg;base64,"+data;
				b='complete';
			},'text');
			isfirst=false;
		}
		if ( !a=='complete' || !b=='complete' || !bgimg.complete ){ 
			cutdown('生成');
		}
		else{
			if ($('.pullhaibao img').attr('src')=='') cutdown('生成');
			else toshow($('.pullhaibao'));
		}
	});
	
	function creat(){
		isdown=true;
		var cxt=canvas.getContext("2d");
		$('#canvas').attr('width',_w);
		$('#canvas').attr('height',_h);
		cxt.drawImage(bgimg,0,0,_w,_h);
		<?php if($this->input->get('id') != 'a457946152'):?> 
		cxt.drawImage(userimg,u_x,u_y,u_w,u_w);
		cxt.drawImage(erweima,e_x,e_y,e_w,e_w);
		<?php else:?>
		cxt.drawImage(erweima,e_x,e_y,e_w,e_w);		 //隐居
		<?php endif;?>
		var txt='扫码关注，畅享优惠';
		cxt.fillStyle = "#026eb3";
		<?php if($this->input->get('id') == 'a452223043' || $this->input->get('id') == 'a450939254'):?>
		txt='莫林 · 美梦开始的地方';
		cxt.fillStyle = "#026eb3";
		<?php endif;?>
		<?php if($this->input->get('id') == 'a445223616'):?>
		txt='扫码可享订房优惠/乐购商场/粉丝互动';
		cxt.fillStyle = "#f7a23d";
		<?php endif;?>
		<?php if($this->input->get('id') == 'a449675133'):?>
		txt='扫码可提供优惠, 快捷的管家服务';
		<?php endif;?>
		<?php if($this->input->get('id') == 'a464177542'):?>  //锦江
		txt='扫码可提供优惠, 快捷的管家服务';
		cxt.fillStyle = "#e44944";
		<?php endif;?>
		<?php if($this->input->get('id') == 'a463105262'):?>  //亲的客栈
		txt='扫我扫我扫我，优惠折扣一起来！';
		cxt.fillStyle = "#990000";
		<?php endif;?>
		<?php if($this->input->get('id') != 'a457946152'):?> 
		cxt.fillRect(r_x,u_y,r_w,u_w);
		cxt.fillStyle = "#ffffff";
		cxt.font=t_s+'px Helvetica Neue,sans-serif';
		cxt.fillText(txt,t_x,t_y);
		<?php endif;?>
		cutdown('下载');
		console.log(canvas.toDataURL().replace('data:image/png;base64,',''));
		var _tmpurl=canvas.toDataURL().replace('data:image/png;base64,','');
		console.log(_tmpurl);
		$.post(getimgeurl,{
			'url':_tmpurl,
			'<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>',
			'qid':'<?php echo $saler_details['id']?>'
		},function(data){
			if (data=='error') {alert('下载失败,请刷新页面重试~');reset_time( '二维码海报生成失败!');return;}
			_count=0;
			var tmpimg = new Image;
			tmpimg.onload=function(){
				reset_time( '我的二维码海报!');
				isdown=false;
				$('#canvas').hide();
				$('.pullhaibao img').attr('src',tmpimg.src);
				toshow($('.pullhaibao')); 
			};
   			tmpimg.src=data;
		});
	}
	function cutdown(str){
		window.clearInterval(_time);
		$('._haibao tt').html('正在'+str+'二维码海报,请稍候('+_count+'s)');
		_time=window.setInterval(function(){
			_count++;
			$('._haibao tt').html('正在'+str+'二维码海报,请稍候('+_count+'s)');
			if( a=='complete' && b=='complete'  && bgimg.complete){
				if (!isdown) creat();
			}
			if (_count>180){
				_count=0;
				isdown=false;
				reset_time( str+'二维码海报');
			}
		},1000);
	}
	function reset_time(str){
		window.clearInterval(_time);
		$('._haibao tt').html(str);
	}

})

</script>