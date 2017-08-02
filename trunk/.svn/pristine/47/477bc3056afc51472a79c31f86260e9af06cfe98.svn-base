if (document.cancelFullScreen) {
    document.cancelFullScreen();
} else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
} else if (document.webkitCancelFullScreen) {
    document.webkitCancelFullScreen();
}
var isIOS = !!navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
function loadvideo(str,str2){
    if(isIOS){
        $(".ioslayer").removeClass("none").attr({"src":str,"poster":str2});
    }else{
        $(".ioslayer").removeClass("none")
        var flashvars={
            p:1,
            e:1,
            i:str2
        };
        
        var video=[str+'->video/m3u8'];
        var support=['all'];
        CKobject.embedHTML5('a1','ckplayer_a1','100%','100%',video,flashvars,support);
        setTimeout(function(){
            CKobject.videoPlay();
            setTimeout(function(){
                 CKobject.quitFullScreen();
                },2000);
        },2000);
    }
}
$(document).on("click",function(){
    if(isIOS){
        $(".ioslayer")[0].play();
    }else{
        CKobject.videoPlay();
    }
});
$(document).on("change", "input", function() {
    document.body.scrollTop = 0;
});
$(document).on("touchmove", function(e) {
    e.preventDefault();
});
var tao = new Tao();
$(".footer>flex ib").on("touchend", function() {
    $(this).addClass("beclick");
});
$(".footer").on("webkitAnimationEnd animationEnd", ".beclick", function() {
    $(this).removeClass("beclick");
});
var width = (window.innerWidth - 80) * 0.44;
$(".daxia,.xiami").css("height", width + "px");

$(".btn_close_zhibo").on("touchstart", function() {
    $(".zhiding").removeClass("none");
});
$(".btn_close").on("touchstart", function() {
    window.close();
});
$(".btn_noclose").on("touchstart", function() {
    $(".zhiding").addClass("fadeOut").removeClass("fadeIn");
});
$(document).on("webkitAnimationEnd animationEnd", ".fadeOut", function() {
    $(this).removeClass("fadeOut").addClass("fadeIn none");
    $(".down").removeClass("blur");
});
$(document).on("webkitAnimationEnd animationEnd", ".fadeOut.gift", function() {
    $(this).find(".wenhao-info").addClass("none");
});
$(".btn_goewm").on("touchstart", function() {
    $(".ewm").removeClass("none");
});
$(".btn_ewm_back").on("touchstart", function() {
    $(".ewm").addClass("fadeOut").removeClass("fadeIn");
});
$(".btn_share_in").on("touchstart", function() {
    $(".share").removeClass("none");
});
$(".btn_share_back").on("touchstart", function() {
    $(".share").addClass("fadeOut").removeClass("fadeIn");
});
$(".btn_gift_in").on("touchstart", function() {
    $(".gift").removeClass("none");
    mohu();
});
$(".btn_gift_back").on("touchstart", function() {
    $(".gift").addClass("fadeOut").removeClass("fadeIn");
    qingxi();
});
$(".wenhao").on("touchstart", function() {
    $(".wenhao-info").removeClass("none");
});
$(".choice-gift>flex>ib").on("touchstart", function() {
    $(".choice-gift>flex>ib").removeClass("gift-choiced");
    $(this).addClass("gift-choiced");
});
$(".btn_go_geren").on("touchstart", function() {
    window.location = "user-info.html";
});
if(window.__wxjs_is_wkwebview){
    $(".input_body").css("position","fixed");
    $(document).on("resize",function(){
        document.body.scrollIntoView(false);
    });
}
var jsq;
$(".btn_message").on("touchstart", function() {
    $(".goinput").removeClass("none");
    $(".goinput").find("input").select();
    if(!window.__wxjs_is_wkwebview){
        var obj = document.querySelector(".input_body");
        obj.scrollIntoView(false);
        jsq = setInterval(function(){
            obj.scrollIntoView(false);
        },20);
    }
});
$(".input_body").on("focus",function(){
    if(!window.__wxjs_is_wkwebview){
    setTimeout(function(){
        this.scrollIntoView(false);
    }.bind(this),20);
}
});
$(".btn_input_back").on("touchstart", function() {
    $(".goinput").addClass("fadeOut").removeClass("fadeIn");
    $(".goinput").find("input").blur();
    document.body.scrollTop = 0;
    clearInterval(jsq);
});
var pd_scroll = new IScroll(".package_detail", {
            bounce : false
        });
var gouwu_switch = true;
$(".gouwu").on("touchstart", function() {
    $(".goods").removeClass("none");
    if (gouwu_switch) {
        new IScroll(".goods_body", {
            scrollX: true,
            scrollY: false
        });
        gouwu_switch = false;
    }
    mohu();
});
$(".btn_goods_back").on("touchstart", function() {
    qingxi();
    $(".goods").addClass("fadeOut").removeClass("fadeIn");
});

function mohu() {
    $(".down").removeClass("qingxi").addClass("blur");
}

function qingxi() {
    $(".down").removeClass("blur").addClass("qingxi");
}
$(document.body).css("height", window.innerHeight + "px");
$(document.body).css("width", window.innerWidth + "px");
var cans = document.querySelector(".lover").getContext("2d");
var img = new Image();
img.src = "img/orange.svg";
var img2 = new Image();
img2.src = "img/orange1.svg";
var img3 = new Image();
img3.src = "img/pink.svg";
var img4 = new Image();
img4.src = "img/po.svg";
var Cans;
var img = [img, img2, img3, img4]
    /**
     * @param {[img,img..]}
     */
var Love = function(img) {
    var whichone = parseInt(Math.random() * 3);
    this.beishu = 1;
    if (whichone == 2) {
        this.beishu = 0.3;
    }
    this.source = img[whichone];
    this.size = (Math.random() * 50 + 50);
    this.angel = Math.random() * 40 + 70;
    var hengxiang = Math.random()*20
    this.point = [140 - (this.size / 2) + hengxiang, 200 - this.size];
    this.speed = (Math.random() * 0.3 + 0.3);
    this.action = (new Date()).getTime();
    this.total = (200 - this.size) / Math.sin(this.angel * 0.017453293);
}
Love.prototype.track = function() {
        var spend = (new Date()).getTime() - this.action;
        var distance = this.speed * spend / 10;
        var opacity = (this.total - distance) / this.total;
        opacity = opacity <= 0 ? 0 : opacity;
        opacity = opacity * this.beishu;
        if (this.angel > 90) {
            var newangel = this.angel - 90;
            newangel = newangel * 0.017453293;
            var now_position_x = this.point[0] - distance * (Math.sin(newangel));
            var now_position_y = this.point[1] - distance * (Math.cos(newangel));
            return [now_position_x, now_position_y, opacity];
        } else {
            var newangel = this.angel;
            newangel = newangel * 0.017453293;
            var now_position_x = this.point[0] + distance * (Math.cos(newangel));
            var now_position_y = this.point[1] - distance * (Math.sin(newangel));
            return [now_position_x, now_position_y, opacity];
        }
    }
    /**
     * @param {需要渲染的canvas}
     * @param {[img,img,..]}
     */
var DrawCanvas = function(cans, img) {
    this.img = img;
    this.cans = cans;
    this.source = [];
    this.draw();
}
DrawCanvas.prototype.add = function() {
    this.source.push(new Love(this.img));
}
DrawCanvas.prototype.draw = function() {
    this.cans.clearRect(0, 0, 200, 200);
    if (this.source[0]) {
        for (var i = 0; i < this.source.length; i++) {
            if (this.source[i].track()[0] <= -this.source[i].size || this.source[i].track()[1] <= -this.source[i].size || this.source[i].track()[0] >= 200 + this.source[i].size) {
                this.source.splice(i, 1);
            } else {
                this.cans.save();
                this.cans.globalAlpha = this.source[i].track()[2];
                this.cans.drawImage(this.source[i].source, this.source[i].track()[0], this.source[i].track()[1], this.source[i].size, this.source[i].size);
                this.cans.restore();
            }
        }
    }
    var req = window.requestAnimationFrame(function() {
        this.draw();
    }.bind(this));
}
Cans = new DrawCanvas(cans, img);
setInterval(function() {
    Cans.add();
}, 350);

function showgoods() {
    $(".bubble_single").removeClass("none");
}

function hiddengoods() {
    $(".bubble_single").removeClass("zoomInLeft").addClass("zoomOutLeft");
}
$(document).on("webkitAnimationEnd animationEnd", ".zoomOutLeft", function() {
    $(this).removeClass("zoomOutLeft").addClass("zoomInLeft none");
});
setTimeout(function() {
    showgoods();
    setTimeout(function() {
        hiddengoods();
    }, 1500);
}, 5000);

$(".gouwu_texiao").on("webkitAnimationEnd animationEnd", function() {
    $(this).addClass("none");
    $(".gouwu_icon").addClass("zhuan");
});
$(".gouwu_icon").on("webkitAnimationEnd animationEnd", function() {
    $(".gouwu_texiao").removeClass("none");
    $(this).removeClass("zhuan");
});
function setTime(e) {
    this.action = e;
    this.loop();
}
setTime.prototype.loop = function() {
    var now = (new Date()).getTime();
    var cha = now - this.action;
    var back = this.change("hh:mm:ss",cha);
    $(".zhibo_time").html(back);
    setTimeout(function(){
        this.loop();
    }.bind(this),1000);
}
setTime.prototype.change = function(fmt,ts) {
    var days = Math.floor(ts / (24 * 3600 * 1000));
    var leave1 = ts % (24 * 3600 * 1000);
    var hours = Math.floor(leave1 / (3600 * 1000));
    var leave2 = leave1 % (3600 * 1000) //计算小时数后剩余的毫秒数
    var minutes = Math.floor(leave2 / (60 * 1000))
        //计算相差秒数
    var leave3 = leave2 % (60 * 1000) //计算分钟数后剩余的毫秒数
    var seconds = Math.round(leave3 / 1000)
    var o = {
        "d+": days, //日 
        "h+": hours, //小时 
        "m+": minutes, //分 
        "s+": seconds, //秒  
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (dateoj.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
function action() {
     $.ajax({
        type: "POST",
        data:"",
        url: "./json/action.json",
        dataType: "json",
        async:false,
        success: function(e){
            load(e);
        },
        complete: function(e) {
            var thejson = eval('(' + e.responseText + ')');
            load(thejson);
        }
    });
}
action();
var total_currency;
function load(data) {
    var data = data.data;
    var Live_time = data.Live_time,
        audience = data.audience,
        audience_photo = data.audience_photo,
        user_info_currency = data.user_info.currency + "个",
        user_info_gifts = data.user_info.gifts + "个",
        goods_quantity = data.goods_quantity,
        goods = data.goods,
        gift1_price = data.gift1_price,
        gift2_price = data.gift2_price,
        video_url = data.play_url,
        video_pic = data.pic_url;
    new setTime(Live_time);
    loadvideo(video_url,video_pic);
    total_currency = parseInt(user_info_currency);
    $(".audience").html(audience);
    var audience_photo_html = "";
    for (var i = 0; i < audience_photo.length; i++) {
        audience_photo_html = audience_photo_html + '<ib><img src=' + audience_photo[i] + '></ib>';
    }
    $(".headimg").html(audience_photo_html);
    $(".user_gifts").html(user_info_gifts);
    $(".currency").html(user_info_currency);
    $(".left_currency").html(user_info_currency);
    $(".gouwu")[0].dataset.number = goods_quantity;
    $(".gift1_price").html("(" + gift1_price + ")虾币");
    $(".gift2_price").html("(" + gift2_price + ")虾币");
    var goods_each_html = "";
    for (var i = 0; i < goods.length; i++) {
        var song = goods[i].gift ? '<ib>送'+goods[i].gift+'虾币</ib>' : '';
        goods_each_html = goods_each_html + '<ib class="goods_each"><block><ib class="goods_icon"><img class="w100" src='+goods[i].img+'></ib><div class="goods_name_info"><div><ib><ib class="goods_num">'+goods[i].number+'号</ib>'+goods[i].name+'</ib></div><div class="ginfo"><ib>'+goods[i].info+'</ib></div></div></block><block class="goods_bottom"><div class="goods_price"><ib><span>￥</span>'+goods[i].price+'</ib>'+song+'</div><div><ib class="btn_buy"><ib>立即购买</ib><ib style="width: 5px;padding-left: 5px"><img src="img/arrow.png" class="w100"></ib></ib></div></block></ib>';
    }
    $(".goods_body>ib").html(goods_each_html);
    $(".xiami")[0].dataset.price = gift1_price;
    $(".daxia")[0].dataset.price = gift2_price;
}



$(".daxia,.xiami").on("touchstart",function(){
    var howmanyucanbuy = parseInt(total_currency/parseInt(this.dataset.price));
    $(".choice-number>flex>ib").removeClass("number-choiced").removeClass("number-cant").removeClass("number-can");
    if(howmanyucanbuy >= 200){
        $(".big").addClass("number-can");
        $(".middle").addClass("number-can");
        $(".small").addClass("number-can number-choiced");
        $(".thistime_used").html(this.dataset.price);
    }else if(howmanyucanbuy >= 10){
        $(".big").addClass("number-cant");
        $(".middle").addClass("number-can");
        $(".small").addClass("number-can number-choiced");
        $(".thistime_used").html(this.dataset.price);
    }else if(howmanyucanbuy >= 1){
        $(".big").addClass("number-cant");
        $(".middle").addClass("number-cant");
        $(".small").addClass("number-can number-choiced");
        $(".thistime_used").html(this.dataset.price);
    }else{
        (".big").addClass("number-cant");
        $(".middle").addClass("number-cant");
        $(".small").addClass("number-cant");
        $(".thistime_used").html("0");
    }
});
$(document).on("touchstart",".number-can",function(){
    var price = parseInt($(".gift-choiced")[0].dataset.price);
    var number = parseInt($(this).html());
    $(".choice-number>flex>ib").removeClass("number-choiced");
    $(this).addClass("number-choiced");
    $(".thistime_used").html(price*number);
});
var user_msg = {
	name : "金宝宝2号",
	msg : "好吃啊！"
}
var sys_msg = {
	type : "img/msg_buy.png",
	msg : "SONG送出了10个大虾"
}
function add_user_msg(e){
	var msg = document.createElement("msg");
	var thehtml = '<ib><name>'+e.name+'<span>'+e.msg+'</span></name></ib>';
	$(msg).html(thehtml);
	msg.className = "lightSpeedIn";
	$(".msg-body:nth-child(2)>ib").append(msg);
    var nodes = $(".msg-body:nth-child(2)>ib")[0].children;
    if(nodes.length >= 10){
        nodes[0].remove();
    }
	msg.scrollIntoView(false);
}
function add_sys_msg(e){
	var msg = document.createElement("msg");
	var thehtml = '<ib><name><ib><img src='+e.type+'></ib>'+e.msg+'</name></ib>';
	$(msg).html(thehtml);
	$(msg).attr("sys","");
	$(msg).attr("buy","");
	msg.className = "lightSpeedIn";
	$(".msg-body:nth-child(1)>ib").append(msg);
    var nodes = $(".msg-body:nth-child(1)>ib")[0].children;
    if(nodes.length >= 4){
        nodes[0].remove();
    }
	msg.scrollIntoView(false);
}
setInterval(function(){
	add_user_msg(user_msg);
},2000);
setInterval(function(){
	add_sys_msg(sys_msg);
},2000);


$(document).on("click",".btn_buy",function(){
    $(".package_detail").removeClass("none");
    setTimeout(function(){
        pd_scroll.refresh();
    },100);
});


