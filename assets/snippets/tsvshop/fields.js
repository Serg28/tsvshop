function del_file(id) {
var parent = document.getElementById('files');
var elem = document.getElementById(id);
parent.removeChild(elem);
//alert(elem);
return false;
}



function new_file() {
var date= new Date();
var id=date.getTime();
document.getElementById('files').innerHTML+='<div id="'+id+'"><input name="file[]" id="'+id+'" type="file"><button onclick="del_file(\''+id+'\');return 
false;">Удалить</button><br></div>';
return false;
}
