wx.error(function(res){
	alert('Wechat jssdk config validation failure:' + JSON.stringify(res));
});

//wx.ready(function () {
//	InitWeixin();
//});

var InitWeixin = function(){
	
	wx.onMenuShareTimeline({
  		title: App.share_desc,
  		link: App.share_url,
  		imgUrl: App.share_img_url,
  		trigger: function (res) {},
  		success: function (res) {
			Utils.ajaxPost('share.php', {
				type: 10,
				url: App.share_url
			}, function(response){});
		},
  		cancel: function (res) {},
  		fail: function (res) {
    		//alert(JSON.stringify(res));
  		}
    });
	
	wx.onMenuShareAppMessage({
	    title: App.share_title,
	    desc: App.share_desc,
	    link: App.share_url,
	    imgUrl: App.share_img_url,
	    success: function () {
			Utils.ajaxPost('share.php', {
				type: 20,
				url: App.share_url
			}, function(response){});
		},
	    cancel: function () {}
	});
	
	//
	wx.onMenuShareQQ({
	    title: App.share_title,
	    desc: App.share_desc,
	    link: App.share_url,
	    imgUrl: App.share_img_url,
	    success: function () {
			Utils.ajaxPost('share.php', {
				type: 30,
				url: App.share_url
			}, function(response){});
		},
	    cancel: function () {}
	});
	wx.onMenuShareWeibo({
	    title: App.share_title,
	    desc: App.share_desc,
	    link: App.share_url,
	    imgUrl: App.share_img_url,
	    success: function () {
			Utils.ajaxPost('share.php', {
				type: 40,
				url: App.share_url
			}, function(response){});
		},
	    cancel: function () {}
	});
	
};
