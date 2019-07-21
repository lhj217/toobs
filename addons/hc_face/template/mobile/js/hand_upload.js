


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