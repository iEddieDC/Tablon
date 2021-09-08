$(document).ready(function() {
    /*obtenemos la id */
    $(".like").click(function(){
        var id = this.id;
      // alert(id);
        
      //AJAX
        $.ajax({
            url: 'likes.php',
            type: 'POST',
            data: {id:id},
            dataType: 'json',

            success:function(data){
            var img = data['img'];
                $('#'+id).html(img);
            }
        });
    });
});

