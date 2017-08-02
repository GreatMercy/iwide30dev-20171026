<?php if(!empty($result)){ foreach($result as $r){?>
	<div onclick="go_hotel('<?php echo site_url('hotel/hotel/index?id=').$inter_id.'&h='.$r->hotel_id;?>')" tmp="<?php echo $r->hotel_id?>" class="webkitbox justify">
    	<?php if( isset($r->is_new_open)&&$r->is_new_open == 1){?>
    	<div class="new_store">新开业</div>
    	<?php }?>
        <div class="img"><div class="squareimg"><img src="<?php echo $r->intro_img?>" /></div></div>
        <div class="info">
            <div class="name"><?php echo $r->name;?><?php if( isset($r->is_tuan)&&$r->is_tuan == 1){?><img src="/public/hotel/su8/images/tag01.jpg"><?php }?></div>
            <?php if(!empty($r->comment_data)){?>
            <div class="ever"><span class="color_main"><?php if(isset($r->comment_data['good_rate'])&&$r->comment_data['good_rate']!='-1'){ ?><?php echo $r->comment_data['good_rate'];?>%好评</span>/<?php }?>
<?php if(isset($r->comment_data['comment_count'])){?><span class="color_888"><?php echo $r->comment_data['comment_count'];?>条评论</span><?php }?></div>
            <div class="address h20 color_888"><?php if(isset($r->distance)){?>距离<span><?php echo $r->distance;?></span>Km<?php }?></div>
            <?php }?>
            <div class="sever h20">
            	<?php if(!empty($r->service)){ foreach ($r->service as $rs) {?> <em class="iconfont"><?php echo $rs['image_url'];?></em><?php }}?>
            </div>
           <?php if(!empty($r->search_icons)){?>
            <div class="tag">
            	<?php foreach ($r->search_icons as $icon){?>
              	  <img src="<?php echo $icon;?>" style="height:10px; width:auto" />
                <?php }?>
            </div>
            <?php }?>
        </div>
        <div class="price color_888" style="font-size:10px">
        <?php if(!empty($r->lowest)){?>
            <div class="qi"><span class="color_main">¥</span><span class="color_main h36" id="lowest_p_<?php echo $r->hotel_id;?>"><?php echo $r->lowest;?></span></div>
            <div class="h6 tag">
            <?php if( isset($r->is_balance_pay)&&$r->is_balance_pay == 1){?><img src="/public/hotel/su8/images/tag02.png"><?php }?>
            </div>
            <?php }else{?>
            <div id="lowest_p_<?php echo $r->hotel_id;?>">暂无价格</div>
            <?php }?>
        </div>
    </div>
    <?php }?>
    <?php }?>