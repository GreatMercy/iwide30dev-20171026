<?php include 'header.php'?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ggmZIrqw5hOjnXwT7ypK0aIoZXrn4yfS"></script>
<?php echo referurl('js','touchwipe.js',3,$media_path) ?>
<?php echo referurl('js','imgscroll.js',2,$media_path) ?>
<?php echo referurl('js','calendar.js',3,$media_path) ?>
<?php echo referurl('css','calendar.css',2,$media_path) ?>
<?php echo referurl('js','search.js',2,$media_path) ?>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<style>
    body,html{background:#fff}
    .checkin_time:after{ content:"晚"}
</style>
<script>
    var fail_locate='-';
    var latitude=0;
    var longitude=0;
    var city='-1';
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
        $.get('<?php echo Hotel_base::inst()->get_url("*/*/get_near_hotel")?>',
            {
                lat:lati,
                lnt:logi
            },function(data){
                var tmp='';
                $.each(data,function(i,n){
                    tmp+=' <li><a href="<?php echo Hotel_base::inst()->get_url('*/*/index')?>&h='+n.hotel_id+'">'+n.name+'</a></li>';
                });
                $('#near_c').html(tmp);
                $('.near').on('click',function(){
                    toshow($('#near_c_i'));
                    layer($('#near_c_i'));
                });
            },'json');
    }
</script>
<?php if ($inter_id=='a480304439'){?>
<!--优程客服-->
<style>
._kefu{position:fixed; right:0px; bottom:0px; border-radius:50% 0 0 0; overflow:hidden; width:50px; height:50px; z-index:55; opacity:0.7}
</style>
<a class="_kefu bg_main" href="http://qdok6.kuaishang.cn/bs/im.htm?cas=16977___182163&fi=17540&ism=1&sText=%E9%A2%84%E8%AE%A2&ref=%E9%87%91%E6%88%BF%E5%8D%A1">
	<img src="http://file.cdn.iwide.cn/public/uploads/201701/qf061240225492.png">
</a>
<!-- end -->
<?php }?>
<header class="headers">
    <div class="headerslide">
        <?php foreach ($pubimgs as $pi){?>
            <a class="slideson" href="<?php echo Hotel_base::inst()->get_url($pi['link'],'',TRUE);?>">
                <img src="<?php echo $pi['image_url'];?>" />
            </a>
        <?php }?>
    </div>
</header>
<form action="<?php echo Hotel_base::inst()->get_url('*/*/sresult')?>" onsubmit="to_search($(this))" method="post" id="index_search">
    <input type="hidden" id="startdate" name="startdate" value='<?php echo date('Y/m/d',strtotime($startdate));?>' />
    <input type="hidden" id="enddate" name="enddate" value='<?php echo date('Y/m/d',strtotime($enddate));?>' />
    <input type="hidden" id="off" name="off" value='0' />
    <input type="hidden" id="num" name="num" value='20' />
    <input type="hidden" id="latitude" name="latitude" value='' />
    <input type="hidden" id="longitude" name="longitude" value='' />
    <input type="hidden" id="sort_type" name="sort_type" value='distance' />
    <input type="hidden" id="city" name="city" value='<?php echo $first_city;?>' />
    <input type="hidden" id="area" name="area" value='' />
    <input type="hidden" id="ec" name="ec" value='[]' />
    <input type="hidden" id="first_local" name="first_local" value='0' />
    <div class="list_style index_list bd_bottom">
        <div class="webkitbox">
            <div class="location arrow bd_right">
                <div class="h22 color_888">入住城市</div>
                <div class="local txtclip h36"><?php echo $first_city; ?></div>
            </div>
            <a class="near color_main center" href='<?php echo Hotel_base::inst()->get_url('*/check/nearby')?>'>
                <em class="iconfont" style="font-size:25px">&#x24;</em>
                <p class="h20" id="cc">附近酒店</p>
            </a>
        </div>
        <div class="webkitbox no_border" id="checkdate">
            <div class="checkin arrow bd_bottom" id='checkin' style="padding-bottom:8px">
                <div class="h22 color_888">入住日期</div>
                <span class="date">1月1日</span>
                <span class="h24 color_888 week">一</span>
            </div>
            <div class="border_circle checkin_time">1</div>
            <div class="checkout arrow bd_bottom" id='checkout' style="padding-bottom:8px">
                <div class="h22 color_888">离店日期</div>
                <span class="date">1月1日</span>
                <span class="h24 color_888 week">一</span>
            </div>
        </div>
        <div class="webkitbox searchbox arrow" style="padding:10px 0">
            <input name="keyword" placeholder="关键字/位置/名称" readonly class="keyword" url="<?php echo Hotel_base::inst()->get_url('*/check/ajax_city_filter')?>">
        </div>
    </div>
    <div class="pad3 center martop">
        <button class="isable submitbtn bg_main">查询</button>
    </div>
</form>
<div class="center h20 color_888 history">
    <div class="clear_history martop">清空记录</div>
</div>
<div class="pad3">
    <div class="often_like webkitbox pad3 <?php if ($inter_id!='a476756979'){?>bg_F8F8F8<?php }?> bdradius">
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
        <ul class="list_style_2 scroll" >
            <?php if(!empty($hotel_collection)) {?>
                <?php foreach($hotel_collection as $hc){ ?>
                    <li><a href="<?php echo Hotel_base::inst()->get_url($hc['mark_link'],array(),TRUE)?>"><?php echo $hc['mark_title'];?></a></li>
                <?php }?>
            <?php }else{?>
                <li>无</li>
            <?php }?>
        </ul>
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
        <ul class="list_style_2 scroll">
            <?php if(!empty($last_orders)){ ?>
                <?php foreach($last_orders as $lo){?>
                    <li><a href="<?php echo Hotel_base::inst()->get_url('*/check/ajax_city_filter').'&h='.$lo['hotel_id']?>"><?php echo $lo['hname']; ?></a></li>
                <?php }?>
            <?php } else {?>
                <li>无</li>
            <?php }?>
        </ul>
        <div class="close" style="display:none"><em class="iconfont">&#x27;</em><p>关闭</p></div>
    </div>
</div>
<div class="ui_pull address_pull" style="display:none">
    <div class="bg_fff scroll" content_pull>
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
                    <?php if(isset($c['area'])){ ?>
                            <li city="<?php echo $c['city'];?>" area="<?php echo $c['area'];?>">
                                <?php
                                    echo $c['area'].'('.$c['city'].')';
                                ?>
                            </li>
                    <?php }else{  ?>
                        <li><?php echo $c['city']; ?></li>
                <?php }}?>
            </ul>
        <?php }?>
    </div>
    <div class="address_index h20"><?php foreach($let as $l){?>
            <div><?php echo $l;?></div>
        <?php }?></div>
</div>
<?php if(isset($foot_ads['ads']) && !empty($foot_ads['ads'])){ ?>
<div class="h28 pad3 bd_top bg_fff martop"><em class="iconfont">&#X43;</em> <?php if(isset($foot_ads['title']) && !empty($foot_ads['title'])) echo $foot_ads['title'];else echo '推荐';?></div>
<div class="vote_spread bg_fff">
    <?php foreach($foot_ads['ads'] as $fad){ foreach($fad as $fa){?>
    <a href="<?php echo Hotel_base::inst()->get_url($fa['ad_link'],array(),TRUE);?>">
        <div class="squareimg"><img src="<?php echo $fa['ad_img'];?>" info="<?php echo $fa['ad_title'];?>"/></div>
        <div class="h28 txtclip"><?php echo $fa['ad_title'];?></div>
        <div class="h22 txtclip"><?php echo $fa['des'];?></div>
    </a>
    <?php }}?>
</div>
<script>
$(function(){
    var l= $('.vote_spread>*').length;
    if( l<=1) $('.vote_spread .squareimg').css('padding-bottom','40%');
    if( l>1) $('.vote_spread>*').css('width','50%');
    if( l>2) $('.vote_spread>*').css('width','45%');
});
</script>
<?php }?>
</body>
<script>
    if($('#city').val()==''){
        disp_city='全部';
    }else{
        disp_city=$('#area').val()!=''?$('#area').val().replace('市','').replace('区','').replace('县','')+'('+$('#city').val().replace('市','').replace('区','').replace('县','')+')':$('#city').val().replace('市','').replace('区','').replace('县','');
    }
    $('.local').html(disp_city);
    $('#ec').val('[]');
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
	var cache = [];
	var count = 0;
	try{
		cache = JSON.parse(window.localStorage['cache']);
	}catch(e){
		console.log(e);
		cache = [];
	}
	$.each(cache,function(m,n){
		var html = $('<div class="color_555 martop">'+n.city+' '+n.startTxt+' - '+n.endTxt+' '+n.key+'</div>');
		html.click(function(){
			$('#ec').val(n.ec);
			$('#city').val(n.city);
			$('#index_search').submit();
		});
		$('.history').prepend(html);
		count++;
	});
	if(count<=0){
		$('.history').hide();
	}
	function saveCache(key){
		var bool 		= true;
		var _cache 		= {};
		var index		= 0;
		_cache.ec  		= $('#ec').val();
		_cache.city		= $('.local').html();
		_cache.startTxt = $('#checkin .date').html();
		_cache.endTxt	= $('#checkout .date').html();
		_cache.key		= key?key:'';
		$.each(cache,function(m,n){
			if(n.ec==_cache.ec&& n.city==_cache.city&& n.startTxt==_cache.startTxt&& n.endTxt==_cache.endTxt&& n.key==_cache.key){
				bool=false;
				index=m;
				return false;
			}
		});
		if( bool) cache.push( _cache);
		else{
			cache.splice(index,1,_cache);
		}
		if(cache.length>5)cache.splice(0,1);
		try{
			window.localStorage['cache']=JSON.stringify(cache);
		}catch(e){
			console.log(e);
		}
	}

    $(function(){
		$('.submitbtn').click(function(){
			saveCache();
		});
		$('.filter_pull').on('click','.get_result li',function(e){
			saveCache($(this).html());
		});
		$('.clear_history').click(function(){
			try{
				cache=[];
				window.localStorage['cache']='[]';
			}catch(e){
				console.log(e);
			}
			$('.history').hide();
		});

        $.fn.imgscroll({
            imgrate			 : 600/160,
            partent_div      : 'headers',
            circlesize		 : '5px'
        });
        $('.often').on('click',function(){  toshow($('.often_pull'));	layer($('.often_pull'));});
        $('.like').on('click',function(){  toshow($('#collects'));      layer($('#collects'));});
        $('.close').on('click',function(){toclose();});

        $('.location').on('click',function(){
            toshow($('.address_pull'));
            var __top = ($('.address_pull').height()-$('.address_index').height())/2;
            $('.address_index').css('top',__top);
        });
        $('.address_index div').on('click',function(){
            var _scltop = $(this).html();
            _scltop=$('#'+_scltop).offset().top+$('.address_pull [content_pull]').scrollTop();
            $('.address_pull [content_pull]').scrollTop(_scltop);
        });
        $('.address_list li').on('click',function(){
//            console.log($(this).attr('city'));
            if($(this).html()!=fail_locate){
                $(this).addClass('color_000');
                toclose();
                $('.location .local').html($(this).html());

                if($(this).attr('city') !=undefined){
                    $('#area').val($(this).attr('area'));
                    $('#city').val($(this).attr('city'));
                }else{
                    $('#area').val('')
                    if($(this).html()!='全部')
                        $('#city').val($(this).html());
                    else
                        $('#city').val('');
                }
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


    var fill_hotel =function(){$('.page_loading').remove();}
    function to_search(obj){
    	if($('#city').val()=='全部'){
    		$('#city').val('');
        }else if($('#city').val()!=undefined){
            obj.attr('action', obj.attr('action')+'&city='+escape($('#city').val())+'&area='+escape($('#area').val()));
        }else{
        	obj.attr('action', obj.attr('action')+'&city='+escape($('#city').val()));
        }
    }
</script>
</html>
