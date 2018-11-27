/*
jPop - ����������� ������ (v1.0).
������ � ����� ������ ����������� ���������� ���� alert � confirm
(� ����������� �������� � promt).
*/

(function($){
	
	// ------------- ���������� ������� ------------
	var $jPop, /* ���� */
			$jPop_close, /* ������ "�����" */
			$jPop_cont, /* ������� */
			$jPop_ind, /* ��������� �������� */
			$jPop_shadow; /* ���� ���� */
			
	// ------------- ���������� ���������� ------------
	var jPop_pos; /* ������� */
	var jPop_blackout; /* ���������� */
	var jPop_blackout_params; /* ��������� ���������� */
	
	var jPop_methods = {
		/* ---------------- ������������� -------------------- */
		init : function(prm){
			// ���������
			prm = $.extend({
				ws : true, // � ����������� ����
				ws_params : {opacity:50,z:49}, // ��������� ����
				z : 50 // z-index ����
			}, prm);
			
			$jPop = $('<div id="jPop"></div>'); // ����
			$jPop_close = $('<div id="jPop_close" title="������� ����"><a href="javascript:void(0)"><img src="../../../img/close_pop.png" /></a></div>'); // ������ "�����"
			$jPop_cont = $('<div id="jPop_cont"></div>'); // ������� ������ ����
			$jPop_ind = $('<div id="jPop_ind"><img src="/inc/advanced/jPop/ind.gif" width="31" height="31"></div>'); // ��������� ��������
			$jPop_shadow = $('<div id="jPop_shadow"></div>'); // ���� �� ���� (������ ��� IE)
			
            //--�������������� ���, ��� ����� �� ������� ���� �����������----- (������ jPop_close)
            $jPop_close_url= $('#back_url');
            
			// ������������� ������� ����
			$jPop.css({'z-index':prm.z});			
			
			$jPop.prepend($jPop_cont).prepend($jPop_close).prepend($jPop_ind);

			$('body').prepend($jPop);
			
			jPop_blackout = prm.ws;
			jPop_blackout_params = prm.ws_params;
			
			if($.browser.msie)
			{
				$jPop_shadow.css({'z-index':prm.z-1});
				$('body').prepend($jPop_shadow);
			}
			
			$jPop_close.click(function(){ jPop_methods.hide.call(); return false; });
			
            //---�������������� ��� ��� �������� ���� (������������ ��� �������� � ������� ��� ������ ������) --
            $jPop_close_url.live('click',function(){jPop_methods.hide.call(); return false; });
				
			$(window).resize(function(){ jPop_methods.repos.call() });
		},
		
		show : function(prm,callback){
			
            
            $jPop_cont.html('');
            $jPop_ind.show();
            
            if(!$jPop.size() || (!prm.url && !prm.data)) return false;
			
			prm.pos = prm.pos ? prm.pos : 'center';
			jPop_pos = prm.pos;
			
			var windW, windH, windL, windT;
			
			
            $jPop.css({
				'width' : (prm.w ? prm.w : Math.round($('body').width()/2)),
				'height' : (prm.h ? prm.h : Math.round($('body').height()/2))
			});
			if(!$.browser.msie) $jPop.css('-moz-border-radius','5px'); // ����� ��� ������ � ���
			
			windW = $jPop.width();
			windH = $jPop.height();
			windL = 0;
			windT = 0;
			switch(prm.pos)
			{
				default:
				case 'center':
					windL = Math.round( ($('body').width()/2) - (windW/2) + $(window).scrollLeft() );
					windT = Math.round( ($('body').height()/2) - (windH/2) + $(window).scrollTop() );
					break;
				case 'top':
					windL = Math.round( ($('body').width()/2) - (windW/2) + $(window).scrollLeft() );
					windT = Math.round( $(window).scrollTop() + 20 );
					break;				
			}
			
			$jPop.css({'left':windL>0?windL:'10','top':windT>0?windT:'10'});
			$jPop_cont.css({'width':windW-30,'height':windH-30});
			$jPop_close.css('margin-left',windW-$jPop_close.width());
			indL = Math.round( (windW/2) - ($jPop_ind.width()/2) );
			indT = Math.round( (windH/2) - ($jPop_ind.height()/2) );
			$jPop_ind.css('margin',indT+'px 0 0 '+indL+'px');
			
			if(jPop_blackout)
				$(document).jB('show',jPop_blackout_params);
			$jPop.show();
			if($.browser.msie)
			{
				$jPop_shadow.css({
					'width' : windW,
					'height' : windH,
					'left' : windL-4,
					'top' : windT-4
				}).show();
			}
			
			if(prm.url)
			{
				$jPop_cont.load(prm.url,function(){
					$jPop_ind.hide();
				});
			}
			else if(prm.data)
			{
				$jPop_ind.hide();
				$jPop_cont.html(prm.data);
			}
            
		},
		
		hide : function(callback){
			
			$jPop.add($jPop_shadow).hide();
			if(jPop_blackout)
				$(document).jB('hide');
			$jPop_cont.html('');
			$jPop_ind.show();
		},

		refresh : function(prm,callback){
          $jPop_cont.html('');
          $jPop_ind.show();
 
           if(prm.url)
			{
				$jPop_cont.load(prm.url,function(){
                    $jPop_ind.hide();
				});
			}
			else if(prm.data)
			{
				$jPop_ind.hide();
				$jPop_cont.html(prm.data);
			}			
		},

		
		repos : function(){
			
			var jPopLeft = Math.round( ($('body').width()/2) - ($jPop.width()/2) + $(window).scrollLeft() );
			var jPopTop = 0;
			switch(jPop_pos)
			{
				default:
				case 'center':
					jPopTop = Math.round( ($('body').height()/2) - ($jPop.height()/2) + $(window).scrollTop() );
					break;
				case 'top':
					jPopTop = Math.round( $(window).scrollTop() + 20 );
					break;				
			}
			
			// ����
			$jPop.css({'left':jPopLeft,'top':jPopTop});
			// ���� �� ����
			$jPop_shadow.css({'left':jPopLeft-4,'top':jPopTop-4});
			
		}
	};
	
	/* ---------------- ������ jPop -------------------- */
	$.fn.jPop = function(method){
		// ������ ������ ������
		if(jPop_methods[method]) {
			return jPop_methods[method].apply(this,Array.prototype.slice.call(arguments,1));
		} else if (typeof method === 'object' || !method) {
			return jPop_methods.init.apply(this,arguments);
		}/* else {
			$.error('�����'+method+' � jQuery.jPop �� ����������');
		}*/
	};
	
})(jQuery);