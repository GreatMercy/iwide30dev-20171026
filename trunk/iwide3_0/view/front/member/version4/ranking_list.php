<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="format-detection" content="telephone=no,email=no">
<meta name="ML-Config" content="fullscreen=yes,preventMove=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=320,initial-scale=1,user-scalable=0">
<script src="<?php echo base_url("public/member/version4.0/js/jquery.min.js"); ?>"></script>
<link href="<?php echo base_url("public/member/version4.0/css/my.css"); ?>" rel="stylesheet">
<title>每日签到</title>
</head>
<body class="">
<div class="title"><img src="<?php echo base_url('public/member/version4.0/images/trophy.png'); ?>">今日排行</div>
<div class="ranking" style="overflow-y:auto">
    <div class="con_rank">
        <?php if(empty($rankingData)): ?>
            <div class="my_ranking display_flex">
                今日暂无人签到
            </div>
        <?php else: ?>
            <?php if(!empty($myRankingInfo)): ?>
                <div class="my_ranking display_flex">
                    <div><?php echo $myRankingInfo['name']; ?></div>
                    <div><?php echo $myRankingInfo['ranking_date']; ?></div>
                    <div class="m_number "><?php echo $myRankingInfo['day_ranking']; ?></div>
                </div>
            <?php else: ?>
                <div class="my_ranking display_flex">
                    您今日还没签到
                </div>
            <?php endif; ?>
            <?php foreach($rankingData as $v): ?>
            <div class="my_ranking display_flex border_bottom">
                <div><?php echo $v['name']; ?></div>
                <div><?php echo $v['ranking_date']; ?></div>
                <div class="m_number">
                    <?php if($v['day_ranking'] == 1): ?>
                        <img src="<?php echo base_url('public/member/version4.0/images/gold.png'); ?>">
                    <?php elseif($v['day_ranking'] == 2):?>
                        <img src="<?php echo base_url('public/member/version4.0/images/silver.png'); ?>">
                    <?php elseif($v['day_ranking'] == 3):?>
                        <img src="<?php echo base_url('public/member/version4.0/images/copper.png'); ?>">
                    <?php else: ?>
                        <?php echo $v['day_ranking']; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<script>
$(function(){
	if(($('.m_number').html()<<0)!=0&&$('.m_number').html()<10){
		$('.m_number').css({"padding-right":"1em"});
	}

    //ajax start 杰
    var t_h=$('.title').height();
    var w_h=$(window).height();
    var ran_h=w_h-t_h;
    $('.ranking').css({"height":ran_h+"px"})
    var number=1;
    var str="";
    var bool=true;
    var drop_down_h=$('.ranking').height();
    $('.ranking').scroll(function(){
        var c_h=$('.con_rank').height();
        if(c_h-drop_down_h<=$('.ranking').scrollTop()+30){
            if(bool){
                bool=false;
                $('.con_rank').append("<p class='isLoad' style='text-align:center;color:#999;font-size:15px'>正在加载中</p >");
                d_ajax();
            }
        }
    });
    function d_ajax(){
        $.ajax({
            url:'<?php echo base_url('index.php/membervip/sign/ajax_get_ranking?page='); ?>' + number,
            type: "GET",
            dataType:'json',
            error: function(xhr) {
                alert('请求失败');
            },
            success:function(data){
                if(data.end==0){
                    number++;
                    str = data.data;
                    html='';
                    for(x in str){
                        var name = str[x].name;
                        if(!name){
                            name = '';
                        }
                        html+='<div class="my_ranking display_flex border_bottom"><div>' + name + '</div><div>' + str[x].ranking_date + '</div><div class="m_number">' + str[x].day_ranking + '</div></div>';
                    }

                    $('.isLoad').remove();
                    $('.con_rank').append(html);
                    bool=true;
                }else{
                    $('.isLoad').remove();
                    $('.con_rank').append("<p class='isLoad' style='text-align:center;color:#999;font-size:15px'>已全部加载完</p >")
                }
            }
        });
    }
    //ajax end 杰
})
</script>
</body>
</html>