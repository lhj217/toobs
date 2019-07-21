function tab(tabId, tabitem, tabDiv, sel) {
	this.tab = document.getElementById(tabId)
	this.item = this.tab.getElementsByClassName(tabitem);
	this.tabDiv = document.getElementsByClassName(tabDiv);
	this.sel = sel;
}
tab.prototype.main = function () {
	var that = this
	for (let i = 0; i < this.item.length; i++) {
		this.item[i].onclick = function () {
			that.show(i);
			$(this).addClass(that.sel).siblings().removeClass(that.sel);
		}
	}
}
tab.prototype.show = function (i) {
	$(this.tabDiv[i]).show().siblings().hide()
}


// footer
function goodsList(tabId, tabitem, tabDiv, tabDivs, sort) {
	tab.apply(this, arguments);
	this.sort = sort
	console.log(sort)
	this.tabDiv = document.getElementsByClassName(tabDiv);
	this.tabDivs = document.getElementsByClassName(tabDivs);
}
goodsList.prototype.main = function () {
	var that = this
	for (let i = 0; i < this.item.length; i++) {
		this.item[i].onclick = function () {
			if (that.sort==1) {
				that.show1(i)
			} else {
				that.show(i);
			}
			$(this).children().eq(1).show().siblings().hide();
			$(this).siblings().children().eq(1).hide().siblings().show();
		}
	}
}
goodsList.prototype.show = function (i) {
	if (i == 1) {
		$(".firstDiv").css({
			"background": "url(../addons/hc_face/template/mobile/images/first11.png) no-repeat",
			"background-size": "100% 100%"
		})
		$(".upload_photo").css({
			"background": "url(../addons/hc_face/template/mobile/images/btn13.png) no-repeat",
			"background-size": "100% 100%"
		})
	} else {
		$(".firstDiv").css({
			"background": "url(../addons/hc_face/template/mobile/images/first.png) no-repeat",
			"background-size": "100% 100%"
		})
		$(".upload_photo").css({
			"background": "url(../addons/hc_face/template/mobile/images/btn.png) no-repeat",
			"background-size": "100% 100%"
		})
	}
	$(this.tabDiv[i]).show().siblings().hide()
	$(this.tabDivs[i]).show().siblings().hide()
}
goodsList.prototype.show1 = function (i) {
	if (i == 1) {
		$(".firstDiv").css({
			"background": "url(../addons/hc_face/template/mobile/images/first.png) no-repeat",
			"background-size": "100% 100%"
		})
		$(".upload_photo").css({
			"background": "url(../addons/hc_face/template/mobile/images/btn.png) no-repeat",
			"background-size": "100% 100%"
		})
	} else {
		$(".firstDiv").css({
			"background": "url(../addons/hc_face/template/mobile/images/first11.png) no-repeat",
			"background-size": "100% 100%"
		})
		$(".upload_photo").css({
			"background": "url(../addons/hc_face/template/mobile/images/btn13.png) no-repeat",
			"background-size": "100% 100%"
		})
	}
	$(this.tabDiv[i]).show().siblings().hide()
	$(this.tabDivs[i]).show().siblings().hide()
}
Object.setPrototypeOf(goodsList.prototype, tab.prototype);
