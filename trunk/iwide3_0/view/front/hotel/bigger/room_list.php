
<?php include 'header.php' ?>
<?php echo referurl('css','calendar.css',1,$media_path) ?>
<?php echo referurl('js','calendar.js',1,$media_path) ?>
<?php echo referurl('css','swiper.css',1,$media_path) ?>
<?php echo referurl('js','swiper.js',1,$media_path) ?>
<form id="book_f" method="post" action="<?php echo Hotel_base::inst()->get_url("BOOKROOM");?>">
    <input type="hidden" id="startdate" name="startdate" value="<?php echo date('Y/m/d',strtotime($startdate));?>" />
    <input type="hidden" id="enddate" name="enddate" value="<?php echo date('Y/m/d',strtotime($enddate));?>" />
    <input type="hidden" id="nums" name="nums" value="1" />
    <input type="hidden" id="price_codes" name="price_codes" value="0" />
    <input type="hidden" id="hotel_id" name="hotel_id" value="<?php echo $hotel['hotel_id']?>" />
    <input type="hidden" id="datas" name="datas" value="" />
    <input type="hidden" id="protrol_code" name="protrol_code" value="" />
    <input type="hidden" id="price_type" name="price_type" value="" />
    <input type="hidden" id="<?php echo $csrf_token;?>" name="<?php echo $csrf_token;?>" value="<?php echo $csrf_value;?>" />
    <input type="hidden" id="more_room" name="" value="" />
    <input type="hidden" id="package_info" name="package_info" value="" />
    <input type="hidden" id="select_package" name="select_package" value="" />
</form>
<div class="gradient_bg">
    <div class="relative big_banner">
        <div class="overflow">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php if(!empty($hotel['imgs']['hotel_lightbox'])){foreach($hotel['imgs']['hotel_lightbox'] as $hl){?>
                    <div class="swiper-slide squareimg">
                        <a <?php if(!empty($gallery_count)){?> href="<?php echo Hotel_base::inst()->get_url("HOTEL_PHOTO",array('h'=>$hotel['hotel_id']));?>"<?php }?>>
                            <img src="<?php echo $hl['image_url'];?>" alt="<?php echo $hl['info'];?>" />
                        </a>
                    </div>
                    <?php }}else{ ?>
                    <div class="swiper-slide layer_bg">
                        <span class="default_banner_img"></span>
                    </div>
                    <?php }?>
                </div>
            </div>
            <?php if(!empty($hotel['imgs']['hotel_lightbox'])){ ?>
                <div class="roomlist_photo_num swiper-pagination swiper-pagination-fraction"></div>
            <?php }?>
        </div>
        <div class="bg_alpha block wrapper" <?php if(!empty($gallery_count)){?> onclick="window.location.href = '<?php echo Hotel_base::inst()->get_url("HOTEL_PHOTO",array('h'=>$hotel['hotel_id']));?>'"<?php }?>>
            <a href="<?php echo Hotel_base::inst()->get_url("HOTEL_DETAIL",array('h'=>$hotel['hotel_id']));?>">
                <div class="bd_bottom pad_b40 pad_lr40">
                    <div class="txtclip color1 h38"><?php echo $hotel['name'];?></div>
                    <div class="txtclip color2 pad_t10 h24">
                        <em class="iconfont">&#xE002;</em> <?php echo $hotel['address'];?><em class="iconfont">&#xE015;</em>
                    </div>
                </div>
            </a>
        </div>
        <span class="like_ico" like='<?php if(!empty($collect_id)){ echo 'on';}?>' mid="<?php echo $collect_id;?>">
            <?php if(!empty($collect_id)){ ?>
                <em class="iconfont main_color1 h34">&#xE050;</em>
            <?php } else{  ?>
                <em class="iconfont color1 h34">&#xE049;</em>
            <?php }?>
            
        </span>
    </div>
    <div class="wrapper" style="padding-top:0">
        <div class="bd_bottom webkitbox room_information" style="width:100%;">
            <div class="room_list_score pad_r10" style="font-family: Helvetica, sans-serif;"><?php echo $t_t['comment_score'];?></div>
            <div class="flexgrow mar_l20">
                <div class="iconfont star h26">
                    <?php for($x = 0; $x < 5; $x++){ ?>
                        <?php if($x < round($t_t['comment_score'])) { ?>
                        <span>&#xE017;</span>
                        <?php } else { ?>
                        <span class="off">&#xE017;</span>
                    <?php } }?>
                </div>
                <div class="h24 color2 mar_t10">
                    <a href="<?php echo Hotel_base::inst()->get_url("HOTEL_COMMENT",array('h'=>$hotel['hotel_id']));?>">
                        <?php echo $t_t['comment_count'];?>条评论<em class="iconfont">&#xE015;</em>
                    </a>
                </div>
            </div>
            <span class="main_line room_list_line flexgrow"></span>
            <div class="color3 h24 flexgrow" id="checkdate">
                <div>入住 <span class="color2 checkin h28"></span></div>
                <div>离店 <span class="color2 checkout h28"></span></div>
            </div>
            <div class="iconfont color2 flexgrow">&#xE014;</div>
        </div>
        <div class="main_tab webkitbox color2 center <?php if(empty($packages))echo 'hide_pack';?>"><!-- hide_pack -->
            <p class="main_tab_choose flexgrow h32 color1 room_list_choose" id="j-reservation">预定酒店 <span class="shadow_b"></span></p>
            <span class="main_tab_line"></span>
            <p class="main_tab_choose flexgrow h32 room_list_choose" id="j-swim">畅享套餐  <span class="shadow_b" style="display:none;"></span></p>
            <span class="main_tab_line"></span>
            <p class="main_tab_choose flexgrow h24 color3" id="business_portal">商务入口<em class="iconfont">&#xE015;</em></p>
        </div>
        <div class="room_list_wrapper">
            <div class="room_list" id="reserve_room_list">
                <?php if(!empty($rooms)){foreach($rooms as $r){?>
                    <div class="item mar_b40">
                        <div class="relative">
                            <div class="img" rid="<?php echo $r['room_info']['room_id']; ?>">
                                <div class="squareimg" onclick="show_room_detail(this,event)">
                                    <?php if(empty($r['room_info']['room_img']) || $r['room_info']['room_img']==''){ ?>
                                     <span class="default_room_img"></span>
                                    <?php }else{ ?>
                                    <img class="lazy" src="<?php echo $r['room_info']['room_img'];?>"  data-original="<?php echo referurl('img','default2.jpg',3,$media_path) ?>"/>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="imgtitle">
                                <span class="color1 h30"><?php echo $r['room_info']['name'];?> <em class="iconfont">&#xE005;</em></span>
                                <div class="h24 color2 server point mar_t5 room_list_describe">
                                    <span><?php echo $r['room_info']['area'];?>㎡</span>
                                    <?php if(!empty($r['room_info']['sub_des'])){ ?>
                                    <span><?php echo $r['room_info']['sub_des'];?></span>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="color3 pad_tb30 pad_lr30 h24 clearfix">
                            <?php if(!empty($r['state_info'])){?>
                                <div class="original_price">
                                    <del class=" mar_r10"><em class="h28">¥</em><tt class="h48"><?php echo $r['room_info']['oprice'];?></tt></del>
                                    <span class="h24">门市价</span>
                                </div>
                                <?php if( $r['lowest']>=0){?>
                                <div class="discount_price">
                                  <span class="main_color1 iconfont mar_r5 h28">&#xFFE5;<tt class="h48"><?php echo $r['lowest']; ?></tt></span>
                                   <span class="color3 h24">起</span>  
                                </div> 
                                <?php }?>
                            <?php }?>
                            <span class="floatr pad_t10 room_collect"><em class="iconfont color1 room_triangle h24">&#xE013;</em> </span>
                        </div>
                        <div class="itemfoot layer_bg bd_list">
                            <?php if(!empty($r['state_info'])){ foreach($r['state_info'] as $si){?>

                            <?php if($si['book_status']=='available'){ ?>
                            <div class="flex flexjustify relative h24">
                                <div class="room_list_word">
                                    <span class="h30 color2 room_list_card" name="<?php echo $si['price_name'];?>"><?php echo $si['price_name'];?> <em class="iconfont color3 room_list_question"  price_des="<?php echo $si['des'];?>" show_info="<?php json_encode($r['show_info']);?>" type=<?php echo $si['price_type'];?>>&#xE011;</em></span>
                                    <?php if (!empty($si['price_tags'])){foreach ($si['price_tags'] as $tag){?>
                                    <div class="h20 point room_list_exclusive" style="color:#c3b686"><span><?php echo $tag;?></span></div>
                                    <?php }}?>
                                    <?php if(isset($si['useable_coupon_favour']) && !empty($si['useable_coupon_favour'])){ ?>
                                        <div class="h20 point room_list_exclusive" style="color:#c3b686"><span><?php echo '券可减'.$si['useable_coupon_favour'].'元';?></span></div>
                                    <?php }?>
                                    <?php if($si['wxpay_favour_sign']==1){?>
                                        <div class="h20 point room_list_exclusive" style="color:#c3b686"><span><?php echo '微信支付减'.$si['bookpolicy_condition']['wxpay_favour'].'元';?></span></div>
                                    <?php }?>
                                </div>
                                <div style="min-width:25px;">
                                <?php if(isset($si['bookpolicy_condition']['breakfast_nums']) && !empty($si['bookpolicy_condition']['breakfast_nums'])){ ?>
                                    <span class="color3"><?php echo $si['bookpolicy_condition']['breakfast_nums'];?></span>
                                <?php }?>
                                </div>
                                <?php if($si['avg_price']>=0){ ?>
                                    <span class="color1 room_list_number h28">&#xFFE5;<tt class="h34"><?php echo $si['avg_price'];?></tt></span>
                                <?php } ?>
                                <div class="main_color1 bookBtn h22 bookBtn_need">
                                <?php if (isset($si['condition']['pre_pay'])&&$si['condition']['pre_pay']==1){ ?>
                                    <div class="iconfont color1" onClick="pay(this,event)" packages="" room_id="<?php echo $r['room_info']['room_id'];?>" price_code="<?php echo $si['price_code'];?>" price_type="<?php echo $si['price_type'];?>">预定</div>
                                    <hr>
                                    <div class="pre h18 color2">需预付</div>
                                <?php }else{?>
                                    <div class="iconfont color1 room_reserve" onClick="pay(this,event)" packages="" room_id="<?php echo $r['room_info']['room_id'];?>" price_code="<?php echo $si['price_code'];?>" price_type="<?php echo $si['price_type'];?>">预定</div>
                                <?php } ?>
                                </div>
                            </div>
                            <?php }else{ ?>
                                    <div class="pad_tb20 pad_lr20 h24">
                                        <span class="h30 color2 room_list_card"><?php echo $si['price_name'];?></span>
                                        <span class="floatr pad_t10"> 满房</span>
                                    </div>
                            <?php }}}?>
                        </div>
                    </div>
                <?php }}?>
            </div> 
            <div class="room_list" id="package_room_list" style="display:none;">

                <?php if(!empty($packages)){ foreach($packages as $pkeys=>$package_info){ ?>
                    <div class="item mar_b40 <?php if($package_info['package_info']['sale_way']!=1){ echo 'room_free_choice'; }?>" >
                        <div class="relative <?php if($package_info['package_info']['sale_way']==1){ echo 'package_show'; }?>" price_code="<?php echo $package_info['state_info']['price_code'];?>" sale_way="<?php echo $package_info['package_info']['sale_way'];?>" hotel_id="<?php echo $hotel['hotel_id'];?>" rid="<?php echo $package_info['room_info']['room_id'];?>" packages_key='<?php echo $pkeys;?>'>
                            <div class="img">
                                <div class="squareimg">
                                    <img src="<?php echo $package_info['room_info']['room_img'];?>" />
                                </div>
                            </div>
                            <div class="imgtitle">
                                <span class="color1 h30"><?php echo $package_info['show_price_name'];?> <?php if($package_info['package_info']['sale_way']==1){ ?><em class="iconfont">&#xE005;</em><?php }?></span>
                                <div class="h24 color2 server point mar_t10 room_list_describe">
                                    <span><?php echo $package_info['room_info']['area'];?>㎡</span>
                                    <?php if(!empty($package_info['room_info']['sub_des']) && $package_info['room_info']['sub_des']!=''){ ?><span><?php echo $package_info['room_info']['sub_des'];?></span><?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="color3 pad20 h24">
                            <span class="main_color1 iconfont h28">&#xFFE5<tt class="h48"><?php echo $package_info['package_info']['total_show_price'];?></tt></span>
                            <div class="main_color1 bookBtn h24 floatr">
                                <?php if($package_info['book_status']=='available'){ ?>
                                    <?php if(isset($package_info['package_info']['sale_way']) && $package_info['package_info']['sale_way']==1){ ?>
                                        <span class="iconfont h30 color1 single" onClick="pay(this,event)" packages_key='<?php echo $pkeys;?>' room_id="<?php echo $package_info['room_info']['room_id'];?>" price_code="<?php echo $package_info['state_info']['price_code'];?>" price_type="<?php echo $package_info['state_info']['price_type'];?>">预定</span>
                                    <?php }else{ ?>
                                        <span class="iconfont h30 color1 single" onClick="select_packages(this,event)" room_price="<?php echo json_encode($package_info['package_info']['total_show_price']);?>" packages_key='<?php echo $pkeys;?>' room_id="<?php echo $package_info['room_info']['room_id'];?>" room_name="<?php echo $package_info['room_info']['name'];?>" price_code="<?php echo $package_info['state_info']['price_code'];?>" price_type="<?php echo $package_info['state_info']['price_type'];?>">选择</span>
                                    <?php }?>
                                <?php }elseif($package_info['book_status']=='disabled'){ ?>
                                    <span class="iconfont h30 color1 single">已售罄</span>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                <?php }}?>
            </div>
        </div>
    </div>

        <?php if(!empty( $hotel['book_policy'])){?>
        <div class="center pad_lr20 mar_t20" style="padding-top:22px;">
             <span class="h32 color1 inblock relative w40 pad_b10">酒店政策 <span class="shadow_b"></span></span>
             <div class="color2 h26 lineheight txt_l pad_lr30" style="margin-top:23px;">
                 <?php echo $hotel['book_policy'];?>
             </div>
        </div>
        <?php }?>
        <?php include 'footer.php' ?>
    </div>
  
<section class="whole_eject" id="room_description_wrap" style="display:none;">
</section>
<section class="whole_eject" id="room_package_wrap" style="display:none;">
</section>
<section class="whole_eject"  style="display:none;" id="comment_verification">
    <div class="whole_eject_small bg_282828 pad_lr60 pad_b60" style="padding-top:2.312rem;">
        <em class="close iconfont color6">&#xE000;</em>
        <div class="center">
            <p class="color1 h32">商务客户预定验证</p>
            <input id="business_val" class="color1 h30" placeholder="请输入商务协议码">
            <div id="comment_reserve" class="iconfont button spacing h32  mar_t80">确定</div>
        </div>
    </div>
</section>
<section class="whole_eject"  style="display:none" id="room_member_wrap">
    <div class="whole_eject_small bg_282828 pad_lr60 pad_b60" style="padding-top:2.312rem;">
        <em class="close iconfont color6">&#xE000;</em>
        <div class="center" id="price_code_show">

            <div  class="iconfont button spacing h32 room_list_reserve mar_t80" >确定</div>-->
        </div>
    </div>
</section>
<section class="whole_eject" style="display:none;padding:0px;" id="package_select_wrap">
    <div class="fixed_btn main_bg1 pad_l80 flexjustify">
        <div class="h20 color_fff pad_tb20">
            <span><tt class="iconfont">&#xFFE5;</tt><em class="h48">3490</em></span>
<!--            <span class="pad_l30">选好了</span>-->
        </div>
        <a href="/index.php/hotel/hotel/order_details?state=1" class="iconfont color_fff center pad_tb20 pad_lr80">&#xe016;</a>
    </div>
</section>
</body>
<?php echo referurl('js','room_list.js',1,$media_path) ?>
<script>
    var check_times = 0;

    var packages_array = {};
    <?php foreach($packages as $key=>$temp_package){?>
       packages_array[<?php echo $key;?>] = JSON.parse('<?php echo addslashes(json_encode($temp_package['package_info']));?>');
    <?php }?>


    $('#checkdate').cusCalendar({
        beginTime:parserDate($("#startdate").val()),
        endTime  :parserDate($("#enddate").val()),
        success  :function(date){
            var N =function(num){
                if(num<10) return '0'+num;
                else return num;
            }
            $('.checkin').html(N(date.beginTime.getMonth()+1)+'/'+N(date.beginTime.getDate()));
            $('.checkout').html(N(date.endTime.getMonth()+1)+'/'+N(date.endTime.getDate()));


            if(check_times!=0){
                pageloading('',0.4);

                $("#startdate").val((date.beginTime.getFullYear())+'/'+N(date.beginTime.getMonth()+1)+'/'+N(date.beginTime.getDate()));
                $("#enddate").val((date.endTime.getFullYear())+'/'+N(date.endTime.getMonth()+1)+'/'+N(date.endTime.getDate()));

                day_rooms($("#startdate").val(),$("#enddate").val());

            }
            check_times++;

        }
    });

    function day_rooms($startdate,$enddate){

        $.post('<?php echo Hotel_base::inst()->get_url("RETURN_MORE_ROOM");?>',{
            h:'<?php echo $hotel['hotel_id']?>',
            start:$startdate,
            end:$enddate,
            mem_level:<?php echo $member->level;?>,
            <?php if(isset($tc_id)) echo 'tc_id:'.$tc_id.',';?>
            protrol_code:$('#protrol_code').val()
        },function(data){
            packages_array = {};
            $.each(data.packages,function(pk,ps){
                packages_array[pk] = ps.package_info;
            })
//                    pageloading('',0.4);
            initHtml(data,true);
            $("#more_room").val(JSON.stringify(data));
        },'json');

    }
    if ($("#more_room").val() != "") { 
      initHtml(JSON.parse($("#more_room").val()),false)
    }
    function initHtml(data,bol){
        var r_temp='';
        var p_temp = '';
        //r_temp+='<div class="room_list" id="reserve_room_list">';
       $.each(data.rooms,function(rk,rs){
            r_temp+='<div class="item mar_b40"><div class="relative">'

            r_temp+='<div class="img" rid="'+rs.room_info.room_id+'"><div class="squareimg" onclick="show_room_detail(this,event)">';

            if(rs.room_info.room_img==undefined || rs.room_info.room_img==''){
                r_temp +='<span class="default_room_img"></span></div></div>';
            }else{
                r_temp+='<img class="lazy" src="'+rs.room_info.room_img+'" data-original="<?php echo referurl('img','default2.jpg',3,$media_path) ?>"/></div></div>';
            }

            r_temp+='<div class="imgtitle">';
            r_temp+='<span class="color1 h30">'+rs.room_info.name+' <em class="iconfont">&#xE005;</em></span><div class="h24 color2 server point mar_t5 room_list_describe">';

            r_temp+='<span>'+rs.room_info.area+'㎡</span>';

            if(rs.room_info.sub_des !=undefined && rs.room_info.sub_des !=''){
                r_temp+='<span>'+rs.room_info.sub_des+'</span>';
            }

            r_temp+='</div></div></div><div class="color3 pad_tb30 pad_lr30 h24 clearfix">';

            if(rs.state_info !=undefined){
                r_temp+='<div class="original_price"><del class=" mar_r10"><em class="h28">¥</em><tt class="h48">'+rs.room_info.oprice+'</tt></del>';

                r_temp+='<span class="h24">门市价</span></div>';


                if(rs.lowest >=0){
                    r_temp+='<div class="discount_price"><span class="main_color1 iconfont mar_r5 h28">&#xFFE5;<tt class="h48">'+ rs.lowest+'</tt></span><span class="color3 h24">起</span></div>';
                }
            }

            r_temp+='<span class="floatr pad_t10 room_collect"><em class="iconfont color1 room_triangle h24">&#xE013;</em> </span> </div>';

            r_temp+='<div class="itemfoot layer_bg bd_list">';

                if(rs.state_info !=undefined){

                    $.each(rs.state_info,function(sk,si){

                        if(si.book_status=='available'){

                            r_temp+='<div class="flex flexjustify relative h24"><div class="room_list_word">';

                            r_temp+='<span class="h30 color2 room_list_card">'+si.price_name+' <em class="iconfont color3 room_list_question">&#xE011;</em></span>';

                            if(si.price_tags !=undefined){

                                $.each(rs.price_tags,function(pk,pt){
                                    r_temp +='<div class="h20 point room_list_exclusive" style="color:#c3b686"><span>'+pt+'</span></div>'
                                })
                            }

                            if(si.useable_coupon_favour !=undefined && si.useable_coupon_favour!=''){
                                    r_temp +='<div class="h20 point room_list_exclusive" style="color:#c3b686"><span>券可减'+si.useable_coupon_favour+'元</span></div>';
                            }

                            if(si.wxpay_favour_sign ==1){
                                r_temp +=' <div class="h20 point room_list_exclusive" style="color:#c3b686"><span>微信支付减'+si.bookpolicy_condition.wxpay_favour+'元</span></div>';
                            }

                            r_temp +='</div><div style="min-width:25px;">';

                            if(si.bookpolicy_condition.breakfast_nums !=undefined && si.bookpolicy_condition.breakfast_nums!=''){
                                r_temp +='<span class="color3">'+si.bookpolicy_condition.breakfast_nums+'</span>';
                            }
                            r_temp +='</div>'
                            if(parseFloat(si.avg_price) >=0){
                                r_temp +='<span class="color1 room_list_number h28">&#xFFE5<tt class="h34">'+si.avg_price+'</tt></span>';
                            }

                            r_temp +='<div class="main_color1 bookBtn h22 bookBtn_need" href="/index.php/hotel/hotel/submit_order">';
                            if(si.condition.pre_pay !=undefined && si.condition.pre_pay==1){

                            r_temp +='<div class="iconfont color1" onClick="pay(this,event)" packages="" room_id="'+ rs.room_info.room_id+'" price_code="'+ si.price_code+'" price_type="'+ si.price_type+'">预定</div> <hr>';

                            r_temp +='<div class="pre h18 color2">需预付</div>';
                            }else{
                                r_temp +='<div class="iconfont color1 room_reserve" onClick="pay(this,event)" packages="" room_id="'+ rs.room_info.room_id+'" price_code="'+ si.price_code+'" price_type="'+ si.price_type+'">预定</div>';
                            }

                            r_temp +='</div></div>';

                        }else{
                            r_temp +='<div class="pad_tb20 pad_lr20 h24"><span class="h30 color2 room_list_card">'+si.price_name+'</span><span class="floatr pad_t10">满房</span></div>';
                        }
                    })
                }
            r_temp +='</div></div>';
        })


        if(data.packages !=undefined && data.packages !=''){

            $.each(data.packages,function(pk,pi){

                if(pi.package_info.sale_way!=undefined && pi.package_info.sale_way==1){
                    p_temp +="<div class='item mar_b40'><div class='relative package_show' hotel_id='<?php echo $hotel['hotel_id'];?>' rid='"+pi.room_info.room_id+"' packages_key='"+ pk+"'>";
                }else{
                    p_temp +="<div class='item mar_b40 room_free_choice'><div class='relative' hotel_id='<?php echo $hotel['hotel_id'];?>' rid='"+pi.room_info.room_id+"' packages_key='"+ pk+"'>";
                }

                p_temp +='<div class="img"><div class="squareimg"><img src="'+pi.room_info.room_img+'"/></div></div>';

                p_temp +='<div class="imgtitle"><span class="color1 h30">'+pi.show_price_name;


                if(pi.package_info.sale_way!=undefined && pi.package_info.sale_way==1){
                    p_temp +=' <em class="iconfont">&#xE005;</em>';
                }

                p_temp +='</span><div class="h24 color2 server point mar_t10 room_list_describe">';

                p_temp +='<span>'+pi.room_info.area+'㎡</span>';

                if(pi.room_info.sub_des!=undefined && pi.room_info.sub_des!=''){
                    p_temp +='<span>'+pi.room_info.sub_des+'</span>';
                }

                p_temp +='</div></div></div>';

                p_temp +='<div class="color3 pad20 h24"><span class="main_color1 iconfont h28">&#xFFE5<tt class="h48">'+pi.package_info.total_show_price+'</tt></span>';

                p_temp +=' <div class="main_color1 bookBtn h24 floatr">';

                if(pi.book_status=='available'){
                    if(pi.package_info.sale_way!=undefined && pi.package_info.sale_way==1){
                        p_temp +="<span class='iconfont h30 color1 single' onClick='pay(this,event)' packages_key='"+pk+"' room_id='"+ pi.room_info.room_id+"' price_code='"+ pi.state_info.price_code +"' price_type='"+ pi.state_info.price_type + "'>预定</span>";
                    }else{
                        p_temp +="<span class='iconfont h30 color1 single' onClick='select_packages(this,event)' room_price='"+JSON.stringify(pi.package_info.total_show_price)+"' packages_key='"+pk+"' room_id='"+ pi.room_info.room_id+"' room_name='"+ pi.room_info.name+"' price_code='"+ pi.state_info.price_code +"' price_type='"+ pi.state_info.price_type +"'>选择</span>";
                    }
                }else if(pi.book_status=='disabled'){
                    p_temp +="<span class='iconfont h30 color1 single'>已售罄</span>";
                }


                p_temp +='</div></div></div>';

            })
        }

        $("#reserve_room_list").html(r_temp);
        $("#package_room_list").html(p_temp);
        removeload();

        return;

    }

    function show_room_detail(obj,event){
        pageloading();
        var _this=$(obj).parents('[rid]');
        $.post("<?php echo site_url('hotel/hotel/return_room_detail').'?id='.$inter_id; ?>",{
            h:"<?php echo $hotel['hotel_id'];?>",
            r:_this.attr('rid')
        },function(data){
            var tmphtml='<div class="h20 layer_bg whole_eject_content scroll"><em class="close iconfont color1" id="close_h_detail">&#xE000;</em>';

                if (data.room_img != '') {
                    tmphtml+='<div class="squareimg room_description mar_b60"><img src="'+data.room_img+'" alt=""></div>';
                } else {
                    tmphtml+= '<span class="default_sresult_img"></span>'
                }
                
            if(data.imgs!=null&&data.imgs.hotel_room_service!=null){
                tmphtml+='<div class="clearfix room_description_rows pad_b40">';
                $.each(data.imgs.hotel_room_service,function(i,n){
                    tmphtml+='<div class="float"><em class="iconfont">'+n.image_url+'</em><span class="h28">'+n.info+'</span></div>';
                })
            }
            tmphtml+='</div><div class="room_description_rows pad_t30 bd_top h28 color2 pad_b20">';
            tmphtml+='<p class="">建筑面积 : <span class="mar_l10">'+data.area+'㎡</span></p>';
            tmphtml+='<p class="">'+data.book_policy+'</p>';
            tmphtml+='</div>';
            $("#room_description_wrap").html(tmphtml);
            removeload();
            $("#room_description_wrap").show();
            setheight();
        },'json');
        event.stopPropagation();
    }


    var pay=function(_this,event){
        room_id=$(_this).attr('room_id');
        if(room_id!=undefined){
            rooms={};
            price_codes={};
            price_type={};
            packages = {};
            rooms[room_id] = $('#nums').val();
            price_codes[room_id] = $(_this).attr('price_code');
            price_type[$(_this).attr('price_type')] = 1;


            if($(_this).attr('packages') !='' || $(_this).attr('packages_key') !=''){
                if($(_this).attr('packages') !='' && $(_this).attr('packages') !=undefined){
                    var temp_package = JSON.parse($(_this).attr('packages'));
                }else if($(_this).attr('packages_key') !='' && $(_this).attr('packages_key') !=undefined){
                    var packages_id = $(_this).attr('packages_key');
                    var temp_package = packages_array[packages_id].items;
                }

                var choose_package_price = 0;

                $.each(temp_package,function(k,g){
                    packages[g.goods_id] = {
                        'gid' : g.goods_id,
                        'nums' : g.nums
                    }
                    choose_package_price = choose_package_price + parseInt(g.nums)*parseFloat(g.price);
                })

                if($(_this).attr('sale_way')!=undefined && choose_package_price==0){
                    $.MsgBox.Alert('至少选择一样商品');return;
                }

                packages = JSON.stringify(packages);
                $('#package_info').val(packages);

            }else{

                $('#package_info').val('');
            }


            $('#datas').val(JSON.stringify(rooms));
            $('#price_type').val(JSON.stringify(price_type));
            $('#price_codes').val(JSON.stringify(price_codes));


            $('#book_f').submit();
        }
        event.stopPropagation();
    }


    var select_packages=function(_this,event){

        var packages_price = 0;

        var packages_id = $(_this).attr('packages_key');
//        var packages_id = JSON.parse($(_this).attr('packages'));
//        console.log(packages_array);
        var choose_packages = packages_array[packages_id].items;

        var choose_room_name = $(_this).attr('room_name');
        var choose_room_id = $(_this).attr('room_id');
        var choose_price_code = $(_this).attr('price_code');
        var choose_price_type = $(_this).attr('price_type');
        var room_price = $(_this).attr('room_price');
        var default_packages ={};
    
        if(packages_id !=undefined && packages_id!=''){
            var temp_choose_packages = [];
            $.each(choose_packages,function(k,g){
                if(g.selectnum !=0){
                    default_packages[g.goods_id] = {
                        'goods_id':g.goods_id,
                        'goods_name':g.goods_name,
                        'price':g.price,
                        'nums':g.selectnum
                    };
                    temp_choose_packages.push(default_packages[g.goods_id]);
                }
            })
        }
        $("#select_package").val(JSON.stringify(temp_choose_packages));

        var p_temp ='';
        p_temp+=' <section class="h20 gradient_bg whole_eject_content pad_tb40 pad_lr30 scrollWrapper" id="choose_package_box"><div class="swiper-wrapper" style="padding-bottom:80px;"><div class="swiper-slide" style=" height: auto;padding-bottom:80px">';//<em class="close iconfont color1">&#xE000;</em>
        p_temp+='<div class="orderhead relative mar_t20" style="padding-top: 0.55rem;">';
        p_temp+='<div class="shadow_r package_select_shadow"></div><p class="color1 h32">请勾选您需要的商品</p><p class="h24 mar_tb20"><span class="mar_r10 color3">组合已选房型</span>';
        p_temp+='<span class="mar_r10 color2">'+choose_room_name+'</span><span class="mar_r10 color3">购买更优惠</span></p></div><div class="mar_b60 mar_t20">';

        $.each(choose_packages,function(k,g){
            p_temp+='<div class="commodity_rows border_radius layer_bg mar_b30">';

            if(g.book_status=='available'){
                if(g.selectnum==0){
                    p_temp += '<label class="check main_color1" ><input type="checkbox"  class="room_check"  onclick="mark_packages(this,event)"><em></em></label>';
                }else{
                    p_temp += '<label class="check main_color1" ><input type="checkbox" checked class="room_check"  onclick="mark_packages(this,event)"><em></em></label>';
                }
            }

            p_temp +='<div class="commodity_img_wrap"><div class="img"><div class="squareimg">';

            p_temp+='<img src="'+ g.intro_img+'" alt=""></div></div><div class="commodity_img_wrap_zhe"></div></div>';

            p_temp+='<div class="commodity_img_content"><p class="color1 h32 pad_t40 pad_r20 txtclip goods_info" goods_id='+ g.goods_id+'>'+ g.goods_name + '</p>';
            p_temp+='<div class="mar_t20 mar_b10" style="margin-left:-18px;"><span class="main_color1 iconfont mar_r10"><tt class="iconfont h24">&#xFFE5;</tt><span class="h36 room_price">'+ g.price + '</span></span></div>';

            // p_temp+='<span class="color2 h24">'+ g.nums + g.unit + '</span></div></div>';

            p_temp+='<span class="color3 commodity_details_ico h24">详情  <i class="iconfont package_detail_ico">&#Xe013;</i></span><div class="inblock number_control h30 floatr">';


            if(g.book_status=='available'){
                p_temp+=  '<span class="reduce_room ';
                if(g.selectnum==0){p_temp += 'off'; }
                p_temp+='">-</span><span class="number_control_main room_num h32">'+ g.selectnum+'</span>';
                p_temp+='<span class="add_room ';
                if(g.selectnum>= g.nums){p_temp += 'off'; }
                p_temp+= '" max_nums='+ g.nums + '>+</span></div></div>';
                p_temp+='<div class="clear bd_top pad_lr40 pad_tb40 package_detail">';
                p_temp+='<div class="lineheight color3 h24">'+ g.short_intro + '</div></div></div>';
            }else if(g.book_status=='full'){
                p_temp+=  '<span>已售罄</span></div></div></div>';
            }


            packages_price = packages_price + g.price;

        })

        p_temp+='</div></section>';

        p_temp+='<div class="fixed_btn main_bg1 pad_l80 flexjustify"><div class="color_fff p315"><span><tt class="h26">￥</tt><em class="h48 room_total">'+ room_price+'</em></span><span class="pad_l30 h24">选好了</span></div>';

        p_temp+="<div id='packages_sure' class='color_fff center iconfont pad_tb20 pad_lr80 h36' sale_way=2 onclick='pay(this,event)' packages='"+JSON.stringify(temp_choose_packages)+"'";
        p_temp+='price_code="'+choose_price_code+'" price_type="'+choose_price_type+'" room_id='+choose_room_id+ '>&#xe016;</div></div></div></section>';

        $("#package_select_wrap").html(p_temp);
        toshow("#package_select_wrap")
        var swiper = new Swiper('.scrollWrapper', {
            direction: 'vertical',
            slidesPerView: 'auto',
            mousewheelControl: true,
            freeMode: true
        });
        setheight();
    }

    $(document).on("click",".close",function(){
        $(".whole_eject").hide();
        cloheight();
    });

    $(document).on("click",".package_show",function(){

        var hid = $(this).attr('hotel_id');
        var rmid = $(this).attr('rid');
        var sale_way = $(this).attr('sale_way');
//        var packages_detail = JSON.parse($(this).attr('packages'));
        var packages_id = $(this).attr('packages_key');
        var packages_detail = packages_array[packages_id];
        var package_price_code = $(this).attr('price_code');


        pageloading();
        var show_pd = '';
        show_pd +='<div class="h20 layer_bg whole_eject_content pad_t40 scroll"><em class="close iconfont color6">&#xE000;</em><div class="main_tab center color2"><p class="main_tab_choose h32 color1" id="room_details">房型详情 <span class="shadow_b"></span></p>';
        show_pd +='<span class="main_tab_line"></span><p class="main_tab_choose h32" id="package_details">套餐详情 <span class="shadow_b" style="display:none;"></span></p></div><div>';

        $.post("<?php echo site_url('hotel/hotel/return_room_detail').'?id='.$inter_id; ?>",{
            h:hid,
            r:rmid
        },function(data){

            show_pd +='<div id="room_details_contents" class="wrapper" style="padding-top:0px;"><div class="h20 pad_t20">'
            if (data.room_img != '') {
                show_pd+='<div class="squareimg room_description mar_b60" style="border-radius:0px;"><img src="'+data.room_img+'" alt=""></div>';
            } else {
                show_pd+= '<span class="default_sresult_img"></span>'
            }          

            if(data.imgs!=null&&data.imgs.hotel_room_service!=null){

                show_pd+='<div class="clearfix room_description_rows pad_b40" style="margin:0px;">';
                $.each(data.imgs.hotel_room_service,function(i,n){
                    show_pd+='<div class="float"><em class="iconfont">'+n.image_url+'</em><span class="h28">'+n.info+'</span></div>';
                })
            }

            show_pd+='</div><div class="room_description_rows pad_t30 bd_top h28 color2 pad_b20"  style="margin:0px;">';
            show_pd+='<p class="">建筑面积 : <span class="mar_l10">'+data.area+'㎡</span></p>';
            show_pd+='<p class="">'+data.book_policy+'</p>';
            show_pd+='</div></div>';

            if(sale_way==1){
                show_pd +='<div class="main_bg1 h34 pad_tb30 center w100 color1" onclick="pay(this,event)" price_code='+ package_price_code + ' price_type='+ package_price_code +' room_id='+rmid+' packages_key='+packages_id+'>立即预定</div>';
            }


            show_pd +='</div><div id="package_details_contents" style="display:none;"><div class="wrapper h28">';

            show_pd +='<p class="color3 mar_b20">订购须知</p>';

            show_pd +='<p class="color3 mar_b20">'+packages_detail.sale_notice+'</p>';

            show_pd +='<p class="color3 mar_b20">套餐明细</p>';

            if(packages_detail.items!=null){
                $.each(packages_detail.items,function(pk,p){
                    show_pd += '<p class="mar_b20">'+p.goods_name+'</p>';
                    show_pd += '<p style="line-height: 25px;">'+p.details+'</p>';
                })
            }

            if(sale_way==1){
                show_pd +='<div class="main_bg1 h34 pad_tb30 mar_t40 center w100 color1" onclick="pay(this,event)"  price_code='+ package_price_code + ' price_type='+ package_price_code +' room_id='+rmid+' packages_key='+packages_id+'>立即预定</div>';
            }

            show_pd +='</div></div>';

            removeload();

            $("#room_package_wrap").html(show_pd);
            $("#room_package_wrap").show();
            setheight();
        },'json');
    
    })

    $("#package_select_wrap").on("click",".commodity_details_ico",function(){
        $(this).parents(".commodity_rows").toggleClass("package_detail_show")
    })
    
    $("#package_select_wrap").on("click",".add_room",function(){
        if($(this).hasClass("off")) return;
        $room_num = $(this).siblings(".room_num");
        var _num = Number($room_num.html());
        max_nums = $(this).attr('max_nums');

        if(_num==0){
            var _obj = $(this).parents(".commodity_rows").find(".room_check");
            if(!_obj.is(':checked')){
                _obj.click();
                _num++;
                if(_num == max_nums){$(this).addClass("off");}
            }
        }else{
            if(_num >= max_nums){$(this).addClass("off");return;}
            _num++;
            if(_num == max_nums){$(this).addClass("off");}
            $room_num.html(_num);
            $(this).siblings(".reduce_room").removeClass("off");

            var _obj = $(this).parents(".commodity_rows").find(".room_check");
            if(_obj.is(':checked')){
                mark_packages(_obj,event,"add");
            }
        }
    })
    $("#package_select_wrap").on("click",".reduce_room",function(){
        if($(this).hasClass("off")) return;
         $room_num = $(this).siblings(".room_num");
        var _num = Number($room_num.html());
        _num--;
        if(_num < 1){
            $(this).addClass("off");
            var _obj = $(this).parents(".commodity_rows").find(".room_check");
            if(_obj.is(':checked')){
                _obj.click();
            }
            $(this).parents(".commodity_rows").find(".room_check")
            
        }
        $room_num.html(_num);
        $(this).siblings(".add_room").removeClass("off");
        var _obj = $(this).parents(".commodity_rows").find(".room_check");
        if(_obj.is(':checked')){
            mark_packages(_obj,event,"reduce");
        }    
    });

    function mark_packages(obj,event,type){
    
        var _parent = $(obj).parents(".commodity_rows"),
            _price  = Number(_parent.find(".room_price").html());
            if( _parent.find(".room_num").html() == 0){
                _parent.find(".room_num").html(1);
                _parent.find(".reduce_room").removeClass("off");
            }
        var _num    = Number(_parent.find(".room_num").html()),
            _totel  = _price * _num,
            temp_packages = {},
            packagesdata = JSON.parse($("#packages_sure").attr("packages"));


            var _roomTotel = Number($(".room_total").html());


            var _id =_parent.find(".goods_info").attr('goods_id');
            temp_packages = {
                    'goods_id' : _id,
                    'goods_name' : _parent.find(".goods_info").html(),
                    'price' : _parent.find(".room_price").html(),
                    'nums' : _parent.find(".room_num").html()
            }

            if($(obj).is(':checked')){
                if(type != undefined){
                    for (var pitem in packagesdata){
                            if(packagesdata[pitem]['goods_id']==_id){
                                packagesdata.splice(packagesdata.indexOf(packagesdata[pitem]),1);
                                packagesdata.push(temp_packages);
                            }
                    }
                }else{
                    packagesdata.push(temp_packages)
                }

            }else{
                for (var pitem in packagesdata){
                    if(packagesdata[pitem]['goods_id']==_id){
                        packagesdata.splice(packagesdata.indexOf(packagesdata[pitem]),1);
                    }
                }
            }
            $("#packages_sure").attr("packages",JSON.stringify(packagesdata));


            if(type == "add"){
                $(".room_total").html((_roomTotel+_price).toFixed(2));
                return;
            }else if(type == "reduce"){
                $(".room_total").html((_roomTotel-_price).toFixed(2));
                return;
            }

            if($(obj).is(':checked')){
                $(".room_total").html((_roomTotel+_totel).toFixed(2));
            }else{
                $(".room_total").html((_roomTotel-_totel).toFixed(2));
            }
    }

    $("#comment_reserve").on("click",function(){
        $('#protrol_code').val($("#business_val").val());
        $("#comment_verification").hide();
        pageloading('',0.4);
        day_rooms($("#startdate").val(),$("#enddate").val());
    });

    $(document).on("click",".room_list_reserve",function(){
        $(".whole_eject").hide();
        cloheight();
    });

    $(document).on("click",".room_list_question",function(){
        var sptemp = '';
        if($(this).attr('type')=='member' && $(this).attr('show_info')!=undefined && $(this).attr('show_info')!=''){

            var show_info = JSON.parse($(this).attr('show_info'));
            sptemp += '<p class="color1 h32 member_point_wrap">金房卡会员价</p><div>';

            $.each(show_info,function(i,n){
                sptemp +='<div class="clearfix mar_t50"><div class="float h30"><span class="room_member_circle" style="background-color: #276940;"></span> ';
                sptemp +='<span class="color1">'+ n.price_name+'</span></div>';
                sptemp +='<div class="floatr"><span class="color1"><em class="h18">¥</em>';
                sptemp +='<tt class="h30">'+ n.avg_price+'</tt></span>';
                sptemp +='<span class="h24 color3">'+ n.related_des+'</span></div></div>';
            })
            sptemp +='</div><div class="iconfont button spacing h32 room_list_reserve mar_t80" >确定</div>';

        }else{
            sptemp += '<p class="color1 h32 member_point_wrap">'+ $(this).parent().attr('name')+'</p><div>';
            sptemp += $(this).attr('price_des');
            sptemp +='</div><div class="iconfont button spacing h32 room_list_reserve mar_t80" >确定</div>';
        }

        $("#price_code_show").html(sptemp);
        $("#room_member_wrap").show();
    })


    $('[like]').click(function(){
        var _like=$(this);
        pageloading();
        if(_like.attr('like')=='on'){
            $.get( "<?php echo site_url('hotel/hotel/cancel_one_mark').'?id='.$inter_id; ?>",{
                mid:_like.attr('mid')
            },function(data){
                if(data==1){
                    _like.attr('mid',data);
                    _like.attr('like','off');
                    $.MsgBox.Alert('已取消收藏');
                    _like.find("em").addClass("color1").removeClass("main_color1").html('&#xE049;');
                }
                removeload();
            });
        }
        else{
            $.get("<?php echo site_url('hotel/hotel/add_hotel_collection').'?id='.$inter_id; ?>",{
                hid:'<?php echo $hotel['hotel_id'];?>',
                hname:'<?php echo $hotel['name'];?>',
            },function(data){
                if(data>0){
                    _like.attr('like','on');
                    $.MsgBox.Alert('已收藏');
                    _like.find("em").addClass("main_color1").removeClass("color1").html('&#xE050;');
                }
                removeload();
            });
        }
    });


</script>
</html>