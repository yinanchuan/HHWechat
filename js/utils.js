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
	
	isSafari: function(){
		if(this.userAgent.indexOf('safari') != -1){
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
	
	getEleParams: function(element){
		return element.getBoundingClientRect();
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
	getSize: function(){
		var _html = [];
		_html.push('网页宽：' + window.innerWidth + '-' + window.innerHeight);
		_html.push('网页可见区域宽：' + document.body.clientWidth + '-' + document.body.clientHeight);
		_html.push('网页可见区域宽：' + document.body.offsetWidth + '-' + document.body.offsetHeight);
		_html.push('网页正文全文宽：' + document.body.scrollWidth + '-' + document.body.scrollHeight);
		_html.push('网页被卷去的高：' + document.body.scrollLeft + '-' + document.body.scrollTop);
		_html.push('网页正文部分上：' + window.screenLeft + '-' + window.screenTop);
		_html.push('屏幕分辨率的高：' + window.screen.width + '-' + window.screen.height);
		_html.push('屏幕可用工作区高度：' + window.screen.availWidth + '-' + window.screen.availHeight);
		
		alert(_html.join('\n'));
	},
	
    isNull: function(val){
        if (val == null || val == '') {
            return true;
        }
        return false;
    },
    
	isUndefined: function(obj){
		return typeof obj === 'undefined';
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
	
	accAdd: function(num1, num2){ // 两个浮点数求和
		var r1, r2, m;
        try{ r1 = num1.toString().split('.')[1].length; }catch(e){ r1 = 0; }
        try{ r2 = num2.toString().split('.')[1].length; }catch(e){ r2 = 0; }
        m = Math.pow(10,Math.max(r1, r2));
        return Math.round(num1 * m + num2 * m)/m;
	},
	accSub: function(num1, num2){ // 两个浮点数相减
		var r1, r2, m, n;
        try{ r1 = num1.toString().split('.')[1].length; }catch(e){ r1 = 0; }
        try{ r2 = num2.toString().split('.')[1].length; }catch(e){ r2 = 0; }
        m = Math.pow(10,Math.max(r1,r2));
        n = (r1>=r2) ? r1 : r2;
        return (Math.round(num1*m-num2*m)/m).toFixed(n);
	},
	accDiv: function(num1, num2){ // 两数相除
		var t1, t2, r1, r2;
        try{ t1 = num1.toString().split('.')[1].length; }catch(e){ t1 = 0; }
        try{ t2 = num2.toString().split('.')[1].length;}catch(e){ t2 = 0; }
        r1 = Number(num1.toString().replace('.',''));
        r2 = Number(num2.toString().replace('.',''));
        return (r1/r2)*Math.pow(10,t2-t1);
	},
	accMul: function(num1, num2){ // 两数相乘
		var m = 0, s1 = num1.toString(),s2 = num2.toString(); 
        try{ m += s1.split('.')[1].length }catch(e){}; 
        try{m += s2.split('.')[1].length}catch(e){}; 
        return Number(s1.replace('.',''))*Number(s2.replace('.',''))/Math.pow(10,m);
	},
	
	postShare: function(type, url, memo){
		Utils.ajaxPost('share.php', {
			type: type,
			url: url,
			memo: memo ? memo : ''
		}, function(response){});
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
}

if (!String.prototype.startWith){
	String.prototype.startWith = function(str){
		var reg = new RegExp("^"+str);
		return reg.test(this);
	};
}

if (!String.prototype.endWith){
	String.prototype.endWith = function(str){
		var reg = new RegExp(str+"$");
		return reg.test(this);
	};
}

if (!String.prototype.lengthByte){
	//http://sentsin.com/web/115.html
	String.prototype.lengthByte = function(){
    var b = 0, l = this.length;
	    if( l ){
	        for( var i = 0; i < l; i ++ ){
	            if(this.charCodeAt( i ) > 255 ){
	                b += 2;
	            }else{
	                b ++ ;
	            }
	        }
	        return b;
	    }else{
	        return 0;
	    }
	};
}
