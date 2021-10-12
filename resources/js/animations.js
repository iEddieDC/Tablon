(function (){
$(document).ready(function() {
    /*botón subida al cielo*/
    var btn = $('#subir');
    //aparecer/desaparecer
    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
          $("#subir").fadeIn('slow');
        
      } else {
        $("#subir").fadeOut('slow');
      }
    });
  
    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });
    /*cambiar icono menu*/
    $('#menu').click(function (){
      changeClass();
    });

    function changeClass(){
      if($("#menu").attr("class") === "fas fa-bars"){
        $("#menu").removeClass("fas fa-bars").addClass("fas fa-times-circle")
      }else{
        $("#menu").removeClass("fas fa-times-circle").addClass("fas fa-bars")
      }
    }
    /*activar modo oscuro*/
    $('#Darkmode').click(function (){
      cambiarModo();
     
    });
    function cambiarModo() { 
      var cuerpoweb = document.body; 
      cuerpoweb.classList.toggle("oscuro");
  }
    
  
}
);

})();
  