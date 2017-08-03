<?php include 'header.php'?>
<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ggmZIrqw5hOjnXwT7ypK0aIoZXrn4yfS"></script> -->
<?php echo referurl('js','touchwipe.js',3,$media_path) ?>
<?php echo referurl('js','imgscroll.js',2,$media_path) ?>
<?php echo referurl('js','calendar.js',3,$media_path) ?>
<?php echo referurl('css','calendar.css',2,$media_path) ?>
<!-- <?php echo referurl('js','search.js',2,$media_path) ?>-->
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<style>
    body,html{background:#000}
.checkin_time:before{ content:"共"}
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
                $('.near').on('click',function(){
                    toshow($('#near_c_i'));
                    layer($('#near_c_i'));
                });
            },'json');
    }
</script>
<header class="headers">
    <div class="headerslide">
        <?php foreach ($pubimgs as $pi){?>
            <a class="slideson" href="<?php echo $pi['link'];?>">
                <img src="<?php echo $pi['image_url'];?>" />
            </a>
        <?php }?>
    </div>
</header>
<form action="sresult?id=<?php echo $inter_id?>" onsubmit="to_search($(this))" method="post" id="index_search">
    <input type="hidden" id="startdate" name="startdate" value='<?php echo date('Y/m/d',strtotime($startdate));?>' />
    <input type="hidden" id="enddate" name="enddate" value='<?php echo date('Y/m/d',strtotime($enddate));?>' />
    <input type="hidden" id="off" name="off" value='0' />
    <input type="hidden" id="num" name="num" value='20' />
    <input type="hidden" id="latitude" name="latitude" value='' />
    <input type="hidden" id="longitude" name="longitude" value='' />
    <input type="hidden" id="sort_type" name="sort_type" value='distance' />
    <input type="hidden" id="city" name="city" value='<?php echo $first_city;?>' />
    <input type="hidden" id="ec" name="ec" value='[]' />
    <input type="hidden" id="first_local" name="first_local" value='0' />
        
    <div class="pad3">
    <?php if (isset($member->logined)&&$member->logined==0){?>
    	<a class="icon" href="<?php echo site_url('membervip/login/index').'?id='.$inter_id;?>"><img style="border-radius:50%;" src="http://file.cdn.iwide.cn/public/uploads/201612/qf191602238062.png"></a>
    	<?php }else{?>
    	<a class="icon" href="<?php echo site_url('membervip/center/index').'?id='.$inter_id;?>"><img style="border-radius:50%;" src="<?php echo empty($fans_info['headimgurl'])?'http://file.cdn.iwide.cn/public/uploads/201612/qf191602238062.png':$fans_info['headimgurl'];?>"></a>
    	<?php }?>
    	<div class="list_style_1 index_list bdradius martop">
            <div class="webkitbox">
                <div class="location" style="padding:12px 0">
                    <span class="local txtclip"><?php echo $first_city; ?></span>
                </div>
                <a href="<?php echo site_url('hotel/check/nearby').'?id='.$inter_id;?>" class="center" style="display:inline-block; line-height:1">
                    <p class="iconfont h36">&#x36;</p>
                    <span class="color_999 h22">附近酒店</span>
                </a>
            </div>
            <div class="webkitbox arrow" id="checkdate" style="padding-right:5%">
                <div class="checkin" id='checkin'>
                    <div class="h24 color_888">入住时间</div>
                    <span class="date1">1月1日</span>-<span class="date2">1月2日</span>
                </div>
                <div class="checkout" id='checkout'>
                </div>
                <div class="checkin_time color_main txt_r">1</div>
            </div>
            <div class="webkitbox searchbox" style="padding:10px 0">
            	<em class="icon iconfont">&#x2c;</em>
                <input name="keyword" placeholder="请输入关键词">
            </div>
        </div>
        <button class="isable submitbtn bg_main martop">查询</button>
    </div>
</form>
<div class="ui_pull" id="near_c_i" style="display:none;">
    <div class="bg_fff pull_box center">
        <div class="pull_title color_main pad3">附近酒店</div>
        <ul class="list_style_2 scroll" id='near_c'></ul>
        <div class="close pad3"><em class="iconfont h30">&#x27;</em><p class="h20">关闭</p></div>
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
                    <li><?php echo $c['city']; ?></li>
                <?php }?>
            </ul>
        <?php }?>
    </div>
    <div class="address_index h20"><?php foreach($let as $l){?>
            <div><?php echo $l;?></div>
        <?php }?></div>
</div>
</body>
<script>
    $('.local').html($('#city').val());
    $('#ec').val('[]');
    var overmonth = 0;
    var weekNames = [ '日', '一', '二', '三', '四', '五', '六' ];
    var today=new Date(<?php echo strtotime($startdate)*1000; ?>);
    var morrow=new Date((today/1000+86400)*1000);

    $('.checkin .date1').html((today.getMonth() + 1) + '月' + today.getDate() + '日');
    $('.checkin .date2').html((morrow.getMonth() + 1) + '月' + morrow.getDate() + '日');
    function layer(_this){
        var _h=_this.find('.pull_box').height();
        var _wh=$(window).height();
        _this.find('.pull_box').css('margin-top',(_wh-_h)/2);
        _this.find('.scroll').height(_h-96);
    }
    $(function(){
        $.fn.imgscroll({
            imgrate			 : $(window).width()/$(window).height(),
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
            if($(this).html()!=fail_locate){
                $(this).addClass('color_000');
                toclose();
                $('.location .local').html($(this).html());
                if($(this).html()!='全部')
                    $('#city').val($(this).html());
                else
                    $('#city').val('');
            }
        });
        var fill_date =function(data){
            $('.checkin .week').html(weekNames[data.inDate.getDay()] );
            $('.checkin .date1').html( (data.inDate.getMonth() + 1) + '月' + data.inDate.getDate() + '日');
            $('.checkin .date2').html( (data.outDate.getMonth() + 1) + '月' + data.outDate.getDate() + '日');

            //$('.checkout .week').html(weekNames[data.outDate.getDay()]);

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
        }else{
        	obj.attr('action', obj.attr('action')+'&city='+escape($('#city').val()));
        }
    }
</script>
</html>