// JavaScript Document

var searchstr= '<div class="ui_pull searchpull bg_F3F4F8" style="display:none;">'
			+'<div class="pad3" style="height:100%">'
			+'<div class="webkitbox justify bg_fff inputbox  color_999">'
			+'<em class="iconfont icon">&#X2C;</em>'
			+'<input type="search" placeholder="关键字/位置/名称">'
			+'<span class="h22 pad3" onclick="toclose()">取消</span></div>'
			+'<div class="color_999 martop h22" id="searchtips"></div>'
			+'<div class="list_style_2 martop scroll"></div>'
			+'</div></div>';

function searchlocal(keyword,$link){
	$('#searchtips').html('正在搜索').show();
	var city = $('.city').val()? $('.city').val():'广州';
	var keyword = keyword?keyword:'广州';
	var url = 'http://apis.map.qq.com/ws/place/v1/suggestion/?region='+city+'&keyword='+keyword+'&output=jsonp&key=OZQBZ-6DZ32-NQJUJ-C6HX7-VUIA5-B4BB2';
	$.get(url,'',function(data){
		if( data.status==0){
			console.log(data);
			var html='';
            var link = $('#link').val();
			var length=data.count;
			for (var i=0;i<data.data.length;i++){
                html += '<li filter="bdmap" code="'+data.data[i].location.lat+','+data.data[i].location.lng+'" >'+data.data[i].title+'</li>';
			}
			$('.searchpull .scroll').html(html);
			$('#searchtips').html('搜索到'+length+'个地标');
            $('.searchpull .scroll li').unbind('click',result_list_click);
            $('.searchpull .scroll li').bind('click',result_list_click);
            $(".searchpull .scroll .ui_loading").remove();
        }
	},'jsonp');
}
$(function(){
	$('body').append(searchstr);
	$('.keyword').click(function(){
		toshow($('.searchpull'));
	});
	$('#filter_result').click(function(){
		toshow($('.searchpull'));
	})
	$('.searchpull input').bind('change',function(){
		if($(this).val()=='')return;
		searchlocal($(this).val());
	});
	$('#show_sort_pull').click(function(){
		if($('.sort_list_pull').is(":hidden"))toshow($('.sort_list_pull'));
	})
	$('.sort_list_pull li').click(function(){
		$(this).addClass('cur').siblings().removeClass('cur');
		pageloading();
		window.setTimeout(removeload,800)
		$('#show_sort_pull span').html($(this).html());
	})
});

function tab_list_click(){
    $(this).addClass('cur').siblings().removeClass('cur');
    $('.get_result').eq($(this).index()).show().siblings('.get_result').hide();
}
function _alink_click(url){
    //extra_condition={};
    $('#ec').val('');
    $(".searchbox input").val("");
    window.location.href=url+"&start="+$('#startdate').val()+"&end="+$('#enddate').val();
}
function result_list_click(){
    _this=$(this);
    if( !_this.hasClass('_alink')){
        $('.get_result li').removeClass('ui_color');
        _this.addClass('ui_color');
        extra_condition={};
        extra_condition[_this.attr('filter')]=_this.attr('code');
        $('#ec').val(JSON.stringify(extra_condition));
        $('.result_list').hide();
        pageloading('正在筛选',0.1);
        fill_hotel('html',0);
        $('.searchbox input').val(_this.html());
        //window.sessionStorage.ec=$('#ec').val();
        if($('#index_search').length>0) $('#index_search').submit();
        else toclose();
    }
}
function search2(){
    var val=$(this).val();
    if( val ==''){$('.result_list').stop().slideUp();}
    else{
        var str = '';
        $('.result_list .address_list').html(str);
        for( var i=0; i<$('.get_result li').length; i++){
            if ( $('.get_result li').eq(i).html().indexOf(val) >= 0){
                str += '<li filter="'+$('.get_result li').eq(i).attr('filter');
                str +='" code="'+$('.get_result li').eq(i).attr('code')+'">'+$('.get_result li').eq(i).html()+'</li>';
            }
        }
        search_hotel(val);
        $('.result_list .address_list').html(str);
        $('.result_list span').html($('.result_list .address_list li').length);
        if($('.result_list .address_list li').length<=5){
            var _val='北京市';
            if ($('#city').val()!=''&&$('#city').val()!=undefined)
                _val=$('#city').val()
            $('.result_list .address_list').append('<div class="h4" style="padding:3%;">搜索到以下地标<em class="ui_ico ui_loading" style="width:12px;height:12px;"></em></div>')
            getmap(_val,val);
        }
        $('.result_list li').bind('click',result_list_click);
        $('.result_list').stop().slideDown();
    }
}
function search_hotel(keyword){
    $.get('../check/ajax_hotel_search',{
        keyword:keyword,
        city:$('#city').val()
    },function(data){
        if(data.s==1){
            $('.result_list .address_list').prepend(data.data);
            $('.result_list span').html($('.result_list .address_list li').length);
        }else{
            return '';
        }
    },'json');
}
function title_click(){
    $(this).next().stop().slideToggle();
}
function tobind(){
    $('.filter_pull .tab_list li').bind('click',tab_list_click);
    $('.get_result li').bind('click',result_list_click);
    $('#search2').bind('change',search2);/*input propertychange*/
    $('.get_result .title').bind('click',title_click);

    var _h = $(window).height() -$('.filter_pull .pull_searchbox').outerHeight();
    $('.result_list').height(_h);
    $('.tab_list').height(_h);
    $('.get_result').height(_h);
}

$(function(){
//	if (window.sessionStorage){
//		if( window.sessionStorage.latitude != undefined && window.sessionStorage.latitude!=''){
//			$('#latitude').val(window.sessionStorage.latitude);
//		}
//		if( window.sessionStorage.longitude != undefined && window.sessionStorage.longitude!=''){
//			$('#longitude').val(window.sessionStorage.longitude);
//		}
//		if(window.sessionStorage.sort_type != undefined && window.sessionStorage.sort_type!="" ){
//			$('#sort_type').val(window.sessionStorage.sort_type);
//		}
//		if( window.sessionStorage.city != undefined &&  window.sessionStorage.city!=''){
//			$('#city').val(window.sessionStorage.city);
//		}
//		if( window.sessionStorage.ec != undefined && window.sessionStorage.ec!=''){
//			$('#ec').val(window.sessionStorage.ec);
//		}
//	}
    $('.sort_list_pull').click(toclose);
    $('.sort_list_pull li').click(function(){
        $(this).addClass('ui_color').siblings().removeClass('ui_color');
        $('#show_sort_pull').html($(this).html());
        $('#sort_type').val($(this).attr('sort_tag'));
        fill_hotel('html',0);
        pageloading('正在筛选',0.1);
    });
})