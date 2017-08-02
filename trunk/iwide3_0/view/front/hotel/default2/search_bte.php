<?php include 'header.php'?>
<?php echo referurl('js','touchwipe.js',3,$media_path) ?>
<?php echo referurl('js','imgscroll.js',2,$media_path) ?>
<?php echo referurl('js','calendar.js',3,$media_path) ?>
<?php echo referurl('css','calendar.css',2,$media_path) ?>
<?php echo referurl('css','index.css',1,$media_path) ?>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<style>
.checkin_time:after{ content:"晚"}
</style>
<!--<?php echo $extra_style ?>-->
<script>
var fail_locate='定位失败';
var latitude=0;
var longitude=0;

function to_locate(){
	$('#cc').html('定位中');
	wx.getLocation({
    success: function (res) {
	        latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
	        longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
	        var speed = res.speed; // 速度，以米/每秒计
	        var accuracy = res.accuracy; // 位置精度
	        locate_city(latitude,longitude);
	    },
	cancel: function (res) {
			$('.local').html(fail_locate);
			$('#cur_city').html(fail_locate);
			$('#cc').html(fail_locate);
	    }
	});
}
function locate_city(lati,logi){
	geocoder = new qq.maps.Geocoder();
	var lat = parseFloat(lati);
	var lng = parseFloat(logi);
	var latLng = new qq.maps.LatLng(lat, lng);
	geocoder.getAddress(latLng);
	geocoder.setComplete(function(result) {
		$('.local').html(result.detail.addressComponents.city);
		$('#cur_city').html(result.detail.addressComponents.city);
		$('#city').val(result.detail.addressComponents.city);
		$('#cc').html(result.detail.addressComponents.city);
		// get_near(lati,logi);
	});
	//若服务请求失败，则运行以下函数
	geocoder.setError(function() {
		$('.local').html(fail_locate);
		$('#cur_city').html(fail_locate);
	});
}
function get_near(lati,logi){
	$('#cc').html('附近酒店');
	$.get('/index.php/hotel/hotel/get_near_hotel?id=<?php echo $inter_id;?>',
		{
			lat:lati,
			lnt:logi
		},function(data){
			var tmp='';
			$.each(data,function(i,n){
				tmp+=' <li><a href="/index.php/hotel/hotel/index?id=<?php echo $inter_id;?>&h='+n.hotel_id+'">'+n.name+'</a></li>';
			});
			$('#near_c').html(tmp);
		},'json');
	$('.near').on('click',function(){
		toshow($('#near_c_i'));
	});
}
</script>
<header class="headers"> 
  <div class="headerslide">
  <?php foreach ($pubimgs as $pi){?>
  	  <a class="slideson ui_img_auto_cut" href="<?php echo $pi['link'];?>">
     	 <img src="<?php echo $pi['image_url'];?>" />
      </a>
      <?php }?>
  </div>
</header>
<form action="sresult?id=<?php echo $inter_id?>" method="post">
<input type="hidden" id="startdate" name="startdate" value="<?php echo date('Y/m/d',strtotime($startdate));?>" />
<input type="hidden" id="enddate" name="enddate" value="<?php echo date('Y/m/d',strtotime($enddate));?>" />
<input type="hidden" id="city" name="city" value="<?php echo $first_city; ?>" />
<input type="hidden" id="<?php echo $csrf_token;?>" name="<?php echo $csrf_token;?>" value="<?php echo $csrf_value;?>" />
<div class="ui_list">
	<div class="ui_item">
        <div class="location ui_btn_block">
            <div class="btn_title">入住城市</div>
            <div class="local txtclip"><?php echo $first_city; ?></div>
        </div>
        <div class="near" onclick="to_locate()"><em class="iconfont color_main">&#x24;</em><p id="cc">定位</p></div>
    </div>
	<div class="ui_item" id="checkdate">
        <div class="checkin ui_btn_block float" id='checkin'>
            <div class="btn_title">入住日期</div>
            <span class="date">1月1日</span>
            <span class="week">一</span>
        </div>
        <div class="border_circle float">
            <div class="checkin_time ui_square_h align_middle">1</div>
        </div>
        <div class="checkout ui_btn_block float_r" id='checkout'>
            <div class="btn_title">离店日期</div>
            <span class="date">1月1日</span>
            <span class="week">一</span>
        </div>
    </div>
	<div class="ui_item">
        <div class="searchbox">
            <input name="keyword" placeholder="关键字/位置/名称" class="keyword">
        </div>
    </div>
</div>
<div class="ui_foot_btn">
	<button class="ui_btn isable">查询</button>
</div>
</form>
<div class="ui_foot_btn" style="margin-top:0px; margin-bottom:5%; padding-top:0">
	<a href="http://whiteswan.iwide.cn/index.php/hotel/hotel/index?id=a451037398&h=1031" class="ui_btn isable" style="display:inline-block">白天鹅宾馆 快速预订通道</a>
</div>
<div class="pad3">
    <div class="often_like webkitbox pad3 bg_F8F8F8 bdradius">
        <div class="often ">
            <em class="iconfont color_main h34">&#x28;</em> <span>常住酒店</span>
        </div>
        <div class="like bd_left" style="padding-left:8px">
            <em class="iconfont color_main h34">&#x2a;</em> <span>我的收藏</span>
        </div>
    </div>
</div>
<div class="ui_pull" id="collects" style="display:none;" onClick="toclose()">
    <div class="bg_fff pull_box center">
        <div class="pull_title color_main pad3" >我的收藏</div>
        <?php if(!empty($hotel_collection)) {?>
        <ul class="list_style_2 scroll" >
       		<?php foreach($hotel_collection as $hc){ ?>
            <li><a href="<?php echo $hc['mark_link']?>"><?php echo $hc['mark_title'];?></a></li>
            <?php }?>
        </ul>
<!--         <a href="often_like.html" class="pull_more">查看更多</a> -->
        <?php }else{?>
        <ul>
            <li>无</li>
        </ul>
        <?php }?>
        <div class="close" style="display:none"><em class="iconfont">&#x27;</em><p>关闭</p></div>
    </div>
</div>
<div class="ui_pull" id="near_c_i" style="display:none;">
    <div class="bg_fff pull_box center">
        <div class="pull_title color_main pad3">附近酒店</div>
        <ul class="list_style_2 scroll" id='near_c'></ul>
        <div class="close pad3"><em class="iconfont h30">&#x27;</em><p class="h20">关闭</p></div>
    </div>
</div>
<div class="ui_pull often_pull" style="display:none;" onClick="toclose()">
    <div class="bg_fff pull_box center">
        <div class="pull_title color_main pad3">常住酒店</div>
        <?php if(!empty($last_orders)){ ?>
        <ul class="list_style_2 scroll">
       <?php foreach($last_orders as $lo){?>
            <li><a href="<?php echo site_url('hotel/hotel/index').'?id='.$inter_id.'&h='.$lo['hotel_id']?>"><?php echo $lo['hname']; ?></a></li>
            <?php }?>
        </ul>
<!--         <a href="often_like.html" class="pull_more">查看更多</a> -->
        <?php } else {?>
        <ul>
         <li><?php echo '无'; ?></li>
        </ul>
        <?php }?>
        <div class="close" style="display:none"><em class="iconfont">&#x27;</em><p>关闭</p></div>
    </div>
</div>
<div class="ui_pull address_pull" style="display:none">
    <div class="bg_fff scroll">
    	<ul class="address_list list_style"><li>全部</li></ul>
    	<div class="title h22">当前定位</div>
    	<ul class="address_list list_style">
        	<li id="cur_city">-</li>
        </ul>     
         <?php if(!empty($last_orders)){ ?>
    	<div class="title h22">历史城市</div>
        <ul class="address_list list_style">
          <?php foreach($last_orders as $lo){?>
        	<li><?php echo $lo['hcity'];?></li>
        	<?php }?>
        </ul>
        <?php }?>
		<?php if(!empty($hot_city)){ ?>
    	<div class="title h22">热门城市</div>
        <ul class="address_list list_style">
        	 <?php foreach($hot_city as $hc){?>
        	<li><?php echo $hc;?></li>
        	<?php }?>
        </ul>
		<?php }?>
        <?php $let=array(); foreach($citys as $ck=>$cs){ $let[]=$ck;?>
    	<div class="title h22" id="<?php echo $ck;?>"><?php echo $ck;?></div>
        <ul class="address_list list_style">
        <?php foreach($cs as $c){ ?>
        	<li><?php echo $c['city']; ?></li>
        	<?php }?>
        </ul>
        <?php }?>
    </div>
    <div class="address_index"><?php foreach($let as $l){?>
        <div><?php echo $l;?></div>
    <?php }?></div>
</div>
<!--
<?php if(!empty($hotel_visited)){?>
<div class="history">
	<div class="title"><hr><span>浏览历史</span><hr></div>
    <ul>
    <?php foreach($hotel_visited as $hv){?>
    	<li><a href="<?php echo $hv['mark_link']?>"><?php echo $hv['mark_title']?></a></li>
    	<?php }?>
    </ul>
    <div class="clear_history">清除历史</div>
</div>
<?php }?>
-->
</body>
<script>
$('.local').html($('#city').val());
var overmonth = 0;
var weekNames = [ '日', '一', '二', '三', '四', '五', '六' ];
var today=new Date(<?php echo strtotime($startdate)*1000; ?>);
var morrow=new Date((today/1000+86400)*1000);

$('.checkin .date').html((today.getMonth() + 1) + '月' + today.getDate() + '日');
$('.checkin .week').html(weekNames[today.getDay()]);

$('.checkout .date').html((morrow.getMonth() + 1) + '月' + morrow.getDate() + '日');
$('.checkout .week').html(weekNames[morrow.getDay()]);
function layer(_this){
	var _h=_this.find('.pull_box').height();
	var _wh=$(window).height();
	_this.find('.pull_box').css('margin-top',(_wh-_h)/2);
	_this.find('.scroll').height(_h-96);
}
$(function(){
	$.fn.imgscroll({
		imgrate			 : 600/160, 
	    partent_div      : 'headers',
		circlesize		 : '5px'
	});
	$('.ui_square_h').height($('.ui_square_h').width());	
	$('.often').on('click',function(){
		toshow($('.often_pull'));
		layer($('.often_pull'));
	});
	$('.like').on('click',function(){
		toshow($('#collects'));
		layer($('#collects'));
	});
	$('.close').on('click',function(){
		toclose();
	});
	$('.location').on('click',function(){
		toshow($('.address_pull'));
		var __top = ($('.address_pull').height()-$('.address_index').height())/2;
		$('.address_index').css('top',__top);
	});
	$('.address_index div').on('click',function(){
		var _scltop = $(this).html();
		_scltop=$('#'+_scltop).offset().top+$('.content_pull').scrollTop();
		$('.content_pull').scrollTop(_scltop);
	});
	$('.address_list li').on('click',function(){
		if($(this).html()!=fail_locate){
			toclose();
			$('.location .local').html($(this).html());
			if($(this).html()!='全部')
				$('#city').val($(this).html());
			else
				$('#city').val('');
		}
	});
	$('.clear_history').on('click',function(){
		var $confirm = confirm("历史记录清除后将不可恢复，是否继续？");
		if( $confirm ){
			$.get('/index.php/hotel/hotel/clear_visited_hotel?id=<?php echo $inter_id?>',function(data){
				if(data==1)
					$('.history').fadeOut();
			});
		}
	});
	var fill_date =function(data){
			$('.checkin .week').html(weekNames[data.inDate.getDay()] );
			$('.checkin .date').html( (data.inDate.getMonth() + 1) + '月' + data.inDate.getDate() + '日');
			
			$('.checkout .week').html(weekNames[data.outDate.getDay()]);
			$('.checkout .date').html( (data.outDate.getMonth() + 1) + '月' + data.outDate.getDate() + '日');
			
			$('.checkin_time').html(data.dateSpan);
	}
	$('#checkdate').cusCalendar({
		_parent			:'checkdate',
		beginTimeElement:'checkin',
		endTimeElement  :'checkout',
		bTimeValElement :'startdate',
		eTimeValElement :'enddate',
		preSpDate:<?php echo $pre_sp_date; ?>,
		selectedCallBack:function(data){fill_date(data)}
	});
})
</script>
</html>