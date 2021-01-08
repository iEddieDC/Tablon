
  /*function mostrarContrasena(){
      var tipo = document.getElementById("password");
      if(tipo.type == "password"){
          tipo.type = "text";
      }else{
          tipo.type = "password";
      }
  }*/
  function obteneridurl(){
    var baseUrl = (window.location).href; // You can also use document.URL
    var koopId = baseUrl.substring(baseUrl.lastIndexOf('=') + 1);
    return koopId;
   //alert(koopId)//503
  }
  //funcion para ocultar boton cerrar sesion si no hay sesion
  

  
