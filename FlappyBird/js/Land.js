(function() {
	window.Land = function() {
		this.image = game.Robj["land"];
		this.x = 0;
		this.y = game.canvas.height - 112;
	};
	Land.prototype.update = function() {
		this.x -= 2;
		if (this.x < -336) {
			this.x = 0;
		}
	};
	Land.prototype.render = function() {
		game.ctx.drawImage(this.image,this.x,this.y);
		game.ctx.drawImage(this.image,336 + this.x,this.y);
	};
})();