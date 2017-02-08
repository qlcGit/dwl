(function() {
	function writeObj(obj){ 
		var description = ""; 
		for(var i in obj){
			var property=obj[i]; 
			description+=i+" = "+property+"\n"; 
		} 
		alert(description);
	}
	window.Game = function() {
		this.canvas = document.getElementById('flappyBird');
		// writeObj(this.canvas);
		this.ctx = this.canvas.getContext("2d");
		// writeObj(this.ctx);
		this.frameNumber = 0;
		this.R = {
			"beijing1" : "images/bg_day.png",
			"bird0_0" : "images/bird0_0.png",
			"bird0_1" : "images/bird0_1.png",
			"bird0_2" : "images/bird0_2.png",
			"bird1_0" : "images/bird1_0.png",
			"bird1_1" : "images/bird1_1.png",
			"bird1_2" : "images/bird1_2.png",
			"bird2_0" : "images/bird2_0.png",
			"bird2_1" : "images/bird2_1.png",
			"bird2_2" : "images/bird2_2.png",
			"land" : "images/land.png",
			"pipe_down" : "images/pipe_down.png",
			"pipe_up" : "images/pipe_up.png",
			"score0" : "images/font_048.png",
			"score1" : "images/font_049.png",
			"score2" : "images/font_050.png",
			"score3" : "images/font_051.png",
			"score4" : "images/font_052.png",
			"score5" : "images/font_053.png",
			"score6" : "images/font_054.png",
			"score7" : "images/font_055.png",
			"score8" : "images/font_056.png",
			"score9" : "images/font_057.png",
			"title" : "images/title.png",
			"tutorial" : "images/tutorial.png",
			"game_over" : "images/text_game_over.png",
			"text_ready" : "images/text_ready.png",
			"ready" : "images/text_ready.png",
			"score_panel" : "images/score_panel.png",
			"button_play" : "images/button_play.png"
		}
		this.Ramount = _.keys(this.R).length;
		this.Robj = {};
		this.score = 0;
		this.loadResource(function() {
			this.start();
		});
	};
	Game.prototype.loadResource = function(callback) {
		var already = 0;
		var self = this;
		for(var k in this.R) {
			this.Robj[k] = new Image();
			this.Robj[k].src = this.R[k];
			this.Robj[k].onload = function() {
				already++;
				self.ctx.clearRect(0,0,self.canvas.width,self.canvas.height);
				self.ctx.font = "20px 微软雅黑";
				self.ctx.fillText("正在加载图片" + already + "/" + self.Ramount,10,40);
				if (already === self.Ramount) {
					callback.call(self);
				}
			};
		}
	};
	Game.prototype.start = function() {
		var self = this;
		//完成演员注册
		this.bird = new Bird();
		this.background = new Background();
		this.land = new Land();
		//场景管理器
		this.sm = new SceneManagement();
		this.sm.changeScene(0);
		// writeObj(this.actors[0]);
		this.timer = setInterval(function() {
			self.mainloop();
		},20);
	};
	Game.prototype.mainloop = function() {
		//清屏
		this.ctx.clearRect(0,0,this.canvas.width,this.canvas.height);
		//命令场景管理器更新渲染
		this.sm.render();
		//测试bird
		// this.bird.update();
		// this.bird.render();
		//打印帧编号
		this.frameNumber++;
		this.ctx.font = "14px consolas";
		this.ctx.fillText("FNO : " + this.frameNumber,10,20);
		//打印场景编号
		this.ctx.fillText("SCN : " + this.sm.sceneNumber,10,40);
		
	};
})();