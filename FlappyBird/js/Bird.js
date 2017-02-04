(function() {
	window.Bird = function() {
		//图片序列
		this.imageArr = [[game.Robj['bird0_0'],game.Robj['bird0_1'],game.Robj['bird0_2']],
						[game.Robj['bird1_0'],game.Robj['bird1_1'],game.Robj['bird1_2']],
						[game.Robj['bird2_0'],game.Robj['bird2_1'],game.Robj['bird2_2']]];
		//鸟颜色0、1、2
		this.color = 0;
		//翅膀状态0、1、2
		this.wing = 0;
		this.x = game.canvas.width / 4;
		this.y = 200;
		this.angle = 0;
		//FSM
		this.state = "A"; //A下落，B上升
		//内部计数器
		this.f = 0;
	};
	Bird.prototype.flyHigh = function() {
		this.state = "B";
		//计数器清零
		this.f = 0;
	};
	Bird.prototype.update = function() {
		if (game.sm.sceneNumber == 3) {
			this.y += 2;
			if (this.y >= 200) {
				this.y = 200;
			}
			return;
		}
		if (game.frameNumber % 10 == 0) {
			this.wing = ++this.wing % 3;
		}
		if (this.state == "A") {
			//计数
			this.f ++;
			//天生下落,除的数字越大掉落越慢
			this.y += Math.pow(this.f,2) / 800;
			//下落旋转,除的数字越大旋转越慢
			this.angle = this.f / 400;
		}else if (this.state == "B") {
			//自己定义上飞的帧数25帧
			this.f ++;
			//上升的时候第一瞬间变化量最大，到25帧，变化为0;
			//除的数字越大跳的高度越小
			this.y -= Math.pow((25 - this.f),2) / 120;
			//鸟头朝上除的数字越大旋转越慢
			this.angle = -(25 - this.f) / 100;
			if (this.f > 25) {
				this.state = "A";
				this.f = 0;
			}
		}

		//判断鸟坠毁
		if (this.y > 450) {
			game.sm.changeScene(3);
			
		}
	};
	Bird.prototype.render = function() {
		if (game.sm.sceneNumber == 0 || game.sm.sceneNumber == 1) {
			this.f ++;
			if (this.f < 20) {
				this.y -= 1;
			}else {
				this.y += 1;
				if (this.y >= 200) {
					this.y = 200;
					this.f = 0;
				}
			}
		}
		if (game.frameNumber % 10 == 0) {
			this.wing = ++this.wing % 3;
		}
		//备份
		game.ctx.save();
		//把坐标原点移动到鸟的中心
		game.ctx.translate(this.x + 24,this.y + 24);
		//旋转
		game.ctx.rotate(this.angle);
		game.ctx.drawImage(this.imageArr[this.color][this.wing],-24,-24);
		//恢复
		game.ctx.restore();
	};
})();