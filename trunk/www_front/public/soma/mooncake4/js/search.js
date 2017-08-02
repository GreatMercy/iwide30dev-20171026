/**
 * 设置label 颜色
 * */
function setLabel () {
  var list = $('#list li');
  for (var i = 0; i < list.length; i++) {
    if ((i + 1) % 3 === 0) {
      list.eq(i).find('.label').addClass('label2');
    } else {
      list.eq(i).find('.label').addClass('label1');
    }
  }
  list.eq(1).find('.label').removeClass('label1').addClass('label2');
}

setLabel();