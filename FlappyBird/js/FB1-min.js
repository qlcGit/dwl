(function(){function a(e){var c="";for(var b in e){var d=e[b];c+=b+" = "+d+"\n"}alert(c)}window.Game=function(){this.canvas=document.getElementById("flappyBird");this.ctx=this.canvas.getContext("2d");this.frameNumber=0;this.R={beijing1:"images/bg_day.png",bird0_0:"images/bird0_0.png",bird0_1:"images/bird0_1.png",bird0_2:"images/bird0_2.png",bird1_0:"images/bird1_0.png",bird1_1:"images/bird1_1.png",bird1_2:"images/bird1_2.png",bird2_0:"images/bird2_0.png",bird2_1:"images/bird2_1.png",bird2_2:"images/bird2_2.png",land:"images/land.png",pipe_down:"images/pipe_down.png",pipe_up:"images/pipe_up.png",score0:"images/font_048.png",score1:"images/font_049.png",score2:"images/font_050.png",score3:"images/font_051.png",score4:"images/font_052.png",score5:"images/font_053.png",score6:"images/font_054.png",score7:"images/font_055.png",score8:"images/font_056.png",score9:"images/font_057.png",title:"images/title.png",tutorial:"images/tutorial.png",game_over:"images/text_game_over.png",text_ready:"images/text_ready.png",ready:"images/text_ready.png",score_panel:"images/score_panel.png",button_play:"images/button_play.png"};this.Ramount=_.keys(this.R).length;this.Robj={};this.score=0;this.loadResource(function(){this.start()})};Game.prototype.loadResource=function(e){var d=0;var c=this;for(var b in this.R){this.Robj[b]=new Image();this.Robj[b].src=this.R[b];this.Robj[b].onload=function(){d++;c.ctx.clearRect(0,0,c.canvas.width,c.canvas.height);c.ctx.font="20px 微软雅黑";c.ctx.fillText("正在加载图片"+d+"/"+c.Ramount,10,40);if(d===c.Ramount){e.call(c)}}}};Game.prototype.start=function(){var b=this;this.bird=new Bird();this.background=new Background();this.land=new Land();this.sm=new SceneManagement();this.sm.changeScene(0);this.timer=setInterval(function(){b.mainloop()},20)};Game.prototype.mainloop=function(){this.ctx.clearRect(0,0,this.canvas.width,this.canvas.height);this.sm.render();this.frameNumber++;this.ctx.font="14px consolas";this.ctx.fillText("FNO : "+this.frameNumber,10,20);this.ctx.fillText("SCN : "+this.sm.sceneNumber,10,40)}})();(function(){window.Land=function(){this.image=game.Robj.land;this.x=0;this.y=game.canvas.height-112};Land.prototype.update=function(){this.x-=2;if(this.x<-336){this.x=0}};Land.prototype.render=function(){game.ctx.drawImage(this.image,this.x,this.y);game.ctx.drawImage(this.image,336+this.x,this.y)}})();(function(){window.Bird=function(){this.imageArr=[[game.Robj.bird0_0,game.Robj.bird0_1,game.Robj.bird0_2],[game.Robj.bird1_0,game.Robj.bird1_1,game.Robj.bird1_2],[game.Robj.bird2_0,game.Robj.bird2_1,game.Robj.bird2_2]];this.color=0;this.wing=0;this.x=game.canvas.width/4;this.y=200;this.angle=0;this.state="A";this.f=0};Bird.prototype.flyHigh=function(){this.state="B";this.f=0};Bird.prototype.update=function(){if(game.sm.sceneNumber==3){this.y+=2;if(this.y>=200){this.y=200}return}if(game.frameNumber%10==0){this.wing=++this.wing%3}if(this.state=="A"){this.f++;this.y+=Math.pow(this.f,2)/800;this.angle=this.f/400}else{if(this.state=="B"){this.f++;this.y-=Math.pow((25-this.f),2)/120;this.angle=-(25-this.f)/100;if(this.f>25){this.state="A";this.f=0}}}if(this.y>450){game.sm.changeScene(3)}};Bird.prototype.render=function(){if(game.sm.sceneNumber==0||game.sm.sceneNumber==1){this.f++;if(this.f<20){this.y-=1}else{this.y+=1;if(this.y>=200){this.y=200;this.f=0}}}if(game.frameNumber%10==0){this.wing=++this.wing%3}game.ctx.save();game.ctx.translate(this.x+24,this.y+24);game.ctx.rotate(this.angle);game.ctx.drawImage(this.imageArr[this.color][this.wing],-24,-24);game.ctx.restore()}})();(function(){window.Pipe=function(){this.image1=game.Robj.pipe_up;this.image2=game.Robj.pipe_down;this.kaikou=100;this.height2=_.random(50,200);this.height1=400-this.kaikou-this.height2;this.x=300;this.pass=false};Pipe.prototype.update=function(){this.x-=2;if(this.x<-52){game.sm.pipes=_.without(game.sm.pipes,this)}if((this.x<game.bird.x+15+28)&&(this.height2>game.bird.y+15)&&(this.x>game.bird.x-42)){game.sm.changeScene(3)}else{if((this.x<game.bird.x+7+28)&&(400-this.height1<game.bird.y+7+28)&&(this.x>game.bird.x-42)){game.sm.changeScene(3)}}if(!this.pass&&(this.x+52<game.bird.x)){this.pass=true;game.score++}};Pipe.prototype.render=function(){game.ctx.drawImage(this.image2,0,320-this.height2,52,this.height2,this.x,0,52,this.height2);game.ctx.drawImage(this.image1,0,0,52,this.height1,this.x,400-this.height1,52,this.height1)}})();(function(){window.Background=function(){this.image=game.Robj.beijing1;this.x=0};Background.prototype.update=function(){this.x-=1;if(this.x<-game.canvas.width){this.x=0}};Background.prototype.render=function(){game.ctx.drawImage(this.image,this.x,0,game.canvas.width,game.canvas.height);game.ctx.drawImage(this.image,game.canvas.width+this.x,0,game.canvas.width,game.canvas.height)}})();(function(){window.SceneManagement=function(){this.sceneNumber=0;this.f=0;this.pipes=[]};SceneManagement.prototype.changeScene=function(b){this.f=0;this.sceneNumber=b;var a=this;if(this.sceneNumber==0){game.ctx.drawImage(game.Robj.title,game.canvas.width/2-89,0);game.canvas.onmousedown=function(e){var d=e.offsetX;var c=e.offsetY;if((d>game.canvas.width/2-58)&&(d<game.canvas.width/2+58)&&c>360&&c<430){a.changeScene(1);game.bird.color=_.random(0,2)}}}else{if(this.sceneNumber==1){game.ctx.drawImage(game.Robj.text_ready,game.canvas.width/2-98,0);game.canvas.onmousedown=function(e){var d=e.offsetX;var c=e.offsetY;if((d>game.canvas.width/2-57)&&(d<game.canvas.width/2+57)&&c>250&&c<348){a.changeScene(2);game.bird.flyHigh()}}}else{if(this.sceneNumber==2){this.pipes=[];game.canvas.onmousedown=function(c){game.bird.flyHigh()}}else{if(this.sceneNumber==3){game.canvas.onmousedown=function(c){a.changeScene(0);game.bird=new Bird();game.bird.color=_.random(0,2);game.score=0}}}}}};SceneManagement.prototype.render=function(){this.f++;if(this.sceneNumber==0){game.background.render();if(this.f<20){game.ctx.drawImage(game.Robj.title,game.canvas.width/2-89,this.f*5)}else{game.ctx.drawImage(game.Robj.title,game.canvas.width/2-89,100)}if(this.f>20){game.ctx.drawImage(game.Robj.button_play,0,0,116,70,game.canvas.width/2-58,360,116,70)}game.bird.render()}else{if(this.sceneNumber==1){game.background.render();game.land.update();game.land.render();if(this.f<20){game.ctx.drawImage(game.Robj.text_ready,game.canvas.width/2-98,this.f*5)}else{game.ctx.drawImage(game.Robj.text_ready,game.canvas.width/2-98,100)}if(this.f>20){game.ctx.save();game.ctx.globalAlpha=this.f%20/20;game.ctx.drawImage(game.Robj.tutorial,0,0,114,98,game.canvas.width/2-57,250,114,98);game.ctx.restore()}game.bird.render()}else{if(this.sceneNumber==2){game.background.update();game.background.render();game.land.update();game.land.render();if(game.frameNumber%120==0){this.pipes.push(new Pipe())}_.each(this.pipes,function(d){d.update();d.render()});game.bird.update();game.bird.render();var b=game.score.toString().length;for(var c=0;c<b;c++){var a=game.score.toString().charAt(c);game.ctx.drawImage(game.Robj["score"+a],game.canvas.width/2-15*b+c*30,420)}}else{if(this.sceneNumber==3){game.background.render();game.land.render();_.each(this.pipes,function(d){d.render()});game.bird.render();game.ctx.drawImage(game.Robj.game_over,game.canvas.width/2-102,100);game.ctx.fillText("分数: "+game.score,90,270);game.ctx.fillText("点击任何地方继续",90,300)}}}}}})();(function(){var u=this;var k=u._;var H=Array.prototype,g=Object.prototype,n=Function.prototype;var K=H.push,l=H.slice,c=g.toString,j=g.hasOwnProperty;var s=Array.isArray,e=Object.keys,I=n.bind,A=Object.create;var D=function(){};var M=function(N){if(N instanceof M){return N}if(!(this instanceof M)){return new M(N)}this._wrapped=N};if(typeof exports!=="undefined"){if(typeof module!=="undefined"&&module.exports){exports=module.exports=M}exports._=M}else{u._=M}M.VERSION="1.8.2";var b=function(O,N,P){if(N===void 0){return O}switch(P==null?3:P){case 1:return function(Q){return O.call(N,Q)};case 2:return function(R,Q){return O.call(N,R,Q)};case 3:return function(R,Q,S){return O.call(N,R,Q,S)};case 4:return function(Q,S,R,T){return O.call(N,Q,S,R,T)}}return function(){return O.apply(N,arguments)}};var E=function(O,N,P){if(O==null){return M.identity}if(M.isFunction(O)){return b(O,N,P)}if(M.isObject(O)){return M.matcher(O)}return M.property(O)};M.iteratee=function(O,N){return E(O,N,Infinity)};var p=function(O,N){return function(W){var U=arguments.length;if(U<2||W==null){return W}for(var Q=1;Q<U;Q++){var V=arguments[Q],T=O(V),P=T.length;for(var S=0;S<P;S++){var R=T[S];if(!N||W[R]===void 0){W[R]=V[R]}}}return W}};var B=function(O){if(!M.isObject(O)){return{}}if(A){return A(O)}D.prototype=O;var N=new D;D.prototype=null;return N};var J=Math.pow(2,53)-1;var C=function(O){var N=O!=null&&O.length;return typeof N=="number"&&N>=0&&N<=J};M.each=M.forEach=function(R,S,O){S=b(S,O);var N,Q;if(C(R)){for(N=0,Q=R.length;N<Q;N++){S(R[N],N,R)}}else{var P=M.keys(R);for(N=0,Q=P.length;N<Q;N++){S(R[P[N]],P[N],R)}}return R};M.map=M.collect=function(S,U,P){U=E(U,P);var R=!C(S)&&M.keys(S),Q=(R||S).length,O=Array(Q);for(var N=0;N<Q;N++){var T=R?R[N]:N;O[N]=U(S[T],T,S)}return O};function y(N){function O(T,V,P,S,Q,R){for(;Q>=0&&Q<R;Q+=N){var U=S?S[Q]:Q;P=V(P,T[U],U,T)}return P}return function(U,V,P,R){V=b(V,R,4);var T=!C(U)&&M.keys(U),S=(T||U).length,Q=N>0?0:S-1;if(arguments.length<3){P=U[T?T[Q]:Q];Q+=N}return O(U,V,P,T,Q,S)}}M.reduce=M.foldl=M.inject=y(1);M.reduceRight=M.foldr=y(-1);M.find=M.detect=function(Q,N,P){var O;if(C(Q)){O=M.findIndex(Q,N,P)}else{O=M.findKey(Q,N,P)}if(O!==void 0&&O!==-1){return Q[O]}};M.filter=M.select=function(Q,N,P){var O=[];N=E(N,P);M.each(Q,function(T,R,S){if(N(T,R,S)){O.push(T)}});return O};M.reject=function(P,N,O){return M.filter(P,M.negate(E(N)),O)};M.every=M.all=function(S,N,P){N=E(N,P);var R=!C(S)&&M.keys(S),Q=(R||S).length;for(var O=0;O<Q;O++){var T=R?R[O]:O;if(!N(S[T],T,S)){return false}}return true};M.some=M.any=function(S,N,P){N=E(N,P);var R=!C(S)&&M.keys(S),Q=(R||S).length;for(var O=0;O<Q;O++){var T=R?R[O]:O;if(N(S[T],T,S)){return true}}return false};M.contains=M.includes=M.include=function(P,O,N){if(!C(P)){P=M.values(P)}return M.indexOf(P,O,typeof N=="number"&&N)>=0};M.invoke=function(P,Q){var N=l.call(arguments,2);var O=M.isFunction(Q);return M.map(P,function(S){var R=O?Q:S[Q];return R==null?R:R.apply(S,N)})};M.pluck=function(O,N){return M.map(O,M.property(N))};M.where=function(O,N){return M.filter(O,M.matcher(N))};M.findWhere=function(O,N){return M.find(O,M.matcher(N))};M.max=function(Q,S,N){var V=-Infinity,T=-Infinity,U,P;if(S==null&&Q!=null){Q=C(Q)?Q:M.values(Q);for(var R=0,O=Q.length;R<O;R++){U=Q[R];if(U>V){V=U}}}else{S=E(S,N);M.each(Q,function(Y,W,X){P=S(Y,W,X);if(P>T||P===-Infinity&&V===-Infinity){V=Y;T=P}})}return V};M.min=function(Q,S,N){var V=Infinity,T=Infinity,U,P;if(S==null&&Q!=null){Q=C(Q)?Q:M.values(Q);for(var R=0,O=Q.length;R<O;R++){U=Q[R];if(U<V){V=U}}}else{S=E(S,N);M.each(Q,function(Y,W,X){P=S(Y,W,X);if(P<T||P===Infinity&&V===Infinity){V=Y;T=P}})}return V};M.shuffle=function(R){var S=C(R)?R:M.values(R);var Q=S.length;var N=Array(Q);for(var O=0,P;O<Q;O++){P=M.random(0,O);if(P!==O){N[O]=N[P]}N[P]=S[O]}return N};M.sample=function(O,P,N){if(P==null||N){if(!C(O)){O=M.values(O)}return O[M.random(O.length-1)]}return M.shuffle(O).slice(0,Math.max(0,P))};M.sortBy=function(O,P,N){P=E(P,N);return M.pluck(M.map(O,function(S,Q,R){return{value:S,index:Q,criteria:P(S,Q,R)}}).sort(function(T,S){var R=T.criteria;var Q=S.criteria;if(R!==Q){if(R>Q||R===void 0){return 1}if(R<Q||Q===void 0){return -1}}return T.index-S.index}),"value")};var q=function(N){return function(Q,R,P){var O={};R=E(R,P);M.each(Q,function(U,S){var T=R(U,S,Q);N(O,U,T)});return O}};M.groupBy=q(function(N,P,O){if(M.has(N,O)){N[O].push(P)}else{N[O]=[P]}});M.indexBy=q(function(N,P,O){N[O]=P});M.countBy=q(function(N,P,O){if(M.has(N,O)){N[O]++}else{N[O]=1}});M.toArray=function(N){if(!N){return[]}if(M.isArray(N)){return l.call(N)}if(C(N)){return M.map(N,M.identity)}return M.values(N)};M.size=function(N){if(N==null){return 0}return C(N)?N.length:M.keys(N).length};M.partition=function(R,N,P){N=E(N,P);var Q=[],O=[];M.each(R,function(T,S,U){(N(T,S,U)?Q:O).push(T)});return[Q,O]};M.first=M.head=M.take=function(P,O,N){if(P==null){return void 0}if(O==null||N){return P[0]}return M.initial(P,P.length-O)};M.initial=function(P,O,N){return l.call(P,0,Math.max(0,P.length-(O==null||N?1:O)))};M.last=function(P,O,N){if(P==null){return void 0}if(O==null||N){return P[P.length-1]}return M.rest(P,Math.max(0,P.length-O))};M.rest=M.tail=M.drop=function(P,O,N){return l.call(P,O==null||N?1:O)};M.compact=function(N){return M.filter(N,M.identity)};var v=function(T,P,U,X){var O=[],W=0;for(var R=X||0,N=T&&T.length;R<N;R++){var V=T[R];if(C(V)&&(M.isArray(V)||M.isArguments(V))){if(!P){V=v(V,P,U)}var Q=0,S=V.length;O.length+=S;while(Q<S){O[W++]=V[Q++]}}else{if(!U){O[W++]=V}}}return O};M.flatten=function(O,N){return v(O,N,false)};M.without=function(N){return M.difference(N,l.call(arguments,1))};M.uniq=M.unique=function(U,Q,T,O){if(U==null){return[]}if(!M.isBoolean(Q)){O=T;T=Q;Q=false}if(T!=null){T=E(T,O)}var W=[];var N=[];for(var S=0,P=U.length;S<P;S++){var V=U[S],R=T?T(V,S,U):V;if(Q){if(!S||N!==R){W.push(V)}N=R}else{if(T){if(!M.contains(N,R)){N.push(R);W.push(V)}}else{if(!M.contains(W,V)){W.push(V)}}}}return W};M.union=function(){return M.uniq(v(arguments,true,true))};M.intersection=function(T){if(T==null){return[]}var N=[];var S=arguments.length;for(var P=0,R=T.length;P<R;P++){var Q=T[P];if(M.contains(N,Q)){continue}for(var O=1;O<S;O++){if(!M.contains(arguments[O],Q)){break}}if(O===S){N.push(Q)}}return N};M.difference=function(O){var N=v(arguments,true,true,1);return M.filter(O,function(P){return !M.contains(N,P)})};M.zip=function(){return M.unzip(arguments)};M.unzip=function(Q){var P=Q&&M.max(Q,"length").length||0;var N=Array(P);for(var O=0;O<P;O++){N[O]=M.pluck(Q,O)}return N};M.object=function(R,O){var N={};for(var P=0,Q=R&&R.length;P<Q;P++){if(O){N[R[P]]=O[P]}else{N[R[P][0]]=R[P][1]}}return N};M.indexOf=function(R,P,Q){var N=0,O=R&&R.length;if(typeof Q=="number"){N=Q<0?Math.max(0,O+Q):Q}else{if(Q&&O){N=M.sortedIndex(R,P);return R[N]===P?N:-1}}if(P!==P){return M.findIndex(l.call(R,N),M.isNaN)}for(;N<O;N++){if(R[N]===P){return N}}return -1};M.lastIndexOf=function(Q,O,P){var N=Q?Q.length:0;if(typeof P=="number"){N=P<0?N+P+1:Math.min(N,P+1)}if(O!==O){return M.findLastIndex(l.call(Q,0,N),M.isNaN)}while(--N>=0){if(Q[N]===O){return N}}return -1};function f(N){return function(S,O,Q){O=E(O,Q);var R=S!=null&&S.length;var P=N>0?0:R-1;for(;P>=0&&P<R;P+=N){if(O(S[P],P,S)){return P}}return -1}}M.findIndex=f(1);M.findLastIndex=f(-1);M.sortedIndex=function(U,S,T,P){T=E(T,P,1);var R=T(S);var N=0,Q=U.length;while(N<Q){var O=Math.floor((N+Q)/2);if(T(U[O])<R){N=O+1}else{Q=O}}return N};M.range=function(S,P,R){if(arguments.length<=1){P=S||0;S=0}R=R||1;var Q=Math.max(Math.ceil((P-S)/R),0);var O=Array(Q);for(var N=0;N<Q;N++,S+=R){O[N]=S}return O};var x=function(S,P,R,T,Q){if(!(T instanceof P)){return S.apply(R,Q)}var O=B(S.prototype);var N=S.apply(O,Q);if(M.isObject(N)){return N}return O};M.bind=function(Q,O){if(I&&Q.bind===I){return I.apply(Q,l.call(arguments,1))}if(!M.isFunction(Q)){throw new TypeError("Bind must be called on a function")}var N=l.call(arguments,2);var P=function(){return x(Q,P,O,this,N.concat(l.call(arguments)))};return P};M.partial=function(O){var P=l.call(arguments,1);var N=function(){var Q=0,T=P.length;var R=Array(T);for(var S=0;S<T;S++){R[S]=P[S]===M?arguments[Q++]:P[S]}while(Q<arguments.length){R.push(arguments[Q++])}return x(O,N,this,this,R)};return N};M.bindAll=function(Q){var O,P=arguments.length,N;if(P<=1){throw new Error("bindAll must be passed function names")}for(O=1;O<P;O++){N=arguments[O];Q[N]=M.bind(Q[N],Q)}return Q};M.memoize=function(O,N){var P=function(S){var R=P.cache;var Q=""+(N?N.apply(this,arguments):S);if(!M.has(R,Q)){R[Q]=O.apply(this,arguments)}return R[Q]};P.cache={};return P};M.delay=function(O,P){var N=l.call(arguments,2);return setTimeout(function(){return O.apply(null,N)},P)};M.defer=M.partial(M.delay,M,1);M.throttle=function(O,Q,U){var N,S,V;var T=null;var R=0;if(!U){U={}}var P=function(){R=U.leading===false?0:M.now();T=null;V=O.apply(N,S);if(!T){N=S=null}};return function(){var W=M.now();if(!R&&U.leading===false){R=W}var X=Q-(W-R);N=this;S=arguments;if(X<=0||X>Q){if(T){clearTimeout(T);T=null}R=W;V=O.apply(N,S);if(!T){N=S=null}}else{if(!T&&U.trailing!==false){T=setTimeout(P,X)}}return V}};M.debounce=function(P,R,O){var U,T,N,S,V;var Q=function(){var W=M.now()-S;if(W<R&&W>=0){U=setTimeout(Q,R-W)}else{U=null;if(!O){V=P.apply(N,T);if(!U){N=T=null}}}};return function(){N=this;T=arguments;S=M.now();var W=O&&!U;if(!U){U=setTimeout(Q,R)}if(W){V=P.apply(N,T);N=T=null}return V}};M.wrap=function(N,O){return M.partial(O,N)};M.negate=function(N){return function(){return !N.apply(this,arguments)}};M.compose=function(){var N=arguments;var O=N.length-1;return function(){var Q=O;var P=N[O].apply(this,arguments);while(Q--){P=N[Q].call(this,P)}return P}};M.after=function(O,N){return function(){if(--O<1){return N.apply(this,arguments)}}};M.before=function(P,O){var N;return function(){if(--P>0){N=O.apply(this,arguments)}if(P<=1){O=null}return N}};M.once=M.partial(M.before,2);var F=!{toString:null}.propertyIsEnumerable("toString");var a=["valueOf","isPrototypeOf","toString","propertyIsEnumerable","hasOwnProperty","toLocaleString"];function d(R,Q){var N=a.length;var O=R.constructor;var P=(M.isFunction(O)&&O.prototype)||g;var S="constructor";if(M.has(R,S)&&!M.contains(Q,S)){Q.push(S)}while(N--){S=a[N];if(S in R&&R[S]!==P[S]&&!M.contains(Q,S)){Q.push(S)}}}M.keys=function(P){if(!M.isObject(P)){return[]}if(e){return e(P)}var O=[];for(var N in P){if(M.has(P,N)){O.push(N)}}if(F){d(P,O)}return O};M.allKeys=function(P){if(!M.isObject(P)){return[]}var O=[];for(var N in P){O.push(N)}if(F){d(P,O)}return O};M.values=function(R){var Q=M.keys(R);var P=Q.length;var N=Array(P);for(var O=0;O<P;O++){N[O]=R[Q[O]]}return N};M.mapObject=function(S,U,P){U=E(U,P);var R=M.keys(S),Q=R.length,O={},T;for(var N=0;N<Q;N++){T=R[N];O[T]=U(S[T],T,S)}return O};M.pairs=function(R){var P=M.keys(R);var O=P.length;var Q=Array(O);for(var N=0;N<O;N++){Q[N]=[P[N],R[P[N]]]}return Q};M.invert=function(R){var N={};var Q=M.keys(R);for(var O=0,P=Q.length;O<P;O++){N[R[Q[O]]]=Q[O]}return N};M.functions=M.methods=function(P){var O=[];for(var N in P){if(M.isFunction(P[N])){O.push(N)}}return O.sort()};M.extend=p(M.allKeys);M.extendOwn=M.assign=p(M.keys);M.findKey=function(T,N,Q){N=E(N,Q);var S=M.keys(T),P;for(var O=0,R=S.length;O<R;O++){P=S[O];if(N(T[P],P,T)){return P}}};M.pick=function(P,T,N){var X={},Q=P,S,W;if(Q==null){return X}if(M.isFunction(T)){W=M.allKeys(Q);S=b(T,N)}else{W=v(arguments,false,false,1);S=function(Z,Y,aa){return Y in aa};Q=Object(Q)}for(var R=0,O=W.length;R<O;R++){var V=W[R];var U=Q[V];if(S(U,V,Q)){X[V]=U}}return X};M.omit=function(P,Q,N){if(M.isFunction(Q)){Q=M.negate(Q)}else{var O=M.map(v(arguments,false,false,1),String);Q=function(S,R){return !M.contains(O,R)}}return M.pick(P,Q,N)};M.defaults=p(M.allKeys,true);M.create=function(O,P){var N=B(O);if(P){M.extendOwn(N,P)}return N};M.clone=function(N){if(!M.isObject(N)){return N}return M.isArray(N)?N.slice():M.extend({},N)};M.tap=function(O,N){N(O);return O};M.isMatch=function(O,N){var S=M.keys(N),R=S.length;if(O==null){return !R}var T=Object(O);for(var Q=0;Q<R;Q++){var P=S[Q];if(N[P]!==T[P]||!(P in T)){return false}}return true};var L=function(V,U,O,Q){if(V===U){return V!==0||1/V===1/U}if(V==null||U==null){return V===U}if(V instanceof M){V=V._wrapped}if(U instanceof M){U=U._wrapped}var S=c.call(V);if(S!==c.call(U)){return false}switch(S){case"[object RegExp]":case"[object String]":return""+V===""+U;case"[object Number]":if(+V!==+V){return +U!==+U}return +V===0?1/+V===1/U:+V===+U;case"[object Date]":case"[object Boolean]":return +V===+U}var P=S==="[object Array]";if(!P){if(typeof V!="object"||typeof U!="object"){return false}var T=V.constructor,R=U.constructor;if(T!==R&&!(M.isFunction(T)&&T instanceof T&&M.isFunction(R)&&R instanceof R)&&("constructor" in V&&"constructor" in U)){return false}}O=O||[];Q=Q||[];var N=O.length;while(N--){if(O[N]===V){return Q[N]===U}}O.push(V);Q.push(U);if(P){N=V.length;if(N!==U.length){return false}while(N--){if(!L(V[N],U[N],O,Q)){return false}}}else{var X=M.keys(V),W;N=X.length;if(M.keys(U).length!==N){return false}while(N--){W=X[N];if(!(M.has(U,W)&&L(V[W],U[W],O,Q))){return false}}}O.pop();Q.pop();return true};M.isEqual=function(O,N){return L(O,N)};M.isEmpty=function(N){if(N==null){return true}if(C(N)&&(M.isArray(N)||M.isString(N)||M.isArguments(N))){return N.length===0}return M.keys(N).length===0};M.isElement=function(N){return !!(N&&N.nodeType===1)};M.isArray=s||function(N){return c.call(N)==="[object Array]"};M.isObject=function(O){var N=typeof O;return N==="function"||N==="object"&&!!O};M.each(["Arguments","Function","String","Number","Date","RegExp","Error"],function(N){M["is"+N]=function(O){return c.call(O)==="[object "+N+"]"}});if(!M.isArguments(arguments)){M.isArguments=function(N){return M.has(N,"callee")}}if(typeof/./!="function"&&typeof Int8Array!="object"){M.isFunction=function(N){return typeof N=="function"||false}}M.isFinite=function(N){return isFinite(N)&&!isNaN(parseFloat(N))};M.isNaN=function(N){return M.isNumber(N)&&N!==+N};M.isBoolean=function(N){return N===true||N===false||c.call(N)==="[object Boolean]"};M.isNull=function(N){return N===null};M.isUndefined=function(N){return N===void 0};M.has=function(O,N){return O!=null&&j.call(O,N)};M.noConflict=function(){u._=k;return this};M.identity=function(N){return N};M.constant=function(N){return function(){return N}};M.noop=function(){};M.property=function(N){return function(O){return O==null?void 0:O[N]}};M.propertyOf=function(N){return N==null?function(){}:function(O){return N[O]}};M.matcher=M.matches=function(N){N=M.extendOwn({},N);return function(O){return M.isMatch(O,N)}};M.times=function(R,Q,P){var N=Array(Math.max(0,R));Q=b(Q,P,1);for(var O=0;O<R;O++){N[O]=Q(O)}return N};M.random=function(O,N){if(N==null){N=O;O=0}return O+Math.floor(Math.random()*(N-O+1))};M.now=Date.now||function(){return new Date().getTime()};var r={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;","`":"&#x60;"};var m=M.invert(r);var w=function(R){var O=function(S){return R[S]};var Q="(?:"+M.keys(R).join("|")+")";var P=RegExp(Q);var N=RegExp(Q,"g");return function(S){S=S==null?"":""+S;return P.test(S)?S.replace(N,O):S}};M.escape=w(r);M.unescape=w(m);M.result=function(N,P,Q){var O=N==null?void 0:N[P];if(O===void 0){O=Q}return M.isFunction(O)?O.call(N):O};var z=0;M.uniqueId=function(N){var O=++z+"";return N?N+O:O};M.templateSettings={evaluate:/<%([\s\S]+?)%>/g,interpolate:/<%=([\s\S]+?)%>/g,escape:/<%-([\s\S]+?)%>/g};var t=/(.)^/;var h={"'":"'","\\":"\\","\r":"r","\n":"n","\u2028":"u2028","\u2029":"u2029"};var i=/\\|'|\r|\n|\u2028|\u2029/g;var G=function(N){return"\\"+h[N]};M.template=function(W,Q,T){if(!Q&&T){Q=T}Q=M.defaults({},Q,M.templateSettings);var R=RegExp([(Q.escape||t).source,(Q.interpolate||t).source,(Q.evaluate||t).source].join("|")+"|$","g");var S=0;var N="__p+='";W.replace(R,function(Y,Z,X,ab,aa){N+=W.slice(S,aa).replace(i,G);S=aa+Y.length;if(Z){N+="'+\n((__t=("+Z+"))==null?'':_.escape(__t))+\n'"}else{if(X){N+="'+\n((__t=("+X+"))==null?'':__t)+\n'"}else{if(ab){N+="';\n"+ab+"\n__p+='"}}}return Y});N+="';\n";if(!Q.variable){N="with(obj||{}){\n"+N+"}\n"}N="var __t,__p='',__j=Array.prototype.join,print=function(){__p+=__j.call(arguments,'');};\n"+N+"return __p;\n";try{var P=new Function(Q.variable||"obj","_",N)}catch(U){U.source=N;throw U}var V=function(X){return P.call(this,X,M)};var O=Q.variable||"obj";V.source="function("+O+"){\n"+N+"}";return V};M.chain=function(O){var N=M(O);N._chain=true;return N};var o=function(N,O){return N._chain?M(O).chain():O};M.mixin=function(N){M.each(M.functions(N),function(O){var P=M[O]=N[O];M.prototype[O]=function(){var Q=[this._wrapped];K.apply(Q,arguments);return o(this,P.apply(M,Q))}})};M.mixin(M);M.each(["pop","push","reverse","shift","sort","splice","unshift"],function(N){var O=H[N];M.prototype[N]=function(){var P=this._wrapped;O.apply(P,arguments);if((N==="shift"||N==="splice")&&P.length===0){delete P[0]}return o(this,P)}});M.each(["concat","join","slice"],function(N){var O=H[N];M.prototype[N]=function(){return o(this,O.apply(this._wrapped,arguments))}});M.prototype.value=function(){return this._wrapped};M.prototype.valueOf=M.prototype.toJSON=M.prototype.value;M.prototype.toString=function(){return""+this._wrapped};if(typeof define==="function"&&define.amd){define("underscore",[],function(){return M})}}.call(this));