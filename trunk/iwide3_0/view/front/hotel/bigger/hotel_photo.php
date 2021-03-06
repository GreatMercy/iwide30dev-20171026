
<?php include 'header.php' ?>
<?php echo referurl('css','photo.css',1,$media_path) ?>

<div class="gradient_bg wrapper hotel_photo_wrapper">
      <div class="hotel-pictures">
          <div class="hotel-pictures__list">
             <?php if(!empty($cur_gallery)){ foreach($cur_gallery as $g){ ?>
                     <div class="hotel-pictures__items active">
                         <div class="hotel-pictures__title">
                             <?php
                                if(!empty($g['info'])){
                                    echo $g['info'].'('.$g['gallery_name'].')';
                                }else{
                                    echo $g['gallery_name'];
                                }
                             ?>
                         </div>
                         <div class="hotel-pictures__photo squareimg"><img src="/public/hotel/bigger/images/hotel_deafult.png" data-src="<?php echo $g['image_url'];?>">
                         </div>
                     </div>
              <?php }}?>
          </div>
        </div>
      <div class="hotel-pictures__pagination center h30"><span class="main_color1 h48 txt_r mar_t10">1</span>
          <tt class="color3"> /<?php echo $total_nums;?></tt>
      </div>
</div>
    <script>
      var total_nums = <?php echo $total_nums;?>;
      var gallery_id = '<?php echo $gallery_info;?>';
      var getClientRect = function(ele){
        return ele.getBoundingClientRect();
      }
      var $hotellist = $('.hotel-pictures__list');
      var $hotellistItems = $hotellist.find('.hotel-pictures__items');
      var $curImg = $('.hotel-pictures__pagination span');
      var state = {};
      $hotellist.on({
        'touchstart': function(e){
          e.preventDefault();
          e.stopPropagation();
          var _e = e.touches[0];
          state ={
            time: Date.now(),
            pageX: _e.pageX,
            pageY: _e.pageY
          }
        },
        'touchmove': function(e){
          e.preventDefault();
          e.stopPropagation();
        },
        'touchend': function(e){
          e.preventDefault();
          e.stopPropagation();
          var _e = e.changedTouches[0];
          var distanceX = _e.pageX - state.pageX;
          var distanceY = _e.pageY - state.pageY;
          var time = Date.now() - state.time;
          var event;
          //30度为界
          var angle = Math.atan2(Math.abs(distanceX), Math.abs(distanceY));
          if(angle < 0.9){
            direction = distanceY < 0 ? 'up' : distanceY > 0 ? 'down' : '';
            if(time < 250){
              if(Math.abs(distanceY) < 50){
                event = 'tap'
              }else{
                event = 'swipe'
              }
            }else{
              event = 'pan'
            }
            
            photoChange({event: event, direction: direction});
          }
        }
      },'.hotel-pictures__items');
      
      //记录两次滑动之间的时间差值，如果小于250ms，则不加载图片
      var timeGap;
      var lastTouchTime;
      var itemLen = $hotellistItems.length;
      var changeDomClass = function(next, cur){
        cur.removeClass('active');
        next.addClass('active');
        cur.removeClass('hotel-pictures__items--pushOutBack hotel-pictures__items--pushOutFront hotel-pictures__items--pushInBack hotel-pictures__items--pushInFront');
        next.removeClass('hotel-pictures__items--pushOutBack hotel-pictures__items--pushOutFront hotel-pictures__items--pushInBack hotel-pictures__items--pushInFront');
      }
      var loadImg = function(img){
        var src = img.data('src');
        if(img.attr('src') !== src){
          img.attr('src', src);
        }
      }
      var loadQueueTime = null;
      var skipLoadImg = 500;
      var animationTime = null;
      //动画持续时间，由css中定义，如果修改，需要同步修改css
      var animationDuration = 300;
      var $next;
      var $cur;
      var photoChange = function(eventObj) {
        var t = Date.now();
        var name = eventObj.event;
        var isUp = eventObj.direction === 'up';
        if(lastTouchTime){
          timeGap = t - lastTouchTime;
          if(timeGap < skipLoadImg){
            clearTimeout(loadQueueTime);
          }
        }
        if(name !== 'tap'){
          //如果两次事件相隔小于animationDuration，则需要立刻执行changeDomClass
          if(timeGap < animationDuration && $next && $cur){
            changeDomClass($next, $cur)
          }
          var index = $hotellistItems.filter('.active').index();
          var nextIndex = isUp ? index - 1 : index + 1;
          if(nextIndex >= 0 && nextIndex < itemLen){
            $cur = $hotellistItems.eq(index);
            $next = $hotellistItems.eq(nextIndex);
            //加载图片
            if(name === 'pan'){
              //pan直接加载图片
              var img = $next.find('img');
              loadImg(img);
            }else{
              //开启一个0.5s的任务
              loadQueueTime = setTimeout(function(){
                loadImg($next.find('img'));
              },skipLoadImg)
            }
            //动画
            if(isUp){
              $cur.addClass('hotel-pictures__items--pushOutBack');
              $next.addClass('hotel-pictures__items--pushInBack');
            }else{
              $next.addClass('hotel-pictures__items--pushInFront');
              $cur.addClass('hotel-pictures__items--pushOutFront');            
            }
            $curImg.text(nextIndex + 1);
            clearTimeout(animationTime);
            animationTime = setTimeout(function(){
              return changeDomClass($next, $cur);
            },animationDuration)
          }
        }
        lastTouchTime = t;
      }
      loadImg($(".hotel-pictures__items").eq(0).find("img"))
    </script>
  </body>
</html>