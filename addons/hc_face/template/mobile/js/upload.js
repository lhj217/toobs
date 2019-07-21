
$(function(){
var u = navigator.userAgent, app = navigator.appVersion; 
	var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器 
	var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
	if(isAndroid){
		var winHeight = $(window).height();   //获取当前页面高度
		$(window).resize(function(){
			var thisHeight=$(this).height();
			console.log(winHeight,thisHeight)
			if(winHeight - thisHeight >200){
		         //当软键盘弹出，在这里面操作
		         $(".container").css({"position":"absolute","height":parseInt(winHeight+document.body.scrollTop)+"px","scrollTo":thisHeight});
		     }else{
		        //当软键盘收起，在此处操作
		        $(".container").css({"position":"fixed","height":"100vh","scrollTo":0});

		    }
		});
	}
});

// ios键盘回不来
$("input").blur(function(){
	     var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0;
	    window.scrollTo(0, Math.max(scrollHeight - 1, 0));
})
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
var canvasH=56*rate,canvasW=window.screen.width,
// 头像的宽高
avatarW=avatarH=36*rate,
// 头像的宽高比例
avatarRateX=avatarRateY=36*rate/300;
// 头像的左上角坐标
var avatarPointX=(canvasW-avatarW)/2,avatarPointY=(canvasH-avatarH)/2;
// 头像的中间分割先坐标
var middleLine=canvasW/2;

// canvas对象加载
var canvas = document.querySelector('#myCanvas');
var ctx = canvas.getContext('2d');
canvas.width=window.screen.width*2;
canvas.height=$(".photo").height()*2;
$("#myCanvas").css("width",window.screen.width)
$("#myCanvas").css("heihgt",$(".photo").height())

// function getreport(){
// 	var rid = $("#rid").val();
// 	var name = $("#username").val();
// 	if(typeof name == "undefined" || name == '' || name == null){
// 		layer.msg('请输入您的姓名');
// 		return false;
// 	}
// 	$.ajax({
// 		type: "POST",
// 		url: "{php echo $this->createMobileUrl('face',array('method'=>'report'))}",
// 		data: {"rid":rid,"name":name},
// 		dataType: "json",
// 		success: function (res) {
// 			window.location.href="./index.php?i={$_W[uniacid]}&c=entry&do=report&rid="+rid+"&m=hc_face"
// 		}
// 	});
// }

// function submit(){
// 	$(".submitPic").animate({
// 		"opacity":0
// 	},
// 	300,
// 	"linear",
// 	function(){
// 		$(".submitPic").hide();
// 	})
// 	$(".scan").animate({
// 		"opacity":1
// 	},
// 	400,
// 	"linear",
// 	function(){
// 		$(".scan").show()
// 	})

// 	$(".photo,#myCanvas").css("padding",0)
// 	var face_token = $(".face_token").val()
// 	var imgurl = $("#myPic").attr("src")
// 	$("#myPic").attr("src",imgurl)
// 	var img=new Image()
// 	img.src=imgurl;
// 	$("#myPic").animate(
// 	{
// 		width:"36vw",
// 		height:"36vw",
// 		margin:"0 auto",
// 		borderRadius:'18vw'
// 	},
// 	800,
// 	"linear",
// 	function(){
// 		$(".line,.light").show()
// 		$('#upLoadPics').hide()
// 	}
// 	)
// 	// 获取五官描点
// 	$.ajax({
// 		type: "POST",
// 		url: "{php echo $this->createMobileUrl('face',array('method'=>'submit'))}",
// 		data: {"image":imgurl,"face_token":face_token},
// 		dataType: "json",
// 		timeout : 10000,
// 		success: function (res) {
// 			allPoints=res.data
// 			$("#rid").val(res.data.rid);
			
// 			setTimeout(function(){
// 				draw(allPoints)
// 			},800)
// 		}
// 	});
// }
function uploadPhoto() {
	$(".uploadNotice,.uploadContent").hide()
	wx.chooseImage({
		count: 1,
		sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
		sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
		success: function (res) {
			var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
			uploadImg(localIds[0]);
		}
	});
};

// //具体上传图片
// function uploadImg(e) {
// 	wx.uploadImage({
// 		localId: e, // 需要上传的图片的本地ID，由chooseImage接口获得
// 		isShowProgressTips: 1, // 默认为1，显示进度提示
// 		success: function (res) {
// 			serverId = res.serverId;
// 			$.ajax({
// 				url: "{php echo $this->createMobileUrl('face',array('method'=>'upload'))}",
// 				dataType: "json",
// 				async: false,
// 				contentType: "application/x-www-form-urlencoded; charset=UTF-8",
// 				data: {"mediaId": serverId},
// 				type: "POST",
// 				timeout: 30000,
// 				success: function (res, textStatus) {
// 					if(res.code==0){
// 						// ---------------------------上传照片符合规定么------------------//
// 						$(".bug").html(res.msg)
// 						$(".uploadContent,.uploadNotice").show()
// 						$(".uploadContent").animate({
// 							"bottom":0+"px"
// 						},
// 						400,
// 						"linear",
// 						function(){
// 							// $(".scan").show()
// 						})
// 						// ---------------------------上传照片符合规定么------------------//
// 					}
// 					$("#myPic").attr("src",res.data.image)
// 					$(".face_token").val(res.data.face_token)
// 					$(".head").html(res.data.rotation);
// 					$(".left_eye").html(res.data.left);
// 					$(".right_eye").html(res.data.right);

// 					// 隐藏上传页   显示结果页
// 					$(".upLoadPic").animate({
// 						"opacity":0
// 					},
// 					300,
// 					"linear",
// 					function(){
// 						$("#upLoadPic1").hide();
// 					})
// 					$(".submitPic").animate({
// 						"opacity":1,
// 						"margin-top":-$("#upLoadPics").height()+"px"
// 					},
// 					600,
// 					"linear",
// 					function(){
// 						$(".submitPic").show()
// 					})
// 				}
// 			});
// 		}
// 	});
// }
function draw(allPoints) { 
	switch (drawStep) {
		case 0:
		Uppercourt(allPoints.shangting)
		break;
		case 1:
		Stalls(allPoints.zhongting)
		break;
		case 2:
		lowercourt(allPoints.xiating)
		break;
		case 3:
		drawPoints(allPoints.eyebrow)
		break;
		case 4:
		drawPoints(allPoints.eye)
		break;
		case 5:
		drawPoints(allPoints.nose)
		break;
		case 6:
		drawPoints(allPoints.mouse)
		break;
		case 7:
		drawLines(allPoints.chin)
		break;
		case 8:
		drawAllpoints(allPoints.line)
		break;
	}
}
// 绘制五官的位置点
var len=0
function Uppercourt (points) {
	clearInterval(timer)
	timer=setInterval(function(){
		len+=1
		var y1=(avatarPointY+points[0]*avatarRateY)*2
		var y2=(avatarPointY+points[1]*avatarRateY)*2
		if(len<=canvasW/2){
			ctx.lineWidth=1;
			ctx.strokeStyle="#fff";
			ctx.moveTo(middleLine*2,y1);
			ctx.lineTo((middleLine+len)*2,y1);
			ctx.stroke();
			ctx.moveTo(middleLine*2,y2);
			ctx.lineTo((middleLine+len)*2,y2);
			ctx.stroke();
		}else{
			ctx.save()
			ctx.font = '30px Arial';
			ctx.fillStyle = '#fff';
			ctx.fillText("上庭", canvas.width-60,y1+(y2-y1)/2+15); 
			ctx.restore();
			$(".loadingPic"+drawStep).hide()
			$(".right"+drawStep).show()
			clearInterval(timer);
			drawStep++;
			len=0; 
			setTimeout(function(){
				draw(allPoints)
			},500)
		}
	},10)
}
function Stalls (points) {
	clearInterval(timer)
	timer=setInterval(function(){
		len+=1
		var y1=(avatarPointY+points[0]*avatarRateY)*2
		var y2=(avatarPointY+points[1]*avatarRateY)*2
		if(len<=canvasW/2){
			ctx.lineWidth=1;
			ctx.strokeStyle="#fff";
			ctx.moveTo(middleLine*2,y1);
			ctx.lineTo((middleLine+len)*2,y1);
			ctx.stroke();
			ctx.moveTo(middleLine*2,y2);
			ctx.lineTo((middleLine+len)*2,y2);
			ctx.stroke();
		}else{
			ctx.save()
			ctx.font = '30px Arial';
			ctx.fillStyle = '#fff';
			ctx.fillText("中庭", canvas.width-60,y1+(y2-y1)/2+15); 
			ctx.restore()
			$(".loadingPic"+drawStep).hide()
			$(".right"+drawStep).show()
			clearInterval(timer);
			drawStep++;
			len=0; 
			setTimeout(function(){
				draw(allPoints)
			},500)
		}
	},10)
}
function lowercourt (points) {
	clearInterval(timer)
	timer=setInterval(function(){
		len+=1
		var y1=(avatarPointY+points[0]*avatarRateY)*2
		var y2=(avatarPointY+points[1]*avatarRateY)*2
		if(len<=canvasW/2){
			ctx.lineWidth=1;
			ctx.strokeStyle="#fff";
			ctx.beginPath();
			ctx.moveTo(middleLine*2,y1);
			ctx.lineTo((middleLine+len)*2,y1);
			ctx.closePath()
			ctx.stroke();
			ctx.moveTo(middleLine*2,y2);
			ctx.lineTo((middleLine+len)*2,y2);
			ctx.stroke();
		}else{
			ctx.save()
			ctx.font = '30px Arial';
			ctx.fillStyle = '#fff';
			ctx.fillText("下庭", canvas.width-60, y1+(y2-y1)/2+15); 
			ctx.restore()
			$(".loadingPic"+drawStep).hide()
			$(".right"+drawStep).show()
			clearInterval(timer);
			drawStep++;
			len=0; 
			setTimeout(function(){
				ctx.clearRect(0,0,canvas.width,canvas.height); 
				$(".tabList>div:nth-child(2)").addClass("selTab");
				$(".tabDivList").animate({
					"margin-left":"-100%"
				},
				800,
				"linear",
				function(){
					setTimeout(function(){
						draw(allPoints)
					},1500)
				})
			},1500)
		}
	},10)
}
function drawPoints(points){
	for (let i = 0, len = points.length; i <len; i++) {
		var x=avatarPointX+points[i].x*avatarRateX,y=avatarPointY+points[i].y*avatarRateX;
		ctx.beginPath()
		ctx.fillStyle="#fff";
		ctx.arc(2*x, 2*y, 2, 0, 2 * Math.PI)
		ctx.fill()
		if(i>=parseInt(points.length-1)){
			$(".loadingPic"+drawStep).hide();
			$(".right"+drawStep).show();
			drawStep++;
			setTimeout(function(){
				if(drawStep<=6){
					draw(allPoints);
				}else if(drawStep==7){
					setTimeout(function(){
						ctx.clearRect(0,0,canvas.width,canvas.height); 
						$(".tabList>div:nth-child(3)").addClass("selTab");
						$(".tabDivList").animate({
							"margin-left":"-200%"
						},
						800,
						"linear",
						function(){
							draw(allPoints)
						})
					},500)
				}
			},2000)
		}
	} 
}
var line=0;
function drawLines(points){
	var originPointX=avatarPointX+points[1].x*avatarRateX,
	originPointY=avatarPointY+points[1].y*avatarRateX;
	var point1X=avatarPointX+points[0].x*avatarRateX,
	point1Y=avatarPointY+points[0].y*avatarRateX;
	var point2X=avatarPointX+points[2].x*avatarRateX,
	point2Y=avatarPointY+points[2].y*avatarRateX;

	var tan1=(originPointY-point1Y)/(originPointX-point1X)
	var tan2=(originPointY-point2Y)/(point2X-originPointX)
	chinTimer=setInterval(function(){
		line+=1;
		if(line<(point2X-originPointX)*2){	 
			ctx.clearRect(0,0,canvas.width,canvas.height); 
			ctx.beginPath();
			ctx.lineWidth=2;
			ctx.moveTo(originPointX*2,originPointY*2);
			ctx.lineTo((originPointX-line)*2,(originPointY-line*tan1)*2);
			ctx.stroke();
			ctx.beginPath();
			ctx.lineWidth=2;
			ctx.moveTo(originPointX*2,originPointY*2);
			ctx.lineTo((originPointX+line)*2,(originPointY-line*tan2)*2);
			ctx.stroke();
		}else{
			clearInterval(chinTimer)
			$(".loadingPic"+drawStep).hide()
			$(".right"+drawStep).show()
			drawStep++
			setTimeout(function(){
				draw(allPoints)
			},3000)
		}
	},50)
}
function drawAllpoints(points){
	ctx.clearRect(0,0,canvas.width,canvas.height); 
	for (let i = 0, len = points.length; i <len; i++) {
		var x=avatarPointX+points[i].x*avatarRateX,y=avatarPointY+points[i].y*avatarRateX;
		ctx.beginPath()
		ctx.fillStyle="#fff";
		ctx.arc(2*x, 2*y, 2, 0, 2 * Math.PI)
		ctx.fill()
		if(i>=parseInt(points.length-1)){
			$(".loadingPic"+drawStep).hide();
			$(".right"+drawStep).show();
			drawStep++
			setTimeout(function(){
				for (let s = 0, len = points.length; s <len; s++) {
					var j=s+1
					if(s==len-1){
						j=0;
						$(".loadingPic"+drawStep).hide();
						$(".right"+drawStep).show();
						setTimeout(function(){
							$(".scan").animate({
								"opacity":0
							},
							300,
							"linear",
							function(){
								$(".line,.scan,#upLoadPics").hide()
							})
							$(".getResult").animate({
								"opacity":1,
							},
							400,
							"linear",
							function(){
								$(".getResult").show()
								$(".light").css({"background-image":"url(../addons/hc_face/template/mobile/images/sunshine.png)","width":54+"vw","height":54+"vw","box-shadow":"none"})
							})


						},2000)
					}
					draw_line(points[s], points[j])
				}
			},4000)
		}
	} 
}
function draw_line(a,b){
	ctx.lineWidth=1;
	ctx.moveTo((avatarPointX+a.x*avatarRateX)*2,(avatarPointY+a.y*avatarRateX)*2);
	ctx.lineTo((avatarPointX+b.x*avatarRateX)*2,(avatarPointY+b.y*avatarRateX)*2);
	ctx.stroke();
}