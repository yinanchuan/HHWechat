var myapp = {
	
	isLoading: true,
	
	init: function(){
		var _this = this;
		
		_this.setup();
		_this.bindHomePanel();
		
	},
	
	setup: function(){
		var _this = this;
		
		_this.$panelContainer = $('.swiper-container');
		
		
	},
	
	bindHomePanel: function(){
		var _this = this;
		
		TweenMax.to(_this.copyPage1, 1.5, {opacity: 1, ease: Strong.easeInOut, onComplete:function(){}});
		
	}
	
};

window.ontouchmove = function(event){event.preventDefault()};