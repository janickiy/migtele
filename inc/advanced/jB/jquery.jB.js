/*
jBlackout - собственный плагин (v1.0).
«атемнение
*/

(function($){
	
	// ------------- глобальные объекты ------------
	var $jB; /* тень */
	
	var jB_methods = {
		/* ---------------- »Ќ»÷»јЋ»«ј÷»я -------------------- */
		init : function(prm){
			
			// Settings
			prm = $.extend({
				color : '#000',
				opacity : 80,
				z : 50
			}, prm);
			
			if($('#jB').size())
				jB_methods.destroy.call();
			
			prm.opacity = parseInt(prm.opacity)*0.01;
		
			$jB = $('<div id="jB"></div>');
			$jB.css({
				'position' : 'absolute',
				'left' : '0',
				'top' : '0',
				'background-color' : prm.color,
				'padding' : '0',
				'z-index' : prm.z,
				'display' : 'none'
			});
			$jB.animate({opacity:prm.opacity},0);
			
			$(window).resize(function(){ jB_methods.repos.call() });
			
			$('body').prepend($jB);
		},
		
		show : function(params,callback){
			
			if(!$jB.size()) return false;
			
			if(params!=undefined)
			{
				if(params['background-color']) $jB.css('background-color',params['background-color']);
				if(params['z']) $jB.css('z-index',params['z']);
				if(params['opacity'])
				{
					if(params['opacity']>=1)
						params['opacity'] = parseInt(params['opacity'])*0.01;
					$jB.animate({opacity:params['opacity']},0);
				}
			}
			
			jB_methods.repos.call();
			$jB.show();
			
			if(callback) callback.call();
			
		},
		
		hide : function(callback){
			
			$jB.hide();
			if(callback) callback.call();
			
		},
		
		repos : function(){
		
			$jB.css({
				'width' : $.browser.msie ? $('body').width() : $(document).width(),
				'height' : $(document).height()-($.browser.msie?4:0)
			});
		
		},
		
		destroy : function(){
		
			$jB.remove();
			
		}
	};
	
	/* ---------------- ѕЋј√»Ќ jB -------------------- */
	$.fn.jB = function(method){
		// логика вызова метода
		if(jB_methods[method]) {
			return jB_methods[method].apply(this,Array.prototype.slice.call(arguments,1));
		} else if (typeof method === 'object' || !method) {
			return jB_methods.init.apply(this,arguments);
		}/* else {
			$.error('ћетод'+method+' в jQuery.jPop не существует');
		}*/
	};
	
})(jQuery);