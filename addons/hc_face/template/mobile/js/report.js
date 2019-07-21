
function show(){
	$(".shadows,#imgShow").show()
}
function shareHide(){
	$(".shadows,#imgShow").hide()
}

	//图片左边以及宽高换算
	// 屏幕比例
	var rate=window.screen.width/100,
	// 要绘制的所有坐标点
	allPoints,
	// 绘制到哪一个位置了
	drawStep=0,
	// 定时器
	timer,chinTimer;
	// canvas的宽高
	var canvasH=$(".points").height(),canvasW=window.screen.width,
	share_canvasH=667,share_canvasW=375,
	// 头像的宽高
	avatarW=avatarH=36*rate,
	avatarW1=avatarH1=36*(375/100),
	// 头像的宽高比例
	avatarRateX=avatarRateY=36*rate/300,
	avatarRateX1=avatarRateY1=36*3.75/300;
	// 头像的左上角坐标
	var avatarPointX=(canvasW-avatarW)/2,avatarPointY=(canvasH-avatarH)/2,avatarPointX1=(375-avatarW1)/2,avatarPointY1=(667-avatarH1)/2;
	// 头像的中间分割先坐标
	var middleLine=canvasW/2;

	// 报告显示的头像
	var canvas = document.querySelector('#myCanvas');
	var ctx = canvas.getContext('2d');
	canvas.width=window.screen.width*2;
	canvas.height=$(".points").height()*2;
	$("#myCanvas").css("width",window.screen.width);
	$("#myCanvas").css("height",$(".points").height());


	var titleImgW=0.9*share_canvasW,titleImgH=0.9*743/688*share_canvasW,tops=70*667/1334,atop=240*667/1334;
	var shareCanvas=document.querySelector('#shareCanvas');
	var ctxs = shareCanvas.getContext('2d');
	shareCanvas.width=375*2;
	shareCanvas.height=667*2;
	$("#shareCanvas").css("width",375);
	$("#shareCanvas").css("height",667);
		// 生成海报的canvas参数

		function gaussBlur(imgData) {
			var pixes = imgData.data;
			var width = imgData.width;
			var height = imgData.height;
			var gaussMatrix = [],
			gaussSum = 0,
			x, y,
			r, g, b, a,
			i, j, k, len;

			var radius = 10;
			var sigma = 5;

			a = 1 / (Math.sqrt(2 * Math.PI) * sigma);
			b = -1 / (2 * sigma * sigma);
        //生成高斯矩阵
        for (i = 0, x = -radius; x <= radius; x++, i++) {
        	g = a * Math.exp(b * x * x);
        	gaussMatrix[i] = g;
        	gaussSum += g;

        }

        //归一化, 保证高斯矩阵的值在[0,1]之间
        for (i = 0, len = gaussMatrix.length; i < len; i++) {
        	gaussMatrix[i] /= gaussSum;
        }
        //x 方向一维高斯运算
        for (y = 0; y < height; y++) {
        	for (x = 0; x < width; x++) {
        		r = g = b = a = 0;
        		gaussSum = 0;
        		for (j = -radius; j <= radius; j++) {
        			k = x + j;
                    if (k >= 0 && k < width) {//确保 k 没超出 x 的范围
                        //r,g,b,a 四个一组
                        i = (y * width + k) * 4;
                        r += pixes[i] * gaussMatrix[j + radius];
                        g += pixes[i + 1] * gaussMatrix[j + radius];
                        b += pixes[i + 2] * gaussMatrix[j + radius];
                        // a += pixes[i + 3] * gaussMatrix[j];
                        gaussSum += gaussMatrix[j + radius];
                    }
                }
                i = (y * width + x) * 4;
                // 除以 gaussSum 是为了消除处于边缘的像素, 高斯运算不足的问题
                // console.log(gaussSum)
                pixes[i] = r / gaussSum;
                pixes[i + 1] = g / gaussSum;
                pixes[i + 2] = b / gaussSum;
                // pixes[i + 3] = a ;
            }
        }
        //y 方向一维高斯运算
        for (x = 0; x < width; x++) {
        	for (y = 0; y < height; y++) {
        		r = g = b = a = 0;
        		gaussSum = 0;
        		for (j = -radius; j <= radius; j++) {
        			k = y + j;
                    if (k >= 0 && k < height) {//确保 k 没超出 y 的范围
                    	i = (k * width + x) * 4;
                    	r += pixes[i] * gaussMatrix[j + radius];
                    	g += pixes[i + 1] * gaussMatrix[j + radius];
                    	b += pixes[i + 2] * gaussMatrix[j + radius];
                        // a += pixes[i + 3] * gaussMatrix[j];
                        gaussSum += gaussMatrix[j + radius];
                    }
                }
                i = (y * width + x) * 4;
                pixes[i] = r / gaussSum;
                pixes[i + 1] = g / gaussSum;
                pixes[i + 2] = b / gaussSum;
            }
        }
        return imgData;
    }

    function drawShare(){
    	var report_bg=document.querySelector('#report_bg'),
    	shareMyself=document.querySelector('#shareMyself'),
    	qrcode_bg=document.querySelector('#qrcode_bg'),
    	header=document.querySelector('#header'),
    	qrcode=document.querySelector('#imgss');

		// 绘制背景色
		ctxs.save()    
		ctxs.beginPath(); //开始绘制    
		ctxs.rect(0,0,375*2,(820*667/1334)*2+tops);
		ctxs.fillStyle="#010005";
		ctxs.fill();
		ctxs.restore()

		ctxs.save()
		ctxs.beginPath(); //开始绘制
		ctxs.rect(0,(820*667/1334)*2+tops,375*2,2*(667-820*667/1334-tops));
		ctxs.fillStyle="#FFFCFD";
		ctxs.fill();
		ctxs.restore()

		// 绘制标题
		// var mySelf_bg=new Image();
		shareMyself.crossOrigin="anonymous";
		shareMyself.src=shareMyself.src
		shareMyself.onload=function(){
			ctxs.drawImage(shareMyself,0.1*375, tops*2,titleImgW*2, titleImgH*2);
		}

		// 绘制圆形头像
		// var avatar_img=new Image();
		header.crossOrigin="anonymous";
		header.src=header.src;
		header.onload=function(){
			ctxs.save();
		    ctxs.beginPath(); //开始绘制
		    ctxs.arc(375,atop*2+avatarW1, avatarW1, 0, Math.PI * 2);
		    ctxs.clip();
		    ctxs.drawImage(header,2*(375/2-avatarW1/2), atop*2,avatarW1*2, avatarW1*2);
		    
		    var datas = ctxs.getImageData(2*(375/2-avatarW1/2), atop*2, header.width, header.height);
	        //将图像数据进行高斯模糊 data.data是一个数组，每四个值代表一个像素点的rgba的值，data.width data.height 分别代表图像数据的宽高
	        var emptyData = gaussBlur(datas);
	        //将模糊的图像数据再渲染到画布上面
	        ctxs.putImageData(emptyData, 2*(375/2-avatarW1/2), atop*2);
	        ctxs.restore()
			// 描点
			draws() 

			// 绘制分数
			ctxs.save();
			ctxs.fillStyle = '#EB852A'; 
			ctxs.shadowOffsetZ = 60; // 阴影X轴偏移
			ctxs.shadowBlur = 100; // 模糊尺寸
			ctxs.shadowColor = 'rgba(255, 255, 255, 0.5)'; // 颜色
			ctxs.beginPath();
			ctxs.arc(375+avatarW1/1.5,465*667/1334+avatarW1*2,avatarW1/2.5,0,2 * Math.PI);
			ctxs.fillStyle = "#fff";
			ctxs.fill();  
			ctxs.restore();	

			// 绘制分数
			
			ctxs.save();
			ctxs.font="35px Arial";
			ctxs.fillStyle = "#3E1B92";
			ctxs.fillText("{$loop['score']}"+"分",375+avatarW1/1.5-35,465*667/1334+avatarW1*2+30/2);
			ctxs.restore();	
		}
		
		var str="{$loop['summary']}",result=[],str1;
		if(str.length>180){
			str1=str.slice(0,180);
		}else{
			str1=str
		}
		for(var i=0,len=str1.length;i<len;i+=21){
			if(i==0){
				result.push(str1.slice(i,i+19));
			}else{
				result.push(str1.slice(i,i+21));
			}
		}
		if(str.length>180){
			result[result.length-1]=result[result.length-1]+"......"
		}
		// 文字宽度为

		var text_W=554*375/750/13;
		// 报告背景图片
		// var report_bg=new Image();
		report_bg.crossOrigin="anonymous";
		report_bg.src=report_bg.src
		report_bg.onload=function(){
			ctxs.drawImage(report_bg,0.16*375, 620/1334*667*2,375*0.84*2, 375*0.84*422/653*2);
			var text_Y=0;
			for(var i=0;i<result.length;i++){
				if(i==0){
					x=152
				}else{
					x=100
				}
				// 绘制文字
				ctxs.save()
				text_Y=30*i
				ctxs.font = '26px Arial';
				ctxs.fillStyle = '#333';
				ctxs.fillText(result[i], x ,667/1334*736*2+text_Y); 
				ctxs.restore()
			}
		}
		// 绘制二维码放置的图片
		// var qrcode_bg=new Image();
		qrcode_bg.crossOrigin="anonymous";
		qrcode_bg.src=qrcode_bg.src;
		qrcode_bg.onload=function(){
			ctxs.drawImage(qrcode_bg,0.16*375, 1055/1334*667*2,375*0.84*2, 375*0.84*204/653*2);

			// 绘制标题
			// var qrcode=new Image();
			qrcode.crossOrigin="anonymous";
			qrcode.src=qrcode.src;
			qrcode.onload=function(){
				ctxs.drawImage(qrcode,490*375/750*2, 1090*667/1334*2, 118,118);
				var _imgSrc = shareCanvas.toDataURL("image/png",1);
				shareCanvas.style.display="none";
				　　　　　　 var imgShow = document.getElementById('imgShow');
				　　　　　　     imgShow.setAttribute('src', _imgSrc);
			}
		}
	}



	var points=[
	{x:{$loop['face']['top']['x']},y:{$loop['face']['top']['y']},right:true,title:"{$loop['face']['top']['txt']}"},
	{x:{$loop['face']['eyebrow']['x']},y:{$loop['face']['eyebrow']['y']},right:false,title:"{$loop['face']['eyebrow']['txt']}"},
	{x:{$loop['face']['eye']['x']},y:{$loop['face']['eye']['y']},right:true,title:"{$loop['face']['eye']['txt']}"},
	{x:{$loop['face']['nose']['x']},y:{$loop['face']['nose']['y']},right:false,title:"{$loop['face']['nose']['txt']}"},
	{x:{$loop['face']['mouse']['x']},y:{$loop['face']['mouse']['y']},right:true,title:"{$loop['face']['mouse']['txt']}"}
	]
	function draws(){
		var x1,x2;
		// 绘制圆形实心点
		for(var i=0;i<points.length;i++){
			ctxs.beginPath()
			ctxs.fillStyle="#401C95";
			ctxs.arc((avatarPointX1+points[i].x*avatarRateX1)*2,atop*2+(points[i].y*avatarRateX1)*2, 6, 0, 2 * Math.PI)
			ctxs.fill()
			// 绘制圆形空心点
			ctxs.beginPath()
			ctxs.lineWidth=2;
			ctxs.strokeStyle="#401C95";
			ctxs.arc((avatarPointX1+points[i].x*avatarRateX1)*2,atop*2+(points[i].y*avatarRateX1)*2,10,0,2*Math.PI);
			ctxs.stroke()
			// // 绘制直线
			if(points[i].right){
				x1=10*rate*2
				x2=10*rate*2
			}else{
				x1=(375-10*rate)*2
				x2=(375-10*rate)*2-26*points[i].title.length
			}

			ctxs.beginPath();
			ctxs.lineWidth=2;
			ctxs.fillStyle="#401C95";
			ctxs.moveTo((avatarPointX1+points[i].x*avatarRateX1)*2,atop*2+(points[i].y*avatarRateX1)*2);
			ctxs.lineTo(x1,atop*2+(points[i].y*avatarRateX1)*2);
			ctxs.stroke();

			ctxs.save()
			ctxs.font = '26px Arial';
			ctxs.fillStyle = '#fff';
			ctxs.fillText(points[i].title, x2,atop*2+(points[i].y*avatarRateX1-8)*2); 
			ctxs.restore()

		}
	}
	var ss = {$loop['score_detail']};
	var arr=[
	{$loop['score_detail'][0]},
	{$loop['score_detail'][1]},
	{$loop['score_detail'][2]},
	{$loop['score_detail'][3]},
	{$loop['score_detail'][4]},
	{$loop['score_detail'][5]},
	{$loop['score_detail'][6]}
	];
	for(var i=0;i<arr.length;i++){
		var j=i+1
		$(".featuresItems:nth-child("+j+")>.progress>.active").animate(
			{height:arr[i]/100*20+"vw",},800,"linear",function(){}
			)
	}
	var width={$loop['score']}/100*70;
	$(".myscore").animate({width:width+"vw",},800,"linear",function(){
		console.log("结束")
	})

	function draw(){
		var x1,x2;
		// 绘制圆形实心点
		for(var i=0;i<points.length;i++){
			ctx.beginPath()
			ctx.fillStyle="#401C95";
			ctx.arc((avatarPointX+points[i].x*avatarRateX)*2,(avatarPointY+points[i].y*avatarRateX)*2, 6, 0, 2 * Math.PI)
			ctx.fill()
			// 绘制圆形空心点
			ctx.beginPath()
			ctx.lineWidth=2;
			ctx.strokeStyle="#401C95";
			ctx.arc((avatarPointX+points[i].x*avatarRateX)*2,(avatarPointY+points[i].y*avatarRateX)*2,10,0,2*Math.PI);
			ctx.stroke()
			// // 绘制直线
			if(points[i].right){
				x1=10*rate*2
				x2=10*rate*2
			}else{
				x1=(canvasW-10*rate)*2
				x2=(canvasW-10*rate)*2-26*points[i].title.length
			}

			ctx.beginPath();
			ctx.lineWidth=2;
			ctx.fillStyle="#401C95";
			ctx.moveTo((avatarPointX+points[i].x*avatarRateX)*2,(avatarPointY+points[i].y*avatarRateX)*2);
			ctx.lineTo(x1,(avatarPointY+points[i].y*avatarRateX)*2);
			ctx.stroke();

			ctx.save()
			ctx.font = '26px Arial';
			ctx.fillStyle = '#fff';
			ctx.fillText(points[i].title, x2,(avatarPointY+points[i].y*avatarRateX-8)*2); 
			ctx.restore()

		}
	}
	draw()


	var nose={$loop['nose']['pos']};
	var w=(nose.end.x-nose.start.x),S_rate=rate*20/w;
	var pic_w=pic_h=S_rate*300;
	var noseX=nose.start.x*S_rate,noseY=nose.start.y*S_rate
	$(".nose").css({"width":pic_w,top:-noseY,left:-noseX})



	var mouse={$loop['mouse']['pos']};
	var w=(mouse.end.x-mouse.start.x),S_rate=rate*20/w;
	var pic_w=pic_h=S_rate*300;
	var noseX=mouse.start.x*S_rate,noseY=mouse.start.y*S_rate
	$(".mouse").css({"width":pic_w,top:-noseY,left:-noseX})



	var eye={$loop['eye']['pos']};
	var w=(eye.end.x-eye.start.x),S_rate=rate*20/w;
	var pic_w=pic_h=S_rate*300;
	var noseX=eye.start.x*S_rate,noseY=eye.start.y*S_rate
	$(".eye").css({"width":pic_w,top:-noseY,left:-noseX})
