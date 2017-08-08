function PercentageAnimation(element, options) {
	var canvas = $(element),
		cWidth = canvas[0].width,
		cHeight = canvas[0].height;
	this.options = $.extend({}, $.fn.percentageAnimation.defaults, options);
	this.canvas = canvas;
	this.cWidth = canvas[0].width;
	this.cHeight = canvas[0].height;
	this.init();
}
PercentageAnimation.prototype = {
	init: function() {
		var drawingStaff,
			num,
			endArc,
			arcIncrements = 0,
			difference = this.options.roundStartDegree - this.options.roundEndDegree,
			actureDegree = difference > 0 ? 360 - difference : Math.abs(difference),
			that = this,
			cxt = this.canvas[0].getContext('2d');
		endArc = this.options.percentage * actureDegree * Math.PI / 180;
		drawingStaff = setInterval(function() {
			arcIncrements += Math.PI / 180;
			that.drawCanvasStaff(cxt, arcIncrements, actureDegree);
			if (arcIncrements > endArc) {
				clearInterval(drawingStaff);
			};
		}, this.options.speed)
	},
	drawCanvasStaff: function(cxt, arcEndStaff, actureDegree) {
		var text,
			textWidth;
		this.drawCanvasRound(cxt, this.options.baseColor, this.options.roundStartDegree * Math.PI / 180, this.options.roundEndDegree * Math.PI / 180);

		// draw cover round
		cxt.beginPath();
		cxt.strokeStyle = this.options.coverColor;
		cxt.lineWidth = this.options.lineWidth;
		cxt.lineCap = this.options.shape;
		cxt.arc(this.cWidth / 2, this.cHeight / 2, this.options.radius, this.options.coverStartDegree * Math.PI / 180, arcEndStaff - (actureDegree - this.options.roundEndDegree) * Math.PI / 180, false);
		cxt.stroke();

		// draw text
		cxt.fillStyle = this.options.coverColor;
		cxt.font = this.options.numberFont;
		text = Math.floor(arcEndStaff / (actureDegree * Math.PI / 180) * 100);
		textWidth = cxt.measureText(text).width;
		cxt.fillText(text, this.cWidth / 2 - textWidth / 2-6, this.cHeight / 2 + 8);
		cxt.font = this.options.subFont;
		cxt.fillStyle = this.options.subColor;
		cxt.fillText(this.options.subtitle, this.cWidth / 2 + textWidth / 2-6, this.cHeight / 2 + 8);

	},
	// draw basic round
	drawCanvasRound: function(cxt, color, sAngle, eAngle) {
		cxt.clearRect(0, 0, this.cWidth, this.cHeight);

		cxt.beginPath();
		cxt.strokeStyle = color;
		cxt.lineWidth = this.options.lineWidth;
		cxt.arc(this.cWidth / 2, this.cHeight / 2, this.options.radius, sAngle, eAngle, false);
		cxt.stroke();
	}
}
$.fn.percentageAnimation = function(options) {
	return this.each(function() {
		new PercentageAnimation(this, options)
	});
}
$.fn.percentageAnimation.defaults = {
	baseColor: '#e1e1e1',
	coverColor: '#e45050',
	lineWidth: 6,
	percentage: 0.8,
	roundStartDegree: 0,
	roundEndDegree: 360,
	coverStartDegree: 0,
	radius: 80,
	speed: 10, //the more the slower
	shape: 'round', //square\butt\round
	subtitle: '分',
	numberFont: '60px Microsoft YaHei',
	subFont: '18px PT Sans',
	subColor:'#ccc'
}