if (!navigator.cookieEnabled) {
    alert(strNoCookies);
}

isIE = window.navigator.userAgent.indexOf("MSIE") > -1;
var protocol = (window.location.protocol == 'https:') ? 'https://' : 'http://';
domain = protocol + window.location.hostname;
var result = null;
var ID = null;
var selOptKo;
var selOptTXT;
var get = (!location.search) ? "?" : "&";
var buttonclass = 'tsv-addtocart'; // класс для кнопки В корзину


// Для всплывающего сообщения
var wObj; // переменная которая хранит div-который в данный момент проявляется
var divnotice = 'tsvglow'; // ID для div всплывающей подсказки
var succ = 'successclass'; // класс для успешного добавления в корзину
var err = 'errorclass'; // класс для ошибочного добавления в корзину
var info = 'infoclass'; // класс для информационного (кастомного) сообщения при добавлении в корзину
var load = 'loadingclass'; // класс для процесса загрузки
var sTimeout = 5; // через сколько вызывать следущую итерацию по уменьшению прозрачности (мс)
var sTimeClose = 3000;
var op = 0; // переменная отвечающая за текущую прозрачность
var tsvres = '';
var position = 'top-right'; // позиция всплывающего сообщения: top-left, top-right, bottom-left, bottom-right, center
function addClass(o, c) {
    var re = new RegExp("(^|\\s)" + c + "(\\s|$)", "g");
    if (re.test(o.className)) return;
    o.className = (o.className + " " + c).replace(/\s+/g, " ").replace(/(^ | $)/g, "");
}

function removeClass(o, c) {
    var re = new RegExp("(^|\\s)" + c + "(\\s|$)", "g");
    o.className = o.className.replace(re, "$1").replace(/\s+/g, " ").replace(/(^ | $)/g, "");
}

function tsvnotice(c, text) {
    wObj = getId(divnotice);
    op = 0.5; // начальная прозрачность 0
    wObj.style.opacity = 0.5; // начальная прозрачность 0
    wObj.innerHTML = text;
    removeClass(wObj, tsvres);
    tsvres = c;
    addClass(wObj, tsvres);
    wObj.style.display = 'block'; // окно стало видимым
    tsvwopen(); // начинаем его плавно проявлять...
}

function tsvwopen() // ф-я которая проявляет объект (div-окно) хранящееся в переменно wObj
{
    //alert(tsvres);
    if (op < 0.85) {
        op += 0.1;
        wObj.style.opacity = op;
        wObj.style.filter = 'alpha(opacity=' + op * 100 + ')';
        t = setTimeout('tsvwopen()', sTimeout);
    } else {
        setTimeout('tsvwclose()', sTimeClose);
    }
}

function tsvwclose() // ф-я которая проявляет объект (div-окно) хранящееся в переменно wObj
{
    if (op > 0) {
        op = op - 0.1;
        wObj.style.opacity = op;
        wObj.style.filter = 'alpha(opacity=' + op * 100 + ')';
        t = setTimeout('tsvwclose()', sTimeout);
    } else {
        wObj.style.display = 'none';
        removeClass(wObj, tsvres);
    }
}
// ----------------
function AJAXInteraction(url, callback) {
    function getHTTPObject() {
        if (typeof XMLHttpRequest === 'undefined') {
            XMLHttpRequest = function() {
                try {
                    return new ActiveXObject("Msxml2.XMLHTTP.6.0");
                } catch (e) {}
                try {
                    return new ActiveXObject("Msxml2.XMLHTTP.3.0");
                } catch (e) {}
                try {
                    return new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {}
                try {
                    return new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
                throw new Error("This browser does not support XMLHttpRequest.");
            };
        }
        return new XMLHttpRequest();
    }

    var request = getHTTPObject();
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                if (callback) callback(request.responseText);
            }
        }
    };

    this.doGet = function() {
        request.open("GET", url, true);
        request.send(null);
    };
    this.doPost = function(body) {
        request.open("POST", url, true);
        request.setRequestHeader("X-Requested-With", "xmlhttprequest");
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
        request.send(body);
    };
}

/*������� ���*/

function replaceS(subject, search, replace) {
    return subject.split(search).join(replace);
}

function findElementByID_(elem, txt) {
    var elems = elem.getElementsByTagName('*');
    var v = elems.length;
    for (var i = v; --i < v;) {
        if (elems[i].id == txt) break;
    }
    if (i < v) {
        return elems[i];
    }
    return (null);
}

function findElementByID(elem, txt) {
    return getId(txt);
}

function moneyFormat(input) {
    var dollars = Math.floor(input);
    var tmp = new String(input);
    for (var decimalAt = tmp.length; --decimalAt > 0;) {
        if (tmp.charAt(decimalAt) == ".") break;
    }
    var cents = "" + Math.round(input * 100);
    cents = cents.substring(cents.length - 2, cents.length);
    //dollars += ((tmp.charAt(decimalAt + 2) == "9") && (cents == "00")) ? 1 : 0;
    if (cents == "0") cents = "00";
    if (PriceFormat == "0,00") return (dollars + "." + cents);
    else return (dollars);
}

function USelect(ID_NUM, form) {
    selOptKo = "";
    selOptTXT = "";
    var text;
    var j;

    try {
        var kol = (form.elements["OptionText"].value);
        if (kol > 0) for (var i = 1; i <= kol; i++) {
            var elem = form.elements["Shop_" + i];
            if (elem.type == 'checkbox' || elem.type == 'radio') {
                if (elem.checked) {
                    text = elem.value;
                    j = text.indexOf("==");
                    if (selOptTXT.length > 0) selOptTXT += ", ";
                    if (elem.getAttribute("data-subname")) {
                        selOptTXT += elem.getAttribute("data-subname") + ": ";
                    } else {
                        selOptTXT += elem.getAttribute("data-subname") + ": ";
                    }
                    selOptTXT += text.substring(j + 2);
                    if (text.substring(0, 1) == "*") {
                        selOptKo = text.substring(0, j) + selOptKo;
                    } else {
                        selOptKo += "+" + text.substring(0, j);
                    }
                }
            } else {
                var Item = elem.selectedIndex;
                var el = elem.length;
                if (Item > -1) {
                    text = elem.options[Item].value;
                    j = text.indexOf("==");
                    if (selOptTXT.length > 0) selOptTXT += ", ";
                    if (elem.getAttribute("data-subname")) {
                        selOptTXT += elem.getAttribute("data-subname") + ": ";
                    } else {
                        selOptTXT += elem.options[Item].getAttribute("data-subname") + ": ";
                    }
                    selOptTXT += text.substring(j + 2);
                    if (text.substring(0, 1) == "*") {
                        selOptKo = text.substring(0, j) + selOptKo;
                    } else {
                        selOptKo += "+" + text.substring(0, j);
                    }
                } else for (n = 0; n < el; n++) {
                    if (elem[n].checked == true) {
                        text = elem[n].value;
                        j = text.indexOf("==");
                        if (selOptTXT.length > 0) selOptTXT += ", ";
                        selOptTXT += elem[n].getAttribute("data-subname") + ": ";
                        selOptTXT += text.substring(j + 2);
                        if (text.substring(0, 1) == "*") {
                            selOptKo = text.substring(0, j) + selOptKo;
                        } else {
                            selOptKo += "+" + text.substring(0, j);
                        }
                    }
                }
            }
        }
    } catch (e) {
        return ("");
    }
}

function Ucalc(ID_NUM) {
    var thisForm = document.getElementsByName('Tovar' + ID_NUM);
    thisForm = thisForm[0];
    //var thisForm = document.getElementById('Tovar' + ID_NUM);
    USelect(ID_NUM, thisForm);
    try {
        elem = findElementByID(thisForm, "price" + ID_NUM);
    } catch (e) {
        return (null);
    }

    if (!elem) {
        return (null);
    }
    if (!thisForm.elements['qty']) {
        var b = 1;
    } else {
        var b = thisForm.elements['qty'].value;
        if (!b || b <= 0) {
            b = 1;
            thisForm.elements['qty'].value = b;
        }
    }
    var c = thisForm.elements['formula'].value;
    c = tryCalc(c, b);
    //	при такой формуле не вычисляется стоимость нескольких экземпляров
    //    c = "=" + c + selOptKo;
    //    c = tryCalc(c, 1);
    c = "=$n*(" + c + selOptKo + ")";
    c = tryCalc(c, b);
    elem.innerHTML = moneyFormat(c);
}


function CalcPrice(ID_NUM, PRICE) {
    var thisForm = document.getElementById('Tovar' + ID_NUM);
    USelect(ID_NUM, thisForm);
    var b = thisForm.elements['qty'].value;
    if (!b) {
        b = 1;
    }
    if (!PRICE) PRICE = "0";
    var c = PRICE;
    c = tryCalc(c, b);
    c = "=" + c + selOptKo;
    c = tryCalc(c, 1);
    return moneyFormat(c);
}

function tryCalc(code, col) {
    try {
        if (typeof code == 'string') {
            var cod = ConvertPrice(code);
            cod = cod.replace(' ', '').replace(',', '.');
            cod = cod.replace('\r\n', '');
            if (cod.indexOf('=') == 0) {
                var a = "";

                var cd = cod.lastIndexOf("//");
                if (cod.charAt(cd + 2) === "r") cod = cod.substring(0, cd)

                cod = replaceS(cod, "&#36", "$");
                cod = replaceS(cod, "$n", col);
                cod = replaceS(cod, "$e", "Math.E");
                cod = replaceS(cod, "max", "Math.max");
                cod = replaceS(cod, "min", "Math.min");
                cod = replaceS(cod, "random", "Math.random");
                cod = replaceS(cod, "floor", "Math.floor");

                eval("a" + cod);
                return (a * 1);

            }
            return cod;
        }
    } catch (e) {
        return ("ERROR");
    }
}

function explode(delimiter, string) {
    return string.toString().split(delimiter.toString());
}


function ConvertPrice(text) {
    var txt = text;
    //var a = txt.indexOf("||",0); //����
    var a = txt.indexOf("||");
    //if(a==0){  //����
    if (a > 0) {
        //var pieces = explode("||", txt);
        var pieces = explode("||", "||" + txt);
        var o = "";
        var o2 = "";
        var value;
        var pos;
        var tmp;
        var pos2;
        var pl = pieces.length;
        for (var i = 0; i < pl; i++) {
            value = pieces[i];
            if (value.length > 0) {
                pos = value.indexOf("-");
                if (pos > 0) {
                    tmp = value.substring(0, pos);
                    o += "(( " + tmp + "<=$n & ";
                    pos2 = value.indexOf("==");
                    tmp = value.substring(pos + 1, pos2);
                    o += tmp + ">=$n)?( ";
                    o2 += "))";
                    tmp = value.substring(pos2 + 2);
                    o += tmp + " ):( ";
                } else {
                    tmp = value;
                    o += tmp;
                }
            }
        }
        return "=" + o + o2;
    }
    return txt;
}

/*-------------*/



function getId(id) {
    return document.getElementById(id);
}

function getClass(classname) {
    return document.getElementsByClassName(classname);
}

function testKey(k) {
    var key = (typeof k.charCode == 'undefined' ? k.keyCode : k.charCode);
    if (k.ctrlKey || k.altKey || key < 32) return true;
    key = String.fromCharCode(key);
    return /[\d]/.test(key);
}

//function ShowWindow(text, width, height) {
function ShowWindow(text, result) {
    tsvnotice(result, text);
    /*
    var log = getId('log');
    var notice = getId('notice');


    if (width == "") width = "150";
    if (height == "") height = "100";
    if (text == "") text = "";


    var w = (window.innerWidth) ? window.innerWidth : ((document.all) ? document.body.offsetWidth : null);
    var h = (window.innerHeight) ? window.innerHeight : ((document.all) ? document.body.offsetHeight : null);
    if (isIE) {
        var t = parseInt(document.documentElement.scrollTop, 10) + document.body.scrollTop;
        var l = parseInt(document.documentElement.scrollLeft, 10) + document.body.scrollLeft;
    } else {
        var t = 0;
        var l = 0;
    }
    var top = (h / 2) - (height / 2);
    var left = (w / 2) - (width / 2);


    log.style.top = t + 'px';
    log.style.left = l + 'px';
    log.style.height = h + 'px';
    log.style.width = w + 'px';
    log.style.visibility = 'visible';
    notice.style.visibility = 'visible';
    notice.style.height = h + 'px';
    notice.style.width = w + 'px';
    notice.style.top = t + 'px';
    notice.style.left = l + 'px';
    notice.innerHTML = text;
    notice.style.paddingTop = (h * 0.33) + 'px';      */
}


function HideWindow(result, text) {
    //getId('notice').style.visibility = 'hidden';
    //getId('log').style.visibility = 'hidden';
    tsvnotice(result, text);
}

function RemoveFromCart(i) {
    if (confirm(strRemove)) {
        location.href = location.href + get + "a=del&num=" + i+"&c="+Date.now();
    } else {
        return false;
    }
}

function ChangeQuantity(i, q) {
    if (isNaN(q)) {
        alert(strErrQty);
    } else {
        if (!q || q <= 0) {
            q = 1;
            this.value = q;
        }
        location.href = location.href + get + "a=chq&num=" + i + "&qnt=" + q+"&c="+Date.now();
    }
}

function AddToCart(ID_NUM, dataset) {

    var dataset = typeof dataset !== 'undefined' ? '&' + dataset : false; //v5.4.5 - теперь можем передать в POST Дополнительные параметры
    if (DisplayNotice) ShowWindow(strAddLoading, load);
    //var thisForm = getId('Tovar' + ID_NUM);
    //var thisForm = document.forms['Tovar' + ID_NUM];
    var thisForm = document.getElementsByName('Tovar' + ID_NUM);
    thisForm = thisForm[0];
    USelect(ID_NUM, thisForm);
    
    //var cart_icon = (ci = thisForm.elements['cart_icon']) ? ci.value : '';
    //var typeitem = (ti = thisForm.elements['typeitem']) ? ti.value : '';
    //var q = (thisForm.elements['qty']) ? parseInt(thisForm.elements['qty'].value) : 1;
    
    var cart_icon = (ci = thisForm.cart_icon) ? ci.value : '';
    var typeitem = (ti = thisForm.typeitem) ? ti.value : 'virtual';
    var q = (thisForm.qty) ? parseInt(thisForm.qty.value) : 1;
    
    strADDTLINFO = "";
    var strCART_ICON = "";
    if (isNaN(q) || !q) {
        alert(strErrQty);
        //thisForm.elements['qty'].value=1;
        HideWindow(err, strErrQty);
    } else {
        //thisForm.elements['qty'].value=q;
        strQUANTITY = q;
        strID_NUM = (!ID_NUM) ? "" : ID_NUM;
        //strNAME = (selOptKo.length) ? " (" + selOptTXT + ")" : "";
        //добавлено разделение названия и опций
        strNAME = (selOptKo.length) ? " ldquo" + selOptTXT + "rdquo" : "";
        /*if (!selOptKo.length) {
            var elPrice = findElementByID(thisForm, "price" + ID_NUM);
            if (elPrice) {
                var pr = elPrice.innerHTML;
                selOptKo = '+' + pr.replace(/[^\d\.]/g, '');
            }
        }*/

        strCART_ICON = (cart_icon) ? cart_icon : "";
        var param = '&idnum=' + ID_NUM + '&name=' + strNAME + '&qty=' + strQUANTITY + '&opt=' + selOptKo + '&icon=' + strCART_ICON + '&typeitem=' + typeitem;
        param = (dataset) ? param + dataset : param; //v5.4.5 добавляем дополнительные параметры из атрибутов data
        var add = new AJAXInteraction(TSVSHOP_URL + 'include/ajax.php', AddSuccess);
        add.doPost('mode=additem' + param+'&c='+Date.now());
    }
    return false;
}


/* Изменение кол-ва товара в корзине. На событие onchange поля name="qty", напр., onChange="changeQTY([+id+],this);return false" */
function changeQTY(ID_NUM, id) {
    if (DisplayNotice) ShowWindow(strAddLoading, load);
    var thisForm = document.getElementsByName('Tovar' + ID_NUM);
    thisForm = thisForm[0];
    USelect(ID_NUM, thisForm);
    
    //var cart_icon = (ci = thisForm.elements['cart_icon']) ? ci.value : '';
    //var typeitem = (ti = thisForm.elements['typeitem']) ? ti.value : '';
    //var q = (thisForm.elements['qty']) ? parseInt(thisForm.elements['qty'].value) : 1;
    
    var cart_icon = (ci = thisForm.cart_icon) ? ci.value : '';
    var typeitem = (ti = thisForm.typeitem) ? ti.value : 'virtual';
    //var q = (thisForm.qty) ? parseInt(thisForm.qty.value) : 1;
	var q = (id) ? parseInt(id.value) : 1;
    
    strADDTLINFO = "";
    var strCART_ICON = "";
    if (isNaN(q)) {
        alert(strErrQty);
        //thisForm.elements['qty'].value=1;
        HideWindow(err, strErrQty);
    } else {
        //thisForm.elements['qty'].value=q;
        strQUANTITY = q;
        strID_NUM = (!ID_NUM) ? "" : ID_NUM;
        //добавлено разделение названия и опций
        strNAME = (selOptKo.length) ? " ldquo" + selOptTXT + "rdquo" : "";
        strCART_ICON = (cart_icon) ? cart_icon : "";
        var param = '&idnum=' + ID_NUM + '&name=' + strNAME + '&qty=' + strQUANTITY + '&opt=' + selOptKo + '&icon=' + strCART_ICON + '&typeitem=' + typeitem;
        //param = (dataset) ? param + dataset : param; //v5.4.5 добавляем дополнительные параметры из атрибутов data
        var add = new AJAXInteraction(TSVSHOP_URL + 'include/ajax.php', AddSuccess);
        add.doPost('mode=changeqty' + param+'&c='+Date.now());
    }
    return false;
}


/*
function AddSuccess(success) {
    if (success) {
      if (DisplayNotice) {
       		HideWindow(succ,strAddSuccess);
    	}
    	if (getId('infoblock_cont')) { GetInfoblock(false);}
    	if (getId('basket_cont')) {preload_image('basket_cont'); GetBasket(false);}
    } else {
      if (DisplayNotice) {
       		HideWindow(err,strAddError);
    	}
    }
}*/

// v5.0.1 - добавлен вывод сообщения из плагина при событии TSVshopOnAddItem. Плагин должен возвращать текст. Иначе - системное сообщение.
function AddSuccess(res) {
    res = replaceS(res, '<br>', '');
    res = replaceS(res, '<br />', '');
    res = replaceS(res, '\r', '');
    res = replaceS(res, '\n', '');
    res = replaceS(res, '\ufeff', '');
    if (res == 'success') {
        if (DisplayNotice) {
            HideWindow(succ, strAddSuccess);
        }
        if (getId('infoblock_cont')) {
            GetInfoblock(false);
        }
        if (getId('basket_cont')) {
            preload_image('basket_cont');
            GetBasket(false);
        }
    }
    if (res == 'error') {
        if (DisplayNotice) {
            HideWindow(err, strAddError);
        }
        if (getId('infoblock_cont')) {
            GetInfoblock(false);
        }
        if (getId('basket_cont')) {
            preload_image('basket_cont');
            GetBasket(false);
        }
    }
    if (res != 'success' && res != 'error' && res) {
        if (DisplayNotice) {
            HideWindow(info, res);
        }
        if (getId('infoblock_cont')) {
            GetInfoblock(false);
        }
        if (getId('basket_cont')) {
            preload_image('basket_cont');
            GetBasket(false);
        }
    }

}

function GetInfoblock(report, type) {
    if (!type) {
        type = "full";
    }
    if (!report) {
        if (getId('infoblock_cont')) loading('infoblock_cont');
        var ib = new AJAXInteraction(TSVSHOP_URL + 'include/ajax.php', GetInfoblock);
        ib.doPost('mode=info&type=' + type+'&c='+Date.now());
    } else {
        if (getId('infoblock_cont')) {
            loading('infoblock_cont');
            getId('infoblock_cont').innerHTML = report;
            //5.4.5 после обновления инфоблока можно задать срабатывание функции TSVshopOnInfoblockUpdate (получает ответ с разметкой инфоблока)
            if(typeof(TSVshopOnInfoblockUpdate)=='function') TSVshopOnInfoblockUpdate(report);
        }
    }
}

function GetBasket(report) {
    if (!report) {
        var b = new AJAXInteraction(TSVSHOP_URL + 'include/ajax.php?mode=basket&c='+Date.now(), GetBasket);
        b.doGet();
    } else {
        getId('basket_cont').innerHTML = report;
        //5.4.5 после обновления корзины можно задать срабатывание функции TSVshopOnBasketUpdate (получает ответ с разметкой корзины)
        if(typeof(TSVshopOnBasketUpdate)=='function') TSVshopOnBasketUpdate(report);
    }
}

function recalcCheckout(report) {
    if (!report) {
        loading('checkout_table');
        var b = new AJAXInteraction(TSVSHOP_URL + 'include/ajax.php?mode=checkout&act=recalc&c='+Date.now(), recalcCheckout);
        b.doGet();
    } else {
        loading('checkout_table');
        getId('checkout_table').innerHTML = report;
        //5.4.5 после обновления корзины (пересчета) можно задать срабатывание функции TSVshopOnCheckoutRecalc (получает ответ с разметкой корзины)
        if(typeof(TSVshopOnCheckoutRecalc)=='function') TSVshopOnCheckoutRecalc(report);
    }
}

function loading(id) {
    var div = document.getElementById(id);
    var width = div.clientWidth;
    var height = div.clientHeight;
    span = document.createElement('div');
    span.style.width = width + "px";
    span.style.height = height + "px";
    span.style.position = 'absolute';
    span.style.opacity = '0.3';
    span.style.margin = "-" + height + "px 0 0 0";
    span.style.background = '#ccc url(\'' + TSVSHOP_URL + 'images/ajax-loader.gif\') no-repeat center center';

    if (div) div.appendChild(span);
}

// Преобразование объекта в URL
function getAsUriParameters(data) {
    return Object.keys(data).map(function(k) {
        if (Array.isArray(data[k])) {
            var keyE = encodeURIComponent(k + '[]');
            return data[k].map(function(subData) {
                return keyE + '=' + encodeURIComponent(subData);
            }).join('&');
        } else {
            return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
        }
    }).join('&');
}

//Init nopcart
function init() {
    if (arguments.callee.done) return;
    arguments.callee.done = true;

    if (!getId(divnotice)) {
        var c = document.createElement('div');
        //c.innerHTML = '<div id="log"></div><div id="notice"></div>';
        c.innerHTML = '<div id="' + divnotice + '" class="jGrowl ie6 ' + position + '"></div>';
        document.body.appendChild(c);
    }

    // v5.4.5 Кнопка добавления товара в корзину. Помимо ИД товара теперь принимает атрибуты data, которые передает в POST
    document.body.onclick = function(e) {
        e = window.event ? event.srcElement : e.target;
        if (e.className && e.className.indexOf(buttonclass) != -1) {
            var idnum = e.dataset.id;
            var dataset = getAsUriParameters(e.dataset); // данные из атрибутов data преобразуем в URL
            AddToCart(idnum, dataset);
            return false;
        };
    };
    //--------
    GetInfoblock(false);
};

function addLoadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload !== 'function') {
        window.onload = func;
    } else {
        window.onload = function() {
            if (oldonload) {
                oldonload();
            }
            func();
        };
    }
}

addLoadEvent(init);