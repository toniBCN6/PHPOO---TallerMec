function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function timeout(){
    setTimeout(function(){
        //document.getElementById("testdiv").innerHTML="Pasaron 2 segundos antes de que pudieras ver esto.";
    },2000,"JavaScript");
}

function disableUnlock(){
  //delay(5000);
  document.getElementById("unlock").disabled = true;
  var nodes = document.getElementById("unlock").getElementsByTagName('*');
  for(var i = 0; i < nodes.length; i++){
      nodes[i].disabled = true;
  }
}