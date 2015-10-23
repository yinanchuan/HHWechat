var Utils = {

	getUserAgent: function(){
		var ua = navigator.userAgent.toLowerCase();
		return ua;
	},
	
    isWeixin: function(){
		var ua = Utils.getUserAgent();
		var isWeixin = ua.indexOf('micromessenger') != -1;
		return isWeixin;
    },
    
    isAndroid: function(){
		var ua = Utils.getUserAgent();
		var isAndroid = ua.indexOf('android') != -1;
		return isAndroid;
    },
    
    isIos: function(){
		var ua = Utils.getUserAgent();
		var isIos = (ua.indexOf('iphone') != -1) || (ua.indexOf('ipad') != -1);
		return isIos;
    },
	
	isIphone4: function(){
		var ua = this.getUserAgent();
		if(ua.indexOf('iphone') != -1 && window.innerWidth == 320 && window.innerHeight == 416){
			return true;
		}
		return false;
    },
	isIphone5: function(){
		//alert(screen.availWidth +'-'+ screen.availHeight);
		var ua = this.getUserAgent();
		if(ua.indexOf('iphone') != -1 && screen.availWidth == 320 && screen.availHeight == 548){
			return true;
		}
		return false;
    },
	isIphone6: function(){
		//TODO screen.availWidth  screen.availHeight
		//http://stackoverflow.com/questions/12505618/detecting-iphone-5-and-any-ios-device-below-it
		var ua = this.getUserAgent();
		if(ua.indexOf('iphone') != -1 && window.innerWidth == 375){
			return true;
		}
		return false;
    },
	isIphone6plus: function(){
		var ua = this.getUserAgent();
		if(ua.indexOf('iphone') != -1 && screen.availWidth === 414){
			return true;
		}
		return false;
    },
	
	isLocal: function(){
		if(_debug && _debug == '1'){
			return true;
		}
		var isLocal = (APP_URL.indexOf('localhost') != -1) || (APP_URL.indexOf('8080') != -1);
		return isLocal;
    },
	
    offsetLeft: function(elements){
        var left = elements.offsetLeft;
        var parent = elements.offsetParent;
        while (parent !== null) {
            left += parent.offsetLeft;
            parent = parent.offsetParent;
        }
        return left;
    },
    
    offsetTop: function(elements){
        var top = elements.offsetTop;
        var parent = elements.offsetParent;
        while (parent !== null) {
            top += parent.offsetTop;
            parent = parent.offsetParent;
        }
        return top;
    },
	
	getHtmlHeight: function(){ //网页总高度
        var htmlHeight = document.body.scrollHeight || document.documentElement.scrollHeight;
		return htmlHeight;
    },
    getClientHeight: function(){ //网页在浏览器中的可视高度
        var clientHeight = document.body.clientHeight || document.documentElement.clientHeight;
		return clientHeight;
    },
	getScrollTop: function(){ //浏览器滚动条的top位置
        var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
		return scrollTop;
    },
	
    isNull: function(val){
        if (val == null || val == '') {
            return true;
        }
        return false;
    },
    
    trim: function(val){
        if (val == null) {
            return "";
        }
        return val.toString().replace(/^\s+|\s+$/g, "");
    },
    
    location: function(url){
        try {
            url = APP_URL + url;
            //window.location.href = url;
            setTimeout(function(){ //TODO Strange jump problem
                window.location.href = url;
            }, 100);
        } 
        catch (e) {
        }
    },
    
    ajaxGet: function(url, callback){
        $.ajax({
            type: 'GET',
            url: APP_URL + url,
            data: {},
            success: function(res){
                if (callback) {
                    callback(res)
                }
            },
            dataType: 'json'
        });
    },
    
    ajaxPost: function(url, data, callback){
        $.ajax({
            type: 'POST',
            url: APP_URL + url,
            data: data,
            success: function(res){
                //alert('success' + JSON.stringify(res));
                if (callback) {callback(res)}
            },
			error: function(XMLHttpRequest, textStatus, errorThrown){
				//alert(JSON.stringify(XMLHttpRequest));
				//alert(JSON.stringify(errorThrown));
			},
            cache: false,
            dataType: 'json'
        });
    }
};

if (!String.prototype.format) {
    String.prototype.format = function(){
        var args = arguments;
        return this.replace(/{(\d+)}/g, function(match, number){
            return typeof args[number] != 'undefined' ? args[number] : match;
        });
    };
};
