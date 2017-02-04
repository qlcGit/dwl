(function() {
	window.Pipe = function() {
		this.image1 = game.Robj["pipe_up"];
		this.image2 = game.Robj["pipe_down"];
		this.kaikou = 100;
		//管子高度，height2上面，height1下面
		this.height2 = _.random(50,200);
		this.height1 = 400  - this.kaikou - this.height2;
		this.x = 300;
		//已安全通过计分的Flag
		this.pass = false;
	};
	Pipe.prototype.update = function() {
		this.x -= 2;
		if (this.x < -52) {
			game.sm.pipes = _.without(game.sm.pipes,this);
		}
		//碰撞检测4个数字验证小鸟是否撞上管子
		if ((this.x < game.bird.x + 15 + 28) && (this.height2 > game.bird.y + 15) && (this.x > game.bird.x - 42)) {
			game.sm.changeScene(3);
		}else if ((this.x < game.bird.x + 7 + 28) && (400 - this.height1 < game.bird.y + 7 + 28) && (this.x > game.bird.x - 42)) {
			game.sm.changeScene(3);
		}
		//加分检测
		if (!this.pass && (this.x + 52 < game.bird.x)) {
			this.pass = true;
			game.score ++;
		}

	};
	Pipe.prototype.render = function() {
		game.ctx.drawImage(this.image2,0,320 - this.height2,52,this.height2,this.x,0,52,this.height2);
		game.ctx.drawImage(this.image1,0,0,52,this.height1,this.x,400 - this.height1,52,this.height1);
		//game.ctx.fillText(this.pass,this.x,100,52,this.height2);
	};
})();