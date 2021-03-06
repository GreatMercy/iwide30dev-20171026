
<?php include 'header.php' ?>
<?php echo referurl('css','swiper.css',1,$media_path) ?>
<?php echo referurl('js','swiper.js',1,$media_path) ?>
<input type="hidden" id="off" name="off" value='<?php echo $nums;?>' />
<input type="hidden" id="num" name="num" value='<?php echo $nums;?>' />
<input type="hidden" id="hotel_id" name="hotel_id" value='<?php echo $hotel_id;?>' />
<div class="gradient_bg wrapper" style="padding-top:2.215rem;">
    <div class="comment_head relative mar_b10">
        <div class="shadow_r"></div>
        <p class="comment_score mar_t10 mar_b10 color1 iconfont"><?php echo $t_t['comment_score'];?></p>
        <div class="mar_t20 comment_star star">
            <?php for($x = 0; $x < 5; $x++){ ?>
                <?php if($x < round($t_t['comment_score'])) { ?>
                 <em class="iconfont h42">&#xE017;</em>
                <?php } else { ?>
                 <em class="iconfont h42 off">&#xE017;</em>
            <?php } }?>
        </div>
        <div class="mar_t60">
            <div class="clearfix mar_t20">
                <span class="float h24" style="letter-spacing:7px;"><?php if(isset($comment_config->clean_score)){ echo $comment_config->clean_score;}else{ echo "卫生";}?></span>
                <div class="float mar_l10">
                    <span class="score_bar color5_bg_gradient" style="width:calc(2.2rem * <?php if(isset($t_t['clean_score'])){echo $t_t['clean_score'];}else{ echo 0;}?>);"></span>
                </div>
                <span class="float mar_l20 h24 color3"><?php if(isset($t_t['clean_score'])){echo $t_t['clean_score'];}else{ echo 0;}?></span>
            </div>
            <div class="clearfix mar_t20">
                <span class="float h24" style="letter-spacing:7px;"><?php if(isset($comment_config->net_score)){ echo $comment_config->net_score;}else{ echo "网络";}?></span>
                <div class="float mar_l10">
                    <span class="score_bar color5_bg_gradient" style="width:calc(2.2rem * <?php if(isset($t_t['net_score'])){echo $t_t['net_score'];}else{ echo 0;}?>);"></span>
                </div>
                <span class="float mar_l20 h24 color3"><?php if(isset($t_t['net_score'])){echo $t_t['net_score'];}else{ echo 0;}?></span>
            </div>
            <div class="clearfix mar_t20">
                <span class="float h24" style="letter-spacing:7px;"><?php if(isset($comment_config->facilities_score)){ echo $comment_config->facilities_score;}else{ echo "设施";}?></span>
                <div class="float mar_l10">
                    <span class="score_bar color5_bg_gradient" style="width:calc(2.2rem * <?php if(isset($t_t['facilities_score'])){echo $t_t['facilities_score'];}else{ echo 0;}?>);"></span>
                </div>
                <span class="float mar_l20 h24 color3"><?php if(isset($t_t['facilities_score'])){echo $t_t['facilities_score'];}else{ echo 0;}?></span>
            </div>
            <div class="clearfix mar_t20">
                <span class="float h24" style="letter-spacing:7px;"><?php if(isset($comment_config->service_score)){ echo $comment_config->service_score;}else{ echo "服务";}?> </span>
                <div class="float mar_l10 h24 color3">
                    <span class="score_bar color5_bg_gradient" style="width:calc(2.2rem * <?php if(isset($t_t['service_score'])){echo $t_t['service_score'];}else{ echo 0;}?>);"></span>
                </div>
                <span class="float mar_l20 h24 color3"><?php if(isset($t_t['service_score'])){echo $t_t['service_score'];}else{ echo 0;}?></span>
            </div>
        </div>
    </div>
    <div class="pad_t40">
        <p class="h24 color3 mar_b40">大家都在说</p>
        <div class="clearfix">
            <div class="comment_type h24">
                <span class="">全部</span>
                <span class="color3">(<?php echo $t_t['comment_count'];?>)</span>
                <span class="shadow_b"></span>
            </div>
            <div class="comment_type h24">
                <span class="">有图评价</span>
                <span class="color3">(<?php if(isset($t_t['image_count'])){echo $t_t['image_count'];}else{ echo 0;}?>)</span>
                <span class="shadow_b"></span>
            </div>
            <?php
                if(isset($t_t['keyword'])){
                    foreach($t_t['keyword'] as $arr){
                        if($arr['count']!=0){
            ?>
                        <div class="comment_type h24">
                            <span class=""><?php echo $arr['keyword'];?></span>
                            <span class="color3">(<?php echo $arr['count'];?>)</span>
                            <span class="shadow_b"></span>
                        </div>
            <?php
                        }
                    }
                }
            ?>
        </div>
    </div>
    <div class="comment_list">
        <?php if(!empty($comments)){foreach($comments as $c){if((!empty($c['content']) && isset($c['type']) && $c['type']=='user') && ($c['status']==1 || (isset($member->open_id) && $c['openid']==$member->open_id))){?>
        <div class="bd_top pad_b50 pad_t60 comment_list_rows">
            <div class="clearfix">
                <div class="float mar_r20 comment_portrait">
                    <?php if(!empty($c['headimgurl'])){?><img src="<?php echo $c['headimgurl'];?>"><?php } else {?> <img src="/public/hotel/bigger/images/head.png" ?><?php } ?>
                </div>
                <div class="float">
                    <p class="h28 color2"><?php echo $c['nickname'];?></p>
                    <p class="h24 color3"><?php echo date('m/d',$c['comment_time']);?></p>
                </div>
                <div class="comment_list_score floatr color3">
                    <?php if(!empty($c['score'])){?>
                        <?php echo $c['score'];?>
                    <?php }?>
                </div>
            </div>
            <p class="comment_list_word mar_t40 h28 color1 lineheight17"><?php echo $c['content'];?></p>
            <div class="comment_list_img mar_t40 swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    if(isset($c['images']) && !empty($c['images'])){
                            foreach($c['images'] as $c_arr){
                                ?>
                                <div class="squareimg swiper-slide <?php if(count($c['images']) == 1) {echo "comment_only";} ?>">
                                    <img src="<?php echo $c_arr;?>" alt="">
                                </div>
                            <?php
                            }
                        }
                    ?>
                </div>
            </div>
            <?php if(isset($c['feedback_content'])){  ?>
            <div class="mar_t60 color2 h28">
                <div class="comment_hotel_click inblock">
                    <p class="comment_hotel_hide">收起酒店回复<span class="iconfont mar_l10 inblock">&#xE013;</span></p>
                    <p class="comment_hotel_show">查看酒店回复<span class="iconfont rotate180 mar_l10 inblock">&#xE013;</span></p>
                </div>
            </div>
            <p class="layer_bg h28 border_radius pad_tb30 pad_lr40 mar_t40 lineheight17 comment_hotel_content">
                <span class="color3">酒店回复：</span>
                <span class="color2"><?php echo $c['feedback_content'];?></span>
            </p>
            <?php }?>
        </div>  
        <?php }}}else{?>
        <div class="blankpage" style="margin-top:50px">
            <p class="iconfont">&#xe019;</p>
            <p class="color3 center h28"><a href="<?php echo Hotel_base::inst()->get_url("INDEX",array('h'=>$hotel_id))?>">暂无评论~ 快来下单体验吧！</a></p>
        </div>
        <?php }?>
    </div>
    <div class="fixed_btn main_bg1 center">
        <div class="h34 pad_tb30 center w100"><a class="color1" href="<?php echo Hotel_base::inst()->get_url("INDEX",array('h'=>$hotel_id))?>">立即预定</a></div>
    </div>
    <?php include 'footer.php' ?>
    <div style="padding-top:65px"></div>
</div>
<div class="back_ico"></div>
</body>
<script type="text/javascript">
    var isload =false;

    $(".comment_type").on("click",function(){
//        $(this).addClass("comment_type_active").siblings().removeClass("comment_type_active");
    })
       var swiper = new Swiper('.comment_list_img', {
         slidesPerView: 'auto'
        // paginationClickable: true,
        // centeredSlides:true,
    });

    $(".comment_word_click").on("click",function(){
        $(this).parents(".comment_list_rows").toggleClass("comment_list_all")
    });

    $(".comment_hotel_click").on("click",function(){
        $(this).parents(".comment_list_rows").toggleClass("comment_hotel_all")
    });
    $(".squareimg").on("click",function(){
        var self = $(this);
        var imgList=self.parents(".swiper-wrapper").find('img');  
        var urlList=[];  
        imgList.each(function(){  
            var url=$(this).attr('src');  
            console.log(url)
            url=window.encodeURI(url);  
            urlList.push(url);  
        });  
        console.log(urlList)
        wx.previewImage({  
            current:urlList[self.index()],  
            urls:urlList  
        });  
    })

    function fill_comments(){
        var num = $('#num').val();
        var off = $('#off').val();

        $.get('<?php echo site_url('hotel/Hotel/ajax_hotel_comments').'?id='.$inter_id;?>',{
            h:$('.hotel_id').val(),
            off:off,
            num:num
        },function(data){
            var tmp='';
            if(data.s==1){
                $.each(data.data,function(ck,cc){
//                console.log(cc);
                    if(cc.content!=''){
                        tmp+='<div class="bd_top pad_b50 pad_t60 comment_list_rows"><div class="clearfix"><div class="float mar_r20 comment_portrait">';
                        if(cc.headimgurl !=undefined && cc.headimgurl!=''){
                            console.log(cc.headimgurl);
                            tmp+='<img src="'+cc.headimgurl+'">';
                        }
                        tmp+='</div><div class="float">';

                        if(cc.nickname!=''){
                            tmp+='<p class="h28 color2">'+cc.nickname+'</p>';
                        }else{
                            tmp+='<p class="h28 color2">微信用户</p>';
                        }

                        tmp+='<p class="h24 color3">'+date(cc.comment_time)+'</p></div><div class="comment_list_score floatr color3">';

                        if(cc.score !=undefined){
                            tmp+=cc.score;
                        }

                        tmp +='</div></div>';

                        tmp+='<p class="comment_list_word mar_t40 h28 color1 lineheight17">'+cc.content+'</p>';

                        tmp+='<div class="comment_list_img mar_t40 swiper-container"><div class="swiper-wrapper">';

                        if(cc.images !=undefined && cc.images!=''){
                            $.each(cc.images,function(ik,ci){
                                tmp+='<div class="squareimg swiper-slide"><img src="'+ci+'" alt=""></div>';
                            })
                        }

                        tmp+='</div></div>';

                        if(cc.feedback_content !=undefined){
                            tmp+='<div class="mar_t60 color2 h28"><div class="comment_hotel_click inblock">';
                            tmp+='<p class="comment_hotel_hide">收起酒店回复<span class="iconfont mar_l10 inblock">&#xE013;</span></p>';
                            tmp+='<p class="comment_hotel_show">查看酒店回复<span class="iconfont rotate180 mar_l10 inblock">&#xE013;</span></p>';
                            tmp+='</div></div>';
                            tmp+='<p class="layer_bg h28 border_radius pad_tb30 pad_lr40 mar_t40 lineheight17 comment_hotel_content"><span class="color3">酒店回复：</span>';
                            tmp+='<span class="color2">'+cc.feedback_content+'</span></p>';
                        }
                        tmp+='</div>';
                    }
                })
                $('#off').val(parseInt(off)+parseInt($('#num').val()));
                $('.comment_list').append(tmp);
            }
            isload = false;
        },'json');

    }


    function date(time){

        var date = new Date(parseInt(time)*1000);
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = (date.getDate() < 10 ? '0'+(date.getDate()) : date.getDate()) + ' ';
        h = (date.getHours() < 10 ? '0'+(date.getHours()) : date.getHours()) + ':';
        m = (date.getMinutes() < 10 ? '0'+(date.getMinutes()) : date.getMinutes());


        return (Y+M+D+h+m);

    }

    var  startX ,startY;
    $(document).bind('touchstart',function(e){
        startX = e.touches[0].pageX,
            startY = e.touches[0].pageY;
    });
    $(document).on('touchmove',function(e){
        endX = e.touches[0].pageX,
            endY = e.touches[0].pageY;
        //获取滑动距离
        distanceX = endX-startX;
        distanceY = endY-startY;
        // console.log(distanceY+'----'+($(document).height()-$(window).height())*0.4+'----'+$('body').scrollTop())
        if(distanceY<0&&($(document).height()-$(window).height())<=$('body').scrollTop()){
            if (!isload){
                e.preventDefault();
                fill_comments();
                isload  = true;
            }
            else{
                showload();
            }
        }
    })
</script>
</html>