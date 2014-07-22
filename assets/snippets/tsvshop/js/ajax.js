   var http_request = false;
   function makePOSTRequest(url, parameters) {
      http_request = false;
      if (window.XMLHttpRequest) { // Mozilla, Safari,...
         http_request = new XMLHttpRequest();
         if (http_request.overrideMimeType) {
         	// set type accordingly to anticipated content type
            //http_request.overrideMimeType('text/xml');
            http_request.overrideMimeType('text/html');
         }
      } else if (window.ActiveXObject) { // IE
         try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
            try {
               http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
         }
      }
      if (!http_request) {
         alert('Cannot create XMLHTTP instance');
         return false;
      }
      
      http_request.onreadystatechange = alertContents;
      http_request.open('POST', url, true);
      http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      http_request.setRequestHeader("Content-length", parameters.length);
      http_request.setRequestHeader("Connection", "close");
      http_request.send(parameters);
   }

   function alertContents() {
      if (http_request.readyState == 4) {
         if (http_request.status == 200) {
            //alert(http_request.responseText);
            result = http_request.responseText;
            document.getElementById('myspan').innerHTML = result;  
	    reload_grid();
	setTimeout("document.getElementById('myspan').innerHTML = ''",1500);           
         } else {
            document.getElementById('myspan').innerHTML = "<span class='error'>Error</span>";
	setTimeout("document.getElementById('myspan').innerHTML = ''",1500);
         }
      }
   }
   
   function get(obj) {
      var poststr = "status=" + encodeURI( document.getElementById("status").value ) +
                    "&commentadmin=" + encodeURI( document.getElementById("commentadmin").value )+
                    "&act=" + encodeURI( document.getElementById("act").value )+
                    "&idorder=" + encodeURI( document.getElementById("idorder").value );
      makePOSTRequest('/manager/index.php?a='+encodeURI( document.getElementById("a").value )+'&id='+encodeURI( document.getElementById("id").value ), poststr);
   }
