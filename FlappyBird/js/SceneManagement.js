(function() {
	//场景管理器，这个类的实例在game中只有一个
	window.SceneManagement = function() {
		//当前场景编号
		this.sceneNumber = 0;
		//小计帧器记录当前场景到第几帧了
		this.f = 0;
		this.pipes = [];
	};
	SceneManagement.prototype.changeScene = function(n) {
		// game.bird.color = _.random(0,2);
		//每一次换场景重新计帧数
		this.f = 0;
		//更换场景
		this.sceneNumber = n;
		var self = this;
		//就位瞬间渲染场景
		if (this.sceneNumber == 0) {
			game.ctx.drawImage(game.Robj["title"],game.canvas.width / 2 - 89,0);
			//添加场景0的监听
			game.canvas.onmousedown = function(event) {
				var mousex = event.offsetX;
				var mousey = event.offsetY;
				if ((mousex > game.canvas.width / 2 - 58) && (mousex < game.canvas.width / 2 + 58) && mousey > 360 && mousey < 430) {
					self.changeScene(1);
					game.bird.color = _.random(0,2);
				}
			};
		}else if (this.sceneNumber == 1) {
			game.ctx.drawImage(game.Robj["text_ready"],game.canvas.width / 2 - 98,0);
			//清空管子
			game.canvas.onmousedown = function(event) {
				var mousex = event.offsetX;
				var mousey = event.offsetY;
				if ((mousex > game.canvas.width / 2 - 57) && (mousex < game.canvas.width / 2 + 57) && mousey > 250 && mousey < 348) {
					self.changeScene(2);
					game.bird.flyHigh();
				}
			};
		}else if (this.sceneNumber == 2) {
			//清空管子
			this.pipes = [];
			game.canvas.onmousedown = function(event) {
				game.bird.flyHigh();
			};
		}else if (this.sceneNumber == 3) {
			game.canvas.onmousedown = function(event) {
				self.changeScene(0);
				//复原bird
				game.bird = new Bird();
				game.bird.color = _.random(0,2);
				game.score = 0;
			};
		}
	};
	SceneManagement.prototype.render = function() {
		this.f++;
		//每个场景的业务
		if (this.sceneNumber == 0) {
			//渲染背景
			game.background.render();
			//title动画20帧下落，20帧停住
			if (this.f < 20) {
				game.ctx.drawImage(game.Robj["title"],game.canvas.width / 2 - 89,this.f * 5);
			} else {
				game.ctx.drawImage(game.Robj["title"],game.canvas.width / 2 - 89,100);
			}
			//渲染按钮
			if (this.f > 20) {	
				game.ctx.drawImage(game.Robj["button_play"],0,0,116,70,game.canvas.width / 2 - 58,360,116,70);
			}
			//渲染bird
			game.bird.render();
		}else if (this.sceneNumber == 1) {
				//更新渲染背景
			game.background.render();
			//更新渲染大地
			game.land.update();
			game.land.render();
			if (this.f < 20) {
				game.ctx.drawImage(game.Robj["text_ready"],game.canvas.width / 2 - 98,this.f * 5);
			} else {
				game.ctx.drawImage(game.Robj["text_ready"],game.canvas.width / 2 - 98,100);
			}
			//tutorial闪烁动画
			if (this.f > 20) {
				game.ctx.save();
				game.ctx.globalAlpha = this.f % 20 / 20;
				game.ctx.drawImage(game.Robj["tutorial"],0,0,114,98,game.canvas.width / 2 - 57,250,114,98);
				game.ctx.restore();
			}
			//渲染bird
			game.bird.render();
		}else if (this.sceneNumber == 2) {
			//更新渲染背景
			game.background.update();
			game.background.render();
			//更新渲染大地
			game.land.update();
			game.land.render();
			
			//每130帧创建新管子，每一帧更新渲染管子
			if (game.frameNumber % 120 == 0) {
				this.pipes.push(new Pipe());
			}
			_.each(this.pipes,function(actor) {
				actor.update();
				actor.render();
			});
			//更新渲染bird
			game.bird.update();
			game.bird.render();
			//打印分数，算法为王
			var weishu = game.score.toString().length;
			for (var i = 0; i < weishu; i++) {
				var zheweishu = game.score.toString().charAt(i);
				game.ctx.drawImage(game.Robj["score" + zheweishu],game.canvas.width / 2 - 15 * weishu + i * 30,420);
			}
		}else if (this.sceneNumber == 3) {
			//渲染背景
			game.background.render();
			//渲染大地
			game.land.render();
			//渲染管子
			_.each(this.pipes,function(actor) {
				actor.render();
			});
			//更新渲染bird
			// game.bird.update();
			game.bird.render();

			//坠毁后进行其他动画
			game.ctx.drawImage(game.Robj["game_over"],game.canvas.width / 2 - 102,100);
			game.ctx.fillText("分数：" + game.score,90,270);
			game.ctx.fillText("点击任何地方继续",90,300);

		}
	};
})();