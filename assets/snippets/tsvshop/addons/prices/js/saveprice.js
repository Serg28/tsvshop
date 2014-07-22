var OldTable = 0;



//---------------------------------------------------------------------||
// FUNCTION:    getCookieVal                                           ||

function getCookieVal(offset) {
    var endstr = document.cookie.indexOf(";", offset);
    if (endstr == - 1) endstr = document.cookie.length;
    return (unescape(document.cookie.substring(offset, endstr)));
}



//---------------------------------------------------------------------||
// FUNCTION:    GetCookie                                              ||

function GetCookie(name) {
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;
    do {
        var j = i + alen;
        if (document.cookie.substring(i, j) == arg) return (getCookieVal(j));
        i = document.cookie.indexOf(" ", i) + 1;
        if (i == 0) break;
    } while (i < clen)
    return (null);
}

//---------------------------------------------------------------------||
// FUNCTION:    SetCookie                                              ||

function SetCookie(name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) + ((expires) ? "; expires=" + expires.toGMTString() : "") + ((path) ? "; path=" + path : "") + ((domain) ? "; domain=" + domain : "") + ((secure) ? "; secure" : "");
}



//---------------------------------------------------------------------||
// FUNCTION:    DeleteCookie                                           ||


function DeleteCookie(name, path, domain) {
    if (GetCookie(name)) {
        document.cookie = name + "=" + ((path) ? "; path=" + path : "") + ((domain) ? "; domain=" + domain : "") + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}








function tree_toggle(event) {
    event = event || window.event
    var clickedElem = event.target || event.srcElement
 
    if (!hasClass(clickedElem, 'Expand')) {
        var Elem = clickedElem.id.replace('ler','teble');
        ShowTable(Elem);
        return // клик не там
    }
 
    // Node, на который кликнули
    var node = clickedElem.parentNode
    if (hasClass(node, 'ExpandLeaf')) {
SetCookie("tsvshopnode",node);
        return // клик на листе
    }

    // определить новый класс для узла
    if ((node.className. indexOf( 'ExpandClosed'))>=0){
            node.className = node.className.replace('ExpandClosed','ExpandOpen');
    } else {
            node.className = node.className.replace('ExpandOpen','ExpandClosed');
    }
}
 
 
function hasClass(elem, className) {
    return new RegExp('(^|\\s)'+className+'(\\s|$)').test(elem.className)
}

function ShowTable(Elem) {
        if (OldTable!=0)
        {
            var table2=document.getElementById(OldTable);
            if (table2){
                table2.style.display='none';
SetCookie("tsvshopOldTable",OldTable);
            };
        };
        var table=document.getElementById(Elem);
         if (table)
           {
               table.style.display='';
           }
SetCookie("tsvshopOldTable",Elem);
        OldTable= Elem;
}

   function get2(obj) {
        r=1;
	n=1;
	a="";
	max_r=document.getElementById("price_col").value;
	while (r<=max_r) {
		c=document.getElementById("price_"+r).value;
		z=document.getElementById("_price"+c).value;
		d=document.getElementById("price"+c).value;
            e=document.getElementById("id_price"+c).value   
		if ( z != d){
			a+="&value"+n+"=";
			a+=d;
			a+="&value_"+n+"=";
			a+=e;
			n++;
		}
		r ++;
	}

	a+="&value_col="+n;
      poststr='/manager/index.php?a='+encodeURI( document.getElementById("a").value )+'&id='+encodeURI( document.getElementById("id").value);
	poststr+=a;

	window.location.href=poststr;
 }

ShowTable(GetCookie("tsvshopOldTable"));