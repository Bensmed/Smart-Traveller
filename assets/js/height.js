if (window.XMLHttpRequest){
     xmlhttp = new XMLHttpRequest();
 }else{
     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 }

var PageToSendTo = "footer.php?";

var MyVariable = Math.max(body.scrollHeight, body.offsetHeight,
  html.clientHeight, html.scrollHeight, html.offsetHeight);;

var VariablePlaceholder = "heightValue=";

var UrlToSend = PageToSendTo + VariablePlaceholder + MyVariable;

xmlhttp.open("POST", UrlToSend, false);
xmlhttp.send();