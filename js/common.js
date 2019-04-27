function requestAjax(pageName, callBack, dataArray){
 
  $.ajax({type: "POST",url: "http://localhost:8888/ajax/" + pageName,data: dataArray}).done(function(list) {callBack(list);});
}
function debug_server_info(data){
        console.log(data);
}
String.prototype.cutByte = function(len) {
var str = this;
var l = 0;
for (var i=0; i<str.length; i++) {
       l += (str.charCodeAt(i) > 128) ? 2 : 1;
       if (l > len){
           var string =  str.substring(0,i) + '...';
           string = string.replace(/\n/g, "<br />\n");
           return string;
       }
}
return str;
}

