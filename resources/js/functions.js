/*Se creo este DOC para las funciones de JS en los forms de Registro*/
$(function(){
inicio();

function inicio() {
  $("span.espacio").hide();
  $("span.no").hide();
  $("span.si").hide();
  $("span.vacio").hide();
  $("#password2").keyup(validar);
  $("#password").keyup(validar);
}

function validar() {
  var p1 = document.getElementById("password").value;
  var p2 = document.getElementById("password2").value;
  var espacios = false;
  var cont = 0;
/*validar espacios*/
  while (!espacios && (cont < p1.length)) {
    if (p1.charAt(cont) == " ")
      espacios = true;
    cont++;
  }
  while (!espacios && (cont < p2.length)) {
    if (p1.charAt(cont) == " ")
      espacios = true;
    cont++;
  }
  /*espacios mensaje*/
  if (espacios) {
    $("span.espacio").show();
    return false;
  }else{
    $("span.espacio").hide();
  }
  /*validar que no quede vacio*/
  if (p1.length == 0 || p2.length == 0) {
    
    return false;
  }else{
  }
  
/*validar contraseñas sean iguales*/
  if (p1 != p2) {
    $("span.no").show();
    $("span.si").hide();
    return false;
  } else {
    $("span.no").hide();
    $("span.si").show();
    return true;
  }
  
}
});


