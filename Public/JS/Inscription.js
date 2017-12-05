$(document).ready(function() {
    var $erreur = $('#erreur'),
        $email = $('#email'),
        $champ = $('.champ'),
        $envoi = $('#envoi'),
        $regex = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;

    $champ.keyup(function() {
        if(($(this).val().length < 5)||($(this).val().length > 15)) {
            $(this).css({
                borderColor : 'red',
                color: 'red'
            });
        }
        else {
            $(this).css({
                borderColor : 'green',
                color : 'green'
            });
        }
    });
    
    $email.keyup(function() {
        if(!$regex.test($(this).val())) {
            $(this).css({
                borderColor : 'red',
                color: 'red'
            });
        }
        else {
            $(this).css({
                borderColor : 'green',
                color : 'green'
            });
        }
    });
    
    $envoi.submit(function(e){
       if(($champ.css('color') === 'rgb(0, 128, 0)')&&($email.css('color') === 'rgb(0, 128, 0)')) {
           $(this).unbind('submit').submit();
       }
       else {
           e.preventDefault();
           $erreur.css('display', 'block');
       }
    });
    
    $rafraichir.click(function(e){
        $champ.css({
            borderColor : '#ccc',
            color : '#555'
        });
        $email.css({
            borderColor : '#ccc',
            color : '#555'
        });
        $erreur.css('display', 'none');
    });
});