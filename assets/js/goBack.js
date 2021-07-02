$(document).ready(function(){
    document.getElementById('go-back').addEventListener('click', function(event){
    event.preventDefault();
    history.back();
    //window.history.go(-1);
  });
});