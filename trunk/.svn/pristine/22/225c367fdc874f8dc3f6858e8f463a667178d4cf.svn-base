// JavaScript Document

var timePickerCss = $('<style>'
+'.timePicker{position:fixed; width:100%; height:100%; background:#f8f8f8;top:0;-webkit-transition:top 350ms; z-index:99}'
+'.timePicker{ display:flex;display:-webkit-flex;flex-flow:column;justify-content:space-between;align-items:stretch;}'
+'.timePicker header,.timePicker footer{flex-shrink:0}'
+'.PickerBtn{text-align:center; padding:8px}'
+'.timePicker .flexgrow{flex-grow:1; -webkit-flex-grow:1}'
+'.DayTab{text-align:center;display:flex;display:-webkit-flex;align-items:center; background:#fff; padding:10px 10px 5px 10px;justify-content:space-around;}'
+'.DayTab>*{border-bottom:2px solid transparent; padding:0 2px 5px 2px;}'
+'.DayTab p{color:#666}'
+'.DayTab .iscur p{color:#000}'
+'.DayTab .iscur {color:inherit;border-bottom:2px solid}'
+'#moreDay{padding-left:5px;}'
+'.DayTab .break{ background:#e4e4e4; width:0.5px; height:1.5em; padding:0; margin-bottom:0.5em}'
+'.timeBox{ background:#fff;display:flex;display:-webkit-flex;flex-wrap:wrap;align-content:space-around }'
+'.BoxTitle{padding:15px 2.5%;width:100%; border-top:0.5px solid #e4e4e4}'
+'.TimeBtn{width:20%; padding:8px 0; line-height:1; border:0.5px solid #e4e4e4; margin:0 2.5%; margin-bottom:15px; display:inline-block;;  text-align:center}'
+'.TimeBtn.forbidden{background:#e4e4e4; border-color:transparent;}'
+'.TimeBtn.active{color:#ff9900;border:0.5px solid;background:#fff4e3}'
+'</style>');
var DatePickerCss =$('<style>'
+'.DateLayer{display:flex; position:fixed; width:100%;height:100%;top:0; background:rgba(0,0,0,0.5);align-items:flex-end;z-index:111}'
+'.DateBox{background:#fff;flex-grow:1; -webkit-flex-grow:1; padding-bottom:8px;}'
+'.handleBtn{ background:#e4e4e4;display:flex;display:-webkit-flex;;justify-content:space-between;}'
+'.handleBtn>*{padding:10px; display:inline-block}'
+'.CurDate{text-align:center;}'
+'.CurDate>*{padding:15px; display:inline-block; line-height:1; padding-bottom:6px}'
+'.DateTable{width:100%; text-align:center; color:#6e6e6e;border-spacing:6px;border-collapse:separate}'
+'.DateTable th,.DateTable td{ padding:4px 0;}'
+'.DateTable .ableDay{ color:#111}'
+'.DateTable .SelectDay{background:#ff9900; color:#fff}'
+'</style>');
/*
<page class="timePicker"><header><div class="color_main DayTab h24">
        	<div class="iscur">
            	<p>今天</p>
                <p>01-16</p>
            </div>
        	<div>
            	<p>今天</p>
                <p>01-16</p>
            </div>
        	<div>
            	<p>今天</p>
                <p>01-16</p>
            </div>
            <div class="break"></div>
        	<div id="moreDay">
                <p class="iconfont">&#xe62d;</p>
            	<p class="h20">更多</p>
            </div>
        </div>
    </header>
    <section class="h24 flexgrow" style="align-self:flex-start; width:100%;">
    	<div class="timeBox">
            <div class="BoxTitle">午餐</div>
            <div class="TimeBtn forbidden">11:30</div>
            <div class="TimeBtn active">11:30</div>
            <div class="TimeBtn">11:30</div>
            <div class="TimeBtn">11:30</div>
            <div class="TimeBtn">11:30</div>
            <div class="TimeBtn">11:30</div>
            <div class="BoxTitle">午餐</div>
            <div class="TimeBtn">11:30</div>
            <div class="TimeBtn">11:30</div>
            <div class="TimeBtn">11:30</div>
            <div class="TimeBtn">11:30</div>
            <div class="TimeBtn">11:30</div>
            <div class="TimeBtn">11:30</div>
        </div>
    </section>
    <footer><div class="bg_main PickerBtn">确认</div></footer>
</page>
<div class="DateLayer">
	<div class="DateBox">
    	<div class="handleBtn h22"><span cancel>取消</span><span class="color_main" sure>确认</span></div>
        <div class="CurDate h24"><span pre>&lt;</span><span CurDate>2017年12月</span><span next>&gt;</span></div>
        <table class="DateTable h22">
        	<tr>
            	<th>周日</th>
            	<th>周日</th>
            	<th>周日</th>
            	<th>周日</th>
            	<th>周日</th>
            	<th>周日</th>
            	<th>周日</th>
            </tr>
            <tr>
            	<td>1</td>
            	<td>2</td>
            	<td>3</td>
            	<td>4</td>
            	<td>5</td>
            	<td>6</td>
            	<td>7</td>
            </tr>
            <tr>
            	<td>8</td>
            	<td class="ableDay">9</td>
            	<td class="ableDay SelectDay">10</td>
            	<td class="ableDay">11</td>
            	<td>12</td>
            	<td>13</td>
            	<td>14</td>
            </tr>
        </table>
    </div>
</div>*/
$.fn.extend({          
    timePicker:function(setting) {
		var $default ={
			range:['0:0-23:0'],
			text:['全天'],
			Menus:3,
			curDate: new Date(),
			MenusTxt:['今天','明天','后天'],
			increment:30,  //时间间隔
		}
		var getnumber=function(num){
			if(num<10) return '0'+num;
			else return num;
		}
		var option = $.extend( $default, setting);
		var tmpday = new Date();
		var today  = new Date();
		var val = $(this).attr('value')? $(this).attr('value'):'';
		var timePickerHtml = $('<page class="timePicker"><header><div class="color_main DayTab h24"></div></header><section class="h24 flexgrow" style="align-self:flex-start; width:100%;"><div class="timeBox"></div><footer></footer></page>');
		for(var i=0;i<option.Menus;i++){
			var html =$('<div><p>'+MenusTxt[i]+'</p><p>'+getnumber(tmpday.getMonth()+1)+'-'+getnumber(tmpday.getDate())+'</p></div>');
			timePickerHtml.find('.DayTabl').append(html);
			if(tmpday.getTime()==today.getTime()){
				html.addClass('iscur');
			}
			html.click(function() {
                $(this).addClass('iscur').siblings().removeClass('iscur');
            });
			tmpday.setMonth(tmpday.getMonth()+1,tmpday.getDate()+1);
		}
		var tmpday = new Date();
		tmpday.setHours(0,0,0,0);
		for(var i=0;i<option.range;i++){
			var start   = option.range[i].split['-'][0];
			var end     = new Date(option.range[i].split['-'][1].toString(),0,0);
			var str     = '<div class="BoxTitle">'+option.text[i]+'</div>';
			tmpday.setHours(start.toString());
			while()
			for( var h = start; h<end ;){
				var TimeBtn = $('<div class="TimeBtn">'+getnumber(tmpday.getHours())+'-'+getnumber(tmpday.getMinutes())+'</div>');
				tmpday.setHours(tmpday.getHours(),tmpday.getMinutes()+option.increment);
			}
		}
		//+'<footer><div class="bg_main PickerBtn">确认</div></footer>';
			
		$(this).click(function(){
			var dom = $(timePickerHtml);
			$('body').append(dom);
		})
		
    },
	datePicker:function(setting) {
		var $default ={
			ableDay:15			
		}
		var option = $.extend( $default, setting);
    }
}); 