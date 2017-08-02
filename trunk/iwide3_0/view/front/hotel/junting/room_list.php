<?php include 'header.php'?>
<?php echo referurl('js','touchwipe.js',3,$media_path) ?>
<?php echo referurl('js','imgscroll.js',2,$media_path) ?>
<?php echo referurl('js','calendar.js',3,$media_path) ?>
<?php echo referurl('css','calendar.css',2,$media_path) ?>
<style>
.checkin_time:after{ content:"晚"}
.checkout:after{content:"离店"}
.week:before {content: "周";}
.week:after{content:"入住"}
</style>
<form id="book_f" method="post" action="bookroom">
<input type="hidden" id="startdate" name="startdate" value="<?php echo date('Y/m/d',strtotime($startdate));?>" />
<input type="hidden" id="enddate" name="enddate" value="<?php echo date('Y/m/d',strtotime($enddate));?>" />
<input type="hidden" id="nums" name="nums" value="1" />
<input type="hidden" id="price_codes" name="price_codes" value="0" />
<input type="hidden" id="hotel_id" name="hotel_id" value="<?php echo $hotel['hotel_id']?>" />
<input type="hidden" id="datas" name="datas" value="" />
<input type="hidden" id="protrol_code" name="protrol_code" value="" />
<input type="hidden" id="price_type" name="price_type" value="" />
<input type="hidden" id="<?php echo $csrf_token;?>" name="<?php echo $csrf_token;?>" value="<?php echo $csrf_value;?>" />
</form>
<header class="headers"> 
    <div class="headerslide">
    	<?php if(!empty($hotel['imgs']['hotel_lightbox'])) foreach($hotel['imgs']['hotel_lightbox'] as $hl){?>
    	<a class="slideson" <?php if(!empty($gallery_count)){?> href="hotel_photo?id=<?php echo $inter_id;?>&h=<?php echo $hotel['hotel_id']?>"<?php }?>>
    		<img src="<?php echo $hl['image_url'];?>" alt=<?php echo $hl['info'];?> />
         </a>
    	<?php }?>
    </div>
    <?php if(!empty($gallery_count)){?>
    <div class="allimg h22 hide">共<?php echo $gallery_count;?>张</div>
    <?php }?>
    <div class="blackbg webkitbox justify hide">
        <div><?php echo $hotel['name'];?></div>
        <div class="iconfont" like='<?php if(!empty($collect_id)){ echo 'on';}?>' mid="<?php echo $collect_id;?>"><?php if(!empty($collect_id)){ echo '&#x29;';} else{ echo '&#x2a;'; }?></div>
    </div>
</header>
<div class="list_style bd_bottom h24" style="padding-left:30px;">
	<div onclick="tonavigate(<?php echo $hotel['latitude'];?>,<?php echo $hotel['longitude'];?>,'<?php echo $hotel['name'];?>','<?php echo $hotel['address'];?>')" class="webkitbox justify arrow">
    	<span style="margin-left:-17px"><em class="iconfont">&#x36;</em> <?php echo $hotel['address'];?></span>
        <span class="color_main" style="min-width:3rem;">地图</span>
    </div>
	<a href="tel:<?php echo $hotel['tel']; ?>">
		<span style="margin-left:-17px"><em class="iconfont">&#x3f;</em> <?php echo $hotel['tel']; ?></span>
    </a>
	<a href="hotel_comment?id=<?php echo $inter_id;?>&h=<?php echo $hotel['hotel_id'];?>" class="webkitbox justify">
    	<span style="margin-left:-17px">
            <span star="<?php echo $t_t['comment_score'];?>" class="star color_fff">
                <em class="icon"></em><em class="icon"></em><em class="icon"></em><em class="icon"></em><em class="icon"></em>
            </span>
			<?php echo $t_t['comment_score'];?>
        </span>
        <span class="color_main"><?php echo $t_t['comment_count'];?>条评论</span>
    </a>
</div>
<div class="bg_fff webkitbox justify pad3 martop bd h24 " id='checkdate'>
    <span class="checkin" id='checkin'><span class="date"><?php echo date("Y-m-d",strtotime($startdate));?></span>  <span class="week color_888"></span></span>
    <span class="checkout hide" id='checkout'><?php echo date("m月d日",strtotime($enddate));?></span>
    <span class="checkin_time color_main linkblock"><?php echo round(strtotime($enddate)-strtotime($startdate))/86400;?></span>
</div>
<!--- 以上相同部分结束 --->

<!-- 单房价 -->
<div class="room_list" id="room_list">
<?php if(!empty($rooms)) foreach($rooms as $r){?>
	<div class="item bg_fff bd_bottom flex <?php if(!empty($r['state_info']))foreach ($r['state_info'] as $si)if($si['book_status']!='available')echo 'full ';?>">
        <div class="flex flexgrow flexjustify" rid="<?php echo $r['room_info']['room_id']; ?>">
    		<div class="img" onclick="show_room_detail(this,event)">
            	<div class="squareimg"><img class="lazy" src="<?php echo referurl('img','default2.jpg',3,$media_path) ?>"  data-original="<?php echo $r['room_info']['room_img']?>"/></div>
            </div>
        	<div class="room_name" onclick="show_room_detail(this,event)">
				<div>
					<p><?php echo $r['room_info']['name'];?></p>
            		<?php if(!empty($icons_set['coupon_back'])){?><p class="btn_void color_key xs h18">入住返券</p><?php }?>
                	<p class="color_999 h22"><?php echo $r['room_info']['sub_des']; ?></p>
                </div>
                <div class="h22">
                	<span class="color_key">¥</span>
                    <span class="color_key h32"><?php echo $r['lowest']; ?></span>
					<?php /* if($r['favour_price']>0){ ?>
                	<span class="color_999">已优惠<?php echo $r['favour_price']; ?>元</span>
					<?php } */?>
                </div>
            </div>
        </div>
        <?php if(!empty($r['top_price'])){?>
        <div class="full_room">
            <span class="topright color_key"></span>
            <span><?php echo current($r['top_price']);?></span>
        </div>
        <?php }?>
		<?php if(!empty($r['state_info'])){?>
        <div class="showprice">
        <?php foreach ($r['state_info'] as $si){ ?>
            <?php if($si['book_status']=='available'){?>
            <span onClick="pay(this,event)" room_id="<?php echo $r['room_info']['room_id'];?>" price_code="<?php echo $si['price_code'];?>" price_type="<?php echo $si['price_type'];?>">
            <span now class="bg_minor"><?php if (isset($si['condition']['pre_pay'])&&$si['condition']['pre_pay']==1){?><?php echo '预付';} else{ echo '预订'; }?></span></span>
            <?php } else{?>
            <span now class="bg_999">预订</span>
            <?php }?>
        <?php } ?>
        </div>
        <?php }else {?>
        <div class="showprice color_999">不可用</div>
        <?php }?>
    </div><!--item --->
   <?php } ?>
</div><!--room_list --->

<!--  以下为相同部分 -->
<?php if(!empty( $hotel['book_policy'])){?>
<div class="bg_fff">
	<div class="pad3 bd_bottom">酒店政策</div>
	<div class="pad3"><?php echo $hotel['book_policy'];?></div>
</div>
<?php }?>

<?php if(isset($foot_ads['ads']) && !empty($foot_ads['ads'])){ ?>
<div class="h28" style="padding:3% 0;"><?php echo $foot_ads['title']?></div>
<div class="vote_spread">
	<?php foreach($foot_ads['ads'] as $fad){ foreach($fad as $fa){?>
	<a href="<?php echo $fa['ad_link'];?>"><img class="lazy" src="<?php echo referurl('img','default.jpg',3,$media_path) ?>"  data-original="<?php echo $fa['ad_img'];?>" info="<?php echo $fa['ad_title'];?>"/></a>
	<?php }}?>
</div>  
<script>
$(function(){
	var l= $('.vote_spread>*').length;
	if( l>1) $('.vote_spread>*').css('width','50%');
	if( l>2) $('.vote_spread>*').css('width','45%');
});
</script>
<?php }?>

<div class="ui_pull guest_pull" style="display:none">
    <div class="bg_fff pull_box center pad15" style="margin-top:40%">
        <div class="color_main pad3">商务旅客</div>
        <div class="color_main pad3" style="border-bottom:1px solid"><input class="center h22" type="text" placeholder="输入客户协议代码获取协议价"></div>
        <div class="webkitbox center martop">
            <div class="close pad3 color_888"><em class="iconfont h36">&#x27;</em><p class="h20">关闭</p></div>
            <div class="sure pad3 color_main"><em class="iconfont h36">&#x26;</em><p class="h20">确认</p></div>
        </div>
    </div>
</div>

<div class="ui_pull detail_pull" style="display:none">
	<div class="pull_box bg_fff">
    	<div class="pull_loading"><p>正在加载</p></div>
        <div title class="color_main center pad3">-</div>
        <div room_img class="pullscroll"></div>
        <div class="scroll pad3 h20">
            <div sever></div>
            <div content></div>
        </div>
        <div class="close color_888 center"><em class="iconfont h36">&#x27;</em></div>
    </div>
</div>
</body>
<script>
var silde_down=function(_this){
	_this=$(_this).find('.item_right');
	_this.find('em').toggleClass('rotate').toggleClass('torotate');
	_this.siblings('.item_foot').stop().slideToggle();
}
var pay=function(_this,event){
	room_id=$(_this).attr('room_id');
	if(room_id!=undefined){
		rooms={};
		price_codes={};
		price_type={};
		rooms[room_id] = $('#nums').val();
		price_codes[room_id] = $(_this).attr('price_code');
		price_type[$(_this).attr('price_type')] = 1;
		$('#datas').val(JSON.stringify(rooms));
		$('#price_type').val(JSON.stringify(price_type));
		$('#price_codes').val(JSON.stringify(price_codes));
		$('#book_f').submit();
	}
	event.stopPropagation();
}
$(function(){
	$.fn.imgscroll({
		imgrate			 : 640/290, 
	    partent_div      : 'headers',
		circlesize		 : '4px'
	});
	$('.star').each(function(index, element) {
		var point=$(this).attr('star')*1;
		for(var i=0; i<point;i++){
			$('em',this).eq(i).addClass('star1');
			if ( i+1!= point & i+1>point) $('em',this).eq(i).addClass('star2');
			
		}
	});
	$('.room_list .item').eq(0).trigger('click');
	$('.guest').click(function(e){e.stopPropagation();toshow($('.guest_pull'));})
	$('.close').click(toclose);
	$('.guest_pull .sure').click(function(){
		toclose();
		if($('.guest_pull input').val()==''){
			return false;
		}		
		$('#protrol_code').val($('.guest_pull input').val());
		$('.guest').html('<span>'+$('.guest_pull input').val()+'</span>');
		day_rooms($('#startdate').val(),$('#enddate').val());
	});
	var placeholder='';
	$('.guest_pull input').focus(function(){
		placeholder=$(this).attr('placeholder');
		if($(this).val()=='')	$(this).attr('placeholder','');
	})
	$('.guest_pull input').blur(function(){
		$(this).attr('placeholder',placeholder);
	})
	$('[like]').click(function(){
		var _like=$(this);
		pageloading('',0.4);
		if(_like.attr('like')!='on'){
			$.get('/index.php/hotel/hotel/cancel_one_mark?id=<?php echo $inter_id?>',{
				mid:_like.attr('mid')
			},function(data){
				if(data==1){
					_like.attr('like','on');
					$.MsgBox.Alert('已收藏');
					_like.html('&#x29;');
				}	
				removeload();
			});
		}
		else{
			$.get('/index.php/hotel/hotel/add_hotel_collection?id=<?php echo $inter_id?>',{
					hid:'<?php echo $hotel['hotel_id'];?>',
					hname:'<?php echo $hotel['name'];?>',
				},function(data){
				if(data>0){
					_like.attr('mid',data);
					_like.attr('like','off');
					$.MsgBox.Alert('已取消收藏');
					_like.html('&#x2a;');
				}	
				removeload();
			});
		}
	});	
	var overmonth = 0;
	var weekNames = [ '日', '一', '二', '三', '四', '五', '六' ];
	var today=new Date($('#startdate').val());
	var morrow=new Date((today/1000+86400)*1000);
	$('.week').html(weekNames[today.getDay()] );
	var r;
	$('#checkdate').cusCalendar({
		_parent			:'checkdate',
		beginTimeElement:'checkin',
		endTimeElement  :'checkout',
		bTimeValElement :'startdate',
		eTimeValElement :'enddate',
		selectedCallBack:function(data){
			$('#checkin .week').html(weekNames[data.inDate.getDay()] );
			$('#checkin .date').html( data.inDate.getFullYear()+'-'+(data.inDate.getMonth() + 1) + '-' + data.inDate.getDate());
			
			//$('.checkout .week').html(weekNames[data.outDate.getDay()]);
			//$('#checkout').html( (data.outDate.getMonth() + 1) + '月' + data.outDate.getDate() + '日');
			
			$('.checkin_time').html(data.dateSpan);
			day_rooms($('#startdate').val(),$('#enddate').val());
		}
	});
})
function show_room_detail(obj,event){ 
	$('.pullscroll').html('');
	toshow($('.detail_pull'));
	$('.pull_loading').stop().show();
	var _this=$(obj).parents('[rid]');
	$.post("<?php echo site_url('hotel/hotel/return_room_detail').'?id='.$inter_id; ?>",{
		h:"<?php echo $hotel['hotel_id'];?>",
		r:_this.attr('rid')
	},function(data){
		$('.detail_pull [title]').html(data.name);
		var tmphtml='<div class="headerslide">';
		if(data.imgs!=null&&data.imgs.hotel_room_lightbox!=null){
			$.each(data.imgs.hotel_room_lightbox,function(i,n){
				tmphtml+='<span class="slideson"><img src="'+n.image_url+'" /></span>';
			});
		}
		else  tmphtml+='<span class="slideson" title=""><img src="'+data.room_img+'" /></span>';
		tmphtml+='</div>';
		$('.detail_pull [room_img]').html(tmphtml);
		if(data.imgs!=null&&data.imgs.hotel_room_service!=null){
			temp='';
			$.each(data.imgs.hotel_room_service,function(i,n){
				temp+='<div><em class="iconfont">'+n.image_url+'</em>'+n.info+'</div>';
			});
			$('.detail_pull [sever]').html(temp);
		}
		$('.detail_pull [content]').html(data.book_policy);
		$('.pull_loading').stop().hide();
		$.fn.imgscroll({
			imgrate			 : 640/290, 
			partent_div      : 'pullscroll',
			circlesize		 : '4px'
		});
	},'json');

	event.stopPropagation();
}
function day_rooms($startdate,$enddate,$price_code){
	pageloading();
	$.post('/index.php/hotel/hotel/return_more_room?id=<?php echo $inter_id;?>',{
		h:'<?php echo $hotel['hotel_id']?>',
		start:$startdate,
		end:$enddate,
		protrol_code:$('#protrol_code').val()
	},function(data){
			removeload();
			var temp='';
			$.each(data.rooms,function(i,n){
				temp+='<div class="item bg_fff bd_bottom flex';
				if(n.state_info!='')$.each(n.state_info,function(sk,sn){if(sn.book_status!='available')temp+=' full ';})
				temp+='"><div class="flex flexgrow flexjustify" rid="'+n.room_info.room_id+'">';
				temp+='<div class="img"  onclick="show_room_detail(this,event)"><div class="squareimg"><img src="'+n.room_info.room_img+'"/></div></div>';
				temp+='<div class="room_name" onclick="show_room_detail(this,event)">';
				temp+='<div><p>'+n.room_info.name+'</p>';
				<?php if(!empty($icons_set['coupon_back'])){?>
				temp+='<p class="btn_void color_key xs h18">入住返券</p>';
				<?php }?>
				temp+='<p class="color_999 h22">'+n.room_info.sub_des+'</p></div>';
				temp+='<div class="h22"><span class="color_key">¥</span>';
				temp+='<span class="color_key h32">'+n.lowest+'</span>';
//				temp+='<span class="color_999">已优惠40元</span>';				/* -----------新增----------- */
				temp+='</div></div>';
				temp+='</div>';
				if(n.state_info!=''){
					temp+='<div class="showprice">';
					$.each(n.state_info,function(sk,sn){
						if(sn.book_status=='available'){
							temp+='<span onclick="pay(this,event)" room_id="'+n.room_info.room_id+'" price_type="'+sn.price_type+'" price_code="'+sn.price_code+'">';
							temp+='<span now class="bg_minor">'
							if(sn.condition&&sn.condition.pre_pay==1)
								temp+='预付';
							else 
								temp+='预订';
							temp+='</span>';
						}
						else
							temp+='<span now class="bg_999">预订</span>';
					});
					temp+='</div>';
				}
				else{
					temp+='<div class="showprice color_999">不可用</div>';
				}
				temp+='</div>';
				if(n.top_price!=undefined&&n.top_price!=''){
					$.each(n.top_price,function(it,nt){
						temp+='<div class="full_room"><span class="topright color_key"></span><span>'+nt+'</span></div>';
						return false;
					});
				}
				
			});
			$('#room_list').html(temp);
			if(data.errmsg){
				window.setTimeout(function(){
					$.MsgBox.Alert(data.errmsg);
					//$('.guest').html('<span>商务旅客</span><em class="iconfont">&#x2d;</em>');
				},300);
			}
		},'json');
}
</script>
</html>
