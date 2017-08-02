
var namelist=["CC","嘉嘉","木子","小米","小鸣","小颜","一飞","元也","芷芷"]; 
var mytime=null;
var ever=[]
var isdraw=[];
var maxdraw=3;
var index = 0;
$('body').click(function(){
	$('.pull').slideUp('fast');
})
$('.pull .btn').click(function(){
	var tmp=$('input').val();
	if ( tmp =='') return;
	isdraw=[];
	maxdraw=tmp;
	index=0;
	document.getElementById("bt").innerHTML="开始";
})
$('input').click(function(e){
	e.stopPropagation();
})
$('.setting').click(function(e){
	e.stopPropagation();
	$('.pullsetting').slideDown();
})
$('.restart').click(function(e){
	e.stopPropagation();
	if(window.confirm('是否清除所有中奖人并重新开始抽奖？'))
		ever=[];
})
$('.drawname span').click(function(e){
	e.stopPropagation();
	$(this).addClass('cur').siblings().removeClass('cur');
})

function doit(e){
	e.stopPropagation();
	var bt=window.document.getElementById("bt");
	//if (isdraw[curindex]) alert(isdraw[curindex]);
	if(mytime==null ){
		if( index>namelist.length){alert('抽奖完毕，请重新开始');return;}
		if (index==maxdraw){
			showdraw(e);
			return;
		}
		$('#ms').get(0).play();
		bt.innerHTML="停止";
		show();       
	}else{
		var num=rnd();
		clearTimeout(mytime);
		for ( var i=0; i<$('#box .item').length; i++){
			while( isdraw.indexOf(namelist[num])>=0||ever.indexOf(namelist[num])>=0){
				num=rnd();
			}
			isdraw.push(namelist[num]);
			ever.push(namelist[num]);
			$('#box .item').eq(i).find('img').attr('src','img/'+namelist[num]+'.jpg');
			$('#box .item').eq(i).find('p').html(namelist[num]);
		}
		mytime=null;  
		bt.innerHTML="开始";
		
		$('#ms').get(0).pause();
		$('#ms').currentTime = 0;
		$('#me').get(0).play();
		index++;
		if (index==maxdraw ){
			bt.innerHTML="查看中奖名单";
			return;
		}
	}
}

function rnd(){
	return Math.floor((Math.random()*100000))%namelist.length;
}
function show(){
	var num=rnd();
	$('#box img').attr('src','img/'+namelist[num]+'.jpg');
	$('#box .item p').html(namelist[num]);
	mytime=setTimeout("show()",1);
} 
function showdraw(e,bool){
	e.stopPropagation();
	if (index==0){
		 alert('抽奖未开始');return;
	}
	$('.showdraw').slideDown();
	var tmp= '' ;
	var tmparray = [];
	if(bool)
		tmparray = ever;
	else
		tmparray = isdraw;
	for ( var j=0; j<tmparray.length; j++){
		tmp += '<div><img src="img/'+tmparray[j]+'.jpg" /><p>'+tmparray[j]+'</p></div>';
	}
	$('.showdraw').html(tmp);
	var _w = ($(window).width()-$('.showdraw').width())/2;
	$('.showdraw').css('left', _w+'px');
}