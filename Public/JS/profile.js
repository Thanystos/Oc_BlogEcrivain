$(document).ready(function() {
    var $email = $('#email'),
        $password = $('#password'),
        $sendemail = $('#sendemail'),
        $sendpassword = $('#sendpassword'),
        $regex = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
        
        $password.keyup(function() {
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
        
        $sendpassword.submit(function(e){
            if($password.css('color') === 'rgb(0, 128, 0)') {
                $(this).unbind('submit').submit();
            }
            else {
                e.preventDefault();
            }
         });
         
         $sendemail.submit(function(e){
            if($email.css('color') === 'rgb(0, 128, 0)') {
                $(this).unbind('submit').submit();
            }
            else {
                e.preventDefault();
            }
         });
});