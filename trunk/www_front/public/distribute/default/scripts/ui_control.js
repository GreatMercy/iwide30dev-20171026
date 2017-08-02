// JavaScript Document


document.addEventListener("touchstart", function(){}, true);

var _winWidth=$(window).width();
var _winHeigh=$(window).height();
if ( _winWidth> _winHeigh )
	alert("为了您更好的体验，请您竖屏浏览");
// 最小高度 
var minRows = 1; 
// 最大高度，超过则出现滚动条 
var maxRows = 3; 

var toshow=function(_this){
	_this.show();
	$('body').addClass('overflow');
	$('html').addClass('overflow');
	history.pushState({ path: this.path }, '', this.href);
	$(window).bind('popstate', function() {
		setTimeout(function(){
			$('.pull').fadeOut();
			$('body').addClass('auto');
			$('html').addClass('auto');
		},100);
	})
}
var toclose = function(){
	history.back(-1);
}
function changerow(_this){  
	
//var l=_this.value.split("\n");
	//var rows = l.length
		if (_this.scrollTop == 0) _this.scrollTop=1; 
		while (_this.scrollTop == 0){ 
		if (_this.rows > minRows) 
			_this.rows--; 
		else 
			break; 
		_this.scrollTop = 1; 
		if (_this.rows < maxRows) 
			_this.style.overflowY = "hidden"; 
		if (_this.scrollTop > 0){ 
			_this.rows++; 
			break; 
			} 
		} 
	while(_this.scrollTop > 0){ 
		if (_this.rows < maxRows){ 
			_this.rows++; 
			if (_this.scrollTop == 0) _this.scrollTop=1; 
		} 
		else{ 
			_this.style.overflowY = "auto"; 
			break; 
		} 
	} 
} 
function img_auto_cut(parent){
	var _this = $('.img_auto_cut');
	if(parent!= undefined)
	  	_this = parent.find('.img_auto_cut');
	var _p_w,_p_h,_w,_h;
	for (var i=0; i<_this.length;i++){
		_p_w  = _this.eq(i).width();
		_p_h  = _this.eq(i).height();
		var _thisimg = _this.eq(i).find('img');
		if(_thisimg.length){	
			if ( _thisimg.height()>0){
				_w = _thisimg.width();
				_h = _thisimg.height();
			}
			else
				_thisimg.load(function(){
					_w = $(this).width();
					_h = $(this).height();
				})
			if( _h < _p_h  ){
				_thisimg.removeClass('_w_h').addClass('_h_w');
				_thisimg.css('left',(_p_w-_thisimg.width())/2);
			}
			else if( _h > _p_h ){
				_thisimg.removeClass('_h_w').addClass('_w_h');
				_thisimg.css('top',(_p_h-_thisimg.height())/2);
			}
		}
		console.warn(_p_w+' '+_p_h+' '+_w+' '+_h);
	}
}

function scrollBottom(){
	window.setTimeout(function(){
		$(document).scrollTop($(document).height());
	},300)
}
window.onload=function(){
	$('.ui_windows_height').height($(window).height());
	$('.ui_windows_width').width($(window).width());
	for(var _i=0; _i<$('.ui_square_h').length; _i++)
		$('.ui_square_h').eq(_i).height($('.ui_square_h').eq(_i).width());
	img_auto_cut();
}
