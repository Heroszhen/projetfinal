$(function(){
    $('.show-message').click(function (event) {
        // empeche d'aller vers la page de suppression
        event.preventDefault();

        // ouvre la modal de confirmation
        $('#message-utilisateur').show();
        });
    });







    /*function getMessages(){
        $.get(
            'ajax/message.php',
            function(response){
                $('#message-container').append(response);
            }
        );
    }
    if(hasUser) {

        setInterval(getMessages,2000);
    }
    //getMessages();
}*/

