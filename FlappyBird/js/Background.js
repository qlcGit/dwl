(function() {
	window.Background = function() {
		this.image = game.Robj['beijing1'];
		this.x = 0;
	};
	Background.prototype.update = function() {
		//根据场景判断
		this.x -= 1;
		if (this.x < -game.canvas.width) {
			this.x = 0;
		}
	};
	Background.prototype.render = function() {
		game.ctx.drawImage(this.image,this.x,0,game.canvas.width,game.canvas.height);
		game.ctx.drawImage(this.image,game.canvas.width + this.x,0,game.canvas.width,game.canvas.height);
	};
})();