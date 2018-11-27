// ПЕРЕДАЕМ URL ВО ФРЕЙМ
function toajax(url)
{
	//frames["ajax"].document.location.href = url;
	showLoad(true);
	console.log('toajax');
	$("#ajax").src = url;
	top.get('ajax').src = url;
}

// ПОКАЗАТЬ/СКРЫТЬ АНИМАШКУ "ЗАГРУЗКА"
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

// ПЕРЕЗАГРУЗИТЬ СТРАНИЦУ ПОСЛЕ РАБОТЫ ФРЕЙМА
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
// ВЫЗОВ ФУНКЦИИ history.back() ПОСЛЕ РАБОТЫ ФРЕЙМА
function topBack(post) // post - страница дергалась формой (иначе - ссылкой)
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

// ОПРЕДЕЛЕНИЕ ТИПА БРАУЗЕРА
function userNavigator()
{
	// Получим userAgent браузера и переведем его в нижний регистр
	var ua = navigator.userAgent.toLowerCase();
	// Определим Internet Explorer
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
	// Safari, используется в MAC OS
	if( (ua.indexOf("safari") != -1) )
		return "isSafari";
	// Konqueror, используется в UNIX-системах
	if( (ua.indexOf("konqueror") != -1) )
		return "isKonqueror";

	return false;
}

// ОТКРЫВАЕТ СТРАНИЦУ В ОТДЕЛЬНОМ ОКНЕ
function openWindow(width,height)
{
/*
	width	размер в пикселах	ширина нового окна
	height	размер в пикселах	высота нового окна
	left	размер в пикселах	абсцисса левого верхнего угла нового окна
	top	размер в пикселах	ордината левого верхнего угла нового окна
	toolbar	1 / 0 / yes / no	вывод панели инструменов
	location	1 / 0 / yes / no	вывод адресной строки
	directories	1 / 0 / yes / no	вывод панели ссылок
	menubar	1 / 0 / yes / no	вывод строки меню
	scrollbars	1 / 0 / yes / no	вывод полос прокрутки
	resizable	1 / 0 / yes / no	возможность изменения размеров окна
	status	1 / 0 / yes / no	вывод строки статуса
	fullscreen	1 / 0 / yes / no	вывод на полный экран
*/
	var left = Math.round((screen.width-width)/2);
	var top = Math.round((screen.height-height)/2)-40;
	var win = window.open('','my','resizable=yes,width='+width+',height='+height+',scrollbars=1,top='+top+',left='+left);
	win.focus();
	// Пример:
	// <a href="page.htm" target="my" onClick="openWindow(570,700)">открыть</a>
}

//
function sure()
{
	return confirm("Уверены?");
}

// ОПРЕДЕЛЕНИЕ КООРДИНАТ ЭЛЕМЕНТА
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
	// Пример:
	// "x = " + absPosition(obj).x;
	// "y = " + absPosition(obj).y;
}

// ОПРЕДЕЛЕНИЕ КООРДИНАТ ПОЛОСЫ ПРОКРУТКИ БРАУЗЕРА
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

// ДОПУСКАЕТ ВВОД ТОЛЬКО ЧИСЕЛ
function numberOnly(e)
{
	if(e.keyCode==44)
		e.keyCode=46;
	return ((e.keyCode>44 && e.keyCode<58) || e.keyCode==0); //  "|| e.keyCode==0" - добавлено для ФайерФокса
}

// ФУНКЦИЯ ПРОВЕРКИ ДАТЫ ВИДА xx.xx.xxxx
function checkDate(val)
{
	return (/^\d{2}\.\d{2}\.\d{4}$/.test(val));
}

// ПРОВЕРКА E-mail
function checkEmail(email)
{
    var reg = new RegExp("^[0-9a-z_^\.]+@[0-9a-z_^\.]+\.[a-z]{2,6}$", 'i');
    return reg.test(email);
}

// ПОЛУЧЕНИЕ GET ПАРАМЕТРОВ
function getQueryVariable(query) //query - можно не передавать
{
	//полачаем строку запроса (?a=123&b=qwe) и удаляем знак ?
	if(!query)
		query = window.location.search.substring(1);
	//получаем массив значений из строки запроса вида vars[0] = ‘a=123’;
	var vars = query.split("&");
	var arr = new Array();
	//переводим массив vars в обычный ассоциативный массив
	for (var i=0;i<vars.length;i++)
	{
		var pair = vars[i].split("=");
		arr[pair[0]] = pair[1];
	}
	return arr;
}

// ИСПОЛЬЗОВАТЬ ВМЕСТО getElementById() (может отдать массив элементов, если передать несколько id)
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

// ФОРМАТИРУЕТ ВЫВОД ЧИСЛА, АНАЛОГ number_format() В PHP
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

// ПРЕДВАРИТЕЛЬНАЯ ЗАГРУЗКА КАРТИНОК
function preloadImg() // в аргументы передаются пути к картинкам
{
	arg = preloadImg.arguments;
	img = new Array();
	for(i=0; i<arg.length; i++)
	{
		img[i] = new Image;
		img[i].src = arg[i];
	}
}