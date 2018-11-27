// �������� URL �� �����
function toajax(url)
{
	//frames["ajax"].document.location.href = url;
	showLoad(true);
	console.log('toajax');
	$("#ajax").src = url;
	top.get('ajax').src = url;
}

// ��������/������ �������� "��������"
function showLoad(visible)
{
	if(visible==null)
		visible = true;
	try {
		var _img = top.document.getElementById("imgLoad");
		_img.style.visibility = visible ? "visible" : "hidden";
	}
	catch(e) {}
}

// ������������� �������� ����� ������ ������
function topReload()
{
	switch(userNavigator())
	{
		case "isOpera":
		case "isChrome":
			history.go(0);
			break;

		case "isGecko":
			history.back();
			setTimeout("top.location.reload(true)",500);
			break;

		default:
			history.back();
			history.go(0);
			break;
	}
}
// ����� ������� history.back() ����� ������ ������
function topBack(post) // post - �������� ��������� ������ (����� - �������)
{
	showLoad(false);
	switch(userNavigator())
	{
		case "isChrome":
			if(post)
				history.back();
			break;

		default:
			history.back();
			break;
	}
}

// ����������� ���� ��������
function userNavigator()
{
	// ������� userAgent �������� � ��������� ��� � ������ �������
	var ua = navigator.userAgent.toLowerCase();
	// ��������� Internet Explorer
	if( (ua.indexOf("msie") != -1 && ua.indexOf("opera") == -1 && ua.indexOf("webtv") == -1) )
		return "isIE";
	// Opera
	if( (ua.indexOf("opera") != -1) )
		return "isOpera";
	// Chrome
	if( (ua.indexOf("chrome") != -1) )
		return "isChrome";
	// Gecko = Mozilla + Firefox + Netscape
	if( (ua.indexOf("gecko") != -1) )
		return "isGecko";
	// Safari, ������������ � MAC OS
	if( (ua.indexOf("safari") != -1) )
		return "isSafari";
	// Konqueror, ������������ � UNIX-��������
	if( (ua.indexOf("konqueror") != -1) )
		return "isKonqueror";

	return false;
}

// ��������� �������� � ��������� ����
function openWindow(width,height)
{
/*
	width	������ � ��������	������ ������ ����
	height	������ � ��������	������ ������ ����
	left	������ � ��������	�������� ������ �������� ���� ������ ����
	top	������ � ��������	�������� ������ �������� ���� ������ ����
	toolbar	1 / 0 / yes / no	����� ������ �����������
	location	1 / 0 / yes / no	����� �������� ������
	directories	1 / 0 / yes / no	����� ������ ������
	menubar	1 / 0 / yes / no	����� ������ ����
	scrollbars	1 / 0 / yes / no	����� ����� ���������
	resizable	1 / 0 / yes / no	����������� ��������� �������� ����
	status	1 / 0 / yes / no	����� ������ �������
	fullscreen	1 / 0 / yes / no	����� �� ������ �����
*/
	var left = Math.round((screen.width-width)/2);
	var top = Math.round((screen.height-height)/2)-40;
	var win = window.open('','my','resizable=yes,width='+width+',height='+height+',scrollbars=1,top='+top+',left='+left);
	win.focus();
	// ������:
	// <a href="page.htm" target="my" onClick="openWindow(570,700)">�������</a>
}

//
function sure()
{
	return confirm("�������?");
}

// ����������� ��������� ��������
function absPosition(obj)
{
	var x = y = 0;
	while(obj)
	{
		x += obj.offsetLeft;
		y += obj.offsetTop;
		obj = obj.offsetParent;
	}
	return {x:x, y:y};
	// ������:
	// "x = " + absPosition(obj).x;
	// "y = " + absPosition(obj).y;
}

// ����������� ��������� ������ ��������� ��������
function scrollPosition()
{
	var scrOfX = 0, scrOfY = 0;
	if( typeof( window.pageYOffset ) == 'number' ) {
		//Netscape compliant
		scrOfY = window.pageYOffset;
		scrOfX = window.pageXOffset;
	} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
		//DOM compliant
		scrOfY = document.body.scrollTop;
		scrOfX = document.body.scrollLeft;
	} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
		//IE6 Strict
		scrOfY = document.documentElement.scrollTop;
		scrOfX = document.documentElement.scrollLeft;
	}
	return { x:scrOfX, y:scrOfY };
}

// ��������� ���� ������ �����
function numberOnly(e)
{
	if(e.keyCode==44)
		e.keyCode=46;
	return ((e.keyCode>44 && e.keyCode<58) || e.keyCode==0); //  "|| e.keyCode==0" - ��������� ��� ����������
}

// ������� �������� ���� ���� xx.xx.xxxx
function checkDate(val)
{
	return (/^\d{2}\.\d{2}\.\d{4}$/.test(val));
}

// �������� E-mail
function checkEmail(email)
{
    var reg = new RegExp("^[0-9a-z_^\.]+@[0-9a-z_^\.]+\.[a-z]{2,6}$", 'i');
    return reg.test(email);
}

// ��������� GET ����������
function getQueryVariable(query) //query - ����� �� ����������
{
	//�������� ������ ������� (?a=123&b=qwe) � ������� ���� ?
	if(!query)
		query = window.location.search.substring(1);
	//�������� ������ �������� �� ������ ������� ���� vars[0] = �a=123�;
	var vars = query.split("&");
	var arr = new Array();
	//��������� ������ vars � ������� ������������� ������
	for (var i=0;i<vars.length;i++)
	{
		var pair = vars[i].split("=");
		arr[pair[0]] = pair[1];
	}
	return arr;
}

// ������������ ������ getElementById() (����� ������ ������ ���������, ���� �������� ��������� id)
function get()
{
	var elements = new Array();
	for(var i=0; i<arguments.length; i++)
	{
		var element = arguments[i];
		if (typeof element == 'string')
			element = document.getElementById(element);

		if (arguments.length == 1)
			return element;

		elements.push(element);
	}
	return elements;
}

// ����������� ����� �����, ������ number_format() � PHP
function number_format(number, decimals, dec_point, thousands_sep)
{
	var n = number, prec = decimals, dec = dec_point, sep = thousands_sep;
	n = !isFinite(+n) ? 0 : +n;
	prec = !isFinite(+prec) ? 0 : Math.abs(prec);
	sep = sep == undefined ? ',' : sep;

	var s = n.toFixed(prec), abs = Math.abs(n).toFixed(prec), _, i;
	if (abs > 1000) {
		_ = abs.split(/\D/);
		i = _[0].length % 3 || 3;
		_[0] = s.slice(0,i + (n < 0)) + _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
		s = _.join(dec || '.');
	}
	return s;
}

// ��������������� �������� ��������
function preloadImg() // � ��������� ���������� ���� � ���������
{
	arg = preloadImg.arguments;
	img = new Array();
	for(i=0; i<arg.length; i++)
	{
		img[i] = new Image;
		img[i].src = arg[i];
	}
}