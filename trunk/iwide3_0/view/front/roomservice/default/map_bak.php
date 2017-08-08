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
<title>地图</title>
	<?php echo referurl('css','global.css',1,$media_path) ?>
	<?php echo referurl('css','service.css',1,$media_path) ?>
	<?php echo referurl('js','jquery.js',1,$media_path) ?>
	<?php echo referurl('js','ui_control.js',1,$media_path) ?>
	<?php echo referurl('js','alert.js',1,$media_path) ?>
</head>
<body>
<div class="pageloading"></div>
<page class="page h24">
	<header>
        <div class="_w mapsearch">
            <div class="searchbox center"><em class="iconfont color_999">&#X0A10;</em><input id="keyword" placeholder="请搜索" class="h24"></div>
        </div>
    	<div class="map" id="map"></div>
    	<div class="center bg_fff flex flexjustify tablayer color_main bd_btm_img" style="justify-content:space-around">
        	<div class="iscur"><tt>写字楼</tt></div>
        	<div><tt>小区</tt></div>
        	<div><tt>学校</tt></div>
        </div>
    </header>
    <section class="scroll flexgrow h26" id="AddressList">
    </section>
    <footer></footer>
</page>
</body>
<script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js "></script>
<script type="text/javascript" src="http://map.qq.com/api/js?v=2.exp&key=6RABZ-LJEKJ-PCNFY-FMHHT-HN2LZ-VCFI6"></script>
<script>
var key = '6RABZ-LJEKJ-PCNFY-FMHHT-HN2LZ-VCFI6';
var user = {};
function filladdress(data,iscur){
	if(iscur==undefined)iscur=false;
	var str = '<div class="flex bg_fff pad10">'
			+ '<em class="iconfont h36 color_main">&#XA8;</em>'
            + '<div class="marleft"><div class="h26">';
	if(iscur) str +='<span class="color_main">[当前] </span>';
	str+= data.name;
    str+= '</div><div class="h20 color_C3C3C3">'
	if(data.address)str+= data.address;
	else str+=' 定位失败，请手动选择地址 '
    str+= '</div></div></div>';
	var TmpObj = $(str);
	$('#AddressList').append(TmpObj);
	if(data.address){
		TmpObj.click(function(){
			try{
				user= $.parseJSON($.getsession('user'));
				console.log(typeof(user));
				if(user==''||typeof(user)=='string')user={};
			}catch(e){
				user={};
			}
			user.select_addr = data.name;
			user.address = data.address;
			user.latLng = data.latLng;
			$.setsession('user',JSON.stringify(user));
			window.location.href=document.referrer;
		})
	}
}

var center=new qq.maps.LatLng(39.916527, 116.397128);
var radius=2000; //配送范围(米)
$(function(){
    var searchService, markers = [];
	var geolocal = new qq.maps.Geolocation(key, 'myapp');
	var map = new qq.maps.Map(document.getElementById('map'), {
		center: center,
		mapTypeId:'roadmap',
		zoom:14,
		mapTypeControl:false,
		zoomControl:false,
		noClear:true,
		disableDoubleClickZoom: true
	});		
	var marker = new qq.maps.Marker({
		draggable: false,
		map: map,
		animation:qq.maps.MarkerAnimation.DROP
	});
	qq.maps.event.addListener(map, 'click', function(ev) {
		//var _center=new qq.maps.LatLng(ev.latLng.getLat(),ev.latLng.getLng());
		//marker.setPosition(_center); //移动标注
		//map.setCenter(_center);//移动地图
	}); 
	searchService = new qq.maps.SearchService({
		//检索成功的回调函数
		complete: function(results) {
			//设置回调函数参数
			var pois = results.detail.pois;
			for (var i = 0, l = pois.length; i < l; i++) {
				//扩展边界范围，用来包含搜索到的Poi
				filladdress({
					name:pois[i].name,
					address:pois[i].address,
					latLng:pois[i].latLng
				},false);
			}
		},
		//若服务请求失败，则运行以下函数
		error: function() {
			alert("出错了");
		}
	
	});//根据输入的城市设置搜索范围
         //清除地图上的marker
	function clearOverlays(overlays) {
		$('#AddressList').html('');
		var overlay;
		while (overlay = overlays.pop()) {
			overlay.setMap(null);
		}
	}
	//设置搜索的范围和关键字等属性
	$('#keyword').change(function() {
		var keyword = $(this).val();
		//clearOverlays(markers);
		//searchService.search(keyword);

	})
	$('.tablayer>*').click(function(){
		$(this).addClass('iscur').siblings().removeClass('iscur');
		$('#AddressList').html('');
		var _center = marker.getPosition();
		searchService.searchNearBy($(this).text(),_center,radius);
		//searchService.search($(this).text());
	})
	//pageloading();
	geolocal.getLocation(function(data){
		removeload();
		$('#AddressList').html('');
		//$('footer').html(JSON.stringify(data));
		filladdress({
			name:data.addr,
			address:data.city+data.district?data.district:'',
			latLng:{
				lat:data.lat,
				lng:data.lng
			}
		},true);
		center = new qq.maps.LatLng(data.lat,data.lng);//中心坐标
		map.setCenter(center);//设置Poi检索服务，用于本地检索、周边检索
		marker.setPosition(center);//标注的位置
		marker.setIcon("<?php echo referurl('img','icon01.png',1,$media_path) ?>");
		//根据输入的城市设置搜索范围
		searchService.setLocation(data.city+data.district);
		//设置搜索页码
		searchService.setPageIndex(0);
		//设置每页的结果数
		searchService.setPageCapacity(10);
		searchService.searchNearBy($('.tablayer .iscur').text(),center,radius);
	},function(){
		removeload();
		$.MsgBox.Alert('网络超时，请稍后再试');
	},{timeout:30000})
});
</script>
</html>
