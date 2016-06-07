function AJAXInteraction(url, callback) {
    function getHTTPObject() {
        var req = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest(); 
        if (!req) {req=false; } else {return req; }
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
    }
    this.doPost = function(body) {
        request.open("POST", url, true);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send(body);
    }
}

function getform(url,obj,callback) {
  var getstr = "?";
  if (!url) {url='/manager/index.php';}
  var y = obj.getElementsByTagName("input").length;
    for (i=0; i < y; i++) {
        if (obj.getElementsByTagName("input")[i].type == "text") {
           getstr += obj.getElementsByTagName("input")[i].name + "=" +
                   obj.getElementsByTagName("input")[i].value + "&";
        }
        if (obj.getElementsByTagName("input")[i].type == "hidden") {
           getstr += obj.getElementsByTagName("input")[i].name + "=" +
                   obj.getElementsByTagName("input")[i].value + "&";
        }
        if (obj.getElementsByTagName("input")[i].type == "checkbox") {
           if (obj.getElementsByTagName("input")[i].checked) {
              getstr += obj.getElementsByTagName("input")[i].name + "=" +
                   obj.getElementsByTagName("input")[i].value + "&";
           } else {
              getstr += obj.getElementsByTagName("input")[i].name + "=&";
           }
        }
        if (obj.getElementsByTagName("input")[i].type == "radio") {
           if (obj.getElementsByTagName("input")[i].checked) {
              getstr += obj.getElementsByTagName("input")[i].name + "=" +
                   obj.getElementsByTagName("input")[i].value + "&";
           }
     }
     if (obj.getElementsByTagName("SELECT")[i]) {
        var sel = obj.getElementsByTagName("SELECT")[i];
        var multiple = new Array(); 
        for (ii = 0; ii < sel.length; ii ++ ) {
          if (sel.options[ii].selected) { multiple.push(sel.options[ii].value)}
        }
        getstr += sel.name + "=" + multiple.join() + "&";
     }

     if (obj.getElementsByTagName("TEXTAREA")[i]) {
        var sel = obj.getElementsByTagName("TEXTAREA")[i];
        getstr += obj.getElementsByTagName("TEXTAREA")[i].name + "=" +
        obj.getElementsByTagName("TEXTAREA")[i].value + "&";
     }
  }
  var res = new AJAXInteraction(domain+url+getstr, callback); res.doGet();
}

var protocol = (window.location.protocol=='https:') ? 'https://' : 'http://';
var domain = protocol + window.location.hostname;

function save_config_ok(result) {
    var out = (result) ? result : "<span class='error'>Error</span>";
    document.getElementById('report').innerHTML = out;
    setTimeout("document.getElementById('report').innerHTML = ''",1500);
}

function expl(delimiter, string) {
	return string.toString().split ( delimiter.toString() );
}

function save_order_ok(result) {
    var out = (result) ? result : "<span class='error'>Error</span>";
    document.getElementById('myspan').innerHTML = out;
    setTimeout("document.getElementById('myspan').innerHTML = ''",1500);
}

function view_order(result) {
    var out = (result) ? result : "<span class='error'>Error</span>";
    document.getElementById('vieworder').innerHTML = out;
    return false;
}

function testKey(e)
{
  var key = (typeof e.charCode == 'undefined' ? e.keyCode : e.charCode);

  if (e.ctrlKey || e.altKey || key < 32)
    return true;

  key = String.fromCharCode(key);
  return /[\d]/.test(key);
}


function checkedAll (check_var,id) {
 for (var i=0; i<document.forms[id].elements.length; i++) {
  var e=document.forms[id].elements[i];
  if (e.type == "checkbox") e.checked = check_var;
 }
 return false;
}

function preload_image(id) {
    var div=document.getElementById(id);
    if (div) div.innerHTML="";
    //img = document.createElement('img');
    //img.src = domain+'/assets/snippets/shop/images/ajax-loader.gif';
    //img.style.margin = '5px auto';
    //img.alt = 'Идет загрузка, подождите...';

    span = document.createElement('div');
    //span.innerHTML = 'Идет загрузка... ';
    span.style.width = '100%';
    span.style.height = '25px';
    //span.style.border = '1px solid #000';
    span.style.background = 'url(/assets/snippets/tsvshop/images/ajax-loader.gif) no-repeat center bottom';
    
    //span.appendChild(img);
    if (div) div.appendChild(span);
}

function show_order(sid,lang,id) {
  preload_image('vieworder');
  var sis = new AJAXInteraction(domain + '/manager/index.php?a=112&id='+id+'&act=view&idorder='+sid+'&lang='+lang, view_order); sis.doGet();
  return false;
}

function chst(mid,a,url,id,num,callback) {
  if (!url) {url='/manager/index.php';}
  var status = id.value;
  if (status) {
    var getstr = '?id='+mid+'&a='+a+'&act=updstorder&idorder='+num+'&status='+status;
    var res = new AJAXInteraction(domain+url+getstr, callback); res.doGet();
  }
}

function updst(result) {
    if (result) {
      var res = expl('||',result.replace(/\s/g,""));
      if (res[2]=="success" && res[1]) {
        document.getElementById("str"+res[0]).style.background="#"+res[1];
      }
      if (res[2]=="error") {
        alert('error');
      }
    } else {
      alert('error');
    }
}

function isdel(text,url) {
	if (confirm(text)) {
    document.location=url;
	}
	else {
		return false;
	}
}
