(function () {
  $(document).ready(function () {
    /*botón subida al cielo*/
    var btn = $('#subir');
    //aparecer/desaparecer
    $(window).scroll(function () {
      if ($(window).scrollTop() > 300) {
        $("#subir").fadeIn('slow');
      } else {
        $("#subir").fadeOut('slow');
      }
    });

    btn.on('click', function (e) {
      e.preventDefault();
      $('html, body').animate({ scrollTop: 0 }, '300');
    });

    /*cambiar icono menu*/
    $('#NavMenu').click(function () {
      changeClass();
    });

    function changeClass() {
      if ($("#Menu").attr("class") === "fas fa-bars") {
        $("#Menu").removeClass("fas fa-bars").addClass("fas fa-minus")
      } else {
        $("#Menu").removeClass("fas fa-minus").addClass("fas fa-bars")
      }
    }


    /*activar/desactivar modo oscuro*/

    $('#Darkmode').click(function () {
      var cuerpoweb = document.body; //variable del cuerpo

      /*Validamos modo ocuro esta activo o desactivo*/
      if (document.body.classList.contains('oscuro')) { //cuando el cuerpo tiene la clase 'oscuro' actualmente
        $("#DarkBtn").removeClass("fas fa-sun").addClass("fas fa-moon")//icono
        cuerpoweb.classList.remove("oscuro");//quitamos modo oscuro
        localStorage.setItem('darkMode', 'disabled'); //almacenar estos datos para desactivar modo oscuro 
      } else {//Modo oscuro esta desactivado
        cuerpoweb.classList.toggle("oscuro");//activamos modo oscuro
        $("#DarkBtn").removeClass("fas fa-moon").addClass("fas fa-sun")//icono
        localStorage.setItem('darkMode', 'enabled'); //almacenar estos datos para activar el modo oscuro 
      } 
    });

    /*verificación si esta activo con persistencia de datos*/
    if (localStorage.getItem('darkMode') == 'enabled') {
      document.body.classList.toggle('oscuro');//modo oscuro 
      $("#DarkBtn").removeClass("fas fa-moon").addClass("fas fa-sun")//icono
      
    } else {
      localStorage.removeItem('darkMode');
      localStorage.clear(); //La sintaxis para eliminar todos los artículos de LocalStorage

    }
  }
  );
})();


